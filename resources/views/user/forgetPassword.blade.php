@extends('layouts.master')
@section('title', 'Olvidaste tu password')

@section('content')
<div class="container">
 <div class="initialDiv">
    <div class="row">
        <div class="col-md-12">
            <h2 class="text-center"><span class="glyphicon glyphicon-cloud"></span> Olvidaste tu password</h2>
        </div>
        <div class="col-md-offset-2 col-md-8">

        </div>
    </div>
    <div class="row marginTop-10">
        <div class="col-md-offset-3 col-md-6">
            <form class="form-horizontal marginTop-10" method="post" action="{{URL::route('postForgetPassword')}}">
                {!! csrf_field() !!}
                @if (count($errors) > 0)
                    <div class="row">
                        <div class="col-md-offset-2 col-md-8">
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif
              <div class="form-group form-group-lg">
                    <p class="marginTop-10">Ingresa tu email que usas para loguearte y te enviaremos
                    las instrucciones para recuperar tu password.</p>
                    <label class="col-sm-2 control-label" for="formGroupInputLarge">Email</label>
                    <div class="col-sm-9">
                        <input class="form-control" type="text" id="formGroupInputLarge" name="email" placeholder="Tu correo electronico" value="{{ old('email') }}">
                    </div>
              </div>
              <div class="form-group form-group-lg">
                <div class="col-sm-offset-3 col-sm-6">
				    <input class="form-control btn-success" onclick="smallModal('Cargando')" type="submit" value="Recuperar password">
			    </div>
			  </div>
            </form>
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