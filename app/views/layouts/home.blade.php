<!DOCTYPE html>
<html>
<head>
	<title>{{ $title }}</title>
	@include('include.home-header')
</head>
<body>
	@yield('content')
	@include('include.home-footer')
</body>
</html>