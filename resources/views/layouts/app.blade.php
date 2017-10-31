<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>FrontFiles</title>
        <meta name="description" content="FF is an open, collaborative network platform of media activists, freelance journalists & witness citizens.">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="{{ url('/css/app.css') }}">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon"/>
        <script>
            window.csrfToken = "{{ csrf_token() }}";
        </script>

        @yield('fb-data')

    </head>
    <body class="page-payment-info @if(Request::is('/')) home @endif">
    <div id="fb-root"></div>
        <script>(function(d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) return;
                js = d.createElement(s); js.id = id;
                js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.10&appId=1961404364145131';
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));</script>
        <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="#">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        <!-- page structure -->
        <div class="container-fluid" id="app" v-cloak>
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
                                    @yield('slogan')
                                    <div class="col-xs-12 col-sm-5 align-right">
                                        <ul class="nav navbar-nav navbar-right">

                                            @if (Auth::guest())
                                                <li><a href="{{ route('login') }}">Login</a></li>
                                                <li><a @click.prevent="modal">Register</a></li>
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

                                                @if(auth()->user()->dropbox_token)
                                                    <li><a href="{{ route('profile.show', auth()->user()->slug) }}">Profile</a></li>
                                                @else
                                                    <li><a href="{{ route('profile') }}">Dashboard</a></li>
                                                @endif

                                                <li><a href="{{ route('files.upload') }}" class="btn btn-border-black">Upload</a></li>

                                                @if(auth()->user()->isAdmin())
                                                    <li><a href="{{ route('backend') }}">Administration</a></li>
                                                @endif

                                            @endif

                                        </ul>
                                    </div>
                                </div><!-- /.navbar-collapse -->
                            </div>
                        </div><!-- /.container-fluid -->
                    </nav>
                </header>
                <div class="row loader">
                    <div class="sk-fading-circle">
                      <div class="sk-circle1 sk-circle"></div>
                      <div class="sk-circle2 sk-circle"></div>
                      <div class="sk-circle3 sk-circle"></div>
                      <div class="sk-circle4 sk-circle"></div>
                      <div class="sk-circle5 sk-circle"></div>
                      <div class="sk-circle6 sk-circle"></div>
                      <div class="sk-circle7 sk-circle"></div>
                      <div class="sk-circle8 sk-circle"></div>
                      <div class="sk-circle9 sk-circle"></div>
                      <div class="sk-circle10 sk-circle"></div>
                      <div class="sk-circle11 sk-circle"></div>
                      <div class="sk-circle12 sk-circle"></div>
                    </div>
                </div>
                <!-- /header module -->
                <div class="row loaded-content">
                        @yield('content')
                         @if (Auth::guest())
                                <modal-container :showmodal="regOptions.show">
                                    <div slot="br">
                                        <h1>Olá! <br/> Ainda estamos a trabalhar árduamente na nossa potente plataforma.</h1>
                                        <p>
                                            A FF estará disponível para todo o mundo brevemente.
                                            Por agora estamos a testar algumas funcionalidades com um grupo restrito de utilizadores.
                                        </p>
                                        <P>
                                            Se você quiser tornar-se um FrontFiles Pioneer e juntar-se a nós nesta fase de testes, envie-nos um pedido para pioneers@frontfiles.com e conte-nos um pouco sobre você.
                                            Sinta-se à vontade para fazer perguntas sobre a plataforma FrontFiles.
                                        </p>
                                        <p>
                                            Muito obrigado!
                                            Até breve.
                                        </p>
                                    </div>
                                    <div slot="es">
                                        <h1>¡Hola! <br/> Estamos trabajando duro en nuestra plataforma.</h1>
                                        <p>
                                            FF estará disponible para todo el mundo muy pronto.
                                            Por ahora estamos probando algunas funcionalidades con algunos usuarios seleccionados.
                                        </p>
                                        <P>
                                            Si también quieres ser uno de nuestros pioneros y juntarte a nuestro programa Beta envianos por favor un email para pioneers@frontfiles.com con una pequeña presentación sobre ti.
                                            Si por otro lado, quieres preguntarnos algo sobre nuestra plataforma no dudes en contactarnos también
                                        </p>
                                        <p>
                                            ¡Muchas gracias!
                                            Hasta pronto.
                                        </p>
                                    </div>
                                    <div slot="en">
                                        <h1>Hi! <br /> We are still working hard on our powerful platform. </h1>
                                        <p>
                                            FF will be world wide available very soon.
                                            For now, we are testing some functionalities with selected users only.
                                        </p>
                                        <P>
                                            If you want to become a FrontFiles Pioneer and join us on the system testing, please send us a request to pioneers@frontfiles.com, and let us know a little about yourself.
                                            Also, feel free to ask questions about the FrontFiles platform.
                                        </p>
                                        <p>
                                            Thank you very much!
                                            See you soon.
                                        </p>    
                                       <!--
                                        <h2>Ups! You should be part of our beta program.</h2>
                                        <p>
                                           Send an email to <a :href="'mailto:info@frontfiles.com'">info@frontfiles.com</a>. Our team will notify you as soon the platform is open for everyone.
                                        </p>
                                        -->
                                    </div>
                               </modal-container>
                    @endif
                    @yield('modals')
                </div>
                
        </div><!-- /page structure -->
    </body>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA7eCQwmRXS72DyZ5WwSmKS6DIT85Qwu8E&libraries=places"></script>
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
    @yield('scripts')
</html>