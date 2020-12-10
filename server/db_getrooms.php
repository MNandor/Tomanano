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

/*This function returnes a list of all the rooms that user has joined*/
function db_get_roomlist($email)
{	
	$userid = db_get_userid($email);
	if($userid < 1)
	{
		return false; /*No such user*/
	}
	$con = connect();
	if(!$con)
	{
		return false; /*Failed to connect to database*/
	}
	$q = "SELECT r.room_id room_id, r.room_name room_name, r.start_date start_date, r.end_date end_date FROM inroom i JOIN room r ON (i.room_id = r.room_id) WHERE i.user_id = $userid";
	$res = mysqli_query($con, $q);
	if(!$res)
	{
		return false; /*error with query*/
	}
	return $res;
}

?>