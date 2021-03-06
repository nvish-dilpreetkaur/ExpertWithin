<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>ExpertWithin</title>
	<link rel="shortcut icon" type="image/png" href="{{ URL::asset('images/kloveslab-favicon-192x192.png') }}"/>

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="{{ URL::asset('css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ URL::asset('css/style.css') }}">
	
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.5.1/css/swiper.min.css"> 

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="{{ URL::asset('js/kit.fontawesome.js') }}" crossorigin="anonymous"></script>
	<script type="text/javascript">
		var SITE_URL = "{{ URL::to('/') }}";
		$.ajaxSetup({
			   headers: {
			 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			   }
		});
	</script>
</head>
<body>
	@include('common.search-top')
	<div class="main-content-container">  <!-- wraps whole page -->
		@include('common.header')
		@include('common.flash-message')
		@yield('content')
	@include('common.footer')
	</div>
</body>
</html>