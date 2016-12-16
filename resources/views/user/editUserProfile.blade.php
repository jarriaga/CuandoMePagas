@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">

                <div class="panel panel-default">
                    <div class="panel-heading">
                       <h4>Actualiza tu perfil</h4>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <form id="profileUserForm" class="form-horizontal" action="{{ route('postUpdateProfile')}}" method="POST" enctype="multipart/form-data">

                            <div class="col-md-10 col-md-offset-1">
                                <div class="profile-image-user text-center">
                                    @if($errors->first('message'))
                                        <div class="row">
                                            <div class="col-md-12 marginTB5">
                                                <div  class="alert alert-danger ">
                                                    {{$errors->first('message')}}
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @if($errors->first('profilePicture'))
                                        <div class="row">
                                            <div class="col-md-12 marginTB5">
                                                <alert class="alert alert-danger ">
                                                    {{$errors->first('profilePicture')}}
                                                </alert>
                                            </div>
                                        </div>
                                    @endif
                                    @if($user->profileImage)
                                        <img id="profileImage" src="{{asset('storage/profiles/'.$user->profileImage)}}" class="img-rounded" >
                                    @else
                                        <img id="profileImage" src="/images/profile/default-user.png" class="img-rounded">
                                    @endif
                                        <div style="margin: 10px auto;">
                                        <span id="fileselector">
                                            <label class="btn btn-default btn-sm" for="upload-file-selector">
                                                <input name="profilePicture" id="upload-file-selector"   accept="image/*" type="file">
                                                <i class="fa fa-upload margin-correction"></i>Foto de perfil
                                            </label>
                                        </span>
                                        </div>

                                </div>

                                {{ csrf_field() }}
                                    <div class="form-group {{ ($errors->first('name'))?'has-error':'' }}">
                                        <label for="inputEmail3" class="col-sm-2 control-label">{{trans('app.Name')}}</label>
                                        <div class="col-sm-10">
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="fa fa-user"></i></div>
                                                 <input type="text" name="name" class="form-control"  value="{{(old('name'))?old('name'):$user->name}}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputPassword3" class="col-sm-2 control-label">{{trans('app.AboutMe')}}</label>
                                        <div class="col-sm-10">
                                            <textarea type="password" name="aboutMe" class="form-control"  >{{$user->aboutMe}}</textarea>
                                        </div>
                                    </div>

                                    <div class="form-group hidden">
                                        <label for="inputEmail3" class="col-sm-2 control-label">{{trans('app.Country')}}</label>
                                        <div class="col-sm-3">
                                            <input type="hidden" class="form-control" id="country" name="country" value="{{$user->country}}">
                                        </div>
                                    </div>
                                    <div class="form-group hidden">
                                        <label for="inputEmail3" class="col-sm-2 control-label">{{trans('app.State')}}</label>
                                        <div class="col-sm-3">
                                            <input type="hidden" class="form-control" id="state" name="state" value="{{$user->state}}">
                                            <input type="hidden" class="form-control" id="city" name="city" value="{{$user->city}}">

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label">{{trans('app.City')}}</label>
                                        <div class="col-sm-10">
                                                <input type="text" class="form-control" id="autocomplete" name="city2" value="{{$user->city2}}">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label">{{trans('app.Birthday')}}</label>
                                        <div class="col-sm-10">
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="fa fa-birthday-cake"></i></div>
                                                <input type="date" class="form-control" name="birthday" value="{{$user->birthday}}">
                                            </div>
                                        </div>
                                    </div>



                              </div>

                                <div class="col-md-12">
                                    <h5 class="text-center">Selecciona los productos o servicios que son de tu interés:</h5>
                                   <div class="categories">
                                       @foreach(\App\Category::where('parent','=',0)->cursor() as $category)
                                         <div class="col-md-4">
                                             <?php $selected = false;
                                                    foreach($user->categories as $cat){
                                                        if($cat->id == $category->id){
                                                            $selected=true;
                                                            break;
                                                        }
                                                    }
                                             ?>

                                             <div class="category-selector {{($selected)?"active":""}}" category-id="{{$category->id}}">
                                                 <img class="category-checked" src="/images/profile/checked2.png" >
                                                 {{$category->name}}
                                             </div>
                                         </div>
                                       @endforeach
                                       <div class="clearfix"></div>
                                   </div>

                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-8 text-center">
                                            <input type="submit" class="btn btn-lg btn-primary" value="{{trans('buttons.SaveProfile')}}">
                                        </div>
                                    </div>

                                </div>

                            </form>

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

            $('form input[type=submit]').click(function(){
               $(this).addClass('disabled').val('{{ trans('buttons.Loading') }}');
            });


            $('.category-selector').click(function(){
                if($(this).hasClass('active'))
                    $(this).removeClass('active');
                else
                    $(this).addClass('active');
            });

            //when the form is submit
            $('#profileUserForm').submit(function(){
                $('.category-selector.active').each(function(){
                    $('.categories').append('<input name="categories[]" type="hidden" value="'+$(this).attr('category-id')+'">');
                });
                smallModal('Cargando');
                return;
            });
        });

        /**
         * Callback for google places api
         */
        function initAutocomplete() {
            // Create the autocomplete object, restricting the search to geographical
            // location types.
            autocomplete = new google.maps.places.Autocomplete(
                    /** @type {!HTMLInputElement} */(document.getElementById('autocomplete')),
                    {types: ['geocode']});

            // When the user selects an address from the dropdown, populate the address
            // fields in the form.
            autocomplete.addListener('place_changed', fillCity);
        }

        /**
         * Fill the country and city
         */
        function fillCity() {
            var place = autocomplete.getPlace();

            for (var i = 0; i < place.address_components.length; i++) {
                var addressType = place.address_components[i].types[0];
                //Check state
                if(addressType=='administrative_area_level_1'){
                    var val = place.address_components[i]['long_name'];
                    document.getElementById('state').value = val;
                }
                //Country
                if(addressType=='country'){
                    var val = place.address_components[i]['long_name'];
                    document.getElementById('country').value = val;
                }

                //Country
                if(addressType=='locality'){
                    var val = place.address_components[i]['long_name'];
                    document.getElementById('city').value = val;
                }
            }
        }

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#profileImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#upload-file-selector").change(function(){
            readURL(this);
        });
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?sensor=false&libraries=places&language=es&key=AIzaSyALNdShZrT3E98mZ48EaAsUUYI3_zfvcT8&callback=initAutocomplete" async defer></script>
@endsection