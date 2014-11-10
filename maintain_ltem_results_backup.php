<?php if (!defined('EL_ADMIN')) exit('No direct script access allowed'); ?>
		<div id="main">
			<div class="container-fluid">
				<?php 
				$maintain_froms = Sdba::table('maintain_froms');
  				$maintain_froms->where('id',$_GET['id']);
  				$total_maintain_froms = $maintain_froms->total();
  				$maintain_froms_list = $maintain_froms->get();
  				
  				$reports = Sdba::table('reports');
  				$reports ->where('id', $maintain_froms_list[0]['report_id']);
  				$reports_list = $reports->get();
				?>
				<div class="page-header">
					<div class="pull-left">
						<h1 style="line-height: 32px;"><?php echo $reports_list[0]['name_cn']; ?><br><?php  $type=$maintain_froms_list[0]['from_type']; echo $maintain_froms_list[0]['from_type'].' System ('.$from_type[$type].'系統)'; ?></h1>
					</div>
					<div class="pull-right">
						 
						<ul class="stats">
							 
							<li class='lightred'>
								<a href='mfr_print.php?id=<?php echo $maintain_froms_list[0]['id']; ?>' target='blank'>
								<i class="fa fa-print"></i>
								<div class="details">
									<span class="big">Print preview</span>
									<span>移至列印頁面</span>
								</div>
								</a>
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
							<a href="?page=home">Reports</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="?page=maintain_froms&id=<?php echo $maintain_froms_list[0]['report_id']; ?>"><?php echo $reports_list[0]['name_en']; ?></a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a><?php echo $type; ?></a>
							 
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
						<h6>　</h6>
						<p>
							<ul class="nav nav-tabs">
								 
								
								<li  class="active">
									<a href="?page=maintain_ltem_results_backup&id=<?php echo $_GET['id']; ?> ">Original</a>
								</li>
								<li>
									<a href="?page=maintain_ltem_results&id=<?php echo $_GET['id']; ?> ">Edit</a>
								</li>
								<li >
									<a href="?page=maintain_remark&id=<?php echo $_GET['id']; ?> ">Remark</a>
								</li>
								<li >
									<a href="?page=photo_report_view&id=<?php echo $_GET['id']; ?> ">Photo Report</a>
								</li> 
							 
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
											<th colspan="2" style="text-align: center" width='70%'><?php echo $reports_cycles_cn[$reports_list[0]['cycle_type']]; ?>服務<br><?php echo $reports_cycles_en[$reports_list[0]['cycle_type']]; ?> Service</th>
											 
											<th colspan="2" style="text-align: center" width='30%'><?php echo $maintain_froms_list[0]['device_id'].'<br>'.$maintain_froms_list[0]['device_model']; ?></th>
											 
										</tr>
									</thead>
									<tbody>
									<?php  
  										$maintain_item_results = Sdba::table('maintain_item_results');
  										//$maintain_item_results->where('from_type','heat');
  										$maintain_item_results->where('maintain_from_id',$_GET['id']);
  										$maintain_item_results->sort_by('maintain_from_id');
  										$total_maintain_item_results = $maintain_item_results->total();
  										$maintain_item_results_list = $maintain_item_results->get();
  										
  										//echo $total_rows;
  										print_r($reportlist);
  									?>
  									<?php 
  										for ($i=0; $i<$total_maintain_item_results;$i++){
  											 $result = json_decode($maintain_item_results_list[$i]['result'],true);
  											
  									?>
  										<tr>
											<td style="vertical-align: middle;" align="center"><?php echo $maintain_item_results_list[$i]['index']; ?></td>
											<td style="vertical-align: middle;" <?php if ($result['type']=='none'){echo 'colspan="3"';} ?>><?php echo $maintain_item_results_list[$i]['item_name_cn']; ?><br><?php echo $maintain_item_results_list[$i]['item_name_en']; ?></td>
											<input name="tdresult" id="new<?php echo $maintain_item_results_list[$i]['id']; ?>result" type="hidden" value="<?php echo $maintain_item_results_list[$i]['result']; ?>">
											<?php 
											$bool_normal = '<td style="vertical-align: middle;" colspan="2" align="center">
															 <i class="glyphicon-ok_2"></i> 
													  	  </td>';
											$bool_wait = '<td style="vertical-align: middle;" colspan="2" align="center">
														 <strong>△</strong> 
													  </td>';
													  
											$bool_repaired = '<td style="vertical-align: middle;" colspan="2" align="center">
														 <i class="fa fa-circle-o"></i> 
													  </td>';
											$bool_null = '<td style="vertical-align: middle;background: yellow;" colspan="2" align="center" id="trnew'.$maintain_item_results_list[$i]['id'].'">
														 未檢查<br>Unchecked
													  </td>';
											
											if ($result['type']=='bool'){  
												if ($result['value']=='normal'){ 
													echo $bool_normal;	
												}elseif ($result['value']=='wait'){
													echo $bool_wait;	
												}elseif ($result['value']=='repaired'){
													echo $bool_repaired;	
												}elseif ($result['value']=='false'){
													echo $bool_null;	
												} 
											}elseif ($result['type']=='s_value'){ //echo u8encode($result['unit'][0]);
												 
													echo '<td style="vertical-align: middle;" colspan="2" align="center"> '.chkempty($result['value']) .$result['unit'].'<br>('.$result['hint'] .')</td>';	
												
											}elseif ($result['type']=='d_value'){
												 
													echo '<td style="vertical-align: middle;" align="center"> '.chkempty($result['value'][0]). $result['unit'][0].'<br>('.$result['hint'][0].')</td>';
													echo '<td style="vertical-align: middle;" align="center"> '.chkempty($result['value'][1]). $result['unit'][1].'<br>('.$result['hint'][1].')</td>';		
												 
											} 
												
											 
											?>
										</tr>
									<?php } ?>
									</tbody>
								</table>
								<table width="850" border="0" cellpadding="0" cellspacing="0" class="table table-hover  table-bordered ">
									<tr>
										<td colspan="1" width="200">Remarks:<br />
										備註</td>
										<td colspan="4"> <?php echo $maintain_froms_list[0]['Inspector_remark']; ?> </td>
									</tr>
									<tr>
										<td  >Maintenance Technican: <br />
										保養技術員 </td>
										<td ><?php echo $maintain_froms_list[0]['maintenance_technician']; ?></td>
										<td width="20"></td>
										<td  >Maintenance Date &amp; Time: <br />
										保養日期及時間</td>
										<td  ><?php echo $maintain_froms_list[0]['maintenance_datetime']; ?> </td>
									</tr>
									<tr>
										<td  >Inspector:<br />
										檢查人員 </td>
										<td  > <?php echo $maintain_froms_list[0]['inspector']; ?> ></td>
										<td width="20"></td>
										<td width="200">Inspection Date &amp;   Time:<br />
										檢查日期及時間</td>
										<td> <?php echo $maintain_froms_list[0]['inspector_datetime']; ?> </td>
									</tr>
									 
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

