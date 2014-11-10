<?php if (!defined('EL_ADMIN')) exit('No direct script access allowed'); ?>
 		<div id="main">
			<div class="container-fluid">
				<div class="page-header">
					<div class="pull-left">
						<h1>管理報告項目</h1>
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
  					$projects = Sdba::table('projects');
  					$projects->where('id',$_GET['id']);
  					$total_projects = $projects->total();
  					$projects_list = $projects->get();
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
							<a href="?page=projects">Projects</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="?page=projects_view&id=<?php echo $_GET['id']; ?>"><?php echo $projects_list[0]['name_cn']; ?> ／ <?php echo $projects_list[0]['name_en']; ?></a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="#">管理報告項目</a>
							 
						</li> 
						 
						 
					</ul>
					<div class="close-bread">
						<a href="#">
							<i class="fa fa-times"></i>
						</a>
					</div>
				</div>
 				<?php  
 					/*
 					$maintain_items = Sdba::table('maintain_items');
  					//$maintain_items->where('report_id',$_GET['id']);
  					$total_maintain_items = $maintain_items->total(); 
  					$maintain_items_list = $maintain_items->get();
  					//echo '<pre>';
  					//print_r($maintain_items_list);
  					//echo '</pre>';
  					for ($i=0; $i<$total_maintain_items;$i++){ 
  						$from_type_arr[] = $maintain_items_list[$i]['from_type'];
  					}
  					$from_type_unique = array_unique($from_type_arr);
  					//echo '<pre>';
  					//print_r(array_unique($from_type_unique));
  					//echo '</pre>';
  					if (!isset($_GET['ft'])){$_GET['ft']=$from_type_unique[0];}
  					*/
  					$projects = Sdba::table('projects');
  					//$maintain_items->where('report_id',$_GET['id']);
  					$total_projects = $projects->total(); 
  					$projects_list = $projects->get();
  					//echo '<pre>';
  					//print_r($maintain_items_list);
  					//echo '</pre>';
  					$result = json_decode($projects_list[0]['machine_types'],true);
  					$cycle_types = json_decode($projects_list[0]['cycle_types'],true);
  					 
  					//echo '<pre>';
  					//print_r(array_unique($from_type_unique));
  					//echo '</pre>';
  					if (!isset($_GET['ft'])){$_GET['ft']=$result[0];}
  				?>
				<div class="row">
					<div class="col-sm-12">
						<h6>　</h6>
						<p>
							<ul class="nav nav-tabs">
							<?php foreach($result as $value){ 
								if ($value == $_GET['ft']){$active = 'class="active"';}else{$active='';}
							?>
								<li <?php echo $active; ?>>
									<a href="?page=maintain_item_set&id=<?php echo $_GET['id'].'&ft='.$value; ?>"><?php echo $from_type[$value]; ?></a>
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
											<th width='30'>#ID</th>
											<th width='120'>Cycle</th>
											<th>Item Name</th>
											<th width='120' colspan="2">Format</th>
											 
										</tr>
									</thead>
									<tbody>
									<?php  
  										$maintain_items = Sdba::table('maintain_items');
  										$maintain_items->where('from_type',$_GET['ft']);
  										//$maintain_items->where('report_id',$_GET['id']);
  										$total_maintain_items = $maintain_items->total();
  										$maintain_items_list = $maintain_items->get();
  										
  										
  										$maintain_item_set = Sdba::table('maintain_item_set');
  										//$maintain_item_set->where('from_type',$_GET['ft']);
  										$maintain_item_set ->where('project_id',$_GET['id']);
  										//$total_maintain_item_set = $maintain_item_set->total();
  										//$maintain_item_set_list = $maintain_item_set->get();
  										
  									 
  									?>
  									<?php 
  										for ($i=0; $i<$total_maintain_items;$i++){
  											 $result = json_decode($maintain_items_list[$i]['result_format'],true);
  											 $id =$maintain_items_list[$i]['id'];
  											 
  											 $maintain_item_set = Sdba::table('maintain_item_set');
  										//$maintain_item_set->where('from_type',$_GET['ft']);
  										$maintain_item_set ->where('project_id',$_GET['id']);
  											 $maintain_item_set ->where('maintain_item_id',$id);
  											 $total_maintain_item_set = $maintain_item_set->total();
  											 //echo $total_maintain_item_set;
  											 $maintain_item_set_list = $maintain_item_set->get();
  											 
  											 //echo '<pre>';
  											//print_r($maintain_item_set_list);
  											//echo '</pre>';
  											 /*
											for ($j=0; $j<$total_maintain_item_set; $j++){
												$maintain_item_set_list[$i]
												
											}
											*/	 
												 
														if ( $total_maintain_item_set ==1) {
															$checked = 'checked';
															 
														}else{
															$checked = '';
														}
												 
												
  									?>
  										<tr>
  											<input type='hidden' id="project_id" value='<?php echo $_GET['id']; ?>' ?>
  											<input type='hidden' id="id<?php echo $maintain_items_list[$i]['id']; ?>" value='<?php echo $maintain_item_set_list[0]['id']; ?>' ?>
											<td><input type="checkbox" id='maintain_item_id<?php echo $maintain_items_list[$i]['id']; ?>' class='icheck-me' <?php echo $checked; ?>  data-skin="minimal"  ></td>
											<td>
												<select name="cycle<?php echo $maintain_items_list[$i]['id']; ?>" id="cycle<?php echo $maintain_items_list[$i]['id']; ?>" class='select2-me' style="width:100px;">
												<?php foreach($cycle_types as $value) { ?>
													<option value="<?php echo $value; ?>" <?php if ($maintain_item_set_list[0]['cycle']==$value){echo 'selected'; } ?>><?php echo $reports_cycles_cn[$value]; ?></option>
												<?php } ?>
												 
												</select>
											</td>
											<td ><?php echo $maintain_items_list[$i]['item_name_cn'].'<br>'.$maintain_items_list[$i]['item_name_en']; ?></td>
											<?php 
											if ($result['type']=='bool'){
												echo '<td style="vertical-align: middle;" colspan="2" align="center"> <i class="glyphicon-ok_2"></i> 正常 | △ 待處理 | ◯ 已修復 </td>';
											 
											}elseif ($result['type']=='s_value'){
											 	echo '<td style="vertical-align: middle;" colspan="2" align="center">'.'x'.$result['unit'] .'<br>('.$result['hint'] .')</td>';	
											 
											}elseif ($result['type']=='d_value'){
												echo '<td style="vertical-align: middle;" align="center"> '. 'x'. $result['unit'][0].'<br>('.$result['hint'][0].')</td>';
												echo '<td style="vertical-align: middle;" align="center"> '.'y'.$result['unit'][1].'<br>('.$result['hint'][1].')</td>';		
												 
											}else{
												echo '<td style="vertical-align: middle;" colspan="2" align="center"> N/A </td>';	
											}
											?>
											 
											 
											 
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
     		var maintain_item_id= $(this).attr('id');
     		maintain_item_id = maintain_item_id.slice(5);
			var poid = $("#id"+maintain_item_id ).val();
			
			var project_id = $( "#project_id" ).val();
     		var cycles = $(this).val();
     		var MM_update = "update_maintain_items_set_cycle";
     		var dataString =  'id='+ poid  +  '&cycle='+ cycles  +'&MM_update='+ MM_update ;	
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
						//alert("删除成功");
						location.reload();
					}else{
						alert("删除錯誤\n \n /"+text+"/");
						 
					}
					 
				}
			});
  			 
		});
		
		$( ".icheck-me" ).click(function() {
     		var maintain_item_id= $(this).attr('id');
     		maintain_item_id = maintain_item_id.slice(16);
			var poid = $("#id"+maintain_item_id ).val();
			
			var project_id = $( "#project_id" ).val();
     		var cycles = $( "select[name=cycle"+maintain_item_id+"]" ).val();
     		var MM_update = "update_maintain_items_set";
     		var dataString =  'id='+ poid +'&maintain_item_id='+ maintain_item_id +'&project_id='+ project_id  +'&cycle='+ cycles  +'&MM_update='+ MM_update ;	
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
						//alert("删除成功");
						//location.reload();
					}else{
						alert("删除錯誤\n \n /"+text+"/");
						 
					}
					 
				}
			});
  			
		});
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
			var MM_del = "del_maintain_items";
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
						//location.reload();
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