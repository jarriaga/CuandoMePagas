@extends('layouts.master')
@section('title', 'Mi coleccion privada')

@section('content')
    <div class="container">
        <div class="initialDiv">
            <div class="row">
                <div class="col-md-12">

                            <div class="row">
                                <div class="col-md-9 borderMiddle">
                                    <h1 class="text-center"> Agregar un nuevo auto</h1>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-11 marginTop20">
                                            <form id="form" class="form-horizontal" method="POST" action="{{ URL::route('agregarAutoAction') }}">

                                                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">


                                                <div class="form-group">
                                                    <label for="inputEmail3" class="col-sm-2 control-label">Nombre</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Cual es el modelo o nombre de tu auto">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="optionsRadios" class="col-sm-2 control-label">Empaque</label>
                                                    <div class="col-sm-10">
                                                        <div class="radio">
                                                            <label>
                                                                <input type="radio" name="empaque" id="optionsRadios1" value="blister" checked>
                                                                Blister (empaque cerrado)
                                                            </label>
                                                        </div>
                                                        <div class="radio">
                                                            <label>
                                                                <input type="radio" name="empaque" id="optionsRadios2" value="loose">
                                                                Loose  (sin empaque o abierto)
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="selectMarca" class="col-sm-2 control-label">Marca</label>
                                                    <div class="col-sm-5">
                                                        <select name="marca" class="form-control">
                                                            <option>Hot Wheels</option>
                                                            <option>Matchbox</option>
                                                            <option>M2</option>
                                                            <option>Otro</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Descripción Adicional</label>
                                                    <div class="col-md-10">
                                                        <textarea name="descripcion" class="form-control" row="4"></textarea>
                                                    </div>
                                                </div>

                                                <div id="seccionFotos" class="form-group">
                                                    <label class="col-sm-2 control-label">Fotos</label>
                                                    <div class="col-sm-10">
                                                     <span class="btn btn-info fileinput-button"><i class="fa fa-camera spaceIcon"></i><span>Agregar fotos...</span>
                                                        <input id="fileupload" type="file" name="foto" data-url="/upload/image" >
                                                     </span>
                                                        <p><small>Puedes subir hasta 3 fotos</small></p>
                                                    </div>
                                                </div>


                                                <input type="hidden" name="files"  id="inputFiles"/>
                                                <input type="hidden" name="idFile" id="idFile"/>

                                                <div class="row">
                                                    <div class="col-md-12 marginTop20">
                                                        <div id="previewImages"></div>
                                                    </div>
                                                </div>


                                                <div class="info-adicional">
                                                <p class="text-center">Busca informacion adicional de tu auto (solo hotwheels)</p>
                                                <div class="form-group">
                                                    <label class="col-sm-2 col-xs-2 control-label" for="exampleInputAmount">Codigo</label>
                                                    <div class="col-sm-5 col-xs-5">
                                                        <input type="text" class="form-control" id="exampleInputAmount" placeholder="Codigo">
                                                    </div>
                                                    <div class="col-sm-3 col-xs-3">
                                                        <button id="buscarAdicional" type="button" class="btn btn-primary">Buscar</button>
                                                    </div>
                                                </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-offset-4 col-md-4 marginTop20">
                                                        <button id="buttonSubmit" type="submit" class="btn btn-success btn-lg btn-block"><i class="fa fa-save spaceIcon"></i> Guardar </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    @include('user.coleccion.menu')
                                </div>

                            </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
<script src="/assets/js/jquery-file/js/vendor/jquery.ui.widget.js"></script>
<script src="/assets/js/jquery-file/js/jquery.iframe-transport.js"></script>
<script src="/assets/js/jquery-file/js/jquery.fileupload.js"></script>
<script src="/assets/js/jquery-file/js/load-image.all.min.js"></script>
<script src="/assets/js/jquery-file/js/canvas-to-blob.min.js"></script>
<script src="/assets/js/jquery-file/js/jquery.fileupload-process.js"></script>

<script src="/assets/js/jquery-file/js/jquery.fileupload-image.js"></script>
<script src="/assets/js/jquery-file/js/jquery.fileupload-validate.js"></script>


