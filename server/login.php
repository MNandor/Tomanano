<?php
include "db_connect.php";
include "db_reglog.php";

if($_SERVER['REQUEST_METHOD'] == 'GET')
{
	$request_type = $_GET['request_type'];
	
	if($request_type == 2)
	{
		$user_email = $_GET['user_email'];
		$user_pw = $_GET['user_pw'];
		
		if(loginOK($user_email, $user_pw) != false)
		{
			if(db_get_userid($user_email) > 0)
			{
				$result = array();
				$result["success"] = (int)db_get_userid($user_email);
				echo json_encode($result);
			}
			else
			{
				$result = array();
				$result["success"] = 0;
				echo json_encode($result);
			}
			
		}
		else
		{
			$result = array();
			$result["success"] = 0;
			echo json_encode($result);
		}
	}
}

?>

