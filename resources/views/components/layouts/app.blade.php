{{-- <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Job Portal') }}</title>
        <meta name="description" content="Job Portal Staging" />
        <meta name="keywords" content="Onepage, creative, modern, bootstrap 5, multipurpose, clean, Job Listing, Job Board, Job, Job Portal" />
        <meta name="author" content="batiklegend" />
        <meta name="version" content="1.0.0" />

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <link href="css/bootstrap.min.css" type="text/css" rel="stylesheet" />
        <link href="css/tobii.min.css" rel="stylesheet" type="text/css" />
        <link href="css/materialdesignicons.min.css" rel="stylesheet" type="text/css" />
        <!-- Custom  Css -->
        <link href="css/style.css" rel="stylesheet" type="text/css" id="theme-opt" />
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
        <style>
            .btn.btn-icon { display: inline-flex; align-items: center; justify-content: center; }
            .btn.btn-icon .icons, .btn.btn-icon svg.icons { display: block; }
            /* Remove dropdown caret in icon-only buttons for perfect centering */
            .btn.btn-icon.dropdown-toggle::after { display: none; }
            /* Align nav menu items vertically with icon buttons */
            #topnav .navigation-menu { display: flex; align-items: center; gap: .5rem; margin-bottom: 0; }
            #topnav .navigation-menu > li { display: flex; align-items: center; }
            #topnav .navigation-menu > li > a { display: flex; align-items: center; height: 36px; padding-top: 0; padding-bottom: 0; }
            #topnav .navigation-menu > li > .menu-arrow { align-self: center; }
            /* Align top-level caret with text, override theme absolute pos */
            #topnav .navigation-menu .has-submenu > .menu-arrow {
                position: static !important;
                right: auto; top: auto;
                display: inline-block;
                margin-left: .375rem;
                vertical-align: middle;
                align-self: center;
            }
            /* Make right icon group align to header height */
            #topnav .buy-button { height: 74px; line-height: initial !important; display: flex; align-items: center; gap: .5rem; }
            #topnav .buy-button > li { display: flex; align-items: center; }
            #topnav .buy-button .btn.btn-icon { width: 36px; height: 36px; padding: 0; }
            /* Fine-tune vertical alignment of right icon buttons on desktop */
            @media (min-width: 992px) {
                #topnav .buy-button .btn.btn-icon { transform: translateY(4px); }
                #topnav.nav-sticky .buy-button .btn.btn-icon { transform: translateY(2px); }
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <x-banner />

        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @livewire('navigation-menu')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        @stack('modals')

        @livewireScripts
    </body>
</html> --}}

