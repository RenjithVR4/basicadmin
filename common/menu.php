<?php
/*********************************************************
   Author: 	Renjith VR
   Version: 	1.0
   Date:	04-Jul-2016
   FileName: 	login.php
   Description:	Admin Dashboard page
**********************************************************/

 ?>
 <body>
         <div id="wrapper">
                 <nav class="navbar-default navbar-static-top" role="navigation">
                         <div class="navbar-header">
                                 <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                                         <span class="sr-only">Toggle navigation</span>
                                         <span class="icon-bar"></span>
                                         <span class="icon-bar"></span>
                                         <span class="icon-bar"></span>
                                 </button>
                                 <h1> <a class="navbar-brand" href="index.php">Basic Admin</a></h1>
                         </div>
                         <div class=" border-bottom">
                                 <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 pull-right" style="margin-top:10px;">
                                         <a href="#" onclick="adminLogout()"><button type="button" class="btn btn-danger">Logout</button></a>
                                 </div>
 			        <div class="clearfix"></div>
                                 <div class="navbar-default sidebar" role="navigation">
                                         <div class="sidebar-nav navbar-collapse">
                                                 <ul class="nav" id="side-menu">
                                                         <li>
                                                                 <a href="index.php" class=" hvr-bounce-to-right"><i class="fa fa-dashboard nav_icon "></i><span class="nav-label">Dashboard</span> </a>
                                                         </li>
                                                         <li>
                                                                 <a href="categories.php" class=" hvr-bounce-to-right"><i class="fa fa-list nav_icon "></i><span class="nav-label">Categories</span> </a>
                                                         </li>
                                                         <li>
                                                                 <a href="subcategories.php" class=" hvr-bounce-to-right"><i class="fa fa-list nav_icon "></i><span class="nav-label">Subcategories</span> </a>
                                                         </li>
                                                         <li>
                                                                 <a href="products.php" class=" hvr-bounce-to-right"><i class="fa fa-list nav_icon "></i><span class="nav-label">Products</span> </a>
                                                         </li>
                                                 </ul>
                                         </div>
                                 </div>
                         </nav>
                 </div>
