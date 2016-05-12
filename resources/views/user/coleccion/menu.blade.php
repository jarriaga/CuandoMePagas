<h4 class="text-center text-capitalize" style="font-weight: bold;">Hola {{\App\Http\Controllers\Auth\AuthMongoController::user()->getFirstname()}}</h4>
<p>Hey! como va esa colección?</p>
@if(isset($numeroAutos))
<p> Tienes {{ ($numeroAutos) }} autos en tu colección</p>
@else

@endif
<div class="menu-coleccion well well-sm">
    <ul class="list-unstyled">
        <li> <a href="{{ URL::route('coleccionPrivada')  }}" class="text-capitalize"> Mi colección</a></li>
        <li><a href="{{ URL::route('agregarCarro') }}" class="text-capitalize">Agregar auto nuevo</a></li>
    </ul>

    <a href="#" class="text-capitalize"> </a>
</div>

@if(isset($last5autos))
<div class="row">
    <div class="col-md-12">
        <h4 class="text-center">Creados recientemente</h4>
        @foreach($last5autos as $auto)
            <div class="row">
                <div class="marginTop10">
                    <a href="#">
                        <div class="col-md-4">
                            <img class="img-rounded img-responsive " src="{{ URL::route('mostrarAuto',['imagenId'=>$auto->getSelectedFoto()->getFilename().'.jpg','size'=>'thumbnail'])}}"/>
                        </div>
                        <div class="col-md-8">
                            <p class="text-center marginTop10">{{ $auto->getNombre() }}<br>
                            <small class="time-lastcars" time="{{ $auto->getCreatedAt() }}"> </small></p>
                        </div>
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endif