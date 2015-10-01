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
		padding: 6px;
		border-top: 1px solid #ddd;
	}
	.table tr th {
		padding: 6px;
		border-top: 1px solid #ddd;
	}
    </style>
</head>
<body>
<div id="content_internal">
	<div class="content_block left" style="width:860px;">
		<?php 
				
  				
  				$reports = Sdba::table('reports');
  				$reports ->where('id', $_GET['id']);
  				$total_reports = $reports->total();
  				$reports_list = $reports->get();
  				//$maintain_froms_list[0]['report_id']
  				
  				$maintain_froms = Sdba::table('maintain_froms');
  				$maintain_froms->where('report_id',$reports_list[0]['id'])->and_where('from_type',$_GET['ft']);
  				$total_maintain_froms = $maintain_froms->total();
  				$maintain_froms_list = $maintain_froms->get();
  				
  				$setpershow = 3;
  				$item_qty = $total_maintain_froms;
  				
  				if (isset($_GET['p'])&&($_GET['p']!='')){
  					$start=($_GET['p']-1)*$setpershow;
  		 			if($item_qty<$start+$setpershow){
  		 				$show =$item_qty-$start;
  		 			}else{
  		 				$show = $setpershow;
  		 			}
  								
  				}else{
  					$_GET['p']=1;
  					$start=0;
  					if ($item_qty > $setpershow) {
  						$show = $setpershow;
  					}else{
  						$show = $item_qty;
  					}
 			 	}
 			 	
  			 
  				//echo $total_maintain_froms;
				?>
		<table width="850" border="0" cellpadding="0" cellspacing="0"  >
			<tr>
                <td colspan="4" style="font-size: 26px; font-weight: bold; text-align: center; line-height: 32px;"><?php  $type=$maintain_froms_list[0]['from_type']; echo $from_type_en[$type].' System ('.$from_type[$type].'系統)'; ?></td>
          </tr>
