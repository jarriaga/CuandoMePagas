<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title> CuandoMePagas.com - @yield('title')</title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	<!-- FontAwesome CDN CSS -->
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
	<!-- Google fonts -->
	<link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,400,700,200italic,700italic" rel="stylesheet" type="text/css">

	<!-- Local styles -->
    <link rel="stylesheet" href="{{ elixir('css/all.css') }}">
	@yield('styles')
</head>
<body>
		@include('layouts.mainmenu')
		@yield('content')
		@include('layouts.footer')
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<!-- Noty js -->
	<script src="/js/noty/packaged/jquery.noty.packaged.min.js"></script>
	<script src="/js/noty/themes/relax.js"></script>
        @yield('angular')
<script>

    @if (Session::has('notify') )
        <?php $notify = Session::get('notify'); ?>
        var n = noty({
                text: '{{ $notify['text'] }}' ,
                type: '{{ $notify['type'] }}' ,
                timeout:8000,
                theme:'relax'
            });
    @endif
</script>
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
</body>
</html>
