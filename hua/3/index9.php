<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<link rel="stylesheet" type="text/css" href="./jquery.datetimepicker.css"/>
</head>
<body>
	
	<h3>DateTimePicker</h3>
	<input type="text" value="" id="datetimepicker"/><br><br>
 
</body>
<script src="./jquery.js"></script>
<script src="./jquery.datetimepicker.full.js"></script>
<script>


$('#datetimepicker').datetimepicker({
dayOfWeekStart : 1,
lang:'en',
disabledDates:['1986/01/08','1986/01/09','1986/01/10'],
startDate:	'1986/01/05'
});
$('#datetimepicker').datetimepicker({value:'2015/04/15 05:03',step:10});





</script>
</html>
