@extends('layouts.master')
@section('title', 'Login')

@section('content')
<div class="container">
 <div class="initialDiv">
    <div class="row">
        <div class="col-sm-6 col-sm-offset-3">
            <h2 class="text-center"><span class="glyphicon glyphicon-user"></span> Login<br><small>Ingresa ahora!</small></h2>
        </div>
    </div>
    <div class="row marginTop-10">
        <div class="col-sm-6 col-sm-offset-3">
            <div class="text-center">
                <div class="btn-container">
                    <div class="fb-btn">
                        <a href="{{$loginUrl}}">
                            <div class="fb-icn"></div>
                            <p>Login con Facebook</p>
                        </a>
                    </div>
                </div>
            </div>
            @if ($reject_app)
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-danger">
                            <ul>
                               {{ $reject_app }}
                            </ul>
                        </div>
                    </div>
                </div>
             @endif
            <div style="border-bottom: 1px solid #AAA;float: left;margin-top: 10px;width: 45%;"></div>
            <div style="float:left;margin:0px 10px;"> o </div>
            <div style="border-bottom: 1px solid #AAA;float: left;margin-top: 10px;width: 45%;"></div>
        </div>
    </div>

    <div class="row marginTop-10">
        <div class="col-md-offset-3 col-md-6">
            <form class="form-horizontal marginTop-10" method="post" action="{{URL::route('authLogin')}}">
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
                <label class="col-sm-2 control-label" for="formGroupInputLarge">Email</label>
                    <div class="col-sm-9">
                        <input class="form-control" type="text" id="formGroupInputLarge" name="email" placeholder="Tu correo electronico" value="{{ old('email') }}">
                    </div>
              </div>
              <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label" for="formGroupInputLarge">Password</label>
                    <div class="col-sm-9">
                        <input class="form-control" type="password" name="password" id="formGroupInputLarge" placeholder="Ingresa un Password" value="{{ old('password') }}">
                    </div>
               </div>

              <div class="form-group form-group-lg">
                <div class="col-sm-offset-3 col-sm-6">
				    <input class="form-control btn-success" type="submit" onclick="smallModal('Cargando')" value="Login">
			    </div>
			  </div>
            </form>
        </div>
    </div>
    <div class="marginTop-10">
        <p class="text-center"><a href="{{URL::route('forgetPassword')}}">Olvidaste tu password?</a></p>
    </div>
 </div>
</div>
@endsection

@section('angular')
<!-- Google Recaptcha 2.0-->
<!--    <script src="https://www.google.com/recaptcha/api.js?hl=es-419"></script> -->

    @include('layouts.angular')
@endsection