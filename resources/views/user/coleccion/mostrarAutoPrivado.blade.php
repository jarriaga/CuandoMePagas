@extends('layouts.master')
@section('title', 'Mi coleccion privada')

@section('content')
    @if(isset($auto))
        <div class="container" ng-app="mostrarAutoPrivado">
            <div class="initialDiv" ng-controller="controller">
                <div class="row">
                    <div class="col-md-8">
                        <h1>{{$auto->getNombre()}}</h1>
                        <div class="row">
                            <div class="col-md-2 text-center">
                                <img class="img-responsive marginTop10 pointer" ng-mouseover="mouseOver(item)" ng-src="/imagen/auto/@{{ item.imagen }}.jpg/thumbnail" ng-repeat="item in fotos">
                            </div>
                            <div class="col-md-10 text-center">
                                <img ng-src="/imagen/auto/@{{ fotoSelected  }}.jpg/400">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        @include('user.coleccion.menu')
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection


@section('javascript')

    <script>
        'use strict';

        /***  Angular ***/
        var app = angular.module('mostrarAutoPrivado',[]);
        app.controller('controller',['$scope', function($scope){
            // Declaramos variables
            $scope.fotos = [];
            $scope.fotoSelected = '';
            // realizamos un For para cargar las fotos
            @foreach($auto->getFotos() as $foto)
                $scope.fotos.push({ imagen:'<?php echo $foto->getFilename() ?>'  });
            @endforeach
            // Asignamos la primera foto por default
            $scope.fotoSelected = $scope.fotos[0].imagen;
            //
            $scope.mouseOver    =   function(item){
                $scope.fotoSelected =   item.imagen;
            }
        }]);

        /******  End Angular  ******/
    </script>

@endsection