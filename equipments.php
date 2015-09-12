<?php if (!defined('EL_ADMIN')) exit('No direct script access allowed'); ?>
 		<div id="main">
			<div class="container-fluid">
				<div class="page-header">
					<div class="pull-left">
						<h1>Equipments</h1>
					</div>
					<div class="pull-right">
						 
						<ul class="stats">
							<li class='blue'><a href='?page=equipments_add&id=<?php echo $_GET["id"]; ?>'>
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
							<a href="?page=projects">Projects</a>
							 <i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="?page=equipments">equipments</a>
							 
						</li>
						 
						 
					</ul>
					<div class="close-bread">
						<a href="#">
							<i class="fa fa-times"></i>
						</a>
					</div>
				</div>
 				<?php  
 					
 					$equipments = Sdba::table('equipments');
  					$equipments->where('project_id',$_GET['id']);
  					$total_equipments = $equipments->total(); 
  					$equipments_list = $equipments->get();
  					//echo '<pre>';
  					//print_r($equipments_list);
  					//echo '</pre>';
  					for ($i=0; $i<$total_equipments;$i++){ 
  						$from_type_arr[] = $equipments_list[$i]['from_type'];
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
											<th style="text-align: center;">Phone num</th>
											<th style="text-align: center;">ref_no</th>
											 
											<th style="text-align: center;  ">Model ID</th>
											<th style="text-align: center;  ">type</th>
											 
											<th style="text-align: center;">Photo </th>
											 
											 
											
											 
											<th style="text-align: center;">Options</th>
										</tr>
									</thead>
									<tbody>
									<?php  
  										$equipments = Sdba::table('equipments');
  										//$equipments->where('from_type',$_GET['ft']);
  										//$equipments->where('report_id',$_GET['id']);
  										$total_equipments = $equipments->total();
  										$equipments_list = $equipments->get();
  										
  										//echo $total_rows;
  										//print_r($reportlist);
  									?>
  									<?php 
  										for ($i=0; $i<$total_equipments;$i++){
  											 
  											
  									?>
  										<tr>
											<td style="text-align: center;"><?php echo $equipments_list[$i]['id']; ?></td>
											<td style="text-align: center;"><?php echo $equipments_list[$i]['phone_num']; ?> </td>
											<td style="text-align: center;"><?php echo chkempty($equipments_list[$i]['ref_no']); ?></td>
											 
											<td style="text-align: center;"><?php echo chkempty($equipments_list[$i]['model_id']); ?></td>
											<td style="text-align: center;"><?php echo $from_type[$equipments_list[$i]['type']]; ?></td>
											 
											<td style="text-align: center;"><img src="photo/equipment/<?php echo $equipments_list[$i]['photo']; ?>" width="120px" ></td>
											 
											 
											<td style="text-align: center;"> 
												<a href="?page=equipments_edit&id=<?php echo $equipments_list[$i]['id']; ?>" class="btn" rel="tooltip" title="" data-original-title="Edit">
													<i class="fa fa-pencil-square-o"></i>
												</a>
												 <a href="#copy" class="btn copy" rel="tooltip" title="" data-original-title="Copy" id='copy<?php echo $equipments_list[$i]['id']; ?>'  >
													<i class="fa fa-files-o"></i>
												</a>
												<a href="#del" class="btn del" rel="tooltip" title="" data-original-title="Delete" id='del<?php echo $equipments_list[$i]['id']; ?>'  >
													<i class="fa fa-trash-o"></i>
												</a>
												
												 <input name="selpn" type="hidden" id="selpn<?php echo $equipments_list[$i]['id']; ?>" value="“<?php echo $equipments_list[$i]['ref_no']; ?>”">
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
	
		//确认删除
		$('.copy').click(function(){
			var poid= $(this).attr('id');
			poid = poid.slice(4);
			//var pn= $('#selpn'+poid).val();
			
			var MM_copy = "copy_equipments";

			var dataString =  'id='+ poid +'&MM_copy='+ MM_copy ;	
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
						//alert("複製成功");
						location.reload();
					}else{
						alert("複製錯誤\n \n /"+text+"/");
						$('#delmsg').hide();
						$('#overlay').fadeOut('fast');
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
			var MM_del = "del_equipments";
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