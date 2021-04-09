<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Postulation A2O dev</title>

    <!-- Styles -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100&display=swap" rel="stylesheet">
     <link href="css/bootstrap.min.css" rel="stylesheet"> 
     <link href="css/styles.css" rel="stylesheet"> 
     <link href="css/app.css" rel="stylesheet"> 
</head>
<body>
	<div id="app">

		
	
		<vue-page-transition name="flip-x">
			<router-view :key="$route.fullPath"></router-view>
		</vue-page-transition>

	</div>
	
	<!-- Scripts -->
     <script src="{{ mix('/js/app.js') }}"></script>

</body>
</html>