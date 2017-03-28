<?php
/*********************************************************
   Author:      Renjith VR
   Version:     1.0
   Date:        06-07-2016
   FileName:    dashboardsettings.php
   Description:  utility functions for dashboard API
**********************************************************/
error_reporting(E_ALL);

function getcategoriescount()
{
        $mysqlcon = DBConnection();

        $query = "SELECT count(*) AS count FROM category";

	error_log($query);

	if(!$result = $mysqlcon->query($query))
	{
		error_log("Get catgeory count query error: ".$mysqlcon->errno. ": ".$mysqlcon->error);
		$mysqlcon->close();
		return array('error'=> 'Get catgeory count query error');
	}

	if($result->num_rows == 0)
	{
		$mysqlcon->close();
		return array('error'=> 'Empty');
	}

	$count = $result->fetch_assoc();

	$result->close();
	$mysqlcon->close();

	return $count;
}

function getactivecategoriescount()
{
        $mysqlcon = DBConnection();

        $query = "SELECT count(*) AS count FROM category WHERE status ='YES'";

	error_log($query);

	if(!$result = $mysqlcon->query($query))
	{
		error_log("Get active catgeory count query error: ".$mysqlcon->errno. ": ".$mysqlcon->error);
		$mysqlcon->close();
		return array('error'=> 'Get active catgeory count query error');
	}

	if($result->num_rows == 0)
	{
		$mysqlcon->close();
		return array('error'=> 'Empty');
	}

	$count = $result->fetch_assoc();

	$result->close();
	$mysqlcon->close();

	return $count;
}

function getsubcategoriescount()
{
        $mysqlcon = DBConnection();

        $query = "SELECT count(*) AS count FROM subcategory";

	error_log($query);

	if(!$result = $mysqlcon->query($query))
	{
		error_log("Get subcatgeory count query error: ".$mysqlcon->errno. ": ".$mysqlcon->error);
		$mysqlcon->close();
		return array('error'=> 'Get subcatgeory count query error');
	}

	if($result->num_rows == 0)
	{
		$mysqlcon->close();
		return array('error'=> 'Empty');
	}

	$count = $result->fetch_assoc();

	$result->close();
	$mysqlcon->close();

	return $count;
}

function getactivesubcategoriescount()
{
        $mysqlcon = DBConnection();

        $query = "SELECT count(*) AS count FROM subcategory WHERE status ='YES'";

	error_log($query);

	if(!$result = $mysqlcon->query($query))
	{
		error_log("Get active subcatgeory count query error: ".$mysqlcon->errno. ": ".$mysqlcon->error);
		$mysqlcon->close();
		return array('error'=> 'Get subactive catgeory count query error');
	}

	if($result->num_rows == 0)
	{
		$mysqlcon->close();
		return array('error'=> 'Empty');
	}

	$count = $result->fetch_assoc();

	$result->close();
	$mysqlcon->close();

	return $count;
}

function getproductscount()
{
        $mysqlcon = DBConnection();

        $query = "SELECT count(*) AS count FROM product";

	error_log($query);

	if(!$result = $mysqlcon->query($query))
	{
		error_log("Get product count query error: ".$mysqlcon->errno. ": ".$mysqlcon->error);
		$mysqlcon->close();
		return array('error'=> 'Get product count query error');
	}

	if($result->num_rows == 0)
	{
		$mysqlcon->close();
		return array('error'=> 'Empty');
	}

	$count = $result->fetch_assoc();

	$result->close();
	$mysqlcon->close();

	return $count;
}

function getactiveproductscount()
{
        $mysqlcon = DBConnection();

        $query = "SELECT count(*) AS count FROM product WHERE status ='YES'";

	error_log($query);

	if(!$result = $mysqlcon->query($query))
	{
		error_log("Get active product count query error: ".$mysqlcon->errno. ": ".$mysqlcon->error);
		$mysqlcon->close();
		return array('error'=> 'Get active product count query error');
	}

	if($result->num_rows == 0)
	{
		$mysqlcon->close();
		return array('error'=> 'Empty');
	}

	$count = $result->fetch_assoc();

	$result->close();
	$mysqlcon->close();

	return $count;
}

function getlastthreecategories()
{
        $mysqlcon = DBConnection();

        $query = "SELECT * FROM category ORDER BY created DESC LIMIT 0,3";

        error_log($query);

        if(!$result = $mysqlcon->query($query))
        {
                error_log("Get last three categories count query error: ".$mysqlcon->errno. ": ".$mysqlcon->error);
                $mysqlcon->close();
                return array('error'=> 'Get last three categories count query error');
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

function getlastthreesubcategories()
{
        $mysqlcon = DBConnection();

        $query = "SELECT * FROM subcategory ORDER BY created DESC LIMIT 0,3";

        error_log($query);

        if(!$result = $mysqlcon->query($query))
        {
                error_log("Get last three subcategories count query error: ".$mysqlcon->errno. ": ".$mysqlcon->error);
                $mysqlcon->close();
                return array('error'=> 'Get last three subcategories count query error');
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


function getlastthreeproducts()
{
        $mysqlcon = DBConnection();

        $query = "SELECT * FROM product ORDER BY created DESC LIMIT 0,3";

        error_log($query);

        if(!$result = $mysqlcon->query($query))
        {
                error_log("Get last three products count query error: ".$mysqlcon->errno. ": ".$mysqlcon->error);
                $mysqlcon->close();
                return array('error'=> 'Get last three products count query error');
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


?>
