<?php
/*********************************************************
   Author:      Renjith VR
   Version:     1.0
   Date:        06-07-2016
   FileName:    contact.php
   Description : Routine for View Contact
**********************************************************/
header("Content-Type:application/json");
error_reporting(E_ALL);

require_once("../settings/helpers.php");

function rest_put($request)
{
	header('HTTP/1.1' .'  '. 405 .'  ' .  'Bad Request');
        exit("This method is not allowed");
}

function rest_post($request)
{
        $parts = parse_url($request);
	$path_parts = pathinfo($parts['path']);
	$id = $path_parts['filename'];

        if(empty($_POST['name']) || empty($_POST['email']) || empty($_POST['message']))
        {
                header('HTTP/1.1' .'  '. 400 .'  ' .  'Bad Request');
                exit("Missing Parameters");
        }

        if(!empty($_POST['name']))
	{
		$page = trim($_POST['name']);
	}

        if(!empty($_POST['email']))
	{
		$email = trim($_POST['email']);
	}

        if(!empty($_POST['message']))
	{
		$message = trim($_POST['message']);
	}

        $result = sendMessage($page,$email,$message);

        if(isset($result['error']) && $result['error'] === 'EMPTY')
	{
		error_log("Error:".json_encode($result));
		return false;
	}

	print json_encode($result);
}

function rest_get($request)
{
        header('HTTP/1.1' .'  '. 405 .'  ' .  'Bad Request');
        exit("This method is not allowed");
}

function rest_delete($request)
{
	header('HTTP/1.1' .'  '. 405 .'  ' .  'Bad Request');
        exit("This method is not allowed");
}

function rest_head($request)
{
	header('HTTP/1.1' .'  '. 405 .'  ' .  'Bad Request');
        exit("This method is not allowed");
}

function rest_options($request)
{
	header('HTTP/1.1' .'  '. 405 .'  ' .  'Bad Request');
        exit("This method is not allowed");
}

function rest_error($request)
{
	header('HTTP/1.1' .'  '. 405 .'  ' .  'Bad Request');
        exit("This method is not allowed");
}

//First check what is the method
if(!isset($_SERVER['REQUEST_METHOD']) || !isset($_SERVER['REQUEST_URI']))
{
    header('HTTP/1.1' .'  '. 400 .'  ' .  'Bad Request');
    exit("HTTP Method or request URI is not set");
}


$method = $_SERVER['REQUEST_METHOD'];
$request = $_SERVER['REQUEST_URI'];

switch($method)
{
	case 'POST':
	rest_post($request);
	break;

	case 'GET':
	rest_get($request);
	break;

	case 'PUT':
	rest_put($request);
	break;

	case 'DELETE':
	rest_delete($request);
	break;

	case 'HEAD':
	rest_head($request);
	break;

	case 'OPTIONS':
	rest_options($request);
	break;

	default:
	rest_error($request);
	break;
}

function sendMessage($name,$email,$message)
{
        $to      = 'renjithvr.gre@gmail.com';
        $subject = 'User Message -'. $name;
        $headers = 'From: '. $email . "\r\n" .
            'Reply-To: '. $email . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        $email = mail($to, $subject, $message, $headers);

        if(!$email)
        {
                return array('error'=> 'Email not send');
        }

        return array('success'=> 'Email sent successfully');
}


exit(0);

?>
