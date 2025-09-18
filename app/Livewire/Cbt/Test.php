<?php

namespace App\Livewire\Cbt;

use Livewire\Component;
use App\Models\Soal;
use App\Models\TestResult;
use App\Models\CbtSetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class Test extends Component
{
    public $currentQuestion = 0;
    public $questions;
    public $userAnswers = [];
    public $markedQuestions = [];
    public $testStarted = false;
    public $testCompleted = false;
    public $timeLeft;
    public $testResult;
    public $showConfirmModal = false;

    public bool $scheduleValid = false;
    public ?array $scheduleInfo = null;
    
    public $maxQuestions = 25; // Maximum number of questions
    public $testDuration = 30; // in minutes

    protected $listeners = ['timeUp' => 'completeTest', 'proctorEvent' => 'handleProctorEvent'];

    protected function refreshCbtSettings(): void
    {
        try {
            if (Schema::hasTable('cbt_settings')) {
                if ($s = CbtSetting::query()->first()) {
                    $this->maxQuestions = (int) ($s->max_questions ?? $this->maxQuestions);
                    $this->testDuration = (int) ($s->test_duration ?? $this->testDuration);
                }
            }
        } catch (\Throwable $e) {
            // ignore if table not migrated yet
        }
    }

    public function restoreState()
    {
        // Pulihkan soal berdasarkan ID yang tersimpan
        $questionIds = session('test_question_ids', []);
        if (empty($questionIds)) {
            $this->initializeNewTest(); // Fallback jika ID soal tidak ada di sesi
            return;
        }
        $idOrder = implode(',', $questionIds);

        $this->questions = Soal::whereIn('id_soal', $questionIds)
                                ->orderByRaw("FIELD(id_soal, $idOrder)")
                                ->get();

        // Pulihkan progres dari sesi
        $this->userAnswers = session('test_user_answers', array_fill(0, $this->questions->count(), null));
        $this->markedQuestions = session('test_marked_questions', []);
        $this->currentQuestion = session('test_current_question', 0);

        // Hitung ulang waktu tersisa
        $elapsedTime = now()->diffInSeconds($this->testResult->started_at);
        $this->timeLeft = (int) max(0, ($this->testDuration * 60) - $elapsedTime);

        $this->testStarted = true;
        $this->testCompleted = false;
    }

    public function initializeNewTest()
    {
        $this->questions = Soal::where('status', true)
            ->inRandomOrder()
            ->take($this->maxQuestions)
            ->get();
        
        $this->userAnswers = array_fill(0, $this->questions->count(), null);
        $this->markedQuestions = [];
        $this->currentQuestion = 0;
        $this->timeLeft = (int) ($this->testDuration * 60);
        $this->testStarted = false;
        $this->testCompleted = false;
    }

    public function validateSchedule()
    {
        // Jika tes sedang berlangsung, izinkan masuk kembali. Timer di dalam tes akan menangani batas waktu.
        if ($this->testStarted && !$this->testCompleted) {
            $this->scheduleValid = true;
            return;
        }

        // Cari lamaran yang relevan untuk psikotes
        $lamaran = \App\Models\LamarLowongan::where('kandidat_id', auth()->user()->kandidat->id)
            ->whereHas('progressRekrutmen', fn($q) => $q->where('status', 'psikotes'))
            ->whereDoesntHave('progressRekrutmen', fn($q) => $q->whereIn('status', ['diterima', 'ditolak']))
            ->latest()
            ->first();

        if (!$lamaran) {
            $this->scheduleValid = false;
            return;
        }

        $psikotesProgress = $lamaran->progressRekrutmen
            ->where('status', 'psikotes')
            ->sortByDesc('created_at')
            ->first();

        $waktuMulai = optional($psikotesProgress)->waktu_pelaksanaan ? \Carbon\Carbon::parse($psikotesProgress->waktu_pelaksanaan) : null;
        $waktuSelesai = optional($psikotesProgress)->waktu_selesai ? \Carbon\Carbon::parse($psikotesProgress->waktu_selesai) : null;

        if (!$waktuMulai || !$waktuSelesai) {
            $this->scheduleValid = false;
            return;
        }

        // Siapkan info jadwal untuk ditampilkan di pesan "Akses Ditolak"
        $this->scheduleInfo = [
            'start' => $waktuMulai->translatedFormat('d F Y, H:i'),
            'end' => $waktuSelesai->translatedFormat('d F Y, H:i'),
        ];

        // Jadwal valid jika waktu saat ini berada di antara waktu mulai dan selesai
        $this->scheduleValid = now()->between($waktuMulai, $waktuSelesai);
    }

    public function mount()
    {
        // Load CBT settings if available
        $this->validateSchedule();
        $this->refreshCbtSettings();

        $user = Auth::user();
        $kandidat = $user->kandidat;

        $hasPsikotes = false;
        if ($kandidat) {
            $hasPsikotes = $kandidat->lamarLowongans()
                ->whereHas('progressRekrutmen', function ($q) {
                    $q->where('status', 'psikotes')
                        ->where('is_psikotes', true);
                })
                ->exists();
        }

        if (!$hasPsikotes) {
            abort(403, 'Anda belum memiliki akses ke tes ini.');
        }

        // Cek apakah user sudah menyelesaikan tes sebelumnya
        $completed = TestResult::where('user_id', Auth::id())
            ->whereNotNull('completed_at')
            ->latest('completed_at')
            ->first();

        if ($completed) {
            // Tampilkan hasil selesai, jangan tampilkan tombol mulai lagi
            $this->testResult = $completed;
            $this->testStarted = false;
            $this->testCompleted = true;
            return;
        }

        $ongoingTestId = session('test_in_progress');

        if ($ongoingTestId && $testResult = TestResult::where('id', $ongoingTestId)->where('user_id', Auth::id())->whereNull('completed_at')->first()) {
            // Jika ada tes yang sedang berjalan, pulihkan state
            $this->testResult = $testResult;
            $this->restoreState();
        } else {
            // Jika tidak, siapkan tes baru
            $this->initializeNewTest();
            session()->forget('test_in_progress'); // Bersihkan sesi lama jika ada
        }
    }

    // Used by wire:poll to keep settings in sync and avoid Livewire errors
    public function ping(): void
    {
        // keep CBT settings synced while waiting to start
        $oldMax = (int) $this->maxQuestions;
        $oldDur = (int) $this->testDuration;
        $this->refreshCbtSettings();

        // If not started or completed, and settings changed, reprepare questions
        if (!$this->testStarted && !$this->testCompleted) {
            if (($this->questions?->count() ?? 0) !== (int) $this->maxQuestions || $oldDur !== (int) $this->testDuration) {
                $this->initializeNewTest();
            }
        }
    }

    public function startTest()
    {
        // Guard: cegah klik ganda / mulai lebih dari sekali
        if ($this->testStarted) return;

        // Jika ada tes berjalan, pulihkan saja
        if ($existing = TestResult::where('user_id', Auth::id())->whereNull('completed_at')->first()) {
            $this->testResult = $existing;
            $this->restoreState();
            return;
        }
        // Jika sudah pernah selesai, jangan mulai lagi
        if (TestResult::where('user_id', Auth::id())->whereNotNull('completed_at')->exists()) {
            $this->testCompleted = true;
            return;
        }

        $this->testStarted = true;
        $this->testResult = TestResult::create([
            'user_id' => Auth::id(),
            'total_questions' => $this->questions->count(),
            'started_at' => now(),
        ]);

        session([
            'test_in_progress' => $this->testResult->id,
            'test_question_ids' => $this->questions->pluck('id_soal')->toArray(),
            'test_user_answers' => $this->userAnswers,
            'test_marked_questions' => $this->markedQuestions,
            'test_current_question' => $this->currentQuestion,
        ]);
    }

    public function nextQuestion()
    {
        if ($this->currentQuestion < $this->questions->count() - 1) {
            $this->currentQuestion++;
            session(['test_current_question' => $this->currentQuestion]);
        }
    }

    public function previousQuestion()
    {
        if ($this->currentQuestion > 0) {
            $this->currentQuestion--;
            session(['test_current_question' => $this->currentQuestion]);
        }
    }

    public function goToQuestion($index)
    {
        if ($index >= 0 && $index < $this->questions->count()) {
            $this->currentQuestion = $index;
            session(['test_current_question' => $this->currentQuestion]);
        }
    }

    public function toggleMarkQuestion()
    {
        if (in_array($this->currentQuestion, $this->markedQuestions)) {
            $this->markedQuestions = array_diff($this->markedQuestions, [$this->currentQuestion]);
        } else {
            $this->markedQuestions[] = $this->currentQuestion;
        }
        session(['test_marked_questions' => $this->markedQuestions]);
    }

    public function isQuestionAnswered($index)
    {
        return isset($this->userAnswers[$index]) && $this->userAnswers[$index] !== null;
    }

    public function isQuestionMarked($index)
    {
        return in_array($index, $this->markedQuestions);
    }

    public function getAnsweredCount()
    {
        return count(array_filter($this->userAnswers, function($answer) {
            return $answer !== null;
        }));
    }

    public function getUnansweredCount()
    {
        return $this->questions->count() - $this->getAnsweredCount();
    }

    public function getMarkedCount()
    {
        return count($this->markedQuestions);
    }

    public function showConfirmation()
    {
        $this->showConfirmModal = true;
    }

    public function hideConfirmation()
    {
        $this->showConfirmModal = false;
    }

    public function completeTest()
    {
        if (!$this->testResult) return;

        $correctAnswers = 0;
        $answersData = [];
        foreach ($this->questions as $index => $question) {
            $userAnswer = $this->userAnswers[$index] ?? null;
            $isCorrect = $userAnswer == $question->jawaban;

            if ($isCorrect) {
                $correctAnswers++;
            }

            $answersData[] = [
                'soal_id' => $question->id_soal,
                'user_answer' => $userAnswer,
                'is_correct' => $isCorrect,
            ];
        }

        $score = ($this->questions->count() > 0)
            ? ($correctAnswers / $this->questions->count()) * 100
            : 0;

        $this->testResult->update([
            'correct_answers' => $correctAnswers,
            'score' => $score,
            'completed_at' => now(),
            'answers_data' => $answersData,
        ]);
        
        $this->testResult->load('user'); // Eager load relasi user
        $this->testCompleted = true;
        $this->showConfirmModal = false;

        // Hapus sesi setelah ujian selesai
        session()->forget([
            'test_in_progress',
            'test_question_ids',
            'test_user_answers',
            'test_marked_questions',
            'test_current_question',
        ]);
    }

    public function selectAnswer($option)
    {
        $this->userAnswers[$this->currentQuestion] = $option;
        // Simpan jawaban ke sesi setiap kali user memilih
        session(['test_user_answers' => $this->userAnswers]);
    }

    public function handleProctorEvent($eventData)
    {
        try {
            $evidencePath = null;
            
            // Handle image evidence if provided
            if (isset($eventData['image_data'])) {
                $imageData = $eventData['image_data'];
                $evidencePath = 'proctor/evidence/'.auth()->id().'_'.time().'_'.uniqid().'.png';
                \Illuminate\Support\Facades\Storage::disk('public')->put($evidencePath, base64_decode($imageData));
                unset($eventData['image_data']);
            }

            \App\Models\ProctorEvent::create([
                'user_id' => auth()->id(),
                'test_result_id' => optional($this->testResult)->id,
                'type' => $eventData['type'] ?? 'unknown',
                'meta' => $eventData ? (array) $eventData : null,
                'evidence_path' => $evidencePath,
            ]);

            // Jika pelanggaran adalah face_count (deteksi kamera), hitung dan akhiri saat >= 3
            try {
                $type = $eventData['type'] ?? null;
                if ($type === 'face_count' && $this->testResult && is_null($this->testResult->completed_at)) {
                    $count = \App\Models\ProctorEvent::query()
                        ->where('user_id', auth()->id())
                        ->where('test_result_id', $this->testResult->id)
                        ->where('type', 'face_count')
                        ->count();
                    if ($count >= 3) {
                        $this->completeTest();
                    }
                }
            } catch (\Throwable $e) {
                // ignore counting error
            }
        } catch (\Throwable $e) {
            // Log error silently or handle as needed
            \Illuminate\Support\Facades\Log::error('Proctor event handling failed: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.cbt.test', [
            'totalQuestions' => $this->questions->count()
        ]);
    }
}
