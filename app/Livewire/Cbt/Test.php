<?php

namespace App\Livewire\Cbt;

use Livewire\Component;
use App\Models\Soal;
use App\Models\TestResult;
use Illuminate\Support\Facades\Auth;

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
    
    public $maxQuestions = 25; // Maximum number of questions
    public $testDuration = 30; // in minutes

    protected $listeners = ['timeUp' => 'completeTest'];

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

    public function mount()
    {
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

        // Get 25 random active questions
        // $this->questions = Soal::where('status', true)
        //     ->inRandomOrder()
        //     ->take($this->maxQuestions)
        //     ->get();
            
        // Initialize answer array based on question count
        // $this->userAnswers = array_fill(0, $this->questions->count(), null);
        
        // $this->timeLeft = $this->testDuration * 60; // Convert to seconds
        // $this->markedQuestions = [];
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

        // !! DIUBAH: Hapus sesi setelah ujian selesai !!
        session()->forget([
            'test_in_progress',
            'test_question_ids',
            'test_user_answers',
            'test_marked_questions',
            'test_current_question',
        ]);
    }

    public function render()
    {
        // Perbarui totalQuestions di view agar dinamis
        return view('livewire.cbt.test', [
            'totalQuestions' => $this->questions->count()
        ]);
    }

     public function selectAnswer($option)
    {
        $this->userAnswers[$this->currentQuestion] = $option;
        // Simpan jawaban ke sesi setiap kali user memilih
        session(['test_user_answers' => $this->userAnswers]);
    }
}
