@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <!-- side part -->
                            <div class="col-md-3">
                                <div class="profile-image-user text-center">
                                    @if($user->profileImage)
                                        <img src="{{ \App\Http\Controllers\Images\ProfileImage::getUrl($user->profileImage)}}"  class="img-circle img-responsive" >
                                    @else
                                        <img src="/images/profile/default-user.png" class="img-circle img-responsive" >
                                    @endif
                                </div>
                                @if($owner)
                                <div class="text-center marginTB5">
                                    <a href="{{ route('editUserProfile',['name'=>str_slug( Auth::user()->name),'id'=> Auth::user()->id])  }}"
                                     >Editar perfil</a>
                                </div>
                                @endif
                                <h3 class="text-center marginTB5">{{ $user->name }}</h3>
                                @if($user->city2)
                                <p class="text-center">
                                    <small>
                                        <i class="fa fa-map-marker" aria-hidden="true"></i> {{$user->city2}}
                                    </small>
                                </p>
                                @endif
                                <p class="text-justify">
                                    <em>Acerca de mi:</em><br>
                                    @if($user->aboutMe)
                                       {{$user->aboutMe}}
                                    @else
                                      <small>{{trans('app.MessageAboutMe')}}</small>
                                    @endif
                                </p>

                            </div>
                            <!-- Central Part -->
                            <div class="col-md-9">
                                    <div class="row">

                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <!-- Tab panes -->
                                            <div class="tab-content">
                                                    <h3 class="text-center"><i class="fa fa-bomb"></i> {{trans('app.Complaints')}}</h3>
                                                <!----- Reviews Panel---->
                                                <div role="tabpanel" class="tab-pane active" id="complaints">
                                                   <br>
                                                    <div class="review-block">
                                                        @foreach($user->complaints as $complaint)
                                                        <div class="row complaint-row{{$complaint->id}}">
                                                            <div class="col-md-12 ">
                                                                <div class="dropdown pull-right">
                                                                    <a href="#" data-toggle="dropdown" class="dropdown-toggle complaint-submenu"><i class="fa fa-lg fa-angle-down"></i></a>
                                                                    <ul class="dropdown-menu">
                                                                        <li><a href="{{route('editComplaint',['id'=>$complaint->id])}}"><i class="fa fa-pencil"></i> Editar</a></li>
                                                                        <li><a href="#" class="complaintDeletelink" complaintId="{{$complaint->id}}"><i class="fa fa-trash-o"></i> Eliminar</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <img src="{{  \App\Http\Controllers\Images\ComplaintImage::getUrl( $complaint->photo )}}"
                                                                     class="img-responsive img-rounded img-complaint">

                                                            </div>
                                                            <div class="col-md-7">
                                                                <!--
                                                                <div class="review-block-rate">
                                                                    <i class="fa fa-star fa-lg" aria-hidden="true"></i>
                                                                    <i class="fa fa-star fa-lg" aria-hidden="true"></i>
                                                                    <i class="fa fa-star fa-lg" aria-hidden="true"></i>
                                                                    <i class="fa fa-star-o fa-lg" aria-hidden="true"></i>
                                                                    <i class="fa fa-star-o fa-lg" aria-hidden="true"></i>
                                                                </div>
                                                                -->
                                                                <div class="review-block-title"><a href="{{  route('viewComplaint',['id'=>$complaint->id]) }}">{{$complaint->name}}</a><span class="date-loan">No ha pagado desde {{$complaint->getDateFormat()}}</span></div>

                                                                <div class="review-block-description">{{str_limit($complaint->story,150)}}</div>
                                                                <div class="pull-right"><a href="{{  route('viewComplaint',['id'=>$complaint->id]) }}">Leer historia completa ></a></div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <ul class="list-group-item-info list-info">
                                                                    <li><i class="fa fa-map-marker"></i> {{$complaint->city. " ".$complaint->state}}</li>
                                                                    <li><i class="fa fa-dollar"></i> {{number_format($complaint->amount,2,'.',',')}} MX</li>
                                                                    <li><i class="fa fa-calendar"></i> {{ $complaint->getDateInDays()  }} dias sin pagar</li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <hr/>
                                                            @endforeach

                                                    </div>
                                                </div>
                                                <!---- / Reviews Panel -->
                                            </div>
                                        </div>
                                    </div>
                            </div>
                            <!-- / central part -->

                        </div>
                    </div>
                </div>
            </div>
        </div>



    </div>





@endsection

@section('javascript')
    <style>
        .modal-text{  font-family: 'Oswald',sans-serif;padding:20px;font-size:16px;  }
    </style>
    <div class="modal fade" data-backdrop="false" id ="deleteModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-text">
                    <p> Por favor confirma que quiere eliminar este registro?</p>
                    <div complaintid="" id="deleteConfirm" class="pull-left btn btn-danger btn-sm">Eliminar</div>
                    <div id="cancelButton" class="pull-right btn btn-default btn-sm">Cancelar</div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>

    <script>

        jQuery(document).ready(function(){

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            var cId=0;

            jQuery('#cancelButton').click(function(){
                jQuery('#deleteModal').modal('hide');
            });

            jQuery('.complaintDeletelink').click(function(e){
                e.preventDefault();
                jQuery('#deleteModal').modal('show');
                cId = jQuery(this).attr('complaintId');
                jQuery('#deleteConfirm').attr('complaintid',cId);
            });

            jQuery('#deleteConfirm').click(function(){
                jQuery.post('/complaint/delete/'+cId,function(){
                    jQuery('.complaint-row'+cId).hide();
                    jQuery('#deleteModal').modal('hide');

                    toastr.success('Se ha borrado la denuncia', 'Excelente');
                }).fail(function(){
                    jQuery('#deleteModal').modal('hide');

                    toastr.error('Hubo un error al borrar la denuncia', 'Error');
                });
            });

        });


    </script>


@endsection