</table>
				<div class="row">
					<div class="col-sm-12">
						<div class="box">
							
							<div class="box-content nopadding"> 
								<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered dataTable-colvis  " width="850" style="font-size:12px;">
									<thead>
										<tr>
											<th colspan="2" style="text-align: center" width='600' ><?php echo $reports_cycles_cn[$reports_list[0]['cycle_type']]; ?>服務<br><?php echo $reports_cycles_en[$reports_list[0]['cycle_type']]; ?> Service</th>
											<?php $chk_start=0; $chk_show=0; 
												for ($b=0; $b<$item_qty; $b++){ 
													$chk_start++; 
            										if ($chk_start>$start){ 
														$chk_show++;
														if ($chk_show<=$show) {
											 ?>
											<th colspan="2" style="text-align: center"  ><?php echo $maintain_froms_list[$b]['device_id'].'<br>'.$maintain_froms_list[$b]['device_model']; ?></th>
											<?php }} } ?>
										</tr>
									</thead>
									<tbody>
									<?php  $chk_start=0; $chk_show=0;
										for ($b=0; $b<$item_qty; $b++){ 
											$chk_start++; 
            								if ($chk_start>$start){ 
												$chk_show++;
												if ($chk_show<=$show) {
  											$maintain_item_results = Sdba::table('maintain_item_results');
  											//$maintain_item_results->where('from_type','heat');
  											$maintain_item_results->where('maintain_from_id',$maintain_froms_list[$b]['id']);
  											$maintain_item_results->sort_by('maintain_from_id');
  											$total_maintain_item_results = $maintain_item_results->total();
  											$maintain_item_results_list[] = $maintain_item_results->get();
  										}
  										}
  										}
  										//echo '<pre>';
  										//print_r($maintain_item_results_list);
  										//echo '</pre>';
  										//echo $total_rows;
  										
  									?>
  									<?php 
  										for ($i=0; $i<$total_maintain_item_results;$i++){
  											for ($c=0; $c<$show; $c++){ 
  											 	$result[$c] = json_decode($maintain_item_results_list[$c][$i]['result'],true);
  											}
  											$j= $i +1;
  											
  										//	echo '<pre>';
  										//print_r($result);
  										//echo '</pre>';
  									?>
  									
  										<tr >
											<td style="vertical-align: middle;" align="center"><?php echo $j; ?></td>
											<td style="vertical-align: middle;" <?php if ($result[0]['type']=='none'){echo 'colspan="'.(1+2*$show).'" align="center"';} ?>><?php echo $maintain_item_results_list[0][$i]['item_name_cn']; ?><br><?php echo $maintain_item_results_list[0][$i]['item_name_en']; ?></td>
											<input name="tdresult" id="new<?php echo $maintain_item_results_list[0][$i]['id']; ?>result" type="hidden" value="<?php echo $maintain_item_results_list[0][$i]['result']; ?>">
											<?php 
											 
											$bool_normal = '<td style="vertical-align: middle;" colspan="2" align="center">
															 <img src="img/check.png" width="20">
													  	  </td>';
											$bool_wait = '<td style="vertical-align: middle;" colspan="2" align="center">
														 <img src="img/sankaku.png" width="20">
													  </td>';
													  
											$bool_repaired = '<td style="vertical-align: middle;" colspan="2" align="center">
														 <img src="img/circle.png" width="20">
													  </td>';
											$bool_null = '<td style="vertical-align: middle;background: yellow;" colspan="2" align="center"  >
														 未檢查 
													  </td>';
											
											for ($c=0; $c<$show; $c++){ 
											if ($result[$c]['type']=='bool'){
												if (isset($result[$c]['new_value'])&&($result[$c]['new_value']=='normal')){
													echo $bool_normal;	
												}elseif (isset($result[$c]['new_value'])&&($result[$c]['new_value']=='wait')){
													echo $bool_wait;	
												}elseif (isset($result[$c]['new_value'])&&($result[$c]['new_value']=='repaired')){
													echo $bool_repaired;	
												}elseif (!isset($result[$c]['new_value'])&&($result[$c]['value']=='normal')){ 
													echo $bool_normal;	
												}elseif (!isset($result[$c]['new_value'])&&($result[$c]['value']=='wait')){
													echo $bool_wait;	
												}elseif (!isset($result[$c]['new_value'])&&($result[$c]['value']=='repaired')){
													echo $bool_repaired;	
												}elseif (!isset($result[$c]['new_value'])&&($result[$c]['value']=='false')){
													echo $bool_null;	
												} 
											}elseif ($result[$c]['type']=='s_value'){
												if (isset($result[$c]['new_value'])){
													echo '<td style="vertical-align: middle;" colspan="2" align="center"> '.chkempty($result[$c]['new_value']).' '.$result[$c]['unit'].'</td>';	
												}else{
													echo '<td style="vertical-align: middle;" colspan="2" align="center"> '.chkempty($result[$c]['value']).' '.$result[$c]['unit'].'</td>';	
												}
											}elseif ($result[$c]['type']=='d_value'){
												if (isset($result[$c]['new_value'])){
													echo '<td style="vertical-align: middle;" align="center"> '.chkempty($result[$c]['new_value'][0]).' '.$result[$c]['unit'][0].'</td>';
													echo '<td style="vertical-align: middle;" align="center"> '.chkempty($result[$c]['new_value'][1]).' '.$result[$c]['unit'][1].'</td>';		
												}else{
													echo '<td style="vertical-align: middle;" align="center"> '.chkempty($result[$c]['value'][0]).' '.$result[$c]['unit'][0].'</td>';
													echo '<td style="vertical-align: middle;" align="center"> '.chkempty($result[$c]['value'][1]).' '.$result[$c]['unit'][1].'</td>';		
												}
											}
												
											}
											?>
										</tr>
										
									<?php } ?>
									</tbody>
								</table>
								<table width="850" border="0" cellpadding="0" cellspacing="0" class="table table-hover  table-bordered table-nomargin dataTable dataTable-tools table-bordered dataTable-colvis" style="font-size:12px;">
 
  <tr>
    <td colspan="1" width="25%">Remarks:<br /> 備註</td>
    <td colspan="3"><?php echo nl2br($maintain_froms_list[0]['Inspector_remark']); ?></td>
  </tr>
  <tr>
    <td   >Maintenance Technican: <br /> 保養技術員 </td>
    <td width="25%" ><?php echo $maintain_froms_list[0]['maintenance_technician']; ?></td>
     
    <td  >Maintenance Date &amp; Time: <br /> 保養日期及時間</td>
    <td width="25%" ><?php echo $maintain_froms_list[0]['maintenance_datetime']; ?></td>
  </tr>
  <tr>
    <td  >Inspector:<br /> 檢查人員 </td>
    <td  ><?php echo $maintain_froms_list[0]['inspector']; ?><br /></td>
     
    <td >Inspection Date &amp;   Time:<br />
    檢查日期及時間</td>
    <td><?php echo $maintain_froms_list[0]['inspector_datetime']; ?></td>
  </tr>
	<tr>
		<td>Sign:<br />
		客户簽名 </td>
		<td colspan="3"><?php if ($maintain_froms_list[0]['signature'] !=''){ ?><img src="../upload/<?php echo $maintain_froms_list[0]['signature']; ?>.png" width="200"><?php } ?></td>
	</tr>
</table>
							</div>
						</div>
					</div>
				</div>
 

		</div>
	</div>
</body>
</html>
 
