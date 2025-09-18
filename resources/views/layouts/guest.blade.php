<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="UTF-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
	    @php
	            $brand = 'Job Portal MTU';
            $routeName = \Illuminate\Support\Facades\Route::currentRouteName();
            $map = [
                'dashboard' => 'Dashboard',
                'jobs.browse' => 'Jobs',
                'kandidat.lowongan-dilamar' => 'Lowongan Dilamar',
                'cbt.dashboard' => 'Tes Seleksi',
                'profile.show' => 'Profil',
                'officers.index' => 'Officers',
                'Lowongan.Index' => 'Lowongan',
                'kategori-lowongan.Index' => 'Kategori Lowongan',
                'kandidat.index' => 'Data Kandidat',
                'lamaran-lowongan.index' => 'Lamaran',
                'jadwal-interview.index' => 'Jadwal Interview',
                'test-results.index' => 'Hasil Psikotes',
                'bank-soal.index' => 'Bank Soal',
                'kategori-soal.index' => 'Kategori Soal',
                'login' => 'Login',
                'register' => 'Register',
                'password.request' => 'Reset Password',
                'password.reset' => 'Reset Password',
                'verification.notice' => 'Verify Email',
            ];
            $defaultTitle = $map[$routeName] ?? \Illuminate\Support\Str::title(str_replace(['.', '-'], ' ', (string) $routeName));
        @endphp
	    <title>{{ $brand }}@hasSection('title') - @yield('title') @elseif(!empty($defaultTitle)) - {{ $defaultTitle }} @endif</title>
	    <meta name="description" content="Job Listing Bootstrap 5 Template" />
	    <meta name="keywords" content="Onepage, creative, modern, bootstrap 5, multipurpose, clean, Job Listing, Job Board, Job, Job Portal" />
	    <meta name="author" content="Shreethemes" />
	    <meta name="website" content="https://shreethemes.in" />
	    <meta name="email" content="support@shreethemes.in" />
	    <meta name="version" content="1.0.0" />
	    <!-- favicon -->
        <link href={{ asset('favicon.ico') }} rel="shortcut icon">
		<!-- Bootstrap core CSS -->
        {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
	    <link href="{{ asset('css/bootstrap.min.css') }}" type="text/css" rel="stylesheet" />
        <link href="{{ asset('css/materialdesignicons.min.css') }}" rel="stylesheet" type="text/css" />
	    <!-- Custom  Css -->
	    <link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css" id="theme-opt" />
        @livewireStyles
    </head>
    <body>
        {{ $slot }}

        @livewireScripts
        <!-- Scripts -->
        <!-- javascript -->
        <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('js/feather.min.js') }}"></script>
	    <!-- Custom -->
	    <script src="{{ asset('js/plugins.init.js') }}"></script>
	    <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>
