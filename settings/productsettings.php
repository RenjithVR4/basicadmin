<?php
/*********************************************************
   Author:      Renjith VR
   Version:     1.0
   Date:        06-07-2016
   FileName:    productsettings.php
   Description:  utility functions for product API
**********************************************************/
error_reporting(E_ALL);

function createProduct($params)
{
	$mysqlcon = DBConnection();

	$title = $mysqlcon->real_escape_string(trim($params['title']));
    	$catid = $mysqlcon->real_escape_string(trim($params['catid']));

	$query = "INSERT INTO product (title,idcategory, ";

	if(!empty($params['subcatid']))
	{
		$subcatid = $mysqlcon->real_escape_string(trim($params['subcatid']));
		$query .= "idsubcategory, ";
	}

	if(!empty($params['description']))
	{
		$desc = $mysqlcon->real_escape_string(base64_encode($params['description']));
		$query .= "description, ";
	}

	if(!empty($params['image']))
	{
		$image = $mysqlcon->real_escape_string(trim($params['image']));
		$query .= "image, ";
	}

	$query .= "created) ";

	$query .= "VALUES ('$title','$catid', ";

	if(!empty($params['subcatid']))
	{
		$query .= "'$subcatid',";
	}

	if(!empty($params['description']))
	{
		$query .= "'$desc',";
	}

	if(!empty($params['image']))
	{
		$query .= "'$image',";
	}

	$query .= "NOW())";

	error_log($query);
	if(!empty($params['image']))
	{
		$dir = "../uploads/";
		$imagefile  = $dir.$image;
	}

	if(!($stmt = $mysqlcon->prepare($query)))
	{
		error_log("CREATE product Failed: (" . $mysqlcon->errno . ") " . $mysqlcon->error);
		$mysqlcon->close();

		if(file_exists($imagefile))
		{
			unlink($imagefile);
		}

		return array('error'=> 'Create query failed');
	}


	//Execute query
	if(!$stmt->execute())
	{
		error_log("Unable to insert data: (" . $stmt->errno . ") " . $stmt->error);
		$mysqlcon->close();

		if(file_exists($imagefile))
		{
			unlink($imagefile);
		}

		if($stmt->errno == 1062)
		{
			return array('error'=> 'Product already exists.');
		}
		else
		{
			return array('error'=> 'Unable to insert data');
		}
	}

	if($stmt->affected_rows==0)
	{
		error_log("Duplicate Entry");
		$mysqlcon->close();

		if(file_exists($imagefile))
		{
			unlink($imagefile);
		}

		return array('error'=> 'Duplicate Entry');
	}

	$stmt->close();
	$mysqlcon->close();

	return array('success'=> $params['title']);

}

