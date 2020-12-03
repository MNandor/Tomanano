<?php
include "db_connect.php";
include "db_result.php";

if($_SERVER['REQUEST_METHOD'] == 'GET')
{
	$request_type = $_GET['request_type'];
	
	if($request_type == 6)
	{
		$user_email = $_GET['user_email'];
		$room_id = $_GET['room_id'];
		$ranglist = array();
		
		if(db_get_result($user_email, $room_id) != false)
		{
			$i = 1;
			$res = db_get_result($user_email, $room_id);
			while($row = mysqli_fetch_assoc($res))
			{
				$temp = array();
				$temp['position'] = $i++;
				$temp['email'] = $row['email'];
				$temp['score'] = $row['score'];
				array_push($ranglist, $temp);
			}
			echo json_encode($ranglist);
		}
		else
		{
			echo json_encode($ranglist);
		}
	}
}

?>