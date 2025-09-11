<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CV - {{ trim(($kandidat->nama_depan ?? '').' '.($kandidat->nama_belakang ?? '')) }}</title>
    <style>
        body { font-family: DejaVu Sans, Arial, Helvetica, sans-serif; font-size: 11pt; color: #111; }
        h1 { font-size: 20pt; margin: 0 0 2px 0; }
        h2 { font-size: 12pt; margin: 16px 0 6px; text-transform: uppercase; letter-spacing: .5px; border-bottom: 1px solid #e5e5e5; padding-bottom: 4px; }
        .muted { color: #555; }
        .section { margin-bottom: 10px; }
        .item { margin: 6px 0; }
        .small { font-size: 10pt; }
        .list { margin: 0; padding-left: 18px; }
        .list li { margin: 2px 0; }
        .hr { height: 1px; background: #e5e5e5; border: 0; margin: 12px 0; }
        .row { display: block; }
        .label { font-weight: 600; }
        .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 6px 16px; }
        .grid .field .name { font-weight: 600; }
        .grid .field .value { }
    </style>
    <!-- ATS-friendly: single column, standard headings, no complex tables/images -->
    <!-- Data source: kandidat profile fields -->
    @php
        use Illuminate\Support\Str;
        use Carbon\Carbon;
        $fullName = trim(($kandidat->nama_depan ?? '').' '.($kandidat->nama_belakang ?? ''));
        $email = optional($kandidat->user)->email;
        $phone = $kandidat->no_telpon;
        $altPhone = $kandidat->no_telpon_alternatif;
        $address = trim(($kandidat->alamat ?? '').', '.($kandidat->kode_pos ?? '').', '.($kandidat->negara ?? ''));
        $summary = $kandidat->kemampuan ? Str::limit($kandidat->kemampuan, 600) : null;
        $dob = $kandidat->tanggal_lahir ? Carbon::parse($kandidat->tanggal_lahir)->translatedFormat('d MMMM Y') : null;

        // Parse skills to bullet list (split by comma / newline)
        $skills = [];
        if (!empty($kandidat->kemampuan)) {
            $tmp = preg_split('/[,\n\r]+/', (string)$kandidat->kemampuan);
            foreach ($tmp as $s) {
                $s = trim($s);
                if ($s !== '') $skills[] = $s;
            }
        }
    @endphp
</head>
<body>
    <!-- Header -->
    <div class="section">
        <h1>{{ $fullName ?: 'Nama Kandidat' }}</h1>
        <div class="muted small">
            {{ $email }} @if($phone) | {{ $phone }} @endif @if($altPhone) | {{ $altPhone }} @endif
        </div>
        @if(!empty($address))
            <div class="muted small">{{ $address }}</div>
        @endif
    </div>
    <div class="hr"></div>

    <!-- Ringkasan / Keahlian Utama -->
    @if($summary)
    <div class="section">
        <h2>Ringkasan</h2>
        <div class="item">{{ $summary }}</div>
        @if(!empty($skills))
            <ul class="list">
                @foreach($skills as $s)
                    <li>{{ $s }}</li>
                @endforeach
            </ul>
        @endif
    </div>
    <div class="hr"></div>
    @endif

    <!-- Data Pribadi -->
    <div class="section">
        <h2>Data Pribadi</h2>
        <div class="grid">
            <div class="field"><div class="name">No. KTP</div><div class="value">{{ $kandidat->no_ktp ?: '-' }}</div></div>
            <div class="field"><div class="name">No. NPWP</div><div class="value">{{ $kandidat->no_npwp ?: '-' }}</div></div>
            <div class="field"><div class="name">Tempat, Tanggal Lahir</div><div class="value">{{ ($kandidat->tempat_lahir ?: '-') }}, {{ $dob ?? '-' }}</div></div>
            <div class="field"><div class="name">Jenis Kelamin</div><div class="value">{{ $kandidat->jenis_kelamin === 'L' ? 'Laki-laki' : ($kandidat->jenis_kelamin === 'P' ? 'Perempuan' : '-') }}</div></div>
            <div class="field"><div class="name">Status Perkawinan</div><div class="value">{{ $kandidat->status_perkawinan ?: '-' }}</div></div>
            <div class="field"><div class="name">Agama</div><div class="value">{{ $kandidat->agama ?: '-' }}</div></div>
            <div class="field"><div class="name">No. Telepon</div><div class="value">{{ $kandidat->no_telpon ?: '-' }}</div></div>
            <div class="field"><div class="name">No. Telepon Alternatif</div><div class="value">{{ $kandidat->no_telpon_alternatif ?: '-' }}</div></div>
            <div class="field" style="grid-column: 1 / span 2"><div class="name">Alamat</div><div class="value">{{ $address ?: '-' }}</div></div>
        </div>
    </div>
    <div class="hr"></div>

    <!-- Pendidikan Tertinggi -->
    @if(!empty($kandidat->pendidikan))
    <div class="section">
        <h2>Pendidikan Tertinggi</h2>
        <div class="item small">{{ $kandidat->pendidikan }}</div>
    </div>
    <div class="hr"></div>
    @endif

    <!-- Pengalaman Kerja -->
    @if(!empty($workData))
    <div class="section">
        <h2>Pengalaman Kerja</h2>
        @foreach($workData as $w)
            <div class="item">
                <div class="label">{{ $w['position'] ?? '-' }} @if(!empty($w['company'])) - {{ $w['company'] }} @endif</div>
                <div class="muted small">{{ $w['start'] ?? '-' }} @if(!empty($w['end'])) - {{ $w['end'] }} @endif</div>
                @if(!empty($w['business']))
                    <div class="small">Bidang: {{ $w['business'] }}</div>
                @endif
                @if(!empty($w['reason']))
                    <div class="small">Alasan keluar: {{ $w['reason'] }}</div>
                @endif
            </div>
        @endforeach
    </div>
    <div class="hr"></div>
    @endif

    <!-- Pendidikan -->
    @if(!empty($eduData))
    <div class="section">
        <h2>Pendidikan</h2>
        @foreach($eduData as $e)
            <div class="item">
                <div class="label">{{ $e['name'] ?? '-' }} @if(!empty($e['major'])) - {{ $e['major'] }} @endif</div>
                <div class="muted small">{{ $e['start'] ?? '-' }} @if(!empty($e['end'])) - {{ $e['end'] }} @endif</div>
                @if(!empty($e['level']))
                    <div class="small">Tingkat: {{ $e['level'] }}</div>
                @endif
            </div>
        @endforeach
    </div>
    <div class="hr"></div>
    @endif

    <!-- Bahasa -->
    @if(!empty($langData))
    <div class="section">
        <h2>Bahasa</h2>
        @foreach($langData as $l)
            <div class="item">
                <div class="label">{{ $l['language'] ?? '-' }}</div>
                <div class="small">Berbicara: {{ $l['speaking'] ?? '-' }}, Membaca: {{ $l['reading'] ?? '-' }}, Menulis: {{ $l['writing'] ?? '-' }}</div>
            </div>
        @endforeach
    </div>
    <div class="hr"></div>
    @endif

    <!-- Keterampilan Lain -->
    @if(!empty($kandidat->kemampuan))
    <div class="section">
        <h2>Keterampilan</h2>
        <div class="small">{{ $kandidat->kemampuan }}</div>
    </div>
    @endif

    <!-- Info tambahan: Tes (BMI / Buta Warna) -->
    @if($kandidat->bmi_score || $kandidat->blind_score)
    <div class="hr"></div>
    <div class="section">
        <h2>Hasil Tes</h2>
        @if($kandidat->bmi_score)
            <div class="small">BMI: {{ $kandidat->bmi_score }} (Kategori: {{ $kandidat->bmi_category ?? '-' }})</div>
        @endif
        @if($kandidat->blind_score)
            <div class="small">Tes Buta Warna: {{ (int)$kandidat->blind_score }}% ({{ $kandidat->blind_test_status ?? '' }})</div>
        @endif
    </div>
    @endif

    <!-- Informasi Spesifik -->
    @if(!empty($specData))
    <div class="hr"></div>
    <div class="section">
        <h2>Informasi Spesifik</h2>
        <div class="small">Pernah bekerja di perusahaan ini? {{ $specData['pernah'] ?? '-' }}</div>
        @if(($specData['pernah'] ?? '') === 'Ya' && !empty($specData['lokasi']))
            <div class="small">Lokasi: {{ $specData['lokasi'] }}</div>
        @endif
        @if(!empty($specData['info']))
            <div class="small">Sumber informasi pekerjaan: {{ $specData['info'] }}</div>
        @endif
    </div>
    @endif

    <!-- Dokumen Pendukung (tersedia/tidak) -->
    @php
        $docMap = [
            'KTP' => $kandidat->ktp_path ?? null,
            'Ijazah' => $kandidat->ijazah_path ?? null,
            'Sertifikat' => $kandidat->sertifikat_path ?? null,
            'Surat Pengalaman Kerja' => $kandidat->surat_pengalaman_path ?? null,
            'SKCK' => $kandidat->skck_path ?? null,
            'Surat Sehat' => $kandidat->surat_sehat_path ?? null,
        ];
        $hasDoc = collect($docMap)->filter()->isNotEmpty();
    @endphp
    @if($hasDoc)
    <div class="hr"></div>
    <div class="section">
        <h2>Dokumen Pendukung</h2>
        <ul class="list">
            @foreach($docMap as $label => $path)
                <li>{{ $label }}: {{ $path ? 'Tersedia' : 'Tidak ada' }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    @if(!empty($docImages))
    <div class="hr"></div>
    <div class="section">
        <h2>Lampiran Dokumen Pendukung</h2>
        @foreach($docImages as $label => $dataUri)
            <div class="item">
                <div class="small" style="margin-bottom:4px; font-weight:600;">{{ $label }}</div>
                <img src="{{ $dataUri }}" alt="{{ $label }}" style="max-width: 100%; max-height: 420px; object-fit: contain; border: 1px solid #eee; padding: 4px;">
            </div>
        @endforeach
    </div>
    @endif
</body>
</html>
