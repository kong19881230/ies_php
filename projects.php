<?php if (!defined('EL_ADMIN')) exit('No direct script access allowed'); ?>
 		<div id="main">
			<div class="container-fluid">
				<div class="page-header">
					<div class="pull-left">
						<h1>Projects</h1>
					</div>
					<div class="pull-right">
						 
						<ul class="stats">
							<li class='blue'><a href='?page=projects_add'>
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
							 
						</li>
						 
						 
					</ul>
					<div class="close-bread">
						<a href="#">
							<i class="fa fa-times"></i>
						</a>
					</div>
				</div>
 				<?php  
 					
 					$projects = Sdba::table('projects');
  					//$projects->where('report_id',$_GET['id']);
  					$total_projects = $projects->total(); 
  					$projects_list = $projects->get();
  					//echo '<pre>';
  					//print_r($projects_list);
  					//echo '</pre>';
  					for ($i=0; $i<$total_projects;$i++){ 
  						$from_type_arr[] = $projects_list[$i]['from_type'];
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
											<th style="text-align: center;">項目名稱</th>
											<th style="text-align: center;">編號</th>
											<th style="text-align: center;">合約期限</th>
											 
											 
											<th style="text-align: center;">保養內容 </th>
											 
											<th style="text-align: center;">聯絡人/聯絡電話</th>
											 
											 
											
											 
											<th style="text-align: center;">Options</th>
										</tr>
									</thead>
									<tbody>
									<?php  
  										$projects = Sdba::table('projects');
  										//$projects->where('from_type',$_GET['ft']);
  										//$projects->where('report_id',$_GET['id']);
  										$total_projects = $projects->total();
  										$projects_list = $projects->get();
  										
  										//echo $total_rows;
  										//print_r($reportlist);
  									?>
  									<?php 
  										for ($i=0; $i<$total_projects;$i++){
  											 
  											
  									?>
  										<tr>
											<td style="text-align: center;"><?php echo $projects_list[$i]['id']; ?></td>
											<td style="text-align: center;"><?php echo $projects_list[$i]['name_cn']; ?><br><?php echo $projects_list[$i]['name_en']; ?></td>
											<td style="text-align: center;"><?php echo chkempty($projects_list[$i]['seq']); ?></td>
											<td style="text-align: center;"><?php echo chkempty($projects_list[$i]['con_start_date']); ?><br><?php echo chkempty($projects_list[$i]['con_espr_date']); ?></td>
											 
											 
											<td style="text-align: center;"><?php echo chkempty($projects_list[$i]['maintain_type']); ?></td>
											 
											
											<td style="text-align: center;"><?php echo chkempty($projects_list[$i]['contact_person']); ?><br><?php echo chkempty($projects_list[$i]['contact_phone']); ?></td>
										 
											 
											
											 
											<td style="text-align: center;"><a href="?page=projects_view&id=<?php echo $projects_list[$i]['id']; ?>" class="btn" rel="tooltip" title="" data-original-title="View">
													<i class="fa fa-search"></i>
												</a>
												<a href="?page=projects_edit&id=<?php echo $projects_list[$i]['id']; ?>" class="btn" rel="tooltip" title="" data-original-title="Edit">
													<i class="fa fa-pencil-square-o"></i>
												</a>
												<a href="#del" class="btn del" rel="tooltip" title="" data-original-title="Delete" id='del<?php echo $projects_list[$i]['id']; ?>' style="display:none;">
													<i class="fa fa-times"></i>
												</a>
												<a href="?page=maintain_item_set&id=<?php echo $projects_list[$i]['id']; ?>" class="btn" rel="tooltip" title="" data-original-title="管理報告項目">
													管理報告項目
												</a>
												<a href="?page=equipments&id=<?php echo $projects_list[$i]['id']; ?>" class="btn" rel="tooltip" title="" data-original-title="Equipement">
													管理設備
												</a>
												 <input name="selpn" type="hidden" id="selpn<?php echo $projects_list[$i]['id']; ?>" value="“<?php echo $projects_list[$i]['name_cn']; ?> / <?php echo $projects_list[$i]['name_en']; ?>”">
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
			var MM_del = "del_projects";
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