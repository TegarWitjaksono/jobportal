<div class="min-vh-100 bg-white">
    <section class="section">
    @if(!($scheduleValid ?? false) && !$testCompleted)
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card shadow-lg border-0 rounded-3 text-center">
                        <div class="card-header bg-danger bg-gradient text-white py-4 border-0 rounded-top-3">
                            <h2 class="mb-1"><i class="mdi mdi-calendar-remove me-2"></i>Akses Ditolak</h2>
                        </div>
                        <div class="card-body p-5">
                            <p class="fs-5">Anda tidak dapat mengakses halaman ini di luar jadwal yang telah ditentukan.</p>
                            @if($scheduleInfo)
                                <div class="alert alert-warning">
                                    Jadwal tes Anda adalah: <br>
                                    <strong>{{ $scheduleInfo['start'] }}</strong> sampai <strong>{{ $scheduleInfo['end'] }}</strong>.
                                </div>
                            @endif
                            <a href="{{ route('cbt.dashboard') }}" class="btn btn-primary mt-3">
                                <i class="mdi mdi-arrow-left me-1"></i> Kembali ke Dashboard Psikotes
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @elseif(!$testStarted && !$testCompleted)
        <div wire:poll.10s="ping"></div>
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card shadow-lg border-0 rounded-3">
                        <div class="card-header bg-primary bg-gradient text-white text-center py-4 border-0 rounded-top-3">
                            <h2 class="mb-1"><i class="mdi mdi-brain me-2"></i>Psikotes</h2>
                            <small class="text-white-50">Silakan baca petunjuk sebelum memulai tes</small>
                        </div>
                        <div class="card-body p-5">
                            <div class="alert alert-info cbt-instructions shadow-sm mb-4">
                                <div class="d-flex align-items-center mb-3">
                                    <i class="mdi mdi-information-outline fs-4 me-3 text-info"></i>
                                    <h5 class="mb-0">Petunjuk Pengerjaan</h5>
                                </div>
                                <ul class="list-unstyled mb-0">
                                    <li class="d-flex align-items-start mb-2">
                                        <i class="mdi mdi-check-circle-outline text-primary me-2 mt-1 flex-shrink-0"></i>
                                        <span>Anda akan mengerjakan <strong>{{ min($totalQuestions, $maxQuestions) }} soal</strong></span>
                                    </li>
                                    <li class="d-flex align-items-start mb-2">
                                        <i class="mdi mdi-check-circle-outline text-primary me-2 mt-1 flex-shrink-0"></i>
                                        <span>Waktu pengerjaan: <strong>{{ $testDuration }} menit</strong></span>
                                    </li>
                                    <li class="d-flex align-items-start mb-2">
                                        <i class="mdi mdi-check-circle-outline text-primary me-2 mt-1 flex-shrink-0"></i>
                                        <span>Soal ditampilkan secara acak</span>
                                    </li>
                                    <li class="d-flex align-items-start mb-2">
                                        <i class="mdi mdi-check-circle-outline text-primary me-2 mt-1 flex-shrink-0"></i>
                                        <span>Pastikan koneksi internet Anda stabil selama tes berlangsung</span>
                                    </li>
                                    <li class="d-flex align-items-start mb-2">
                                        <i class="mdi mdi-check-circle-outline text-primary me-2 mt-1 flex-shrink-0"></i>
                                        <span>Jangan merefresh atau menutup halaman browser</span>
                                    </li>
                                    <li class="d-flex align-items-start mb-2">
                                        <i class="mdi mdi-check-circle-outline text-primary me-2 mt-1 flex-shrink-0"></i>
                                        <span>Gunakan tombol navigasi untuk berpindah antar soal</span>
                                    </li>
                                    <li class="d-flex align-items-start mb-2">
                                        <i class="mdi mdi-check-circle-outline text-primary me-2 mt-1 flex-shrink-0"></i>
                                        <span>Anda dapat menandai soal untuk ditinjau kembali</span>
                                    </li>
                                    <li class="d-flex align-items-start mb-2">
                                        <i class="mdi mdi-check-circle-outline text-primary me-2 mt-1 flex-shrink-0"></i>
                                        <span>Pastikan kamera Anda aktif selama tes berlangsung (jika diminta)</span>
                                    </li>
                                    <li class="d-flex align-items-start mb-0">
                                        <i class="mdi mdi-check-circle-outline text-primary me-2 mt-1 flex-shrink-0"></i>
                                        <span>Gunakan mode layar penuh selama ujian. <strong>Jangan keluar dari fullscreen (ESC)</strong> karena tindakan ini akan langsung mengakhiri ujian.</span>
                                    </li>
                                </ul>
                            </div>
                            
                            <div class="row g-3 mb-4">
                                <div class="col-6 col-md-3">
                                    <div class="metric-box d-flex align-items-center p-3 rounded-3 bg-white border shadow-sm">
                                        <div class="metric-icon bg-soft-primary text-primary me-3">
                                            <i class="mdi mdi-clock-outline"></i>
                                        </div>
                                        <div class="min-w-0">
                                            <div class="text-muted small">Waktu</div>
                                            <div class="fw-semibold">{{ $testDuration }} Menit</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="metric-box d-flex align-items-center p-3 rounded-3 bg-white border shadow-sm">
                                        <div class="metric-icon bg-soft-success text-success me-3">
                                            <i class="mdi mdi-help-circle-outline"></i>
                                        </div>
                                        <div class="min-w-0">
                                            <div class="text-muted small">Jumlah Soal</div>
                                            <div class="fw-semibold">{{ min($totalQuestions, $maxQuestions) }} Soal</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="metric-box d-flex align-items-center p-3 rounded-3 bg-white border shadow-sm">
                                        <div class="metric-icon bg-soft-info text-info me-3">
                                            <i class="mdi mdi-shuffle-variant"></i>
                                        </div>
                                        <div class="min-w-0">
                                            <div class="text-muted small">Soal Acak</div>
                                            <div class="fw-semibold">Ya</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="metric-box d-flex align-items-center p-3 rounded-3 bg-white border shadow-sm">
                                        <div class="metric-icon bg-soft-warning text-warning me-3">
                                            <i class="mdi mdi-trophy-outline"></i>
                                        </div>
                                        <div class="min-w-0">
                                            <div class="text-muted small">Passing Grade</div>
                                            <div class="fw-semibold">{{ $passingGrade }}%</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="text-center" x-data="{
                                async start(){
                                    try {
                                        if (document.documentElement.requestFullscreen) {
                                            try { await document.documentElement.requestFullscreen(); } catch(e) {}
                                        }
                                        if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                                            try {
                                                const s = await navigator.mediaDevices.getUserMedia({ video: { width: 640, height: 480 }, audio: false });
                                                // Simpan stream agar bisa langsung dipakai saat tampilan soal dirender
                                                window.__proctorStream = s;
                                            } catch(e) { /* ignore */ }
                                        }
                                    } finally {
                                        $wire.startTest();
                                    }
                                }
                            }">
                                <button
                                    type="button"
                                    @click.prevent="start()"
                                    wire:loading.attr="disabled"
                                    wire:target="startTest"
                                    class="btn btn-cta-primary btn-lg px-5 py-3 rounded-pill shadow-sm d-inline-flex align-items-center justify-content-center w-100 w-md-auto">
                                    <span wire:loading.remove wire:target="startTest">
                                        <i class="mdi mdi-play-circle-outline me-2"></i>
                                        Mulai Tes Sekarang
                                    </span>
                                    <span wire:loading wire:target="startTest">
                                        <i class="mdi mdi-loading mdi-spin me-2"></i>
                                        Menyiapkan tes...
                                    </span>
                                </button>
                                <div class="small text-muted mt-2" wire:loading wire:target="startTest">Jangan tutup atau refresh halaman</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @elseif($testCompleted)
        <div class="container py-5">
            <div x-data x-init="try { window.Proctor && window.Proctor.disable(); window.__PROCTOR_DISABLED = true; } catch(e){}; window.stopProctorCamera && window.stopProctorCamera()"></div>
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="card shadow-lg border-0 rounded-3">
                        <div class="card-header bg-soft-success text-success text-center py-4 border-0 rounded-top-3">
                            <h3 class="mb-0 d-inline-flex align-items-center"><i class="mdi mdi-check-circle me-2"></i>Tes Selesai</h3>
                            <p class="mb-0 mt-2 fs-6 text-success opacity-75"><strong>{{ $testResult->user->name }}</strong></p>
                        </div>
                        <div class="card-body p-5">
                            <div class="row g-3 g-md-4 mb-5">
                                <div class="col-6 col-md-3">
                                    <div class="text-center p-4 bg-soft-primary text-primary rounded-3 border">
                                        <i class="mdi mdi-percent-outline fs-1 mb-2"></i>
                                        <div class="h4 mb-0">{{ number_format($testResult->score, 1) }}%</div>
                                        <small class="opacity-75">Skor Anda</small>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="text-center p-4 bg-soft-success text-success rounded-3 border">
                                        <i class="mdi mdi-check fs-1 mb-2"></i>
                                        <div class="h4 mb-0">{{ $testResult->correct_answers }}</div>
                                        <small class="opacity-75">Jawaban Benar</small>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="text-center p-4 bg-soft-danger text-danger rounded-3 border">
                                        <i class="mdi mdi-close fs-1 mb-2"></i>
                                        <div class="h4 mb-0">{{ max(0, (int) $testResult->total_questions - (int) $testResult->correct_answers) }}</div>
                                        <small class="opacity-75">Jawaban Salah</small>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="text-center p-4 bg-soft-info text-info rounded-3 border">
                                        <i class="mdi mdi-shuffle-variant fs-1 mb-2"></i>
                                        <div class="h4 mb-0">{{ $testResult?->total_questions ?? min($totalQuestions, $maxQuestions) }}</div>
                                        <small class="opacity-75">Total Soal</small>
                                    </div>
                                </div>
                            </div>

                            <div class="text-center mb-4">
                                @php $pg = (int) ($passingGrade ?? 70); @endphp
                                @if($testResult->score >= $pg)
                                    <span class="badge bg-soft-success text-success fs-6 px-4 py-2 rounded-pill">
                                        <i class="mdi mdi-trophy-outline me-2"></i>LULUS
                                    </span>
                                @else
                                    <span class="badge bg-soft-danger text-danger fs-6 px-4 py-2 rounded-pill">
                                        <i class="mdi mdi-alert-outline me-2"></i>TIDAK LULUS
                                    </span>
                                @endif
                            </div>

                            <div class="mt-5" x-data="{ reviewMode: 'accordion' }">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="mb-0"><i class="mdi mdi-clipboard-list-outline me-2"></i>Review Jawaban</h5>
                                    <div class="btn-group btn-group-sm" role="group" aria-label="Pilih tampilan">
                                        <button type="button" class="btn" :class="reviewMode==='accordion' ? 'btn-soft-primary' : 'btn-outline-secondary'" @click="reviewMode='accordion'">
                                            <i class="mdi mdi-view-agenda-outline me-1"></i> Accordion
                                        </button>
                                        <button type="button" class="btn" :class="reviewMode==='table' ? 'btn-soft-primary' : 'btn-outline-secondary'" @click="reviewMode='table'">
                                            <i class="mdi mdi-table me-1"></i> Tabel
                                        </button>
                                    </div>
                                </div>

                                <!-- Mode: Accordion (default) -->
                                <div class="accordion" id="answerAccordion" x-show="reviewMode==='accordion'" x-cloak>
                                    @foreach($questions as $index => $question)
                                        @php
                                            $isCorrect = isset($userAnswers[$index]) && $userAnswers[$index] == $question->jawaban;
                                            $userAnswer = $userAnswers[$index] ?? null;
                                        @endphp
                                        <div class="accordion-item border-0 shadow-sm mb-3">
                                            <h2 class="accordion-header">
                                                <button class="accordion-button collapsed d-flex align-items-center {{ $isCorrect ? 'bg-success-subtle' : 'bg-danger-subtle' }}" 
                                                        type="button" 
                                                        data-bs-toggle="collapse" 
                                                        data-bs-target="#question{{ $index + 1 }}"
                                                        aria-expanded="false">
                                                    <div class="d-flex align-items-center w-100">
                                                        <span class="badge {{ $isCorrect ? 'bg-soft-success text-success' : 'bg-soft-danger text-danger' }} me-3">
                                                            <i class="mdi {{ $isCorrect ? 'mdi-check' : 'mdi-close' }}"></i>
                                                        </span>
                                                        <span class="fw-bold">Soal {{ $index + 1 }}</span>
                                                        <span class="ms-auto badge {{ $isCorrect ? 'bg-soft-success text-success' : 'bg-soft-danger text-danger' }}">
                                                            {{ $isCorrect ? 'Benar' : 'Salah' }}
                                                        </span>
                                                    </div>
                                                </button>
                                            </h2>
                                            <div id="question{{ $index + 1 }}" 
                                                 class="accordion-collapse collapse" 
                                                 data-bs-parent="#answerAccordion">
                                                <div class="accordion-body">
                                                    <div class="mb-4">
                                                        <h6 class="text-muted mb-2">Pertanyaan:</h6>
                                                        @if($question->type_soal == 'foto')
                                                            <img src="{{ Storage::url($question->soal) }}" 
                                                                 class="img-fluid rounded shadow-sm question-image" 
                                                                 alt="Question Image"
                                                                 style="max-height: 200px">
                                                        @else
                                                            <p class="fs-6">{{ $question->soal }}</p>
                                                        @endif
                                                    </div>

                                                    <div class="mb-3">
                                                        <h6 class="text-muted mb-2">Jawaban Anda:</h6>
                                                        @if($userAnswer)
                                                            @if($question->type_jawaban == 'foto')
                                                                <img src="{{ Storage::url($question->{'pilihan_' . $userAnswer}) }}" 
                                                                     class="img-fluid rounded shadow-sm answer-image mb-2" 
                                                                     alt="Your Answer"
                                                                     style="max-height: 100px">
                                                            @else
                                                                <div class="p-3 rounded {{ $isCorrect ? 'bg-success-subtle border-success' : 'bg-danger-subtle border-danger' }} border">
                                                                    {{ $question->{'pilihan_' . $userAnswer} }}
                                                                </div>
                                                            @endif
                                                        @else
                                                            <div class="p-3 rounded bg-warning-subtle border-warning border">
                                                                 <i class="mdi mdi-alert-outline me-2"></i>Tidak dijawab
                                                            </div>
                                                        @endif
                                                    </div>

                                                    @if(!$isCorrect)
                                                        <div class="mb-3">
                                                            <h6 class="text-muted mb-2">Jawaban Benar:</h6>
                                                            @if($question->type_jawaban === 'foto')
                                                                <img src="{{ Storage::url($question->{'pilihan_' . $question->jawaban}) }}" 
                                                                     class="img-fluid rounded shadow-sm" 
                                                                     style="max-height: 100px">
                                                            @else
                                                                <div class="p-3 rounded bg-success-subtle border-success border">
                                                                    {{ $question->{'pilihan_' . $question->jawaban} }}
                                                                </div>
                                                            @endif
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Mode: Table (compact) -->
                                <div x-show="reviewMode==='table'" x-cloak>
                                    <div class="table-responsive shadow-sm rounded border">
                                        <table class="table align-middle mb-0">
                                            <thead class="bg-light">
                                                <tr>
                                                    <th style="width: 60px;" class="text-center">#</th>
                                                    <th style="width: 120px;">Status</th>
                                                    <th>Pertanyaan</th>
                                                    <th>Jawaban Anda</th>
                                                    <th style="width: 160px;">Jawaban Benar</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($questions as $index => $question)
                                                @php
                                                    $isCorrect = isset($userAnswers[$index]) && $userAnswers[$index] == $question->jawaban;
                                                    $userAnswer = $userAnswers[$index] ?? null;
                                                @endphp
                                                <tr>
                                                    <td class="text-center fw-semibold">{{ $index + 1 }}</td>
                                                    <td>
                                                        <span class="badge {{ $isCorrect ? 'bg-soft-success text-success' : 'bg-soft-danger text-danger' }}">
                                                            {{ $isCorrect ? 'Benar' : 'Salah' }}
                                                        </span>
                                                    </td>
                                                    <td class="text-muted">
                                                        @if($question->type_soal == 'foto')
                                                            <img src="{{ Storage::url($question->soal) }}" alt="Soal" class="rounded border" style="max-height: 48px;">
                                                        @else
                                                            <span class="d-inline-block" style="max-width: 420px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $question->soal }}</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($userAnswer)
                                                            @if($question->type_jawaban == 'foto')
                                                                <img src="{{ Storage::url($question->{'pilihan_' . $userAnswer}) }}" alt="Jawaban Anda" class="rounded border" style="max-height: 48px;">
                                                            @else
                                                                <span class="d-inline-block {{ $isCorrect ? 'text-success' : 'text-danger' }}" style="max-width: 360px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                                    {{ $question->{'pilihan_' . $userAnswer} }}
                                                                </span>
                                                            @endif
                                                        @else
                                                            <span class="badge bg-soft-warning text-warning"><i class="mdi mdi-alert-outline me-1"></i> Tidak dijawab</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($question->type_jawaban === 'foto')
                                                            <img src="{{ Storage::url($question->{'pilihan_' . $question->jawaban}) }}" alt="Jawaban Benar" class="rounded border" style="max-height: 48px;">
                                                        @else
                                                            <span class="d-inline-block text-success" style="max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                                {{ $question->{'pilihan_' . $question->jawaban} }}
                                                            </span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="text-center mt-5">
                                <a href="{{ route('dashboard') }}" class="btn btn-cta-primary btn-lg px-5 py-3 rounded-pill">
                                    <i class="mdi mdi-home-outline me-2"></i>Kembali ke Dashboard
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @else
        <div class="container-fluid py-3 proctor-protect" id="cbt-area">
            <!-- Proctor: active only during test -->
            <div id="proctor-active" class="d-none" x-data x-init="window.__initProctor && window.__initProctor()"></div>
            <div id="proctor-warning" class="proctor-warning" style="display:none;">
                <i class="mdi mdi-alert-outline me-2"></i>
                <span id="proctor-warning-text">Peringatan: Perilaku mencurigakan terdeteksi.</span>
            </div>
            <div id="proctor-camera" class="proctor-camera shadow border rounded-3 bg-white">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <small class="fw-semibold text-muted">Kamera Ujian</small>
                    <div class="d-flex align-items-center gap-2">
                        <small id="proctor-status" class="text-muted">Memuat kamera…</small>
                        <span id="proctor-detect-count" class="badge bg-soft-danger text-danger" title="Deteksi kamera">
                            0/3
                        </span>
                    </div>
                </div>
                <div class="ratio ratio-4x3 bg-light rounded overflow-hidden">
                    <video id="proctorVideo" autoplay playsinline muted></video>
                </div>
            </div>
            <div class="row g-3">
                <div class="col-lg-3">
                    <div class="sticky-top" style="top: 1rem;">
                        <div class="card shadow-sm mb-3 border-0">
                            <div class="card-header bg-gradient text-white text-center py-3" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                <h5 class="mb-2" style="text-transform: uppercase; color: #3c4858;"><i class="mdi mdi-clock-outline me-2"></i>Waktu Tersisa</h5>
                                <div x-data="timer({{ $testResult?->started_at?->timestamp ?? 'null' }}, {{ (int) $testDuration }}, {{ (int) ($timeLeft ?? 0) }})" x-init="startTimer()">
                                    {{-- The text-dark class is removed from here --}}
                                    <div class="timer-display bg-white rounded-3 p-3 shadow-sm">
                                        {{-- The :class directive is added here to dynamically change color --}}
                                        <span x-text="formatTime()" 
                                              class="fs-3 fw-bold font-monospace"
                                              :class="{'text-danger': timeLeft < 300, 'text-dark': timeLeft >= 300}"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card shadow-sm mb-3 border-0">
                            <div class="card-header bg-soft-info text-info py-3 border-0 rounded-top-3 d-flex align-items-center justify-content-between">
                                <h6 class="mb-0 d-flex align-items-center">
                                    <i class="mdi mdi-chart-pie me-2"></i>
                                    Progress
                                </h6>
                                <small class="opacity-75 text-info">{{ $this->getAnsweredCount() }}/{{ $totalQuestions }}</small>
                            </div>
                            <div class="card-body">
                                <div class="row g-2 text-center">
                                    <div class="col-4">
                                        <div class="py-2 px-3 bg-soft-success text-success rounded-3 d-flex flex-column align-items-center">
                                            <div class="fw-semibold">{{ $this->getAnsweredCount() }}</div>
                                            <small class="opacity-75 stat-label">Dijawab</small>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="py-2 px-3 bg-soft-warning text-warning rounded-3 d-flex flex-column align-items-center">
                                            <div class="fw-semibold">{{ $this->getMarkedCount() }}</div>
                                            <small class="opacity-75 stat-label">Ditandai</small>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="py-2 px-3 bg-soft-danger text-danger rounded-3 d-flex flex-column align-items-center">
                                            <div class="fw-semibold">{{ $this->getUnansweredCount() }}</div>
                                            <small class="opacity-75 stat-label">Kosong</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="progress mt-3 bg-light rounded-pill" style="height: 8px;">
                                    <div class="progress-bar bg-success rounded-pill" 
                                         style="width: {{ ($this->getAnsweredCount() / count($questions)) * 100 }}%"></div>
                                </div>
                            </div>
                        </div>

                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-soft-primary text-primary py-3 border-0 rounded-top-3">
                                <h6 class="mb-0"><i class="mdi mdi-format-list-bulleted-square me-2"></i>Navigasi Soal</h6>
                            </div>
                            <div class="card-body">
                                <div class="question-grid mb-3">
                                    @foreach($questions as $index => $question)
                                        <button wire:click="goToQuestion({{ $index }})"
                                                class="btn btn-sm rounded-pill question-btn {{ $currentQuestion === $index ? 'btn-soft-primary' : 
                                                    ($this->isQuestionMarked($index) ? 'btn-soft-warning' : 
                                                    ($this->isQuestionAnswered($index) ? 'btn-soft-success' : 'btn-outline-secondary')) }}"
                                                title="Soal {{ $index + 1 }}{{ $this->isQuestionAnswered($index) ? ' (Dijawab)' : '' }}{{ $this->isQuestionMarked($index) ? ' (Ditandai)' : '' }}">
                                            {{ $index + 1 }}
                                        </button>
                                    @endforeach
                                </div>
                                
                                <div class="d-grid gap-2">
                                    <button class="btn {{ $this->isQuestionMarked($currentQuestion) ? 'btn-warning' : 'btn-outline-warning' }}" 
                                            wire:click="toggleMarkQuestion">
                                        @if($this->isQuestionMarked($currentQuestion))
                                            <i class="mdi mdi-bookmark me-1"></i>Hapus Tanda
                                        @else
                                            <i class="mdi mdi-bookmark-outline me-1"></i>Tandai Soal
                                        @endif
                                    </button>
                                    
                                    @if($currentQuestion === count($questions) - 1)
                                <button class="btn btn-success" wire:click="showConfirmation" onclick="window.Proctor && window.Proctor.disable();">
                                    <i class="mdi mdi-check me-1"></i>Selesai
                                </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-9">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-header bg-soft-primary text-primary py-3 border-0 rounded-top-3 d-flex justify-content-between align-items-center">
                            <h6 class="mb-0 d-flex align-items-center">
                                <i class="mdi mdi-help-circle-outline me-2"></i>
                                Soal {{ $currentQuestion + 1 }} / {{ count($questions) }}
                            </h6>
                            @php $answered = $this->isQuestionAnswered($currentQuestion); @endphp
                            <span class="badge {{ $answered ? 'bg-soft-success text-success' : 'bg-soft-warning text-warning' }}">
                                {{ $answered ? 'Dijawab' : 'Belum Dijawab' }}
                            </span>
                        </div>
                        
                        <div class="card-body p-4">
                            <div class="question-container mb-4">
                                @if($questions[$currentQuestion]->type_soal == 'foto')
                                    <div class="text-center mb-4">
                                        <img src="{{ Storage::url($questions[$currentQuestion]->soal) }}" 
                                             class="img-fluid rounded shadow-sm question-image" 
                                             alt="Question Image"
                                             style="max-height: 400px">
                                    </div>
                                @else
                                    <div class="question-text p-4 bg-light rounded-3 border-start border-primary border-4">
                                        <p class="fs-5 mb-0 lh-base">{{ $questions[$currentQuestion]->soal }}</p>
                                    </div>
                                @endif
                            </div>

                            <div class="answers">
                                @foreach(['pilihan_1', 'pilihan_2', 'pilihan_3', 'pilihan_4'] as $index => $pilihan)
                                    @php
                                        $optionValue = $index + 1;
                                    @endphp
                                    <div class="answer-option mb-3 {{ ($userAnswers[$currentQuestion] ?? null) == $optionValue ? 'selected' : '' }}"
                                         wire:click="selectAnswer({{ $optionValue }})">
                                        
                                        <input type="radio" 
                                            id="q{{ $currentQuestion }}_opt{{ $optionValue }}"
                                            name="answer_for_q_{{ $currentQuestion }}" 
                                            value="{{ $optionValue }}"
                                            wire:model.live="userAnswers.{{ $currentQuestion }}"
                                            class="form-check-input d-none">

                                        <label class="answer-label w-100 p-3 rounded-3 border cursor-pointer d-flex align-items-center" 
                                            for="q{{ $currentQuestion }}_opt{{ $optionValue }}">
                                            <div class="answer-indicator me-3">
                                                <span class="option-letter">{{ chr(65 + $index) }}</span>
                                            </div>
                                            <div class="answer-content flex-grow-1">
                                                @if($questions[$currentQuestion]->type_jawaban == 'foto')
                                                    <img src="{{ Storage::url($questions[$currentQuestion]->$pilihan) }}" 
                                                        class="img-fluid rounded answer-image" 
                                                        alt="Answer Option {{ $optionValue }}"
                                                        style="max-height: 120px">
                                                @else
                                                    <span class="fs-6">{{ $questions[$currentQuestion]->$pilihan }}</span>
                                                @endif
                                            </div>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="card-footer bg-white border-top d-flex justify-content-between align-items-center py-3">
                            <button class="btn btn-soft-secondary" 
                                    wire:click="previousQuestion"
                                    @if($currentQuestion === 0) disabled @endif>
                                <i class="mdi mdi-chevron-left me-1"></i>Sebelumnya
                            </button>
                            
                            <span class="badge bg-soft-secondary text-secondary rounded-pill px-3">
                                {{ $currentQuestion + 1 }} / {{ count($questions) }}
                            </span>
                            
                            @if($currentQuestion < count($questions) - 1)
                                <button class="btn btn-soft-primary" wire:click="nextQuestion">
                                    Selanjutnya<i class="mdi mdi-chevron-right ms-1"></i>
                                </button>
                            @else
                                <button class="btn btn-soft-success" wire:click="showConfirmation">
                                    <i class="mdi mdi-check me-1"></i>Selesai
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($showConfirmModal)
        <div class="modal fade show d-block" tabindex="-1" style="background: rgba(0,0,0,0.45);">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg">
                    <div class="modal-header bg-soft-warning text-warning border-0 rounded-top-3">
                        <h5 class="modal-title d-flex align-items-center mb-0"><i class="mdi mdi-alert-outline me-2"></i>Konfirmasi Selesai</h5>
                    </div>
                    <div class="modal-body p-4">
                        <div class="text-center mb-4">
                            <i class="mdi mdi-help-circle-outline text-warning" style="font-size: 4rem;"></i>
                        </div>
                        <p class="text-center fs-5 mb-4">Apakah Anda yakin ingin menyelesaikan tes?</p>
                        
                        <div class="row g-3 mb-4">
                            <div class="col-4 text-center">
                                <div class="p-3 bg-success-subtle rounded">
                                    <div class="fw-bold text-success fs-4">{{ $this->getAnsweredCount() }}</div>
                                    <small class="text-muted">Dijawab</small>
                                </div>
                            </div>
                            <div class="col-4 text-center">
                                <div class="p-3 bg-warning-subtle rounded">
                                    <div class="fw-bold text-warning fs-4">{{ $this->getMarkedCount() }}</div>
                                    <small class="text-muted">Ditandai</small>
                                </div>
                            </div>
                            <div class="col-4 text-center">
                                <div class="p-3 bg-danger-subtle rounded">
                                    <div class="fw-bold text-danger fs-4">{{ $this->getUnansweredCount() }}</div>
                                    <small class="text-muted">Belum Dijawab</small>
                                </div>
                            </div>
                        </div>
                        
                        @if($this->getUnansweredCount() > 0)
                            <div class="alert border-0 bg-warning-subtle text-warning">
                                <i class="mdi mdi-alert-outline me-2"></i>
                                Masih ada {{ $this->getUnansweredCount() }} soal yang belum dijawab.
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-soft-secondary" wire:click="hideConfirmation" onclick="window.Proctor && window.Proctor.enable();">
                            <i class="mdi mdi-close me-1"></i>Batal
                        </button>
                        <button type="button" class="btn btn-soft-success" wire:click="completeTest" onclick="window.Proctor && window.Proctor.disable(); window.stopProctorCamera && window.stopProctorCamera();">
                            <i class="mdi mdi-check me-1"></i>Ya, Selesai
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
    </section>

    <style>
        .bg-gradient-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        .question-grid {
            display: grid;
            grid-template-columns: repeat(5, 44px); /* 5 kolom, lebar tetap */
            justify-content: center; /* pusatkan grid di dalam container */
            justify-items: center; /* pusatkan item di tiap sel */
            gap: 10px;
            margin: 0 auto 1rem auto; /* center secara aman */
        }
        .question-grid .btn{ box-sizing: border-box; }
        .question-btn {
            width: 100%;
            aspect-ratio: 1; /* fix circle sizing */
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.9rem;
            line-height: 1;
            transition: transform .15s ease, box-shadow .15s ease;
            border-radius: 50%;
            padding: 0 !important; /* remove bootstrap btn padding */
            margin: 2px; /* small inset so circle fits inside cell */
            min-height: 0; /* allow aspect-ratio to control height */
            border: 2px solid; /* keep outline variant thickness */
        }

        .question-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.08);
        }

        .answer-option {
            transition: all 0.3s ease;
        }

        .answer-option:hover .answer-label {
            transform: translateX(2px);
            box-shadow: 0 4px 10px rgba(0,0,0,0.06);
            border-color: rgba(var(--bs-primary-rgb), .3);
        }

        .answer-option.selected .answer-label {
            background-color: rgba(var(--bs-primary-rgb), .08);
            color: var(--bs-primary);
            border-color: rgba(var(--bs-primary-rgb), .45);
            transform: none;
            box-shadow: 0 6px 16px rgba(13,110,253,.12);
        }

        .answer-option.selected .option-letter {
            background: rgba(var(--bs-primary-rgb), .12);
            color: var(--bs-primary);
        }

        .answer-label {
            transition: all 0.3s ease;
            border: 2px solid #e5e7eb;
            background: #fff;
        }

        .answer-label:hover {
            border-color: #667eea;
            background: #f8f9ff;
        }

        .answer-indicator {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .option-letter {
            width: 32px;
            height: 32px;
            background: #e9ecef;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 0.9rem;
            color: #495057;
            transition: all 0.3s ease;
        }

        .cursor-pointer {
            cursor: pointer;
        }

        .timer-display {
            animation: pulse-timer 2s infinite;
        }

        @keyframes pulse-timer {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        .card {
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }

        .modal {
            backdrop-filter: blur(5px);
        }

        .sticky-top {
            z-index: 1020;
        }

        @media (max-width: 576px) {
            .question-grid { grid-template-columns: repeat(3, 40px); }
        }

        @media (max-width: 768px) {
            .question-grid { grid-template-columns: repeat(4, 42px); }
            
            .col-lg-3 {
                order: 2;
            }
            
            .col-lg-9 {
                order: 1;
            }
        }

        .bg-success-subtle {
            background-color: rgba(25, 135, 84, 0.1);
        }

        .bg-danger-subtle {
            background-color: rgba(220, 53, 69, 0.1);
        }

        .bg-warning-subtle {
            background-color: rgba(255, 193, 7, 0.1);
        }

        .bg-info-subtle {
            background-color: rgba(13, 202, 240, 0.1);
        }

        .bg-primary-subtle {
            background-color: rgba(13, 110, 253, 0.1);
        }
        /* Paksa navbar agar tidak transparan dan memiliki background putih */
        #topnav {
            background: #ffffff !important;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 1030;
        }

        /* Pastikan link di navbar terlihat jelas di background putih */
        #topnav .navigation-menu > li > a {
            color: #3c4858 !important;
        }

        /* Ubah warna logo jika perlu */
        #topnav .logo .l-dark {
            display: inline-block !important;
        }
        #topnav .logo .l-light {
            display: none !important;
        }

        /* Proctor: disable text selection & copying in test area */
        .proctor-protect, .proctor-protect * {
            -webkit-user-select: none !important;
            -moz-user-select: none !important;
            -ms-user-select: none !important;
            user-select: none !important;
        }
        .proctor-protect img { -webkit-user-drag: none; user-drag: none; }
    </style>

    <style>
        /* Proctoring UI */
        .proctor-camera {
            position: fixed;
            right: 1rem;
            bottom: 1rem;
            width: 260px;
            z-index: 1060;
            padding: .75rem;
        }
        .proctor-camera video { width: 100%; height: 100%; object-fit: cover; transform: scaleX(-1); }
        .proctor-warning {
            position: fixed;
            left: 50%;
            transform: translateX(-50%);
            top: .5rem;
            background: #fff3cd;
            color: #8a6d3b;
            border: 1px solid #ffe69c;
            border-radius: .5rem;
            padding: .5rem .75rem;
            z-index: 1065;
            box-shadow: 0 6px 16px rgba(0,0,0,.12);
        }
        .proctor-warning.blink { animation: blink-warning 1s ease-in-out infinite; }
        @keyframes blink-warning {
            0%, 100% { opacity: 1; }
            50% { opacity: .5; }
        }
        #proctor-detect-count.badge { min-width: 3.25rem; text-align: center; }
        .proctor-flash {
            animation: proctor-flash 1s ease-in-out 3;
        }
        @keyframes proctor-flash {
            0%, 100% { box-shadow: 0 0 0 0 rgba(220,53,69,.0); }
            50% { box-shadow: 0 0 0 6px rgba(220,53,69,.3); }
        }
    </style>

    <script>
        function timer(startedAtEpoch, durationMinutes, initialLeft) {
            return {
                endsAt: startedAtEpoch ? (startedAtEpoch * 1000) + (durationMinutes * 60 * 1000) : null,
                timeLeft: Number(initialLeft || 0),
                interval: null,
                
                startTimer() {
                    if (this.endsAt) {
                        this.tick();
                        this.interval = setInterval(() => this.tick(), 1000);
                    } else {
                        // Fallback if endsAt not available
                        this.interval = setInterval(() => {
                            this.timeLeft = Math.max(0, this.timeLeft - 1);
                            if (this.timeLeft <= 0) {
                                clearInterval(this.interval);
                                @this.call('completeTest');
                            }
                        }, 1000);
                    }
                },
                
                tick() {
                    const now = Date.now();
                    this.timeLeft = Math.max(0, Math.floor((this.endsAt - now) / 1000));
                    if (this.timeLeft <= 0) {
                        clearInterval(this.interval);
                        @this.call('completeTest');
                    }
                },
                
                updateDisplay() {
                    const minutes = Math.floor(this.timeLeft / 60);
                    const seconds = this.timeLeft % 60;
                    return `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                },
                
                formatTime() { return this.updateDisplay(); },
            }
        }

        // Add image zoom functionality
        document.addEventListener('DOMContentLoaded', function() {
            const images = document.querySelectorAll('.question-image, .answer-image');
            images.forEach(img => {
                img.classList.add('image-zoom');
                img.addEventListener('click', function() {
                    const lightbox = document.createElement('div');
                    lightbox.className = 'lightbox';
                    const clone = this.cloneNode();
                    lightbox.appendChild(clone);
                    document.body.appendChild(lightbox);
                    lightbox.style.display = 'block';
                    
                    lightbox.addEventListener('click', function() {
                        this.remove();
                    });
                });
            });
        });

        // --- Proctoring ---
        (function(){
            let initialized = false;
            function initProctor(){
                if (window.__PROCTOR_DISABLED) { return; }
                // only start when test area is present
                const root = document.getElementById('proctor-active');
                if(!root) return;
                if(initialized) return; initialized = true;

                const warnEl = document.getElementById('proctor-warning');
                const warnText = document.getElementById('proctor-warning-text');
                const camEl = document.getElementById('proctor-camera');
                const statusEl = document.getElementById('proctor-status');
                const video = document.getElementById('proctorVideo');
                let detectCountEl = document.getElementById('proctor-detect-count');

                let audioCtx = null; let lastBeep = 0; let proctorMuted = false;
                let alarmOsc = null; let alarmGain = null; let alarmTimer = null; let currentWarnMsg = '';
                const violations = new Set();
                let persistentWarning = false;
                let cameraDetectCount = (window.__cameraDetectCount || 0);
                let forcedExitScheduled = false;

                function writeDetectBadge(val){
                    if(!detectCountEl || !detectCountEl.isConnected){
                        detectCountEl = document.getElementById('proctor-detect-count');
                        if(!detectCountEl) return;
                    }
                    const max = 3;
                    const v = Math.min(val, max);
                    detectCountEl.textContent = `${v}/${max}`;
                    detectCountEl.classList.remove('bg-soft-danger','text-danger','bg-soft-warning','text-warning','bg-soft-success','text-success');
                    if(v >= 3){
                        detectCountEl.classList.add('bg-soft-danger','text-danger');
                    } else if(v === 2){
                        detectCountEl.classList.add('bg-soft-warning','text-warning');
                    } else {
                        detectCountEl.classList.add('bg-soft-danger','text-danger');
                    }
                }
                function updateDetectCounter(){ writeDetectBadge(cameraDetectCount); }
                function refreshDetectBadge(){ writeDetectBadge(window.__cameraDetectCount || 0); }
                updateDetectCounter();
                // Periodically refresh badge to resist DOM swaps
                try { clearInterval(window.__PROCTOR_BADGE_TIMER); } catch(_) {}
                window.__PROCTOR_BADGE_TIMER = setInterval(refreshDetectBadge, 1000);

                // expose simple control to pause/resume alarms and blocking
                window.Proctor = window.Proctor || {};
                window.Proctor.mute = function(){ proctorMuted = true; updateAlarmAndWarning(); };
                window.Proctor.unmute = function(){ proctorMuted = false; updateAlarmAndWarning(); };
                window.Proctor.disable = window.Proctor.mute;
                window.Proctor.enable = window.Proctor.unmute;
                function startAlarm(){
                    if (proctorMuted) return;
                    try {
                        audioCtx = audioCtx || new (window.AudioContext || window.webkitAudioContext)();
                        if (alarmOsc) return; // already running
                        alarmOsc = audioCtx.createOscillator();
                        alarmGain = audioCtx.createGain();
                        alarmOsc.type = 'square';
                        alarmOsc.frequency.value = 1000;
                        alarmGain.gain.value = 0.18;
                        alarmOsc.connect(alarmGain); alarmGain.connect(audioCtx.destination);
                        alarmOsc.start();
                        alarmTimer = setInterval(()=>{
                            if (!alarmOsc) return; 
                            alarmOsc.frequency.value = (alarmOsc.frequency.value === 1000 ? 1300 : 1000);
                        }, 450);
                    } catch(e) { /* ignore */ }
                }

                function stopAlarm(){
                    try {
                        if (alarmTimer) { clearInterval(alarmTimer); alarmTimer = null; }
                        if (alarmOsc) { alarmOsc.stop(); alarmOsc.disconnect(); alarmOsc = null; }
                        if (alarmGain) { try { alarmGain.disconnect(); } catch(_){} alarmGain = null; }
                    } catch(e) { /* ignore */ }
                }

                function updateAlarmAndWarning(){
                    if (proctorMuted) {
                        stopAlarm();
                        // Saat muted, sembunyikan alarm suara, tapi jika persistentWarning aktif, tetap tampilkan banner
                        if (persistentWarning) {
                            warnEl.style.display = 'block';
                            if (currentWarnMsg) warnText.textContent = currentWarnMsg;
                        } else {
                            warnEl.style.display = 'none';
                        }
                        return;
                    }
                    if (violations.size > 0){
                        startAlarm();
                        warnEl.style.display = 'block';
                        if (currentWarnMsg) warnText.textContent = currentWarnMsg;
                    } else {
                        stopAlarm();
                        if (persistentWarning) {
                            // Pertahankan banner tetap tampil walau tidak ada pelanggaran aktif
                            warnEl.style.display = 'block';
                            if (currentWarnMsg) warnText.textContent = currentWarnMsg;
                        } else {
                            warnEl.style.display = 'none';
                        }
                    }
                }

                function beep(){
                    if (proctorMuted) return;
                    const now = Date.now();
                    if(now - lastBeep < 1500) return; // throttle
                    lastBeep = now;
                    try {
                        audioCtx = audioCtx || new (window.AudioContext || window.webkitAudioContext)();
                        const o = audioCtx.createOscillator();
                        const g = audioCtx.createGain();
                        o.type = 'sine'; o.frequency.value = 880; // A5
                        o.connect(g); g.connect(audioCtx.destination);
                        g.gain.setValueAtTime(0.0001, audioCtx.currentTime);
                        g.gain.exponentialRampToValueAtTime(0.3, audioCtx.currentTime + 0.02);
                        o.start();
                        setTimeout(()=>{ g.gain.exponentialRampToValueAtTime(0.0001, audioCtx.currentTime + 0.02); o.stop(); }, 300);
                    } catch(e) { /* ignore */ }
                }

                // Ensure audio context can play after a user gesture
                function primeAudio(){
                    try { audioCtx = audioCtx || new (window.AudioContext || window.webkitAudioContext)(); audioCtx.resume && audioCtx.resume(); } catch(e) {}
                    window.removeEventListener('click', primeAudio, { capture: true });
                    window.removeEventListener('keydown', primeAudio, { capture: true });
                }
                window.addEventListener('click', primeAudio, { capture: true, once: true });
                window.addEventListener('keydown', primeAudio, { capture: true, once: true });

                function showWarning(msg){
                    if (proctorMuted) return;
                    if (msg) { currentWarnMsg = msg; warnText.textContent = msg; }
                    warnEl.style.display = 'block';
                    camEl.classList.add('proctor-flash');
                    setTimeout(()=>camEl.classList.remove('proctor-flash'), 1200);
                }

                function activateViolation(type, meta={}){
                    if (proctorMuted) return;
                    violations.add(type);
                    updateAlarmAndWarning();
                }

                function clearViolation(type){
                    if (violations.has(type)) {
                        violations.delete(type);
                        updateAlarmAndWarning();
                    }
                }

                function captureFrame(){
                    try {
                        const canvas = document.createElement('canvas');
                        const vw = video.videoWidth || 640, vh = video.videoHeight || 480;
                        canvas.width = vw; canvas.height = vh;
                        const ctx = canvas.getContext('2d');
                        ctx.drawImage(video, 0, 0, vw, vh);
                        return canvas.toDataURL('image/png');
                    } catch(e){ return null; }
                }

                async function ensureHtml2Canvas(){
                    if (window.html2canvas) return true;
                    try {
                        await loadScript('{{ asset('js/html2canvas.min.js') }}');
                    } catch(_e){
                        try {
                            await loadScript('https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js');
                        } catch(__e) { return false; }
                    }
                    return !!window.html2canvas;
                }

                async function captureDomScreenshot(){
                    try {
                        const ok = await ensureHtml2Canvas();
                        if (!ok) return null;
                        const canvas = await window.html2canvas(document.body, { useCORS: true, logging: false, scale: (window.devicePixelRatio||1) });
                        return canvas.toDataURL('image/png');
                    } catch(e){ return null; }
                }

                async function captureEvidenceFor(type, meta){
                    try {
                        let img = null;
                        if (type === 'fullscreen_exit' || type === 'window_blur' || type === 'tab_hidden'){
                            img = await captureDomScreenshot();
                            if (!img) { img = captureFrame(); }
                        } else {
                            img = captureFrame();
                        }
                        if (img) { return Object.assign({}, meta||{}, { image_data: img }); }
                        return meta||{};
                    } catch(e){ return meta||{}; }
                }

                async function persistProctor(payload){
                    if (window.__PROCTOR_DISABLED) return;
                    try {
                        // Prefer direct server call to avoid being dropped before redirect
                        return await @this.call('handleProctorEvent', payload);
                    } catch(e){
                        try { if (window.Livewire && window.Livewire.emit) window.Livewire.emit('proctorEvent', payload); } catch(_e){}
                    }
                }

                // track last clicked link (if any) for context
                (function(){
                    document.addEventListener('click', (e)=>{
                        const a = e.target.closest && e.target.closest('a[href]');
                        if(a && a.href){ window.__lastClickedHref = a.href; }
                    }, { capture: true });
                })();

                async function reportViolation(type, meta={}){
                    if (proctorMuted || window.__PROCTOR_DISABLED) return;
                    const messageMap = {
                        tab_hidden: 'Jangan berpindah tab atau meminimalkan jendela saat ujian berlangsung.',
                        window_blur: 'Jendela tidak aktif. Kembali ke halaman ujian.',
                        fullscreen_exit: 'Mohon tetap dalam mode layar penuh selama ujian.',
                        blocked_shortcut: 'Shortcut tidak diizinkan selama ujian.',
                        context_menu: 'Klik kanan dinonaktifkan selama ujian.',
                        camera_denied: 'Izin kamera ditolak. Kamera diperlukan untuk ujian.',
                        face_count: 'Deteksi wajah tidak valid. Pastikan wajah Anda jelas dan sendiri.',
                        copy: 'Menyalin konten tidak diizinkan.',
                        screenshot: 'Tindakan screenshot terdeteksi. Hindari perekaman layar.',
                        print: 'Mencetak halaman tidak diizinkan selama ujian.',
                    };
                    let msg = messageMap[type] || 'Perilaku mencurigakan terdeteksi.';
                    // Kamera: hitung pelanggaran dan beri peringatan/keluarkan jika perlu
                    let willForceExit = false;
                    if(type === 'face_count'){
                        cameraDetectCount++;
                        window.__cameraDetectCount = cameraDetectCount;
                        updateDetectCounter();
                        if(cameraDetectCount === 2){
                            msg = 'Peringatan: Deteksi kamera 2 kali. Jika terulang, ujian akan diakhiri.';
                            persistentWarning = true;
                            try { warnEl.classList.add('blink'); } catch(_e){}
                        }
                        if(cameraDetectCount >= 3 && !forcedExitScheduled){
                            willForceExit = true;
                            msg = 'Deteksi kamera 3 kali. Ujian diakhiri.';
                        }
                    }
                    currentWarnMsg = msg; showWarning(msg);
                    // enrich meta with evidence when appropriate
                    try {
                        if(type === 'tab_hidden'){
                            meta = Object.assign({ last_url: window.__lastClickedHref || null }, meta || {});
                        }
                        if(['face_count','fullscreen_exit','window_blur','tab_hidden','screenshot','print'].includes(type)){
                            meta = await captureEvidenceFor(type, meta);
                        }
                    } catch(_e){}
                    activateViolation(type, meta);
                    startAlarm();
                    try { await persistProctor({ type, meta, at: new Date().toISOString() }); } catch(e) {}
                    if (willForceExit && !forcedExitScheduled){
                        forcedExitScheduled = true;
                        try { window.Proctor && window.Proctor.disable(); window.__PROCTOR_DISABLED = true; } catch(_e){}
                        try { window.stopProctorCamera && window.stopProctorCamera(); } catch(_e){}
                        try { document.exitFullscreen && document.exitFullscreen(); } catch(_e){}
                        setTimeout(()=>{ try { @this.call('completeTest'); } catch(_e){} }, 150);
                    }
                }

                // Request fullscreen
                if(document.documentElement.requestFullscreen){
                    document.documentElement.requestFullscreen().catch(()=>{});
                }
                document.addEventListener('fullscreenchange', async ()=>{
                    if (window.__PROCTOR_DISABLED) return;
                    if(!document.fullscreenElement){
                        // Ambil bukti screenshot DOM (fallback ke frame kamera) dan simpan ke server terlebih dahulu
                        const meta = await captureEvidenceFor('fullscreen_exit', {});
                        const payload = { type: 'fullscreen_exit', meta, at: new Date().toISOString() };
                        try { await persistProctor(payload); } catch(_e){}
                        // Lalu akhiri ujian
                        if (!forcedExitScheduled) {
                            forcedExitScheduled = true;
                            try { window.Proctor && window.Proctor.disable(); } catch(_e){}
                            try { window.stopProctorCamera && window.stopProctorCamera(); } catch(_e){}
                            setTimeout(()=>{ try { @this.call('completeTest'); } catch(_e){} }, 150);
                        }
                    } else {
                        clearViolation('fullscreen_exit');
                    }
                });

                // Visibility / focus
                document.addEventListener('visibilitychange', ()=>{
                    if(proctorMuted || window.__PROCTOR_DISABLED) return;
                    if(document.hidden){ reportViolation('tab_hidden'); } else { clearViolation('tab_hidden'); }
                });
                window.addEventListener('blur', ()=>{ if(proctorMuted || window.__PROCTOR_DISABLED) return; reportViolation('window_blur'); });
                window.addEventListener('focus', ()=>{ if(proctorMuted || window.__PROCTOR_DISABLED) return; clearViolation('window_blur'); });

                // Block common shortcuts
                window.addEventListener('keydown', (e)=>{
                    if(proctorMuted || window.__PROCTOR_DISABLED) return;
                    const k = e.key?.toLowerCase();
                    if(
                        e.key === 'F5' || e.key === 'F12' ||
                        (e.ctrlKey && (k === 'r' || k === 'n' || k === 't' || k === 'w' || k === 'p' || k === 's'))
                    ){
                        e.preventDefault(); e.returnValue = false; reportViolation('blocked_shortcut');
                        setTimeout(()=>clearViolation('blocked_shortcut'), 2500);
                    }
                    // Screenshot keys: PrintScreen (Windows), Meta+Shift+3/4/5 (macOS)
                    if (e.key === 'PrintScreen' || (e.metaKey && e.shiftKey && ['3','4','5'].includes(k))){
                        e.preventDefault && e.preventDefault();
                        // Attempt to overwrite clipboard (may fail)
                        if (navigator.clipboard && navigator.clipboard.writeText){
                            navigator.clipboard.writeText('').catch(()=>{});
                        }
                        reportViolation('screenshot');
                        setTimeout(()=>clearViolation('screenshot'), 4000);
                    }
                }, { capture: true });
                window.addEventListener('contextmenu', (e)=>{ if(proctorMuted || window.__PROCTOR_DISABLED) return; e.preventDefault(); reportViolation('context_menu'); setTimeout(()=>clearViolation('context_menu'), 2500); }, { capture: true });

                // Block copy/cut/paste inside test area
                const cbtArea = document.getElementById('cbt-area');
                if (cbtArea){
                    ['copy','cut'].forEach(evt => cbtArea.addEventListener(evt, (e)=>{ if(proctorMuted || window.__PROCTOR_DISABLED) return; e.preventDefault(); reportViolation('copy'); setTimeout(()=>clearViolation('copy'), 3000); }, { capture: true }));
                    cbtArea.addEventListener('paste', (e)=>{ if(proctorMuted || window.__PROCTOR_DISABLED) return; e.preventDefault(); reportViolation('copy'); setTimeout(()=>clearViolation('copy'), 3000); }, { capture: true });
                    cbtArea.addEventListener('selectstart', (e)=>{ if(proctorMuted || window.__PROCTOR_DISABLED) return; e.preventDefault(); }, { capture: true });
                    cbtArea.addEventListener('dragstart', (e)=>{ if(proctorMuted || window.__PROCTOR_DISABLED) return; e.preventDefault(); }, { capture: true });
                }

                // Printing treated as screenshot attempt
                window.addEventListener('beforeprint', ()=>{ if(proctorMuted || window.__PROCTOR_DISABLED) return; reportViolation('print'); });
                window.addEventListener('afterprint', ()=>{ if(proctorMuted || window.__PROCTOR_DISABLED) return; clearViolation('print'); });

                // Prevent navigation away
                window.addEventListener('beforeunload', (e)=>{ if(proctorMuted || window.__PROCTOR_DISABLED) return; e.preventDefault(); e.returnValue=''; });

                // Camera init
                async function initCamera(){
                    try {
                        let stream = window.__proctorStream;
                        if (!stream) {
                            stream = await navigator.mediaDevices.getUserMedia({ video: { width: 640, height: 480 }, audio: false });
                            window.__proctorStream = stream;
                        }
                        video.srcObject = stream;
                        video.muted = true;
                        if (video.play) { video.play().catch(()=>{}); }
                        if ('onloadedmetadata' in video) {
                            video.onloadedmetadata = () => { try { video.play && video.play(); } catch(e) {} };
                        }
                        statusEl.textContent = 'Kamera aktif';
                        setupFaceCheck();
                    } catch(err){
                        statusEl.textContent = 'Kamera tidak tersedia';
                        reportViolation('camera_denied', { error: String(err) });
                    }
                }
                function stopProctorCamera(){
                    try {
                        if (video) {
                            try { video.pause && video.pause(); } catch(_) {}
                            video.srcObject = null;
                        }
                        if (window.__proctorStream) {
                            try { window.__proctorStream.getTracks().forEach(t => t.stop()); } catch(_) {}
                            window.__proctorStream = null;
                        }
                        if (statusEl) statusEl.textContent = 'Kamera dimatikan';
                    } catch(e) { /* ignore */ }
                }
                window.stopProctorCamera = stopProctorCamera;

                // Face detection with fallback to face-api.js (local -> CDN)
                function setupFaceCheck(){
                    const hasFD = 'FaceDetector' in window;
                    if(hasFD){
                        let detector; try { detector = new window.FaceDetector({ fastMode: true }); } catch(e){ detector = null; }
                        if(!detector) { loadFaceApiAndRun(); return; }
                        statusEl.textContent = 'Kamera aktif - deteksi wajah';
                    let lastFaceViolationAt = 0;
                    const faceViolationCooldownMs = 3000; // throttle to avoid burst
                    const check = async ()=>{
                        try {
                            const faces = await detector.detect(video);
                            const count = faces?.length ?? 0;
                            if(count !== 1){
                                const now = Date.now();
                                if (now - lastFaceViolationAt > faceViolationCooldownMs){
                                    lastFaceViolationAt = now;
                                    reportViolation('face_count', { count });
                                }
                            } else {
                                clearViolation('face_count');
                            }
                        } catch(e){ /* ignore */ }
                    };
                    setInterval(check, 2000);
                    } else {
                        loadFaceApiAndRun();
                    }
                }

                async function loadScript(src){
                    return new Promise((resolve, reject)=>{
                        const s = document.createElement('script');
                        s.src = src; s.async = true; s.onload = resolve; s.onerror = reject;
                        document.head.appendChild(s);
                    });
                }

                async function loadFaceApiAndRun(){
                    try {
                        // Load library if needed
                        if(!window.faceapi){
                            // try local first, then CDN
                            try {
                                await loadScript('{{ asset('js/face-api.min.js') }}');
                            } catch(_e){
                                await loadScript('https://cdn.jsdelivr.net/npm/@vladmandic/face-api@1.7.2/dist/face-api.min.js');
                            }
                        }
                        // Try local models first, then CDN
                        const LOCAL_MODEL_URL = '{{ asset('models/face-api') }}/';
                        const CDN_MODEL_URL = 'https://cdn.jsdelivr.net/npm/@vladmandic/face-api@1.7.2/model/';
                        try {
                            await faceapi.nets.tinyFaceDetector.loadFromUri(LOCAL_MODEL_URL);
                        } catch(_m){
                            await faceapi.nets.tinyFaceDetector.loadFromUri(CDN_MODEL_URL);
                        }
                        statusEl.textContent = 'Kamera aktif - deteksi wajah';
                        runFaceApiChecks();
                    } catch(err){
                        // If even CDN fails, we silently proceed with camera-only
                        statusEl.textContent = 'Kamera aktif - deteksi tidak tersedia';
                        try { if (detectCountEl) detectCountEl.classList.add('d-none'); } catch(_) {}
                    }
                }

                function runFaceApiChecks(){
                    let lastFaceViolationAt = 0;
                    const faceViolationCooldownMs = 3000;
                    const options = new faceapi.TinyFaceDetectorOptions({
                        inputSize: 256,
                        scoreThreshold: 0.5,
                    });
                    const check = async ()=>{
                        try {
                            const detections = await faceapi.detectAllFaces(video, options);
                            const count = (detections || []).length;
                            if(count !== 1){
                                const now = Date.now();
                                if (now - lastFaceViolationAt > faceViolationCooldownMs){
                                    lastFaceViolationAt = now;
                                    reportViolation('face_count', { count });
                                }
                            } else {
                                clearViolation('face_count');
                            }
                        } catch(e){ /* ignore */ }
                    };
                    setInterval(check, 2200);
                }

                initCamera();
            }

            // Expose init for Alpine x-init
            window.__initProctor = initProctor;

            // Initialize after Livewire DOM present
            if(document.readyState === 'loading'){
                document.addEventListener('DOMContentLoaded', initProctor);
            } else { initProctor(); }

            // Re-init if Livewire updates the DOM
            document.addEventListener('livewire:load', function(){
                if(window.Livewire && window.Livewire.hook){
                    window.Livewire.hook('message.processed', (message, component)=>{
                        if(document.getElementById('proctor-active')) initProctor();
                        try { refreshDetectBadge(); } catch(_) {}
                    });
                }
            });
            // Ensure camera stops when leaving page
            window.addEventListener('pagehide', ()=>{ try { window.stopProctorCamera && window.stopProctorCamera(); } catch(_) {} });
        })();
        // --- End Proctoring ---
    </script>
</div>