<!doctype html>
<html lang="{{  str_replace('_', '-', app()->getLocale()) }}">
	<head>
        @livewireStyles
		<meta charset="UTF-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <title>{{ config('app.name', 'Job Portal') }}</title>
	    <meta name="description" content="Job Listing Bootstrap 5 Template" />
	    <meta name="keywords" content="Onepage, creative, modern, bootstrap 5, multipurpose, clean, Job Listing, Job Board, Job, Job Portal" />
	    <meta name="author" content="Shreethemes" />
	    <meta name="website" content="https://shreethemes.in" />
	    <meta name="email" content="support@shreethemes.in" />
	    <meta name="version" content="1.0.0" />
	    <!-- favicon -->
        <link href="{{ asset('images/favicon.ico') }}" rel="shortcut icon">
		<!-- Bootstrap core CSS -->
	    <link href="{{ asset('css/bootstrap.min.css') }}" type="text/css" rel="stylesheet" />
        <link href="{{ asset('css/tobii.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('css/materialdesignicons.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- Custom  Css -->
        <link href="{{ asset('css/style.min.css') }}" rel="stylesheet" type="text/css" id="theme-opt" />
        <!-- Overrides / additions -->
        <link href="{{ asset('css/style.css') }}?v=1" rel="stylesheet" type="text/css" />
        @stack('styles')
	</head>

	<body>
        <!-- Navbar STart -->
        <header id="topnav" class="defaultscroll sticky">
            <div class="container">
                <a class="logo" href="index.html">
                    <span class="logo-light-mode">
                        <img src="images/logo-dark.png" class="l-dark" alt="">
                        <img src="images/logo-light.png" class="l-light" alt="">
                    </span>
                    <img src="images/logo-light.png" class="logo-dark-mode" alt="">
                </a>

                <!-- Removed hamburger toggle -->

                <ul class="buy-button list-inline mb-0 d-flex align-items-center gap-2">
                    @auth
                    <li class="list-inline-item ps-1 mb-0 align-middle">
                        @php
                            $user = auth()->user();
                            $firstName = optional($user->kandidat)->nama_depan ?? \Illuminate\Support\Str::before($user->name ?? '', ' ');
                            $isOfficer = $user->is_officer;
                            $badgeClass = $isOfficer ? $user->role_badge_class : 'bg-soft-success text-success';
                            $icon = $isOfficer ? 'shield' : 'user';
                            $label = $isOfficer ? $user->role_badge_label : null; // hide role label for kandidat
                        @endphp
                        <div class="dropdown role-dropdown d-inline-flex align-items-center">
                            <a href="#" class="dropdown-toggle badge rounded-pill {{ $badgeClass }} px-3 py-2 d-inline-flex align-items-center role-badge-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="mdi {{ $isOfficer ? 'mdi-shield-outline' : 'mdi-account-outline' }} me-1 align-middle"></i>
                                <span class="fw-semibold">{{ $firstName }}</span>
                                @if($label)
                                    <span class="mx-1">-</span>
                                    <span>{{ $label }}</span>
                                @endif
                                <i class="mdi mdi-chevron-down ms-1"></i>
                            </a>
                            <div class="dropdown-menu dd-menu dropdown-menu-end bg-white rounded shadow border-0 mt-3">
                                <a href="{{ auth()->user()->is_kandidat ? route('profile.show') : route('officers.index') }}" class="dropdown-item fw-medium fs-6 d-flex align-items-center">
                                    <i class="mdi mdi-account-outline me-2 align-middle"></i>
                                    <span>Profile</span>
                                </a>
                                <div class="dropdown-divider border-top"></div>
                                <form method="POST" action="{{ route('logout') }}" x-data class="d-inline w-100">
                                    @csrf
                                    <button type="submit" class="dropdown-item fw-medium fs-6 d-flex align-items-center w-100 text-start border-0"
                                            onclick="event.preventDefault(); this.closest('form').submit();">
                                        <i class="mdi mdi-logout me-2 align-middle"></i>Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </li>
                    @endauth
                    @guest
                    <li class="list-inline-item ps-1 mb-0">
                        <a href="javascript:void(0)" class="btn btn-sm btn-soft-primary d-inline-flex align-items-center" data-bs-toggle="modal" data-bs-target="#guestAuthModal" title="Masuk" aria-label="Login">
                            <i class="mdi mdi-login me-1"></i>
                            Login
                        </a>
                    </li>
                    @endguest
                </ul>

                @include('partials.navbar-menu')
            </div>
        </header>
        <!-- Navbar End -->

        @guest
        <!-- Guest Auth Modal -->
        <div class="modal fade" id="guestAuthModal" tabindex="-1" aria-labelledby="guestAuthModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="guestAuthModalLabel">Masuk atau Tes Awal</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="mb-2 fw-semibold">Apakah Anda sudah punya akun?</p>
                        <p class="text-muted mb-0">Jika belum, Anda diwajibkan menyelesaikan Blind Test dan BMI Test terlebih dahulu sebelum mendaftar.</p>
                    </div>
                    <div class="modal-footer d-flex gap-2">
                        <a href="{{ route('dashboard') }}?start_test=1" class="btn btn-primary flex-fill">
                            <i class="mdi mdi-clipboard-text-outline me-1"></i> Mulai Tes (Blind & BMI)
                        </a>
                        <a href="{{ route('login') }}" class="btn btn-soft-primary flex-fill">
                            <i class="mdi mdi-login me-1"></i> Saya sudah punya akun
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endguest

        {{ $slot }}

        

        <!-- Footer Start -->
        @include('partials.footer')
        {{-- legacy footer below; kept for reference
        <footer class="bg-footer">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="py-5">
                            <div class="row align-items-center">
                                <div class="col-sm-3">
                                    <div class="text-center text-sm-start">
                                        <a href=""><img src="images/logo-light.png" alt=""></a>
                                    </div>
                                </div>

                                <div class="col-sm-9 mt-4 mt-sm-0">
                                    <ul class="list-unstyled footer-list terms-service text-center text-sm-end mb-0">
                                        <li class="list-inline-item my-2"><a href="index.html" class="text-foot fs-6 fw-medium me-2"><i class="mdi mdi-circle-small"></i> Home</a></li>
                                        <li class="list-inline-item my-2"><a href="services.html" class="text-foot fs-6 fw-medium me-2"><i class="mdi mdi-circle-small"></i> How it works</a></li>
                                        <li class="list-inline-item my-2"><a href="job-post.html" class="text-foot fs-6 fw-medium me-2"><i class="mdi mdi-circle-small"></i> Create a job</a></li>
                                        <li class="list-inline-item my-2"><a href="aboutus.html" class="text-foot fs-6 fw-medium me-2"><i class="mdi mdi-circle-small"></i> About us</a></li>
                                        <li class="list-inline-item my-2"><a href="pricing.html" class="text-foot fs-6 fw-medium"><i class="mdi mdi-circle-small"></i> Plans</a></li>
                                    </ul>
                                </div><!--end col-->
                            </div><!--end row-->
                        </div>
                    </div><!--end col-->
                </div><!--end row-->
            </div><!--end container-->


        <div class="py-4 footer-bar">
                <div class="container text-center">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <div class="text-sm-start">
                                <p class="mb-0 fw-medium">© <script>document.write(new Date().getFullYear())</script> Jobnova. Design with <i class="mdi mdi-heart text-danger"></i> by <a href="https://shreethemes.in/" target="_blank" class="text-reset">Shreethemes</a>.</p>
                            </div>
                        </div>

                        <div class="col-sm-6 mt-4 mt-sm-0 pt-2 pt-sm-0">
                            <ul class="list-unstyled social-icon foot-social-icon text-sm-end mb-0">
                                <li class="list-inline-item"><a href="https://1.envato.market/jobnova" target="_blank" class="rounded"><i data-feather="shopping-cart" class="fea icon-sm align-middle" title="Buy Now"></i></a></li>
                                <li class="list-inline-item"><a href="https://dribbble.com/shreethemes" target="_blank" class="rounded"><i data-feather="dribbble" class="fea icon-sm align-middle" title="dribbble"></i></a></li>
                                <li class="list-inline-item"><a href="http://linkedin.com/company/shreethemes" target="_blank" class="rounded"><i data-feather="linkedin" class="fea icon-sm align-middle" title="Linkedin"></i></a></li>
                                <li class="list-inline-item"><a href="https://www.facebook.com/shreethemes" target="_blank" class="rounded"><i data-feather="facebook" class="fea icon-sm align-middle" title="facebook"></i></a></li>
                                <li class="list-inline-item"><a href="https://www.instagram.com/shreethemes/" target="_blank" class="rounded"><i data-feather="instagram" class="fea icon-sm align-middle" title="instagram"></i></a></li>
                                <li class="list-inline-item"><a href="https://twitter.com/shreethemes" target="_blank" class="rounded"><i data-feather="twitter" class="fea icon-sm align-middle" title="twitter"></i></a></li>
                            </ul><!--end icon-->
                        </div><!--end col-->
                    </div><!--end row-->
                </div><!--end container-->
            </div>
        </footer><!--end footer--> --}}
        <!-- Footer End -->

        <!-- Back to top -->
        <a href="#" onclick="topFunction()" id="back-to-top" class="back-to-top rounded fs-5"><i data-feather="arrow-up" class="fea icon-sm align-middle"></i></a>
        <!-- Back to top -->

        <!-- JAVASCRIPTS -->
	    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('js/tobii.min.js') }}"></script>
        <script src="{{ asset('js/feather.min.js') }}"></script>
	    <!-- Custom -->
	    <script src="{{ asset('js/plugins.init.js') }}"></script>
	    <script src="{{ asset('js/app.js') }}"></script>
        @stack('scripts')
        @livewireScripts
    </body>
</html>
