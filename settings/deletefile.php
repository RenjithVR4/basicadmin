<?php
/*********************************************************
   Author:      Renjith VR
   Version:     1.0
   Date:        06-07-2016
   FileName:    imagesettings.php
   Description:  Image API
**********************************************************/
header("Content-Type:application/json");
error_reporting(E_ALL);

require_once("../settings/helpers.php");


if(!isset($_SERVER['REQUEST_METHOD']) || !isset($_SERVER['REQUEST_URI']))
{
    header('HTTP/1.1' .'  '. 400 .'  ' .  'Bad Request');
    exit("HTTP Method or request URI is not set");
}

$method = $_SERVER['REQUEST_METHOD'];
$request = $_SERVER['REQUEST_URI'];

if($method !== 'POST')
{
	header('HTTP/1.1' .'  '. 405 .'  ' .  'Bad Request');
        exit("Only POST method is allowed");
}

$path_parts = pathinfo($request);
$id = $path_parts['filename'];

if(!($adminid = sessionValidate(ADMIN_SESSION_ID)))
{
        header('HTTP/1.1' .'  '. 401 .'  ' .  'Bad Request');
        exit("No Valid Admin Session");
}

if(empty($_POST['image']))
{
        header('HTTP/1.1' .'  '. 400 .'  ' .  'Bad Request');
        exit("Empty image");
}

$image = trim($_POST['image']);

$result = deleteImagefile($image);

if(isset($result['error']) && $result['error'] === 'EMPTY')
{
        header('HTTP/1.1' .'  '. 400 .'  ' .  'Bad Request');
        exit("Error while deleting image");
}

print json_encode($result);


function deleteImagefile($image)
{
        $file = '../uploads/'.$image;

	if (!unlink($file))
	{
		error_log("Image is not deleted");
		$result =  array('error'=> 'Image is not deleted');
	}
	else
	{
		error_log("Image file has been deleted". $image);
	  	$result =  array('success'=> $image);
	}

	return $result;
}

?>
