<?php if (!defined('EL_ADMIN')) exit('No direct script access allowed'); ?>
 		<div id="main">
			<div class="container-fluid">
				<div class="page-header">
					<div class="pull-left">
						<h1>machines</h1>
					</div>
					<div class="pull-right">
						 
						<ul class="stats">
							<li class='blue'><a href='?page=machines_add'>
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
							<a href="?page=machines">machines</a>
							 
						</li>
						 
						 
					</ul>
					<div class="close-bread">
						<a href="#">
							<i class="fa fa-times"></i>
						</a>
					</div>
				</div>
 				<?php  
 					
 					$machines = Sdba::table('machines');
  					//$machines->where('project_id',$_GET['id']);
  					$total_machines = $machines->total(); 
  					$machines_list = $machines->get();
  					//echo '<pre>';
  					//print_r($machines_list);
  					//echo '</pre>';
  					for ($i=0; $i<$total_machines;$i++){ 
  						$from_type_arr[] = $machines_list[$i]['from_type'];
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
											<th style="text-align: center;">Type</th>
											<th style="text-align: center;">model_id</th>
											<th style="text-align: center;">name</th>
											 
											 
											<th style="text-align: center;">description </th>
											<th style="text-align: center;">created_at </th>
											<th style="text-align: center;">updated_at </th>
											
											 
											<th style="text-align: center;">Options</th>
										</tr>
									</thead>
									<tbody>
									<?php  
  										$machines = Sdba::table('machines');
  										//$machines->where('from_type',$_GET['ft']);
  										//$machines->where('report_id',$_GET['id']);
  										$total_machines = $machines->total();
  										$machines_list = $machines->get();
  										
  										//echo $total_rows;
  										//print_r($reportlist);
  									?>
  									<?php 
  										for ($i=0; $i<$total_machines;$i++){
  											 
  											
  									?>
  										<tr>
											<td style="text-align: center;"><?php echo $machines_list[$i]['id']; ?></td>
											<td style="text-align: center;"><?php echo $machines_list[$i]['type']; ?> </td>
											<td style="text-align: center;"><?php echo chkempty($machines_list[$i]['model_id']); ?></td>
											<td style="text-align: center;"><?php echo chkempty($machines_list[$i]['name']); ?></td>
											 
											 
											<td style="text-align: center;"><?php echo chkempty($machines_list[$i]['description']); ?></td>
											<td style="text-align: center;"><?php echo chkempty($machines_list[$i]['created_at']); ?></td>
											<td style="text-align: center;"><?php echo chkempty($machines_list[$i]['updated_at']); ?></td>
											 
											<td style="text-align: center;"> 
												<a href="?page=machines_edit&id=<?php echo $machines_list[$i]['id']; ?>" class="btn" rel="tooltip" title="" data-original-title="Edit">
													<i class="fa fa-pencil-square-o"></i>
												</a>
												<a href="#del" class="btn del" rel="tooltip" title="" data-original-title="Delete" id='del<?php echo $machines_list[$i]['id']; ?>' style="display:none;">
													<i class="fa fa-times"></i>
												</a>
												 
												 <input name="selpn" type="hidden" id="selpn<?php echo $machines_list[$i]['id']; ?>" value="“<?php echo $machines_list[$i]['name_cn']; ?> / <?php echo $machines_list[$i]['name_en']; ?>”">
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
			var MM_del = "del_machines";
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