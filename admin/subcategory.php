<?php
/*********************************************************
   Author:      Renjith VR
   Version:     1.0
   Date:        06-07-2016
   FileName:    product.php
   Description : Routine for products
**********************************************************/
header("Content-Type:application/json");
error_reporting(E_ALL);

require_once("../settings/helpers.php");
require_once("../settings/subcategorysettings.php");


function rest_put($request)
{
	$parts = parse_url($request);
	$path_parts = pathinfo($parts['path']);
	$id = $path_parts['filename'];
	$result =  array();

	if(!($adminid = sessionValidate(ADMIN_SESSION_ID)))
	{
		header('HTTP/1.1' .'  '. 401 .'  ' .  'Bad Request');
        exit("No Valid Admin Session");
	}

	if(!is_numeric($id))
	{
		header('HTTP/1.1' .'  '. 400 .'  ' .  'Bad Request');
        exit("Subcategory ID is not valid");
	}

	$put_vars = json_decode(file_get_contents('php://input'), true);

	error_log(json_encode($put_vars));

	if(empty($put_vars))
	{
		header('HTTP/1.1' .'  '. 400 .'  ' .  'Bad Request');
        exit("Missing Parameters");
	}

	$result = updateSubcategory($id, $put_vars);

	if(isset($result['error']) && $result['error'] === 'EMPTY')
	{
		header('HTTP/1.1' .'  '. 400 .'  ' .  'Bad Request');
        exit("Error while updating category");
	}

	print json_encode($result);
}

function rest_post($request)
{
	$parts = parse_url($request);
	$path_parts = pathinfo($parts['path']);
	$id = $path_parts['filename'];

	error_log(json_encode($_POST));

	if(!($adminid = sessionValidate(ADMIN_SESSION_ID)))
	{
		header('HTTP/1.1' .'  '. 401 .'  ' .  'Bad Request');
        	exit("No Valid Admin Session");
	}

	if(empty($_POST['title']) || empty($_POST['catid']))
	{
		header('HTTP/1.1' .'  '. 400 .'  ' .  'Bad Request');
        	exit("Missing Parameters");
	}

	$result = createSubcategory($_POST);

	print json_encode($result);
}

function rest_get($request)
{
	$parts = parse_url($request);
	$path_parts = pathinfo($parts['path']);
	$id = $path_parts['filename'];
	$title = NULL;
	$status = NULL;
    	$categorytitle = NULL;
	$catid = NULL;
	$page = 1;

	if(!empty($_GET['page']))
	{
		$page = $_GET['page'];
	}

	if(!empty($_GET['title']))
	{
		$title = $_GET['title'];
	}

    	if(!empty($_GET['status']))
	{
		$status = $_GET['status'];
	}

    	if(!empty($_GET['categorytitle']))
	{
		$categorytitle = $_GET['categorytitle'];
	}

	if(!empty($_GET['catid']))
	{
		$catid = $_GET['catid'];
	}


	if(!($adminid = sessionValidate(ADMIN_SESSION_ID)))
	{
		header('HTTP/1.1' .'  '. 401 .'  ' .  'Bad Request');
        	exit("No Valid Admin Session");
	}

	if($id === "subcategories")
	{
		$result = listSubcategories($title,$status,$categorytitle,$page);
	}
	else if($id === "subcatbycat")
	{
		$result = getSubategoriesbycatid($catid);
	}
	else
	{
		$result = getSubcategoryForAdmin($id);
	}

	if(isset($result['error']) && $result['error'] === 'EMPTY')
	{
		error_log("Error:".json_encode($result));
		return false;
	}

	print json_encode($result);
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

exit(0);

?>
