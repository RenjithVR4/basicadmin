<?php
/*********************************************************
   Author:      Renjith VR
   Version:     1.0
   Date:        06-07-2016
   FileName:    categorysettings.php
   Description:  utility functions for category API
**********************************************************/
error_reporting(E_ALL);

function createCategory($params)
{
	$mysqlcon = DBConnection();

	$title = $mysqlcon->real_escape_string(trim($params['title']));

	$query = "INSERT INTO category(title, created) VALUES ('$title',NOW())";

	error_log($query);

	if(!($stmt = $mysqlcon->prepare($query)))
	{
		error_log("CREATE category Failed: (" . $mysqlcon->errno . ") " . $mysqlcon->error);
		$mysqlcon->close();
		return array('error'=> 'Create query failed');
	}

	//Execute query
	if(!$stmt->execute())
	{
		error_log("Unable to insert data: (" . $stmt->errno . ") " . $stmt->error);
		$mysqlcon->close();

		if($stmt->errno == 1062)
		{
			return array('error'=> 'Duplicate Entry');
		}
		else
		{
			return array('error'=> $stmt->error);
		}
	}

	if($stmt->affected_rows==0)
	{
		error_log("Duplicate Entry");
		$mysqlcon->close();
		return array('error'=> 'Duplicate Entry');
	}

	$stmt->close();
	$mysqlcon->close();

	return array('success'=> $params['title']);

}

function getCategoryTitlesForAdmin()
{
	$mysqlcon = DBConnection();

	$query = "SELECT title FROM category";

	error_log($query);

	if(!$result = $mysqlcon->query($query))
	{
		error_log("List category title error: ".$mysqlcon->errno. ": ".$mysqlcon->error);
		$mysqlcon->close();
		return array('error'=> 'List category query error');
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

function getCatagoryForAdmin($catid)
{
	$mysqlcon = DBConnection();

	$catid = $mysqlcon->real_escape_string(trim($catid));

	$query = "SELECT * FROM category WHERE idcategory = '$catid'";

	error_log($query);

	if(!$result = $mysqlcon->query($query))
	{
		error_log("List category details error: ".$mysqlcon->errno. ": ".$mysqlcon->error);
		$mysqlcon->close();
		return array('error'=> 'List category query error');
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


function updateCategory($catid,$data)
{
	$mysqlcon = DBConnection();


	error_log(json_encode($data));

	if(!empty($data['title']))
	{
		$categorytitle = $mysqlcon->real_escape_string(trim($data['title']));
	}

	$query = "UPDATE category SET title='$categorytitle'";

	if(!empty($data['status']))
	{
		$categorystatus = $mysqlcon->real_escape_string(trim($data['status']));
		$query .= ", status='$categorystatus'";
	}

	$query.= " WHERE idcategory ='$catid'";

	error_log($query);

	if(!($stmt=$mysqlcon->prepare($query)))
	{
		error_log("Update category failed: (" . $mysqlcon->errno . ") " . $mysqlcon->error);
		return array('error'=> 'Update category failed');
	}

	if(!($stmt->execute()))
	{
		error_log("Update category failed: (" . $stmt->errno . ") " . $stmt->error);

		if($stmt->errno == 1062)
		{
			return array('error'=> 'Duplicate entry');
		}
		else
		{
			return array('error'=> 'Update category failed');
		}

	}

	if($stmt->affected_rows==0)
	{
		error_log("No change in category");
		return array('error'=> 'No change in category');
	}

	$stmt->close();
	$mysqlcon->close();

	return array("success" => $catid);
}


function listCategories($title=NULL, $status=NULL, $page=1)
{
	$mysqlcon = DBConnection();

	error_log($title);

	$title = $mysqlcon->real_escape_string(trim($title));

	$status = $mysqlcon->real_escape_string(trim($status));

	$query = "SELECT * FROM category ";

	if((!empty($title)) || (!empty($status)))
	{
		$query .= " WHERE ";
	}

	if(!empty($title))
	{
		$query .= "title LIKE '%%%$title%%'";

		if(!empty($status))
		{
			$query .= " AND ";
		}
	}

	if(!empty($status))
	{
		$query .= " status = '$status'";
	}

	$query .= "ORDER BY created DESC";

	$limit = $page-1;

	$query.= " LIMIT ". ($limit*15) . ",15";


	error_log($query);

	if(!($result = $mysqlcon->query($query)))
	{
		error_log("List category failed :".$mysqlcon->errno.": ".$mysqlcon->error);
		$mysqlcon->close();
		return array('error'=> 'List category failed');
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