function getProductTitlesForAdmin()
{
	$mysqlcon = DBConnection();

	$query = "SELECT title FROM product";

	error_log($query);

	if(!$result = $mysqlcon->query($query))
	{
		error_log("List product title error: ".$mysqlcon->errno. ": ".$mysqlcon->error);
		$mysqlcon->close();
		return array('error'=> 'List product query error');
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

function getProductForAdmin($productid)
{
	$mysqlcon = DBConnection();

	$query = "SELECT * FROM product WHERE idproduct = '$productid'";

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


function updateProduct($productid,$data)
{
	$mysqlcon = DBConnection();

	$query = "UPDATE product SET ";

	if(!empty($data['title']))
	{
		$producttitle = $mysqlcon->real_escape_string(trim($data['title']));
		$query .= " title = ' $producttitle'";

		if((!empty($data['status'])) || (!empty($data['catid'])) || (!empty($data['subcatid'])))
		{
			$query .= ",";
		}
	}

    if(!empty($data['subcatid']))
	{
		$subcatid = $mysqlcon->real_escape_string(trim($data['subcatid']));
        $query .= " idsubcategory = ' $subcatid'";

		if((!empty($data['status'])) || (!empty($data['catid'])))
		{
			$query .= ",";
		}
	}

	if(!empty($data['catid']))
	{
		$catid = $mysqlcon->real_escape_string(trim($data['catid']));
        $query .= " idcategory = ' $catid'";

		if((!empty($data['status'])) || (!empty($data['description'])) || (!empty($data['image'])))
		{
			$query .= ",";
		}
	}

	if(!empty($data['description']))
	{
		$desc = $mysqlcon->real_escape_string(trim($data['description']));
        	$query .= " description = ' $desc'";

		if((!empty($data['status'])) || (!empty($data['image'])))
		{
			$query .= ",";
		}
	}

	if(!empty($data['image']))
	{
		if(move_uploaded_file($sourcefile,$targetfile))
		{
        		$query .= " image = ' $filename'";

			if((!empty($data['status'])))
			{
				$query .= ",";
			}
		}
	}

	if(!empty($data['status']))
	{
		$productstatus = $mysqlcon->real_escape_string(trim($data['status']));
		$query .= " status ='$productstatus'";
	}

	$query.= " WHERE idproduct = ' $productid'";

	error_log($query);

	if(!($stmt=$mysqlcon->prepare($query)))
	{
		error_log("Update product failed: (" . $mysqlcon->errno . ") " . $mysqlcon->error);
		return array('error'=> 'Update product failed');
	}

	if(!($stmt->execute()))
	{
		error_log("Update product failed: (" . $stmt->errno . ") " . $stmt->error);

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

         return array("success" => $productid);
}


function listProducts($title=NULL, $categorytitle=NULL, $subcategorytitle=NULL, $status=NULL, $page=1)
{
	$mysqlcon = DBConnection();

	$title = $mysqlcon->real_escape_string(trim($title));

	$status = $mysqlcon->real_escape_string(trim($status));

    	$categorytitle = $mysqlcon->real_escape_string(trim($categorytitle));

	$subcategorytitle = $mysqlcon->real_escape_string(trim($subcategorytitle));

	$query = "SELECT p.idproduct,p.title,p.idsubcategory,p.status,p.idcategory,s.created,c.title AS categorytitle,s.title AS subcategorytitle FROM product p LEFT JOIN category c ON c.idcategory = p.idcategory
 	LEFT JOIN subcategory s ON s.idsubcategory = p.idsubcategory WHERE c.status = 'YES' AND s.status = 'YES'";

    	if((!empty($title)) || (!empty($status)) || (!empty($catid)) || (!empty($subcatid)))
	{
		$query .= " AND ";
	}

	if(!empty($title))
	{
		$query .= "p.title LIKE '%%%$title%%'";

		if((!empty($status)) || (!empty($categorytitle)) || (!empty($subcategorytitle)))
		{
			$query .= " AND ";
		}
	}

    	if(!empty($catid))
	{
		$query .= " c.title = '$categorytitle'";

        if(!empty($status) || (!empty($subcategorytitle)))
        {
            $query .= " AND ";
        }
	}

	if(!empty($subcatid))
	{
		$query .= " s.title = '$categorytitle'";

        if(!empty($status))
        {
            $query .= " AND ";
        }
	}

	if(!empty($status))
	{
		$query .= " p.status = '$status'";
	}

	$query .= "ORDER BY p.created DESC";

	$limit = $page-1;

	$query.= " LIMIT ". ($limit*15) . ",15";

	error_log($query);

	if(!($result = $mysqlcon->query($query)))
	{
		error_log("List product failed :".$mysqlcon->errno.": ".$mysqlcon->error);
		$mysqlcon->close();
		return array('error'=> 'List product failed');
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

	error_log(json_encode($values));

	$result->close();
	$mysqlcon->close();

	return $values;
}

function getImages()
{
	$mysqlcon = DBConnection();

	$query = "SELECT image FROM product";

	error_log($query);

	if(!$result = $mysqlcon->query($query))
	{
		error_log("List images error: ".$mysqlcon->errno. ": ".$mysqlcon->error);
		$mysqlcon->close();
		return array('error'=> 'List image query error');
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

	error_log(json_encode($values));

	$result->close();
	$mysqlcon->close();

	return $values;
}

function deleteImage($data)
{
	$mysqlcon = DBConnection();

	if(!empty($data['productid']))
	{
		$productid = $mysqlcon->real_escape_string(trim($data['productid']));
	}

	if(!empty($data['image']))
	{
		$image = $mysqlcon->real_escape_string(trim($data['image']));
	}


	$query = "UPDATE product SET image = NULL WHERE idproduct = '$productid'";

	error_log($query);

	if(!($stmt=$mysqlcon->prepare($query)))
	{
		error_log("delete image failed: (" . $mysqlcon->errno . ") " . $mysqlcon->error);
		return array('error'=> 'delete image failed');
	}

	if(!($stmt->execute()))
	{
		error_log("delete image failed: (" . $stmt->errno . ") " . $stmt->error);
		return array('error'=> 'delete image failed');
	}

	if($stmt->affected_rows==0)
	{
		error_log("No change in product for image");
		return array('error'=> 'No change for image');
	}

	$stmt->close();
	$mysqlcon->close();

	$file = "uploads/".$image;

	if (!unlink($file))
	{
		error_log("Image is not deleted");
		$result =  array('error'=> 'Image is not deleted');
	}
	else
	{
		error_log("Image file has been deleted". $file);
	  	$result =  array('success'=> $data['productid']);
	}

	return $result;
}
