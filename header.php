<?php session_start(); ?>
<?php include('sdba/sdba.php'); ?>
<?php require 'security/processor.php';	?>
<?php 
define('EL_ADMIN', true);

require_once('easylogin/includes/load.php');
$EL = EasyLogin::getInstance();

if (isset($_GET['logout'])) {
	$EL->signout();
	header('Location: login.php');
}

// Check if is logged
if (!$EL->is_logged()) {
	header('Location: login.php');
}

// Check if is admin
if ( $EL->get_current_user('role') != 'admin' ) {
	die('<h2>You do not have sufficient permissions to access this page</h2>');
}

if (!isset($_GET['page'])) {
		$_GET['page'] = 'home';
}
?>

<!doctype html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<!-- Apple devices fullscreen -->
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<!-- Apple devices fullscreen -->
	<meta names="apple-mobile-web-app-status-bar-style" content="black-translucent" />

	<title>Uniquecode - Dynamic tables</title>

	<!-- Bootstrap -->
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<!-- jQuery UI -->
	<link rel="stylesheet" href="css/plugins/jquery-ui/smoothness/jquery-ui.css">
	<link rel="stylesheet" href="css/plugins/jquery-ui/smoothness/jquery.ui.theme.css">
	<!-- dataTables -->
	<link rel="stylesheet" href="css/plugins/datatable/TableTools.css">
	<!-- Fullcalendar -->
	<link rel="stylesheet" href="css/plugins/fullcalendar/fullcalendar.css">
	<link rel="stylesheet" href="css/plugins/fullcalendar/fullcalendar.print.css" media="print">
	<!-- Tagsinput -->
	<link rel="stylesheet" href="css/plugins/tagsinput/jquery.tagsinput.css">
	<!-- chosen -->
	<link rel="stylesheet" href="css/plugins/chosen/chosen.css">
	<!-- multi select -->
	<link rel="stylesheet" href="css/plugins/multiselect/multi-select.css">
	<!-- timepicker -->
	<link rel="stylesheet" href="css/plugins/timepicker/bootstrap-timepicker.min.css">
	<!-- colorpicker -->
	<link rel="stylesheet" href="css/plugins/colorpicker/colorpicker.css">
	<!-- Datepicker -->
	<link rel="stylesheet" href="css/plugins/datepicker/datepicker.css">
	<!-- Daterangepicker -->
	<link rel="stylesheet" href="css/plugins/daterangepicker/daterangepicker.css">
	<!-- Plupload -->
	<link rel="stylesheet" href="css/plugins/plupload/jquery.plupload.queue.css">
	<!-- select2 -->
	<link rel="stylesheet" href="css/plugins/select2/select2.css">
	<!-- icheck -->
	<link rel="stylesheet" href="css/plugins/icheck/all.css">
	<!-- chosen -->
	<link rel="stylesheet" href="css/plugins/chosen/chosen.css">
	<!-- Theme CSS -->
	<link rel="stylesheet" href="css/style.css">
	<!-- Color CSS -->
	<link rel="stylesheet" href="css/themes.css">

	<!-- jQuery -->
	<script src="js/jquery.min.js"></script>

	<!-- Nice Scroll -->
	<script src="js/plugins/nicescroll/jquery.nicescroll.min.js"></script>
	<!-- imagesLoaded -->
	<script src="js/plugins/imagesLoaded/jquery.imagesloaded.min.js"></script>
	<!-- jQuery UI -->
	<script src="js/plugins/jquery-ui/jquery.ui.core.min.js"></script>
	<script src="js/plugins/jquery-ui/jquery.ui.widget.min.js"></script>
	<script src="js/plugins/jquery-ui/jquery.ui.mouse.min.js"></script>
	<script src="js/plugins/jquery-ui/jquery.ui.resizable.min.js"></script>
	<script src="js/plugins/jquery-ui/jquery.ui.sortable.min.js"></script>
	<script src="js/plugins/jquery-ui/jquery.ui.datepicker.min.js"></script>
	<!-- slimScroll -->
	<script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
	<!-- Bootstrap -->
	<script src="js/bootstrap.min.js"></script>
	<!-- Bootbox -->
	<script src="js/plugins/bootbox/jquery.bootbox.js"></script>
	<!-- dataTables -->
	<script src="js/plugins/datatable/jquery.dataTables.min.js"></script>
	<script src="js/plugins/datatable/TableTools.min.js"></script>
	<script src="js/plugins/datatable/ColReorderWithResize.js"></script>
	<script src="js/plugins/datatable/ColVis.min.js"></script>
	<script src="js/plugins/datatable/jquery.dataTables.columnFilter.js"></script>
	<script src="js/plugins/datatable/jquery.dataTables.grouping.js"></script>
	<!-- Chosen -->
	<script src="js/plugins/chosen/chosen.jquery.min.js"></script>

	<!-- Theme framework -->
	<script src="js/eakroko.min.js"></script>
	<!-- Theme scripts -->
	<script src="js/application.min.js"></script>
	<!-- Just for demonstration -->
	<script src="js/demonstration.min.js"></script>
	<!-- Masked inputs -->
	<script src="js/plugins/maskedinput/jquery.maskedinput.min.js"></script>
	<!-- TagsInput -->
	<script src="js/plugins/tagsinput/jquery.tagsinput.min.js"></script>
	<!-- Datepicker -->
	<script src="js/plugins/datepicker/bootstrap-datepicker.js"></script>
	<!-- Daterangepicker -->
	<script src="js/plugins/daterangepicker/moment.min.js"></script>
	<script src="js/plugins/daterangepicker/daterangepicker.js"></script>
	<!-- Timepicker -->
	<script src="js/plugins/timepicker/bootstrap-timepicker.min.js"></script>
	<!-- Colorpicker -->
	<script src="js/plugins/colorpicker/bootstrap-colorpicker.js"></script>
	<!-- Chosen -->
	<script src="js/plugins/chosen/chosen.jquery.min.js"></script>
	<!-- MultiSelect -->
	<script src="js/plugins/multiselect/jquery.multi-select.js"></script>
	<!-- CKEditor -->
	<script src="js/plugins/ckeditor/ckeditor.js"></script>
	<!-- PLUpload -->
	<script src="js/plugins/plupload/plupload.full.js"></script>
	<script src="js/plugins/plupload/jquery.plupload.queue.js"></script>
	<!-- Custom file upload -->
	<script src="js/plugins/fileupload/bootstrap-fileupload.min.js"></script>
	<script src="js/plugins/mockjax/jquery.mockjax.js"></script>
	<!-- select2 -->
	<script src="js/plugins/select2/select2.min.js"></script>
	<!-- icheck -->
	<script src="js/plugins/icheck/jquery.icheck.min.js"></script>
	<!-- complexify -->
	<script src="js/plugins/complexify/jquery.complexify-banlist.min.js"></script>
	<script src="js/plugins/complexify/jquery.complexify.min.js"></script>
	<!-- Mockjax -->
	<script src="js/plugins/mockjax/jquery.mockjax.js"></script>
	
	<!-- XEditable -->
	<link rel="stylesheet" href="css/plugins/xeditable/bootstrap-editable.css">
	<!-- XEditable -->
	<script src="js/plugins/momentjs/jquery.moment.js"></script>
	<script src="js/plugins/mockjax/jquery.mockjax.js"></script>
	<script src="js/plugins/xeditable/bootstrap-editable.min.js"></script>
	<script src="js/plugins/xeditable/demo.js"></script>
	<script src="js/plugins/xeditable/address.js"></script>
	<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
	
	<!--[if lte IE 9]>
		<script src="js/plugins/placeholder/jquery.placeholder.min.js"></script>
		<script>
			$(document).ready(function() {
				$('input, textarea').placeholder();
			});
		</script>
	<![endif]-->

	<!-- Favicon -->
	<link rel="shortcut icon" href="img/favicon.ico" />
	<!-- Apple devices Homescreen icon -->
	<link rel="apple-touch-icon-precomposed" href="img/apple-touch-icon-precomposed.png" />
