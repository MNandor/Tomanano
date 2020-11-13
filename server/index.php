<?php
include "db_connect.php";

function proba()
{
	$pw = "alma";
	$con = connect();
	$q = "INSERT INTO users VALUES(NULL, 'Norbi', 'a@example.ru', NULL, '" . hash("sha512", $pw) . "')";
	mysqli_query($con, $q);
	mysqli_close($con);
}
?>