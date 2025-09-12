@php
    $lowongan = optional($lamaran)->lowongan;
    $candidateName = optional(optional($lamaran->kandidat)->user)->name;
    $position = optional($lowongan)->nama_posisi;
    $department = optional($lowongan)->departemen;
    $location = optional($lowongan)->lokasi_penugasan;
    $salary = optional($lowongan)->formatted_gaji ?? optional($lowongan)->range_gaji;
@endphp

<div class="card border-0 shadow-sm mt-3">
    <div class="card-body p-4">
        <div class="d-flex align-items-center gap-3 mb-3">
            <img src="https://www.multindo-technology.com/img/logomultindo-transparent.png" alt="Multindo Technology" style="height:40px;">
            <div>
                <h6 class="mb-0">Offering Letter</h6>
                <small class="text-muted">{{ now()->format('d M Y') }}</small>
            </div>
        </div>

        <p class="mb-2">Kepada Yth,</p>
        <p class="mb-3"><strong>{{ $candidateName }}</strong></p>
        <p class="mb-3">Dengan hormat,</p>

        <p class="mb-3">
            Kami dengan senang hati menyampaikan bahwa Anda telah <span class="badge bg-soft-success text-success">DITERIMA</span>
            untuk posisi <strong>{{ $position }}</strong>@if(!empty($department)) ({{ $department }}) @endif di <strong>Multindo Technology</strong>.
        </p>

        <div class="p-3 rounded-3 bg-light border mb-3">
            <div class="fw-semibold mb-2">Ringkasan Penawaran</div>
            <div class="small text-muted">
                <div><span class="text-dark">Posisi:</span> {{ $position ?? '-' }}</div>
                @if(!empty($department))<div><span class="text-dark">Departemen:</span> {{ $department }}</div>@endif
                @if(!empty($location))<div><span class="text-dark">Lokasi Kerja:</span> {{ $location }}</div>@endif
                @if(!empty($salary))<div><span class="text-dark">Perkiraan Gaji:</span> {{ $salary }}</div>@endif
            </div>
        </div>

        <p class="mb-3">Detail lebih lanjut terkait dokumen administrasi, jadwal onboarding, dan keperluan lain akan kami informasikan menyusul. Jika Anda memiliki pertanyaan, silakan menghubungi kami.</p>

        <p class="mb-0">Hormat kami,</p>
        <p class="mb-0">Multindo Technology</p>
    </div>
</div>

