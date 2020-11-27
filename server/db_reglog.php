<?php

/*this function checks if there already exisits a user with the given email. If so, it returns a positive number, else returns 0*/
function user_already_exists($useremail)
{
	$con = connect();
	$q = "SELECT user_email FROM users WHERE user_email='" . mysqli_real_escape_string($con, $useremail) . "'";
	$res = mysqli_query($con, $q);
	mysqli_close($con);
	return mysqli_num_rows($res);
}

function user_registration($fullname, $email, $password)
{
	if(strlen($fullname)< 1 || strlen($email)<1 || strlen($password)< 1 || strlen($fullname)>150 || strlen($email)>150 || strlen($password)>50)
	{
		return false; /*Length of email and fullname must be between 2-150! Password cannot be empty.*/
	}
	if(user_already_exists($email) > 0)
	{
		return false; /*There have been already a registration with this email!*/
	}
	$password = hash("sha512", $password);
	$con = connect();
	$q = "INSERT INTO users (user_name, user_email, user_pw) VALUES('" . mysqli_real_escape_string($con, $fullname) . "', '" . mysqli_real_escape_string($con, $email) . "', '" . mysqli_real_escape_string($con, $password) . "')";
	mysqli_query($con, $q);
	$res = mysqli_query($con, "SELECT user_id FROM users WHERE user_email = '" . mysqli_real_escape_string($con, $email) . "'");
	$row = mysqli_fetch_assoc($res);
	mysqli_query($con, "INSERT INTO logs (user_id, log_content, log_date) VALUES('" . $row['user_id'] . "', 'SUCCESSFUL Registration. ', NOW())");
	mysqli_close($con);
	return true;
}

/*this function checks if a user can log into his account or not*/
function loginOK($user_email, $user_pw)
{
	if(strlen($user_email) < 3 || strlen($user_email) > 50)
	{
		return false;
	}	
	if(strlen($user_pw)< 1 || strlen($user_pw)>20)
	{
		return false;
	}	
	$con = connect();
	$q = "SELECT user_id, user_email, user_pw FROM users WHERE user_email='" . mysqli_real_escape_string($con, $user_email) . "'";
	$res = mysqli_query($con, $q);
	if (mysqli_num_rows($res) == 0)
	{
		return false; /*No such user*/
	}
	$row = mysqli_fetch_assoc($res);
	if ($row["user_pw"] != hash("sha512", $user_pw))
	{
		return false; /*password doesnt match*/
	}
	mysqli_query($con, "INSERT INTO logs (user_id, log_content, log_date) VALUES('" . $row['user_id'] . "', 'SUCCESSFUL Login. ', NOW())");
	mysqli_close($con);
	return true;
}
?>