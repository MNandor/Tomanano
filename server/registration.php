<?php
include "db_connect.php";
include "db_reglog.php";

if($_SERVER['REQUEST_METHOD'] == 'GET')
{
	$request_type = $_GET['request_type'];
	
	if($request_type == 1)
	{
		$user_name = $_GET['user_name'];
		$user_email = $_GET['user_email'];
		$user_pw = $_GET['user_pw'];
		
		if(user_registration($user_name, $user_email, $user_pw) == true)
		{
			$result = array();
			$result["success"] = "1";
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