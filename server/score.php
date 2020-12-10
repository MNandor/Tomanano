<?php
include "db_connect.php";
include "db_score.php";

if($_SERVER['REQUEST_METHOD'] == 'GET')
{
	$request_type = $_GET['request_type'];
	
	if($request_type == 5)
	{
		$user_email = $_GET['user_email'];
		$room_id = $_GET['room_id'];
		$photos = $_GET['photos'];
		$persons = $_GET['persons'];
		
		if(db_update_score($user_email, $room_id, $photos, $persons) == true)
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