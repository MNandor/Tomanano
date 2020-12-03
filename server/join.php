<?php
include "db_connect.php";
include "db_join.php";

if($_SERVER['REQUEST_METHOD'] == 'GET')
{
	$request_type = $_GET['request_type'];
	
	if($request_type == 4)
	{
		$user_email = $_GET['user_email'];
		$room_id = $_GET['room_id'];
		
		if(db_join($user_email, $room_id) == true)
		{
			$result = array();
			$result["success"] = 1;
			echo json_encode($result);
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