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
	mysqli_close($con);
	return $row['user_id'];
}

/*This function checks if the user has already sent his own score or not. If not, we insert this data in DB.*/
function db_update_score($email, $room, $photos, $persons)
{
	if(filter_var($photos, FILTER_VALIDATE_INT) != true || filter_var($persons, FILTER_VALIDATE_INT) != true || filter_var($room, FILTER_VALIDATE_INT) != true)
	{
		return false; /*these 3 variables must be strict positive and Natural numbers.*/
	}
	if($photos < 0 || $persons < 0 || $room < 1)
	{
		return false;
	}
	$con = connect();
	if(!$con)
	{
		return 0; /*Failed to connect to database*/
	}
	$id = db_get_userid($email);
	if($id < 1)
	{
		return false;
	}
	$q = "SELECT all_photos, num_of_persons FROM inroom WHERE user_id = '" . $id . "' AND room_id = '" . $room . "'";
	$res = mysqli_query($con, $q);
	if(!$res || mysqli_num_rows($res) == 0)
	{
		return false;
	}
	$row = mysqli_fetch_assoc($res);
	if($row['all_photos'] == -1 && $row['num_of_persons'] == -1)
	{
		mysqli_query($con, "UPDATE inroom SET all_photos = '" . $photos . "', num_of_persons = '" . $persons . "' WHERE user_id = '" . $id . "' AND room_id = '" . $room . "'");
		mysqli_query($con, "INSERT INTO logs (user_id, log_content, log_date) VALUES('" . $id . "', 'User sent his score: all photos: .$photos ., number of all different people: .$persons. ', NOW())");
		mysqli_close($con);
		return true;
	}
	else
	{
		return false;
	}
}
?>