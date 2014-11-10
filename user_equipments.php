<?php if (!defined('EL_ADMIN')) exit('No direct script access allowed'); ?>
 <?php 
 if(isset($_SESSION["key"], $_POST["key"]) && $_SESSION["key"] == $finalkey){
 	date_default_timezone_set("Asia/Hong_Kong");
		
		 
		
		$equipmentid =  $_POST['equipmentid'];
		//echo '<pre>';
		//print_r($equipmentid);
		//echo '</pre>';
		
		$user_equipments = Sdba::table('user_equipments');
  		$user_equipments->where('user_id',$_GET['id']);
  		$user_equipments->delete();
  		
  		for ($k=0; $k < count($equipmentid); $k++){
  			$data = array(
				'user_id'=> $_GET['id'],
				'equipment_id'=> $equipmentid[$k] 
			);
			$user_equipments ->insert($data);
  		}
		
		
		
		
		unset($_SESSION["key"]);
		$_SESSION["key"] = md5(uniqid().mt_rand());				
		?>
<script>
window.location = './?page=user';
</script>
<?php	 }	   ?>
 		<div id="main">
			<div class="container-fluid">
				<div class="page-header">
					<?php  
  					$users = Sdba::table('users');
  					$users->where('id',$_GET['id']);
  					$total_users = $users->total();
  					$users_list = $users->get();
  					//echo $total_rows;
  					//print_r($reportlist);
  				?>
					<div class="pull-left">
						<h1>管理使用者設備（<?php echo $users_list[0]['name']; ?>） </h1>
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
							<a href="?page=user">User</a>
							<i class="fa fa-angle-right"></i>
						</li>
						
						<li>
							<a href="#">管理使用者設備（<?php echo $users_list[0]['name']; ?>）</a>
							 
						</li>
					</ul>
					<div class="close-bread">
						<a href="#">
							<i class="fa fa-times"></i>
						</a>
					</div>
				</div>
 				 <form action="?page=user_equipments&id=<?php echo $users_list[0]['id']; ?>" method="POST" enctype="multipart/form-data" class='form-horizontal form-bordered'>
				<div class="row">
					
					<div class="col-sm-12">
						<div class="box box-bordered">
							<?php  
  					$project_users = Sdba::table('project_users');
  					$project_users->where('user_id',$_GET['id']);
  					$total_project_users = $project_users->total();
  					$project_users_list = $project_users->get();
  					 
  					for($a=0; $a<$total_project_users; $a++) {
  					
  					$projects = Sdba::table('projects');
  					$projects->where('id',$project_users_list[$a]['project_id']);
  					$total_projects = $projects->total();
  					$projects_list = $projects->get();
  					?>
							<div class="box-title">
								<h3>
									<i class="fa fa-th-list"></i>  <?php echo $projects_list[0]['name_en']; ?> </h3>
							</div>
							<div class="box-content nopadding">
							
								
									<?php 
										$equipments = Sdba::table('equipments');
  										$equipments->where('project_id',$projects_list[0]['id']);
  										$total_equipments = $equipments->total();
  										$equipments_list = $equipments->get();
  										
  										//print_r($equipments_list);
									?>
									 
									 
									
									<div class="form-group">
										<label for="text" class="control-label col-sm-2">equipments</label>
										<div class="col-sm-10">
											 <?php  
  												$equipments = Sdba::table('equipments');
  												$equipments->where('project_id',$projects_list[0]['id']);
  												$total_equipments = $equipments->total();
  												$equipments_list = $equipments->get();
  												//echo $total_rows;
  												//print_r($reportlist);
  												
  												$user_equipments = Sdba::table('user_equipments');
  												$user_equipments->where('user_id',$_GET['id']);
  												$total_user_equipments = $user_equipments->total();
  												$user_equipments_list = $user_equipments->get();
  											?>
											<?php 
												for ($i=0; $i<$total_equipments; $i++){
													for ($j=0; $j<$total_user_equipments; $j++){ 	
														if ($equipments_list[$i]['id'] == $user_equipments_list[$j]['equipment_id']) {
															$checked = 'checked';
															break;
														}else{
															$checked = '';
														}
													}
											?>
											<div class="check-demo-col">
												<div class="check-line">
													<input type="checkbox" class='icheck-me ' <?php echo $checked; ?>  data-skin="minimal" value='<?php echo $equipments_list[$i]['id']; ?>' name='equipmentid[]'>
													<label class='inline' for="c<?php echo $equipments_list[$i]['id']; ?>"><?php echo $equipments_list[$i]['ref_no']; ?></label>
												</div>	 
											</div>
											<?php } ?> 
											<p><a href='?page=equipments_add&id=<?php echo $projects_list[0]['id']; ?>' target='blank' >Add equipments</a></p>
										</div>
									</div> 
									 
									<div class="form-actions col-sm-offset-2 col-sm-10" <?php if ($total_equipments==0){echo 'style="display:none;"';} ?>>
										<input type="hidden" name="key" value="<?php echo htmlspecialchars($_SESSION["key"], ENT_QUOTES);?>">
										<button type="submit" class="btn btn-primary">Save changes</button>
										<a type="button" class="btn" href="?page=user">Cancel</a>
									</div>
								
							</div>
							<?php } ?>
						</div>
					</div>
					
					
				</div>
				 </form>
			</div>
		</div>
	</div>