<?php
/*********************************************************
   Author: 	Renjith VR
   Version: 	1.0
   Date:	04-Jul-2016
   FileName: 	login.php
   Description:	Add Category
**********************************************************/
include_once("common/header.php");
 ?>
</head>
<?php include_once("common/menu.php"); ?>
        <div id="page-wrapper" class="gray-bg dashbard-1">
                <div class="content-main">
  		<!--banner-->
                        <div class="banner">
                                <h2>
                                        <a href="index.php">Home</a>
                                        <i class="fa fa-angle-right"></i>
                                        <span>Edit Category</span>
                                </h2>
        		</div>

                        <div class="grid-form">
                                <div class="grid-form1">
                                        <h3 id="forms-horizontal">Edit Category</h3>
                                        <p class="errormessage col-md-offset-2" style="color:red"></p>
                                        <p class="successmessage col-md-offset-2" style="color:green"></p>
                                        <form class="form-horizontal" method="POST">
                                                <div class="form-group">
                                                        <label for="category" class="col-sm-2 control-label hor-form">Title</label>
                                                        <div class="col-sm-4">
                                                                <input type="text" name="title" class="form-control" id="title" placeholder="Enter category title">
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
                                                        <div class="col-sm-offset-2 col-sm-10">
                                                                <button type="submit" id="submitcategory" class="btn btn-default">Submit</button>
                                                        </div>
                                                </div>
                                        </form>
                                </div>
                        </div>
                </div>
        </div>
<?php include_once("common/footer.php"); ?>
<!-- Common JS files-->
<?php include_once("common/commonjs.php"); ?>
<script src="js/settings/editcategory.js"> </script>
<script type="text/javascript">
  var id = "<?php echo $_GET['categoryid']?>";
  editcategory.init(id);
</script>
</body>
</html>
