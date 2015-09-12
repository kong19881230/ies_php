<?php if (!defined('EL_ADMIN')) exit('No direct script access allowed'); ?>
 <?php 
 if(isset($_SESSION["key"], $_POST["key"]) && $_SESSION["key"] == $finalkey){
 	date_default_timezone_set("Asia/Hong_Kong");
		
		$ud_users = Sdba::table('users');
		$ud_users ->where('id', $_GET['id']);
		$ud_users_list = $ud_users->get();
		if ( ($_POST['npassword'] !='')&&  ($_POST['cpassword'] !='')){
			//echo '　　　　　　　　　　　　　　　　　　　　xx';
			if($_POST['npassword']==$_POST['cpassword']){
				$password = md5($_POST['npassword']);
			}else{
				$password = $ud_users_list[0]['password'];
			}
		}else{
			$password = $ud_users_list[0]['password'];
		}
		
		if ($ud_users_list[0]['username']!=$_POST['username']){
			$users = Sdba::table('users');
  			$users->where('username',$_POST['username']);
  			$total_users = $users->total();
  		}else{ $total_users = 0; }
  		
  		if ($ud_users_list[0]['email']!=$_POST['email']){
  			$users_mail = Sdba::table('users');
  			$users_mail->where('email',$_POST['email']);
  			$total_users_mail = $users_mail->total();
  		}else{ $total_users_mail = 0; }
		if ($total_users > 0) {
			$error_msg = '此賬號已存在，請輸入其他的電郵地址';
		}elseif ($total_users_mail > 0) {
			$error_msg = '此電郵已存在，請輸入其他的電郵地址';
		}else{
		//echo $password;
		$data = array(
			'name'=> $finalname,
			'position'=> $_POST['position'],
			'company'=> $_POST['company'],
			'phone'=> $_POST['phone'],
			'username'=> $_POST['username'],
			'email'=>$_POST['email'],
			'password'=>$password,
			'status'=> $_POST['status'],
			'role'=> $_POST['role'],
			'updated_at'=> date('Y-m-d H:i:s')
		);
		$ud_users ->update($data);
		
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
				'user_id'=> $_GET['id'],
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
		<?php		}						 
 }else{
 	$_SESSION["key"] = md5(uniqid().mt_rand());		
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
				<?php  
  					$users = Sdba::table('users');
  					$users->where('id',$_GET['id']);
  					$total_users = $users->total();
  					$users_list = $users->get();
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
							<a href="?page=users">users</a>
							<i class="fa fa-angle-right"></i>
						</li>
						
						<li>
							<a href="#">Edit</a>
							 <i class="fa fa-angle-right"></i>
						</li>
						 <li>
							<a href="#"><?php echo $users_list[0]['name']; ?>  </a>
							
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
									<i class="fa fa-th-list"></i> 編輯 <?php echo $users_list[0]['name']; ?> </h3>
							</div>
							<div class="box-content nopadding">
							
								<form action="?page=users_edit&id=<?php echo $users_list[0]['id']; ?>" method="POST" enctype="multipart/form-data" class='form-horizontal form-bordered'>
									<div class="form-group">
										<label for="textfield" class="control-label col-sm-2">name</label>
										<div class="col-sm-10">
											<input type="text" name="name" id="textfield" placeholder="<?php echo chkempty($users_list[0]['name']); ?>" class="form-control" value='<?php echo  $users_list[0]['name']; ?>'>

										</div>
									</div>
									 
									
									<div class="form-group">
										<label for="textfield" class="control-label col-sm-2">position</label>
										<div class="col-sm-10">
											<input type="text" name="position" id="textfield" placeholder="<?php echo chkempty($users_list[0]['position']); ?>" class="form-control" value='<?php echo $users_list[0]['position']; ?>'>
										</div>
									</div>
									<div class="form-group">
										<label for="text" class="control-label col-sm-2">company</label>
										<div class="col-sm-10">
											<input type="text" name="company" id="text" placeholder="<?php echo chkempty($users_list[0]['company']); ?>" class="form-control" value='<?php echo $users_list[0]['company']; ?>'>
										</div>
									</div>
									<div class="form-group">
										<label for="text" class="control-label col-sm-2">phone</label>
										<div class="col-sm-10">
											<input type="text" name="phone" id="text" placeholder="<?php echo chkempty($users_list[0]['phone']); ?>" class="form-control" value='<?php echo $users_list[0]['phone']; ?>'>
										</div>
									</div>
									
									<div class="form-group">
										<label for="text" class="control-label col-sm-2">username</label>
										<div class="col-sm-10">
											<input type="text" name="username" id="text" placeholder="<?php echo chkempty($users_list[0]['username']); ?>" class="form-control" value='<?php echo $users_list[0]['username']; ?>'>
										</div>
									</div>
									<div class="form-group">
										<label for="text" class="control-label col-sm-2">email(IES Login)</label>
										<div class="col-sm-10">
											<input type="text" name="email" id="text" placeholder="<?php echo chkempty($users_list[0]['email']); ?>" class="form-control" value='<?php echo $users_list[0]['email']; ?>'>
										</div>
									</div>
									<div class="form-group">
										<label for="text" class="control-label col-sm-2">New Password</label>
										<div class="col-sm-10">
											<input type="text" name="npassword" id="text" placeholder="" class="form-control" value=''>
										</div>
									</div>
									<div class="form-group">
										<label for="text" class="control-label col-sm-2">Confirm New Password</label>
										<div class="col-sm-10">
											<input type="text" name="cpassword" id="text" placeholder="" class="form-control" value=''>
										</div>
									</div>
									<div class="form-group">
										<label for="text" class="control-label col-sm-2">role</label>
										<div class="col-sm-10">
											<select name="role" id="role" class='select2-me' style="width:100%">
												  
													<option value="admin" <?php if ($users_list[0]['role']== 'admin'){echo 'selected'; } ?>>Admin</option>
												 	<option value="user" <?php if ($users_list[0]['role']== 'user'){echo 'selected'; } ?>>User</option>
												  
											</select>
										</div>
									</div>
									<div class="form-group">
										<label for="text" class="control-label col-sm-2">status</label>
										<div class="col-sm-10">
											<select name="status" id="status1" class='select2-me' style="width:100%">
												  
													<option value="1" <?php if ($users_list[0]['status']== '1'){echo 'selected'; } ?>>Enable</option>
												 	<option value="0" <?php if ($users_list[0]['status']== '0'){echo 'selected'; } ?>>Disable</option>
												  
											</select>
										</div>
									</div> 
									
									<div class="form-group">
										<label for="text" class="control-label col-sm-2">Project</label>
										<div class="col-sm-10">
											<div class="input-group input-group">
												<span class="input-group-addon">
													<i class="fa fa-search"></i>
												</span>
												<input type="text" placeholder="Search here..." class="form-control" id='search_project'>
												<div class="input-group-btn">
													<button class="btn" type="button" id='showall'>清除</button>
													
													 
												</div>
											</div><br><input type="checkbox" id="selecctall"/> Selecct All<br><hr>
											 <?php  
  												$projects = Sdba::table('projects');
  												$total_projects = $projects->total();
  												$projects_list = $projects->get();
  												//echo $total_rows;
  												//print_r($reportlist);
  												
  												$project_users = Sdba::table('project_users');
  												$project_users->where('user_id',$_GET['id']);
  												$total_project_users = $project_users->total();
  												$project_users_list = $project_users->get();
  											?>
											<?php 
												for ($i=0; $i<$total_projects; $i++){
													for ($j=0; $j<$total_project_users; $j++){ 	
														if ($projects_list[$i]['id'] == $project_users_list[$j]['project_id']) {
															$checked = 'checked';
															break;
														}else{
															$checked = '';
														}
													}
											?>
											<div class="check-demo-col project" data-skin="<?php echo strtolower($projects_list[$i]['name_en']); ?>">
												<div class="check-line">
													<input type="checkbox" class='check-me ' <?php echo $checked; ?>  data-skin="minimal" value='<?php echo $projects_list[$i]['id']; ?>' name='projectid[]'>
													<label class='inline' for="c<?php echo $projects_list[$i]['id']; ?>"><?php echo $projects_list[$i]['name_en']; ?></label>
													 
												</div>	 
											</div>
											<?php } ?>
										</div>
									</div> 
									 
									<div class="form-actions col-sm-offset-2 col-sm-10">
										<input type="hidden" name="key" value="<?php echo htmlspecialchars($_SESSION["key"], ENT_QUOTES);?>">
										<button type="submit" class="btn btn-primary">Save changes</button>
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
	
<script>
 
 
$(document).ready(function() {
	$( "#search_project" ).keyup(function() {
		var search_val = $(this).val();
		search_val = search_val.toLowerCase();
		 
		$(".project").hide();
		 
   		$("[class*='project'][data-skin*='"+search_val+"']").show();
    	//alert('"'+search_val+'"');
		if (search_val==''){
    		$(".project").show();
    		 
    	}
	});
 
	$( "#showall" ).click(function() {
  		$(".project").show(); 
  		$( "#search_project" ).val('');
	});
	$('#selecctall').click(function(event) {  //on click  
        if(this.checked) { // check select status
            $('.check-me').each(function() { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"               
            });
        }else{
            $('.check-me').each(function() { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "checkbox1"                       
            });         
        }
    });
	 
});
</script>