<!doctype html>
<html lang="en" class="fontawesome-i2svg-active fontawesome-i2svg-complete">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<title>ExpertWithIn</title>
		<link rel="shortcut icon" type="image/png" href="{{ URL::asset('images/kloveslab-favicon-192x192.png') }}"/>
		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="{{ URL::asset('css/bootstrap.min.css') }}">
		
		<link rel="stylesheet" href="{{ URL::asset('css/style-2.0.css') }}">
		<link rel="stylesheet" href="{{ URL::asset('css/community-slider.css') }}">



		<link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,700,900&display=swap" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i&display=swap" rel="stylesheet"> 
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/"
		 crossorigin="anonymous">
		 
		<link rel="stylesheet" href="{{ URL::asset('css/fontawesome-free-5.10.2-web/css/all.css') }}">
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>	
		<!-- <script src="{{ URL::asset('js/bootstrap.min.js') }}"></script> -->
		<!-- Datepicker -->

		<link rel="stylesheet" href="{{ URL::asset('css/bootstrap-datetimepicker.min.css') }}" type="text/css" media="all" />
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.min.js"></script>
		<script type="text/javascript" src="{{ URL::asset('js/bootstrap-datetimepicker.min.js') }}"></script>
		<script type="text/javascript" src="{{ URL::asset('js/demo.js') }}"></script>
		<!-- Scrollbar Custom CSS -->
		<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet"/>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
		<!-- mobile css/js -->
	
		<!-- <script src="http://code.jquery.com/mobile/1.5.0-alpha.1/jquery.mobile-1.5.0-alpha.1.min.js"></script> -->
		
		<script src="{{URL::asset('js/tinymce/tinymce.min.js')}}" referrerpolicy="origin"></script>
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
			<div class="container">	
				@include('common.admin-header')
				<div id="content">
				@include('common.flash-message')
				@yield('content')
				@include('common.admin-footer')
				</div>	
			</div>													
	</body>
</html>