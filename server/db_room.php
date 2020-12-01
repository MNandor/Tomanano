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

/*This function verifies if the given room name exists or not.*/
function room_already_exists($room_name)
{
	$con = connect();
	if(!$con)
	{
		return false; /*failed to connect to MySQL database*/
	}
	$q = "SELECT room_name FROM room WHERE room_name='" . mysqli_real_escape_string($con, $room_name) . "'";
	$res = mysqli_query($con, $q);
	mysqli_close($con);
	return mysqli_num_rows($res);
}

/*This function verifies whether the given user exists or not.*/
function user_exists($user_email)
{
	$con = connect();
	if(!$con)
	{
		return false; /*failed to connect to MySQL database*/
	}
	$q = "SELECT user_id FROM users WHERE user_email='" . mysqli_real_escape_string($con, $user_email) . "'";
	$res = mysqli_query($con, $q);
	mysqli_close($con);
	return mysqli_num_rows($res);
}

/*this function return true if the given date is correct.*/
function validateDate($date, $format = 'Y-m-d H:i:s')
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}

/*this function verifies if the second date greater than the first one*/
function valid_dates($date1, $date2)
{
	$start = new DateTime($date1);
	$start_d = $start->format('Y-m-d H:i:s');
	
	$expire = new DateTime($date2);
	$expire_d = $expire->format('Y-m-d H:i:s');

	$start_time = strtotime($start_d);
	$expire_time = strtotime($expire_d);
	
	if(($expire_time - $start_time)>0)
	{
		return true;
	}
	return false;
}

/*This function inserts a new row in database, so creates a new room*/
function db_createRoom($created_by, $room_name, $start_date, $end_date)
{
	if(user_exists($created_by) == 0)
	{
		return false; /*No such user in database.*/
	}
	if(strlen($room_name)< 5 || strlen($room_name) > 250)
	{
		return false; /*Length of room must be a value between 5-250.*/
	}
	if(room_already_exists($room_name) > 0)
	{
		return false; /*Another room has already been created with this name.*/
	}
	if(strlen($start_date)< 1 || strlen($end_date)< 1)
	{
		return false; /*these fields cannot be empty.*/
	}
	if(validateDate($start_date) == false || validateDate($end_date) == false)
	{
		return false;  /*incorrect date formats.*/
	}
	if(valid_dates($start_date, $end_date) == false)
	{
		return false; /*logically not correct dates.*/
	}
	$con = connect();
	if(!$con)
	{
		return false; /*failed to connect to MySQL database*/
	}
	$id = db_get_userid($created_by);
	if($id > 0)
	{
		$q = "INSERT INTO room(created_by, room_name, start_date, end_date) VALUES('" . $id . "', '" . mysqli_real_escape_string($con, $room_name) . "', '" . mysqli_real_escape_string($con, $start_date) . "', '" . mysqli_real_escape_string($con, $end_date) . "')";
		mysqli_query($con, $q);
		mysqli_close($con);
		return true;
	}
	else
	{
		return false;
	}	
}

function db_return_roomid($user_email, $room_name)
{
	$con = connect();
	if(!$con)
	{
		return false; /*failed to connect to MySQL database*/
	}
	$res = mysqli_query($con, "SELECT u.user_id u_id, r.room_id r_id FROM users u JOIN room r ON (u.user_id = r.created_by) WHERE r.room_name = '" . $room_name . "' AND u.user_email = '" . $user_email . "'");
	if(!$res)
	{
		return false;
	}
	$row = mysqli_fetch_assoc($res);
	$u_id = $row['u_id'];
	$r_id = $row['r_id'];
	mysqli_query($con, "INSERT INTO logs (user_id, log_content, log_date) VALUES('" . $u_id . "', 'Room with ID = . $r_id . created successfully. ', NOW())");
	mysqli_close($con);
	return $r_id;
}

?>