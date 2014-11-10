<?php if (!defined('EL_ADMIN')) exit('No direct script access allowed'); ?>
 <?php 
 if(isset($_SESSION["key"], $_POST["key"]) && $_SESSION["key"] == $finalkey){
 	date_default_timezone_set("Asia/Hong_Kong");
		
		$ud_users = Sdba::table('users');
		
		$users = Sdba::table('users');
  		$users->where('username',$_POST['username']);
  		$total_users = $users->total();
  		
  		$users_mail = Sdba::table('users');
  		$users_mail->where('email',$_POST['email']);
  		$total_users_mail = $users_mail->total();
		
		if (empty($finalname)){
			$error_msg = '請輸入用戸姓名';
		}elseif (empty($_POST['username'])){
			$error_msg = '請輸入賬號名稱';
		}elseif  (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
			$error_msg = '您輸入的電郵地址不正確';
		}elseif (empty($_POST['npassword'])){
			$error_msg = '請輸入密碼';
		}elseif (empty($_POST['cpassword'])){
			$error_msg = '請再次輸入確認密碼';
		}elseif($_POST['npassword']!=$_POST['cpassword']){
			$error_msg = '您輸入的密碼與確認密碼不符';
				
			 
		}elseif ($total_users > 0) {
			$error_msg = '此賬號已存在，請輸入其他的電郵地址';
		}elseif ($total_users_mail > 0) {
			$error_msg = '此電郵已存在，請輸入其他的電郵地址';
		}else{
			$password = md5($_POST['npassword']);
		//echo $password;
		
			
  			 
  			
		
		$data = array(
			'name'=> $finalname,
			'position'=> $_POST['position'],
			'company'=> $_POST['company'],
			'phone'=> $_POST['phone'],
			'username'=> $_POST['username'],
			'current_token'=> 'F3nfMbcuTd',
			
			'email'=>$_POST['email'],
			'password'=>$password,
			'status'=> $_POST['status'],
			'role'=> $_POST['role'],
			'created_at'=> date('Y-m-d H:i:s'),
			'updated_at'=> date('Y-m-d H:i:s')
		);
		$ud_users ->insert($data);
		
		//echo $ud_users ->insert_id();
		
		$projectid =  $_POST['projectid'];
		//echo '<pre>';
		//print_r($projectid);
		//echo '</pre>';
		//Project id 
		$project_users = Sdba::table('project_users');
  		$project_users->where('user_id',$_GET['id']);
  		$project_users->delete();
  		
  		for ($k=0; $k < count($projectid); $k++){
  			$data = array(
				'user_id'=> $ud_users ->insert_id(),
				'project_id'=> $projectid[$k] 
			);
			$project_users ->insert($data);
  		}
  		
		unset($_SESSION["key"]);
		$_SESSION["key"] = md5(uniqid().mt_rand());				
		?>
<script>
window.location = './?page=user';
</script>
		<?php	}							 
 }
 ?>
 		<div id="main">
			<div class="container-fluid">
				<div class="page-header">
					<div class="pull-left">
						<h1>users </h1>
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
							<a href="?page=user">users</a>
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
									<i class="fa fa-th-list"></i> Add User</h3>
							</div>
							<div class="box-content nopadding">
							
								<form action="?page=users_add" method="POST" enctype="multipart/form-data" class='form-horizontal form-bordered'>
									<div class="form-group">
										<label for="textfield" class="control-label col-sm-2">name</label>
										<div class="col-sm-10">
											<input type="text" name="name" id="textfield" placeholder="" class="form-control" value='<?php echo $_POST['name']; ?>'>

										</div>
									</div>
									 
									
									<div class="form-group">
										<label for="textfield" class="control-label col-sm-2">position</label>
										<div class="col-sm-10">
											<input type="text" name="position" id="textfield" placeholder="" class="form-control" value='<?php echo $_POST['position']; ?>'>
										</div>
									</div>
									<div class="form-group">
										<label for="text" class="control-label col-sm-2">company</label>
										<div class="col-sm-10">
											<input type="text" name="company" id="text" placeholder="" class="form-control" value='<?php echo $_POST['company']; ?>'>
										</div>
									</div>
									<div class="form-group">
										<label for="text" class="control-label col-sm-2">phone</label>
										<div class="col-sm-10">
											<input type="text" name="phone" id="text" placeholder="" class="form-control" value='<?php echo $_POST['phone']; ?>'>
										</div>
									</div>
									
									<div class="form-group">
										<label for="text" class="control-label col-sm-2">username</label>
										<div class="col-sm-10">
											<input type="text" name="username" id="text" placeholder="" class="form-control" value='<?php echo $_POST['username']; ?>'>
										</div>
									</div>
									<div class="form-group">
										<label for="text" class="control-label col-sm-2">email(IES Login)</label>
										<div class="col-sm-10">
											<input type="text" name="email" id="text" placeholder="" class="form-control" value='<?php echo $_POST['email']; ?>'>
										</div>
									</div>
									<div class="form-group">
										<label for="text" class="control-label col-sm-2">New Password</label>
										<div class="col-sm-10">
											<input type="text" name="npassword" id="text" placeholder="" class="form-control" value='<?php echo $_POST['npassword']; ?>'>
										</div>
									</div>
									<div class="form-group">
										<label for="text" class="control-label col-sm-2">Confirm New Password</label>
										<div class="col-sm-10">
											<input type="text" name="cpassword" id="text" placeholder="" class="form-control" value='<?php echo $_POST['cpassword']; ?>'>
										</div>
									</div>
									<div class="form-group">
										<label for="text" class="control-label col-sm-2">role</label>
										<div class="col-sm-10">
											<select name="role" id="role" class='select2-me' style="width:100%">
												  
													<option value="admin" <?php if ($_POST['role']== 'admin'){echo 'selected'; } ?>>Admin</option>
												 	<option value="user" <?php if ($_POST['role']== 'user'){echo 'selected'; } ?>>User</option>
												  
											</select>
										</div>
									</div>
									<div class="form-group">
										<label for="text" class="control-label col-sm-2">status</label>
										<div class="col-sm-10">
											<select name="status" id="status1" class='select2-me' style="width:100%">
												  
													<option value="1" <?php if ($_POST['status']== '1'){echo 'selected'; } ?> >Enable</option>
												 	<option value="0" <?php if ($_POST['status']== '2'){echo 'selected'; } ?>>Disable</option>
												  
											</select>
										</div>
									</div>
									<div class="form-group">
										<label for="text" class="control-label col-sm-2">Project</label>
										<div class="col-sm-10">
											 <?php  
  												$projects = Sdba::table('projects');
  												$total_projects = $projects->total();
  												$projects_list = $projects->get();
  												//echo $total_rows;
  												//print_r($reportlist);
  												
  												 
  											?>
											<?php 
												for ($i=0; $i<$total_projects; $i++){
													for ($j=0; $j<count($_POST['projectid']); $j++){ 	
														if ($projects_list[$i]['id'] == $_POST['projectid'][$j]) {
															$checked = 'checked';
															break;
														}else{
															$checked = '';
														}
													}
											?>
											<div class="check-demo-col">
												<div class="check-line">
													<input type="checkbox" class='icheck-me ' <?php echo $checked; ?>  data-skin="minimal" value='<?php echo $projects_list[$i]['id']; ?>' name='projectid[]'>
													<label class='inline' for="c<?php echo $projects_list[$i]['id']; ?>"><?php echo $projects_list[$i]['name_en']; ?></label>
												</div>	 
											</div>
											<?php } ?>
										</div>
									</div>  
									 
									<div class="form-actions col-sm-offset-2 col-sm-10">
										<input type="hidden" name="key" value="<?php echo htmlspecialchars($_SESSION["key"], ENT_QUOTES);?>">
										<button type="submit" class="btn btn-primary">Add User</button>
										<a type="button" class="btn" href="?page=user">Cancel</a>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				 
			</div>
		</div>
	</div>