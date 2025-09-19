<div>
    <!-- Hero Start -->
    <section class="bg-half-170 d-table w-100" style="background: url('{{ asset('images/hero/bg.jpg') }}');">
        <div class="bg-overlay bg-gradient-overlay"></div>
        <div class="container">
            <div class="row mt-5 justify-content-center">
                <div class="col-12">
                    <div class="title-heading text-center">
                        <h5 class="heading fw-semibold mb-0 sub-heading text-white title-dark">Review Hasil Psikotes</h5>
                        <p class="text-white-50 mt-2">{{ optional($result->user)->name }} &mdash; Skor {{ number_format($result->score, 1) }}%</p>
                    </div>
                </div>
            </div>
            <div class="position-middle-bottom">
                <nav aria-label="breadcrumb" class="d-block">
                    <ul class="breadcrumb breadcrumb-muted mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('officers.index') }}">Beranda</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('test-results.index') }}">Hasil Psikotes</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Review</li>
                    </ul>
                </nav>
            </div>
        </div>
    </section>
    <div class="position-relative">
        <div class="shape overflow-hidden text-white">
            <svg viewBox="0 0 2880 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 48H1437.5H2880V0H2160C1442.5 52 720 0 720 0H0V48Z" fill="currentColor"></path>
            </svg>
        </div>
    </div>

    <section class="section">
        <div class="container">
            <div class="mb-3 d-flex justify-content-between align-items-center">
                <a href="{{ route('test-results.index') }}" class="btn btn-soft-secondary btn-sm">
                    <i class="mdi mdi-arrow-left me-1"></i> Kembali
                </a>
                <div class="d-flex gap-2">
                    <span class="badge {{ $result->score >= 70 ? 'bg-soft-success text-success' : 'bg-soft-danger text-danger' }}">
                        {{ $result->score >= 70 ? 'Lulus' : 'Tidak Lulus' }}
                    </span>
                    <span class="badge bg-soft-info text-info">Total: {{ $result->total_questions }}</span>
                    <span class="badge bg-soft-success text-success">Benar: {{ $result->correct_answers }}</span>
                </div>
            </div>

            {{-- Proctoring Report --}}
            <div class="card border-0 shadow rounded-3 mb-4">
                <div class="card-header bg-soft-danger text-danger border-0 rounded-top-3">
                    <!-- Top bar: title + actions -->
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                        <div class="d-flex align-items-center gap-2">
                            <h6 class="mb-0 d-flex align-items-center"><i class="mdi mdi-cctv me-2"></i>Laporan Proctoring (Mencurigakan)</h6>
                            <span class="badge {{ count($proctorEvents) ? 'bg-soft-danger text-danger' : 'bg-soft-secondary text-muted' }}" aria-live="polite">
                                {{ count($proctorEvents) }} temuan
                            </span>
                        </div>
                        <div class="btn-group btn-group-sm" role="group" aria-label="Aksi">
                            <button type="button" class="btn btn-soft-secondary" title="Urutkan" wire:click="$set('proctorSort', '{{ $proctorSort === 'desc' ? 'asc' : 'desc' }}')" wire:loading.attr="disabled">
                                <i class="mdi mdi-sort"></i> {{ $proctorSort === 'desc' ? 'Terbaru' : 'Terlama' }}
                            </button>
                            <button type="button" class="btn btn-soft-primary" title="Unduh CSV" wire:click="exportProctorCsv" wire:loading.attr="disabled" wire:target="exportProctorCsv">
                                <span class="position-relative">
                                    <i class="mdi mdi-download"></i> Export CSV
                                    <span class="spinner-border spinner-border-sm text-primary ms-2" role="status" aria-hidden="true" wire:loading wire:target="exportProctorCsv"></span>
                                </span>
                            </button>
                        </div>
                    </div>
                    @if(!empty($proctorSummary))
                        <div class="mt-2 d-flex flex-wrap align-items-center gap-2">
                            @foreach($proctorSummary as $t => $c)
                                <span class="badge bg-soft-danger text-danger" title="{{ $t }}">
                                    <i class="mdi mdi-alert-outline me-1"></i>{{ $t }}: {{ $c }}
                                </span>
                            @endforeach
                        </div>
                    @endif
                    <!-- Filters bottom row -->
                    <div class="mt-2 pt-2 border-top border-danger-subtle">
                        <div class="d-flex justify-content-between align-items-center d-md-none">
                            <button class="btn btn-link btn-sm px-0" type="button" data-bs-toggle="collapse" data-bs-target="#proctorFilters" aria-expanded="false" aria-controls="proctorFilters">
                                <i class="mdi mdi-filter-variant"></i> Tampilkan Filter
                            </button>
                        </div>
                        <div id="proctorFilters" class="collapse d-md-block">
                            <div class="d-flex align-items-center gap-2 flex-wrap proctor-toolbar">
                                <select class="form-select form-select-sm w-auto" wire:model.live="proctorType" title="Filter jenis temuan">
                                    <option value="all">Semua jenis</option>
                                    @foreach($proctorTypes as $t)
                                        <option value="{{ $t }}">{{ $t }}</option>
                                    @endforeach
                                </select>
                                <div class="form-check" title="Hanya tampilkan temuan yang memiliki bukti gambar">
                                    <input id="onlyEvidence" class="form-check-input" type="checkbox" wire:model.live="proctorOnlyWithEvidence">
                                    <label class="form-check-label" for="onlyEvidence">Hanya bukti</label>
                                </div>
                                <div class="d-flex align-items-center gap-1" title="Batasi rentang waktu temuan">
                                    <input type="datetime-local" class="form-control form-control-sm" wire:model.live="proctorFromDate" placeholder="Dari" aria-label="Dari tanggal">
                                    <span class="small text-muted">s/d</span>
                                    <input type="datetime-local" class="form-control form-control-sm" wire:model.live="proctorToDate" placeholder="Sampai" aria-label="Sampai tanggal">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body position-relative">
                    @if(empty($proctorEvents))
                        <div class="text-center text-muted py-4">
                            <i class="mdi mdi-check-circle-outline d-block mb-2" style="font-size: 28px;"></i>
                            <div class="small">Tidak ada temuan mencurigakan untuk sesi ini.</div>
                        </div>
                    @else
                        <div class="table-responsive" wire:loading.class="opacity-50" wire:target="proctorType,proctorOnlyWithEvidence,proctorFromDate,proctorToDate,proctorSort">
                            <table class="table table-sm table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th style="width: 160px;" class="text-nowrap">Waktu</th>
                                        <th>Jenis</th>
                                        <th>Detail</th>
                                        <th style="width: 200px;">Bukti</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($proctorEvents as $e)
                                    <tr>
                                        <td class="text-muted small text-nowrap">{{ $e['time'] ?? '-' }}</td>
                                        <td>
                                            <span class="badge bg-soft-danger text-danger text-uppercase">{{ $e['type'] }}</span>
                                        </td>
                                        <td class="small">
                                            @php 
                                                $m = $e['meta'] ?? []; 
                                                $mm = is_array($m) && isset($m['meta']) && is_array($m['meta']) ? $m['meta'] : $m;
                                            @endphp
                                            @if(is_array($mm) && !empty($mm))
                                                <ul class="list-inline mb-0">
                                                    @if(isset($mm['count']))
                                                        <li class="list-inline-item me-3">
                                                            <span class="text-muted">Wajah terdeteksi:</span> <span class="fw-semibold">{{ $mm['count'] }}</span>
                                                        </li>
                                                    @endif
                                                    @if(!empty($mm['last_url']))
                                                        <li class="list-inline-item me-3 text-truncate" style="max-width:300px">
                                                            <span class="text-muted">Last URL:</span> <a href="{{ $mm['last_url'] }}" target="_blank" rel="noopener">{{ $mm['last_url'] }}</a>
                                                        </li>
                                                    @endif
                                                    @if(!empty($m['at']))
                                                        <li class="list-inline-item text-muted">Client time: {{ $m['at'] }}</li>
                                                    @endif
                                                </ul>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if(!empty($e['evidence']))
                                                <a href="{{ $e['evidence'] }}" target="_blank" rel="noopener" class="d-inline-block" title="Buka bukti di tab baru">
                                                    <img src="{{ $e['evidence'] }}" alt="Evidence" class="img-fluid rounded border" style="max-height:120px;">
                                                </a>
                                                <div class="small mt-1">
                                                    <a href="{{ $e['evidence'] }}" download class="link-secondary text-decoration-none">
                                                        <i class="mdi mdi-download me-1"></i>Unduh
                                                    </a>
                                                </div>
                                            @else
                                                <span class="text-muted small">Tidak ada</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

            <div class="card border-0 shadow rounded-3" x-data="{mode:'accordion'}">
                <div class="card-header bg-soft-primary text-primary border-0 rounded-top-3 d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 d-flex align-items-center"><i class="mdi mdi-clipboard-list-outline me-2"></i>Review Jawaban</h6>
                    <div class="btn-group btn-group-sm" role="group">
                        <button type="button" class="btn" :class="mode==='accordion'?'btn-soft-primary':'btn-outline-secondary'" @click="mode='accordion'">
                            <i class="mdi mdi-view-agenda-outline me-1"></i>Accordion
                        </button>
                        <button type="button" class="btn" :class="mode==='table'?'btn-soft-primary':'btn-outline-secondary'" @click="mode='table'">
                            <i class="mdi mdi-table me-1"></i>Tabel
                        </button>
                        <button type="button" class="btn btn-soft-primary" wire:click="exportReviewPdf">
                            <i class="mdi mdi-download me-1"></i> Export PDF
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Accordion Mode -->
                    <div class="accordion" id="officerAnswerAccordion" x-show="mode==='accordion'" x-cloak>
                        @foreach($items as $row)
                            @php($soal = $row['soal'])
                            <div class="accordion-item border-0 shadow-sm mb-3">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed d-flex align-items-center {{ $row['is_correct'] ? 'bg-success-subtle' : 'bg-danger-subtle' }}" type="button" data-bs-toggle="collapse" data-bs-target="#q{{ $row['index'] }}">
                                        <div class="d-flex align-items-center w-100">
                                            <span class="badge {{ $row['is_correct'] ? 'bg-soft-success text-success' : 'bg-soft-danger text-danger' }} me-3">
                                                <i class="mdi {{ $row['is_correct'] ? 'mdi-check' : 'mdi-close' }}"></i>
                                            </span>
                                            <span class="fw-bold">Soal {{ $row['index'] }}</span>
                                            <span class="ms-auto badge {{ $row['is_correct'] ? 'bg-soft-success text-success' : 'bg-soft-danger text-danger' }}">{{ $row['is_correct'] ? 'Benar' : 'Salah' }}</span>
                                        </div>
                                    </button>
                                </h2>
                                <div id="q{{ $row['index'] }}" class="accordion-collapse collapse" data-bs-parent="#officerAnswerAccordion">
                                    <div class="accordion-body">
                                        <div class="mb-3">
                                            <h6 class="text-muted mb-2">Pertanyaan:</h6>
                                            @if($row['type_soal'] === 'foto')
                                                <img src="{{ Storage::url($soal?->soal) }}" class="img-fluid rounded border" style="max-height: 200px" alt="Soal">
                                            @else
                                                <p class="mb-0">{{ $soal?->soal }}</p>
                                            @endif
                                        </div>
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="p-3 rounded border {{ $row['is_correct'] ? 'bg-success-subtle border-success' : 'bg-danger-subtle border-danger' }}">
                                                    <div class="text-muted small mb-1">Jawaban Kandidat</div>
                                                    @if($row['type_jawaban'] === 'foto')
                                                        <img src="{{ Storage::url(optional($soal)->{'pilihan_' . $row['user_answer']}) }}" class="img-fluid rounded" style="max-height: 120px" alt="Jawaban">
                                                    @else
                                                        {{ optional($soal)->{'pilihan_' . $row['user_answer']} }}
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="p-3 rounded border bg-success-subtle border-success">
                                                    <div class="text-muted small mb-1">Jawaban Benar</div>
                                                    @if($row['type_jawaban'] === 'foto')
                                                        <img src="{{ Storage::url(optional($soal)->{'pilihan_' . $row['correct_index']}) }}" class="img-fluid rounded" style="max-height: 120px" alt="Kunci">
                                                    @else
                                                        {{ optional($soal)->{'pilihan_' . $row['correct_index']} }}
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Table Mode -->
                    <div x-show="mode==='table'" x-cloak>
                        <div class="table-responsive shadow-sm rounded border">
                            <table class="table align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th style="width:60px;" class="text-center">#</th>
                                        <th style="width:120px;">Status</th>
                                        <th>Pertanyaan</th>
                                        <th>Jawaban Kandidat</th>
                                        <th style="width:180px;">Kunci</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($items as $row)
                                    @php($soal = $row['soal'])
                                    <tr>
                                        <td class="text-center fw-semibold">{{ $row['index'] }}</td>
                                        <td>
                                            <span class="badge {{ $row['is_correct'] ? 'bg-soft-success text-success' : 'bg-soft-danger text-danger' }}">{{ $row['is_correct'] ? 'Benar' : 'Salah' }}</span>
                                        </td>
                                        <td class="text-muted">
                                            @if($row['type_soal'] === 'foto')
                                                <img src="{{ Storage::url($soal?->soal) }}" alt="Soal" class="rounded border" style="max-height:48px;">
                                            @else
                                                <span class="d-inline-block" style="max-width: 420px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $soal?->soal }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($row['type_jawaban'] === 'foto')
                                                <img src="{{ Storage::url(optional($soal)->{'pilihan_' . $row['user_answer']}) }}" alt="Jawaban" class="rounded border" style="max-height:48px;">
                                            @else
                                                <span class="d-inline-block {{ $row['is_correct'] ? 'text-success' : 'text-danger' }}" style="max-width: 360px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ optional($soal)->{'pilihan_' . $row['user_answer']} }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($row['type_jawaban'] === 'foto')
                                                <img src="{{ Storage::url(optional($soal)->{'pilihan_' . $row['correct_index']}) }}" alt="Kunci" class="rounded border" style="max-height:48px;">
                                            @else
                                                <span class="d-inline-block text-success" style="max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ optional($soal)->{'pilihan_' . $row['correct_index']} }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <style>
/* Proctor toolbar responsive tweaks */
.proctor-toolbar .form-select-sm,
.proctor-toolbar .form-control-sm { min-width: 160px; }
@media (max-width: 767.98px){
  .proctor-toolbar .form-select-sm,
  .proctor-toolbar .form-control-sm { min-width: 100%; }
}
    </style>
</div>
