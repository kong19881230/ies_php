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
    </style>
</head>
<body>
<div id="content_internal">
	<div class="content_block left" style="width:860px;">
		<?php 
				$maintain_froms = Sdba::table('maintain_froms');
  				$maintain_froms->where('id',$_GET['id']);
  				$total_maintain_froms = $maintain_froms->total();
  				$maintain_froms_list = $maintain_froms->get();
  				
  				$reports = Sdba::table('reports');
  				$reports ->where('id', $maintain_froms_list[0]['report_id']);
  				$reports_list = $reports->get();
				?>
		<table width="850" border="0" cellpadding="0" cellspacing="0"  >
			<tr>
                <td colspan="4" style="font-size: 36px; font-weight: bold; text-align: center; line-height: 44px;"><?php  $type=$maintain_froms_list[0]['from_type']; echo $maintain_froms_list[0]['from_type'].' System ('.$from_type[$type].'系統)'; ?></td>
          </tr>
</table>
				<div class="row">
					<div class="col-sm-12">
						<div class="box">
							
							<div class="box-content nopadding"> 
								<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered dataTable-colvis  " width="850">
									<thead>
										<tr>
											<th colspan="2" style="text-align: center" width='70%'><?php echo $reports_cycles_cn[$reports_list[0]['cycle_type']]; ?>服務<br><?php echo $reports_cycles_en[$reports_list[0]['cycle_type']]; ?> Service</th>
											 
											<th colspan="2" style="text-align: center" width='30%'><?php echo $maintain_froms_list[0]['device_id'].'<br>'.$maintain_froms_list[0]['device_model']; ?></th>
											 
										</tr>
									</thead>
									<tbody>
									<?php  
  										$maintain_item_results = Sdba::table('maintain_item_results');
  										//$maintain_item_results->where('from_type','heat');
  										$maintain_item_results->where('maintain_from_id',$_GET['id']);
  										$maintain_item_results->sort_by('maintain_from_id');
  										$total_maintain_item_results = $maintain_item_results->total();
  										$maintain_item_results_list = $maintain_item_results->get();
  										
  										//echo $total_rows;
  										//print_r($reportlist);
  									?>
  									<?php 
  										for ($i=0; $i<$total_maintain_item_results;$i++){
  											 $result = json_decode($maintain_item_results_list[$i]['result'],true);
  											
  									?>
  									
  										<tr >
											<td style="vertical-align: middle;"align="center"><?php echo $maintain_item_results_list[$i]['index']; ?></td>
											<td style="vertical-align: middle;" <?php if ($result['type']=='none'){echo 'colspan="3" align="center"';} ?>><?php echo $maintain_item_results_list[$i]['item_name_cn']; ?><br><?php echo $maintain_item_results_list[$i]['item_name_en']; ?></td>
											<input name="tdresult" id="new<?php echo $maintain_item_results_list[$i]['id']; ?>result" type="hidden" value="<?php echo $maintain_item_results_list[$i]['result']; ?>">
											<?php 
											 
											$bool_normal = '<td style="vertical-align: middle;" colspan="2" align="center">
															 <i class="glyphicon-ok_2"></i> 
													  	  </td>';
											$bool_wait = '<td style="vertical-align: middle;" colspan="2" align="center">
														 <strong>△</strong> 
													  </td>';
													  
											$bool_repaired = '<td style="vertical-align: middle;" colspan="2" align="center">
														 <i class="fa fa-circle-o"></i> 
													  </td>';
											$bool_null = '<td style="vertical-align: middle;background: yellow;" colspan="2" align="center"  >
														 未檢查 
													  </td>';
											
											if ($result['type']=='bool'){
												if (isset($result['new_value'])&&($result['new_value']=='normal')){
													echo $bool_normal;	
												}elseif (isset($result['new_value'])&&($result['new_value']=='wait')){
													echo $bool_wait;	
												}elseif (isset($result['new_value'])&&($result['new_value']=='repaired')){
													echo $bool_repaired;	
												}elseif (!isset($result['new_value'])&&($result['value']=='normal')){ 
													echo $bool_normal;	
												}elseif (!isset($result['new_value'])&&($result['value']=='wait')){
													echo $bool_wait;	
												}elseif (!isset($result['new_value'])&&($result['value']=='repaired')){
													echo $bool_repaired;	
												}elseif (!isset($result['new_value'])&&($result['value']=='false')){
													echo $bool_null;	
												} 
											}elseif ($result['type']=='s_value'){
												if (isset($result['new_value'])){
													echo '<td style="vertical-align: middle;" colspan="2" align="center"> '.chkempty($result['new_value']).' '.$result['unit'].'</td>';	
												}else{
													echo '<td style="vertical-align: middle;" colspan="2" align="center"> '.chkempty($result['value']).' '.$result['unit'].'</td>';	
												}
											}elseif ($result['type']=='d_value'){
												if (isset($result['new_value'])){
													echo '<td style="vertical-align: middle;" align="center"> '.chkempty($result['new_value'][0]).' '.$result['unit'][0].'</td>';
													echo '<td style="vertical-align: middle;" align="center"> '.chkempty($result['new_value'][1]).' '.$result['unit'][1].'</td>';		
												}else{
													echo '<td style="vertical-align: middle;" align="center"> '.chkempty($result['value'][0]).' '.$result['unit'][0].'</td>';
													echo '<td style="vertical-align: middle;" align="center"> '.chkempty($result['value'][1]).' '.$result['unit'][1].'</td>';		
												}
											}
												
											 
											?>
										</tr>
										
									<?php } ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
<br />
<table width="850" border="0" cellpadding="0" cellspacing="0" class="table table-hover  table-bordered ">
 
  <tr>
    <td colspan="1" width="200">Remarks:<br />
      備註</td>
    <td colspan="4"><?php echo nl2br($maintain_froms_list[0]['Inspector_remark']); ?></td>
  </tr>
  <tr>
    <td  >Maintenance Technican: <br />
    保養技術員 </td>
    <td width="26%" ><?php echo $maintain_froms_list[0]['maintenance_technician']; ?></td>
    <td width="20"></td>
    <td  >Maintenance Date &amp; Time: <br />
    保養日期及時間</td>
    <td width="26%" ><?php echo $maintain_froms_list[0]['maintenance_datetime']; ?></td>
  </tr>
  <tr>
    <td  >Inspector:<br />
    檢查人員 </td>
    <td  ><?php echo $maintain_froms_list[0]['inspector']; ?><br /></td>
    <td width="20"></td>
    <td >Inspection Date &amp;   Time:<br />
    檢查日期及時間</td>
    <td><?php echo $maintain_froms_list[0]['inspector_datetime']; ?></td>
  </tr>

</table>
		</div>
	</div>
</body>
</html>
 
