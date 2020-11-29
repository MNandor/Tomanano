<?php

?>
<html>
<head>
	<title>API</title>
	<meta charset="utf-8">
</head>
<body>
<center><h1>API</h1></center>
<h1>API Reference</h1>
<font size="3">
Note! Each activity requires the <i>request_type</i> data that is actually the number next to the activity name.</font>
<ol>
	<h2><li>Registration</li></h2>
	<font size="3">Required: user_name, user_email, user_pw <br>
	ex: <u>/registration.php?request_type=1&user_name=someone123&user_email=someone@example.ru&user_pw=1234</u></font>
	<h2><li>Login</li></h2>
	<font size="3">Required: user_email, user_pw <br>
	ex: <u>/login.php?request_type=2&user_email=someone@example.ru&user_pw=1234</u></font>
	<h2><li>Create room</li></h2>
	<font size="3">Required: created_by, room_name, start_date, end_date <br>
	ex: <u>/room.php?request_type=3&user_email=someone@example.ru&room_name=Room_01&start_date=2020-11-01 2020:22:00&end_date=2020-12-01 2020:22:00</u></font>
	<h2><li>Join room</li></h2>
	<font size="3">Required: user_email, room_id <br>
	ex: <u>/join.php?request_type=4&user_email=someone@example.ru&room_id=12785</u></font>
	<h2><li>Send result</li></h2>
	<h2><li>Get ranglist</li></h2>
</ol>
</body>

</html>