<?php
include "db_connect.php";
include "db_getrooms.php";

if($_SERVER['REQUEST_METHOD'] == 'GET')
{
	$request_type = $_GET['request_type'];
	
	if($request_type == 7)
	{
		$user_email = $_GET['user_email'];
		$roomlist = array();
		
		if(db_get_roomlist($user_email) != false)
		{
			$res = db_get_roomlist($user_email);
			//$count = array();
			//$count['count'] = mysqli_num_rows($res);
			//array_push($roomlist, $count);
			while($row = mysqli_fetch_assoc($res))
			{
				$temp = array();
				$temp['room_id'] = $row['room_id'];
				$temp['room_name'] = $row['room_name'];
				$temp['start_date'] = $row['start_date'];
				$temp['end_date'] = $row['end_date'];
				array_push($roomlist, $temp);
			}
			echo json_encode($roomlist);
		}
		else
		{
			echo json_encode($roomlist);
		}
	}
}

?>