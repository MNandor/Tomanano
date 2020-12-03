<?php
/*This function returns the ID of the user that has the given email address.*/
function db_get_userid($email)
{
	$con = connect();
	if(!$con)
	{
		return 0; /*Failed to connect to database*/
	}
	$res = mysqli_query($con, "SELECT user_id FROM users WHERE user_email = '" . mysqli_real_escape_string($con, $email) . "'");
	if(!$res || mysqli_num_rows($res) == 0)
	{
		return 0;
	}
	$row = mysqli_fetch_assoc($res);
	return $row['user_id'];
}

/*This function verifies if the user has already joined in the room*/
function db_already_in_room($email, $roomid)
{
	$con = connect();
	if(!$con)
	{
		return false; /*Failed to connect to database*/
	}
	$q = "SELECT user_id FROM inroom WHERE user_id = (SELECT user_id FROM users WHERE user_email = '" . mysqli_real_escape_string($con, $email) . "') AND room_id = '" . mysqli_real_escape_string($con, $roomid) . "'";
	$res = mysqli_query($con, $q);
	mysqli_close($con);
	return mysqli_num_rows($res);
}

/*This function checks whether exists or not a room with the given ID*/
function db_room_exists($roomid)
{
	$con = connect();
	if(!$con)
	{
		return false; /*Failed to connect to database*/
	}
	$q = "SELECT room_id FROM room WHERE room_id = '" . mysqli_real_escape_string($con, $roomid) . "'";
	$res = mysqli_query($con, $q);
	mysqli_close($con);
	return mysqli_num_rows($res);
}

/*This function allows users to join in the room then, and only then when current date is between StartDate and EndDate. Note: A room exists only in this period.*/
function db_access_room($roomid)
{
	$con = connect();
	if(!$con)
	{
		return false; /*Failed to connect to database*/
	}
	$q = "SELECT start_date, end_date FROM room WHERE room_id = '" . mysqli_real_escape_string($con, $roomid) . "'";
	$res = mysqli_query($con, $q);
	$row = mysqli_fetch_assoc($res);
	
	$start = new DateTime($row['start_date']);
	$start_d = $start->format('Y-m-d H:i:s');
	
	$today = new DateTime("now", new DateTimeZone('Europe/Bucharest') );
	$now = $today->format('Y-m-d H:i:s');
	
	$expire = new DateTime($row['end_date']);
	$expire_d = $expire->format('Y-m-d H:i:s');

	$start_time = strtotime($start_d);
	$now_time = strtotime($now);
	$expire_time = strtotime($expire_d);
	
	if(($expire_time - $now_time >0) && ($now_time - $start_time)>=0)
	{
		return true;
	}
	return false;
}

/*This function let the users join in the room if every data is OK*/
function db_join($email, $roomid)
{
	if(filter_var($roomid, FILTER_VALIDATE_INT) != true)
	{
		return false;
	}
	if($roomid < 1)
	{
		return false;
	}
	$con = connect();
	if(!$con)
	{
		return false; /*Failed to connect to database*/
	}
	if(db_room_exists($roomid) != 1)
	{
		return false; /*No such room with this ID or too_many_rows_exception*/
	}
	if(db_already_in_room($email, $roomid) > 0)
	{
		return false; /*Already is in room*/
	}
	if(db_access_room($roomid) == false)
	{
		return false; /*room expired or not available yet*/
	}
	$id = db_get_userid($email);
	if($id > 0)
	{
		$q = "INSERT INTO inroom (user_id, room_id, all_photos, num_of_persons) VALUES('" . mysqli_real_escape_string($con, $id) . "', '" . mysqli_real_escape_string($con, $roomid) . "', -1, -1)";
		mysqli_query($con, $q);
		mysqli_query($con, "INSERT INTO logs (user_id, log_content, log_date) VALUES('" . $id . "', 'User JOINED IN the . $roomid . room. ', NOW())");
		mysqli_close($con);
		return true;
	}
	else
	{
		return false;
	}
	
}

?>