<script>
    var parray = [];
    var idPhoto = 0;
    var loadingFotos = 0;

    function loadDeleteAction(remove){
        if(remove){
            smallModal('borrando');
            $.post("/remove/image",{idFile:remove})
                    .done(function(data){
                        for(var i = 0; i < parray.length; i++) {
                            if(parray[i] == 'foto-'+remove) {
                                $('#'+parray[i]).remove();
                                parray.splice(i, 1);
                                checkFileInput();
                                smallModalHide();
                                break;
                            }
                        }

                    })
                    .fail(function(data){
                        smallModalHide();
                    });
        };
    }

    function checkFileInput(){
        if(parray.length==3){
            $('#seccionFotos').hide();
        }

        if(parray.length<3){
            $('#seccionFotos').show();
        }
    }


    $(function () {
        'use strict';
      $('#fileupload').fileupload({
          dataType: 'json',
          acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
          autoUpload: true,
          previewMaxWidth: 100,
          previewMaxHeight: 100,
          maxFileSize:1024*1024*3,
          previewCrop: true

      }).on('fileuploadadd', function (e, data) {
          idPhoto   =   0;
          idPhoto = Date.now();
          $('#idFile').val(idPhoto);
          data.context  =   idPhoto;
          loadingFotos++;
      }).on('fileuploadprocessalways',function(e,data){
          $('.alert.alert-danger').each(function(){
              $(this).remove();
          });
          var index = data.index,
          file = data.files[index];
          if(data.files.error){
              $('<div id="imageErrorAlert" class="alert alert-danger alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> <strong>Error!</strong> <span id="imageErrorMsg"></span> </div>').insertAfter($('#fileupload').closest('.form-group')) ;
              $('#imageErrorMsg').text(file.error);
              $('#imageErrorAlert').fadeIn();
              smallModalHide();
              loadingFotos--;
              return false;
          }
          parray.push('foto-'+idPhoto);
          checkFileInput();
          if (file.preview){
              $('#previewImages').append($('<div id="foto-'+idPhoto+'" class="thumbsAuto img-thumbnail"/>').html(file.preview));
              $('#foto-'+idPhoto).append($('<button type="button" onclick="loadDeleteAction('+idPhoto+')" class="boton-borrar btn btn-danger btn-sm btn-block"><i class="fa fa-trash"></i> Borrar</button>'+
              '<div class="progress">'+
                      '<div class="progress-bar progress-bar-danger progress-bar-striped" style="width: 0%">'+
                      '</div>'+
              '</div>'));
          }

      }).on('fileuploadfail',function(e,data){
          smallModalHide();
          $('.alert.alert-danger').each(function(){
              $(this).remove();
          });
          var pop  = parray.pop();
          $('#'+pop).remove();
          $('<div id="imageErrorAlert" class="alert alert-danger alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> <strong>Error!</strong> Hubo un error al cargar tu foto </div>').insertAfter($('#fileupload').closest('.form-group')) ;
          $('#imageErrorAlert').fadeIn();
          loadingFotos--;
          checkFileInput();
          return false;
      }).on('fileuploaddone',function(e,data){
          console.log('terminado');
          smallModalHide();
          loadingFotos--;
          checkFileInput();
      }).on('fileuploadprogress',function (e, data) {
          var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#foto-'+data.context+' .progress-bar').css('width',progress+'%');
          if(progress>99){
              $('#foto-'+data.context+' .progress-bar').removeClass('progress-bar-danger');
              $('#foto-'+data.context+' .progress-bar').addClass('progress-bar-success');
              $('#foto-'+data.context+' .boton-borrar').show();
          }
      });


        $('#buttonSubmit').click(function(e){
            e.preventDefault();
                smallModal('Cargando')
                if(validateForm()){
                    $('#inputFiles').val(parray);
                    $('#form').submit();
                }
            smallModalHide();
        });


        function validateForm(){
            var hasError = false;

            $('.errorBorder').each(function(){
               $(this).removeClass('errorBorder');
            });

            if(!$('#nombre').val().length){
                $('#nombre').addClass('errorBorder');
                hasError = true;
            }
            if(!parray.length){
                $('.alert.alert-danger').each(function(){
                    $(this).remove();
                });
                $('<div id="imageErrorAlert" class="alert alert-danger alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> <strong>Error!</strong> Agregar una foto como minimo</div>').insertAfter($('#fileupload').closest('.form-group')) ;
                $('#imageErrorAlert').fadeIn();
                hasError = true;
            }

            if(loadingFotos>0){
                console.log(loadingFotos);
                $('.alert.alert-danger').each(function(){
                    $(this).remove();
                });
                var aunCargandoFotos = noty({
                    text: 'Tus fotos aun estan cargando, por favor espera un momento' ,
                    type: 'warning' ,
                    timeout:5000,
                    theme:'relax',
                    layout: 'topCenter',
                });
                hasError = true;
            }

            if(hasError){
                return false;
            }

            return true;
        }


        $('.time-lastcars').each(function(){
            var convertedDate = moment($(this).attr('time'),'ddd, DD MMM YYYY HH:mm:ss ZZ').locale('es').format('D/MMMM/YY h:mm a');
            $(this).text(convertedDate);
        });

    });


</script>

@endsection