<div class="popover fade in editable-container top" style="display: none;" id="editsbox">
    	<div class="arrow"></div>
        <h3 class="popover-title">Enter username</h3>
        <div class="popover-content"> 
            <div>
                <div class="editableform-loading" style="display: none;"></div>
                   	 <div class="form-inline editableform" >
                        <div class="control-group">
                            <div>
                                <div class="editable-input" style="position: relative;">
                                	<select class="form-control input-sm" id='bool'>
                                		<option value="normal">Normal (正常)</option>
                                		<option value="wait">Pending (待處理)</option>
                                		<option value="repaired">Repaired (已修復)</option>
                                	</select>
                                    <input type="text" class="input-medium mask_yarn" style="padding-right: 24px; display:none;" id="new_value" placeholder=" ">
                                    <input name="tdnew" id="tdnew" type="hidden" value="">
                                    <input name="tdresult" id="tdresult" type="hidden" value="">
                                    <span class="editable-clear-x" style="bottom: 8.5px; right: 8.5px;"></span>
                                </div>
                                <div class="editable-buttons">
                                    <button type="button" class="btn btn-primary editable-submit" id="editable-submit">
                                        <i class="glyphicon-ok_2"></i>
                                    </button>
                                    <button type="button" class="btn editable-cancel">
                                        <i class="glyphicon-remove_2"></i>
                                    </button>
                                    
                                </div>
                            </div>
                            
                            <div class="editable-error-block help-block" style="display: none;"></div>
                        </div>
					</div>
				</div>
			</div>
		</div>
