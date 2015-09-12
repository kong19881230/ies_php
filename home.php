 
		<div id="main">
			<div class="container-fluid">
				<div class="page-header">
					<div class="pull-left">
						<h1>Reports</h1>
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
				<div class="breadcrumbs">
					<ul>
						<li>
							<a href="index.php">Home</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a>Reports</a>
							 
						</li>
						 
					</ul>
					<div class="close-bread">
						<a href="#">
							<i class="fa fa-times"></i>
						</a>
					</div>
				</div>
 
				 <hr>
				<div class="row" id='PDFtoPrint'>
					<div class="col-sm-12">
						<div class="box">
							
							<div class="box-content nopadding"> 
								<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered dataTable-colvis  " id='homes'  >
									<thead>
										<tr>
											<td style="display:none;"> </td>
											<th>Name</th>
											<th>Type</th>
											<th class='hidden-350'>Cycle type</th>
											<th class='hidden-1024'>Created by</th>
											<th class='hidden-480'>Created at</th>
											<th class='hidden-480'>updated at</th>
											<th class='hidden-480'>Customer</th>
											<th class='hidden-480'>Options</th>
										</tr>
									</thead>
									<tbody>
									<?php  
										
										
  										$reports = Sdba::table('reports');
  										$reports->where('state',1);
  										if (isset($_GET['type'])){
											$reports->and_where('type',$_GET['type']);

										}
  										$total_reports = $reports->total();
  										$reports_list = $reports->get();
  										
  										//echo $total_rows;
  										//print_r($reportlist);
  									?>
  									<?php 
  										for ($i=0; $i<$total_reports;$i++){
  											$customers = Sdba::table('projects');
  											$customers->where('id',$reports_list[$i]['project_id']);
  											//$sa1->where('status',0);
  											//$total_report = $report->total();
  											$customers_list = $customers->get();
  											
  											$maintain_froms = Sdba::table('maintain_froms');
  											$maintain_froms->where('report_id',$reports_list[$i]['id']);
  											$total_maintain_froms = $maintain_froms->total(); 
  											$maintain_froms_list = $maintain_froms->get();
  									?>
  										<tr>
  											<td style="display:none;"><?php echo $reports_list[$i]['updated_at']; ?></td>
											<td><?php echo $reports_list[$i]['name_en']; ?><br><?php echo $reports_list[$i]['name_cn']; ?></td>
											<td><?php echo $reports_type[$reports_list[$i]['type']]; ?></td>
											<td><?php echo $reports_cycles_cn[$reports_list[$i]['cycle_type']].'<br>'.$reports_cycles_en[$reports_list[$i]['cycle_type']]; ?></td>
											<td><?php echo $maintain_froms_list[0]['maintenance_technician']; ?></td>
											<td><?php echo $reports_list[$i]['created_at']; ?></td>
											<td><?php echo $reports_list[$i]['updated_at']; ?></td>
											<td><?php echo $customers_list[0]['name_cn']; ?><br><?php echo $customers_list[0]['name_en']; ?></td>
											<td><a href="<?php echo $reports_type_link[$reports_list[$i]['type']] ?>&id=<?php echo $reports_list[$i]['id']; ?>" class="btn" rel="tooltip" title="" data-original-title="View">
													<i class="fa fa-search"></i>
												</a>
												<a href="#del" class="btn del" rel="tooltip" title="" data-original-title="Delete" id='del<?php echo $reports_list[$i]['id']; ?>'  >
													<i class="fa fa-trash-o"></i>
												</a>
												 <input name="selpn" type="hidden" id="selpn<?php echo $reports_list[$i]['id']; ?>" value="“<?php echo $reports_list[$i]['name_cn']; ?>”">
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
			var MM_del = "del_reports";
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