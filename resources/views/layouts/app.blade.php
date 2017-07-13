<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
        <script>
            window.csrfToken = "{{ csrf_token() }}";
        </script>
    </head>
    <body class="page-payment-info">
        <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="#">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        <!-- page structure -->
        <div class="container-fluid" id="app">
            <div class="row">
                <!-- modules -->
                <!-- header module -->
                <header class="header main-header">
                    <nav class="navbar navbar-default">
                        <div class="container-fluid">
                            <!-- Brand and toggle get grouped for better mobile display -->
                            <div class="navbar-header col-xs-12">
                                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-navbar-collapse" aria-expanded="false">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>

                                <div class="col-xs-6 col-sm-4">
                                    <a class="navbar-brand logo" href="{{ url('/') }}"><span></span></a>
                                </div>

                                <!-- Collect the nav links, forms, and other content for toggling -->
                                <div class="collapse navbar-collapse" id="main-navbar-collapse">
                                    <div class="col-xs-12 col-sm-3">
                                        <form class="navbar-form navbar-left">
                                            <div class="form-group search">
                                                <input type="text" name="s" id="inpSearch" class="search-input form-control" placeholder="Search">
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-xs-12 col-sm-5">
                                        <ul class="nav navbar-nav navbar-right">
                                            <li><a href="/video">Videos</a></li>
                                            <li><a href="#">$$$</a></li>
                                            <li><a href="#">World</a></li>
                                            <li><a href="#" class="btn-bg-blue">SS</a></li>
                                            <li><a href="#"><i class="fa fa-sliders txt-medium"></i></a></li>

                                            @if (Auth::guest())
                                                <li><a href="{{ route('login') }}">Login</a></li>
                                                <li><a href="{{ route('register') }}">Register</a></li>
                                            @else
                                                <li>
                                                    <a href="{{ route('logout') }}"
                                                       onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                                        Logout
                                                    </a>
                                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                        {{ csrf_field() }}
                                                    </form>
                                                </li>
                                            @endif

                                            <li><a href="/video/upload" class="btn btn-border-black">upload</a></li>
                                        </ul>
                                    </div>
                                </div><!-- /.navbar-collapse -->
                            </div>
                        </div><!-- /.container-fluid -->
                    </nav>
                </header>
                <!-- /header module -->

                @yield('content')

            </div>
        </div><!-- /page structure -->
    </body>
    <script type="text/javascript" src="{{ mix ('/js/manifest.js')}}"></script>
    <script type="text/javascript" src="{{ mix ('/js/vendor.js')}}"></script>
    <script type="text/javascript" src="{{ mix ('/js/app.js')}}"></script>
</html>