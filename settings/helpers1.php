<?php
error_reporting(E_ALL);

define('ADMIN_SESSION_ID', 'AMTHARADMINid');


function DBConnection()
{
	//Now create db connection
	$mysqlcon = new mysqli('mysql.hostinger.ae', 'u903222557_root', 'rootamthar','u903222557_amath');

	if ($mysqlcon->connect_errno)
	{
		 error_log("Failed to connect to MySQL: (" . $mysqlcon->connect_errno . ") " . $mysqlcon->connect_error);
		 return false;
	}

	return $mysqlcon;
}


function generateHash($password)
{
          if (defined("CRYPT_BLOWFISH") && CRYPT_BLOWFISH)
          {
                    $salt = '$2y$11$' . substr(md5('AMTHAR'), 0, 22);
                    return crypt($password, $salt);
          }
}

function sessionValidate($roleid,$id=NULL)
{
	session_start();

	if(!isset($_SESSION[$roleid]))
	{
		return false;
	}

	if(!empty($id) && $_SESSION[$roleid] !== $id)
	{
		return false;
	}

	$id = $_SESSION[$roleid];

	if((time() - $_SESSION['LOGIN_TIME']) >= 3600)
	{
		error_log('Session Expired: '.$id.' from '.$_SERVER['REMOTE_ADDR']);
		session_destroy();
		return false;
	}


	return $id;
}


 ?>
