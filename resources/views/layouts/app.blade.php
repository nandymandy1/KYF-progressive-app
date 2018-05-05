<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--Favicon-->
    <link rel="shortcut icon" type="image/png" href="{{ asset('favicon.png')}}"/>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Arvind- KYF</title>
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('./css/materialize.css') }}">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('./css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('./css/materialize.css') }}">
    <!-- Animation Css -->
    <link href="{{ asset('./css/animate.min.css')}}" rel="stylesheet" />
    <link href="{{ asset('./css/style.css') }}" rel="stylesheet">
    <!-- Waves Effect Css -->
    <link href="{{ asset('./css/waves.min.css')}}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('./css/materialicon.css')}}">
    
    @yield('css')
</head>
<body>
    <div id="app">
        @include('layouts.partials.nav')
        <br><br>
        <main class="py-5">
          <div class="container">
            @include('layouts.partials.messages')
          </div>
            @yield('content')
        </main>
    </div>
    <!-- Scripts -->
    <script src="{{ asset('./js/jquery-3.2.1.slim.min.js') }}" charset="utf-8"></script>
    <script src="{{ asset('./js/popper.min.js') }}" charset="utf-8"></script>
    <script src="{{ asset('./js/bootstrap.min.js') }}" charset="utf-8"></script>
    <script src="{{ asset('./js/vue.js') }}" charset="utf-8"></script>
    <script src="{{ asset('./js/axios.js') }}" charset="utf-8"></script>
    <script src="{{ asset('./js/Chart.min.js')}}" charset="utf-8"></script>
    @yield('scripts')
</body>
</html>
