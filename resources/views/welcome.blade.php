<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>ChécaloAquí.com</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:300,500" rel="stylesheet" type="text/css">

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">




        <script src="https://use.fontawesome.com/95088d75b6.js"></script>
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                margin: 0;
                /*css for full size background image*/
                background: url('../images/background-carpintero.jpg') no-repeat center right fixed;
                -webkit-background-size: cover;
                -moz-background-size: cover;
                -o-background-size: cover;
                background-size: cover;

                height: 100%;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                height: 80px;
                width: 100%;
                position: absolute;
                right: 0px;
                left: 0px;
                top: 0px;
                z-index: 99;
                background-color: rgba(255,255,255,.7);
            }

            .top-left {
                position: absolute;
                left: 20px;
                top: 0px;
                z-index: 99;
            }


            .content {
                z-index: 99;
                text-align: center;
            }

            .title {
                font-size: 64px;
                color: #fff;
                margin-bottom: 50px;
            }

            .links > a {
                color: #31708f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                float: right;
                margin-top: 30px;
                text-transform: uppercase;
            }

        </style>
        <link href="/css/styles.css" rel="stylesheet" type="text/css">

    </head>
    <body >
        <div class="overlay"></div>
        <nav class="navbar navbar-default navbar-static-top navbar-homepage">
            <div class="container">
                <div class="navbar-header">
                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <!-- <a class="navbar-brand" href="{{ url('/') }}"> -->
                    <a  class="navbar-brand" href="/"><img src="images/checalo-250x250.png" style="width:80px;height: auto"></a>

                    <!-- </a> -->
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @include('layouts.menu')
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container ">
            <div class="wrapper-content">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="title m-b-md text-center">
                            Buscas el mejor precio?<br>
                            <p class="white-color text-center font14">La comunidad digital que conecta servicios y productos con personas como tú, que buscan el mejor
                                precio!</p>
                        </div>


                    </div>
                </div>
                <div class="row">
                        <div class="col-md-4 col-md-offset-1 col-sm-6 text-center">
                            <a class="btn btn-lg btn-block btn-success btn-landing" href="{{ url('/register') }}">
                                <br>Quieres cazar las mejores ofertas?<br>
                                <h2><i class="fa fa-shopping-cart" aria-hidden="true"></i> Click aquí</h2>
                            </a>
                        </div>
                        <div class="col-md-2">

                        </div>
                        <div class="col-md-4 col-sm-6 text-center">
                            <a class="btn btn-lg btn-block btn-warning btn-landing">
                                Quieres anunciar tu negocio o servicios,<br> y llevarlo al siguiente nivel?
                                <h2><i class="fa fa-rocket" aria-hidden="true"></i> Click aquí</h2>
                            </a>
                        </div>
                </div>
            </div>

        </div>
    </body>
</html>
