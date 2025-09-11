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
</div>
