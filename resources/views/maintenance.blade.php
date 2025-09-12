<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="UTF-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <title>Multindo Job Portal</title>
	    <meta name="description" content="Job Listing Bootstrap 5 Template" />
	    <meta name="keywords" content="Onepage, creative, modern, bootstrap 5, multipurpose, clean, Job Listing, Job Board, Job, Job Portal" />
	    <meta name="author" content="Shreethemes" />
	    <meta name="website" content="https://shreethemes.in" />
	    <meta name="email" content="support@shreethemes.in" />
	    <meta name="version" content="1.0.0" />
	    <!-- favicon -->
        <link href="{{ asset('favicon.ico') }}" rel="shortcut icon">
		<!-- Bootstrap core CSS -->
	    <link href="{{ asset('css/bootstrap.min.css') }}" type="text/css" rel="stylesheet" />
        <link href="{{ asset('css/materialdesignicons.min.css') }}" rel="stylesheet" type="text/css" />
	    <!-- Custom  Css -->
	    <link href="{{ asset('css/style.min.css') }}" rel="stylesheet" type="text/css" id="theme-opt" />

    </head>

    <body>
        <section class="bg-home d-flex align-items-center" style="background: url('{{ asset('images/hero/bg2.jpg') }}') top;">
            <div class="bg-overlay bg-gradient-overlay"></div>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-12 text-center">
                        <img src="{{ asset('images/logo-icon-80-white.png') }}" alt="">
                        <h2 class="title-dark text-white text-uppercase mt-2 mb-4 fw-semibold">{{ __('We are back soon...') }}</h2>
                        <p class="text-white-50 para-desc para-dark mx-auto">{{ __('Find Jobs, Employment & Career Opportunities.') }}</p>
                    </div><!--end col-->
                </div><!--end row-->

                <div class="row">
                    <div class="col-md-12 text-center">
                        <div class="text-center">
                            <span id="maintenance" class="timer"></span><span class="d-block h6 text-uppercase text-white title-dark">{{ __('Minutes') }}</span>
                        </div>
                    </div>
                </div>

                {{-- <div class="row mt-4 pt-2">
                    <div class="col-12 text-center">
                        <div class="subscribe-form">
                            <form class="mx-auto" action="index.html">
                                <input name="email" id="email" type="email" class="rounded-pill bg-white" required="" placeholder="Your email :">
                                <button type="submit" class="btn btn-primary rounded-pill">Subscribe</button>
                            </form>
                        </div>
                    </div><!--end col-->
                </div><!--end row--> --}}
            </div>
        </section>

        <!-- javascript -->
        <script src="js/bootstrap.bundle.min.js"></script>
        <script src="js/feather.min.js"></script>
	    <!-- Custom -->
	    <script src="js/plugins.init.js"></script>
	    <script src="js/app.js"></script>

    </body>

</html>
