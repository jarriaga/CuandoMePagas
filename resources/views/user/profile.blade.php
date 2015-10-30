@extends('...layouts.master')
@section('title', 'Perfil')

@section('content')
<div class="container">
    <div class="initialDiv">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="col-md-3">
                            <div class="img-profile text-center">
                                @if(isset($user_profile))
                                    <img class="img-responsive img-thumbnail" src="http://graph.facebook.com/{{$user_profile->facebook_id}}/picture?width=200&height=200">
                                @endif
                            </div>
                            <h2>{{$user_profile->firstname}}</h2>
                            <h4>{{$user_profile->username}}</h4>
                            <p>Miembro desde el {{ $user_profile->dates['createAt']->toDateTime()->format('d \d\e M Y ')}}</p>

                        </div>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-12">
                                    <h3 class="titleColor">Estadisticas como jugador</h3>

                                    <table class="table">
                                        <tr>
                                            <td>Goles: 68</td>
                                            <td>Tarjetas amarillas: 12</td>
                                        </tr>
                                        <tr>
                                            <td>Tarjetas rojas: 4</td>
                                            <td>Fuera de juego: 20</td>
                                        </tr>
                                        <tr>

                                            <td>Partidos disputados: 22</td>
                                            <td>Mas datos: 10</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <h3 class="titleColor">Jugando en los equipos</h3>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-2 col-sm-2 col-xs-3">
                                            <a href="#" class="thumbnail">
                                                <img src="http://icons.iconarchive.com/icons/giannis-zographos/german-football-club/256/Borussia-Dortmund-icon.png">
                                            </a>
                                        </div>
                                        <div class="col-md-2 col-sm-2 col-xs-3">
                                            <a href="#" class="thumbnail">
                                                <img src="http://e1.365dm.com/football/badges/128/880.png">
                                            </a>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <h3 class="titleColor">Participando en los siguientes torneos</h3>
                                    <hr>
                                    <p><a href="#"><i class="fa fa-circle-thin colorPrimary" ></i>  Torneo verano 2016 </a></p>
                                    <p><a href="#"><i class="fa fa-circle-thin colorPrimary" ></i>  Torneo Los amigos  2016</a> </p>
                                    <p><a href="#"><i class="fa fa-circle-thin colorPrimary" ></i>  Fall season North Dallas</a> </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <h3 class="titleColor">Administrador del torneo</h3>
                                    <hr>
                                </div>
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