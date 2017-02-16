@extends('layouts.app')



@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">

                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">

                            <div class="col-md-12">
                                <!--- createComplaint Panel --->

                                <div role="tabpanel" class="tab-pane" id="createComplaint">
                                    <div class="row">
                                        <div class="col-md-10 col-md-offset-1">

                                            <h3 class="text-center text-capitalize text-primary ">Ten cuidado con {{$complaint->name}}</h3>

                                            <h4 class="text-center">Acompañame aleer esta triste historia:</h4>

                                            <img src="{{  \App\Http\Controllers\Images\ComplaintImage::getUrl($complaint->photo)}}" class="img-responsive complaint-image-view">


                                            <h4 class="text-debe text-center">Debe <i class="fa fa-dollar"></i> {{number_format($complaint->amount,2,'.',',')}}</h4>
                                            <p class="text-center">No me ha pagado desde <span class="date-loan"> {{$complaint->getDateFormat()}}</span></p>

                                            <p class="marginTB20 text-justify">{{$complaint->story}}</p>


                                        </div>

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




@section('javascript')



@endsection