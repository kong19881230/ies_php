<?php if (!defined('EL_ADMIN')) exit('No direct script access allowed'); ?>
 <?php 
 if(isset($_SESSION["key"], $_POST["key"]) && $_SESSION["key"] == $finalkey){
 	date_default_timezone_set("Asia/Hong_Kong");
		
		$ud_equipments = Sdba::table('equipments');
		
		$postvalue =  $_POST['value'];
		$postnamesid = $_POST['namesid'];
		if (count($postvalue)>0){
		foreach($postvalue as $keys => $values){
			if ($values != ''){
				$newvalue[$postnamesid[$keys]] = $values;
			}
		}
		}
		if (empty($finalref_no)){
			$error_msg = 'Please Enter the Reference No.';
		}else{
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
  		
  		
  		echo '　　　　　　　　　　　　　　　　　　　　　　　　>>>>'.count($_FILES['gallery']['tmp_name']); ;
		$gallery = array();
		//new add gallery
		if (count($_FILES['gallery']['tmp_name'])>0){
		foreach($_FILES['gallery']['tmp_name'] as $key => $tmp_name){
			if (($_FILES["gallery"]["type"][$key] == "image/gif")
  					|| ($_FILES["gallery"]["type"][$key] == "image/jpeg")
					|| ($_FILES["gallery"]["type"][$key] == "image/pjpeg")
					|| ($_FILES["gallery"]["type"][$key] == "image/jpg")
  					|| ($_FILES["gallery"]["type"][$key] == "image/png" )
  					&& ($_FILES["gallery"]["size"][$key] < 800000))
   			 		{
					$galleryname = 'gallery'.date('YmdHis').$key.'.jpg';
					move_uploaded_file($_FILES["gallery"]["tmp_name"][$key],"photo/equipment/".$_FILES["gallery"]["name"][$key]);
					squarenailByGd("photo/equipment/" , $_FILES["gallery"]["name"][$key],580, 280,$galleryname);
					
					$gallery[] = $galleryname;
					 
					echo $galleryname.',';
					echo $_FILES["gallery"]["name"][$key].'/';
  					//$ud_cms_activities_list = $ud_cms_activities->get();
			
			}else{
					if ($gallery_og[$key] != ''){
						$gallery[] = $gallery_og[$key];
					}
					$galleryname = '';
					echo 'error:';
					echo $_FILES["gallery"]["size"][$key].'-'.$_FILES["gallery"]["type"][$key].'/';
			}
		}
		}
		/*
		echo '<pre>';
		print_r($gallery);
		echo '</pre>';
  		
  		
		$data = array(
			'project_id'=> $_GET['id'],
			'machine_id'=> $finalmachine_id,
			'phone_num'=>$finalphone_num,
			'ref_no'=> $finalref_no,
			'photo'=> $photoname
		);
		*/
		$data = array(
				'model_id'=> $finalmodel_id,
				'project_id'=> $_GET['id'],
				'type'=> $finaltype,
				'phone_num'=>$finalphone_num,
				'ref_no'=> $finalref_no,
				'photo'=> $photoname,
				'gallery'=> json_encode($gallery),
				'com_method'=> $finalcom_method,
				'note'=> $finalnote
			);
		$ud_equipments ->insert($data);
		$insert_id = $ud_equipments->insert_id();
		
		
		
		//echo '<pre>';
		//print_r($newvalue);
		//echo '</pre>';
		//Project id 
		
		$equipment_attributes = Sdba::table('equipment_attributes');
  		 
  		if (count($newvalue)>0){
  		foreach($newvalue as $keys => $values){
  		//for ($k=0; $k < count($newvalue); $k++){
  			$data = array(
  				'equipment_id' => $insert_id,
				'equipment_attribute_name_id'=> $keys,
				'value'=> $values 
			);
			$equipment_attributes ->insert($data);
  		}
		}	
			
		unset($_SESSION["key"]);
		$_SESSION["key"] = md5(uniqid().mt_rand());				
		?>
<script>
window.location = './?page=equipments&id=<?php echo $_GET["id"]; ?>';
</script>
		<?php								 
}

 }else{
 	$_SESSION["key"] = md5(uniqid().mt_rand());		
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
							<a href="?page=equipments&id=<?php echo $_GET['id']; ?>">equipments</a>	 
							 <i class="fa fa-angle-right"></i>
						</li>
						
						<li>
							<a href="#">Add</a>
							
						</li>
						 
					</ul>
					<div class="close-bread">
						<a href="#">
							<i class="fa fa-times"></i>
						</a>
					</div>
				</div>
 				<?php if ($error_msg !=''){ ?>
 				<div class="alert alert-danger alert-dismissable" style="margin-bottom: 0px;">
					<button type="button" class="close" data-dismiss="alert">×</button>
					<strong>請注意! </strong><?php echo $error_msg; ?>
				 
				</div>
				<?php } ?>
				<div class="row">
					<div class="col-sm-12">
						<div class="box box-bordered">
							<div class="box-title">
								<h3>
									<i class="fa fa-th-list"></i> Add </h3>
							</div>
							<div class="box-content nopadding">
							
								<form action="?page=equipments_add&id=<?php echo $_GET['id']; ?>" method="POST" enctype="multipart/form-data" class='form-horizontal form-bordered'>
									 
									<div class="form-group">
										<label for="textfield" class="control-label col-sm-2">Model ID</label>
										<div class="col-sm-10">
											<input type="text" name="model_id" id="textfield" placeholder="" class="form-control" value='<?php echo $finalmodel_id; ?>'>
										</div>
									</div> 
									<div class="form-group">
										<label for="textfield" class="control-label col-sm-2">Equipment Type</label>
										<div class="col-sm-10">
											<select name="type" id="e_type" class='select2-me' style="width:100%">
											<?php if (isset($_GET['e_type'])){ $e_type = $_GET['e_type']; }elseif(isset($finaltype)){ $e_type =$finaltype;}else{ $e_type = 'boiler';} ?>
											<?php foreach($from_type as $key => $value){ ?>
												<option value="<?php echo $key; ?>" <?php if ($e_type == $key){ echo 'selected'; } ?> ><?php echo $from_type_en[$key]; ?></option>
												 
											<?php } ?>
											</select>
											
										</div>
									</div> 
									
									<div class="form-group">
										<label for="textfield" class="control-label col-sm-2">Phone Number</label>
										<div class="col-sm-10">
											<input type="text" name="phone_num" id="textfield" placeholder="" class="form-control" value='<?php echo $finalphone_num; ?>'>
										</div>
									</div>
									<div class="form-group">
										<label for="text" class="control-label col-sm-2">Reference No. *</label>
										<div class="col-sm-10">
											<input type="text" name="ref_no" id="text" placeholder="" class="form-control" value='<?php echo $finalref_no; ?>'>
										</div>
									</div>
									<div class="form-group">
										<label for="text" class="control-label col-sm-2">Main Photo<br><?php if ($error_msg !=''){ ?><span style='color:red;'>請重新選擇</span><?php  }?></label>
										 
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
									
									<div class="form-group" >
										<label for="text" class="control-label col-sm-2">Gallery<br><?php if ($error_msg !=''){ ?><span style='color:red;'>請重新選擇</span><?php  }?></label>
										 
										<div class="col-sm-10" id='gallery_col'>
										 
											<div class="fileinput fileinput-new" data-provides="fileinput" id="<?php echo 'gallery'.$i; ?>">
												<div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;"></div>
												<div>
													<span class="btn btn-default btn-file">
														<span class="fileinput-new">Select image</span>
														
													<span class="fileinput-exists">Change</span>
													<input type="file" name="gallery[]">
													</span>
													 
													<a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
												</div>
											</div>
											 
											<div class="fileinput fileinput-new" data-provides="fileinput" style="float: right;">
											<a href='#adds' id='addgallery'>
												<div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 100px; height: 100px; font-size:60px;">+</div>
											</a> 
											</div>
										</div>
									</div>
									
									<div class="form-group">
										<label for="textfield" class="control-label col-sm-2">Communication Method</label>
										<div class="col-sm-10">
											<select name="com_method" id="com_method" class='select2-me' style="width:100%">
											 
												<option value="sms" <?php if ($finalcom_method  == 'sms'){ echo 'selected'; } ?> >SMS</option>
												<option value="web" <?php if ($finalcom_method == 'web'){ echo 'selected'; } ?> >Internet</option> 
											 
											</select>
											
										</div>
									</div> 
									
									<?php  
									 
  								$equipment_attribute_names = Sdba::table('equipment_attribute_names');
  								$equipment_attribute_names->where('type',$e_type);
  								$total_equipment_attribute_names = $equipment_attribute_names->total();
  								$equipment_attribute_names_list = $equipment_attribute_names->get();
  								//echo $total_rows;
  								//print_r($reportlist);
  								
  							 
  								
  								$value = '';
  								
  								for ($a=0; $a<$total_equipment_attribute_names; $a++){
  									if (count($newvalue)>0){
  									foreach ($newvalue as $keys => $values){
  									//for ($b=0; $b<$total_equipment_attributes; $b++){
  										if ($keys==$equipment_attribute_names_list[$a]['id']) {
  											$value = $values;
  										}
  									}
  									}
  								?>
								
									<div class="form-group">
										<label for="textfield" class="control-label col-sm-2"><?php echo $equipment_attribute_names_list[$a]['name_en']; ?></label>
										<div class="col-sm-10">
											<input type="text" name="value[]" id="textfield" placeholder="不要請留空即可" class="form-control" value='<?php echo $value; ?>'>
											<input type="hidden" name="namesid[]" id="textfield"  class="form-control" value='<?php echo $equipment_attribute_names_list[$a][id]; ?>'>
										</div>
									</div>
								<?php $value=''; } ?>
									
									<div class="form-group">
										<label for="textfield" class="control-label col-sm-2">Note</label>
										<div class="col-sm-10">
											<textarea id="note" name="note" class="form-control " placeholder="" rows="3"><?php echo $finalnote; ?></textarea>
										</div>
									</div>
									
									</div>
									 
									 
									<div class="form-actions col-sm-offset-2 col-sm-10">
										<input type="hidden" name="nowid" id="nowid" value="<?php echo $_GET['id']; ?>">
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
   <script src="js/jquery.min.js"></script>
    <script type="text/javascript">
    $(document).ready(function(){
		$('#e_type').change(function() {
			var e_type = $(this).val();
     		 var nowid = $('#nowid').val();
			window.location = './?page=equipments_add&id='+nowid +'&e_type='+e_type;
            //$(location).attr('href', 'http://www.sitefinity.com');
        });
    });
    $('#addgallery').click(function(){
			
			var gethtml = '<div class="fileinput fileinput-new" data-provides="fileinput">'+
								'<div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;"></div>'+
								'<div>'+
									'<span class="btn btn-default btn-file"> <span class="fileinput-new">Select image</span> <span class="fileinput-exists">Change</span>'+
										'<input type="file" name="gallery[]">'+
									'</span>'+
									'<a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>'+
								'</div>'+
							'</div>';
			//alert(gethtml);
			
			$('#gallery_col').append(gethtml);
		});
		 
    </script>