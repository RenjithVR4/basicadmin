<?php
error_reporting(E_ALL);

define('ADMIN_SESSION_ID', 'BASICADMINid');


function DBConnection()
{
	$mysqlcon = new mysqli('localhost', 'root', 'root','basicadmin');

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

function getBrowser()
{


	  $browser = "";

	  if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== FALSE)
	  {
	    $browser = 'Internet explorer';
	  }
	  elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Trident') !== FALSE) //For Supporting IE 11
	  {
	    $browser =  'Internet explorer';
	  }
	  elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox') !== FALSE)
	  {
	    $browser = 'Mozilla Firefox';
	  }
	  elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') !== FALSE)
	  {
	    $browser =  'Google Chrome';
	  }
	  elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mini') !== FALSE)
	  {
	    $browser =  "Opera Mini";
	  }
	  elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Opera') !== FALSE)
	  {
	   $browser = "Opera";
	  }
	  elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Safari') !== FALSE)
	  {
	   $browser =  "Safari";
	  }
	  else
	  {
	    $browser =  'UnKnown';
	  }

	  error_log("Browser ==> " . $browser);

	  return $browser;

}



 ?>
