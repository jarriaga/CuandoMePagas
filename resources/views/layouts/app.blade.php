<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <script src="https://use.fontawesome.com/95088d75b6.js"></script>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">


    <link href="/css/app.css" rel="stylesheet">
    <link href="/css/styles.css" rel="stylesheet" type="text/css">


    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body>


    <nav class="navbar navbar-default navbar-static-top">
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
                    <a  class="navbar-brand" href="/"><img src="/images/checalo-250x250.png" style="width:80px;height: auto"></a>

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
<div class="wrapper-app">
    @yield('content')
</div>


    <div class="modal fade" tabindex="-1" role="dialog" id="smallModal" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-sm">
            <div class="modal-content" >
                <div  class="text-muted" style="font-family: 'Oswald',sans-serif;padding:20px;font-size:26px;">
                <span id="smallModalContent">

                </span>
                <span>
                  <img src="/images/loading_dots.gif" width="64" height="64">
                </span>
                </div>

            </div>
        </div>
    </div>


    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <!-- Toastr -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    @yield('javascript')

<script>
    /**
     * Created by jbarron on 3/13/16.
     */
    function smallModal(message){
        $('#smallModal').modal('show');
        $('#smallModalContent').text(message);
    }

    /**
     * Created by jbarron on 3/13/16.
     */
    function smallModalHide(message){
        $('#smallModal').modal('hide');
    }


    @if (session('flash-success'))
        toastr.success('{{ session('flash-success') }}', 'Excelente');
    @endif

    @if (session('flash-error'))
        toastr.error('{{ session('flash-error') }}', 'Error');
    @endif
</script>
</body>
</html>
