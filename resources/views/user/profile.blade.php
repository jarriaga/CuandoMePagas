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
                                       class="btn btn-success btn-sm btn-block">Editar perfil</a>
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
                                @if($owner)
                                    <hr>
                                    <em>Mis intereses:</em>
                                    <div>
                                        @if(count($user->categories)>0)
                                            @foreach($user->categories as $category)
                                                <span class="label label-info">{{$category->name}}</span>
                                            @endforeach
                                        @else
                                            <small>{{trans('app.MesssageCategories')}}</small>
                                        @endif
                                    </div>
                                @endif
                            </div>
                            <!-- Central Part -->
                            <div class="col-md-8">
                                    <div class="row">

                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">

                                            <!-- Nav tabs -->
                                            <ul class="nav nav-tabs nav-justified" role="tablist" id="user-tabs">
                                                <li role="presentation" class="active"><a href="#reviews" aria-controls="reviews" role="tab" data-toggle="tab">{{ trans('app.Reviews') }}</a></li>
                                                <li role="presentation"><a href="#favorites" aria-controls="favorites" role="tab" data-toggle="tab">{{trans('app.Favorites')}}</a></li>
                                                <li role="presentation"><a href="#biz" aria-controls="favorites" role="tab" data-toggle="tab">{{trans('app.Biz')}}</a></li>

                                            </ul>

                                            <!-- Tab panes -->
                                            <div class="tab-content">
                                                <!----- Reviews Panel---->
                                                <div role="tabpanel" class="tab-pane active" id="reviews">
                                                   <br>


                                                    <div class="review-block">
                                                        @for($i=0;$i<10;$i++)
                                                        <div class="row">
                                                            <div class="col-sm-3">
                                                                <img src="http://dummyimage.com/60x60/F24/ffffff&text=No+Image" class="img-rounded">
                                                                <div class="review-block-name"><a href="#">El oferton</a></div>
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
                                                            @endfor




                                                    </div>
                                                </div>
                                                <!---- / Reviews Panel -->


                                                <!--- Favorites Panel --->
                                                <div role="tabpanel" class="tab-pane" id="favorites">
                                                                    favoritos
                                                </div>
                                                <!---- / Favorites Panel --->


                                                <!-- Biz Panel -->
                                                <div role="tabpanel" class="tab-pane" id="biz">
                                                    Biz
                                                </div>
                                                <!-- / Biz Panel -->
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
    <script>
        jQuery(document).ready(function(){
            $('#user-tabs a').click(function (e) {
                e.preventDefault()
                $(this).tab('show')
            });
        });
    </script>
@endsection