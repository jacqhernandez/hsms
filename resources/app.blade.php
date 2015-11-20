<!DOCTYPE html>
<html lang="en">
<head>
	@yield('header')
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<title>HSM System</title>
	<h1> THIS IS A HEADER </h1>
	
	<!-- JS -->
	<script src="{{ asset('/js/jquery-1.11.3.js') }}" ></script>
	<script src="{{ asset('/js/bootstrap.min.js') }}" ></script>
	<script src="{{ asset('/js/sorttable.js') }}" ></script>

	<script src="{{ asset('/js/select2.full.min.js') }}"></script>

	<script src="{{ asset('/js/jquery.orgchart.js') }}"></script>
	<script src="{{ asset('/js/bootstrap-confirmation.js') }}"></script>

	<script src="{{ asset('/js/pace.js') }}"></script>
	
	<!-- CSS -->
	<link href="{{ asset('/css/bootstrap.css') }}" rel="stylesheet">
	<link href="{{ asset('/css/select2.css') }}" rel="stylesheet">


	<link rel="stylesheet" href="{{ asset('/css/jquery.orgchart.css') }}">
	<!-- Fonts -->
	<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>

	
	<style type="text/css">
		#SiteBody
		{
			margin: 7px;
		}
	</style>
	</head>
	<body>
		<div id = "SiteBody">
			@yield('content')
		</div>

		
		<!-- Scripts -->
		<script>
			
			$(document).ajaxStart(function() {
    Pace.restart();
}).ajaxStop( function() { 
    Pace.stop();
}).ajaxError( function(event, request, settings) { 
    Pace.stop();
}).ajaxComplete( function(event, request, settings) { 
    Pace.stop();
});
		</script> 
	</body>
</html>
