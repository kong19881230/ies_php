<?php session_start(); ?>
<?php include('sdba/sdba.php'); ?>
<?php require 'security/processor.php';	?>
<?php 
define('EL_ADMIN', true);
if (!isset($_GET['page'])) {
		$_GET['page'] = 'home';
}
?>
 
<style>
	
	 
	.table tr td {
		font-size:12px;
		color:#555;
		padding: 6px;
		border-top: 1px solid #ddd;
		line-height: 18px;
	}
	.table tr th {
		padding: 8px;
		border-top: 1px solid #ddd;
		
	}
	.circle
    {
	
    border:0.1mm solid #000;
    background-color: #EFEFEF;
    border-radius: 3mm;
    background-clip: border-box;
    width: 700px;
    text-align: center;
    font: 15px "Trebuchet MS", Verdana, Arial;
    color: #000;
    margin: 0px auto;
    padding: 0 10px;
    } 
    .ans{
    	color:#000; 
    	font-size:16px;
 
    }
    
</style>
 
<body>
<div id="content_internal">
	<div class="content_block left" style="width:860px;">
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
		
	<br>
				<div class="row">
					<div class="col-sm-12">
						<div class="box">
							
							<div class="box-content nopadding"> 
								<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered dataTable-colvis  " width="850" style="font-size:16px;border: 3px solid #ccc;">
									 
									<tr>
										<td colspan="3" align="center" bgcolor="#ccc"><strong  style="font-size:18px;">SERVICE REPORT (工作報告)</td>
									</tr>
									<tr>
										<td colspan="3" style="padding: 8px;">Customer Name (客戶名稱): 　　<span class='ans'><?php if( $emergency_details_list[0]['project_name']==""){ echo $projects_list[0]['name_en'];}else{ echo $emergency_details_list[0]['project_name'];} ?></span></td>
									</tr>
									<tr>
										<td colspan="3" align="center" bgcolor="#EEEEEE">NATURE OF PROBLEM (問題類別)</td>
									</tr>
									<tr>
										<td colspan="3">Problem Reported (回報的問題): <br><br>
									    <span class='ans'><?php echo $emergency_details_list[0]['problem_reported']; ?> </span>
										</td>
									</tr>
									<tr>
										<td colspan="3">System Down (系統停止): </td>
										
									</tr>
									<tr >
									  <td colspan="3" style="border-top: 2px solid #fff;color:#000; font-size:16px; padding:2px 12px;"  align="right" class='ans'> 
									   <span  style="font-size:13px;color:#222;">
                                      <?php if($emergency_details_list[0]['is_system_down']=='true'){ ?>
                                      <span class='circle'> Yes </span> /  No
                                      <?php }else{ ?>
										Yes  / <span class='circle'> No </span>
										<?php } ?>
										</span>
                                       </td>
									 
 								 	</tr>
 								 	<tr>
										<td width='40%'>Equipment Type (設備種類): </td>
										<td width='30%'>Part of Equipment  (設備部位):　 </td>
										<td width='30%'>Element Name (元件名稱):  </td>
									</tr>
									<tr>
									  <td class='ans' style="border-top: 2px solid #fff;color:#000; font-size:16px; padding:2px 12px;"  align="right"> <?php if( $emergency_details_list[0]['device_name']==""){ echo $from_type_en[$emergency_details_list[0]['machine_type']];}else{ echo $emergency_details_list[0]['device_name'];} ?>  </td>
									  <td class='ans' style="border-top: 2px solid #fff;color:#000; font-size:16px; padding:2px 12px;"  width='30%' align="right"><?php echo $emergency_details_list[0]['machine_part']; ?></td>
									  <td class='ans' style="border-top: 2px solid #fff;color:#000; font-size:16px; padding:2px 12px;"  width='40%' align="right"><?php echo $emergency_details_list[0]['machine_element']; ?></td>
  </tr>
									<tr>
										<td width='40%'>Power (功率):  </td>
										<td width='30%'>Model (型號): </td>
										<td width='30%'>Serial No. (編號):  </td>
									</tr>
									<tr>
									  <td class='ans' style="border-top: 2px solid #fff;color:#000; font-size:16px; padding:2px 12px;"  align="right"><?php echo $emergency_details_list[0]['power']; ?></td>
									  <td class='ans' style="border-top: 2px solid #fff;color:#000; font-size:16px; padding:2px 12px;"  width='30%' align="right"><?php echo $emergency_details_list[0]['device_model']; ?></td>
									  <td class='ans' style="border-top: 2px solid #fff;color:#000; font-size:16px; padding:2px 12px;"  width='40%' align="right"><?php echo $emergency_details_list[0]['device_id']; ?></td>
  </tr>
									<tr>
										<td>Call Reported by (匯報部門): </td>
										<td>Date (日期):  </td>
										<td>Time (時間):  </td>
									</tr>
									<tr>
									  <td class='ans' style="border-top: 2px solid #fff;color:#000; font-size:16px; padding:2px 12px;"  align="right"><?php echo $emergency_details_list[0]['reported_by']; ?></td>
									  <td class='ans' style="border-top: 2px solid #fff;color:#000; font-size:16px; padding:2px 12px;"  align="right"><?php echo date_format(date_create($emergency_details_list[0]['reported_at']),'Y-m-d'); ?></td>
									  <td class='ans' style="border-top: 2px solid #fff;color:#000; font-size:16px; padding:2px 12px;"  align="right"><?php echo date_format(date_create($emergency_details_list[0]['reported_at']),'H:i'); ?></td>
  </tr>
									<tr>
										<td colspan="3">Location of Installation (地點): 　　<span class='ans'><?php echo $emergency_details_list[0]['location']; ?></span></td>
									</tr>
									<tr>
										<td colspan="3" align="center" bgcolor="#EEEEEE">REPORT DETAILS (報告詳細)</td>
									</tr>
									<tr>
										<td colspan="3">Defects found on inspection (損毀發現):  
                                          <br /><br><span class='ans'><?php echo $emergency_details_list[0]['inspection_found']; ?>  </span>
				                      </td>
									</tr>
									<tr>
										<td colspan="2" valign="top">Engineer's Remarks (工程師備註):<br />
										<?php $result = json_decode($emergency_details_list[0]['situation'],true); ?>
									    <span class='ans'>
										  <ul>
										    
									        <?php for ($i=0; $i<count($result); $i++) { echo '<li>'.$result[$i]['text'].'</li>'; } ?> 
									        
						                 </ul></span></td>
										<td>Status after Service (完工後狀態): <br><br>
										 <span  style="font-size:13px;color:#222;">
											<?php if($emergency_details_list[0]['status_after_service']=='complete'){ ?>
											<span class='circle'>  Complete  </span>   /   Incomplete   / <br>  Pending for spares   /   Under Observation   / <br>  Working solution provided   
											<?php }elseif($emergency_details_list[0]['status_after_service']=='incomplete'){ ?>
											Complete   /   <span class='circle'>  Incomplete  </span>   / <br>  Pending for spares   /   Under Observation   / <br>  Working solution provided   
											<?php }elseif($emergency_details_list[0]['status_after_service']=='pending'){ ?>
											Complete   /   Incomplete   /   <br>
											  <span class='circle'>  Pending for spares  </span>   /   Under Observation   / <br>  Working solution provided   
											<?php }elseif($emergency_details_list[0]['status_after_service']=='observation'){ ?>
											Complete   /   Incomplete   / <br>  Pending for spares   /   <span class='circle'>  Under Observation  </span>   / <br>  Working solution provided    
											<?php }elseif($emergency_details_list[0]['status_after_service']=='working'){ ?>
											Complete   /   Incomplete   / <br>  Pending for spares   /   Under Observation   / <br>
											  <span class='circle'>  Working solution provided  </span>    
											<?php } ?>
										 </span><br>
										  <em style="font-size:12px;padding-top: 6px; padding-right: 18px; float:right;">*Please circle</em>
										</td>
									</tr>
									 
									<tr>
										 <td>Date (日期):　　</td> 
										<td >Start of Service (開始):　</td>
										<td >End of Service (結束): </td>
									</tr>
									<tr>
									  <td class='ans' style="border-top: 2px solid #fff;color:#000; font-size:16px; padding:2px 12px;"  align="right"><?php echo date_format(date_create($emergency_details_list[0]['start_service_at']),'Y-m-d'); ?></td>
									  <td class='ans' style="border-top: 2px solid #fff;color:#000; font-size:16px; padding:2px 12px;"  align="right"> <?php echo date_format(date_create($emergency_details_list[0]['start_service_at']),'H:i');?></td>
									  <td class='ans' style="border-top: 2px solid #fff;color:#000; font-size:16px; padding:2px 12px;"  align="right"><?php echo date_format(date_create($emergency_details_list[0]['end_service_at']),'H:i');?></td>
  </tr>
									<tr>
										<td colspan="3" align="center" bgcolor="#EEEEEE">CUSTOMER (客戶)</td>
									</tr>
									<tr>
										<td colspan="3">Remarks (備註):	 <br /><br><span class='ans'><?php if(isset($emergency_details_list[0]['remarks'])&&$emergency_details_list[0]['remarks']!='""'){  echo $emergency_details_list[0]['remarks'];} ?></span> </td>
									</tr>
									<tr>
										<td>Name (姓名):  </td>
										<td>Designation (職位):  </td>
										<td>Phone/Fax (電話/傳真):</td>
									</tr>
									<tr>
									  <td class='ans' style="border-top: 2px solid #fff;color:#000; font-size:16px; padding:2px 12px;"  align="right"><?php echo $emergency_details_list[0]['contact_name']; ?></td>
									  <td class='ans' style="border-top: 2px solid #fff;color:#000; font-size:16px; padding:2px 12px;"  align="right"><?php echo $emergency_details_list[0]['designation']; ?></td>
									  <td class='ans' style="border-top: 2px solid #fff;color:#000; font-size:16px; padding:2px 12px;"  align="right"><?php echo $emergency_details_list[0]['phone']; ?> <?php if($emergency_details_list[0]['phone']!=""&&$emergency_details_list[0]['fax']!=""){echo "/";} ?>  <?php echo $emergency_details_list[0]['fax']; ?></td>
  </tr>
									<tr>
										<td colspan="3">Email (電郵):　　<span class='ans'><?php echo $emergency_details_list[0]['email']; ?></span></td>
									</tr>
									<tr>
										<td>Sign (客户簽名):
										 </td>
										<td colspan="2"><?php if ($reports_list[0]['signature'] !=''){ ?><img src="../upload/<?php echo $reports_list[0]['signature']; ?>.png" width="200"><?php }?></td>
									</tr> 		
									
								</table>
							</div>
						</div>
					</div>
				</div>
<br />

		</div>
	</div>
</body>
