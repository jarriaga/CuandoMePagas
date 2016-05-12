<?php  use App\Http\Controllers\Auth\AuthMongoController as AuthMongo;  ?>
<!-- Fixed navbar -->
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">HotWheelsMX</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <?php if( AuthMongo::check() ){?>
                <li class=""><a href="#"><i class="fa fa-comment spaceIcon"></i>Mensajes</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Mi Cuenta <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="#"><i class="fa fa-user spaceIcon"></i>Mi Perfil</a></li>
                        <li><a href="{{ URL::route('coleccionPrivada') }}"><i class="fa fa-car spaceIcon"></i>Colección Privada</a></li>
                        <li><a href="#"><i class="fa fa-gavel spaceIcon"></i>Mis Subastas</a></li>
                        <li><a href="#"><i class="fa fa-hand-paper-o spaceIcon"></i>Mis Pujas</a></li>
                        <li role="separator" class="divider"></li>
                        <li class="dropdown-header">Movimientos</li>
                        <li><a href="#"><i class="fa fa-shopping-cart spaceIcon"></i> Mis Compras</a></li>
                        <li><a href="#"><i class="fa fa-money spaceIcon"></i> Mis Ventas</a></li>
                        <li role="separator" class="divider"></li>
                        <li class="dropdown-header">Configuración</li>
                        <li><a href="#"><i class="fa fa-gear spaceIcon"></i>Ajustes</a></li>
                        <li><a href="{{ URL::route('logout')  }}"><i class="fa fa-power-off spaceIcon"></i>Logout</a></li>
                    </ul>
                </li>
              <?php }else{ ?>

                <li><a href="#about">About</a></li>
                <li><a href="{{     URL::route('signUpPage')      }}">Registrate</a></li>
                <li><a href="{{     URL::route('logInPage')      }}">Login</a></li>

               <?php } ?>

            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>