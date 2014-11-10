<?php if (!defined('EL_ADMIN')) exit('No direct script access allowed'); ?>
 <?php 
 if(isset($_SESSION["key"], $_POST["key"]) && $_SESSION["key"] == $finalkey){
 	date_default_timezone_set("Asia/Hong_Kong");
		
		$ud_machines = Sdba::table('machines');
		$ud_machines ->where('id', $_GET['id']);
		$data = array(
			'name'=> $finalname,
			'model_id'=>$finalmodel_id,
			'description'=> $finaldescription,
			'type'=> $finaltype,
			'updated_at'=> date('Y-m-d H:i:s')
		);
		$ud_machines ->update($data);
 
		$postvalue =  $_POST['value'];
		$postnamesid = $_POST['namesid'];
		
		foreach($postvalue as $keys => $values){
			if ($values != ''){
				$newvalue[$postnamesid[$keys]] = $values;
			}
		}
		//echo '<pre>';
		//print_r($newvalue);
		//echo '</pre>';
		//Project id 
		
		$machine_attributes = Sdba::table('machine_attributes');
  		$machine_attributes->where('machine_id',$_GET['id']);
  		$machine_attributes->delete();
  		
  		foreach($newvalue as $keys => $values){
  		//for ($k=0; $k < count($newvalue); $k++){
  			$data = array(
  				'machine_id' => $_GET['id'],
				'machine_attribute_name_id'=> $keys,
				'value'=> $values 
			);
			$machine_attributes ->insert($data);
  		}
		
		
		unset($_SESSION["key"]);
		$_SESSION["key"] = md5(uniqid().mt_rand());				
		?>
<script>
window.location = './?page=machines';
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
							<a href="#">Edit</a>
							 <i class="fa fa-angle-right"></i>
						</li>
						 <li>
							<a href="#"><?php echo $machines_list[0]['name']; ?>  </a>
							
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
									<i class="fa fa-th-list"></i> 編輯 <?php echo $machines_list[0]['name']; ?> </h3>
							</div>
							<form action="?page=machines_edit&id=<?php echo $machines_list[0]['id']; ?>" method="POST" enctype="multipart/form-data" class='form-horizontal form-bordered'>
							<div class="box-content nopadding">
							
									<div class="form-group">
										<label for="textfield" class="control-label col-sm-2">名稱</label>
										<div class="col-sm-10">
											<input type="text" name="name" id="textfield" placeholder="<?php echo chkempty($machines_list[0]['name']); ?>" class="form-control" value='<?php echo  $machines_list[0]['name']; ?>'>

										</div>
									</div>
									 
									
									<div class="form-group">
										<label for="textfield" class="control-label col-sm-2">model_id</label>
										<div class="col-sm-10">
											<input type="text" name="model_id" id="textfield" placeholder="<?php echo chkempty($machines_list[0]['model_id']); ?>" class="form-control" value='<?php echo $machines_list[0]['model_id']; ?>'>
										</div>
									</div>
									<div class="form-group">
										<label for="text" class="control-label col-sm-2">description</label>
										<div class="col-sm-10">
											<input type="text" name="description" id="text" placeholder="<?php echo chkempty($machines_list[0]['description']); ?>" class="form-control" value='<?php echo $machines_list[0]['description']; ?>'>
										</div>
									</div>
									<div class="form-group">
										<label for="text" class="control-label col-sm-2">type</label>
										<div class="col-sm-10">
											<input type="text" name="type" id="text" placeholder="<?php echo chkempty($machines_list[0]['type']); ?>" class="form-control" value='<?php echo $machines_list[0]['type']; ?>'>
										</div>
									</div>
									 
									 
									<div class="form-actions col-sm-offset-2 col-sm-10">
										machine_attributes
									</div>
								
							</div>
							<div class="box-content nopadding">
								<?php  
  								$machine_attribute_names = Sdba::table('machine_attribute_names');
  								$machine_attribute_names->where('type',$machines_list[0]['type']);
  								$total_machine_attribute_names = $machine_attribute_names->total();
  								$machine_attribute_names_list = $machine_attribute_names->get();
  								//echo $total_rows;
  								//print_r($reportlist);
  								
  								$machine_attributes = Sdba::table('machine_attributes');
  								$machine_attributes->where('machine_id',$_GET['id']);
  								$total_machine_attributes = $machine_attributes->total();
  								$machine_attributes_list = $machine_attributes->get();
  								$value = '';
  								for ($a=0; $a<$total_machine_attribute_names; $a++){
  									for ($b=0; $b<$total_machine_attributes; $b++){
  										if ($machine_attributes_list[$b]['machine_attribute_name_id']==$machine_attribute_names_list[$a]['id']) {
  											$value = $machine_attributes_list[$b]['value'];
  										}
  									}
  								?>
								
									<div class="form-group">
										<label for="textfield" class="control-label col-sm-2"><?php echo $machine_attribute_names_list[$a]['name_cn']; ?></label>
										<div class="col-sm-10">
											<input type="text" name="value[]" id="textfield" placeholder="不要請留空即可" class="form-control" value='<?php echo $value; ?>'>
											<input type="hidden" name="namesid[]" id="textfield"  class="form-control" value='<?php echo $machine_attribute_names_list[$a][id]; ?>'>
										</div>
									</div>
								<?php $value=''; } ?>	 
									
									 
									 
									 
									<div class="form-actions col-sm-offset-2 col-sm-10">
										<input type="hidden" name="key" value="<?php echo htmlspecialchars($_SESSION["key"], ENT_QUOTES);?>">
										<button type="submit" class="btn btn-primary">Save changes</button>
										<a type="button" class="btn" href="?page=machines">Cancel</a>
									</div>
								 
							</div>
							</form>
						</div>
					</div>
				</div>
				 
			</div>
		</div>
	</div>