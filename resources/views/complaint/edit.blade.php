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
                                            <h3 class="text-center text-capitalize text-primary">Editar tu denuncia </h3>

                                            @if(count($errors)>0)
                                                <div class="alert alert-danger">
                                            @foreach ($errors->all() as $message)
                                                    <p>{{$message}}</p>
                                            @endforeach
                                                </div>
                                            @endif
                                            <form id="complaintForm" method="post" action="{{ route('postEditComplaint',['id'=>$complaint->id])  }}" enctype="multipart/form-data" >
                                                {{ csrf_field()  }}
                                                <div class="form-group">
                                                    <label>*Cuéntanos tu historia <small>(80 caracteres mínimo)</small>: </label>
                                                                    <textarea class="form-control" rows="4" name="story" required>{{$complaint->story}}</textarea>
                                                </div>

                                                <div class="form-group">
                                                    <label>*Tipo de denuncia:</label>
                                                    <div class="input-group">
                                                        <div id="radioBtn" class="btn-group">
                                                            <a class="btn btn-success btn-sm {{($complaint->typeComplaint=="persona")?"active":"notActive"}}" data-toggle="typeComplaint" data-title="persona">Persona</a>
                                                            <a class="btn btn-success btn-sm {{($complaint->typeComplaint=="empresa")?"active":"notActive"}}" data-toggle="typeComplaint" data-title="empresa">Empresa</a>
                                                        </div>
                                                        <input type="hidden" name="typeComplaint" id="typeComplaint" value="{{$complaint->typeComplaint}}">
                                                    </div>
                                                </div>

                                                <div class="form-group" >
                                                    <label>*Nombre del deudor <small>(persona o empresa que te debe)</small>:</label>
                                                    <input type="text" class="form-control" name="name" placeholder="Escribe el nombre de la persona o empresa que te debe dinero" required value="{{$complaint->name}}">
                                                </div>



                                                <div class="form-group has-success">
                                                    <label>*Cuanto te deben? (en pesos MX):</label>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">$</span>
                                                        <input type="number" name="amount" class="form-control input-lg" required value="{{$complaint->amount}}">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label>*Recuerdas cuando prestaste o hiciste el trabajo?:</label>
                                                    <input type="text" class="form-control" name="dateLoan" id="dateLoan" required value="{{$complaint->getDatePickerFormat()}}" >
                                                </div>


                                                <div class="form-group" >
                                                    <label>Email del deudor <small>no enviaremos ningun correo a menos que tú lo solicites (opcional)</small>:</label>
                                                    <input type="email" class="form-control" name="email" placeholder="Escribe el email del deudor" value="{{$complaint->email}}">
                                                </div>


                                                <div class="form-group">
                                                    <label><i class="fa fa-facebook-square"></i> Facebook del deudor:</label>
                                                    <div id="facebookArray">
                                                        <input type="text" class="form-control" name="facebook" placeholder="Url de la cuenta de facebook" value="{{$complaint->facebook}}">
                                                    </div>
                                                    <a href="#" class="pull-right small hidden" id="facebookAdd">agregar otra cuenta de facebook</a>
                                                </div>

                                                <div class="form-group">
                                                    <label><i class="fa fa-twitter"></i> Twitter del deudor:</label>
                                                    <div id="twitterArray">
                                                        <input type="text" class="form-control" name="twitter" placeholder="Url de la cuenta de twitter" value="{{$complaint->twitter}}">
                                                    </div>
                                                    <a href="#" class="pull-right small hidden" id="twitterAdd">agregar otra cuenta de twitter</a>
                                                </div>


                                                <div class="form-group hidden">
                                                    <label for="inputEmail3" class="col-sm-2 control-label">{{trans('app.Country')}}</label>
                                                    <div class="col-sm-3">
                                                        <input type="hidden" class="form-control" id="country" name="country" value="{{$complaint->country}}">
                                                    </div>
                                                </div>
                                                <div class="form-group hidden">
                                                    <label for="inputEmail3" class="col-sm-2 control-label">{{trans('app.State')}}</label>
                                                    <div class="col-sm-3">
                                                        <input type="hidden" class="form-control" id="state" name="state" value="{{$complaint->state}}">
                                                        <input type="hidden" class="form-control" id="city" name="city" value="{{$complaint->city}}">

                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label">*{{trans('app.City')}}: <small>(teclea la ciudad)</small></label>
                                                        <input type="text" class="form-control" id="autocomplete" name="city2" value="{{$complaint->city2}}" required>
                                                </div>

                                                <div>
                                                     <span id="fileselector">
                                                    <label class="btn btn-default btn-sm" for="upload-file-selector">
                                                        <input name="image" id="upload-file-selector"   accept="image/*" type="file">
                                                        <i class="fa fa-upload margin-correction"></i>Selecciona una foto
                                                    </label>
                                                     </span>
                                                </div>

                                                <div class="text-center">
                                                    <img id="profileImage" src="{{\App\Http\Controllers\Images\ComplaintImage::getUrl($complaint->photo)}}" style="max-width:300px;margin: 20px auto;height: auto;" class="img-rounded">
                                                </div>


                                                <br>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <button type="submit"  class="btn btn-lg btn-success marginTB20">Guardar cambios</button>

                                                    </div>
                                                    <div class="col-md-6">
                                                        <a href="{{ route('getUserProfile',['name'=>str_slug( Auth::user()->name),'id'=> Auth::user()->id])   }}" class="btn btn-lg btn-default marginTB20">Cancelar</a>

                                                    </div>
                                                </div>
                                            </form>
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

            //avoid submit by enter
            $(window).keydown(function(event){
                if(event.keyCode == 13) {
                    event.preventDefault();
                    return false;
                }
            });

            $.datepicker.regional['es'] = {
                closeText: 'Cerrar',
                prevText: '< Ant',
                nextText: 'Sig >',
                currentText: 'Hoy',
                monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
                dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
                dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
                dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
                weekHeader: 'Sm',
                dateFormat: 'dd/mm/yy',
                firstDay: 1,
                isRTL: false,
                showMonthAfterYear: false,
                yearSuffix: ''
            };

            $.datepicker.setDefaults($.datepicker.regional['es']);


            $( "#dateLoan" ).datepicker({
                changeMonth: true,
                changeYear: true,
                defaultDate:'{{$complaint->getDatePickerFormat()}}'
            });


            $('#radioBtn a').on('click', function(){
                var sel = $(this).data('title');
                var tog = $(this).data('toggle');
                $('#'+tog).prop('value', sel);

                $('a[data-toggle="'+tog+'"]').not('[data-title="'+sel+'"]').removeClass('active').addClass('notActive');
                $('a[data-toggle="'+tog+'"][data-title="'+sel+'"]').removeClass('notActive').addClass('active');
            })

            //Facebook Add
            $('#facebookAdd').click(function(e){
                e.preventDefault();
                $('#facebookArray')
                        .append('<div class="rowInput"><input type="text" class="form-control marginT10" name="facebook[]" placeholder="Url de la cuenta de facebook"><i class="fa fa-minus-circle fa-lg iconRemove"></i></div>');


                $('div.rowInput').hover(function(){
                    $(this).find('.iconRemove').show();
                },function(){
                    $(this).find('.iconRemove').hide();
                });

                $('.iconRemove').click(function(){
                    $(this).parent().remove();
                });

            });

            //Twitter
            $('#twitterAdd').click(function(e){
                e.preventDefault();
                $('#twitterArray')
                        .append('<div class="rowInput"><input type="text" class="form-control marginT10" name="twitter[]" placeholder="Url de la cuenta de twitter"><i class="fa fa-minus-circle fa-lg iconRemove"></i></div>');


                $('div.rowInput').hover(function(){
                    $(this).find('.iconRemove').show();
                },function(){
                    $(this).find('.iconRemove').hide();
                });

                $('.iconRemove').click(function(){
                    $(this).parent().remove();
                });

            });


            //validate Complaint form
            $('#complaintForm').submit(function(e){



                if(  $(this).attr('submit') != undefined ){
                    return;
                }
                e.preventDefault();

                $('.error-facebook').remove();
                //check facebook url
                var error = false;

                $('input[name^=facebook]').each(function(){
                    if($(this).val()){
                        var expFacebook = /((http:|https:)\/\/|www\.)+facebook\.com\/[\w]+/g;
                        var cadena = $(this).val();
                        var result = expFacebook.test(cadena);
                        if(!result){
                            error=true;
                            $('<p class="text-danger error-facebook" style="margin-top:0px;font-size:12px;">el link de facebook no es correcto</p>').insertAfter($(this));
                        }
                    }
                });

                $('input[name^=twitter]').each(function(){
                    if($(this).val()){
                        var expTwitter = /((http:|https:)\/\/|www\.)+twitter\.com\/[\w]+/g;
                        var cadena = $(this).val();
                        var result = expTwitter.test(cadena);
                        if(!result){
                            error=true;
                            $('<p class="text-danger error-facebook" style="margin-top:0px;font-size:12px;">el link de twitter no es correcto</p>').insertAfter($(this));
                        }
                    }
                });

                if(!error){
                    $(this).attr('submit',true);
                    $(this).submit();
                }


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


    <style>
        .rowInput{
            position: relative;
        }
        .iconRemove{
            cursor: pointer;
            display: none;
            position: absolute;
            right: 10px;
            top: 12px;
            color:#ff6666;
        }
    </style>

@endsection