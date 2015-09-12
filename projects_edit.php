<?php if (!defined('EL_ADMIN')) exit('No direct script access allowed'); ?>
 <?php date_default_timezone_set("Asia/Hong_Kong");
 if(isset($_SESSION["key"], $_POST["key"]) && $_SESSION["key"] == $finalkey){
 	//echo 'xx'.$finalkey;$_SESSION["key"] = md5(uniqid().mt_rand());
		date_default_timezone_set("Asia/Hong_Kong");
		//echo  '　　　　　　　　　　　　　　　　　　　　　　　　　　　　';
		//print_r($_POST['cycle_types']); 
		$finalcycle_types = json_encode($_POST['cycle_types']);
		$finalmachine_types = json_encode($_POST['machine_types']);
		//print_r($finalcycle_types);
		
		$ud_projects = Sdba::table('projects');
		$ud_projects ->where('id', $_GET['id']);
		
		$ud_projects_list = $ud_projects->get();
		
		if (($_FILES["photo"]["type"] == "image/gif")
  				|| ($_FILES["photo"]["type"] == "image/jpeg")
				|| ($_FILES["photo"]["type"] == "image/pjpeg")
				|| ($_FILES["photo"]["type"] == "image/jpg")
  				|| ($_FILES["photo"]["type"] == "image/png" )
  				&& ($_FILES["photo"]["size"] < 800000))
   			 	{
  			$photoname = 'project'.date('Y-m-d-H-i-s').'.jpg';
			move_uploaded_file($_FILES["photo"]["tmp_name"],"photo/project/".$_FILES["photo"]["name"]);
			squarenailByGd("photo/project/" , $_FILES["photo"]["name"],580, 280,$photoname);
		}else{
			$photoname = $ud_projects_list[0]['photo'];
		}
		
		if ($_FILES["photo"]["name"]==''){
			//echo '　　　　　　　　　　　　　　　　　xxxxx'.$ud_equipments_list[0]['photo'];
			$photoname = $ud_projects_list[0]['photo'];
		}
		
		
		$data = array(
			'seq'=> $finalseq,
			'con_espr_date'=>date('Y-m-d', strtotime($finalcon_espr_date)),
			'con_start_date'=> date('Y-m-d', strtotime($finalcon_start_date)),
			'con_count'=> $finalcon_count,
			'maintain_type'=> $finalmaintain_type,
			'report_style'=> $finalreport_style,
			'device_position'=> $finaldevice_position,
			'contact_person'=> $finalcontact_person,
			'contact_phone'=> $finalcontact_phone,
			'region'=> $finalregion,
			'remark'=> $finalremark,
			'updated_at'=> date('Y-m-d H:i:s'),
			'cycle_types'=> $finalcycle_types,
			'machine_types'=>$finalmachine_types,
			'default_lang'=>$finaldefault_lang,
			'photo'=> $photoname
		);
		 
		$ud_projects ->update($data);
		unset($_SESSION["key"]);
		$_SESSION["key"] = md5(uniqid().mt_rand());				
		?>
<script>
window.location = './?page=projects';
</script>
		<?php								 
 }else{
 	$_SESSION["key"] = md5(uniqid().mt_rand());		
 }
 ?>
 		<div id="main">
			<div class="container-fluid">
				<?php  
  					$projects = Sdba::table('projects');
  					$projects->where('id',$_GET['id']);
  					$total_projects = $projects->total();
  					$projects_list = $projects->get();
  					//echo $total_rows;
  					//print_r($reportlist);
  				?>
				<div class="page-header">
					<div class="pull-left">
						<h1><?php echo $projects_list[0]['name_cn']; ?> ／ <?php echo $projects_list[0]['name_en']; ?> </h1>
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
							<a href="?page=projects_view&id=<?php echo $projects_list[0]['id']; ?>"><?php echo $projects_list[0]['name_cn']; ?> ／ <?php echo $projects_list[0]['name_en']; ?></a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="#">Edit</a>
							 
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
						<form action="?page=projects_edit&id=<?php echo $projects_list[0]['id']; ?>" method="POST" enctype="multipart/form-data" class='form-horizontal form-bordered'>
						<div class="box box-bordered">
							<div class="box-title">
								<h3>
									<i class="fa fa-th-list"></i>基本資料</h3>
							</div>
							<div class="box-content nopadding">
									<div class="form-group">
										<label for="textarea" class="control-label col-sm-2">圖片</label>
										<div class="col-sm-10">
											<div class="fileinput fileinput-new" data-provides="fileinput">
												<div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 160px; height: 120px;">
													<img src="photo/project/<?php echo $projects_list[0]['photo']; ?>" >
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
								
									<div class="form-group">
										<label for="textfield" class="control-label col-sm-2">項目編號</label>
										<div class="col-sm-10">
											<input type="text" name="seq" id="textfield" placeholder="<?php echo chkempty($projects_list[0]['seq']); ?>" class="form-control" value='<?php echo  $projects_list[0]['seq']; ?>'>

										</div>
									</div>
									<div class="form-group">
										<label for="textfield" class="control-label col-sm-2">合約開始日期</label>
										<div class="col-sm-10">
											<input type="text" name="con_start_date" id="textfield" placeholder="YYYY-MM-DD" class="form-control " value='<?php echo  date('Y-m-d', strtotime($projects_list[0]['con_start_date'])); ?>'>
										</div>
									</div>
									<div class="form-group">
										<label for="textfield" class="control-label col-sm-2">合約結束日期</label>
										<div class="col-sm-10">
											<input type="text" name="con_espr_date" id="textfield" placeholder="YYYY-MM-DD" class="form-control " value='<?php echo  date('Y-m-d', strtotime($projects_list[0]['con_espr_date'])); ?>'>
										</div>
									</div>
									<div class="form-group">
										<label for="textfield" class="control-label col-sm-2">合約期數</label>
										<div class="col-sm-10">
											<input type="text" name="con_count" id="textfield" placeholder="<?php echo chkempty($projects_list[0]['con_count']); ?>" class="form-control" value='<?php echo $projects_list[0]['con_count']; ?>'>
										</div>
									</div>
									<div class="form-group">
										<label for="textfield" class="control-label col-sm-2">保養內容</label>
										<div class="col-sm-10">
											<input type="text" name="maintain_type" id="textfield" placeholder="<?php echo chkempty($projects_list[0]['maintain_type']); ?>" class="form-control" value='<?php echo $projects_list[0]['maintain_type']; ?>'>
										</div>
									</div>
									<div class="form-group">
										<label for="text" class="control-label col-sm-2">報告形式</label>
										<div class="col-sm-10">
											<input type="text" name="report_style" id="text" placeholder="<?php echo chkempty($projects_list[0]['report_style']); ?>" class="form-control" value='<?php echo $projects_list[0]['report_style']; ?>'>
										</div>
									</div>
									<div class="form-group">
										<label for="text" class="control-label col-sm-2">設備位置</label>
										<div class="col-sm-10">
											<input type="text" name="device_position" id="text" placeholder="<?php echo chkempty($projects_list[0]['device_position']); ?>" class="form-control" value='<?php echo $projects_list[0]['device_position']; ?>'>
										</div>
									</div>
									<div class="form-group">
										<label for="text" class="control-label col-sm-2">聯絡人</label>
										<div class="col-sm-10">
											<input type="text" name="contact_person" id="text" placeholder="<?php echo chkempty($projects_list[0]['contact_person']); ?>" class="form-control" value='<?php echo $projects_list[0]['contact_person']; ?>'>
										</div>
									</div>
									<div class="form-group">
										<label for="text" class="control-label col-sm-2">聯絡電話</label>
										<div class="col-sm-10">
											<input type="text" name="contact_phone" id="text" placeholder="<?php echo chkempty($projects_list[0]['contact_phone']); ?>" class="form-control" value='<?php echo $projects_list[0]['contact_phone']; ?>'>
										</div>
									</div>
									 
									<div class="form-group" style="display:none;">
										<label for="text" class="control-label col-sm-2">created_at</label>
										<div class="col-sm-10">
											<input type="text" name="created_at" id="text" placeholder="<?php echo chkempty($projects_list[0]['created_at']); ?>" class="form-control" value='<?php echo $projects_list[0]['created_at']; ?>'>
										</div>
									</div>
									<div class="form-group" style="display:none;">
										<label for="text" class="control-label col-sm-2">updated_at</label>
										<div class="col-sm-10">
											<input type="text" name="updated_at" id="text" placeholder="<?php echo chkempty($projects_list[0]['updated_at']); ?>" class="form-control" value='<?php echo $projects_list[0]['updated_at']; ?>'>
										</div>
									</div>
							 		 <div class="form-group">
										<label for="text" class="control-label col-sm-2">地區</label>
										<div class="col-sm-10">
											<select name="region" id="region" class='select2-me' style="width:100%">
												<option value="mo" <?php if ($projects_list[0]['region'] == 'mo'){ echo 'selected'; } ?> >Macau</option>
												<option value="hk" <?php if ($projects_list[0]['region'] == 'hk'){ echo 'selected'; } ?> >Hong Kong</option> 
											</select>
										</div>
									</div>
									 
									<div class="form-group">
										<label for="textarea" class="control-label col-sm-2">註備</label>
										<div class="col-sm-10">
											<textarea name="remark" id="textarea" rows="5" class="form-control" placeholder="<?php echo chkempty($projects_list[0]['remark']); ?>"><?php echo $projects_list[0]['remark']; ?></textarea>
										</div>
									</div>
									 
								 
							</div>
							<div class="box-title">
								<h3>
									<i class="fa fa-th-list"></i>報告的設定</h3>
							</div>
							<div class="box-content nopadding">
							 
									<div class="form-group">
										<label for="textfield" class="control-label col-sm-2">保養期</label>
										<div class="col-sm-10">
											<?php $result = json_decode($projects_list[0]['cycle_types'],true); $checked=''; ?>
											<?php 
												foreach ($reports_cycles_cn as $key => $value){ 
													for ($i=0; $i<count($result); $i++){
														if ($result["$i"] == $key) {
															$checked = 'checked';
															break;
														}else{
															$checked = '';
														}
													}
											?>
											 
											<div class="check-demo-col">
												<div class="check-line">
													<input type="checkbox" class='icheck-me ' <?php echo $checked; ?>  data-skin="minimal" value='<?php echo $key; ?>' name='cycle_types[]'>
													<label class='inline' for="c<?php echo $key; ?>"><?php echo $value; ?></label>
												</div>	 
											</div>
											<?php } ?>
										</div>
									</div>
									<div class="form-group">
										<label for="textfield" class="control-label col-sm-2">設備種類</label>
										<div class="col-sm-10">
											<?php $result = json_decode($projects_list[0]['machine_types'],true);  $checked='';  ?>
											<?php 
												foreach ($from_type as $key => $value){ 
													for ($i=0; $i<count($result); $i++){
														if ($result["$i"] == $key) {
															$checked = 'checked';
															break;
														}else{
															$checked = '';
														}
													}	
											?>
											<div class="check-demo-col">
												<div class="check-line">
													<input type="checkbox" class='icheck-me' <?php echo $checked; ?>  data-skin="minimal" value='<?php echo $key; ?>' name='machine_types[]'>
													<label class='inline' for="m<?php echo $key; ?>"><?php echo $value; ?></label>
												</div>	 
											</div>
											<?php } ?>
											 
										</div>
										
										
									</div>
									 <div class="form-actions col-sm-offset-2 col-sm-10">
											<input type="hidden" name="key" value="<?php echo htmlspecialchars($_SESSION["key"], ENT_QUOTES);?>">
											<button type="submit" class="btn btn-primary">Save changes</button>
											<a type="button" class="btn" href="?page=projects">Cancel</a>
										</div>
									 
								 
							</div>
							<div class="box-title" style="display:none;">
								<h3>
									<i class="fa fa-th-list"></i>GSM 程式的設定</h3>
							</div>
							<div class="box-content nopadding" style="display:none;">
							 		<div class="form-group">
										<label for="textfield" class="control-label col-sm-2">預設語言</label>
										<div class="col-sm-10">
											 
											<select name="default_lang" id="default_lang" class='select2-me' style="width:100%">
												<option value="en" <?php if ($projects_list[0]['default_lang'] == 'en'){ echo 'selected'; } ?> >English</option>
												<option value="cn" <?php if ($projects_list[0]['default_lang'] == 'cn'){ echo 'selected'; } ?> >中文</option> 
											</select>

										</div>
									</div>
									
								 
							</div>
						</div>
						</from>
					</div>
				</div>
				 
			</div>
		</div>
	</div>