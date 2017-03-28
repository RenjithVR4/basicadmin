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


if(!isset($_SERVER['REQUEST_METHOD']) || !isset($_SERVER['REQUEST_URI']))
{
    header('HTTP/1.1' .'  '. 400 .'  ' .  'Bad Request');
    exit("HTTP Method or request URI is not set");
}

$method = $_SERVER['REQUEST_METHOD'];
$request = $_SERVER['REQUEST_URI'];

if(!($method === 'PUT' || $method === 'POST'))
{
	header('HTTP/1.1' .'  '. 405 .'  ' .  'Bad Request');
    exit("Only PUT & POST method is allowed");
}

error_log(json_encode($_FILES)); 

if(!empty($_FILES['image']['name']))
{
	$imageSize = $_FILES['image']['size'];
	$imagename = trim($_FILES['image']['name']);
	$sourcefile = $_FILES['image']['tmp_name'];
	$imagefile = explode('.',$imagename);
	$imageFileType = $imagefile[1];
	$dir= "../uploads";
	$filename = preg_replace('/\s+/', '', $imagename);
	$newname = substr(md5($filename), 0, 8);
	$filename = $newname.'.'.$imageFileType;
	$targetfile = $dir.'/'.$filename;

	if($imageSize > 1000000)
	{
		error_log("Image size is more than 1 MB");
		print json_encode(array('error'=>'Image size  is more than 1 MB'));
		exit(0);
	}

	error_log($imageFileType);

	$imagetypes = array('jpg','png','jpeg','gif');

	if(!in_array($imageFileType,$imagetypes))
	{
		error_log("Invalid image file format");
		print json_encode(array('error'=>'Invalid file format'));
		exit(0);
	}

	if(file_exists($targetfile))
	{
		error_log("File already exists");
		print json_encode(array('error'=>'Image already exists'));
		exit(0);
	}

	if(!move_uploaded_file($sourcefile,$targetfile))
	{
		error_log("Image is not uploaded");
		print json_encode(array('error'=>'Image is not uploaded. Try again'));
		exit(0);
	}

	print json_encode(array('success'=> $filename));
}
else
{
	print json_encode(array('error'=> 'Error in image file upload'));
}



?>
