<?php if (!defined('EL_ADMIN')) exit('No direct script access allowed'); ?>
 <?php 
 if(isset($_SESSION["key"], $_POST["key"]) && $_SESSION["key"] == $finalkey){
 	date_default_timezone_set("Asia/Hong_Kong");
		
		$ud_equipments = Sdba::table('equipments');
		$ud_equipments ->where('id', $_GET['id']);
		 
  		$ud_equipments_list = $ud_equipments->get();
  		$gallery_og = json_decode($ud_equipments_list[0]['gallery'],true);
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
			$photoname = $ud_equipments_list[0]['photo'];
		}
		
		if ($_FILES["photo"]["name"]==''){
			//echo '　　　　　　　　　　　　　　　　　xxxxx'.$ud_equipments_list[0]['photo'];
			$photoname = $ud_equipments_list[0]['photo'];
		}
		echo '　　　　　　　　　　　　　　　　　　　　　　　　>>>>'.count($_FILES['gallery']['tmp_name']); ;
		$gallery = array();
		//new add gallery
		if ($_FILES['gallery']['tmp_name']>0){
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
					/*
					$uploads = Sdba::table('uploads');
					//$uploads->where('prod_code', $_SESSION['prod_code']);
					//$total_uploads = $uploads->total();
					//$uploadslist = $uploads->get();
					$data = array(
						'upload_name'=> $photoname,
						'prod_code'=>$ud_cms_activitieslist[0]['prod_code'] 
					);
					$uploads ->insert($data);
					*/
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
		echo '<pre>';
		print_r($gallery);
		echo '</pre>';
		
			$data = array(
				'model_id'=> $finalmodel_id,
				'type'=> $finaltype,
				'phone_num'=>$finalphone_num,
				'ref_no'=> $finalref_no,
				'photo'=> $photoname,
				'gallery'=> json_encode($gallery),
				'com_method'=> $finalcom_method,
				'note'=> $finalnote
			);
			$ud_equipments ->update($data);
			
			$postvalue =  $_POST['value'];
		$postnamesid = $_POST['namesid'];
		if (count($postvalue)>0){
		foreach($postvalue as $keys => $values){
			if ($values != ''){
				$newvalue[$postnamesid[$keys]] = $values;
			}
		}
		}
		//echo '<pre>';
		//print_r($newvalue);
		//echo '</pre>';
		//Project id 
		
		$equipment_attributes = Sdba::table('equipment_attributes');
  		$equipment_attributes->where('equipment_id',$_GET['id']);
  		$equipment_attributes->delete();
  		
  		if (count($newvalue)>0){
  		foreach($newvalue as $keys => $values){
  		//for ($k=0; $k < count($newvalue); $k++){
  			$data = array(
  				'equipment_id' => $_GET['id'],
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
window.location = './?page=equipments&id=<?php echo $ud_equipments_list[0]["project_id"]; ?>';
</script>
		<?php								 
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
							<a href="?page=equipments&id=<?php echo $equipments_list[0]['project_id'] ; ?>">equipments</a>
							 <i class="fa fa-angle-right"></i>
						</li>
						
						<li>
							<a href="#">Edit</a>
							 <i class="fa fa-angle-right"></i> 
						</li>
						 <li>
							<a href="#"><?php echo $equipments_list[0]['ref_no']; ?>  </a>
							
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
									<i class="fa fa-th-list"></i> 編輯 <?php echo $equipments_list[0]['ref_no']; ?> </h3>
							</div>
							<div class="box-content nopadding">
							
								<form action="?page=equipments_edit&id=<?php echo $equipments_list[0]['id']; ?>" method="POST" enctype="multipart/form-data" class='form-horizontal form-bordered'>
									 
									<div class="form-group">
										<label for="textfield" class="control-label col-sm-2">Model ID</label>
										<div class="col-sm-10">
											<input type="text" name="model_id" id="textfield" placeholder="<?php echo chkempty($equipments_list[0]['model_id']); ?>" class="form-control" value='<?php echo $equipments_list[0]['model_id']; ?>'>
										</div>
									</div> 
									<div class="form-group">
										<label for="textfield" class="control-label col-sm-2">Equipment Type</label>
										<div class="col-sm-10">
											<select name="type" id="e_type" class='select2-me' style="width:100%">
											<?php if (isset($_GET['e_type'])){ $e_type = $_GET['e_type']; }else{ $e_type = $equipments_list[0]['type'];} ?>
											<?php foreach($from_type as $key => $value){ ?>
												<option value="<?php echo $key; ?>" <?php if ($e_type == $key){ echo 'selected'; } ?> ><?php echo $from_type_en[$key]; ?></option>
												 
											<?php } ?>
											</select>
											
										</div>
									</div> 
									<div class="form-group">
										<label for="textfield" class="control-label col-sm-2">Phone Number</label>
										<div class="col-sm-10">
											<input type="text" name="phone_num" id="textfield" placeholder="<?php echo chkempty($equipments_list[0]['phone_num']); ?>" class="form-control" value='<?php echo $equipments_list[0]['phone_num']; ?>'>
										</div>
									</div>
									<div class="form-group">
										<label for="text" class="control-label col-sm-2">Reference No.</label>
										<div class="col-sm-10">
											<input type="text" name="ref_no" id="text" placeholder="<?php echo chkempty($equipments_list[0]['ref_no']); ?>" class="form-control" value='<?php echo $equipments_list[0]['ref_no']; ?>'>
										</div>
									</div>
									<div class="form-group">
										<label for="text" class="control-label col-sm-2">Main Photo</label>
										<div class="form-group">
										<label for="textfield" class="control-label col-sm-2"></label>
										<div class="col-sm-10">
											<div class="fileinput fileinput-new" data-provides="fileinput">
												<div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;">
													<img src="photo/equipment/<?php echo $equipments_list[0]['photo']; ?>" >
												</div>
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
										<label for="text" class="control-label col-sm-2">Gallery</label>
										 
										<div class="col-sm-10" id='gallery_col'>
										<?php $gallerys = json_decode($equipments_list[0]['gallery'],true); ?>
										<?php for ($i=0; $i<count($gallerys); $i++) { ?>
											<div class="fileinput fileinput-new" data-provides="fileinput" id="<?php echo 'gallery'.$i; ?>">
												<div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;">
													<img src="photo/equipment/<?php echo $gallerys[$i]; ?>" >
												</div>
												<div>
													<span class="btn btn-default btn-file">
														<span class="fileinput-new">Select image</span>
														
													<span class="fileinput-exists">Change</span>
													<input type="file" name="gallery[]">
													</span>
													 
													<a href="#delgallery" class="btn btn-default delgallery" id="<?php echo 'delgallery'.$i; ?>">Remove</a>
												</div>
											</div>
										<?php } ?>
											 
											 
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
											 
												<option value="sms" <?php if ($equipments_list[0]['com_method'] == 'sms'){ echo 'selected'; } ?> >SMS</option>
												<option value="web" <?php if ($equipments_list[0]['com_method'] == 'web'){ echo 'selected'; } ?> >Internet</option> 
											 
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
  								
  								$equipment_attributes = Sdba::table('equipment_attributes');
  								$equipment_attributes->where('equipment_id',$_GET['id']);
  								$total_equipment_attributes = $equipment_attributes->total();
  								$equipment_attributes_list = $equipment_attributes->get();
  								$value = '';
  								for ($a=0; $a<$total_equipment_attribute_names; $a++){
  									for ($b=0; $b<$total_equipment_attributes; $b++){
  										if ($equipment_attributes_list[$b]['equipment_attribute_name_id']==$equipment_attribute_names_list[$a]['id']) {
  											$value = $equipment_attributes_list[$b]['value'];
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
											<textarea id="note" name="note" class="form-control " placeholder="" rows="3"><?php echo $equipments_list[0]['note']; ?></textarea>
										</div>
									</div>
									</div>
									 
									 
									<div class="form-actions col-sm-offset-2 col-sm-10">
										<input type="hidden" name="nowid" id="nowid" value="<?php echo $_GET['id']; ?>">
										<input type="hidden" name="key" value="<?php echo htmlspecialchars($_SESSION["key"], ENT_QUOTES);?>">
										<button type="submit" class="btn btn-primary">Save changes</button>
										<a type="button" class="btn" href="?page=equipments&id=<?php echo $equipments_list[0]['project_id']; ?>">Cancel</a>
									</div>
									 
									<div class="form-actions  col-sm-12" style="border-top: 2px solid #ddd;">
										<h3 style="width: 50%; float: left;"> <i class="fa fa-th-list"></i> Indicators </h3>
										 
										 
										<a type="button" class="btn btn-blue" id='add' href="#add" style="width:160px;float:right; font-size:20px;"><i class="fa fa-plus-square" style="font-size:20px;"></i>　新增</a>
									</div>
								</form>
								<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered dataTable-colvis  ">
									<thead>
										<tr>
											<th style="text-align: center; display:none;">#ID</th>
											<th style="text-align: center;" width='80'>Type</th>
											<th style="text-align: center;" width='100'>Channel</th>
											<th style="text-align: center;" width='200'>Name</th>						 
											<th style="text-align: center; display:none;" width='260'>name_cn </th>
											<th style="text-align: center;" width='160'>Unit</th>
											<th style="text-align: center;">Indicator Display Style</th>
											<th style="text-align: center;" width='100'>Photo</th>
											<th style="text-align: center;" width='160'>Option</th>
										</tr>
									</thead>
									<tbody>
									<?php  
  										$indicators = Sdba::table('indicators');
  										$indicators->where('equipments_id',$_GET['id']); 
  										$total_indicators = $indicators->total();
  										$indicators_list = $indicators->get();
  										
  										//echo $total_rows;
  										//print_r($reportlist);
  									?>
  									<tr id='add_tr' style="background-color: FloralWhite; display:none">
											<td style="text-align: center; display:none;" >新增</td>
											<td style="text-align: center;">
												<span id = 'text_type<?php echo $ind_id; ?>' style="display:none;"><?php echo $indicators_list[$i]['type']; ?></span> 
												
												<select  id="type_add" class='select2-me type_item' style="width:60px;">
													<option value="CH" >CH</option>
												 	<option value="IP" >IP</option>
												</select>
											</td>
											<td style="text-align: center;">
												<span id = 'text_channel<?php echo $ind_id; ?>' style="display:none;">　</span> 
												<select  id="channel_add" class='select2-me' style="width:80px;  ">
												<?php for ($a=1; $a<=8; $a++) { ?>
													<option value="<?php echo $a; ?>" ><?php echo $a; ?></option>
												<?php } ?>
												 
												</select>
											</td>
											<td style="text-align: center;">
												<span id = 'text_name_en<?php echo $ind_id; ?>' style="display:none;">　</span>
												<input type="text" id="name_en_add" id="text" class="form-control" value=''  width='200px'>
											</td>
											<td style="text-align: center; display:none;">
												<span id = 'text_name_cn<?php echo $ind_id; ?>' style="display:none;"><?php echo chkempty($indicators_list[$i]['name_cn']); ?></span>
												<input type="text" id="name_cn_add" id="text" class="form-control" value=''  width='200px'  >
											</td>
											<td style="text-align: center;">
												<span id = 'text_unit<?php echo $ind_id; ?>' style="display:none;"><?php echo chkempty($indicators_list[$i]['unit']); ?></span>
												<input type="text" id="unit_add" id="text" class="form-control" value=''  width='100px'  >
											</td>
											<td style="text-align: center;" id='tdindicator_add'>
												 
												<span id='select_indicator_display_style_id_add' >

												<?php  
  													$indicator_display_styles = Sdba::table('indicator_display_styles');
  													$indicator_display_styles->where('type','IP'); 
  													$total_indicator_display_styles = $indicator_display_styles->total();
  													$indicator_display_styles_list = $indicator_display_styles->get();
  										
  													//echo $total_rows;
  													//print_r($reportlist);
  												?> 
  												<select id="indicator_display_style_id_IP_add" class='select2-me ids' style="width:230px;   display:none; " >
												<?php for ($b=0; $b<$total_indicator_display_styles; $b++) { ?>
													<option value="<?php echo $indicator_display_styles_list[$b]['id']; ?>" ><?php echo $indicator_display_styles_list[$b]['name']; ?></option>
												<?php } ?>
												 
												</select>
												
																								<?php  
  													$indicator_display_styles = Sdba::table('indicator_display_styles');
  													$indicator_display_styles->where('type','CH'); 
  													$total_indicator_display_styles = $indicator_display_styles->total();
  													$indicator_display_styles_list = $indicator_display_styles->get();
  										
  													//echo $total_rows;
  													//print_r($reportlist);
  												?><span id='ids_val_add' style="display:none;"><?php echo $indicators_list[$i]['indicator_display_style_id']; ?></span> 
  												<select id="indicator_display_style_id_CH_add" class='select2-me ids' style="width:230px;" >
												<?php for ($b=0; $b<$total_indicator_display_styles; $b++) { ?>
													<option value="<?php echo $indicator_display_styles_list[$b]['id']; ?>"  ><?php echo $indicator_display_styles_list[$b]['name']; ?></option>
												<?php } ?>
												 
												</select>
												</span>
												
											</td>
											<td style="text-align: center;">
												<img src="photo/indicator/3.jpg" height="80px"  id='img_add' >
											</td> 
											 
											<td style="text-align: center;"> 
												 
												<a href="#add" class="btn addnew" rel="tooltip" title="" data-original-title="Add" id='addnew' >
													新增
												</a>
												<a href="#cancel" class="btn canceladd" rel="tooltip" title="" data-original-title="Cancel" id='canceladd' >
													取消
												</a>
												 
												 
												 
											</td>
										</tr>
  									<?php 
  										for ($i=0; $i<$total_indicators;$i++){
  											 $ind_id = $indicators_list[$i]['id'];
  											
  									?>
  										<tr id='tr<?php echo $ind_id; ?>'>
											<td style="text-align: center; display:none;" >
												<?php echo $indicators_list[$i]['id'];   ?>
												
											</td>
											<td style="text-align: center;">
												<span id = 'text_type<?php echo $ind_id; ?>'><?php echo $indicators_list[$i]['type']; ?></span> 
												
												<select  id="type<?php echo $ind_id; ?>" class='select2-me type_item' style="width:60px;  display:none;">
													<option value="CH" <?php if ($indicators_list[$i]['type']=='CH'){echo 'selected'; } ?>>CH</option>
												 	<option value="IP" <?php if ($indicators_list[$i]['type']=='IP'){echo 'selected'; } ?>>IP</option>
												</select>
											</td>
											<td style="text-align: center;">
												<span id = 'text_channel<?php echo $ind_id; ?>'><?php echo chkempty($indicators_list[$i]['channel']); ?></span> 
												<select  id="channel<?php echo $ind_id; ?>" class='select2-me' style="width:80px; display:none;">
												<?php for ($a=1; $a<=8; $a++) { ?>
													<option value="<?php echo $a; ?>" <?php if ($indicators_list[$i]['channel']==$a){echo 'selected'; } ?>><?php echo $a; ?></option>
												<?php } ?>
												 
												</select>
											</td>
											<td style="text-align: center;">
												<span id = 'text_name_en<?php echo $ind_id; ?>'><?php echo chkempty($indicators_list[$i]['name_en']); ?></span>
												<input type="text" id="name_en<?php echo $ind_id; ?>" id="text" class="form-control" value='<?php echo $indicators_list[$i]['name_en']; ?>'  width='200px' style="display:none;">
											</td>
											<td style="text-align: center; display:none;">
												<span id = 'text_name_cn<?php echo $ind_id; ?>'><?php echo chkempty($indicators_list[$i]['name_cn']); ?></span>
												<input type="text" id="name_cn<?php echo $ind_id; ?>" id="text" class="form-control" value='<?php echo $indicators_list[$i]['name_cn']; ?>'  width='200px' style="display:none;">
											</td>
											<td style="text-align: center;">
												<span id = 'text_unit<?php echo $ind_id; ?>'><?php echo chkempty($indicators_list[$i]['unit']); ?></span>
												<input type="text" id="unit<?php echo $ind_id; ?>" id="text" class="form-control" value='<?php echo $indicators_list[$i]['unit']; ?>'  width='100px' style="display:none;">
											</td>
											<td style="text-align: center;" id='tdindicator<?php echo $ind_id; ?>'>
												<?php  
  													$indicator_display_styles_text = Sdba::table('indicator_display_styles');
  													$indicator_display_styles_text->where('id',$indicators_list[$i]['indicator_display_style_id']); 
  													$total_indicator_display_styles_text = $indicator_display_styles_text->total();
  													$indicator_display_styles_text_list = $indicator_display_styles_text->get();
  										
  													//echo $total_rows;
  													//print_r($reportlist);
  												?>
												<span id='text_indicator_display_style_id<?php echo $ind_id; ?>' ><?php echo $indicator_display_styles_text_list[0]['name']; ?></span>
												<span id='select_indicator_display_style_id<?php echo $ind_id; ?>' style="display:none;">
												<?php  
  													$indicator_display_styles = Sdba::table('indicator_display_styles');
  													$indicator_display_styles->where('type','CH'); 
  													$total_indicator_display_styles = $indicator_display_styles->total();
  													$indicator_display_styles_list = $indicator_display_styles->get();
  										
  													//echo $total_rows;
  													//print_r($reportlist);
  												?><span id='ids_val<?php echo $ind_id; ?>' style="display:none;"><?php echo $indicators_list[$i]['indicator_display_style_id']; ?></span> 
  												<select id="indicator_display_style_id_CH<?php echo $ind_id; ?>" class='select2-me ids' style="width:230px; <?php if ($indicators_list[$i]['type']!='CH'){echo 'display:none;'; } ?>" >
												<?php for ($b=0; $b<$total_indicator_display_styles; $b++) {  ?>
													<option value="<?php echo $indicator_display_styles_list[$b]['id']; ?>" <?php if ($indicators_list[$i]['indicator_display_style_id']==$indicator_display_styles_list[$b]['id']){echo 'selected'; $photo =  $indicator_display_styles_list[$b]['exm_photo'];} ?>><?php echo $indicator_display_styles_list[$b]['name']; ?></option>
												<?php } ?>
												 
												</select>
												<?php  
  													$indicator_display_styles = Sdba::table('indicator_display_styles');
  													$indicator_display_styles->where('type','IP'); 
  													$total_indicator_display_styles = $indicator_display_styles->total();
  													$indicator_display_styles_list = $indicator_display_styles->get();
  										
  													//echo $total_rows;
  													//print_r($reportlist);
  												?> 
  												<select id="indicator_display_style_id_IP<?php echo $ind_id; ?>" class='select2-me ids' style="width:230px; <?php if ($indicators_list[$i]['type']!='IP'){echo 'display:none;'; } ?>" >
												<?php for ($b=0; $b<$total_indicator_display_styles; $b++) { ?>
													<option value="<?php echo $indicator_display_styles_list[$b]['id']; ?>" <?php if ($indicators_list[$i]['indicator_display_style_id']==$indicator_display_styles_list[$b]['id']){echo 'selected'; $photo =  $indicator_display_styles_list[$b]['exm_photo']; } ?>><?php echo $indicator_display_styles_list[$b]['name']; ?></option>
												<?php } ?>
												 
												</select>
												</span>
												
											</td>
											<td style="text-align: center;">
												<img src="photo/indicator/<?php echo $photo; ?>" height="80px" id='img<?php echo $ind_id; ?>' >
											</td> 
											 
											<td style="text-align: center;"> 
												<a href="#edit" class="btn edit" rel="tooltip" title="" data-original-title="Edit" id='edit<?php echo $ind_id; ?>'>
													<i class="fa fa-pencil-square-o"></i>
												</a>
												<a href="#save" class="btn save" rel="tooltip" title="" data-original-title="Save" id='save<?php echo $ind_id; ?>' style="display:none;">
													<i class="fa fa-floppy-o"></i>
												</a>
												<a href="#cancel" class="btn cancel" rel="tooltip" title="" data-original-title="Cancel" id='cancel<?php echo $ind_id; ?>' style="display:none;">
													<i class="fa fa-undo"></i>
												</a>
												<a href="#del" class="btn del" rel="tooltip" title="" data-original-title="Delete" id='del<?php echo $ind_id; ?>' >
													<i class="fa fa-times"></i>
												</a>
												 
												 
											</td>
										</tr>
									<?php } ?>
									<input   type="hidden" id="equipments_id" value="<?php echo $_GET['id']; ?>">
									
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				 
			</div>
		</div>
	</div>
	<div class="overlays" id="overlay" style="display:none;" ></div>
	<div class="delbox" id="delmsg" style="display:none;">
        <div class="contents" style="height:200px; color:#333">
        	<i class="fa fa-exclamation-triangle" style="float: left; margin-left:200px; font-size:50px;margin-top: 10px;"></i>
            <p style="font-size: 36px;margin-top: 10px; text-align: left; margin-left:260px;">請注意！</p>
            <p style="font-size: 14px;margin-top: -16px; text-align: left; margin-left:260px; ">您是否要删除 <span id="msg"></span> 嗎？删除後將無法還原！</p>
        </div>
        <div class="last" style="margin: -110px -20px -20px -20px;">
        		<button class="btn btn-primary" style="margin-right: 10px; min-width:88px; background-color: #368ee0;" id="delcomfig">確認删除</button>
				<button class="btn btn-primary" style="margin-right: 200px; min-width:88px; background-color: #555;" id="dcloses">取消</button>
                <input name="delpopn" type="hidden" id="delpopn" value="">
                <input name="delpoid" type="hidden" id="del_id" value="">
        </div>
    </div>
   <script src="js/jquery.min.js"></script>
    <script type="text/javascript">
function  empty_check(value){
	value = $.trim(value);
	if (value == ''){
		value = 'N/A';
	}
	return value;
}

function get_photo(value, this_id){
	//alert(value+'/'+this_id);
	value = $.trim(value);
	var MM_get = "get_indicator_photo";
	 
	var id = value;
	var dataString =  'id='+ id + '&MM_get='+ MM_get ;	
		$.ajax({
			type: "POST",
			url: "edit_data.php",
			data: dataString,
			cache: false,
			success: function(text)
			{
				text = $.trim(text); 
				//$('#photo_file').val(text);
				$("#img"+this_id).attr("src","photo/indicator/"+text);
				//alert(text);
				
			}
		});
	//return text;	 
}
	//JQuery 実装
	$(document).ready(function(){
		$('#e_type').change(function() {
			var e_type = $(this).val();
     		var nowid = $('#nowid').val();
			window.location = './?page=equipments_edit&id='+nowid + '&e_type='+e_type;
            //$(location).attr('href', 'http://www.sitefinity.com');
        });
		
	
	
		$('.save').click(function(){
			var id= $(this).attr('id');
     		id =  id.slice(4);
     		//alert(id);
     		var name_cn = $( "#name_cn"+id ).val();
     		var name_en = $( "#name_en"+id ).val();
     		var type = $( "#type"+id ).val();
     		var channel = $( "#channel"+id ).val();
     		var unit = $( "#unit"+id ).val();
     		var indicator_display_style_id = $( "#indicator_display_style_id_"+type+id ).val();
     		var indicator_display_style_id_text = $( "#indicator_display_style_id_"+type+id +' option:selected').text();
     		
     		
     		
     		var equipments_id = $( "#equipments_id").val();
     		
     		var MM_update = "update_indicators";
     		
     		var dataString =  'id='+ id +'&equipments_id='+ equipments_id +'&name_cn='+ name_cn +'&name_en='+ name_en +'&type='+ type +'&channel='+ channel +'&unit='+ unit +'&indicator_display_style_id='+ indicator_display_style_id +'&MM_update='+ MM_update ;	
     		 
     		
     		$('#text_type'+id).text(type);
			$('#text_name_cn'+id).text(empty_check(name_cn));
			$('#text_name_en'+id).text(empty_check(name_en));
			$('#text_unit'+id).text(empty_check(unit));
			$('#text_channel'+id).text(channel);
			$('#text_indicator_display_style_id'+id ).text(indicator_display_style_id_text); 
		 	
			
			//alert(dataString+"/");
		 	
			$.ajax({
				type: "POST",
				url: "edit_data.php",
				data: dataString,
				cache: false,
				success: function(text)
				{
					text = $.trim(text);
					
					kekka = text.split("/");
					//alert(kekka[0] );
					result = kekka[0];
					if (result == "ok"){
						//alert(id);
						//alert("保存成功");		 
     					$('#save'+id).hide();
						$('#cancel'+id).hide();
						$('#edit'+id).show();
			
						$('#type'+id).hide();
						$('#name_cn'+id).hide();
						$('#name_en'+id).hide();
						$('#unit'+id).hide();
						$('#channel'+id).hide();
						$('#select_indicator_display_style_id'+id).hide();
			
						$('#text_type'+id).show();
						$('#text_name_cn'+id).show();
						$('#text_name_en'+id).show();
						$('#text_unit'+id).show();
						$('#text_channel'+id).show();
						$('#text_indicator_display_style_id'+id).show();
						
						$( "#tdindicator"+id ).css( "background-color", "white" );
						$( "#ids_val"+id ).text(indicator_display_style_id);
						//$('#text_indicator_display_style_id'+id).text();
						//location.reload();
					}else{
						alert("錯誤\n \n /"+text+"/");
						 
					}
					 
				}
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
		$('.delgallery').click(function(){
			var id= $(this).attr('id');
     		id =  id.slice(3);
     		//alert(id);
     		gid = id.slice(7);
     		var nowid = $('#nowid').val();
     		//$('#del_gallery').val(del_gallery_id+id+',');
     		
     		var MM_del = "del_gallery";
     		
     		var dataString =  'gid='+ gid +'&id='+ nowid +'&MM_del='+ MM_del ;	
     		
     		//alert(dataString);
     		
     		$.ajax({
				type: "POST",
				url: "edit_data.php",
				data: dataString,
				cache: false,
				success: function(text)
				{
					text = $.trim(text);
					
					if (text == "ok"){
						$('#'+id).html('');
						//alert("保存成功");
						
						//location.reload();
					}else{
						alert("錯誤\n \n /"+text+"/");
						 
					}
					 
				}
			});
			
		});
		$('#addnew').click(function(){
			//var id= $(this).attr('id');
     		//id =  id.slice(4);
     		//alert(id);
     		var name_cn = $( "#name_cn_add"  ).val();
     		var name_en = $( "#name_en_add"  ).val();
     		var type = $( "#type_add"  ).val();
     		var channel = $( "#channel_add"  ).val();
     		var unit = $( "#unit_add" ).val();
     		var indicator_display_style_id = $( "#indicator_display_style_id_"+type +'_add' ).val();
     		var indicator_display_style_id_text = $( "#indicator_display_style_id_"+type +'_add' +' option:selected').text();
     		
     		
     		
     		var equipments_id = $( "#equipments_id").val();
     		
     		var MM_update = "add_indicators";
     		
     		var dataString =  'equipments_id='+ equipments_id +'&name_cn='+ name_cn +'&name_en='+ name_en +'&type='+ type +'&channel='+ channel +'&unit='+ unit +'&indicator_display_style_id='+ indicator_display_style_id +'&MM_update='+ MM_update ;	
     		 
     		/*
     		$('#text_type'+id).text(type);
			$('#text_name_cn'+id).text(empty_check(name_cn));
			$('#text_name_en'+id).text(empty_check(name_en));
			$('#text_unit'+id).text(empty_check(unit));
			$('#text_channel'+id).text(channel);
			$('#text_indicator_display_style_id'+id ).text(indicator_display_style_id_text); 
		 	*/
			
			//alert(dataString+"/");
		 	
			$.ajax({
				type: "POST",
				url: "edit_data.php",
				data: dataString,
				cache: false,
				success: function(text)
				{
					text = $.trim(text);
			 
					if (text == "ok"){
						//alert(id);
						alert("新增成功");		 
     				 
						location.reload();
					}else{
						alert("錯誤\n \n /"+text+"/");
						 
					}
					 
				}
			});
			
		 	 
		});
		
		$('.edit').click(function(){
			var id= $(this).attr('id');
     		id =  id.slice(4);
     		$('#save'+id).show();
			$('#cancel'+id).show();
			$(this).hide();
			
			$('#type'+id).show();
			$('#name_cn'+id).show();
			$('#name_en'+id).show();
			$('#unit'+id).show();
			$('#channel'+id).show();
			$('#select_indicator_display_style_id'+id).show();
			
			$('#text_type'+id).hide();
			$('#text_name_cn'+id).hide();
			$('#text_name_en'+id).hide();
			$('#text_unit'+id).hide();
			$('#text_channel'+id).hide();
			$('#text_indicator_display_style_id'+id).hide();
			
     		//alert(id);
		});
		
		$('#add').click(function(){
			 
			$('#add_tr').fadeIn("slow");

		});
		$('#canceladd').click(function(){
			 
			$('#add_tr').fadeOut("slow");

		});
		
		 
		$('.cancel').click(function(){
			var id= $(this).attr('id');
     		id =  id.slice(6);
     		$('#save'+id).hide();
			$('#cancel'+id).hide();
			$('#edit'+id).show();
			
			$('#type'+id).hide();
			$('#name_cn'+id).hide();
			$('#name_en'+id).hide();
			$('#unit'+id).hide();
			$('#channel'+id).hide();
			$('#select_indicator_display_style_id'+id).hide();
			
			$('#text_type'+id).show();
			$('#text_name_cn'+id).show();
			$('#text_name_en'+id).show();
			$('#text_unit'+id).show();
			$('#text_channel'+id).show();
			$('#text_indicator_display_style_id'+id).show();
			
     		//alert(id);
		});
		
		$( ".type_item" ).change(function() {
     		var id= $(this).attr('id');
     		id =  id.slice(4);
     		//alert(id);
     		var value= $(this).val();
     		var ids_val = $( "#ids_val"+id ).text();
     		var i_val = $( "#indicator_display_style_id_"+value+id ).val();
     		//alert(i_val);
     		if (value == 'IP'){
     			$( "#indicator_display_style_id_CH"+id ).hide();
     			$( "#indicator_display_style_id_IP"+id ).show();
     			
     		}else if (value == 'CH'){
     			$( "#indicator_display_style_id_IP"+id ).hide();
     			$( "#indicator_display_style_id_CH"+id ).show();
     		} 
     		if (i_val != ids_val){
     			$( "#tdindicator"+id ).css( "background-color", "yellow" );
     		}else{
     			$( "#tdindicator"+id ).css( "background-color", "white" );
     		}
     		//alert();
     		get_photo(i_val, id);
     		
     		//alert(photo_file);
     		
     		
		});
		
		$( ".ids" ).change(function() {
     		var id= $(this).attr('id');
     		id =  id.slice(29);
     		//alert(id);
     		var value= $('#type'+id).val(); 
     		//alert(value);
     		var i_val = $( this ).val();
     		 //alert(i_val);
     		//alert();
     		get_photo(i_val, id);
     		
     		//alert(photo_file);
     		
     		
		});
		
		//确认删除
		$('.del').click(function(){
		 
			var poid= $(this).attr('id');
			poid = poid.slice(3);
			var name_en = $( "#name_en"+poid ).val();
			var pn= $('#selpn'+poid).val();
			//alert(poid);
			$('#overlay').fadeIn('fast',function(){
				$('#msg').text(name_en);
				$('#delmsg').show();
				//$('#delpopn').val(pn);
				$('#del_id').val(poid);

			});
		});
		//删除信息視窗關閉
		$('#dcloses').click(function(){
			$('#delmsg').hide();
			$('#overlay').fadeOut('fast');
		});
		//确认删除
		$('#delcomfig').click(function(){
			var pn = $('#delpopn').val();
			var id = $('#del_id').val();
			var MM_del = "del_indicators";
     		
     		var dataString =  'id='+ id +'&MM_del='+ MM_del ;	
			//alert(dataString+"/");
		 
			$.ajax({
				type: "POST",
				url: "edit_data.php",
				data: dataString,
				cache: false,
				success: function(text)
				{
					text = $.trim(text);
					
					if (text == "ok"){
						$('#delmsg').hide();
						$('#overlay').fadeOut('fast');
						$('#tr'+id).fadeOut("slow");
						//alert("保存成功");
						
						//location.reload();
					}else{
						alert("錯誤\n \n /"+text+"/");
						 
					}
					 
				}
			});
		 
		});
		 
 	});
	
	</script>