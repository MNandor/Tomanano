<?php
function connect()
{
	$host = "localhost";
	$user = "id15331351_norbi";
	$pass = "+quaE\nNxybg_<F8";
	$db = "id15331351_project";	
	$con = mysqli_connect($host, $user, $pass, $db);
	if (!$con)
		return false;
	mysqli_query($con, "SET NAMES 'utf8'");
	mysqli_query($con, "SET CHARACTER SET 'utf8'");
	mysqli_query($con, "SET COLLATION_CONNECTION='utf8_general_ci'");
	return $con;
}
?>