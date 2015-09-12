<?php if (!defined('EL_ADMIN')) exit('No direct script access allowed'); ?>
 <?php 
 if(isset($_SESSION["key"], $_POST["key"]) && $_SESSION["key"] == $finalkey){
 	//echo 'xx'.$finalkey;$_SESSION["key"] = md5(uniqid().mt_rand());
		
		//echo  '　　　　　　　　　　　　　　　　　　　　　　　　　　　　';
		//print_r($_POST['cycle_types']); 
		//$finalcycle_types = json_encode($_POST['cycle_types']);
		//$finalmachine_types = json_encode($_POST['machine_types']);
		//print_r($finalcycle_types);
		//echo '　　　　　　　　　　　　　　　　　　　　　　　　　　';
		//print_r ( $_POST['text'] );
		
		$emergency_details = Sdba::table('emergency_details');
		$emergency_details->where('report_id',$_GET['id']);
		$total_emergency_details = $emergency_details->total();
		$emergency_details_list = $emergency_details->get();
  		$result = json_decode($emergency_details_list[0]['situation'],true); 
  		
  		for ($k=0; $k<count($result);$k++){
  			$result[$k]['text']=$_POST['text'][$k];
  		}
  	 
  		
  		
		$data = array(
			'situation'=> json_encode($result) 
		);
		$emergency_details ->update($data);
		
		unset($_SESSION["key"]);
		$_SESSION["key"] = md5(uniqid().mt_rand());				
		?>

<script>
//location.reload();
</script>
		<?php								 
 }
 ?>
 

		<div id="main">
			<div class="container-fluid">
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
				<div class="page-header">
					<div class="pull-left">
						<h1 style="line-height: 32px;">Service Report - <?php echo $projects_list[0]['name_en'];  ?><br> - Remark</h1>
					</div>

					<div class="pull-right">
						 
						<ul class="stats">
							 
							<li class='lightred'>
								<a href='erm_print.php?id=<?php echo $_GET['id']; ?>' target='blank'>
								<i class="fa fa-print"></i>
								<div class="details">
									<span class="big">Print preview</span>
									<span>移至列印頁面</span>
								</div>
								</a>
							</li>
							
							<li class='green'  >
								<a href='http://uniquecode.net/job/ms/mpdf56/emergency_remark.php?id=<?php echo $_GET['id']; ?>' target='blank'>
								<i class="fa fa-file-pdf-o"></i>
								<div class="details">
									<span class="big">PDF</span>
									<span>以PDF保存</span>
								</div>
								</a>
							</li>
							<li class='blue'>
								<a href='?page=emergency_remark_doc&id=<?php echo $_GET['id']; ?>' target='blank'>
								<i class="fa fa-print"></i>
								<div class="details">
									<span class="big">Word</span>
									<span>Word編輯保存</span>
								</div>
								</a>
							</li>
						</ul>
					</div>
				</div>
			
				<h6></h6>
				<div class="pull-left breadcrumbs">
					<ul>
						<li>
							<a href="?page=home">Home</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="?page=home">Reports</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="?page=emergency_details&id=<?php echo $emergency_details_list[0]['report_id']; ?>">Service Report</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a><?php echo $projects_list[0]['name_en']; ?></a>
							 
						</li>
						 
					</ul>
					<div class="close-bread">
						<a href="#">
							<i class="fa fa-times"></i>
						</a>
					</div>
				</div>
 
				<div class="row">
					<div class="col-sm-12">
						<h6>　</h6>
						<p>
							<ul class="nav nav-tabs">
								 
								
								<li >
									<a href="?page=emergency_details_view&id=<?php echo $_GET['id']; ?> ">View</a>
								</li>
								<li>
									<a href="?page=emergency_details&id=<?php echo $_GET['id']; ?> ">Edit</a>
								</li>
								<li class="active">
									<a href="?page=emergency_remark&id=<?php echo $_GET['id']; ?> ">Remark</a>
								</li>
								
							 
							</ul>
						</p>
					</div>
				</div>
				
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
								<form action="?page=emergency_remark&id=<?php echo $_GET['id']; ?>" method="POST" enctype="multipart/form-data" class='form-horizontal form-bordered'>
								<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered dataTable-colvis  ">
									 
									<tbody>
									
  									<?php 
  										for ($i=0; $i<count($result);$i++){
  											
  											
  									?>
  										
										<tr>
											<td style="vertical-align: middle;"  >
												<input type='hidden' id='id' value='<?php echo $_GET['id'] ; ?>'>
												
												<textarea id='text<?php echo $i; ?>'  name='text[]' class="form-control up_val" placeholder="<?php echo $result[$i]['text'] ; ?>" rows="2"><?php echo $result[$i]['text'] ; ?></textarea>
												 
												 <br>
												<?php   
												for ($j=0; $j<count($result[$i]['photos']); $j++) {  
  												$photos = Sdba::table('photos');
  												//$maintain_item_results->where('from_type','heat');
  												$photos->where('id',$result[$i]['photos'][$j]);
  												//$maintain_item_results->sort_by('maintain_from_id');
  												$total_photos = $photos->total();
  												$photos_list = $photos->get();
  										
  												//echo $photos_list[$j]['remote'];
  												//print_r($photos_list);
  												?>
												<img src="upload/<?php echo $photos_list[0]['remote'] ; ?>"  style=" padding: 20px 50px; ">
												<?php } ?>
											</td>				 
										</tr>
										 
									<?php } ?>
									<tr>
										<td colspan="5">
											<input type="hidden" name="key" value="<?php echo htmlspecialchars($_SESSION["key"], ENT_QUOTES);?>">
											<button class="btn btn-primary" style="margin-right: 10px; min-width:88px; background-color: #368ee0;" id="save_from">保存</button>
										</td>
									</tr>
									</tbody>
								</table>
								</from>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

  
 