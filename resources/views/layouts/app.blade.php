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
        <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon"/>
        <script>
            window.csrfToken = "{{ csrf_token() }}";
        </script>
    </head>
    <body class="page-payment-info @if(Request::is('/')) home @endif">
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
                                    @yield('slogan')
                                    <div class="col-xs-12 col-sm-5 align-right">
                                        <ul class="nav navbar-nav navbar-right">

                                            @if (Auth::guest())
                                                <li><a href="{{ route('auth.login') }}">Login</a></li>
                                                <li><a @click.prevent="modal">Register</a></li>
                                            @else
                                                <li>
                                                    <a href="{{ route('auth.logout') }}"
                                                       onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                                        Logout
                                                    </a>
                                                    <form id="logout-form" action="{{ route('auth.logout') }}" method="POST" style="display: none;">
                                                        {{ csrf_field() }}
                                                    </form>
                                                </li>

                                                @if(auth()->user()->dropbox_token)
                                                    <li><a href="{{ route('profile.show', auth()->user()->slug) }}">Profile</a></li>
                                                @else
                                                    <li><a href="{{ route('profile') }}">Dashboard</a></li>
                                                @endif

                                                <li><a href="{{ route('files.upload') }}" class="btn btn-border-black">Upload</a></li>
                                            @endif

                                           

                                        </ul>
                                    </div>
                                </div><!-- /.navbar-collapse -->
                            </div>
                        </div><!-- /.container-fluid -->
                    </nav>
                </header>
                <!-- /header module -->

                @yield('content')
                            @if (Auth::guest())
                <modal-container :showmodal="regOptions.show">
                    <div slot="br">
                        <h1>Caro(a) amigo(a): <br/> Bem-vindo(a) ao FrontFiles</h1>
                        <p>
                            Você está prestes a acessar a versão Beta da Plataforma FrontFiles.
                            Tenha em mente que esta área está em construção pela comunidade de usuários e temos o enorme prazer de contar com a sua colaboração para ajudar a plataforma a melhorar sua performance.

                        </p>
                        <h2>FrontFiles é uma comunidade web global de jornalistas e midialivristas.</h2>
                        <p>
                            Ao tornar-se um FrontFiler você fará parte de um grupo mundial de pessoas empenhadas em construir um novo modelo de fornecimento de notícias e informações, produzidas pelos usuários e baseadas em imagens, vídeos e relatos. Através do trabalho colaborativo - compartilhamento de dados, tecnologia, equipamentos, alojamento, transporte, etc…
                        </p>
                        <h2>Visamos empoderar a comunidade e tornar nosso trabalho mais fácil e eficiente.</h2>
                        <p>
                            Ao vender seus arquivos de imagem, vídeo ou ilustração de uma forma rápida, simples e sem burocracia, o usuário se empodera financeiramente. Este é o começo de uma longa e poderosa viagem. Vamos fazê-la juntos.
                        </p>
                    </div>
                    <div slot="es">
                        <h1>Estimado amigo: <br/> Bienvenido a FrontFiles</h1>
                        <p>
                            Está a punto de ingresar a la versión Beta de la plataforma FrontFiles Tenga en cuenta que este área está en construcción por la comunidad de usuarios y estamos muy agradecidos por su ayuda para mejorar su calidad.

                        </p>
                        <h2>FrontFiles es una comunidad web global de periodistas y medios livres de comunicación.</h2>
                        <p>
                            Al convertirse en un FrontFiler, usted formará parte de un grupo mundial de personas comprometidas en construir un nuevo modelo de suministro de noticias e informaciones, producidas por los usuarios y basadas en imágenes, vídeos y relatos verdaderos, con efectiva confirmación de los hechos. A través del trabajo colaborativo - compartir datos, tecnologías, equipamientos, alojamiento, transporte, etc ...
                        </p>
                        <h2>Buscamos empoderar a la comunidad y hacer nuestro trabajo más fácil y eficiente.</h2>
                        <p>
                            Al vender sus archivos de imagen, vídeo o ilustración de una forma rápida, sencilla y sin burocracia, el usuario se empodera financieramente. Este es el comienzo de un largo y poderoso viaje. Vamos a hacerlo juntos.
                        </p>
                    </div>
                    <div slot="en">
                        <h1>Dear friend: <br />Welcome to FrontFiles</h1>
                        <p>
                            Thank you for joining us on this Beta version and Platform testing. Please note that this is a community work-in-progress area. We are very pleased that you are helping us to improve its quality.
                        </p>
                        <h2>FrontFiles is a global web-based community of free reporters and journalists.</h2>
                        <p>
                            By becoming a FrontFiler you will be part of a worldwide group of people committed to building a new model for news and information sourcing, produced by the users and based on true images, footage and reports and effective fact checking. By collaborating - sharing information, technology, equipment, lodging, transportation and more
                        </p>
                        <h2>We empower ourselves and make our jobs easier.</h2>
                        <p>
                            By selling our files in a way that’s fast, easy and free of bureaucracy, we find financial empowerment. This is the beginning of a long and powerful journey. Let’s do it together.
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
            </div>
            @yield('modals')
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