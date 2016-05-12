@extends('layouts.master')
@section('title', 'Verificar cuenta')

@section('content')
    <div class="container">
        <div class="initialDiv">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="text-center">Estás a un paso de registrarte</h1>
                </div>
            </div>
            <div class="row marginTop20">
                <div class="col-md-offset-2 col-md-8">
                    <p class="text-jusfity">
                        Te enviamos un correo electrónico a la dirección de email que nos proporcionaste, para
                        que confirmes tu alta a nuestro sistema, por favor revisa en tu bandeja de entrada o en tu
                        bandeja de correo no deseado (por si las dudas) y clickea el enlace para que tu cuenta sea activada.
                    </p>
                    <p class="text-center aviso-verifica-icon text-success marginTop20">
                        Revisa tu email<br><i class="fa fa-thumbs-o-up fa-lg"></i>
                    </p>
                </div>
            </div>
        </div>
    </div>
    @endsection

