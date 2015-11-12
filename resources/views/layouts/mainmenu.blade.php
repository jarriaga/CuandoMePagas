<div class="menuMobile">

</div>

<div class="headerLogo">
    <a href="/"><img  src="/images/logo-cuandomepagas.png"></a>
    <p class="mobileTextHeader"><strong>www.cuandomepagas.com</strong> - Tu buro de credito social</p>
    <div class="headerText">
        <h2>Ellos deben y no quieren pagar</h2>
        <small><strong>www.cuandomepagas.com</strong> - Tu buro de credito social</small>
    </div>
    <div class="btnMenuMobile" id="btnMenu"><i class="fa fa-bars"></i></div>
</div>

<nav class="navbar navbar-default ">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li @if(Request::is('/')) class="active" @endif ><a href="/"><span class="glyphicon glyphicon-home" aria-hidden="true"></span> Home</a></li>
                <li @if(Request::is('about')) class="active" @endif><a href="{{URL::route('about')}}"><span class="glyphicon glyphicon-info-sign"></span> Acerca de</a></li>
                @if(Auth::check())
                <li><a href="#"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Crea tu denuncia</a></li>
                @endif
                @if(!Auth::check())
                <li @if(Request::is('signup')) class="active" @endif><a href="{{URL::route('signup')}}"><span class="glyphicon glyphicon-hand-up"></span> Registrate</a></li>
                <li @if(Request::is('login')) class="active" @endif><a href="{{URL::route('login')}}"><span class="glyphicon glyphicon-user"></span> Login</a></li>
                @else
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{Auth::user()->firstname}} <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{URL::route('profile',Auth::user()->username)}}"><i class="fa fa-user"></i> Mi Perfil</a></li>
                        <li><a href="{{URL::route('logout')}}"><i class="fa fa-power-off"></i> Logout </a></li>
                    </ul>
                </li>
                @endif
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>