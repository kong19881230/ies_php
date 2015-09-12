<?php session_start(); ?>
<?php include('sdba/sdba.php'); ?>
<?php require 'security/processor.php';	?>
<?php 
define('EL_ADMIN', true);
if (!isset($_GET['page'])) {
		$_GET['page'] = 'home';
}

$link = 'http://uniquecode.net/job/ms/';
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
		padding: 3px;
		border-top: 1px solid #ddd;
	}
	.table tr th {
		padding: 3px;
		border-top: 1px solid #ddd;
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
                <td colspan="4" style="font-size: 20px; font-weight: bold; text-align: center; line-height: 32px;"> Service Report - <?php echo $projects_list[0]['name_en']; ?> - Remark </td>
          </tr>
</table>
				<div class="row">
					<div class="col-sm-12">
						<div class="box">
							
							<div class="box-content nopadding"> 
								<?php   
								$result = json_decode($emergency_details_list[0]['situation'],true); 
								//echo '<pre>';
								//print_r($result); 
								//echo '</pre>';
								?>
								 
								<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered dataTable-colvis  ">
									 
									<tbody>
									
  									<?php 
  										$photoCount=0;
  										for ($i=0; $i<count($result);$i++){
  											
											for ($j=0; $j<count($result[$i]['photos']); $j++) {  
  												$photos = Sdba::table('photos');
  												//$maintain_item_results->where('from_type','heat');
  												$photos->where('id',$result[$i]['photos'][$j]);
  												//$maintain_item_results->sort_by('maintain_from_id');
  												$total_photos = $photos->total();
  												$photos_list = $photos->get();
  												if($photoCount % 2==0){
  												?><tr>
													<td style="vertical-align: middle;"  >
														<input type='hidden' id='id' value='<?php echo $_GET['id'] ; ?>'>
														 <?php if($j==0){ echo $result[$i]['text'] ; }?> 
														 <br>
														 <img src="<?php echo $link; ?>upload/<?php echo $photos_list[0]['remote'] ; ?>"  style=" padding: 3px 20px; width: 300px;">
  													</td>	
  												<?php }
  												else {
  												  ?>
												<td style="vertical-align: middle;"  >
														<input type='hidden' id='id' value='<?php echo $_GET['id'] ; ?>'>
														<?php if($j==0){ echo $result[$i]['text'] ; }?> 
														 <br>
														 <img src="<?php echo $link; ?>upload/<?php echo $photos_list[0]['remote'] ; ?>"  style=" padding: 3px 20px; width: 300px;">
  													</td>	
  												</tr>	
												<?php }

										 		$photoCount++;
										 		if($photoCount % 6==0) 	{
										 			echo "</tbody></table><table class='table table-hover table-nomargin dataTable dataTable-tools table-bordered dataTable-colvis'><tbody>";
										 		}
											} 
										}?>
									 
									</tbody>
								</table>
								 
							</div>
						</div>
					</div>
				</div>
 

		</div>
	</div>
</body>
</html>
 
