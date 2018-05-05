<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>User Not Active</title>
    <!-- Favicon-->

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="{{ asset('./css/app.css')}}" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="{{ asset('./css/waves.min.css')}}" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="{{ asset('./css/style.css')}}" rel="stylesheet">
</head>

<body class="four-zero-four">
    <div class="four-zero-four-container">
        <div class="error-code">403</div>
        <div class="error-message">User is Not Active, Contact the factory admin.</div>
        <br><br>
        <div class="error-message">Try Logging in next time when your status is active.</div>
        <div class="button-place">
            <a href="{{ route('logout') }}" class="btn btn-lg btn-info waves-effect" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </div>

    <!-- Jquery Core Js -->
    <script src="{{ asset('./js/jquery.min.js')}}"></script>

    <!-- Bootstrap Core Js -->
    <script src="{{ asset('./js/bootstrap1.min.js')}}"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="{{ asset('./js/waves.min.js')}}"></script>
</body>

</html>
