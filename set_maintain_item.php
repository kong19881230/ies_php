<?php if (!defined('EL_ADMIN')) exit('No direct script access allowed'); ?>
 		<div id="main">
			<div class="container-fluid">
				<div class="page-header">
					<div class="pull-left">
						<h1>管理報告項目</h1>
					</div>
					<div class="pull-right">
						 
						<ul class="stats">
							
							<li class='blue'><a href='#add' id='add_from_click'>
								<i class="fa fa-plus-square"></i>
								<div class="details">
									<span class="big" style="font-size:26px;"> 新增 </span>
									 
								</div></a>
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
							<a href="#">報告項目設置</a>
							 
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
							<?php foreach($from_type as $key => $value){ 
								if ($key == $_GET['ft']){$active = 'class="active"'; $ft = $value;}else{$active='';}
							?>
								<li <?php echo $active; ?>>
									<a href="?page=set_maintain_item&ft=<?php echo $key; ?>"><?php echo $value; ?></a>
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
							
								<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered dataTable-colvis  " id='add_from' style="display:none;">
									<tbody>
										<tr>
											<td colspan="5"  align="center"><span style='font-size:20px;'>▼▼▼　新增<?php echo $ft; ?>報告項目　▼▼▼</span></td>
										</tr>
										<tr>
  											 
  											<input type='hidden' id="from_type" value='<?php echo $_GET['ft']; ?>' ?>
											<td width='80px'>INDEX<input type='text' class="form-control up_val" id="index" value='' ?>
											<br><button class="btn btn-primary" style="margin-right: 10px; min-width:88px; background-color: #368ee0; " id="add_item">新增</button></td>
											
											<td width='60%'>中文<input type='text' class="form-control up_val" style="padding-right: 24px; " id="cnname" placeholder="" value='' > 
											ENG<input type='text' class="form-control up_val" style="padding-right: 24px; " id="enname" placeholder="" value='' >
											</td>
											<td width='180px'>TYPE
												<select name="typeid" id="typeid" class='select2-me' style="width:100px;">
												 	<option value=""  >-- 請選選 --</option>
													<option value="bool" <?php if ($result['type']=='bool'){echo 'selected'; } ?>>選擇式</option>
												 	<option value="s_value" <?php if ($result['type']=='s_value'){echo 'selected'; } ?>>單値式  </option>
												 	<option value="d_value" <?php if ($result['type']=='d_value'){echo 'selected'; } ?>>雙値式 </option>
												 	<option value="none" <?php if ($result['type']=='none'){echo 'selected'; } ?>>空値(小標題) </option>
												</select><br><br>
												 group
												 <input type='text' class="form-control up_val" id="from_group" value='' ?>
											</td>
											 
											<td class='trop' style="vertical-align: middle; <?php if ($result['type']!='bool'){ echo 'display:none;'; } ?>" colspan="2" align="center" id="trboolid" > <i class="glyphicon-ok_2"></i> 正常 | △ 待處理 | ◯ 已修復 </td>
											<td class='trop'  id="trsid" style="vertical-align: middle; <?php if ($result['type']!='s_value'){ echo 'display:none;'; } ?>" colspan="2" align="center">單位
												<input type='text' class="form-control up_val" style="padding-right: 24px; " id="s1unit" placeholder="<?php echo $result['unit']; ?>" value='<?php echo $result['unit']; ?>' >
												參考值<input type='text' class="form-control up_val" style="padding-right: 24px; " id="s1hint" placeholder="" value='' >
											</td>
											<td class='trop'  id="trd1id" style="vertical-align: middle; <?php if ($result['type']!='d_value'){ echo 'display:none;'; } ?>"  align="center">
											X 單位<input type='text' class="form-control up_val" style="padding-right: 24px; " id="d1unit" placeholder="" value='' >
												X 參考值<input type='text' class="form-control up_val" style="padding-right: 24px; " id="d1hint" placeholder="" value='' >
												</td>
												<td class='trop'  id="trd2id" style="vertical-align: middle; <?php if ($result['type']!='d_value'){ echo 'display:none;'; } ?>"  align="center" >
												Y 單位<input type='text' class="form-control up_val" style="padding-right: 24px; " id="d2unit" placeholder="<?php echo $result['unit'][1]; ?>" value='' >
												Y 參考值<input type='text' class="form-control up_val" style="padding-right: 24px; " id="d2hint<?php echo $maintain_items_list[$i]['id']; ?>" placeholder="" value='' >
											</td>
											<td class='trop'  style="vertical-align: middle; <?php if ($result['type']!='none'){ echo 'display:none;'; } ?>" colspan="2" align="center" id="trnoneid"> N/A </td>
											 
											
											 
											 
										</tr>
									</tbody>
								</table>
								<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered dataTable-colvis  ">
									<thead>
										<tr>
											<th width='30'>#</th>
											<th width='68%'>Item Name</th>
											<th width='120'>Format</th>
											<th colspan="2">Value</th>
											 
										</tr>
									</thead>
									<tbody>
									<?php  
  										$maintain_items = Sdba::table('maintain_items');
  										$maintain_items->where('from_type',$_GET['ft']);
  										//$maintain_items->where('report_id',$_GET['id']);
  										$total_maintain_items = $maintain_items->total();
  										$maintain_items_list = $maintain_items->get();
  										
  										
  										 
  										
  									 
  									?>
  									<?php 
  										for ($i=0; $i<$total_maintain_items;$i++){
  											  $result = json_decode($maintain_items_list[$i]['result_format'],true);
  											  
  									?>
  										<tr>
  											 
  											<input type='hidden' id="id<?php echo $maintain_items_list[$i]['id']; ?>" value='<?php echo $maintain_items_list[$i]['id']; ?>' ?>
											<td> <?php echo $maintain_items_list[$i]['id']; ?> </td>
											
											<td ><input type='text' class="form-control up_val" style="padding-right: 24px; " id="cnname<?php echo $maintain_items_list[$i]['id']; ?>" placeholder="<?php echo  $maintain_items_list[$i]['item_name_cn']; ?>" value='<?php echo $maintain_items_list[$i]['item_name_cn']; ?>' > 
											<input type='text' class="form-control up_val" style="padding-right: 24px; " id="enname<?php echo $maintain_items_list[$i]['id']; ?>" placeholder="<?php echo  $maintain_items_list[$i]['item_name_en']; ?>" value='<?php echo  $maintain_items_list[$i]['item_name_en']; ?>' >
											</td>
											<td>
												<select name="typeid<?php echo $maintain_items_list[$i]['id']; ?>" id="typeid<?php echo $maintain_items_list[$i]['id']; ?>" class='select2-me' style="width:100px;">
												 
													<option value="bool" <?php if ($result['type']=='bool'){echo 'selected'; } ?>>選擇式</option>
												 	<option value="s_value" <?php if ($result['type']=='s_value'){echo 'selected'; } ?>>單値式  </option>
												 	<option value="d_value" <?php if ($result['type']=='d_value'){echo 'selected'; } ?>>雙値式 </option>
												 	<option value="none" <?php if ($result['type']=='none'){echo 'selected'; } ?>>空値(小標題) </option>
												</select><br><br>
												 <button class="btn btn-primary save" style="margin-right: 10px; min-width:88px; background-color: #368ee0; display:none;" id="save<?php echo $maintain_items_list[$i]['id']; ?>">保存</button>
											</td>
											 
											<td class='trop<?php echo $maintain_items_list[$i]['id']; ?>' style="vertical-align: middle; <?php if ($result['type']!='bool'){ echo 'display:none;'; } ?>" colspan="2" align="center" id="trboolid<?php echo $maintain_items_list[$i]['id']; ?>" > <i class="glyphicon-ok_2"></i> 正常 | △ 待處理 | ◯ 已修復 </td>
											<td class='trop<?php echo $maintain_items_list[$i]['id']; ?>'  id="trsid<?php echo $maintain_items_list[$i]['id']; ?>" style="vertical-align: middle; <?php if ($result['type']!='s_value'){ echo 'display:none;'; } ?>" colspan="2" align="center">單位
												<input type='text' class="form-control up_val" style="padding-right: 24px; " id="s1unit<?php echo $maintain_items_list[$i]['id']; ?>" placeholder="<?php echo $result['unit']; ?>" value='<?php echo $result['unit']; ?>' >
												參考值<input type='text' class="form-control up_val" style="padding-right: 24px; " id="s1hint<?php echo $maintain_items_list[$i]['id']; ?>" placeholder="<?php echo $result['hint']; ?>" value='<?php echo $result['hint']; ?>' >
											</td>
											<td class='trop<?php echo $maintain_items_list[$i]['id']; ?>'  id="trd1id<?php echo $maintain_items_list[$i]['id']; ?>" style="vertical-align: middle; <?php if ($result['type']!='d_value'){ echo 'display:none;'; } ?>"  align="center">
											X 單位<input type='text' class="form-control up_val" style="padding-right: 24px; " id="d1unit<?php echo $maintain_items_list[$i]['id']; ?>" placeholder="<?php echo $result['unit'][0]; ?>" value='<?php echo $result['unit'][0]; ?>' >
												X 參考值<input type='text' class="form-control up_val" style="padding-right: 24px; " id="d1hint<?php echo $maintain_items_list[$i]['id']; ?>" placeholder="<?php echo $result['hint'][0]; ?>" value='<?php echo $result['hint'][0]; ?>' >
												</td>
												<td class='trop<?php echo $maintain_items_list[$i]['id']; ?>'  id="trd2id<?php echo $maintain_items_list[$i]['id']; ?>" style="vertical-align: middle; <?php if ($result['type']!='d_value'){ echo 'display:none;'; } ?>"  align="center" >
												Y 單位<input type='text' class="form-control up_val" style="padding-right: 24px; " id="d2unit<?php echo $maintain_items_list[$i]['id']; ?>" placeholder="<?php echo $result['unit'][1]; ?>" value='<?php echo $result['unit'][1]; ?>' >
												Y 參考值<input type='text' class="form-control up_val" style="padding-right: 24px; " id="d2hint<?php echo $maintain_items_list[$i]['id']; ?>" placeholder="<?php echo $result['hint'][1]; ?>" value='<?php echo $result['hint'][1]; ?>' >
											</td>
											<td class='trop<?php echo $maintain_items_list[$i]['id']; ?>'  style="vertical-align: middle; <?php if ($result['type']!='none'){ echo 'display:none;'; } ?>" colspan="2" align="center" id="trnoneid<?php echo $maintain_items_list[$i]['id']; ?>"> N/A </td>
											 
											
											 
											 
										</tr>
									<?php }   ?>
										
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
   <script src="js/jquery.min.js"></script>
    <script type="text/javascript">
	//JQuery 実装
	$(document).ready(function(){
		 
     	$( ".select2-me" ).change(function() {
     		var id= $(this).attr('id');
     		id =  id.slice(6);
     		var value= $(this).val();
     		
     		if (value == 'bool'){
     			$( ".trop"+id ).hide();
     			$( "#trboolid"+id ).show();
     		}else if (value == 's_value'){
     			$( ".trop"+id ).hide();
     			$( "#trsid"+id ).show();
     		}else if (value == 'd_value'){
     			$( ".trop"+id ).hide();
     			$( "#trd1id"+id ).show();
     			$( "#trd2id"+id ).show();
     		}else if (value == 'none'){
     			$( ".trop"+id ).hide();
     			$( "#trnoneid"+id ).show();
     		} 
     		 $( "#save"+id ).show();
     		 
		});
		
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
     		var item_name_cn = $( "#cnname"+id ).val();
     		var item_name_en = $( "#enname"+id ).val();
     		var type = $( "#typeid"+id ).val();
     		
     		var MM_update = "update_maintain_items";
     		
     		if (type == 's_value'){
     			var s1unit = $( "#s1unit"+id ).val();
     			var s1hint = $( "#s1hint"+id ).val();
     			var dataString =  'id='+ id +'&item_name_cn='+ item_name_cn +'&item_name_en='+ item_name_en +'&type='+ type +'&MM_update='+ MM_update +'&s1hint='+ s1hint +'&s1unit='+ s1unit ;	
     		}else if (type == 'd_value'){
     			var d1unit = $( "#d1unit"+id ).val();
     			var d1hint = $( "#d1hint"+id ).val();
     			var d2unit = $( "#d2unit"+id ).val();
     			var d2hint = $( "#d2hint"+id ).val();
     			var dataString =  'id='+ id +'&item_name_cn='+ item_name_cn +'&item_name_en='+ item_name_en +'&type='+ type +'&MM_update='+ MM_update +'&d2hint='+ d2hint +'&d2unit='+ d2unit +'&d1hint='+ d2hint +'&d1unit='+ d1unit ;	
     		}else{
     			var dataString =  'id='+ id +'&item_name_cn='+ item_name_cn +'&item_name_en='+ item_name_en +'&type='+ type +'&MM_update='+ MM_update ;	
     		
     		}
     		
     		 
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
		
		
		$('#add_from_click').click(function(){
			$( "#add_from"  ).show();
		});
		$('#add_item').click(function(){
			var id= $(this).attr('id');
     		id =  id.slice(4);
     		var item_name_cn = $( "#cnname" ).val();
     		var item_name_en = $( "#enname" ).val();
     		var type = $( "#typeid" ).val();
     		var from_type = $( "#from_type" ).val();
     		var group = $( "#from_group" ).val();
     		var index = $( "#index" ).val();
     		var ierror = 'no';
     		if (item_name_cn == '') { 
     			alert('請輸入中文項目名稱');
     			ierror = 'yes';
     		}else if (item_name_en == '') { 
     			alert('請輸入英文項目名稱');
     			ierror = 'yes';
     		}
     		
     		var MM_update = "add_maintain_items";
     		
     		if (type == 's_value'){
     			var s1unit = $( "#s1unit"  ).val();
     			var s1hint = $( "#s1hint"  ).val();
     			var dataString =  'from_type='+ from_type +'&index='+ index  +'&group='+ group +'&item_name_cn='+ item_name_cn +'&item_name_en='+ item_name_en +'&type='+ type +'&MM_update='+ MM_update +'&s1hint='+ s1hint +'&s1unit='+ s1unit ;	
     		}else if (type == 'd_value'){
     			var d1unit = $( "#d1unit" ).val();
     			var d1hint = $( "#d1hint" ).val();
     			var d2unit = $( "#d2unit"  ).val();
     			var d2hint = $( "#d2hint" ).val();
     			var dataString =  'from_type='+ from_type +'&index='+ index  +'&group='+ group +'&item_name_cn='+ item_name_cn +'&item_name_en='+ item_name_en +'&type='+ type +'&MM_update='+ MM_update +'&d2hint='+ d2hint +'&d2unit='+ d2unit +'&d1hint='+ d2hint +'&d1unit='+ d1unit ;	
     		}else{
     			var dataString =  'from_type='+ from_type +'&index='+ index  +'&group='+ group +'&item_name_cn='+ item_name_cn +'&item_name_en='+ item_name_en +'&type='+ type +'&MM_update='+ MM_update ;	
     		
     		}
     		
     		 
			//alert(dataString+"/");
		 	if (ierror == 'no') {
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
						//$('.save').hide();
						location.reload();
					}else{
						alert("錯誤\n \n /"+text+"/");
						 
					}
					 
				}
			});
		 	}
		});
	});
	</script>