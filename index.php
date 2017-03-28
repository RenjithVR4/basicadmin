<?php
/*********************************************************
   Author: 	Renjith VR
   Version: 	1.0
   Date:	04-Jul-2016
   FileName: 	login.php
   Description:	Admin Dashboard page
**********************************************************/
include_once("header.php");

$user_ip = getenv('REMOTE_ADDR');
$geo = unserialize(file_get_contents("http://www.geoplugin.net/php.gp?ip=$user_ip"));
$browser = $_SERVER['HTTP_USER_AGENT'];
$city = $geo["geoplugin_city"];
$region = $geo["geoplugin_regionName"];
$country = $geo["geoplugin_countryName"];

error_log(json_encode($geo));

 ?>
<link rel="stylesheet" href="css/clndr.css" type="text/css" />
</head>
<?php include_once("menu.php"); ?>
        <div id="page-wrapper" class="gray-bg dashbard-1">
                <div class="content-main">
  		<!--banner-->
                        <div class="banner">
                                <h2>
                                        <a href="index.php">Home</a>
                                        <i class="fa fa-angle-right"></i>
                                        <span>Dashboard</span>
                                </h2>
        		</div>
		<!--//banner-->
		<!--content-->
                        <div class="content-top">
                                <div class="col-md-6">
                                        <div class="content-top-1">
        					<h4>Categories</h4>
        					<div class="clearfix" style="margin-bottom:1em;"> </div>
        					<div class="col-md-6 top-content">
        						<h5>Total</h5>
        						<label id ="categories"></label>
        					</div>
        					<div class="col-md-6 top-content">
        						<h5>Active</h5>
        						<label id ="activecategories"></label>
        					</div>
        					<div class="clearfix"> </div>
        				</div>

        				<div class="content-top-1">
        					<h4>SubCategories</h4>
        					<div class="clearfix" style="margin-bottom:1em;"> </div>
        					<div class="col-md-6 top-content">
        						<h5>Total</h5>
        						<label id ="subcategories"></label>
        					</div>
                                                <div class="col-md-6 top-content">
        						<h5>Active</h5>
        						<label id ="activesubcategories"></label>
        					</div>
        					<div class="clearfix"> </div>
        				</div>

        				<div class="content-top-1">
        					<h4>Products</h4>
        					<div class="clearfix" style="margin-bottom:1em;"> </div>
        					<div class="col-md-6 top-content">
        						<h5>Total</h5>
        						<label id ="products"></label>
        					</div>
                                                <div class="col-md-6 top-content">
        						<h5>Active</h5>
        						<label id ="activeproducts"></label>
        					</div>
        					<div class="clearfix"> </div>
        				</div>
                                </div>
                        </div>
		<!---->

                        <div class="content-mid">
                                <div class="col-md-6">
                                        <div class="cal1 cal_2"><div class="clndr"><div class="clndr-controls"><div class="clndr-control-button"><p class="clndr-previous-button">previous</p></div><div class="month">July 2015</div><div class="clndr-control-button rightalign"><p class="clndr-next-button">next</p></div></div><table class="clndr-table" border="0" cellspacing="0" cellpadding="0"><thead><tr class="header-days"><td class="header-day">S</td><td class="header-day">M</td><td class="header-day">T</td><td class="header-day">W</td><td class="header-day">T</td><td class="header-day">F</td><td class="header-day">S</td></tr></thead><tbody><tr><td class="day adjacent-month last-month calendar-day-2015-06-28"><div class="day-contents">28</div></td><td class="day adjacent-month last-month calendar-day-2015-06-29"><div class="day-contents">29</div></td><td class="day adjacent-month last-month calendar-day-2015-06-30"><div class="day-contents">30</div></td><td class="day calendar-day-2015-07-01"><div class="day-contents">1</div></td><td class="day calendar-day-2015-07-02"><div class="day-contents">2</div></td><td class="day calendar-day-2015-07-03"><div class="day-contents">3</div></td><td class="day calendar-day-2015-07-04"><div class="day-contents">4</div></td></tr><tr><td class="day calendar-day-2015-07-05"><div class="day-contents">5</div></td><td class="day calendar-day-2015-07-06"><div class="day-contents">6</div></td><td class="day calendar-day-2015-07-07"><div class="day-contents">7</div></td><td class="day calendar-day-2015-07-08"><div class="day-contents">8</div></td><td class="day calendar-day-2015-07-09"><div class="day-contents">9</div></td><td class="day calendar-day-2015-07-10"><div class="day-contents">10</div></td><td class="day calendar-day-2015-07-11"><div class="day-contents">11</div></td></tr><tr><td class="day calendar-day-2015-07-12"><div class="day-contents">12</div></td><td class="day calendar-day-2015-07-13"><div class="day-contents">13</div></td><td class="day calendar-day-2015-07-14"><div class="day-contents">14</div></td><td class="day calendar-day-2015-07-15"><div class="day-contents">15</div></td><td class="day calendar-day-2015-07-16"><div class="day-contents">16</div></td><td class="day calendar-day-2015-07-17"><div class="day-contents">17</div></td><td class="day calendar-day-2015-07-18"><div class="day-contents">18</div></td></tr><tr><td class="day calendar-day-2015-07-19"><div class="day-contents">19</div></td><td class="day calendar-day-2015-07-20"><div class="day-contents">20</div></td><td class="day calendar-day-2015-07-21"><div class="day-contents">21</div></td><td class="day calendar-day-2015-07-22"><div class="day-contents">22</div></td><td class="day calendar-day-2015-07-23"><div class="day-contents">23</div></td><td class="day calendar-day-2015-07-24"><div class="day-contents">24</div></td><td class="day calendar-day-2015-07-25"><div class="day-contents">25</div></td></tr><tr><td class="day calendar-day-2015-07-26"><div class="day-contents">26</div></td><td class="day calendar-day-2015-07-27"><div class="day-contents">27</div></td><td class="day calendar-day-2015-07-28"><div class="day-contents">28</div></td><td class="day calendar-day-2015-07-29"><div class="day-contents">29</div></td><td class="day calendar-day-2015-07-30"><div class="day-contents">30</div></td><td class="day calendar-day-2015-07-31"><div class="day-contents">31</div></td><td class="day adjacent-month next-month calendar-day-2015-08-01"><div class="day-contents">1</div></td></tr></tbody></table></div></div>

                                </div>
                                <div class="col-md-6">
                                        <div class="middle-content-1">
                                        <h4>User Details</h4>
                                        <hr>
                                                <p><b>IP:</b> <?php echo $user_ip; ?></p>
                                                <br>
                                                <p><b>Browser:</b> <?php echo $browser; ?></p>
                                                <br>
                                                <p><b>City:</b> <?php echo $city; ?></p>
                                                <br>
                                                <p><b>Region:</b> <?php echo $region; ?></p>
                                                <br>
                                                <p><b>Country:</b> <?php echo $country; ?></p>
                                        </div>
                                </div>
                                <div class="clearfix"> </div></div>
                                <div class="col-md-12 mid-content-top">
                                        <div class="middle-content">
                                                <div class="categorylist col-md-6">
                                                        <h3>Last added categories</h3>
                                                        <hr>
                                                        <ul> </ul>
                                                </div>
                                                <div class="clearfix"> </div>
                                                <div class="subcategorylist col-md-6">
                                                        <label></label>
                                                        <h3>Last added subcategories</h3>
                                                        <hr>
                                                        <ul> </ul>
                                                </div>
                                                <div class="clearfix"> </div>
                                                <div class="productlist col-md-6">
                                                        <label></label>
                                                        <h3>Last added products</h3>
                                                        <hr>
                                                        <ul> </ul>
                                                </div>
                                                <div class="clearfix"> </div>

					<!-- start content_slider -->
                                        </div>
                                </div>
                                <div class="clearfix"> </div></div>
                        </div>
                        <div class="clearfix"> </div>
                </div>
        </div>
        <!--Footer-->
        <?php include_once("footer.php"); ?>
<!---->
<script src="js/underscore-min.js" type="text/javascript"></script>
<script src= "js/moment-2.2.1.js" type="text/javascript"></script>
<script src="js/clndr.js" type="text/javascript"></script>
<script src="js/site.js" type="text/javascript"></script>

<script src="js/jquery.nicescroll.js"></script>
<script src="js/scripts.js"></script>
<!--//scrolling js-->
<script src="js/bootstrap.min.js"> </script>
<script src="js/settings/helpers.js"> </script>
<script src="js/settings/dashboard.js"> </script>
</body>
</html>
