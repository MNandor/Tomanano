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
	Response: {"success":1} OR {"success":0}<br>
	ex: <u>/registration.php?request_type=1&user_name=someone123&user_email=someone@example.ru&user_pw=1234</u></font>
	<h2><li>Login</li></h2>
	<font size="3">Required: user_email, user_pw <br>
	Response ex: {"success":17856}. When failed: {"success":0} <br>
	ex: <u>/login.php?request_type=2&user_email=someone@example.ru&user_pw=1234</u></font>
	<h2><li>Create room</li></h2>
	<font size="3">Required: created_by, room_name, start_date, end_date <br>
	Response: {"success":1}  OR {"success":0} <br>
	ex: <u>/room.php?request_type=3&user_email=someone@example.ru&room_name=Room_01&start_date=2020-11-01 2020:22:00&end_date=2020-12-01 2020:22:00</u></font>
	<h2><li>Join room</li></h2>
	<font size="3">Required: user_email, room_id <br>
	Response: {"success":1}  OR {"success":0} <br>
	ex: <u>/join.php?request_type=4&user_email=someone@example.ru&room_id=12785</u></font>
	<h2><li>Send result</li></h2>
	<font size="3">Required: user_email, room_id, photos, persons <br>
	Response: {"success":1}  OR {"success":0} <br>
	ex: <u>/score.php?request_type=5&user_email=someone@example.ru&room_id=2525&photos=2&persons=11</u></font>
	<h2><li>Get ranglist</li></h2>
	<font size="3">Required: user_email, room_id <br>
	Response ex: [{"position":1,"email":"abc@gmail.com","score":"25"},{"position":2,"email":"kedves.norbert@student.ms.sapientia.ro","score":"14"}] <br> When failed: [] <br>
	ex: <u>/result.php?request_type=6&user_email=kedves.norbert@student.ms.sapientia.ro&room_id=10</u></font>
	<h2><li>Get roomlist</li></h2>
	<font size="3">Required: user_email<br>
	Response ex: [3,{"room_id":"2","room_name":"Szoba_2","start_date":"2020-01-01 20:22:00","end_date":"2020-12-01 20:22:00"},{"room_id":"10","room_name":"Szoba6001","start_date":"2020-11-01 20:22:00","end_date":"2020-12-01 20:22:00"},{"room_id":"12","room_name":"Sf7895","start_date":"2020-11-01 20:22:00","end_date":"2020-12-01 20:22:00"}]
	<br> When failed: [] <br>
	ex: <u>/roomlist.php?request_type=7&user_email=kedves.norbert@student.ms.sapientia.ro</u></font>
	
</ol>
</body>

</html>