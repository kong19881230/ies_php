<?php if (!defined('EL_ADMIN')) exit('No direct script access allowed'); ?>
		<div id="main">
			<div class="container-fluid">
				<?php 
				$emergency_details = Sdba::table('emergency_details');
  				$emergency_details->where('report_id',$_GET['id']);
  				$total_emergency_details = $emergency_details->total();
  				$emergency_details_list = $emergency_details->get();
  				
  				$maintain_froms = Sdba::table('maintain_froms');
  				$maintain_froms->where('id',$_GET['id']);
  				$total_maintain_froms = $maintain_froms->total();
  				$maintain_froms_list = $maintain_froms->get();
  				
  				$reports = Sdba::table('reports');
  				$reports ->where('id', $maintain_froms_list[0]['report_id']);
  				$reports_list = $reports->get();
  				
  				$projects = Sdba::table('projects');
  				$projects ->where('id', $reports_list[0]['project_id']);
  				$projects_list = $projects->get();
  				
  				
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
								 
								
								<li >
									<a href="?page=maintain_ltem_results_backup&id=<?php echo $_GET['id']; ?> ">Original</a>
								</li>
								<li>
									<a href="?page=maintain_ltem_results&id=<?php echo $_GET['id']; ?> ">Edit</a>
								</li>
								<li>
									<a href="?page=maintain_remark&id=<?php echo $_GET['id']; ?> ">Remark</a>
								</li>
								<li class="active">
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
								<?php $part=0;
									if (like_photo($_GET['id'].'-b') > 0) { $td=0; $part++;
								?>
								<table  class="table table-hover table-nomargin dataTable dataTable-tools table-bordered dataTable-colvis  " style="font-size:16px;">
									<tr>
										<td colspan="2" align="center" bgcolor="#ccc"><strong  style="font-size:26px;">Part<?php echo $part; ?>: (清潔鍋爐內部件)</strong></td>
									</tr>
									 
									<tr>
										<?php if (is_photo($_GET['id'].'-b0') > 0) { $td++;  ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-b0'; ?>.jpg" width="250" height="202" /><br>
											鍋爐編號：3號熱水鍋爐	 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-b1') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-b1'; ?>.jpg" width="250" height="202" /><br>
											打開燃燒器
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										
										<?php if (is_photo($_GET['id'].'-b2') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-b2'; ?>.jpg" width="250" height="202" /><br>
											鍋爐編號：3號熱水鍋爐	 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-b3') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-b3'; ?>.jpg" width="250" height="202" /><br>
											 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-b4') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-b4'; ?>.jpg" width="250" height="202" /><br>
											鬆開點火捧的線，拿出散流器
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-b5') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-b5'; ?>.jpg" width="250" height="202" /><br>
											散流器外表	 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-b6') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-b6'; ?>.jpg" width="250" height="202" /><br>
											用鋼絲刷清潔散流器
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-b7') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-b7'; ?>.jpg" width="250" height="202" /><br>
											 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-b8') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-b8'; ?>.jpg" width="250" height="202" /><br>
											 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-b9') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-b9'; ?>.jpg" width="250" height="202" /><br>
											把散流器裝回燃燒器內
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-b10') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-b10'; ?>.jpg" width="250" height="202" /><br>
											調試石油氣及空氣比例
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-b11') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-b11'; ?>.jpg" width="250" height="202" /><br>
											 
										</td>
										<?php } if ($td % 2 != 0){echo '<td></td>';} if ($td % 2 ==0){echo '</tr><tr>';}?>
										<td align="center">
											 
										</td>
									 </tr>
									<tr>
										<td colspan="2" align="center" bgcolor="#ccc"><strong  style="font-size:26px;">Part<?php $part++; echo $part; ?>: (檢查部件及電器元件)</strong></td>
									</tr>
									<tr>
										<?php $td=0; if (is_photo($_GET['id'].'-b12') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-b12'; ?>.jpg" width="250" height="202" /><br>
											檢查程控器 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-b13') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-b13'; ?>.jpg" width="250" height="202" /><br>
											檢查空氣壓力開關有否短路
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-b14') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-b14'; ?>.jpg" width="250" height="202" /><br>
											  
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-b15') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-b15'; ?>.jpg" width="250" height="202" /><br>
											檢查燃氣壓力開關（對於漏氣）有否短路
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-b16') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-b16'; ?>.jpg" width="250" height="202" /><br>
											 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-b17') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-b17'; ?>.jpg" width="250" height="202" /><br>
											檢查摩打有否短路
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-b18') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-b18'; ?>.jpg" width="250" height="202" /><br>
											檢查對地阻抗 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-b19') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-b19'; ?>.jpg" width="250" height="202" /><br>
											檢查運行電流
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-b20') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-b20'; ?>.jpg" width="250" height="202" /><br>
											.
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-b21') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-b21'; ?>.jpg" width="250" height="202" /><br>
											檢查鍋爐水壓力保護制
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-b22') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-b22'; ?>.jpg" width="250" height="202" /><br>
											檢查低水位制 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-b23') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-b23'; ?>.jpg" width="250" height="202" /><br>
											檢查低水位制有否短路
										</td>
										<?php } if ($td % 2 != 0){echo '<td></td>';} if ($td % 2 ==0){echo '</tr><tr>';}?>
									</tr>
									 
									
									 
								</table>
								 <?php } ?>
								 <?php 
		 
									if (like_photo($_GET['id'].'-c') > 0) { $td=0; $part++;
								?>
								 <table   class="table table-hover table-nomargin dataTable dataTable-tools table-bordered dataTable-colvis  " style="font-size:16px;">
								 	<tr>
										<td colspan="2" align="center" bgcolor="#ccc"><strong  style="font-size:26px;">Part<?php echo $part; ?>: (檢查煙囪電控箱的電器元件)</strong></td>
									</tr>
									 <tr>
									 	<?php if (is_photo($_GET['id'].'-c0') > 0) { $td++;   ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-c0'; ?>.jpg" width="250" height="202" /><br>
											風機電控箱表面
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-c1') > 0) { $td++;  ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-c1'; ?>.jpg" width="250" height="202" /><br>
											檢查所有電連接是否扭緊
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-c2') > 0) { $td++;  ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-c2'; ?>.jpg" width="250" height="202" /><br>
											檢查是否短路 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-c3') > 0) { $td++;  ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-c3'; ?>.jpg" width="250" height="202" /><br>
											檢查對地電阻
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-c4') > 0) { $td++;  ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-c4'; ?>.jpg" width="250" height="202" /><br>
											檢查運行電流	 
										</td>
										<?php } if ($td % 2 != 0){echo '<td></td>';} if ($td % 2 ==0){echo '</tr><tr>';}?>
									</tr>
									  
								 </table>
								  <?php } ?>
								  <?php  
									if (like_photo($_GET['id'].'-h') > 0) { $td=0; $part++;
								?>
								 <table  class="table table-hover table-nomargin dataTable dataTable-tools table-bordered dataTable-colvis  " style="font-size:16px;">
								 	 
									<tr>
										<td colspan="2" align="center" bgcolor="#ccc"><strong  style="font-size:26px;">Part<?php echo $part; ?>: (檢查熱交換器機組電控箱的電器元件)</strong></td>
									</tr>
									 <tr>
									 	<?php if (is_photo($_GET['id'].'-h0') > 0) { $td++;   ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-h0'; ?>.jpg" width="250" height="202" /><br>
											熱交換器表面
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-h1') > 0) { $td++;  ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-h1'; ?>.jpg" width="250" height="202" /><br>
											檢查所有電連接是否扭緊
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-h2') > 0) { $td++;  ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-h2'; ?>.jpg" width="250" height="202" /><br>
											檢查是否短路 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-h3') > 0) { $td++;  ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-h3'; ?>.jpg" width="250" height="202" /><br>
											對地阻抗
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-h4') > 0) { $td++;  ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-h4'; ?>.jpg" width="250" height="202" /><br>
											檢查運行電流	 
										</td>
										<?php } if ($td % 2 != 0){echo '<td></td>';} if ($td % 2 ==0){echo '</tr><tr>';}?>
									</tr>
									  
								 </table>
								  <?php } ?>
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