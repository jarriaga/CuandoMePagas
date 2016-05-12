@extends('layouts.master')
@section('title', 'Olvidaste tu password')

@section('content')
    <div class="container">
        <div class="initialDiv">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="text-center">Revisa tu Email</h1>
                </div>
            </div>
            <div class="row marginTop20">
                <div class="col-md-offset-2 col-md-8">
                    <p class="text-jusfity">
                        Te hemos enviado un correo electrónico, dentro encontraras un link único
                        que tu puedes usar para cambiar tu password, si el email no te ha llegado por
                        favor revisa tu bandeja de spam o junk mail.
                    </p>
                    <p class="text-center">
                        <a href="{{URL::route('logInPage')}}">Regresar a la pagina de login</a>
                    </p>
                    <p class="text-center aviso-verifica-icon text-success marginTop20">
                       <i class="fa fa-thumbs-o-up fa-lg"></i>
                    </p>
                </div>
            </div>
        </div>
    </div>
    @endsection

