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
		
		$maintain_froms = Sdba::table('maintain_froms');
  		$maintain_froms->where('id',$_GET['id']);
  		$total_maintain_froms = $maintain_froms->total();
  		$maintain_froms_list = $maintain_froms->get();
  		$result = json_decode($maintain_froms_list[0]['remark'],true);
  		
  		for ($k=0; $k<count($result);$k++){
  			$result[$k]['text']=$_POST['text'][$k];
  		}
  	 
  		
  		
		$data = array(
			'remark'=> json_encode($result) 
		);
		$maintain_froms ->update($data);
		
		unset($_SESSION["key"]);
		$_SESSION["key"] = md5(uniqid().mt_rand());				
		?>

<script>
//location.reload();
</script>
		<?php								 
 }
 ?>
<script type="text/javascript" src="Editor/ckeditor.js"></script>
<script src="Editor/editor.js" type="text/javascript"></script>

		<div id="main">
			<div class="container-fluid">
				<?php 
				$maintain_froms = Sdba::table('maintain_froms');
  				$maintain_froms->where('id',$_GET['id']);
  				$total_maintain_froms = $maintain_froms->total();
  				$maintain_froms_list = $maintain_froms->get();
  				
  				$reports = Sdba::table('reports');
  				$reports ->where('id', $maintain_froms_list[0]['report_id']);
  				$reports_list = $reports->get();
				?>
				<div class="page-header">
					<div class="pull-left">
						<h1 style="line-height: 32px;"><?php echo $reports_list[0]['name_cn']; ?><br><?php  $type=$maintain_froms_list[0]['from_type']; echo $from_type_en[$type].' System ('.$from_type[$type].'系統)'; ?></h1>
					</div>
					<div class="pull-right">
						 
						<ul class="stats">
							 
							<li class='lightred'>
								<a href='mrm_print.php?id=<?php echo $maintain_froms_list[0]['id']; ?>' target='blank'>
								<i class="fa fa-print"></i>
								<div class="details">
									<span class="big">Print preview</span>
									<span>移至列印頁面</span>
								</div>
								</a>
							</li>
						</ul>
					</div>
				</div>
				<div class="breadcrumbs">
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
							<a href="?page=maintain_froms&id=<?php echo $maintain_froms_list[0]['report_id']; ?>"><?php echo $reports_list[0]['name_en']; ?></a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a><?php echo $type; ?></a>
							 
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
									<a href="?page=maintain_ltem_results_backup&id=<?php echo $_GET['id']; ?> ">Original</a>
								</li>
								<li>
									<a href="?page=maintain_ltem_results&id=<?php echo $_GET['id']; ?> ">Edit</a>
								</li>
								<li class="active">
									<a href="?page=maintain_remark&id=<?php echo $_GET['id']; ?> ">Remark</a>
								</li>
								<li >
									<a href="?page=photo_report_view&id=<?php echo $_GET['id']; ?> ">Photo Report</a>
								</li> 
							 
							</ul>
						</p>
					</div>
				</div>
				
				<div class="row">
					<div class="col-sm-12">
						<div class="box">
							
							<div class="box-content nopadding">
								<form action="Word.php" method="post">
		
								<textarea class="ckeditor" cols="100" id="editor1" name="editortext" rows="20">
								<?php   
								$result = json_decode($maintain_froms_list[0]['remark'],true); 
								//echo '<pre>';
								//print_r($result); 
								//echo '</pre>';
								?>
								 
								<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered dataTable-colvis  ">
									 
									<tbody>
									
  									<?php 
  										for ($i=0; $i<count($result);$i++){
  											
  											
  									?>
  										<tr>
											<td style="vertical-align: middle;background: #eee;"  >
												<?php 
													if ($result[$i]['ref'] !=''){ 
													 	echo $result[$i]['ref'].': '.$result[$i]['title']; 
													 }else{
													 	echo '其他問題';
													 }
												?>
											</td>				 
										</tr>
										<tr>
											<td style="vertical-align: middle;"  >
												 
												
												 <?php echo $result[$i]['text'] ; ?> 
												 
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
  												/*<img src="data:image/png;base64,<?php echo base64_encode(file_get_contents('upload/'.$photos_list[0]['remote'])); ?>" /> */
  												?>
  												
  												
												<img src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/job/ms/upload/<?php echo $photos_list[0]['remote'] ; ?>"  style=" padding: 20px 50px; ">
												<?php } ?>
											</td>				 
										</tr>
										 
									<?php } ?>
									<tr>
										 
									</tr>
									</tbody>
								</table>
								 </textarea>
								 <input type="submit" class="downloadbutton" value="Download as Word" />
								 </form> 
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

  
 