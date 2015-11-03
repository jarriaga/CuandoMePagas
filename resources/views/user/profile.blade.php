@extends('layouts.master')
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
                            @if(Auth::user() && Auth::user()->_id==$user_profile->_id)
                            <div class="row">
                                <div class="col-md-12">
                                <div class="bottomBorder">
                                    <h2 class="titleColor">Te deben lana? publicalo ya!!!</h2>
                                    <a href="#" class="btn btn-lg btn-primary">
                                        <i class="fa fa-gavel" style="color:#fff;"></i> Me deben
                                    </a>
                                </div>
                               </div>
                            </div>
                            @endif
                            <div class="row">
                                <div class="col-md-12">
                                    <h4 style="color:#999!important;font-weight: 400">Cuidado! ellos me deben dinero y no me han pagado</h4>
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