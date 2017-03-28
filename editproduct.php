<?php
/*********************************************************
   Author: 	Renjith VR
   Version: 	1.0
   Date:	04-Jul-2016
   FileName: 	editproduct.php
   Description:	Edit Product routines
**********************************************************/
include_once("header.php");
 ?>
</head>
<?php include_once("menu.php"); ?>
        <div id="page-wrapper" class="gray-bg dashbard-1">
                <div class="content-main">
  		<!--banner-->
                        <div class="banner">
                                <h2>
                                        <a href="index.php">Home</a>
                                        <i class="fa fa-angle-right"></i>
                                        <span>Edit Product</span>
                                </h2>
        		</div>

                        <div class="grid-form">
                                <div class="grid-form1">
                                        <h3 id="forms-horizontal">Edit Product</h3>
                                        <form class="form-horizontal" enctype="multipart/form-data" method="POST">
                                                <div class="form-group">
                                                        <label for="product" class="col-sm-2 control-label hor-form">Title</label>
                                                        <div class="col-sm-4">
                                                                <input type="text" class="form-control"name="title" id="title" placeholder="Enter product title">
                                                        </div>
                                                </div>
                                                <div class="form-group">
                                                        <label for="category" class="col-sm-2 control-label hor-form">Category</label>
                                                        <div class="col-sm-4">
                                                                <select name="category" id="category" class="form-control">
                                                                        <!-- <option value="">Select category</option> -->

                                                                </select>
                                                        </div>
                                                </div>
                                                <div class="form-group">
                                                        <label for="subcategory" class="col-sm-2 control-label hor-form">Subcategory</label>
                                                        <div class="col-sm-4">
                                                                <select name="subcategory" id="subcategory" class="form-control">
                                                                        <!-- <option value="">Select subcategory</option> -->

                                                                </select>
                                                        </div>
                                                </div>
                                                <div class="form-group">
                                                        <label for="description" class="col-sm-2 control-label">Description</label>
                                                        <div class="col-md-4">
                                                                <textarea name="description" class="form-control description" id="description" ></textarea>
                                                        </div>
                                                </div>
                                                <div class="form-group">
                                                        <label for="uploadimage" class="col-sm-2 control-label hor-form">Upload Image</label>
                                                        <div class="col-sm-4">
                                                                <input type="file" name="uploadimage" id="uploadimage">
                                                        </div>
                                                </div>
                                                <div class="form-group image-group">
                                                        <div class="col-md-2 col-md-offset-2 imagearea">
                                                                <div class="middle-content-1">


                                                                </div>
                                                                <div class="col-md-1" style="margin:10px 0 0 35px">
                                                                    <button type="submit" id="deleteImage" class="btn btn-danger text-center">Delete</button>
                                                                </div>
                                                        </div>
                                                </div>
                                                <div class="form-group">
                                                        <div class="col-sm-offset-2 col-sm-10">
                                                                <div class="checkbox">
                                                                        <label>
                                                                                <input type="checkbox" name="featured" id="featured" value="YES"> Featured
                                                                        </label>
                                                                </div>
                                                        </div>
                                                </div>
                                                <div class="form-group">
                                                        <div class="col-sm-offset-2 col-sm-10">
                                                                <div class="checkbox">
                                                                        <label>
                                                                                <input type="checkbox" name="status" id="status" value="YES" > Active
                                                                        </label>
                                                                </div>
                                                        </div>
                                                </div>
                                                <div class="form-group">
                                                        <div class="col-sm-offset-2 col-sm-10" style="margin-top:20px">
                                                                <button type="submit" id="submitproduct" class="btn btn-default">Submit</button>
                                                        </div>
                                                </div>
                                        </form>
                                </div>
                        </div>
                        </div>
                </div>
        </div>
<?php include_once("footer.php"); ?>

	<script src="js/jquery.nicescroll.js"></script>
	<script src="js/scripts.js"></script>
	<script src="js/bootstrap.min.js"> </script>
        <script src="js/settings/helpers.js"> </script>
        <script src="js/jquery.tinymce.min.js"> </script>
        <script src="js/tinymce.min.js"> </script>
        <script src="js/settings/editproduct.js"> </script>
        <script type="text/javascript">
          var id = "<?php echo $_GET['productid']?>";
          editproductid.init(id);
        </script>
</body>
</html>
