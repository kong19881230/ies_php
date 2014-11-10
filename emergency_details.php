<?php if (!defined('EL_ADMIN')) exit('No direct script access allowed'); ?>
<?php  
 if(isset($_SESSION["key"], $_POST["key"]) && $_SESSION["key"] == $finalkey){
 	 
		$finalcycle_types = json_encode($_POST['cycle_types']);
		$finalmachine_types = json_encode($_POST['machine_types']);
		//print_r($finalcycle_types);
		
		$ud_emergency_details = Sdba::table('emergency_details');
		$ud_emergency_details ->where('report_id', $_GET['id']);
		$data = array(
			'problem_reported'=> $finalproblem_reported,
			'is_system_down'=>$finalis_system_down,
			'reported_by'=> $finalreported_by,
			'device_model'=> $finaldevice_model,
			'device_id'=> $finaldevice_id,
			'power'=> $finalpower,
			'machine_type'=> $finalmachine_type,
			'location'=> $finallocation,
			'engineer_remarks'=> $finalengineer_remarks,
			'inspection_found'=> $finalinspection_found,
			'status_after_service'=> $finalstatus_after_service,
			'remarks'=> $finalremarks,
			'contact_name'=> $finalcontact_name,
			'designation'=> $finaldesignation,
			'signature'=> $finalsignature,
			'phone'=> $finalphone,
			'fax'=> $finalfax,
			'email'=>$finalemail 
		);
		$ud_emergency_details ->update($data);
		unset($_SESSION["key"]);
		$_SESSION["key"] = md5(uniqid().mt_rand());				
		?>
<script>
window.location = './?page=emergency_details_view&id=<?php echo $_GET["id"]; ?>';
</script>
		<?php								 
 }else{
 	$_SESSION["key"] = md5(uniqid().mt_rand());
 }
 ?>
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
						
					</div>
				</div>
				
				<div class="row">
					<div class="col-sm-12">
						<div class="box">
							
							<div class="box-content nopadding"> 
							<form action="?page=emergency_details&id=<?php echo $_GET['id']; ?>" method="POST" enctype="multipart/form-data" class='form-horizontal form-bordered'>
								<table  class="table table-hover table-nomargin dataTable dataTable-tools table-bordered dataTable-colvis  " style="font-size:16px;">
									<tr>
										<td colspan="3" align="center" bgcolor="#ccc"><strong  style="font-size:26px;">SERVICE REPORT (工作報告)</strong></td>
									</tr>
									<tr>
										<td colspan="3"><strong >Customer Name:　　</strong><?php echo $projects_list[0]['name_en']; ?></td>
									</tr>
									<tr>
										<td colspan="3" align="center" bgcolor="#EEEEEE">NATURE OF PROBLEM (問題類別)</td>
									</tr>
									<tr>
										<td colspan="3"> 
											<strong >Problem Reported:　　</strong><br>
											<blockquote><textarea id='show_textarea' name='problem_reported' class="form-control " placeholder="<?php echo $emergency_details_list[0]['problem_reported']; ?>" rows="4"><?php echo $emergency_details_list[0]['problem_reported']; ?></textarea>  
										</td>
									</tr>
									<tr>
										<td colspan="2">
											<strong style="float:left;">System Down (系統停止):　　</strong> 
											
											<select class="form-control input-sm" style="width:120px; float:left;" name='is_system_down'>
                                				<option value="true" <?php if($emergency_details_list[0]['is_system_down']=='true'){ echo 'selected'; } ?> >Yes</option>
                                				<option value="false" <?php if($emergency_details_list[0]['is_system_down']=='false'){ echo 'selected';}  ?> >No</option>
                                			</select>
											
											<em style="font-size:12px;padding-top: 6px; padding-right: 26px; float:right;">*Please select</em>
										</td>
										<td><strong style="float:left;">Equipment Type (設備種類):　　</strong>
											<select class="form-control input-sm" style="width:120px; float:left;" name='machine_type'>
												<?php foreach ($from_type as $key => $value) { ?>
                                				<option value="<?php echo $key; ?>" <?php if($emergency_details_list[0]['machine_type']==$key){ echo 'selected'; } ?> ><?php echo $key; ?></option>
                                				<?php } ?>		
                                			</select>
										
										 </td>
									</tr>
									<tr>
										<td width='33%'><strong >Power (功率):　　</strong><input type="text" name='power' class="form-control" style="padding-right: 24px; " id="new_value" placeholder="<?php echo $emergency_details_list[0]['power']; ?>" value="<?php echo $emergency_details_list[0]['power']; ?>"> </td>
										<td width='33%'><strong >Model (型號):　　</strong><input type="text" name='device_model'  class="form-control" style="padding-right: 24px; " id="new_value" placeholder="<?php echo $emergency_details_list[0]['device_model']; ?>" value="<?php echo $emergency_details_list[0]['device_model']; ?>"></td>
										<td width='34%'><strong >Serial No. (編號):　　</strong><input type="text" name='device_id'  class="form-control" style="padding-right: 24px; " id="new_value" placeholder="<?php echo $emergency_details_list[0]['device_id']; ?>" value="<?php echo $emergency_details_list[0]['device_id']; ?>"></td>
									</tr>
									<tr>
										<td><strong >Call Reported by (匯報部門):　　</strong><input type="text" name='reported_by'  class="form-control" style="padding-right: 24px; " id="new_value" placeholder="<?php echo $emergency_details_list[0]['reported_by']; ?>" value="<?php echo $emergency_details_list[0]['reported_by']; ?>"></td>
										<td><strong >Date (日期):　　</strong></td>
										<td><strong >Time (時間):　　</strong></td>
									</tr>
									<tr>
										<td colspan="3"><strong >Location of Installation (地點):　　</strong><input type="text" name='location'  class="form-control" style="padding-right: 24px; " id="new_value" placeholder="<?php echo $emergency_details_list[0]['location']; ?>" value="<?php echo $emergency_details_list[0]['location']; ?>"> </td>
									</tr>
									<tr>
										<td colspan="3" align="center" bgcolor="#EEEEEE">REPORT DETAILS</td>
									</tr>
									<tr>
										<td colspan="3"><strong >Defects found on inspection (損毀發現):　　</strong>
										<blockquote><textarea id='show_textarea' name='inspection_found' class="form-control " placeholder="<?php echo $emergency_details_list[0]['inspection_found']; ?>" rows="3"><?php echo $emergency_details_list[0]['inspection_found']; ?> </textarea>
									</td>
									</tr>
									<tr>
										<td colspan="2"><strong >Engineer's Remarks (工程師備註):　　</strong>
										<blockquote><textarea id='show_textarea' name='engineer_remarks'  class="form-control " placeholder="<?php echo $emergency_details_list[0]['engineer_remarks']; ?>" rows="2"><?php echo $emergency_details_list[0]['engineer_remarks']; ?></textarea>
										 </td>
										<td><strong >Status after Service (完工後狀態):　　</strong>
										 <br>
										 	<select class="form-control input-sm" style=" "  name='status_after_service'>
                                				<option value="complete" <?php if($emergency_details_list[0]['status_after_service']=='complete'){ echo 'selected'; } ?> >Complete</option>
                                				<option value="incomplete" <?php if($emergency_details_list[0]['status_after_service']=='incomplete'){ echo 'selected';}  ?> >Incomplete</option>
                                				<option value="pending" <?php if($emergency_details_list[0]['status_after_service']=='pending'){ echo 'selected';}  ?> >Pending for spares</option>
                                				<option value="observation" <?php if($emergency_details_list[0]['status_after_service']=='observation'){ echo 'selected';}  ?> >Under Observation</option>
                                				<option value="working" <?php if($emergency_details_list[0]['status_after_service']=='working'){ echo 'selected';}  ?> >Working solution provided</option>
                                			</select>
											 
											<em style="font-size:12px;padding-top: 6px; padding-right: 26px; float:right;">*Please select</em>
										</td>
									</tr>
									<tr>
										<td colspan="3">&nbsp;</td>
									</tr>
									<tr>
										<td><strong >Events:　　</strong></td>
										<td><strong >Start of Service (開始):　　</strong></td>
										<td><strong >End of Service (結束):　　</strong></td>
									</tr>
									<tr>
										<td colspan="3" align="center" bgcolor="#EEEEEE">CUSTOMER (客戶)</td>
									</tr>
									<tr>
										<td colspan="3"><strong >Remarks (備註):　　</strong>
										<blockquote><textarea id='show_textarea'  name='remarks' class="form-control " placeholder="<?php echo $emergency_details_list[0]['remarks']; ?>" rows="2"><?php echo $emergency_details_list[0]['remarks']; ?></textarea> </td>
									</tr>
									<tr>
										<td><strong >Name:　　</strong><input type="text" name='contact_name' class="form-control" style="padding-right: 24px; " id="new_value" placeholder="<?php echo $emergency_details_list[0]['contact_name']; ?>" value="<?php echo $emergency_details_list[0]['contact_name']; ?>"></td>
										<td><strong >Designation:　　</strong><input type="text" name='designation' class="form-control" style="padding-right: 24px; " id="new_value" placeholder="<?php echo $emergency_details_list[0]['designation']; ?>" value="<?php echo $emergency_details_list[0]['designation']; ?>"></td>
										<td><strong >Phone/Fax:　　</strong><input type="text" name='phone' class="form-control" style="padding-right: 24px; " id="new_value" placeholder="<?php echo $emergency_details_list[0]['phone']; ?>" value="<?php echo $emergency_details_list[0]['phone']; ?>"></td>
									</tr>
									<tr>
										<td colspan="2"><strong >Email:　　</strong><input type="text" name='email'  class="form-control" style="padding-right: 24px; " id="new_value" placeholder="<?php echo $emergency_details_list[0]['email']; ?>" value="<?php echo $emergency_details_list[0]['email']; ?>"></td>
										<td><strong >Fax:　　</strong><input type="text" name='fax' class="form-control" style="padding-right: 24px; " id="new_value" placeholder="<?php echo $emergency_details_list[0]['fax']; ?>" value="<?php echo $emergency_details_list[0]['fax']; ?>"></td>
									</tr>
									<tr>
										<td colspan="3"><br>
										<input type="hidden" name="key" value="<?php echo  $_SESSION["key"];?>">
										<button type="submit" class="btn btn-primary">Save changes</button>
										<a type="button" class="btn" href="?page=emergency_details_view&id=<?php echo $_GET["id"]; ?>">Cancel</a>
										</td>
									</tr>
								</table>
								 </form> 
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
                                    <textarea id='show_textarea' class="form-control input-large" placeholder="Your comments here..." rows="7"></textarea>
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
		$('.edits').click(function() {
		//alert('x');
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
		   }else if (date_type=='textarea'){
		   		$("#bool").hide();
		   		$("#new_value").hide();
		   		$("#show_textarea").show();
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