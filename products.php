<?php
/*********************************************************
   Author: 	Renjith VR
   Version: 	1.0
   Date:	04-Jul-2016
   FileName: 	login.php
   Description:	List Products
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
                                        <span>Products</span>
                                </h2>
                                <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 pull-right" style="margin-top:-28px;">
                                        <a href="addproduct.php"><button type="button" class="btn btn-success">Create</button></a>
                                </div>
        		</div>
                        <div class="container">
                                <div class="row" style="margin-bottom: 1%; margin-top: 2%;">
                                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8" style="padding-right:60px;">
                                                <div class="table-responsive">
                                                        <table class="table table-striped">
                                                                <thead>
                                                                        <tr>
                                                                                <th style="text-align:left">TITLE</th>
                                                                                <th style="text-align:left">CATEGORY</th>
                                                                                <th style="text-align:left">SUBCATEGORY</th>
                                                                                <th style="text-align:left">STATUS</th>
                                                                                <!-- <th style="text-align:left">CREATED</th> -->
                                                                                <th style="text-align:left">EDIT</th>
                                                                        </tr>
                                                                </thead>
                                                                <tbody id="content-body">
                                                                </tbody>
                                                        </table>
                                                </div><!-- Closed tabel responsive -->
                                        </div>
                                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"  style="padding-left:0px; padding-right:0px">
                                                <div class="table-responsive">
                                                        <table class="table table-bordered">
                                                                <tbody>
                                                                        <tr>
                                                                                <td>
                                                                                        <br />
                                                                                        <form class="filter" id="search-form">
                                                                                                <h10>TITLE</h10>
                                                                                                <hr class="darkhr">
                                                                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                                                        <input type="text" name="title" class="form-control input-sm search" placeholder="Search by title">
                                                                                                </div>
                                                                                                <h10>CATEGORY</h10>
                                                                                                <hr class="darkhr">
                                                                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                                                        <input type="text" name="categorytitle" class="form-control input-sm search" placeholder="Search by category">
                                                                                                </div>
                                                                                                <h10>SUBCATEGORY</h10>
                                                                                                <hr class="darkhr">
                                                                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                                                        <input type="text" name="subcategorytitle" class="form-control input-sm search" placeholder="Search by subcategory">
                                                                                                </div>
                                                                                                <h10>STATUS</h10>
                                                                                                <hr class="darkhr">
                                                                                                <div class="radio">
                                                                                                        <label><input type="radio" name="status" id="any" value="" checked>ANY</label>
                                                                                                </div>
                                                                                                <div class="radio">
                                                                                                        <label><input type="radio" name="status" id="active" value="YES">ACTIVE</label>
                                                                                                </div>
                                                                                                <div class="radio">
                                                                                                        <label><input type="radio" name="status" id="inactive" value="NO">INACTIVE</label>
                                                                                                </div>
                                                                                        </form>
                                                                                </td>
                                                                        </tr>
                                                                </tbody>
                                                        </table>
                                                </div>
                                        </div>
                                </div><!--Rows-->
                                <div class="row page">
                                        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10" style="text-align:right">
                                                <a href="javascript:void(0)" class="btn btn-link disabled previous" style="display:inline-block;line-height:40px" role="button"><span class="inside-btn">Previous</span></a> / <a href="javascript:void(0)" style="display:inline-block" class="btn btn-link disabled next" role="button"><span class="inside-btn">Next</span></a>
                                        </div>
                                </div>

                        </div>
                </div>
        </div>
<?php include_once("footer.php"); ?>
<!--scrolling js-->
	<script src="js/jquery.nicescroll.js"></script>
	<script src="js/scripts.js"></script>
	<!--//scrolling js-->
	<script src="js/bootstrap.min.js"> </script>
        <script src="js/settings/helpers.js"> </script>
        <script src="js/settings/products.js"> </script>
</body>
</html>
