@extends('layouts.master')
@section('title', 'Password Cambiado')

@section('content')
    <div class="container">
        <div class="initialDiv">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="text-center">Tu password se ha actualizado</h1>
                </div>
            </div>
            <div class="row marginTop20">
                <div class="col-md-offset-2 col-md-8">
                    <p class="text-jusfity">
                        Perfecto, tu password ha cambiado, por favor mantenlo seguro, desde este momento
                        ya puedes ingresar a tu cuenta con tu nuevo password.
                    </p>
                    <p class="text-center">
                        <a href="{{URL::route('logInPage')}}">Regresar a la pagina de login</a>
                    </p>
                    <p class="text-center aviso-verifica-icon text-success marginTop20">
                        <i class="fa fa-check fa-lg"></i>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection

