<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="author" content="talkstuff" />

    <!-- Stylesheets
    ============================================= -->
    <link href="http://fonts.googleapis.com/css?family=Lato:300,400,400italic,600,700|Raleway:300,400,500,600,700|Crete+Round:400italic" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="/vendors/canvas/css/bootstrap.css" type="text/css" />
    <link rel="stylesheet" href="/vendors/canvas/style.css" type="text/css" />
    <link rel="stylesheet" href="/vendors/canvas/css/dark.css" type="text/css" />
    <link rel="stylesheet" href="/vendors/canvas/css/font-icons.css" type="text/css" />
    <link rel="stylesheet" href="/vendors/canvas/css/animate.css" type="text/css" />
    <link rel="stylesheet" href="/vendors/canvas/css/magnific-popup.css" type="text/css" />

    <link rel="stylesheet" href="/vendors/canvas/css/responsive.css" type="text/css" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!--[if lt IE 9]>
    <script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
    <![endif]-->

    <!-- Document Title
    ============================================= -->
    <title>TalkStuff</title>

    <!-- Bootstrap and OneUI CSS framework -->
    <link rel="stylesheet" href="/vendors/uikit/css/uikit.min.css" />
    <link rel="stylesheet" href="/vendors/metroui/metro.lite.css" />

    <link rel="stylesheet" href="/build/site.min.css">
    @yield('styles')
</head>
<body class="bg-white" style="min-height: 100vh;">

@include('site::components.header')

@yield('page')

<script src="/vendors/jquery/jquery.min.js"></script>
<script src="/vendors/uikit/js/uikit.min.js"></script>
<script src="/vendors/uikit/js/uikit-icons.min.js"></script>
<script src="/vendors/moments/moment-with-locales.js"></script>
<script src="/vendors/bootstrap/js/bootstrap.js"></script>

@yield('scripts')

</body>
</html>