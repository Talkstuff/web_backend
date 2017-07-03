@extends('controlPanel::layouts.master')

@section('app')
    <div id="page-container" class="sidebar-l sidebar-o side-scroll header-navbar-fixed">
        <!-- Sidebar -->
        <nav id="sidebar" class="">
            <!-- Sidebar Scroll Container -->
            <div id="sidebar-scroll">
                <!-- Sidebar Content -->
                <!-- Adding .sidebar-mini-hide to an element will hide it when the sidebar is in mini mode -->
                <div class="sidebar-content">
                    <!-- Side Header -->
                    <div class="side-header side-content bg-white uk-flex uk-flex-middle">
                        <!-- Layout API, functionality initialized in App() -> uiLayoutApi() -->
                        <button class="btn btn-link text-gray pull-right hidden-md hidden-lg"
                                type="button" data-toggle="layout" data-action="sidebar_close">
                            <i class="fa fa-times"></i>
                        </button>
                        <!-- Themes functionality initialized in App() -> uiHandleTheme() -->
                        <div class="btn-group pull-right ">
                            <button class="btn btn-link text-gray dropdown-toggle" data-toggle="dropdown" type="button">
                                <img src="/shared/images/tslogo1.png" alt="talkstuff" uk-cover>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right font-s13 sidebar-mini-hide">
                                <li>
                                    <a data-toggle="theme" data-theme="default" tabindex="-1" href="javascript:void(0)">
                                        <i class="fa fa-circle text-default pull-right"></i> <span class="font-w600">Default</span>
                                    </a>
                                </li>
                                <li>
                                    <a data-toggle="theme" data-theme="assets/css/themes/amethyst.min.css" tabindex="-1" href="javascript:void(0)">
                                        <i class="fa fa-circle text-amethyst pull-right"></i> <span class="font-w600">Amethyst</span>
                                    </a>
                                </li>
                                <li>
                                    <a data-toggle="theme" data-theme="assets/css/themes/city.min.css" tabindex="-1" href="javascript:void(0)">
                                        <i class="fa fa-circle text-city pull-right"></i> <span class="font-w600">City</span>
                                    </a>
                                </li>
                                <li>
                                    <a data-toggle="theme" data-theme="assets/css/themes/flat.min.css" tabindex="-1" href="javascript:void(0)">
                                        <i class="fa fa-circle text-flat pull-right"></i> <span class="font-w600">Flat</span>
                                    </a>
                                </li>
                                <li>
                                    <a data-toggle="theme" data-theme="assets/css/themes/modern.min.css" tabindex="-1" href="javascript:void(0)">
                                        <i class="fa fa-circle text-modern pull-right"></i> <span class="font-w600">Modern</span>
                                    </a>
                                </li>
                                <li>
                                    <a data-toggle="theme" data-theme="assets/css/themes/smooth.min.css" tabindex="-1" href="javascript:void(0)">
                                        <i class="fa fa-circle text-smooth pull-right"></i> <span class="font-w600">Smooth</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <a class="h5 fg-ts uk-text-lead uk-width-expand uk-link-reset" href="/" target="_blank">
                            talkstuff
                        </a>
                    </div>
                    <!-- END Side Header -->

                    <!-- Side Content -->
                    <div class="side-content">
                        <ul class="nav-main">
                            @foreach(\Module::slugs() as $slug)
                                @includeIf('controlPanel::' . 'extensions/' .  $slug)
                            @endforeach
                        </ul>
                    </div>
                    <!-- END Side Content -->
                </div>
                <!-- Sidebar Content -->
            </div>
            <!-- END Sidebar Scroll Container -->
        </nav>
        <!-- END Sidebar -->

        <!-- Header -->
        <header id="header-navbar" class="content-mini content-mini-full">
            <!-- Header Navigation Right -->
            <ul class="nav-header pull-right">
                <li>
                    <div class="btn-group">
                        <button class="btn btn-default dropdown-toggle" data-toggle="dropdown" type="button">
                            Hello, @{{ system.user ? system.user.fullName : '' }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-right">
                            @stack('user_drop_down')
                            <li class="divider"></li>
                            <li class="">
                                <a class="fg-hover-white bg-hover-crimson" href="/security/adminpanel/logout">Logout</a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
            <!-- END Header Navigation Right -->

            <!-- Header Navigation Left -->
            <ul class="nav-header pull-left">
                <li class="hidden-md hidden-lg">
                    <!-- Layout API, functionality initialized in App() -> uiLayoutApi() -->
                    <button class="btn btn-default" data-toggle="layout" data-action="sidebar_toggle" type="button">
                        <i class="fa fa-navicon"></i>
                    </button>
                </li>

                <li class="hidden-xs hidden-sm">
                    <!-- Layout API, functionality initialized in App() -> uiLayoutApi() -->
                    <button class="uk-button uk-button-default" data-toggle="layout"
                            data-action="sidebar_mini_toggle" type="button">
                        <i class="fa fa-ellipsis-v"></i>
                    </button>
                </li>
            </ul>
            <!-- END Header Navigation Left -->
        </header>
        <!-- END Header -->

        <!-- Main Container -->
        <main id="main-container">
            <!-- Page Header -->
            <div class="content bg-gray-lighter">
                <div class="row items-push">
                    <div class="col-sm-7">
                        <h1 class="page-heading" v-text="pageTitle"></h1>
                    </div>
                    <div class="col-sm-5 text-right hidden-xs">
                        <ol class="breadcrumb push-10-t"></ol>
                    </div>
                </div>
            </div>
            <!-- END Page Header -->

            <!-- Page Content -->
            <div class="content uk-container">
                <router-view></router-view>
            </div>
            <!-- END Page Content -->
        </main>
        <!-- END Main Container -->

        <!-- Footer -->
        <footer id="page-footer" class="content-mini content-mini-full font-s12 bg-gray-lighter clearfix">
            <div class="pull-right">

            </div>
            <div class="pull-left">
                <a class="font-w600" href="http://talkstuff.com" target="_blank">talkstuff</a> &copy; <span class="js-year-copy"></span>
            </div>
        </footer>
        <!-- END Footer -->
    </div>
    <!-- END Page Container -->

@endsection

@section('styles')
    <meta name="api-key" content="{{ auth()->user()->api_token }}" >

    <link rel="stylesheet" href="/vendors/bootstrap-datetimepicker-master/build/css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" href="/vendors/fontAwesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/build/app.min.css">

    <base href="/adminpanel/">
@endsection

@section('scripts')

    <script src="/themes/controlPanel/assets/js/run.min.js"></script>

@endsection