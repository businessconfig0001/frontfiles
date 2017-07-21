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
        <link rel="stylesheet" href="{{ url('/css/app.css') }}">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
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
                                <div class="mobile-nav">
                                    
                                </div>
                                <div class="col-xs-6 col-sm-4">
                                    <a class="navbar-brand logo" href="{{ url('/') }}"><span></span></a>
                                </div>

                                <!-- Collect the nav links, forms, and other content for toggling -->
                                <div class="collapse navbar-collapse header-content" id="main-navbar-collapse">
                                    <div class="col-xs-12 col-sm-3">
                                        <h2 class="text-blue sub-title">The Global Platform for Independent Journalism</h2>
                                    </div>
                                    <div class="col-xs-12 col-sm-5">
                                        <ul class="nav navbar-nav navbar-right">
                                            

                                            @if (Auth::guest())
                                                <li><a href="{{ route('auth.login') }}">Login</a></li>
                                            @else
                                                <li><a href="{{ route('files') }}">Files</a></li>
                                                <li>
                                                    <a href="{{ route('auth.logout') }}"
                                                       onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                                        Logout
                                                    </a>
                                                    <form id="logout-form" action="{{ route('auth.logout') }}" method="POST" style="display: none;">
                                                        {{ csrf_field() }}
                                                    </form>
                                                </li>
                                            @endif

                                            <li><a href="{{ route('files.upload') }}" class="btn btn-border-black">Upload</a></li>
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
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
        ga('create', 'UA-102556173-1', 'auto');
        ga('send', 'pageview');
    </script>
</html>