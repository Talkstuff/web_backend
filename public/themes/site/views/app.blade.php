@extends('app.v1::layouts.master')

@section('app')
    <div class="uk-container-expand" style="padding-left: 0;padding-right: 0px; min-height: 100vh;">
        <div class="uk-grid-collapse uk-padding-remove " uk-grid>
            <div class="uk-width-1-6@m uk-visible@m uk-background-top-center bg-darkerGray"
                 style="min-height: 100vh;">

                <div class="app-sidebar-name-wrapper uk-text-center uk-width-1-1 bg-black">
                    D.L.T. Gold
                </div>

                <div class="uk-width-1-1 uk-margin-top">
                    <a href="/" target="_blank">
                        <div class="main_logo_wrapper uk-margin-auto bg-white">
                            <div class="uk-background-contain uk-height-1-1"
                                 style="background-image: url(/images/logo.png);"></div>
                        </div>
                    </a>
                </div>

                <ul class="uk-nav uk-nav-default uk-nav-parent-icon uk-margin-large-top app-menu" uk-nav>
                    @foreach(\Module::slugs() as $slug)
                        @includeIf('app.v1::' . 'extensions/' .  $slug)
                    @endforeach
                </ul>
            </div>

            <div class="uk-width-5-6@m bg-lighterGray" style="min-height: 100vh;">
                <nav class="uk-navbar-container uk-margin uk-margin-remove-bottom bg-white" uk-navbar>
                    <div class="uk-navbar-left">
                        <a class="uk-navbar-toggle uk-hidden@m fg-emerald fg-hover-amber"
                           href="#" uk-toggle="target: #offcanvas-nav">
                            <span uk-navbar-toggle-icon></span>
                            <span class="uk-navbar-item uk-logo uk-text-truncate" v-text="pageTitle"></span>
                        </a>
                        <span class="uk-navbar-item uk-logo uk-visible@m uk-text-truncate" v-text="pageTitle"></span>
                    </div>

                    <div class="uk-navbar-right">
                        <div class="uk-navbar-left uk-flex-1 nav-overlay" hidden>

                            <div class="uk-navbar-item uk-width-1-1">
                                <form class="uk-search uk-search-navbar uk-width-1-1">
                                    <input class="uk-search-input" type="search" placeholder="Search..." autofocus>
                                </form>
                            </div>

                            <a class="uk-navbar-toggle" uk-close uk-toggle="target: .nav-overlay; animation: uk-animation-fade" href="#"></a>

                        </div>
                        <ul class="uk-navbar-nav uk-visible@m" v-if="system.user">
                            <li>
                                <a href="#">
                                    Hello, @{{ system.user.account ? system.user.account.firstName : system.user.username }}
                                </a>
                                <div class="uk-navbar-dropdown uk-padding-remove uk-margin-remove">
                                    <ul class="uk-nav uk-navbar-dropdown-nav uk-margin-small-top">
                                        @stack('user_drop_down')
                                        <li class="uk-nav-divider"></li>
                                        <li class="bg-hover-crimson uk-padding-small">
                                            <a class="fg-hover-white" href="/security/logout">Logout</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
                <div class="uk-width-1-1 uk-margin-bottom">
                    <progress v-show="progressBarValue" id="progressbar" class="uk-progress"
                              :value="progressBarValue" :max="progressBarMax"></progress>
                </div>

                <div class="uk-container uk-margin-large-bottom " id="content">
                    <router-view></router-view>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('styles')
    <meta name="api-key" content="{{ auth()->user()->api_token }}" >

    <link rel="stylesheet" href="/vendors/gridster/jquery.gridster.min.css">
    <link rel="stylesheet" href="/vendors/qtip/jquery.qtip.min.css">

    <link rel="stylesheet" href="/vendors/bootstrap-datetimepicker-master/build/css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" href="/vendors/fontAwesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/build/app.min.css">
@endsection

@section('scripts')

    <script src="/vendors/gridster/jquery.gridster.min.js"></script>
    <script src="/vendors/qtip/jquery.qtip.min.js"></script>

    <script src="/vendors/cytoscape/cytoscape.min.js"></script>
    <script src="/vendors/dagre/dagre.min.js"></script>
    <script src="/vendors/dagre/cytoscape-dagre.js"></script>
    <script src="/vendors/qtip/cytoscape-qtip.js"></script>
    <script src="/vendors/accounting/accounting.min.js"></script>
    <script src="/build/run.min.js"></script>


@endsection