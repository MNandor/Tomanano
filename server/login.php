<?php
include "db_connect.php";
include "db_reglog.php";

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
	$request_type = $_POST['request_type'];
	
	if($request_type == 2)
	{
		$user_email = $_POST['user_email'];
		$user_pw = $_POST['user_pw'];
		
		if(loginOK($user_email, $user_pw) != false)
		{
			$con = connect();
			$res = mysqli_query($con, "SELECT user_id FROM users WHERE user_email='" . $user_email . "'");
			$row = mysqli_fetch_assoc($res);
			$u_id = $row['user_id'];
			$result = array();
			$result["success"] = $u_id;
			echo json_encode($result);
		}
		else
		{
			$result = array();
			$result["success"] = "0";
			echo json_encode($result);
		}
	}
}

?>