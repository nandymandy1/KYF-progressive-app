<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Arvind- KYF</title>
        <!--Favicon-->
        <link rel="shortcut icon" type="image/png" href="{{ asset('favicon.png')}}"/>
        <!-- Fonts -->
        <link rel="stylesheet" media="screen" href="{{ asset('./css/particle.css') }}">
        <link rel="stylesheet" href="{{ asset('./css/materialize.css') }}">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('./css/font-awesome.min.css') }}">
        <!-- Animation Css -->
        <link href="{{ asset('./css/animate/min.css')}}" rel="stylesheet" />
        <link href="{{ asset('./css/style.css') }}" rel="stylesheet">
        <!-- Waves Effect Css -->
        <link href="{{ asset('./css/waves.min.css')}}" rel="stylesheet" />
    </head>
    <body>
      <!-- particles.js container -->
      <div id="particles-js">
        <nav class="navbar navbar-expand-md navbar navbar-dark bg-dark fixed-top">
            <div class="container">
                <div class="container text-center logo">
                  <a class="navbar-brand mx-auto" href="{{ url('/home') }}">
                      <b>Arvind-KYF</b>
                  </a>
                </div>
                <button class="navbar-toggler pull-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @if (Route::has('login'))
                                @auth
                                    <a class="nav-link" href="{{ url('/home') }}">Home</a>
                                @else
                                    <a class="nav-link" href="{{ route('login') }}">Login</a>
                                    <a class="nav-link" href="{{ route('register') }}">Register</a>
                                @endauth
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
        <br><br><br><br><br>
        <div class="container">
          <div class="pull-right">
            <img src="{{ asset('logo.png')}}" alt="Arvind Automate" height="70px">
          </div>
        </div>
      </div><!-- Particle js DIV -->
      <script src="{{ asset('./js/jquery-3.2.1.slim.min.js')}}" charset="utf-8"></script>
      <script src="{{ asset('./js/popper.min.js')}}" charset="utf-8"></script>
      <script src="{{ asset('./js/bootstrap.min.js') }}" charset="utf-8"></script>
      <script src="{{ asset('./js/particles.js')}}"></script>
      <script src="{{ asset('./js/particle.js')}}"></script>
    </body>
</html>
