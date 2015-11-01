@extends('layouts.master')
@section('title', 'Inicio')

@section('content')
<div class="container">
 <div class="initialDiv">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h2 class="titleColor">Ellos deben y no quieren pagar...<small>El buro de credito social</small></h2>
                    <br>
                    <div class="row">
                    <div class="col-md-offset-1 col-md-10">
                    <ul class="media-list">
                        @for($i=0;$i<10;$i++)
                        <li class="media" style="padding:20px;border-bottom:  1px solid #ccc;">
                            <div class="row">
                            <div class="col-md-4 col-sm-4">
                                <div class="text-center">
                                    <img class="img-responsive" style="margin: 0 auto;" src="https://scontent-dfw1-1.xx.fbcdn.net/hprofile-xft1/v/t1.0-1/p160x160/12039712_10207457489173453_464546216391109557_n.jpg?oh=4f6cea9fc696e05348fd3c7b0792ae04&oe=56C565A9">
                                </div>
                            </div>
                            <div class="col-md-8 col-sm-8">
                                <h3 class="media-heading firstNameList">Macaria Barron</h3>
                                    <div class="row">
                                        <div class="col-md-8">
                                        <p class="text-justify">
                                          Esta persona me debe casi 800 pesos por la venta de zapatillas,
                                        hasta ahora no me ha pagado nada
                                        </p>
                                        <p class="text-right">
                                            <a href="#">Leer historia completa...</a>
                                        </p>
                                        </div>
                                        <div class="col-md-4">
                                         <ul class="list-unstyled">
                                            <li><i class="fa fa-map-marker"></i> Mexico DF</li>
                                            <li><i class="fa fa-dollar"></i>Debe 800.00 MX</li>
                                            <li><i class="fa fa-calendar"></i>154 dias sin pagar</li>
                                            <li><i class="fa fa-eye"></i>453 vistas</li>
                                            <li><i class="fa  fa-comments-o"></i>23 Comentarios</li>
                                         </ul>
                                        </div>
                                    </div>


                            </div>
                            </div>
                            <p class="text-right marginTop-10"><small>Cuando le vas a pagar a: <a href="#">Enrique gonzales - Puebla</a></small></p>
                        </li>
                        @endfor
                    </ul>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
 </div>
</div>
@endsection

@section('angular')
<!-- Google Recaptcha 2.0-->
<!--    <script src="https://www.google.com/recaptcha/api.js?hl=es-419"></script> -->

    @include('layouts.angular')
@endsection