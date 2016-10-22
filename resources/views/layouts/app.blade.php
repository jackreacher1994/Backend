<!DOCTYPE html>
<html lang="vn">
    <head>
    	<meta charset="UTF-8">
        <title>
            @section('title')
            @show
        </title>
        <link rel="stylesheet" href="{{  asset('public/admin/login/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{  asset('public/admin/login/css/reset.css') }}">
		<link rel='stylesheet prefetch' href='http://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900|RobotoDraft:400,100,300,500,700,900'>
		<link rel='stylesheet prefetch' href='http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'>
        <link rel="stylesheet" href="{{  asset('public/admin/login/css/style.css') }}">
    </head>

    <body>
		@yield('content')

		<script src="{{  asset('public/admin/login/js/jquery.min.js') }}"></script>
    	<script src="{{  asset('public/admin/login/js/bootstrap.min.js') }}"></script>
        <script src="{{  asset('public/admin/login/js/index.js') }}"></script>
    </body>
</html>