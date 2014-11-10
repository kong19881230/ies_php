<?php if (!defined('EL_ADMIN')) exit('No direct script access allowed'); ?>
 <?php 
 if(isset($_SESSION["key"], $_POST["key"]) && $_SESSION["key"] == $finalkey){
 	date_default_timezone_set("Asia/Hong_Kong");
		
		$ud_machines = Sdba::table('machines');
		 
		$data = array(
			'name'=> $finalname,
			'model_id'=>$finalmodel_id,
			'description'=> $finaldescription,
			'type'=> $finaltype,
			'created_at'=> date('Y-m-d H:i:s'),
			'updated_at'=> date('Y-m-d H:i:s')
		);
		$ud_machines ->insert($data);
		unset($_SESSION["key"]);
		$_SESSION["key"] = md5(uniqid().mt_rand());				
		?>
<script>
window.location = './?page=machines';
</script>
		<?php								 
 }
 ?>
 		<div id="main">
			<div class="container-fluid">
				<div class="page-header">
					<div class="pull-left">
						<h1>machines </h1>
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
  					$machines = Sdba::table('machines');
  					$machines->where('id',$_GET['id']);
  					$total_machines = $machines->total();
  					$machines_list = $machines->get();
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
							<a href="?page=machines">machines</a>
							<i class="fa fa-angle-right"></i>
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
									<i class="fa fa-th-list"></i> Add New </h3>
							</div>
							<div class="box-content nopadding">
							
								<form action="?page=machines_add" method="POST" enctype="multipart/form-data" class='form-horizontal form-bordered'>
									<div class="form-group">
										<label for="textfield" class="control-label col-sm-2">名稱</label>
										<div class="col-sm-10">
											<input type="text" name="name" id="textfield" placeholder="" class="form-control" value=''>

										</div>
									</div>
									 
									
									<div class="form-group">
										<label for="textfield" class="control-label col-sm-2">model_id</label>
										<div class="col-sm-10">
											<input type="text" name="model_id" id="textfield" placeholder="" class="form-control" value=''>
										</div>
									</div>
									<div class="form-group">
										<label for="text" class="control-label col-sm-2">description</label>
										<div class="col-sm-10">
											<input type="text" name="description" id="text" placeholder="" class="form-control" value=''>
										</div>
									</div>
									<div class="form-group">
										<label for="text" class="control-label col-sm-2">type</label>
										<div class="col-sm-10">
											<input type="text" name="type" id="text" placeholder="" class="form-control" value=''>
										</div>
									</div>
									 
									 
									<div class="form-actions col-sm-offset-2 col-sm-10">
										<input type="hidden" name="key" value="<?php echo htmlspecialchars($_SESSION["key"], ENT_QUOTES);?>">
										<button type="submit" class="btn btn-primary">Add</button>
										<a type="button" class="btn" href="?page=machines">Cancel</a>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				 
			</div>
		</div>
	</div>