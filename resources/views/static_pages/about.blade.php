@extends('layouts.master')
@section('title', 'Titulo')

@section('content')
<div class="container">
 <div class="initialDiv">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h1>About</h1>
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