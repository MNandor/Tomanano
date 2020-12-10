<?php
include "db_connect.php";
include "db_room.php";

if($_SERVER['REQUEST_METHOD'] == 'GET')
{
	$request_type = $_GET['request_type'];
	
	if($request_type == 3)
	{
		$user_email = $_GET['user_email'];
		$room_name = $_GET['room_name'];
		$start_date = $_GET['start_date'];
		$end_date = $_GET['end_date'];
		
		if(db_createRoom($user_email, $room_name, $start_date, $end_date) != false)
		{
			$res = db_return_roomid($user_email, $room_name);
			if($res != false)
			{
				$result = array();
				$result["success"] = (int)$res; /*returning the room ID*/
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