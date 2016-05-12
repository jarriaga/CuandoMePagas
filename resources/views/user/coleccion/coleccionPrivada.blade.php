@extends('layouts.master')
@section('title', 'Mi coleccion privada')

@section('content')
    <div class="container" ng-app="coleccionPrivada" ng-cloak>
        <div class="initialDiv" ng-controller="controller">
            <div class="row">
                <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-9 borderMiddle">
                                    <h1 class="text-center"> Mi colección privada
                                        <small><br>Muéstrale al mundo tus mejores autos</small> </h1>
                                        <div class="row">
                                            <div id="listaAutos" >
                                                <div class="col-md-12" infinite-scroll='loadMore()' infinite-scroll-disabled='busy' infininfinite-scroll-distance='1'>
                                                    <div ng-repeat="auto in autos" class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
                                                        <a ng-href="/coleccion-privada/auto/@{{ auto.id }}">
                                                            <div class="thumbnail">
                                                                <img ng-src="@{{ auto.foto }}" alt="@{{ auto.nombre }}">
                                                                <div class="caption">
                                                                    <h4 class="lista-coleccion">@{{ auto.nombre }}</h4>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="">
                                    @include('user.coleccion.menu')
                                    </div>
                                </div>
                            </div>
                </div>
            </div>
        </div>
    </div>



@endsection



@section('javascript')
    <script src="/assets/js/ng-infinite-scroll.min.js"></script>
    <script>
        'use strict';

        var id      =   '{{ \App\Http\Controllers\Auth\AuthMongoController::user()->getIdhw() }}';
        var urlAutos =  '{{ URL::route('coleccionAutos',['idhw'=> \App\Http\Controllers\Auth\AuthMongoController::user()->getIdhw() ])  }}';

        //cambiar horas en cada elemento
        $(document).ready(function(){
            $('.time-lastcars').each(function(){
                var convertedDate = moment($(this).attr('time'),'ddd, DD MMM YYYY HH:mm:ss ZZ').locale('es').format('D/MMMM/YY h:mm a');
                $(this).text(convertedDate);
            });
        });


        /***  Angular ***/
        var app = angular.module('coleccionPrivada',['infinite-scroll']);
        app.controller('controller',['$scope','$http', function($scope,$http){
            $scope.busy     =       false;
            $scope.pagina   =       1;
            $scope.end      =       false;


            $scope.autos = [];

            $scope.loadMore     =   function(){
                if($scope.busy) return ;
                $scope.busy     =   true;
                $http({
                    method:'POST',
                    url:urlAutos,
                    data:{pagina:$scope.pagina}
                }).then(
                        function(response){
                            var items   =   response.data.autos;
                            for(var i=0;i<items.length;i++){
                                $scope.autos.push(items[i]);
                            }
                            $scope.pagina++;

                            if(items.length)
                                $scope.busy =   false;
                            else
                                $scope.busy =   true;

                        },function(response){

                        }
                )
            }

        }]);
        /*** /Angular  ***/
    </script>
@endsection
