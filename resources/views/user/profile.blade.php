@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <!-- side part -->
                            <div class="col-md-4">
                                <div class="profile-image-user text-center">
                                    @if($user->profileImage)
                                        <img src="{{ \App\Http\Controllers\ImageController::getUrl('/profiles/'.$user->profileImage)}}" class="img-rounded" >
                                    @else
                                        <img src="/images/profile/default-user.png"  >
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
                            <div class="col-md-8">
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
                                                        <div class="row">
                                                            <div class="col-sm-3">
                                                                <img src="{{  \App\Http\Controllers\Images\ComplaintImage::getUrl( $complaint->photo )}}"
                                                                     class="img-responsive img-rounded img-complaint">
                                                                <div class="review-block-name"><a href="#">{{$complaint->name}}</a></div>
                                                                <div class="review-block-date">Enero 29, 2016<br/>hace 1 día</div>
                                                            </div>
                                                            <div class="col-sm-9">
                                                                <div class="review-block-rate">
                                                                    <i class="fa fa-star fa-lg" aria-hidden="true"></i>
                                                                    <i class="fa fa-star fa-lg" aria-hidden="true"></i>
                                                                    <i class="fa fa-star fa-lg" aria-hidden="true"></i>
                                                                    <i class="fa fa-star-o fa-lg" aria-hidden="true"></i>
                                                                    <i class="fa fa-star-o fa-lg" aria-hidden="true"></i>
                                                                </div>
                                                                <div class="review-block-title">Los precios son realmente bajos</div>
                                                                <div class="review-block-description">Encontre productos muy economicos a precios bajisimos</div>
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



@endsection