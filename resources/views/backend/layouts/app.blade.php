<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>FrontFiles - Backend</title>
    <meta name="description" content="FF is an open, collaborative network platform of media activists, freelance journalists & witness citizens.">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ url('/css/backend/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ url('/css/backend/app.css') }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon"/>
    <script>
        window.csrfToken = "{{ csrf_token() }}";
    </script>

</head>
<body>

    <div id="app">

        @include('backend.layouts.nav')

        @yield('content')

    </div>

</body>
<script type="text/javascript" src="{{ asset('/js/backend/bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('/js/backend/app.js')}}"></script>
</html>