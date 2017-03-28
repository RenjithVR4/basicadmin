<?php
/*********************************************************
   Author:      Renjith VR
   Version:     1.0
   Date:        06-07-2016
   FileName:    dashboard.php
   Description : Routine for admin dashboard
**********************************************************/
header("Content-Type:application/json");
error_reporting(E_ALL);

require_once("../settings/helpers.php");
require_once("../settings/dashboardsettings.php");


function rest_put($request)
{
        header('HTTP/1.1' .'  '. 405 .'  ' .  'Bad Request');
        exit("This method is not allowed");
}

function rest_post($request)
{
        header('HTTP/1.1' .'  '. 405 .'  ' .  'Bad Request');
        exit("This method is not allowed");
}

function rest_get($request)
{
        if(!($adminid = sessionValidate(ADMIN_SESSION_ID)))
	{
		header('HTTP/1.1' .'  '. 401 .'  ' .  'Bad Request');
        	exit("No Valid Admin Session");
	}

	$parts = parse_url($request);
	$path_parts = pathinfo($parts['path']);
	$id = $path_parts['filename'];
	$title = NULL;
	$status = NULL;
	$page = 1;
        
	switch($id)
        {
	        case 'categoriescount':
	                $result = getcategoriescount();
	                break;
                case 'categoriesactivecount':
	                $result = getactivecategoriescount();
	                break;
                case 'subcategoriescount':
	                $result = getsubcategoriescount();
	                break;
                case 'subcategoriesactivecount':
	                $result = getactivesubcategoriescount();
	                break;
                case 'productscount':
	                $result = getproductscount();
	                break;
                case 'productsactivecount':
	                $result = getactiveproductscount();
	                break;
                case 'lastthreecategories':
	                $result = getlastthreecategories();
	                break;
                case 'lastthreesubcategories':
	                $result = getlastthreesubcategories();
	                break;
                case 'lastthreeproducts':
	                $result = getlastthreeproducts();
	                break;
	        default:
	                $result  = array('error');
	                break;
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
