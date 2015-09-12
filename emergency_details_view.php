<?php if (!defined('EL_ADMIN')) exit('No direct script access allowed'); ?>
		<div id="main">
			<div class="container-fluid">
				<?php 
				$emergency_details = Sdba::table('emergency_details');
  				$emergency_details->where('report_id',$_GET['id']);
  				$total_emergency_details = $emergency_details->total();
  				$emergency_details_list = $emergency_details->get();
  				
  				$reports = Sdba::table('reports');
  				$reports ->where('id', $_GET['id']);
  				$reports_list = $reports->get();
  				
  				$projects = Sdba::table('projects');
  				$projects ->where('id', $reports_list[0]['project_id']);
  				$projects_list = $projects->get();
  				
  				
				?>
				<div class="page-header">
					<div class="pull-left">
						<h1>Service Report - <?php echo $projects_list[0]['name_en']; ?></h1>
					</div>
					<div class="pull-right">
						 
						<ul class="stats">
							 
							<li class='lightred'>
								<a href='ed_print.php?id=<?php echo $_GET['id']; ?>' target='blank'>
								<i class="fa fa-print"></i>
								<div class="details">
									<span class="big">Print</span>
									<span>移至列印頁面</span>
								</div>
								</a>
							</li>
							
							<li class='green'  >
								<a href='http://uniquecode.net/job/ms/mpdf56/service_report.php?id=<?php echo $_GET['id']; ?>' target='blank'>
								<i class="fa fa-file-pdf-o"></i>
								<div class="details">
									<span class="big">PDF</span>
									<span>以PDF保存</span>
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
							<a href="?page=emergency_details&id=<?php echo $emergency_details_list[0]['report_id']; ?>">Service Report</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a><?php echo $projects_list[0]['name_en']; ?></a>
							 
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
								 
								
								<li class="active">
									<a href="?page=emergency_details_view&id=<?php echo $_GET['id']; ?> ">View</a>
								</li>
								<li>
									<a href="?page=emergency_details&id=<?php echo $_GET['id']; ?> ">Edit</a>
								</li>
								<li >
									<a href="?page=emergency_remark&id=<?php echo $_GET['id']; ?> ">Remark</a>
								</li>
								
							 
							</ul>
						</p>
					</div>
				</div>
				
				<div class="row">
					<div class="col-sm-12">
						<div class="box">
							
							<div class="box-content nopadding"> 
								<table  class="table table-hover table-nomargin dataTable dataTable-tools table-bordered dataTable-colvis  " style="font-size:16px;">
									<tr>
										<td colspan="3" align="center" bgcolor="#ccc"><strong  style="font-size:26px;">SERVICE REPORT (工作報告)</strong></td>
									</tr>
									<tr>
										<td colspan="3"><strong >Customer Name (客戶名稱):　　</strong><?php if( $emergency_details_list[0]['project_name']==""){ echo $projects_list[0]['name_en'];}else{ echo $emergency_details_list[0]['project_name'];} ?></td>
									</tr>
									<tr>
										<td colspan="3" align="center" bgcolor="#EEEEEE">NATURE OF PROBLEM (問題類別)</td>
									</tr>
									<tr>
										<td colspan="3"> 
											<strong >Problem Reported (回報的問題):　　</strong><br>
											<blockquote><?php echo $emergency_details_list[0]['problem_reported']; ?> 
										</td>
									</tr>
									<tr>
										<td colspan="2">
											<strong >System Down (系統停止):　　</strong> 
											<?php if($emergency_details_list[0]['is_system_down']=='true'){ ?>
											<span class='circle'>　Yes　</span>　/　No　
											<?php }else{ ?>
											　Yes　/　<span class='circle'>　 No　</span> 
											<?php } ?>
											<em style="font-size:12px;padding-top: 6px; padding-right: 26px; float:right;">*Please circle</em>
										</td>
										<td><strong >Equipment Type (設備種類):　　</strong><?php if( $emergency_details_list[0]['device_name']==""){ echo $from_type_en[$emergency_details_list[0]['machine_type']];}else{ echo $emergency_details_list[0]['device_name'];} ?> </td>
									</tr>
									<tr>
										<td width='33%'><strong >Power (功率):　　</strong><?php echo $emergency_details_list[0]['power']; ?> </td>
										<td width='33%'><strong >Model (型號):　　</strong><?php echo $emergency_details_list[0]['device_model']; ?></td>
										<td width='34%'><strong >Serial No. (編號):　　</strong><?php echo $emergency_details_list[0]['device_id']; ?></td>
									</tr>
									<tr>
										<td><strong >Call Reported by (匯報部門):　　</strong><?php echo $emergency_details_list[0]['reported_by']; ?></td>
										<td><strong >Date (日期):</strong>　<?php echo date_format(date_create($emergency_details_list[0]['reported_at']),'Y-m-d'); ?>　</td>
										<td><strong >Time (時間):</strong>　<?php echo date_format(date_create($emergency_details_list[0]['reported_at']),'H:i'); ?>　</td>
									</tr>
									<tr>
										<td colspan="3"><strong >Location of Installation (地點):　　</strong><?php echo $emergency_details_list[0]['location']; ?> </td>
									</tr>
									<tr>
										<td colspan="3" align="center" bgcolor="#EEEEEE">REPORT DETAILS  (報告詳細)	</td>
									</tr>
									<tr>
										<td colspan="3"><strong >Defects found on inspection (損毀發現):　　</strong>
										<blockquote><?php echo $emergency_details_list[0]['inspection_found']; ?> 
									</td>
									</tr>
									<tr>
										<td colspan="2"><strong >Engineer's Remarks (工程師備註):　　</strong>
										<?php $result = json_decode($emergency_details_list[0]['situation'],true); ?>
										 <ul><?php for ($i=0; $i<count($result); $i++) { echo '<li>'.$result[$i]['text'].'</li>'; } ?> </ul></td>
										<td><strong >Status after Service (完工後狀態):　　</strong>
										 <br>
											<?php if($emergency_details_list[0]['status_after_service']=='complete'){ ?>
											<span class='circle'>　Complete　</span>　 / 　Incomplete　 / <br>　Pending for spares　 / 　Under Observation　 / <br>　Working solution provided　 
											<?php }elseif($emergency_details_list[0]['status_after_service']=='incomplete'){ ?>
											　Complete　 / 　<span class='circle'>　Incomplete　</span>　 / <br>　Pending for spares　 / 　Under Observation　 / <br>　Working solution provided　 
											<?php }elseif($emergency_details_list[0]['status_after_service']=='pending'){ ?>
											　Complete　 / 　Incomplete　 / 　<br><span class='circle'>　Pending for spares　</span>　 / 　Under Observation　 / <br>　Working solution provided　 
											<?php }elseif($emergency_details_list[0]['status_after_service']=='observation'){ ?>
											　Complete　 / 　Incomplete　 / <br>　Pending for spares　 / 　<span class='circle'>　Under Observation　</span>　 / <br>　Working solution provided　  
											<?php }elseif($emergency_details_list[0]['status_after_service']=='working'){ ?>
											　Complete　 / 　Incomplete　 / <br>　Pending for spares　 / 　Under Observation　 / <br><span class='circle'>　Working solution provided　</span>　  
											<?php } ?>
											<em style="font-size:12px;padding-top: 6px; padding-right: 26px; float:right;">*Please circle</em>
										</td>
									</tr>
									<tr>
										<td colspan="3">&nbsp;</td>
									</tr>
									<tr>
									    <td><strong >Date (日期):</strong>　<?php echo date_format(date_create($emergency_details_list[0]['start_service_at']),'Y-m-d'); ?>　</td> 
										<td ><strong >Start of Service (開始):　　</strong> <?php echo date_format(date_create($emergency_details_list[0]['start_service_at']),'H:i');?></td>
										<td ><strong >End of Service (結束):　　</strong> <?php echo date_format(date_create($emergency_details_list[0]['end_service_at']),'H:i');?></td>
									</tr>
									<tr>
										<td colspan="3" align="center" bgcolor="#EEEEEE">CUSTOMER (客戶)</td>
									</tr>
									<tr>
										<td colspan="3"><strong >Remarks (備註):　　</strong>
										<blockquote><?php if(isset($emergency_details_list[0]['remarks'])&&$emergency_details_list[0]['remarks']!='""'){  echo $emergency_details_list[0]['remarks'];} ?> </td>
									</tr>
									<tr>
										<td><strong >Name (姓名):　　</strong><?php echo $emergency_details_list[0]['contact_name']; ?></td>
										<td><strong >Designation (職位):　　</strong><?php echo $emergency_details_list[0]['designation']; ?></td>
										<td><strong >Phone/Fax (電話/傳真):　　</strong><?php echo $emergency_details_list[0]['phone']; ?> <?php if($emergency_details_list[0]['phone']!=""&&$emergency_details_list[0]['fax']!=""){echo "/";} ?> <?php echo $emergency_details_list[0]['fax']; ?></td>
									</tr>
									<tr>
										<td colspan="3"><strong >Email (電郵):　　</strong><?php echo $emergency_details_list[0]['email']; ?></td>
									</tr>
									<tr>
										<td><strong >Sign (客戸簽名):</strong>
										 </td>
										<td colspan="2"><?php if ($reports_list[0]['signature'] !=''){ ?><img src="upload/<?php echo $reports_list 	[0]['signature']; ?>.png" width="200"><?php }else{ echo '未簽名'; }  ?></td>
									</tr>
									<tr>
										<td colspan="3"><br>
										<input type="hidden" name="key" value="<?php echo htmlspecialchars($_SESSION["key"], ENT_QUOTES);?>">
										<a href='?page=emergency_details&id=<?php echo $_GET["id"]; ?>' class="btn btn-primary" style="width:120px;">Edit (編輯)</a>
										 
										</td>
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
                                		<option value="true">Normal (正常)</option>
                                		<option value="false">Abnormal (不正常)</option>
                                		<option value="2">Repaired (已修復)</option>
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
						if (selectstr == 'true'){
				   			$("#"+tdnew).html('<i class="glyphicon-ok_2"></i>');
				   		}else if (selectstr == 'false'){
				   			$("#"+tdnew).html('<i class="glyphicon-remove_2"></i>');
				   		}else{
				   			$("#"+tdnew).html('<i class="fa fa-circle-o"></i>');
				   		}
				   	}else{
				   		//alert(tdnew);
				   		var inputstr = $('#new_value').val();
				   		$("#"+tdnew).text(inputstr);
				   		
					}
					$("#editsbox").hide();
				}
			});
	   });
	   
	   
	
	});
	</script>