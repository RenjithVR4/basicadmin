<?php
/*********************************************************
   Author: 	Renjith VR
   Version: 	1.0
   Date:		04-Jul-2016
   FileName: 	login.php
   Description:	User login page
**********************************************************/
 ?>

<!DOCTYPE HTML>
<html>
<head>
<title>Admin Login | Basic Admin</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
<!-- Custom Theme files -->
<link href="css/style.css" rel='stylesheet' type='text/css' />
<link href="css/font-awesome.css" rel="stylesheet">
<script type="text/javascript" src="js/notifIt.js"></script>
<link rel="stylesheet" type="text/css" href="css/notifIt.css">
<script src="js/jquery.min.js"> </script>
<script src="js/bootstrap.min.js"> </script>
</head>
<body class="loginbody">
	<div class="login">
		<h1><a href="index.html">Basic Admin</a></h1>
		<div class="login-bottom">
			<h2>Admin Login</h2>
			<form id="loginform">
				<p class="loginmessage text-center" style=" color:red;"></p>
				<br>
				<div class="col-md-6 col-md-offset-3">
					<div class="login-mail emailfield">
						<input type="text" id="email"  placeholder="Email" >
						<i class="fa fa-envelope"></i>
					</div>
					<div class="login-mail passwordfield">
						<input type="password" id="password"  placeholder="Password">
						<i class="fa fa-lock"></i>
					</div>
					<div class="col-md-5 col-md-offset-3 login-do">
						<label class="hvr-shutter-in-horizontal login-sub">
							<input type="submit" id="loginbutton" value="Login">
						</label>
					</div>
				</div>
				<div class="clearfix"> </div>
			</form>
		</div>
	</div>
		<!---->

<!---->
<!--scrolling js-->
	<script src="js/jquery.nicescroll.js"></script>
	<script src="js/scripts.js"></script>
	<!--//scrolling js-->
	<script src="js/settings/helpers.js"></script>
	<script src="js/settings/login.js"></script>
</body>
</html>
