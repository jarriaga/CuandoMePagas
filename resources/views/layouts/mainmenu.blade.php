<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">Cuando Me Pagas?</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li @if(Request::is('/')) class="active" @endif ><a href="/">Home</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#contact">Contact</a></li>
                @if(!Auth::check())
                <li @if(Request::is('signup')) class="active" @endif><a href="{{URL::route('signup')}}">Registrate</a></li>
                <li @if(Request::is('login')) class="active" @endif><a href="{{URL::route('login')}}">Login</a></li>
                @else
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{Auth::user()->firstname}} <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{URL::route('profile',Auth::user()->username)}}"><i class="fa fa-user"></i> Mi Perfil</a></li>
                        <li><a href="{{URL::route('dashboard')}}"><i class="fa fa-futbol-o"></i> Dashboard </a></li>
                        <li><a href="{{URL::route('logout')}}"><i class="fa fa-power-off"></i> Logout </a></li>
                    </ul>
                </li>
                @endif
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>