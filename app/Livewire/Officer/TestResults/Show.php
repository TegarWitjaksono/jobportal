<?php

namespace App\Livewire\Officer\TestResults;

use Livewire\Component;
use App\Models\TestResult;
use App\Models\Soal;
use Dompdf\Dompdf;
use Dompdf\Options;

class Show extends Component
{
    public TestResult $result;
    public $items = [];

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
