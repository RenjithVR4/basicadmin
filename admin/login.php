<?php
/*********************************************************
   Author: 	   Renjith VR
   Version: 	1.0
   Date:		04-Nov-2016
   FileName: 	login.php
   Description:	Admin Login
**********************************************************/

error_reporting(E_ALL);

require_once("../settings/helpers.php");

header("Content-Type:application/json");

function rest_get($request)
{
	//Get Subscriber Id
	$parts = parse_url($request);
	$path_parts = pathinfo($parts['path']);
	$id = $path_parts['filename'];

	if(!isset($_GET['password']) || !isset($_GET['email']))
	{
		header('HTTP/1.1' .'  '. 400 .'  ' .  'Bad Request');
                exit("Missing Parameters");
	}

	if(!($result = verifyAccount($_GET['email'],$_GET['password'])))
	{
		error_log($result);
		print json_encode(array('error'=>'Login Failed. Check Username/Password'));
		exit(0);
	}

	//Start session
	session_start();
	//Login is successful
	session_regenerate_id();
	$_SESSION[ADMIN_SESSION_ID] = $result["idadmin"];
	$_SESSION['SESS_NAME'] = $result['name'];
	$_SESSION['SESS_EMAIL'] = $result['email'];
	$_SESSION['LOGIN_TIME'] = time();
	session_write_close();

	print json_encode($result);

}

function verifyAccount($email,$password)
{
	$mysqlcon = DBConnection();

	// error_log(json_encode($mysqlcon));

	$email = $mysqlcon->real_escape_string(trim($email));
	$password = $mysqlcon->real_escape_string(trim($password));

	$password = generateHash($password);

	error_log($password);

	$query = "SELECT * FROM admin WHERE email = '$email'" ;

	error_log($query);

	//Execute query
	if(!($result = $mysqlcon->query($query)))
	{
		error_log("Admin login failed: (" . $mysqlcon->errno . ") " . $mysqlcon->error);
		return  false;
	}

	if ($result->num_rows == 0)
	{
		error_log('No login match for admin with email / password : '. $email);
		return false;
	}

	$row = $result->fetch_assoc();

	$result->close();
	$mysqlcon->close();

	if($password != $row['password'])
	{
		return false;
	}

	unset($row['password']);

	return $row;
}

//First check what is the method
if(!isset($_SERVER['REQUEST_METHOD']) || !isset($_SERVER['REQUEST_URI']))
{
	header('HTTP/1.1'.'  '. 400 .'  '. 'Bad Request');
	exit("HTTP Method or request URI is not set");
}

$method = $_SERVER['REQUEST_METHOD'];
$request = $_SERVER['REQUEST_URI'];

if($method!='GET')
{
	header('HTTP/1.1'. '  '. 405 .'  '. 'Bad Request');
	exit("HTTP Method not allowed'");
}

rest_get($request);

exit(0);
?>
