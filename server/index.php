<?php
include "db_connect.php";
include "db_reglog.php";



function proba()
{
	$fullname = "Kedves Norbert";
	$email = "kedves.norbert@student.ms.sapientia.ro";
	$pw = hash("sha512", "alma");
	$con = connect();	
	mysqli_query($con, "SET @p_message");
	mysqli_query($con, "CALL insert_registration('" . mysqli_real_escape_string($con, $fullname) . "', '" . mysqli_real_escape_string($con, $email) . "', '" . mysqli_real_escape_string($con, $pw) . "', @p_message)");
	$q = "SELECT @p_message AS p_message";
	$res = mysqli_query($con, $q);
	$row = mysqli_fetch_assoc($res);
	$kiir = $row['p_message'];
	mysqli_close($con);	
	?>
	<script>alert('<?php echo $kiir; ?>') </script><?php
}

function proba1()
{
	$email = "kedves.norbert@student.ms.sapientia.ro";
	$pw = hash("sha512", "alma");
	$con = connect();	
	mysqli_query($con, "SET @p_message");
	mysqli_query($con, "CALL user_login('" . mysqli_real_escape_string($con, $email) . "', '" . mysqli_real_escape_string($con, $pw) . "', @p_message)");
	$q = "SELECT @p_message AS p_message";
	$res = mysqli_query($con, $q);
	$row = mysqli_fetch_assoc($res);
	$kiir = $row['p_message'];
	mysqli_close($con);	
	?>
	<script>alert('<?php echo $kiir; ?>') </script><?php
}

proba1();
?>