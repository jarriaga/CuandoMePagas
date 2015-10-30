@extends('layouts.master')
@section('title', 'Tu nuevo password')

@section('content')
<div class="container">
 <div class="initialDiv">
    <div class="row">
        <div class="col-md-12">
            <h1 class="text-center">Nuevo password</h1>
        </div>
    </div>
     <div class="row marginTop-10">
        <div class="col-md-offset-2 col-md-8">
        <p class="text-center">
            Tu correo de tener mas de 6 caracteres
        </p>
            <form class="form-horizontal marginTop-10" method="post" action="{{URL::route('postResetPassword')}}">
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
                    <label class="col-sm-4 control-label" for="formGroupInputLarge">Tu nuevo password</label>
                    <div class="col-sm-6">
                        <input class="form-control" type="password" name="password" id="formGroupInputLarge" placeholder="Ingresa un Password" value="{{ old('password') }}">
                    </div>
               </div>
               <div class="form-group form-group-lg">
                   <label class="col-sm-4 control-label" for="formGroupInputLarge">Confirma tu password</label>
                   <div class="col-sm-6">
                       <input class="form-control" type="password" name="retype_password" id="formGroupInputLarge" placeholder="Confirmar password" value="{{ old('retype_password') }}">
                       <input type="hidden" name="code" value="{{$code}}">
                   </div>
              </div>

              <div class="form-group form-group-lg">
                <div class="col-sm-offset-3 col-sm-6">
				    <input class="marginTop-10 form-control btn-success" type="submit" onclick="smallModal('Cargando')" value="Reestablecer password">
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