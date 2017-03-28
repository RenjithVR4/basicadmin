<?php
/*********************************************************
   Author:      Renjith VR
   Version:     1.0
   Date:        05-06-2016
   FileName:    logout.php
   Description:  Used to logout from admin portal
**********************************************************/

error_reporting(E_ALL);

require_once("../settings/helpers.php");

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

if(!($adminid = sessionValidate(ADMIN_SESSION_ID)))
{
      header('HTTP/1.1'. '  '. 401 .'  '. 'Bad Request');
      exit("No valid session exist'");
}
// echo $adminid;exit;
if(empty($adminid))
{
    header('HTTP/1.1'.'  '. 400 .'  '. 'Bad Request');
    exit("Admin id is missing");
}

if($adminid)
{
     //remove the session
     session_destroy();
     error_log('Session destroyed. logged out');
     print json_encode(array('success'=>$adminid));
}

error_log("Basic Admin Logout - ".$adminid);
exit(0);
?>
