<html>
<head>
	<title></title>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	{{ HTML::script('assets/js/datetimepicker/jquery.simple-dtpicker.js') }}
	{{ HTML::style('assets/js/datetimepicker/jquery.simple-dtpicker.css') }}


</head>
<body>
	<input type="text" name="date" value="">
	<script type="text/javascript">
	$(function(){
	$('*[name=date]').appendDtpicker();
	});
	</script>
</body>
</html>