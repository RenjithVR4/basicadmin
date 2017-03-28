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
	$subcatid = NULL;
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

	if(!empty($_GET['subcatid']))
	{
		$subcatid = $_GET['subcatid'];
	}

	if($id === "products")
	{
		$result = listProducts($title,$catid,$subcatid,$page);
	}
	elseif($id === "featured")
	{
		$result = listfeaturedProducts();
	}
	else
	{
		$result = getProductForView($id);
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

function getProductForView($productid)
{
	$mysqlcon = DBConnection();

	$query = "SELECT * FROM product WHERE idproduct = '$productid' AND status = 'YES'";

	error_log($query);

	if(!$result = $mysqlcon->query($query))
	{
		error_log("Get product query error: ".$mysqlcon->errno. ": ".$mysqlcon->error);
		$mysqlcon->close();
		return array('error'=> 'Get product query error');
	}

	if($result->num_rows == 0)
	{
		$mysqlcon->close();
		return array('error'=> 'Empty');
	}

	$row = $result->fetch_assoc();

	if(isset($row['description']) && (!empty($row['description'])))
	{
		$row['description'] = base64_decode($row['description']);
	}

	$result->close();
	$mysqlcon->close();

	return $row;
}


function listProducts($title=NULL, $catid=NULL, $subcatid=NULL, $page=1)
{
	$mysqlcon = DBConnection();

	$title = $mysqlcon->real_escape_string(trim($title));

    	$catid = $mysqlcon->real_escape_string(trim($catid));

	$subcatid = $mysqlcon->real_escape_string(trim($subcatid));

	$query = "SELECT * FROM product WHERE status = 'YES' ";

	if(!empty($title))
	{
		$query .= " AND title LIKE '%%%$title%%'";
	}

    	if(!empty($catid))
	{
		$query .= " AND  idcategory = '$catid'";
	}

	if(!empty($subcatid))
	{
		$query .= " AND  idsubcategory = '$subcatid'";
	}

	$limit = $page-1;

	$query.= " LIMIT ". ($limit*15) . ",15";

	error_log($query);

	if(!($result = $mysqlcon->query($query)))
	{
		error_log("List view product failed :".$mysqlcon->errno.": ".$mysqlcon->error);
		$mysqlcon->close();
		return array('error'=> 'List view product failed');
	}

	if($result->num_rows == 0)
	{
		$mysqlcon->close();
		return array('error'=> 'Empty');
	}

	$values = array();
	while($row = $result->fetch_assoc())
	{

		if(isset($row['description']) && (!empty($row['description'])))
		{
			$row['description'] = base64_decode($row['description']);
		}
		$values[] = $row;
	}

	error_log(json_encode($values));

	$result->close();
	$mysqlcon->close();

	return $values;
}

function listfeaturedProducts()
{
	$mysqlcon = DBConnection();

	$query = "SELECT * FROM product WHERE featured = 'YES' ";

	error_log($query);

	if(!($result = $mysqlcon->query($query)))
	{
		error_log("List view featured product failed :".$mysqlcon->errno.": ".$mysqlcon->error);
		$mysqlcon->close();
		return array('error'=> 'List featured product failed');
	}

	if($result->num_rows == 0)
	{
		$mysqlcon->close();
		return array('error'=> 'Empty');
	}

	$values = array();
	while($row = $result->fetch_assoc())
	{
		if(isset($row['description']) && (!empty($row['description'])))
		{
			$row['description'] = base64_decode($row['description']);
		}
		$values[] = $row;
	}

	error_log(json_encode($values));

	$result->close();
	$mysqlcon->close();

	return $values;

}

exit(0);

?>
