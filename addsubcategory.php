<?php
/*********************************************************
   Author: 	Renjith VR
   Version: 	1.0
   Date:	04-Jul-2016
   FileName: 	addsubcategory.php
   Description:	Add Subcategory
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
                                        <span>Add Subcategory</span>
                                </h2>
        		</div>

                        <div class="grid-form">
                                <div class="grid-form1">
                                        <h3 id="forms-horizontal">Add Subcategory</h3>
                                        <p class="errormessage col-md-offset-2" style="color:red"></p>
                                        <p class="successmessage col-md-offset-2" style="color:green"></p>
                                        <form class="form-horizontal" method="POST">
                                                <div class="form-group">
                                                        <label for="subcategory" class="col-sm-2 control-label hor-form">Title</label>
                                                        <div class="col-sm-4">
                                                                <input type="text" class="form-control" id="title" placeholder="Enter subcategory title">
                                                        </div>
                                                </div>
                                                <div class="form-group">
                                                        <label for="category" class="col-sm-2 control-label hor-form">Category</label>
                                                        <div class="col-sm-4">
                                                                <select name="category" id="category" class="form-control">
                                                                        <option value="">Select Category</option>
                                                                </select>
                                                        </div>
                                                </div>
                                                <!-- <div class="form-group">
                                                        <div class="col-sm-offset-2 col-sm-10">
                                                                <div class="checkbox">
                                                                        <label>
                                                                                <input type="checkbox" name="status" id="status" value="YES" > Active
                                                                        </label>
                                                                </div>
                                                        </div>
                                                </div> -->
                                                <div class="form-group">
                                                        <div class="col-sm-offset-2 col-sm-10">
                                                                <button type="submit" id="submitsubcategory" class="btn btn-default">Submit</button>
                                                        </div>
                                                </div>
                                        </form>
                                </div>
                        </div>
                </div>
        </div>
<?php include_once("footer.php"); ?>
<!--scrolling js-->
	<script src="js/jquery.nicescroll.js"></script>
	<script src="js/scripts.js"></script>
	<script src="js/bootstrap.min.js"> </script>
        <script src="js/settings/helpers.js"> </script>
        <script src="js/settings/addsubcategory.js"> </script>
</body>
</html>
