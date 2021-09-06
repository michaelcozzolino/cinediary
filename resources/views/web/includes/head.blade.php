<head>

    <title>@yield('title')</title>

    <meta name="_token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">

    <!-- ===== Mobile viewport optimized ===== -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1.0, user-scalable=no">

    <!-- ===== Meta Tags - Description for Search Engine purposes ===== -->
    <meta name="description" content="Movify - Movies, Series & Cinema HTML Template">
    <meta name="keywords" content="movies, series, online streaming, html template, cinema html template">
    <meta name="author" content="GnoDesign">

    <link rel="stylesheet" type="text/css" href="{{ mix("css/app.css") }}">
    <!-- ===== Favicon & Different size apple touch icons ===== -->
    <link rel="shortcut icon" href="{{ asset("/images/favicon.png") }}" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset("/images/apple-touch-icon-iphone.png") }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset("/images/apple-touch-icon-ipad.png") }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset("/images/apple-touch-icon-iphone-retina.png") }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset("/images/apple-touch-icon-ipad-retina.png") }}">
    <link rel="apple-touch-icon" sizes="167x167" href="{{ asset("/images/apple-touch-icon-ipad-pro.png") }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset("/images/apple-touch-icon-iphone-6-plus.png") }}">
    <link rel="icon" sizes="192x192" href="{{ asset("/images/icon-hd.png") }}">
    <link rel="icon" sizes="128x128" href="{{ asset("/images/icon.png") }}">

    <!-- ===== Google Fonts ===== -->
    <link href="https://fonts.googleapis.com/css?family=Quicksand:300,400,500,700" rel="stylesheet">

    <!-- ===== CSS links ===== -->
    <link rel="stylesheet" type="text/css" href="{{ asset("css/bootstrap.min.css") }}">
    <link rel="stylesheet" type="text/css" href="{{ asset("revolution/css/settings.css") }}">
    <link rel="stylesheet" type="text/css" href="{{ asset("revolution/css/layers.css") }}">
    <link rel="stylesheet" type="text/css" href="{{ asset("revolution/css/navigation.css") }}">
    <link rel="stylesheet" type="text/css" href="{{ asset("css/magnific-popup.css") }}">
    <link rel="stylesheet" type="text/css" href="{{ asset("css/jquery.mmenu.css") }}">
    <link rel="stylesheet" type="text/css" href="{{ asset("css/owl.carousel.min.css") }}">

    <link rel="stylesheet" type="text/css" href="{{ asset("css/style.css") }}">
    <link rel="stylesheet" type="text/css" href="{{ asset("css/responsive.css") }}">


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->


    @yield('head')

</head>
