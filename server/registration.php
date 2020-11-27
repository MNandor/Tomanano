<?php
include "db_connect.php";
include "db_reglog.php";

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
	$request_type = $_POST['request_type'];
	
	if($request_type == 1)
	{
		$user_name = $_POST['user_name'];
		$user_email = $_POST['user_email'];
		$user_pw = $_POST['user_pw'];
		
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