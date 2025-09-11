<!doctype html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <title>{{ $title }}</title>
	    <meta name="description" content="Job Portal Multindo Technology Utama" />
	    <meta name="keywords" content="mtu, MTU, Multindo, Multindo Technology Utama, Pekerjaan, Lowongan, Mining, Job Listing, Job Board, Job, Job Portal" />
	    <meta name="author" content="batiklegend" />
	    <meta name="website" content="https://career.multindo-technology.com" />
	    <meta name="email" content="it@multindo-technology.com" />
	    <meta name="version" content="1.0.0" />
	    <!-- favicon -->
        <link href="{{ asset('favicon.ico') }}" rel="shortcut icon">
        <!-- Bootstrap core CSS -->
	    <link href="{{ asset('css/bootstrap.min.css') }}" type="text/css" rel="stylesheet" />
        <link href="{{ asset('css/tobii.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('css/materialdesignicons.min.css') }}" rel="stylesheet" type="text/css" />
	    <!-- Custom  Css -->
	    <link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css" id="theme-opt" />
	    <style>
	        /* Alpine: hide cloaked elements until hydrated */
	        [x-cloak]{display:none!important}
	        .btn.btn-icon { display: inline-flex; align-items: center; justify-content: center; }
	        .btn.btn-icon .icons, .btn.btn-icon svg.icons { display: block; }
	        /* Remove dropdown caret in icon-only buttons for perfect centering */
	        .btn.btn-icon.dropdown-toggle::after { display: none; }
	        /* Ensure right icon group centers to header height */
	        #topnav .buy-button { height: 74px; line-height: initial !important; display: flex; align-items: center; gap: .5rem; }
	        #topnav .buy-button > li { display: flex; align-items: center; margin-bottom: 0; }
	        #topnav .buy-button .btn.btn-icon { width: 36px; height: 36px; padding: 0; }
	        /* Align menu items vertically */
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
	        /* Fine-tune vertical alignment of right icon buttons on desktop */
	        @media (min-width: 992px) {
	            #topnav .buy-button .btn.btn-icon { transform: translateY(4px); }
	            #topnav.nav-sticky .buy-button .btn.btn-icon { transform: translateY(2px); }
	        }
	    </style>
        @livewireStyles
	</head>
