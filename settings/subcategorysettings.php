<?php
/*********************************************************
   Author:      Renjith VR
   Version:     1.0
   Date:        06-07-2016
   FileName:    categorysettings.php
   Description:  utility functions for category API
**********************************************************/
error_reporting(E_ALL);

function createSubcategory($params)
{
	$mysqlcon = DBConnection();

	$title = $mysqlcon->real_escape_string(trim($params['title']));
    	$catid = $mysqlcon->real_escape_string(trim($params['catid']));
	$status = $mysqlcon->real_escape_string(trim($params['status']));

	$query = "INSERT INTO subcategory (title,idcategory,created) VALUES ('$title','$catid', NOW())";

	error_log($query);

	if(!($stmt = $mysqlcon->prepare($query)))
	{
		error_log("CREATE subcategory Failed: (" . $mysqlcon->errno . ") " . $mysqlcon->error);
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

function getSubategoriesbycatid($catid)
{
	$mysqlcon = DBConnection();

	$query = "SELECT s.title,s.idsubcategory,s.status,s.idcategory,s.created,c.title AS categorytitle FROM subcategory s LEFT JOIN category c ON c.idcategory = s.idcategory WHERE s.idcategory = '$catid' AND s.status= 'YES' AND c.status = 'YES' ";

	error_log($query);

	if(!$result = $mysqlcon->query($query))
	{
		error_log("List subcategory title error: ".$mysqlcon->errno. ": ".$mysqlcon->error);
		$mysqlcon->close();
		return array('error'=> 'List subcategory query error');
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

function getSubcategoryForAdmin($subcatid)
{
	$mysqlcon = DBConnection();

	$query = "SELECT * FROM subcategory WHERE idsubcategory = '$subcatid'";

	error_log($query);

	if(!$result = $mysqlcon->query($query))
	{
		error_log("List subcategory details error: ".$mysqlcon->errno. ": ".$mysqlcon->error);
		$mysqlcon->close();
		return array('error'=> 'List subcategory query error');
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


function updateSubcategory($subcatid,$data)
{
	$mysqlcon = DBConnection();

	$subcatid = $mysqlcon->real_escape_string(trim($subcatid));

	$query = "UPDATE subcategory SET";

	if(!empty($data['title']))
	{
		$subcategorytitle = $mysqlcon->real_escape_string(trim($data['title']));

		$query .= " title = '$subcategorytitle'";

		if((!empty($data['status'])) || (!empty($data['catid'])))
		{
			$query .= ",";
		}
	}

	if(!empty($data['catid']))
	{
		$catid = $mysqlcon->real_escape_string(trim($data['catid']));
        $query .= " idcategory ='$catid'";

		if((!empty($data['status'])))
		{
			$query .= ",";
		}
	}


	if(!empty($data['status']))
	{
		$categorystatus = $mysqlcon->real_escape_string(trim($data['status']));
		$query .= " status ='$categorystatus'";
	}

	$query.= " WHERE idsubcategory ='$subcatid'";

	error_log($query);

	if(!($stmt=$mysqlcon->prepare($query)))
	{
		error_log("Update subcategory failed: (" . $mysqlcon->errno . ") " . $mysqlcon->error);
		return array('error'=> 'Update subcategory failed');
	}

	if(!($stmt->execute()))
	{
		error_log("Update subcategory failed: (" . $stmt->errno . ") " . $stmt->error);

		if($stmt->errno == 1062)
		{
			return array('error'=> 'Duplicate entry');
		}
		else
		{
			return array('error'=> 'Update subcategory failed');
		}

	}

	if($stmt->affected_rows==0)
	{
		error_log("No change in subcategory");
		return array('error'=> 'No change in subcategory');
	}

	$stmt->close();
	$mysqlcon->close();

	return array("success" => $subcatid);
}


function listSubcategories($title=NULL, $status=NULL, $categorytitle=NULL, $page=1)
{
	$mysqlcon = DBConnection();

	$title = $mysqlcon->real_escape_string(trim($title));

	$status = $mysqlcon->real_escape_string(trim($status));
	error_log($status);

    	$categorytitle = $mysqlcon->real_escape_string(trim($categorytitle));

	$query = "SELECT s.title,s.idsubcategory,s.status,s.idcategory,s.created,c.title AS categorytitle FROM subcategory s LEFT JOIN category c ON c.idcategory = s.idcategory WHERE c.status = 'YES'";

    	if((!empty($title)) || (!empty($status)) || (!empty($categorytitle)))
	{
		$query .= " AND ";
	}

	if(!empty($title))
	{
		$query .= "s.title LIKE '%%%$title%%'";

		if((!empty($status)) || (!empty($categorytitle)))
		{
			$query .= " AND ";
		}
	}

    if(!empty($categorytitle))
	{
		$query .= "c.title LIKE '%%%$categorytitle%%'";

	        if(!empty($status))
	        {
	            $query .= " AND ";
	        }
	}

	if(!empty($status))
	{
		$query .= " s.status = '$status'";
	}

	$query .= " ORDER BY s.created DESC";

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
