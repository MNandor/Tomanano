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

function db_user_in_room($user_email, $room_id)
{
	if(db_get_userid($user_email) < 1)
	{
		return false;
	}
	$id = db_get_userid($user_email);
	$con = connect();
	if(!$con)
	{
		return false; /*Failed to connect to database*/
	}
	$q = "SELECT user_id FROM inroom WHERE user_id = '" . mysqli_real_escape_string($con, $id) . "' AND room_id = '" . mysqli_real_escape_string($con, $room_id) . "'";
	$res = mysqli_query($con, $q);
	mysqli_close($con);
	if(!$res)
	{
	    return false;
	}
	if(mysqli_num_rows($res) == 1)
	{
		return true;
	}
	return false;
}

function db_get_result($user_email, $room_id)
{
	if(filter_var($room_id, FILTER_VALIDATE_INT) != true)
	{
		return false;
	}
	if($room_id < 1)
	{
		return false;
	}
	if(db_user_in_room($user_email, $room_id) == false)
	{
		return false;
	}
	$con = connect();
	if(!$con)
	{
		return false; /*Failed to connect to database*/
	}
	$q = "SELECT u.user_email email, i.num_of_persons score FROM users u JOIN inroom i ON (u.user_id = i.user_id) WHERE room_id = '" . mysqli_real_escape_string($con, $room_id) . "' ORDER BY i.num_of_persons DESC";
	$res = mysqli_query($con, $q);
	if(!$res)
	{
	    return false;
	}
	mysqli_close($con);
	return $res;
}
?>