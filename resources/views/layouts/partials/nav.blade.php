<nav class="navbar navbar-expand-md navbar navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand mx-auto" href="{{ url('/home') }}">
            Arvind-Kyf
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">

            </ul>
            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                    <li><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                    <li><a class="nav-link" href="{{ route('register') }}">Register</a></li>
                @else
                  @if (Auth::user()->job == 'master')
                    <li><a class="nav-link" href="/admin/factory/master/{{Auth::user()->factory_id}}">Dashboard</a></li>
                    <li><a class="nav-link" href="/master/cutting">Cutting</a></li>
                    <li><a class="nav-link" href="/master/sewing">Sewing</a></li>
                    <li><a class="nav-link" href="/master/finishing">Finishing</a></li>
                    <li><a class="nav-link" href="/master/quality">Quality</a></li>
                    <li><a class="nav-link" href="/master/general">General</a></li>
                    <li><a class="nav-link" href="/master/users/{{ Auth::user()->factory_id }}">Users</a></li>
                  @elseif (Auth::user()->type == 'admin' || Auth::user()->type == 'superadmin')
                    <li><a class="nav-link" href="/home">Factory</a></li>
                    <li><a class="nav-link" href="/admin/users">Factory Owners</a></li>
                    @if (Auth::user()->type == 'superadmin')
                      <li><a class="nav-link" href="/admin/getadmins">Admin Manager</a></li>
                    @endif
                  @endif
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
                <li><a class="nav-link" href="/merchandiser">Merchandiser</a></li>
                <li><a class="nav-link" href="/cutting/orders">Cutting Plan</a></li>
                <li><a class="nav-link" href="/sewingline">Sewing Line</a></li>
                <li><a class="nav-link" href="/finish/orders">Finishing Orders</a></li>
                <li><a class="nav-link" href="/quality/orders">Quality Orders</a></li>
            </ul>
        </div>
    </div>
</nav>
