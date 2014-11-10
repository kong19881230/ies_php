<?php if (!defined('EL_ADMIN')) exit('No direct script access allowed'); ?>
 <?php 
 if(isset($_SESSION["key"], $_POST["key"]) && $_SESSION["key"] == $finalkey){
 	date_default_timezone_set("Asia/Hong_Kong");
		
		$ud_equipments = Sdba::table('equipments');
		//$ud_equipments ->where('id', $_GET['id']);
		if (($_FILES["photo"]["type"] == "image/gif")
  				|| ($_FILES["photo"]["type"] == "image/jpeg")
				|| ($_FILES["photo"]["type"] == "image/pjpeg")
				|| ($_FILES["photo"]["type"] == "image/jpg")
  				|| ($_FILES["photo"]["type"] == "image/png" )
  				&& ($_FILES["photo"]["size"] < 800000))
   			 	{
			$photoname = 'equipments'.date('Y-m-d-H-i-s').'.jpg';
			move_uploaded_file($_FILES["photo"]["tmp_name"],"photo/equipment/".$_FILES["photo"]["name"]);
			squarenailByGd("photo/equipment/" , $_FILES["photo"]["name"],580, 280,$photoname);
		}else{
			$photoname = '';
		}
		//echo $_FILES["photo"]["name"];
  		//$ud_equipments_list = $ud_equipments->get();
		$data = array(
			'project_id'=> $_GET['id'],
			
			'phone_num'=>$finalphone_num,
			'ref_no'=> $finalref_no,
			'photo'=> $photoname,
			'type'=>$finaltype,
			'model_id'=>$finalmodel_id
		);
		$ud_equipments ->insert($data);
		unset($_SESSION["key"]);
		$_SESSION["key"] = md5(uniqid().mt_rand());				
		?>
<script>
window.location = './?page=equipments&id=<?php echo $_GET["id"]; ?>';
</script>
		<?php								 
 }
 ?>
 		<div id="main">
			<div class="container-fluid">
				<div class="page-header">
					<div class="pull-left">
						<h1>Equipments </h1>
					</div>
					<div class="pull-right">
						 
						<ul class="stats">
							 
							<li class='lightred'>
								<i class="fa fa-calendar"></i>
								<div class="details">
									<span class="big">February 22, 2013</span>
									<span>Wednesday, 13:56</span>
								</div>
							</li>
						</ul>
					</div>
				</div>
				<?php  
  					$equipments = Sdba::table('equipments');
  					$equipments->where('id',$_GET['id']);
  					$total_equipments = $equipments->total();
  					$equipments_list = $equipments->get();
  					//echo $total_rows;
  					//print_r($reportlist);
  				?>
				<div class="breadcrumbs">
					<ul>
						<li>
							<a href="?page=home">Home</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="?page=projects">Projects</a>
							 <i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="?page=equipments">equipments</a>
							 
						</li>
						
						<li>
							<a href="#">Add</a>
							 <i class="fa fa-angle-right"></i>
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
						<div class="box box-bordered">
							<div class="box-title">
								<h3>
									<i class="fa fa-th-list"></i> Add </h3>
							</div>
							<div class="box-content nopadding">
							
								<form action="?page=equipments_add&id=<?php echo $_GET['id']; ?>" method="POST" enctype="multipart/form-data" class='form-horizontal form-bordered'>
									<!-- <div class="form-group">
										<label for="textfield" class="control-label col-sm-2">machine_id</label>
										<div class="col-sm-10">
											 
											<select name="machine_id" id="machine_id" class='select2-me' style="width:100%">
												 <?php
													$machines = Sdba::table('machines');
  										 			$total_machines = $machines->total();
  													$machines_list = $machines->get();
  										 
  													for ($i=0; $i<$total_machines;$i++){ ?>
													<option value="<?php echo $machines_list[$i]['id'];?>"  ><?php echo $machines_list[$i]['name'].' / '.$machines_list[$i]['model_id']; ?></option>
												<?php  } ?>
												  
											</select>
										</div>
									</div> -->
									 
									
									<div class="form-group">
										<label for="textfield" class="control-label col-sm-2">Phone num</label>
										<div class="col-sm-10">
											<input type="text" name="phone_num" id="textfield" placeholder="" class="form-control" value=''>
										</div>
									</div>
									<div class="form-group">
										<label for="text" class="control-label col-sm-2">Ref no</label>
										<div class="col-sm-10">
											<input type="text" name="ref_no" id="text" placeholder="" class="form-control" value=''>
										</div>
									</div>
									<div class="form-group">
										<label for="text" class="control-label col-sm-2">Type</label>
										<div class="col-sm-10">
											<input type="text" name="type" id="type" placeholder="" class="form-control" value=''>
										</div>
									</div>
									<div class="form-group">
										<label for="text" class="control-label col-sm-2">Model ID</label>
										<div class="col-sm-10">
											<input type="text" name="model_id" id="model_id" placeholder="" class="form-control" value=''>
										</div>
									</div>
									<div class="form-group">
										<label for="text" class="control-label col-sm-2">photo</label>
										 
										<div class="form-group">
										<label for="textfield" class="control-label col-sm-2"></label>
										<div class="col-sm-10">
											<div class="fileinput fileinput-new" data-provides="fileinput">
												<div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;"></div>
												<div>
													<span class="btn btn-default btn-file">
														<span class="fileinput-new">Select image</span>
													<span class="fileinput-exists">Change</span>
													<input type="file" name="photo">
													</span>
													<a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
												</div>
											</div>
										</div>
									</div>
									</div>
									 
									 
									<div class="form-actions col-sm-offset-2 col-sm-10">
										<input type="hidden" name="key" value="<?php echo htmlspecialchars($_SESSION["key"], ENT_QUOTES);?>">
										<button type="submit" class="btn btn-primary">Add</button>
										<a type="button" class="btn" href="?page=equipments&id=<?php echo $_GET['id']; ?>">Cancel</a>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				 
			</div>
		</div>
	</div>