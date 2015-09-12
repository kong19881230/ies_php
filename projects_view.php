 <?php if (!defined('EL_ADMIN')) exit('No direct script access allowed'); date_default_timezone_set("Asia/Hong_Kong"); ?>
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
						<h1><?php echo $projects_list[0]['name_cn']; ?> ／ <?php echo $projects_list[0]['name_en']; ?></h1>
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
							<a href="#"><?php echo $projects_list[0]['name_cn']; ?> ／ <?php echo $projects_list[0]['name_en']; ?></a>
							
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
							<form action="#" method="POST" class='form-horizontal form-bordered'>
							<div class="box-title">
								<h3>
									<i class="fa fa-th-list"></i>基本資料</h3>
								<div style="float:right; padding-right:10px;"><a class="btn btn-primary" style="width:100px;"  href='?page=projects_edit&id=<?php echo $projects_list[0]['id']; ?>' >Edit</a></div>
							</div>
							<div class="box-content nopadding">
								
									<div class="form-group">
										<label for="textarea" class="control-label col-sm-2">圖片</label>
										<div class="col-sm-10">
											<a href="photo/project/<?php echo $projects_list[0]['photo']; ?>" class="colorbox-image cboxElement" rel="group-1">
												<img src="photo/project/<?php echo $projects_list[0]['photo']; ?>" height="100px" >
											</a>
												
										</div>
									</div>
									<div class="form-group">
										<label for="textfield" class="control-label col-sm-2">項目編號</label>
										<div class="col-sm-10">
											<span class="form-control"  style='border:0px;'><?php echo chkempty($projects_list[0]['seq']); ?></span>

										</div>
									</div>
									<div class="form-group">
										<label for="textfield" class="control-label col-sm-2">合約開始日期</label>
										<div class="col-sm-10">
											<span class="form-control"  style='border:0px;'><?php echo chkempty($projects_list[0]['con_start_date']); ?></span>
										</div>
									</div>
									<div class="form-group">
										<label for="textfield" class="control-label col-sm-2">合約結束日期</label>
										<div class="col-sm-10">
											<span class="form-control"  style='border:0px;'><?php echo chkempty($projects_list[0]['con_espr_date']); ?></span>
											
										</div>
									</div>
									<div class="form-group">
										<label for="textfield" class="control-label col-sm-2">合約期數</label>
										<div class="col-sm-10">
											<span class="form-control"  style='border:0px;'><?php echo chkempty($projects_list[0]['con_count']); ?></span>
											
										</div>
									</div>
									<div class="form-group">
										<label for="textfield" class="control-label col-sm-2">保養內容</label>
										<div class="col-sm-10">
											<span class="form-control"  style='border:0px;'><?php echo chkempty($projects_list[0]['maintain_type']); ?></span>
										</div>
									</div>
									<div class="form-group">
										<label for="text" class="control-label col-sm-2">報告形式</label>
										<div class="col-sm-10">
											<span class="form-control"  style='border:0px;'><?php echo chkempty($projects_list[0]['report_style']); ?></span>
										</div>
									</div>
									<div class="form-group">
										<label for="text" class="control-label col-sm-2">設備位置</label>
										<div class="col-sm-10">
											<span class="form-control"  style='border:0px;'><?php echo chkempty($projects_list[0]['device_position']); ?></span>
										</div>
									</div>
									<div class="form-group">
										<label for="text" class="control-label col-sm-2">聯絡人</label>
										<div class="col-sm-10">
											<span class="form-control"  style='border:0px;'><?php echo chkempty($projects_list[0]['contact_person']); ?></span>
										</div>
									</div>
									<div class="form-group">
										<label for="text" class="control-label col-sm-2">聯絡電話</label>
										<div class="col-sm-10">
											<span class="form-control"  style='border:0px;'><?php echo chkempty($projects_list[0]['contact_phone']); ?></span>	
										</div>
									</div>
									 
									<div class="form-group" >
										<label for="text" class="control-label col-sm-2">創建日期</label>
										<div class="col-sm-10">
											<span class="form-control"  style='border:0px;'><?php echo chkempty($projects_list[0]['created_at']); ?></span>
										</div>
									</div>
									<div class="form-group" >
										<label for="text" class="control-label col-sm-2">最後修改日期</label>
										<div class="col-sm-10">
											<span class="form-control"  style='border:0px;'><?php echo chkempty($projects_list[0]['updated_at']); ?></span>
										</div>
									</div>
									 <div class="form-group">
										<label for="text" class="control-label col-sm-2">地區</label>
										<div class="col-sm-10">
											<span class="form-control"  style='border:0px;'><?php if ($projects_list[0]['region']=='mo'){ echo 'Macau'; }elseif($projects_list[0]['region']=='hk'){ echo 'Hong Kong'; }  ?></span>
											 
										</div>
									</div>
									 
									 
									<div class="form-group">
										<label for="textarea" class="control-label col-sm-2">註備</label>
										<div class="col-sm-10">
											<span class="form-control"  style='border:0px;'><?php echo chkempty($projects_list[0]['remark']); ?></span>
											 
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
											<?php $result = json_decode($projects_list[0]['cycle_types'],true); $icon = '<i class="fa fa-square-o"></i>　'; ?>
											<?php 
												foreach ($reports_cycles_cn as $key => $value){ 
													for ($i=0; $i<count($result); $i++){
														if ($result["$i"] == $key) {
															$icon = '<i class="fa fa-check-square-o"></i>　';
															break;
														}else{
															$icon = '<i class="fa fa-square-o"></i>　';
														}
													}
											?>
											
											<div class="check-demo-col">
												<div class="check-line">
													<span class="form-control"  style='border:0px;'><?php echo $icon.$value; ?></span>
												</div>	 
											</div>
											<?php  } ?>
										</div>
									</div>
									<div class="form-group">
										<label for="textfield" class="control-label col-sm-2">設備種類</label>
										<div class="col-sm-10">
											<?php $result = json_decode($projects_list[0]['machine_types'],true); $icon = '<i class="fa fa-square-o"></i>　'; ?>
											<?php 
												foreach ($from_type as $key => $value){ 
													for ($i=0; $i<count($result); $i++){
														if ($result["$i"] == $key) {
															$icon = '<i class="fa fa-check-square-o"></i>　';
															break;
														}else{
															$icon = '<i class="fa fa-square-o"></i>　';
														}
													}	
											?>
											<div class="check-demo-col">
												<div class="check-line">
													<span class="form-control"  style='border:0px;'><?php echo $icon.$value; ?></span>
												</div>	 
											</div>
											<?php } ?>
											 
										</div>
									</div>
									 
									 <div class="form-actions col-sm-offset-2 col-sm-10">
										<a class="btn btn-primary" style="width:100px;"  href='?page=projects_edit&id=<?php echo $projects_list[0]['id']; ?>' >Edit</a>
										<a type="button" class="btn" href='?page=projects'  style="width:100px;" >Back</a>
									</div>
							</div>
							<div class="box-title"  style="display:none;">
								<h3>
									<i class="fa fa-th-list"></i>GSM 程式的設定</h3>	
							</div>
							<div class="box-content nopadding" style="display:none;">
								
									<div class="form-group">
										<label for="textfield" class="control-label col-sm-2">預設語言</label>
										<div class="col-sm-10">
											<span class="form-control"  style='border:0px;'><?php if ($projects_list[0]['default_lang']=='en'){ echo 'English'; }elseif($projects_list[0]['default_lang']=='cn'){ echo '中文'; } ?></span>

										</div>
									</div>
									
 							</div>
							</form>
						</div>
					</div>
				</div>
				 
			</div>
		</div>
	</div>