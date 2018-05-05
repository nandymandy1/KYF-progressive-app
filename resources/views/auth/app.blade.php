<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Arvind App</title>
    <!--Favicon-->
    <link rel="shortcut icon" type="image/png" href="{{ asset('favicon.png')}}"/>
    <!-- Styles -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
    <!-- Bootstrap Core Css -->
    <link href="{{ asset('./css/bootstrap.min.css')}}" rel="stylesheet">
    <!--Materialize-->
    <link rel="stylesheet" href="{{ asset('./css/materialize.css')}}">
    <!-- Waves Effect Css -->
    <link href="{{ asset('./css/waves.min.css')}}" rel="stylesheet"/>
    <!-- Animation Css -->
    <link href="{{ asset('./css/animate.min.css')}}" rel="stylesheet"/>
    <!-- Custom Css -->
    <link href="{{ asset('./css/style.css')}}" rel="stylesheet">
    <link href="{{ asset('./css/font-awesome.min.css') }}" rel="stylesheet">
</head>
    @yield('content')
    <!-- Scripts -->
    <!-- Jquery Core Js -->
    <script src="{{ asset('./js/jquery.min.js')}}"></script>
    <!-- Bootstrap Core Js -->
    <script src="{{ asset('./js/bootstrap1.min.js')}}"></script>
    <!-- Waves Effect Plugin Js -->
    <script src="{{ asset('./js/waves.min.js')}}"></script>
    <!-- Validation Plugin Js -->
    <script src="{{ asset('./js/jquery.validate.js')}}"></script>
    <!-- Custom Js -->
    <script src="{{ asset('./js/admin.js')}}"></script>
    <script src="{{ asset('./js/particles.js')}}"></script>
    <script src="{{ asset('./js/particle.js')}}"></script>
    <script src="{{ asset('./js/sign-in.js')}}"></script>
    @yield('scripts')
</body>
</html>
