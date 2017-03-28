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
	$parts = parse_url($request);
	$path_parts = pathinfo($parts['path']);
	$id = $path_parts['filename'];
	$title = NULL;
    $catid = NULL;
	$page = 1;
	
	error_log($id);

	if(!empty($_GET['page']))
	{
		$page = $_GET['page'];
	}

	if(!empty($_GET['title']))
	{
		$title = $_GET['title'];
	}

    if(!empty($_GET['catid']))
	{
		$catid = $_GET['catid'];
	}

	if($id === "subcategories")
	{
		$result = listSubcategories($title,$catid,$page);
	}
	else
	{
		$result = getSubcategoryForView($id);
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

function listSubcategories($title=NULL, $catid=NULL, $page=1)
{
	$mysqlcon = DBConnection();

	$title = $mysqlcon->real_escape_string(trim($title));

    $catid = $mysqlcon->real_escape_string(trim($catid));

	$query = "SELECT * FROM subcategory  WHERE status = 'YES'";

	if(!empty($title))
	{
		$query .= " AND title LIKE '%%%$title%%'";
	}

    if(!empty($catid))
	{
		$query .= " AND idcategory = '$catid'";
	}

	$limit = $page-1;

	$query.= " LIMIT ". ($limit*15) . ",15";

	error_log($query);

	if(!($result = $mysqlcon->query($query)))
	{
		error_log("List subcategory failed :".$mysqlcon->errno.": ".$mysqlcon->error);
		$mysqlcon->close();
		return array('error'=> 'List subcategory failed');
	}

	if($result->num_rows == 0)
	{
		$mysqlcon->close();
		return array('error'=> 'Empty');
	}

	$values = array();
	while($row = $result->fetch_assoc())
	{
		$values[] = $row;
	}

	$result->close();
	$mysqlcon->close();

	return $values;
}

function getSubcategoryForView($subcatid)
{
	$mysqlcon = DBConnection();

	$query = "SELECT * FROM subcategory WHERE idsubcategory = '$subcatid' AND status = 'YES'";

	error_log($query);

	if(!$result = $mysqlcon->query($query))
	{
		error_log("Get subcategory details error: ".$mysqlcon->errno. ": ".$mysqlcon->error);
		$mysqlcon->close();
		return array('error'=> 'Get subcategory query error');
	}

	if($result->num_rows == 0)
	{
		$mysqlcon->close();
		return array('error'=> 'Empty');
	}

	$row = $result->fetch_assoc();

	$result->close();
	$mysqlcon->close();

	return $row;
}


exit(0);

?>
