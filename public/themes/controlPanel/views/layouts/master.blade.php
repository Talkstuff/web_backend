<!DOCTYPE html>
<html>
<head>
    <title>{{config('app.name')}}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{csrf_token()}}" >
    <link rel="shortcut icon" type="image/x-icon" href="/shared/images/ts_favicon.jpg" />

    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400italic,600,700%7COpen+Sans:300,400,400italic,600,700">

    <!-- Bootstrap and OneUI CSS framework -->
    <link rel="stylesheet" href="/vendors/1ui/css/bootstrap.min.css">
    <link rel="stylesheet" id="css-main" href="/vendors/1ui/css/oneui.css">

    <link rel="stylesheet" href="/vendors/uikit/css/uikit.min.css" />

    <link rel="stylesheet" href="/vendors/metroui/metro.lite.css" />

    @yield('styles')
</head>
<body class="sidebar-l sidebar-o side-scroll header-navbar-fixed" style="min-height: 100vh;">
<div id="app">
    @yield('app')
    <div class="uk-container-expand uk-position-top uk-height-1-1 bg-white
    uk-flex uk-flex-middle uk-flex-around"
         v-if="loadingApp" style="min-height: 100vh;">
        <div class="uk-flex uk-flex-column">
            <div class="spinner">
                <div class="double-bounce1"></div>
                <div class="double-bounce2"></div>
            </div>
        </div>
    </div>
</div>
<script src="/vendors/1ui/js/core/jquery.min.js"></script>
<script src="/vendors/1ui/js/core/bootstrap.min.js"></script>
<script src="/vendors/1ui/js/core/jquery.slimscroll.min.js"></script>
<script src="/vendors/1ui/js/core/jquery.scrollLock.min.js"></script>
<script src="/vendors/1ui/js/core/jquery.appear.min.js"></script>
<script src="/vendors/1ui/js/core/jquery.countTo.min.js"></script>
<script src="/vendors/1ui/js/core/jquery.placeholder.min.js"></script>
<script src="/vendors/1ui/js/core/js.cookie.min.js"></script>
<script src="/vendors/1ui/js/app.js"></script>

<script src="/vendors/uikit/js/uikit.min.js"></script>
<script src="/vendors/uikit/js/uikit-icons.min.js"></script>
<script src="/vendors/moments/moment-with-locales.js"></script>

@yield('scripts')

</body>
</html>