<style>
 

.titles{
    border-bottom: 1px dashed #7F7F7F;
    margin:-20px -20px 0px -20px;
    padding:0px;
    background-color:#368ee0;
    color:#fff;
	height:30px;
	line-height: 25px;
}
.contents{
	color: #368ee0; 
	font-size: 45px; 
	height:70px;	
}
.last{
	text-align: right;
	margin: 0px -20px -20px -20px;
	padding: 0px;
	background-color: #f0f0f0;
	color: #000;
	height: 50px;
	line-height: 50px;
}
 
.overlays{
    background:transparent url(img/overlay.png) repeat top left;
    position:fixed;
    top:0px;
    bottom:0px;
    left:0px;
    right:0px;
    z-index:100;
}
.delbox{
	width:100%;
	font-family: "Helvetica Neue",Verdana,Tahoma, SimSun, Arial, Helvetica, sans-serif;
	position:fixed;
	top:50%;
	margin-top:-60px;
	background-color:#fff;
	color: #000;
	padding:20px;
	height:120px;
	-webkit-box-shadow: 0 1px 5px #333;
	z-index:101;
	font-size: 12px;
	text-align: center;
} 
.circle
    {
    //width:50px;
    //height:50px;
    border-radius:200px;
    border:#000 1px solid; 
    font-size:16px;
    color:#000;
    //line-height:54px;
    text-align:center;
    } 
 
</style>
</head>

<body class="theme-satblue" data-theme="theme-satblue">
	 
	<div class="container-fluid" id="content">
		<div id="left">
			<a href="#"  >
			<img src="img/logo.jpg"  width='100%' style="border-bottom: 1px solid #888;	padding: 20px 50px; background: #fcfcfc;">
			</a>
			<button class="btn-block btn btn-large" onclick="history.go(-1)" title="Back"><i class="fa fa-chevron-circle-left" style="font-size:100px;"></i></button>
			<div class="subnav">
				<div class="subnav-title">
					<a href="#" class="toggle-subnav">
						<i class="fa fa-angle-down"></i>
						<span>Reports</span>
					</a>
				</div>
				<ul class="subnav-menu">
					<li>
						<a href="?type=0">Maintenance Report</a>
						 
					</li>
					<li>
						<a href="?type=1">Service Report </a>
					</li>
					 
				</ul>
			</div>
			<div class="subnav">
				<div class="subnav-title">
					<a href="#" class='toggle-subnav'>
						<i class="fa fa-angle-down"></i>
						<span>Projects</span>
					</a>
				</div>
				<ul class="subnav-menu">
					<li>
						<a href="?page=projects">Projects</a>
					</li>
					<li>
						<a href="?page=machines">Machines</a>
					</li>
				</ul>
			</div>
			<div class="subnav">
				<div class="subnav-title">
					<a href="#" class='toggle-subnav'>
						<i class="fa fa-angle-down"></i>
						<span>Settings</span>
					</a>
				</div>
				<ul class="subnav-menu">
					 
					 <li>
						<a href="?page=set_maintain_item">Report item setting</a>
					</li>
					<li>
						<a href="?page=user">Users</a>
					</li>
					<li>
						<a href="?logout">Logout / 登出</a>
					</li>
				</ul>
			</div>
			 
		</div>