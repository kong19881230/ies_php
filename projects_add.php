 <?php if (!defined('EL_ADMIN')) exit('No direct script access allowed'); ?>
 <?php date_default_timezone_set("Asia/Hong_Kong");
 if(isset($_SESSION["key"], $_POST["key"]) && $_SESSION["key"] == $finalkey){
 	//echo 'xx'.$finalkey;$_SESSION["key"] = md5(uniqid().mt_rand());
		
		//echo  '　　　　　　　　　　　　　　　　　　　　　　　　　　　　';
		//print_r($_POST['cycle_types']); 
		$finalcycle_types = json_encode($_POST['cycle_types']);
		$finalmachine_types = json_encode($_POST['machine_types']);
		//print_r($finalcycle_types);
		$error_msg = '';
		if (empty($finalname_cn)){
			$error_msg = '請輸入項目名稱(中文)';
		}elseif (empty($finalname_en)){
			$error_msg = '請輸入項目名稱(英文)';
		}elseif (empty($finalseq)){
			$error_msg = '請輸入項目編號';
		}elseif (empty($finalcon_espr_date)){
			$error_msg = '請輸入結束的合約期';
		}elseif (empty($finalcon_start_date)){
			$error_msg = '請輸入開始的合約期';
		}elseif (empty($finalmaintain_type)){
			$error_msg = '請輸入保養內容';
		}elseif (empty($finalreport_style)){
			$error_msg = '請輸入報告形式';
		}elseif (empty($finaldevice_position)){
			$error_msg = '請輸入設備位置';
		}elseif (empty($finalcontact_person)){
			$error_msg = '請輸入聯絡人';
		}elseif (empty($finalcontact_phone)){
			$error_msg = '請輸入聯絡電話';
		}else{
		
		date_default_timezone_set("Asia/Hong_Kong");
		$ud_projects = Sdba::table('projects');
		//$ud_projects ->where('id', $_GET['id']);
		
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
			$photoname = '';
		}
		
		$data = array(
			'name_en'=> $finalname_en,
			'name_cn'=> $finalname_cn,
			'seq'=> $finalseq,
			'con_espr_date'=>date('Y-m-d', strtotime( $finalcon_espr_date)),
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
		$ud_projects ->insert($data);
		unset($_SESSION["key"]);
		$_SESSION["key"] = md5(uniqid().mt_rand());
		?>
<script>
window.location = './?page=projects';
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
						<h1>新增酒店 </h1>
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
							<a href="#">Add</a>
							 
						</li>
						 
					</ul>
					<div class="close-bread">
						<a href="#">
							<i class="fa fa-times"></i>
						</a>
					</div>
				</div>
				<br>
				<?php if ($error_msg !=''){ ?>
 				<div class="alert alert-danger alert-dismissable" style="margin-bottom: 0px;">
					<button type="button" class="close" data-dismiss="alert">×</button>
					<strong>請注意! </strong><?php echo $error_msg; ?>
				 
				</div>
				<?php } ?>
				<div class="row">
					<div class="col-sm-12">
						<div class="box box-bordered">
						<form action="?page=projects_add" method="POST" enctype="multipart/form-data" class='form-horizontal form-bordered'>
							<div class="box-title">
								<h3>
									<i class="fa fa-th-list"></i>新增項目基本資料
								</h3>
							</div>
							<div class="box-content nopadding">
									<div class="form-group">
										<label for="text" class="control-label col-sm-2">圖片</label>
										 
										<div class="form-group">
										<label for="textfield" class="control-label col-sm-2"></label>
										<div class="col-sm-10">
											<div class="fileinput fileinput-new" data-provides="fileinput">
												<div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 160px; height: 120px;"></div>
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
										<label for="textfield" class="control-label col-sm-2">項目名稱(英文)</label>
										<div class="col-sm-10">
											<input type="text" name="name_en" id="textfield" placeholder=" " class="form-control" value='<?php echo $finalname_en; ?>'>

										</div>
									</div>
									<div class="form-group">
										<label for="textfield" class="control-label col-sm-2">項目名稱(中文)</label>
										<div class="col-sm-10">
											<input type="text" name="name_cn" id="textfield" placeholder=" " class="form-control" value='<?php echo $finalname_cn; ?>'>

										</div>
									</div>
									<div class="form-group">
										<label for="textfield" class="control-label col-sm-2">項目編號</label>
										<div class="col-sm-10">
											<input type="text" name="seq" id="textfield" placeholder=" " class="form-control" value='<?php echo $finalseq; ?>'>

										</div>
									</div>
									<div class="form-group">
										<label for="textfield" class="control-label col-sm-2">合約開始日期</label>
										<div class="col-sm-10">
											<input type="text" name="con_start_date" id="textfield" placeholder="YYYY-MM-DD" class="form-control " value='<?php echo $finalcon_start_date; ?>'>
										</div>
									</div>
									<div class="form-group">
										<label for="textfield" class="control-label col-sm-2">合約結束日期</label>
										<div class="col-sm-10">
											<input type="text" name="con_espr_date" id="textfield" placeholder="YYYY-MM-DD" class="form-control " value='<?php echo $finalcon_espr_date; ?>'>
										</div>
									</div>
									<div class="form-group">
										<label for="textfield" class="control-label col-sm-2">合約期數</label>
										<div class="col-sm-10">
											<input type="text" name="con_count" id="textfield" placeholder="" class="form-control" value='<?php echo $finalcon_count; ?>'>
										</div>
									</div>
									<div class="form-group">
										<label for="textfield" class="control-label col-sm-2">保養內容</label>
										<div class="col-sm-10">
											<input type="text" name="maintain_type" id="textfield" placeholder=" " class="form-control" value='<?php echo $finalmaintain_type; ?>'>
										</div>
									</div>
									<div class="form-group">
										<label for="text" class="control-label col-sm-2">報告形式</label>
										<div class="col-sm-10">
											<input type="text" name="report_style" id="text" placeholder=" " class="form-control" value='<?php echo $finalreport_style; ?>'>
										</div>
									</div>
									<div class="form-group">
										<label for="text" class="control-label col-sm-2">設備位置</label>
										<div class="col-sm-10">
											<input type="text" name="device_position" id="text" placeholder=" " class="form-control" value='<?php echo $finaldevice_position; ?>'>
										</div>
									</div>
									<div class="form-group">
										<label for="text" class="control-label col-sm-2">聯絡人</label>
										<div class="col-sm-10">
											<input type="text" name="contact_person" id="text" placeholder=" " class="form-control" value='<?php echo $finalcontact_person; ?>'>
										</div>
									</div>
									<div class="form-group">
										<label for="text" class="control-label col-sm-2">聯絡電話</label>
										<div class="col-sm-10">
											<input type="text" name="contact_phone" id="text" placeholder=" " class="form-control" value='<?php echo $finalcontact_phone; ?>'>
										</div>
									</div>
									 
									<div class="form-group" style="display:none;"> 
										<label for="text" class="control-label col-sm-2">created_at</label>
										<div class="col-sm-10">
											<input type="text" name="created_at" id="text" placeholder="<?php echo chkempty($projects_list[0]['created_at']); ?>" class="form-control" value=''>
										</div>
									</div>
									<div class="form-group" style="display:none;">
										<label for="text" class="control-label col-sm-2">updated_at</label>
										<div class="col-sm-10">
											<input type="text" name="updated_at" id="text" placeholder="<?php echo chkempty($projects_list[0]['updated_at']); ?>" class="form-control" value=''>
										</div>
									</div>
									 <div class="form-group">
										<label for="text" class="control-label col-sm-2">地區</label>
										<div class="col-sm-10">
											<select name="region" id="region" class='select2-me' style="width:100%">
												<option value="mo" <?php if ($finaldefault_lang == 'mo'){ echo 'selected'; } ?> >Macau</option>
												<option value="hk" <?php if ($finaldefault_lang == 'hk'){ echo 'selected'; } ?> >Hong Kong</option> 
											</select>
										</div>
									</div>
									 
									<div class="form-group">
										<label for="textarea" class="control-label col-sm-2">註備</label>
										<div class="col-sm-10">
											<textarea name="remark" id="textarea" rows="5" class="form-control" placeholder="自由填寫"><?php echo $finalremark; ?></textarea>
										</div>
									</div>
									
									
								
							</div>
						</div>
							<div class="box-title">
								<h3>
									<i class="fa fa-th-list"></i>報告的設定
								</h3>
							</div>
							<div class="box-content nopadding">
								
									<div class="form-group">
										<label for="textfield" class="control-label col-sm-2">保養期</label>
										<div class="col-sm-10">
											<?php $result = $_POST['cycle_types'];  $checked='';  ?>
											
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
													<input type="checkbox" class='icheck-me '   data-skin="minimal" value='<?php echo $key; ?>' name='cycle_types[]' <?php echo $checked; ?>>
													<label class='inline' for="c<?php echo $key; ?>"><?php echo $value; ?></label>
												</div>	 
											</div>
											<?php } ?>
										</div>
									</div>
									<div class="form-group">
										<label for="textfield" class="control-label col-sm-2">設備種類</label>
										<div class="col-sm-10">
											 
											<?php $result = $_POST['machine_types'];  $checked='';  ?>
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
													<input type="checkbox" class='icheck-me'  data-skin="minimal" value='<?php echo $key; ?>' name='machine_types[]' <?php echo $checked; ?>>
													<label class='inline' for="m<?php echo $key; ?>"><?php echo $value; ?></label>
												</div>	 
											</div>
											<?php } ?>
											 
										</div>
									</div>
									 <div class="form-actions col-sm-offset-2 col-sm-10">
										<input type="hidden" name="key" value="<?php echo htmlspecialchars($_SESSION["key"], ENT_QUOTES);?>">
										<button type="submit" class="btn btn-primary" style="width:100px;">新增</button>
										<a type="button" class="btn" href="?page=projects" style="width:100px;">Cancel</a>
									</div>
									 
							</div>
						
							<div class="box-title" style="display:none;">
								<h3>
									<i class="fa fa-th-list"></i>GSM 程式的設定
								</h3>
							</div>
							<div class="box-content nopadding" style="display:none;">
								
									 
									<div class="form-group">
										<label for="textfield" class="control-label col-sm-2">預設語言</label>
										<div class="col-sm-10">
											 
											<select name="default_lang" id="default_lang" class='select2-me' style="width:100%">
												<option value="en" <?php if ($finaldefault_lang == 'en'){ echo 'selected'; } ?> >English</option>
												<option value="cn" <?php if ($finaldefault_lang == 'cn'){ echo 'selected'; } ?> >中文</option> 
											</select>

										</div>
									</div>
									
								
							</div>
						</div>
						</form>
					</div>
				</div>
				 
			</div>
		</div>
	</div>