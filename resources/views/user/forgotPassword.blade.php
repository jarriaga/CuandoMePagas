@extends('layouts.master')
@section('title', 'Olvidaste tu password')

@section('content')
<div class="container">
 <div class="initialDiv">
    <div class="row">
        <div class="col-md-12">
            <h1 class="text-center"><i class="fa fa-binoculars"></i> Olvidaste tu password</h1>
        </div>
        <div class="col-md-offset-2 col-md-8">

        </div>
    </div>
    <div class="row marginTop-10">
        <div class="col-md-offset-3 col-md-6">
            <form class="form-horizontal marginTop-10" method="post" action="{{URL::route('forgotPageAction')}}">
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
                    <p class="marginTop20 marginBottom20">Ingresa tu email que usaste para registrarte y te enviaremos
                    las instrucciones para crear un nuevo password, si no encuentras tu correo, asegurate de
                    revisar tu badeja de spam.</p>
                    <label class="col-sm-2 control-label" for="formGroupInputLarge">Email</label>
                    <div class="col-sm-9">
                        <input class="form-control" type="text" id="formGroupInputLarge" name="email" placeholder="Tu correo electronico" value="{{ old('email') }}">
                    </div>
              </div>
              <div class="form-group form-group-lg marginTop20">
                <div class="col-sm-offset-3 col-sm-6">
				    <input class="form-control btn-success" onclick="smallModal('Cargando')" type="submit" value="Enviar">
			    </div>
			  </div>
            </form>
        </div>
    </div>
 </div>
</div>
@endsection

