<?php session_start(); ?>
<?php include('sdba/sdba.php'); ?>
<?php require 'security/processor.php';	?>
<?php 
define('EL_ADMIN', true);
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
	
	<title>Pun'x-Group System</title>

	<!-- Bootstrap -->
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<!-- Bootstrap responsive -->
	<link rel="stylesheet" href="css/bootstrap-responsive.min.css">
	<!-- jQuery UI -->
	<link rel="stylesheet" href="css/plugins/jquery-ui/smoothness/jquery-ui.css">
	<link rel="stylesheet" href="css/plugins/jquery-ui/smoothness/jquery.ui.theme.css">
	<!-- dataTables -->
	<link rel="stylesheet" href="css/plugins/datatable/TableTools.css">
	<!-- chosen -->
	<link rel="stylesheet" href="css/plugins/chosen/chosen.css">
	<!-- Theme CSS -->
	<link rel="stylesheet" href="css/style.css">
	<!-- Color CSS -->
	<link rel="stylesheet" href="css/themes.css">
	
	<!-- Favicon -->
	<link rel="shortcut icon" href="img/favicon.ico" />
	<!-- Apple devices Homescreen icon -->
	<link rel="apple-touch-icon-precomposed" href="img/apple-touch-icon-precomposed.png" />	<style>
	body,td,th {
		font-family: "Helvetica Neue",Verdana,Tahoma, SimSun, Arial, Helvetica, sans-serif;
	}
	 
	.table tr td {
		padding: 2px;
		border-top: 1px solid #ddd;
	}
	.table tr th {
		padding: 2px;
		border-top: 1px solid #ddd;
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
<body>
<div id="content_internal">
	<div class="content_block left" style="width:860px;">
		<?php 
				$emergency_details = Sdba::table('emergency_details');
  				$emergency_details->where('report_id',$_GET['id']);
  				$total_emergency_details = $emergency_details->total();
  				$emergency_details_list = $emergency_details->get();
  				
  				$reports = Sdba::table('reports');
  				$reports ->where('id', $_GET['id']);
  				$reports_list = $reports->get();
  				
  				$projects = Sdba::table('projects');
  				$projects ->where('id', $reports_list[0]['project_id']);
  				$projects_list = $projects->get();
				?>
		<table width="850" border="0" cellpadding="0" cellspacing="0"  >
			<tr>
                <td colspan="4" style="font-size: 36px; font-weight: bold; text-align: center; line-height: 44px;">恆豐工程(澳門)有限公司<br>IES ENGINEERING (MACAU) LIMITED</td>
          </tr>
</table>
				<div class="row">
					<div class="col-sm-12">
						<div class="box">
							
							<div class="box-content nopadding"> 
								<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered dataTable-colvis  " width="850" style="font-size:16px;">
									 
									<tr>
										<td colspan="3" align="center" bgcolor="#ccc"><strong  style="font-size:26px;">SERVICE REPORT (工作報告)</strong></td>
									</tr>
									<tr>
										<td colspan="3"><strong >Customer Name:　</strong><?php echo $projects_list[0]['name_en']; ?></td>
									</tr>
									<tr>
										<td colspan="3" align="center" bgcolor="#EEEEEE">NATURE OF PROBLEM (問題類別)</td>
									</tr>
									<tr>
										<td colspan="3"> 
											<strong >Problem Reported:　</strong><br>
											<blockquote><?php echo $emergency_details_list[0]['problem_reported']; ?> 
										</td>
									</tr>
									<tr>
										<td colspan="2">
											<strong >System Down (系統停止):　</strong> 
											<?php if($emergency_details_list[0]['is_system_down']=='true'){ ?>
											<span class='circle'>　Yes　</span>　/　No　
											<?php }else{ ?>
											　Yes　/　<span class='circle'>　 No　</span> 
											<?php } ?>
											<em style="font-size:12px;padding-top: 6px; padding-right: 26px; float:right;">*Please circle</em>
										</td>
										<td><strong >Equipment Type (設備種類):　</strong><?php echo $emergency_details_list[0]['machine_type']; ?> </td>
									</tr>
									<tr>
										<td width='30%'><strong >Power (功率):　</strong><?php echo $emergency_details_list[0]['power']; ?> </td>
										<td width='30%'><strong >Model (型號):　</strong><?php echo $emergency_details_list[0]['device_model']; ?></td>
										<td width='40%'><strong >Serial No. (編號):　</strong><?php echo $emergency_details_list[0]['device_id']; ?></td>
									</tr>
									<tr>
										<td><strong >Call Reported by (匯報部門):　</strong><?php echo $emergency_details_list[0]['reported_by']; ?></td>
										<td><strong >Date (日期):　</strong></td>
										<td><strong >Time (時間):　</strong></td>
									</tr>
									<tr>
										<td colspan="3"><strong >Location of Installation (地點):　</strong><?php echo $emergency_details_list[0]['location']; ?> </td>
									</tr>
									<tr>
										<td colspan="3" align="center" bgcolor="#EEEEEE">REPORT DETAILS</td>
									</tr>
									<tr>
										<td colspan="3"><strong >Defects found on inspection (損毀發現):　</strong>
										<blockquote><?php echo $emergency_details_list[0]['inspection_found']; ?> 
									</td>
									</tr>
									<tr>
										<td colspan="2"><strong >Engineer's Remarks (工程師備註):　</strong>
										<?php $result = json_decode($emergency_details_list[0]['situation'],true); ?>
										 <ul><?php for ($i=0; $i<count($result); $i++) { echo '<li>'.$result[$i]['text'].'</li>'; } ?> </ul></td>
										<td><strong >Status after Service (完工後狀態):　</strong>
										 <br><span  style="font-size:13px;">
											<?php if($emergency_details_list[0]['status_after_service']=='complete'){ ?>
											<span class='circle'>　Complete　</span>　 / 　Incomplete　 / <br>　Pending for spares　 / 　Under Observation　 / <br>　Working solution provided　 
											<?php }elseif($emergency_details_list[0]['status_after_service']=='incomplete'){ ?>
											　Complete　 / 　<span class='circle'>　Incomplete　</span>　 / <br>　Pending for spares　 / 　Under Observation　 / <br>　Working solution provided　 
											<?php }elseif($emergency_details_list[0]['status_after_service']=='pending'){ ?>
											　Complete　 / 　Incomplete　 / 　<br><span class='circle'>　Pending for spares　</span>　 / 　Under Observation　 / <br>　Working solution provided　 
											<?php }elseif($emergency_details_list[0]['status_after_service']=='observation'){ ?>
											　Complete　 / 　Incomplete　 / <br>　Pending for spares　 / 　<span class='circle'>　Under Observation　</span>　 / <br>　Working solution provided　  
											<?php }elseif($emergency_details_list[0]['status_after_service']=='working'){ ?>
											　Complete　 / 　Incomplete　 / <br>　Pending for spares　 / 　Under Observation　 / <br><span class='circle'>　Working solution provided　</span>　  
											<?php } ?>
											</span>
											<em style="font-size:12px;padding-top: 6px; padding-right: 26px; float:right;">*Please circle</em>
										</td>
									</tr>
									<tr>
										<td colspan="3">&nbsp;</td>
									</tr>
									<tr>
										<td><strong >Events:　</strong></td>
										<td><strong >Start of Service (開始):　</strong></td>
										<td><strong >End of Service (結束):　</strong></td>
									</tr>
									<tr>
										<td colspan="3" align="center" bgcolor="#EEEEEE">CUSTOMER (客戶)</td>
									</tr>
									<tr>
										<td colspan="3"><strong >Remarks (備註):　</strong>
										<blockquote><?php echo $emergency_details_list[0]['remarks']; ?> </td>
									</tr>
									<tr>
										<td><strong >Name:　</strong><?php echo $emergency_details_list[0]['contact_name']; ?></td>
										<td><strong >Designation:　</strong><?php echo $emergency_details_list[0]['designation']; ?></td>
										<td><strong >Phone/Fax:　</strong><?php echo $emergency_details_list[0]['phone']; ?> / <?php echo $emergency_details_list[0]['fax']; ?></td>
									</tr>
									<tr>
										<td colspan="3"><strong >Email:　</strong><?php echo $emergency_details_list[0]['email']; ?></td>
									</tr>
									 
							
								</table>
							</div>
						</div>
					</div>
				</div>
<br />

		</div>
	</div>
</body>
</html>
 
