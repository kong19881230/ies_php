<?php if (!defined('EL_ADMIN')) exit('No direct script access allowed'); ?>
 		<div id="main">
			<div class="container-fluid">
				<div class="page-header">
					<div class="pull-left">
						<h1>User</h1>
					</div>
					<div class="pull-right">
						 
						<ul class="stats">
							<li class='blue'><a href='?page=users_add'>
								<i class="fa fa-plus-square"></i>
								<div class="details">
									<span class="big" style="font-size:26px;"> 新增 </span>
									 
								</div></a>
							</li>
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
							 
						</li>
						 
						 
					</ul>
					<div class="close-bread">
						<a href="#">
							<i class="fa fa-times"></i>
						</a>
					</div>
				</div>
 				<?php  
 					
 					$users = Sdba::table('users');
  					//$users->where('project_id',$_GET['id']);
  					$total_users = $users->total(); 
  					$users_list = $users->get();
  					//echo '<pre>';
  					//print_r($users_list);
  					//echo '</pre>';
  					for ($i=0; $i<$total_users;$i++){ 
  						$from_type_arr[] = $users_list[$i]['from_type'];
  					}
  					$from_type_unique = array_unique($from_type_arr);
  					//echo '<pre>';
  					//print_r(array_unique($from_type_unique));
  					//echo '</pre>';
  					if (!isset($_GET['ft'])){$_GET['ft']=$from_type_unique[0];}
  				?>
				 
				<div class="row">
					<div class="col-sm-12">
						<div class="box">
							
							<div class="box-content nopadding"> 
								<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered dataTable-colvis  ">
									<thead>
										<tr>
											<th style="text-align: center;">#ID</th>
											<th style="text-align: center;">name</th>
											<th style="text-align: center;">position</th>
											<th style="text-align: center;">company</th>
											
											<th style="text-align: center;">phone</th>
											<th style="text-align: center;">username</th>
											<th style="text-align: center;">email</th>
											<th style="text-align: center;">status</th>
											<th style="text-align: center;">role</th>
											<th style="text-align: center;">registered</th>
											 
											<th style="text-align: center;">Options</th>
										</tr>
									</thead>
									<tbody>
									<?php  
  										$users = Sdba::table('users');
  										//$users->where('from_type',$_GET['ft']);
  										//$users->where('report_id',$_GET['id']);
  										$total_users = $users->total();
  										$users_list = $users->get();
  										
  										//echo $total_rows;
  										//print_r($reportlist);
  									?>
  									<?php 
  										for ($i=0; $i<$total_users;$i++){
  											 if ($users_list[$i]['role']=='admin'){
  											 	$role = '<span class="label label-success">Admin</span>';
  											 }else{
  											 	$role = '<span class="label label-info">User</span>';
  											 }
  											 
  											  if ($users_list[$i]['status']=='1'){
  											 	$status = '<span class="label label-success">Enable</span>';
  											 }else{
  											 	$status = '<span class="label label-danger">Disable</span>';
  											 }
  											
  									?>
  										<tr>
											<td style="text-align: center;"><?php echo $users_list[$i]['id']; ?></td>
											<td style="text-align: center;"><?php echo $users_list[$i]['name']; ?> </td>
											<td style="text-align: center;"><?php echo chkempty($users_list[$i]['position']); ?></td>
											<td style="text-align: center;"><?php echo chkempty($users_list[$i]['company']); ?></td>
											 
											 
											<td style="text-align: center;"><?php echo chkempty($users_list[$i]['phone']); ?></td>
											<td style="text-align: center;"><?php echo chkempty($users_list[$i]['username']); ?></td>
											<td style="text-align: center;"><?php echo chkempty($users_list[$i]['email']); ?></td>
											
											<td style="text-align: center;"><?php echo $status; ?></td>
											<td style="text-align: center;"><?php echo $role; ?></td>
											<td style="text-align: center;"><?php echo chkempty($users_list[$i]['registered']); ?></td>
											 
											<td style="text-align: center;"> 
												<a href="?page=users_edit&id=<?php echo $users_list[$i]['id']; ?>" class="btn" rel="tooltip" title="" data-original-title="Edit">
													<i class="fa fa-pencil-square-o"></i>
												</a>
												<a href="#del" class="btn del" rel="tooltip" title="" data-original-title="Delete" id='del<?php echo $users_list[$i]['id']; ?>' style="display:none;">
													<i class="fa fa-times"></i>
												</a>
												<a href="?page=user_equipments&id=<?php echo $users_list[$i]['id']; ?>" class="btn" rel="tooltip" title="" data-original-title="管理使用者設備">
													管理使用者設備
												</a>
												 
												 <input name="selpn" type="hidden" id="selpn<?php echo $users_list[$i]['id']; ?>" value="“<?php echo $users_list[$i]['name_cn']; ?> / <?php echo $users_list[$i]['name_en']; ?>”">
											</td>
										</tr>
									<?php } ?>
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
                <input name="delpoid" type="hidden" id="delpoid" value="">
        </div>
    </div>
      <script type="text/javascript">
	//JQuery 実装
	$(document).ready(function(){
     
		$('.del').click(function(){
		 
			var poid= $(this).attr('id');
			poid = poid.slice(3);
			var pn= $('#selpn'+poid).val();
			//alert(poid);
			$('#overlay').fadeIn('fast',function(){
				$('#msg').text(pn);
				$('#delmsg').show();
				$('#delpopn').val(pn);
				$('#delpoid').val(poid);

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
			var poid = $('#delpoid').val();
			var MM_del = "del_users";
			var url = window.location.pathname;
			//alert("profs_list:"+theme_name);
			//var dataString = 'pn='+ pn +'&poid='+ poid +'&MM_del='+ MM_del +'&url='+ url;	
			var dataString =  'id='+ poid +'&MM_del='+ MM_del ;	
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
						alert("删除成功");
						location.reload();
					}else{
						alert("删除錯誤\n \n /"+text+"/");
						$('#delmsg').hide();
						$('#overlay').fadeOut('fast');
					}
					 
				}
			});
		 
		});
	});
	</script>