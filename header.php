<?php
/*********************************************************
   Author: 	Renjith VR
   Version: 	1.0
   Date:	04-Jul-2016
   FileName: 	login.php
   Description:	Admin Header
**********************************************************/
require_once("settings/helpers.php");
if(!($adminid = sessionValidate(ADMIN_SESSION_ID)))
{
        error_log('Admin: Session Validation Failed');
	header( 'Location: login.php');
}
$paths = explode("/",$_SERVER['PHP_SELF']);
$filename = $paths[count($paths)-1];
 ?>
<!DOCTYPE HTML>
<html>
<head>
        <title>Basic Admin| Admin</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="keywords" content="" />
        <script type="application/x-javascript">
        addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); }
        </script>
        <link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
        <link href="css/custom.css" rel="stylesheet">
        <!-- Custom Theme files -->
        <link href="css/style.css" rel='stylesheet' type='text/css' />
        <link href="css/notifIt.css" rel="stylesheet" type="text/css"  />
        <link href="css/font-awesome.css" rel="stylesheet">
        <script src="js/notifIt.js"></script>
        <script src="js/jquery.min.js"> </script>
        <!-- Mainly scripts -->
        <script src="js/jquery.metisMenu.js"></script>
        <script src="js/jquery.slimscroll.min.js"></script>
        <!-- Custom and plugin javascript -->
        <script src="js/custom.js"></script>
        <!-- <script>
        $(function ()
        {
                $('#supported').text('Supported/allowed: ' + !!screenfull.enabled);
        	if (!screenfull.enabled)
                {
                        return false;
        	}

        	$('#toggle').click(function ()
                {
        		screenfull.toggle($('#container')[0]);
        	});
        });
        </script> -->
