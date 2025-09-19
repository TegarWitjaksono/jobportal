<?php

namespace App\Livewire\Officer\TestResults;

use Livewire\Component;
use App\Models\TestResult;
use App\Models\Soal;
use App\Models\ProctorEvent;
use Illuminate\Support\Facades\Storage;
use Dompdf\Dompdf;
use Dompdf\Options;

class Show extends Component
{
    public TestResult $result;
    public $items = [];
    public array $proctorEvents = [];
    public array $proctorAllEvents = [];
    public array $proctorTypes = [];
    public string $proctorType = 'all';
    public bool $proctorOnlyWithEvidence = false;
    public string $proctorSort = 'desc';
    public ?string $proctorFromDate = null; // 'Y-m-d\TH:i' from datetime-local
    public ?string $proctorToDate = null;   // 'Y-m-d\TH:i'
    public array $proctorSummary = [];

    public function mount($id)
    {
        $this->result = TestResult::with('user')->findOrFail($id);

        $answers = $this->result->answers_data ?? [];
        if (!is_array($answers)) {
            $answers = [];
        }

        // Map soal IDs and fetch questions
        $soalIds = collect($answers)->pluck('soal_id')->filter()->values()->all();
        $soalMap = Soal::whereIn('id_soal', $soalIds)->get()->keyBy('id_soal');

        $this->items = collect($answers)->map(function ($row, $idx) use ($soalMap) {
            $soal = $soalMap->get($row['soal_id'] ?? null);
            $typeSoal = $soal?->type_soal ?? 'teks';
            $typeJawaban = $soal?->type_jawaban ?? 'teks';
            $userAnswer = $row['user_answer'] ?? null;
            $correct = (bool)($row['is_correct'] ?? false);
            $correctIndex = $soal?->jawaban;
            return [
                'index' => $idx + 1,
                'soal' => $soal,
                'type_soal' => $typeSoal,
                'type_jawaban' => $typeJawaban,
                'user_answer' => $userAnswer,
                'is_correct' => $correct,
                'correct_index' => $correctIndex,
            ];
        })->values()->all();

        // Load suspicious proctoring events for this test result (face not detected, fullscreen exit)
        $events = ProctorEvent::query()
            ->where('user_id', optional($this->result->user)->id)
            ->where('test_result_id', $this->result->id)
            ->latest()
            ->limit(300)
            ->get();

        $mapped = $events->map(function ($e) {
            $url = null;
            if ($e->evidence_path) {
                try {
                    if (Storage::disk('public')->exists($e->evidence_path)) {
                        $url = asset('storage/' . ltrim($e->evidence_path, '/'));
                    } else {
                        $url = asset('storage/' . ltrim($e->evidence_path, '/'));
                    }
                } catch (\Throwable $th) {
                    $url = asset('storage/' . ltrim($e->evidence_path, '/'));
                }
            }
            return [
                'type' => $e->type,
                'meta' => $e->meta,
                'evidence' => $url,
                'time' => optional($e->created_at)->format('d M Y H:i:s'),
                'ts' => optional($e->created_at)->timestamp ?? 0,
            ];
        })->values()->all();

        $this->proctorAllEvents = $mapped;
        $this->proctorTypes = collect($mapped)->pluck('type')->unique()->values()->all();
        $this->applyProctorFilter();
    }

    public function updatedProctorType(): void { $this->applyProctorFilter(); }
    public function updatedProctorOnlyWithEvidence(): void { $this->applyProctorFilter(); }
    public function updatedProctorSort(): void { $this->applyProctorFilter(); }
    public function updatedProctorFromDate(): void { $this->applyProctorFilter(); }
    public function updatedProctorToDate(): void { $this->applyProctorFilter(); }

    private function applyProctorFilter(): void
    {
        $list = $this->proctorAllEvents;
        // Date range filtering (client timezone)
        $fromTs = null; $toTs = null;
        if ($this->proctorFromDate) {
            $fromTs = strtotime($this->proctorFromDate);
        }
        if ($this->proctorToDate) {
            $toTs = strtotime($this->proctorToDate);
        }

        if ($this->proctorType !== 'all') {
            $list = array_values(array_filter($list, fn($e) => ($e['type'] ?? null) === $this->proctorType));
        }
        if ($this->proctorOnlyWithEvidence) {
            $list = array_values(array_filter($list, fn($e) => !empty($e['evidence'])));
        }
        if ($fromTs) {
            $list = array_values(array_filter($list, fn($e) => (int)($e['ts'] ?? 0) >= $fromTs));
        }
        if ($toTs) {
            $list = array_values(array_filter($list, fn($e) => (int)($e['ts'] ?? 0) <= $toTs));
        }
        usort($list, function($a, $b){
            $av = (int)($a['ts'] ?? 0); $bv = (int)($b['ts'] ?? 0);
            return $this->proctorSort === 'asc' ? $av <=> $bv : $bv <=> $av;
        });
        $this->proctorEvents = $list;

        // Build summary per type for visible list
        $summary = [];
        foreach ($list as $row) {
            $t = $row['type'] ?? 'unknown';
            $summary[$t] = ($summary[$t] ?? 0) + 1;
        }
        ksort($summary);
        $this->proctorSummary = $summary;
    }

    public function exportProctorCsv()
    {
        $rows = $this->proctorEvents;
        $csv = fopen('php://temp', 'r+');
        fputcsv($csv, ['time','type','faces_count','last_url','evidence_url']);
        foreach ($rows as $r) {
            $meta = $r['meta'] ?? [];
            $mm = (is_array($meta) && isset($meta['meta']) && is_array($meta['meta'])) ? $meta['meta'] : (is_array($meta) ? $meta : []);
            $count = $mm['count'] ?? '';
            $lastUrl = $mm['last_url'] ?? '';
            fputcsv($csv, [
                $r['time'] ?? '',
                $r['type'] ?? '',
                is_numeric($count) ? (string)$count : '',
                is_string($lastUrl) ? $lastUrl : '',
                $r['evidence'] ?? '',
            ]);
        }
        rewind($csv);
        $content = stream_get_contents($csv);
        fclose($csv);
        $filename = 'proctor-events-' . (optional($this->result->user)->name ?? 'kandidat') . '-' . now()->format('Ymd_His') . '.csv';
        return response()->streamDownload(function() use ($content) { echo $content; }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    public function render()
    {
        return view('livewire.officer.test-results.show');
    }

    public function exportReviewPdf()
    {
        $html = view('livewire.officer.test-results.pdf-review', [
            'result' => $this->result,
            'items' => $this->items,
        ])->render();

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $fileName = 'review-psikotes-' . (optional($this->result->user)->name ?? 'kandidat') . '-' . now()->format('Ymd_His') . '.pdf';

        return response()->streamDownload(function () use ($dompdf) {
            echo $dompdf->output();
        }, $fileName);
    }
}