<script src="js/jquery.min.js"></script>
<script type="text/javascript">
	//JQuery 実装
	$(document).ready(function(){
		$('.edits').click(function() {
		
		   var str = $(this).attr("id");
		   var title = $(this).attr("data-original-title");
		   var date_type = $(this).attr("data-type");
		   var position = $('#'+str).offset(); 
		   var newresult = $("#"+str+'result').val();
		   var x = position.left; 
		   var y = position.top; 
		   y -= 89;x -= 120;
		   //alert('x:'+x+', y:'+y);
		   //alert(str);
		   if (date_type=='select'){
		   		$("#bool").show();
		   		$("#new_value").hide();
		   }else{
		   		$("#bool").hide();
		   		$("#new_value").show();
		   }
		   $("#tdnew").val(str);
		   $("#tdresult").val(newresult);
		   $("#weight").val("");
		   $(".popover-title").text(title);
		   $("#editsbox").css({position: "absolute",  top: y, left: x});
		   
		   $("#editsbox").show();
		   $("#new_value").focus();
		   
	   }); 
	   $('.editable-cancel').click(function() {
		   $("#editsbox").hide();
	   });
	   
	   $('#editable-submit').click(function() {		   
		   var tdnew = $("#tdnew").val();
		   var dtype = $("#"+tdnew).attr("data-type");
		   if (dtype=='select'){
				var newval1 = $('#bool').val();
				var newval2 = '';
				var newid = tdnew.slice(3);
				
		  }else{
		  		var s_d = tdnew.substr(0,1);
		  		var ids = tdnew.substr(1);
		  		var newid = tdnew.slice(4);
		  		//alert(newid);
		  		if (s_d==0){
					var newval1 = $("#new_value").val();
					var newval2 = $("#1"+ids).text();
				}else{
					var newval2 = $("#new_value").val();
					var newval1 = $("#0"+ids).text();
				}
				//alert(newval1);
				 
		  }
		   
		   
		    
		   //alert(newid);
		   var MM_update = "save_new_maintain_item_result";
		   var dataString = 'id='+ newid + '&newval1='+ newval1  + '&newval2='+ newval2   +'&MM_update='+ MM_update;
			//alert(dataString+"/");
			$.ajax({
				type: "POST",
				url: "edit_data.php",
				data: dataString,
				cache: false,
				success: function(html)
				{
				   
				   var tdnew = $("#tdnew").val();
				   var dtype = $("#"+tdnew).attr("data-type");
				   //alert('xxx'+tdnew);
					if (dtype=='select'){
						var selectstr = $('#bool').val();
						//alert('xx'+selectstr);
						if (selectstr == 'normal'){
				   			$("#"+tdnew).html('<i class="glyphicon-ok_2"></i>');
				   		}else if (selectstr == 'wait'){
				   			$("#"+tdnew).html('<strong>△</strong>');
				   		}else{
				   			$("#"+tdnew).html('<i class="fa fa-circle-o"></i>');
				   		}
				   		$("#tr"+tdnew).css("background-color","white");
				   	}else{
				   		//alert(tdnew);
				   		var inputstr = $('#new_value').val();
				   		$("#"+tdnew).text(inputstr);
				   		
					}
					$("#editsbox").hide();
				}
			});
	   });
	   
	   $('#save_from').click(function() {
	   		var thisid = $('#thisid').val();
		    var remark = $('#from_remarks').val();
		    var form_m = $('#form_m').val();
			var form_md = $('#form_md').val();
		    var form_inspection = $('#form_inspection').val();
			var form_inspection_date = $('#form_inspection_date').val();
		   //alert(newid);
		   var MM_update = "update_maintain_form";
		   var dataString = 'id='+ thisid + '&Inspector_remark='+ remark + '&maintenance_technician='+ form_m + '&maintenance_datetime='+ form_md + '&inspector='+ form_inspection  + '&inspector_datetime='+form_inspection_date +'&MM_update='+ MM_update;
			//alert(dataString+"/");
			
			$.ajax({
				type: "POST",
				url: "edit_data.php",
				data: dataString,
				cache: false,
				success: function(html)
				{
					//alert(html);
				   if (html=='ok'){
				   		alert('存儲成功');
				   }
				    
				}
			});
			
	   });
	   
	
	});
	</script>