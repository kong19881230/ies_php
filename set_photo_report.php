<?php if (!defined('EL_ADMIN')) exit('No direct script access allowed'); ?>

		<?php 
				
  				
  				
				?>
 		<div id="main">
			<div class="container-fluid">
				<div class="page-header">
					<div class="pull-left">
						<h1>管理相片報告</h1>
					</div>
					
				</div>
				 
				<div class="breadcrumbs">
					<ul>
						<li>
							<a href="?page=home">Home</a>
							<i class="fa fa-angle-right"></i>
						</li>
						 
						 
						<li>
							<a href="#">相片報告描述設置</a>
							 
						</li> 
						 
						 
					</ul>
					<div class="close-bread">
						<a href="#">
							<i class="fa fa-times"></i>
						</a>
					</div>
				</div>
 				<?php  
 					 
  					if (!isset($_GET['ft'])){$_GET['ft'] = 'boiler';}
  				?>
				<div class="row">
					<div class="col-sm-12">
						<h6>　</h6>
						<p>
							<ul class="nav nav-tabs">
							<?php foreach($photo_types as $photo_type){ 
								if ($photo_type== $_GET['ft']){$active = 'class="active"'; $ft = $photo_type;}else{$active='';}
							?>
								<li <?php echo $active; ?>>
									<a href="?page=set_photo_report&ft=<?php echo $photo_type; ?>"><?php echo $from_type[$photo_type]; ?></a>
								</li>
								 
							<?php } ?>
							</ul>
						</p>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<div class="box">
							
							<div class="box-content nopadding"> 
							
								
								<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered dataTable-colvis  ">
									<thead>
										<tr>
											<th width='20'>#</th>
											<th width='68%'>Photo Description</th>
											<th width='250'>Photo</th>
											 
										</tr>
									</thead>
									<tbody>
									<?php  
  										
  										
  										$photo_reports= Sdba::table('photo_reports');
  										$photo_reports->like('key','%'.$from_type_short[$_GET['ft']].'%');
  										$total_photo = $photo_reports->total();
										$photo_report_list= $photo_reports->get();
						            
						              
						              
  										
  									 
  									?>
  									<?php 
  										for ($i=0; $i<$total_photo;$i++){
  											  if( preg_match("/".$from_type_short[$_GET['ft']]."[0-9]/", $photo_report_list[$i]['key'])){
  									?>
  										
  											<tr>
  											 
  											<input type='hidden' id="id<?php echo $photo_report_list[$i]['key']; ?>" value='<?php echo $photo_report_list[$i]['key']; ?>' ?>
											<td> <?php echo $i+1 ?> </td>
											
											<td ><input type='text' class="form-control up_val" style="padding-right: 24px; " id="cnname<?php echo $photo_report_list[$i]['key']; ?>" placeholder="<?php echo  $photo_report_list[$i]['text_cn']; ?>" value='<?php echo $photo_report_list[$i]['text_cn']; ?>' > 
											<input type='text' class="form-control up_val" style="padding-right: 24px; " id="enname<?php echo $photo_report_list[$i]['key']; ?>" placeholder="<?php echo $photo_report_list[$i]['text_en']; ?>" value='<?php echo  $photo_report_list[$i]['text_en']; ?>' >
											<br/>
											 <button class="btn btn-primary save" style="margin-right: 10px; min-width:88px; background-color: #368ee0; display:none;" id="save<?php echo$photo_report_list[$i]['key']; ?>">保存</button>
											</td>
											<td>
												<a href="exm_photos/<?php echo $photo_report_list[$i]['key']; ?>.jpg" class="colorbox-image cboxElement" rel="group-1" target='blank'>
												<img src="exm_photos/<?php echo$photo_report_list[$i]['key']; ?>.jpg" width="240px" >
												</a>
												
											</td>
											 
										
											
											 
											 
										</tr>
									<?php 

										}
									}   ?>
										
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
	
   <script src="js/jquery.min.js"></script>
    <script type="text/javascript">
	//JQuery 実装
	$(document).ready(function(){
		 
     
		
		$( ".up_val" ).keyup(function() {
     		var id= $(this).attr('id');
     		id =  id.slice(6);
     		var placeholder= $(this).attr('placeholder');
     		var value= $(this).val();
     		//alert(value);
     		if (placeholder!=value){
     			$( "#save"+id ).show();
  			}
		});
		 
		//确认删除
		$('.save').click(function(){
			var id= $(this).attr('id');
     		id =  id.slice(4);
     		var text_cn = $( "#cnname"+id ).val();
     		var text_en = $( "#enname"+id ).val();
     		
     		
     		var MM_update = "update_photo_report";
     		
     	
     		var dataString =  'key='+ id +'&text_cn='+ text_cn +'&text_en='+ text_en +'&MM_update='+ MM_update ;	
     		
     	
     		
     		 
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
						alert("保存成功");
						$('.save').hide();
						//location.reload();
					}else{
						alert("錯誤\n \n /"+text+"/");
						 
					}
					 
				}
			});
		 	 
		});
		
		
	
	
	});
	</script>