<!doctype html>
<html lang=""{{ str_replace('_', '-', app()->getLocale()) }}"">
	<head>
		<meta charset="UTF-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <title>Multindo Job Poral</title>
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
        <!-- Start -->
        <section class="position-relative bg-soft-primary">
            <div class="container">
                <div class="row">
                    <div class="col-12 p-0">
                        <div class="d-flex flex-column min-vh-100 justify-content-center px-md-5 py-5 px-4">
                            <div class="text-center">
                                <a href="index.html"><img src="{{ asset('images/logo-icon-64.png') }}" alt=""></a>
                            </div>
                            <div class="title-heading text-center my-auto">
                                <img src="{{ asset('images/error.png') }}" class="img-fluid" alt="">
                                <h3 class="text-dark text-uppercase mt-2 mb-4 fw-bold">{{ __('Page Not Found?') }}</h3>
                                <p class="text-muted para-desc mx-auto">{{ __('Whoops, this is embarassing. Looks like the page you were looking for wasn\'t found.') }}</p>

                                <div class="mt-4">
                                    <a href="index.html" class="btn btn-primary">{{ __('Back to Home') }}</a>
                                </div>
                            </div>
                            <div class="text-center">
                                <p class="mb-0 text-muted">© <script>document.write(new Date().getFullYear())</script> Jobnova. Design with <i class="mdi mdi-heart text-danger"></i> by <a href="https://shreethemes.in/" target="_blank" class="text-reset">Shreethemes</a>.</p>
                            </div>
                        </div>
                    </div><!--end col-->
                </div><!--end row-->
            </div><!--end container-->
        </section><!--end section-->
        <!-- End -->

        <!-- javascript -->
        <script src="js/bootstrap.bundle.min.js"></script>
        <script src="js/feather.min.js"></script>
	    <!-- Custom -->
	    <script src="js/plugins.init.js"></script>
	    <script src="js/app.js"></script>

    </body>

</html>
