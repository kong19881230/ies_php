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
  				 
  				$photo_reports= Sdba::table('photo_reports');
				 $photo_report_list= $photo_reports->get();
              $lang='cn';
              
              foreach ($photo_report_list as &$photo_report) {
                 $photo_report_hash[$photo_report["key"]]["text_cn"]= $photo_report["text_cn"];
              }
				?>
				<div class="page-header">
					<div class="pull-left">
						<h1 style="line-height: 32px;"><?php echo $reports_list[0]['name_cn']; ?><br><?php  $type=$maintain_froms_list[0]['from_type']; echo $from_type_en[$type].' System ('.$from_type[$type].'系統)'; ?></h1>
					</div>
					<div class="pull-right">
						 
						<ul class="stats">
							 
							<li class='lightred'>
								<a href='mpr_print.php?id=<?php echo $maintain_froms_list[0]['id']; ?>' target='blank'>
								<i class="fa fa-print"></i>
								<div class="details">
									<span class="big">Print preview</span>
									<span>移至列印頁面</span>
								</div>
								</a>
							</li>
							<li class='green'  >
								<a href='http://uniquecode.net/job/ms/mpdf56/photo_report.php?id=<?php echo $_GET['id']; ?>' target='blank'>
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
									if ($from_type_short[$type]=='b'&&like_photo($_GET['id'].'-b') > 0) { $td=0; $part++;
								?>
								<table  class="table table-hover table-nomargin dataTable dataTable-tools table-bordered dataTable-colvis  " style="font-size:16px;">
									<tr>
										<td colspan="2" align="center" bgcolor="#ccc"><strong  style="font-size:26px;">Part<?php echo $part; ?>: (清潔鍋爐內部件)</strong></td>
									</tr>
									 
									<tr>
										<?php if (is_photo($_GET['id'].'-b0') > 0) { $td++;  ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-b0'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['b0']['text_'.$lang]?><?php echo $maintain_froms_list[0]['device_id']?>	 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-b1') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-b1'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['b1']['text_'.$lang]?>
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										
										<?php if (is_photo($_GET['id'].'-b2') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-b2'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['b2']['text_'.$lang]?>
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-b3') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-b3'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['b3']['text_'.$lang]?>	 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-b4') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-b4'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['b4']['text_'.$lang]?>
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-b5') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-b5'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['b5']['text_'.$lang]?>
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-b6') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-b6'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['b6']['text_'.$lang]?>
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-b7') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-b7'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['b7']['text_'.$lang]?>
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-b8') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-b8'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['b8']['text_'.$lang]?>
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-b9') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-b9'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['b9']['text_'.$lang]?>
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-b10') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-b10'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['b10']['text_'.$lang]?>
										</td>
										
										<?php } if ($td % 2 != 0){echo '<td></td></tr>';} if ($td % 2 ==0){echo '</tr> ';}?>
										 
									  </table><br><br> 
									 <table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered dataTable-colvis  " style="font-size:16px;">
									<tr>
										<td colspan="2" align="center" bgcolor="#ccc"><strong  style="font-size:26px;">Part<?php $part++; echo $part; ?>: (檢查部件及電器元件)</strong></td>
									</tr>
									<tr>
										<?php $td=0; if (is_photo($_GET['id'].'-b11') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-b11'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['b11']['text_'.$lang]?> 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-b12') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-b12'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['b12']['text_'.$lang]?>  
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>

										<?php if (is_photo($_GET['id'].'-b13') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-b13'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['b13']['text_'.$lang]?> 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-b14') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-b14'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['b14']['text_'.$lang]?> 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-b15') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-b15'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['b15']['text_'.$lang]?> 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-b16') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-b16'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['b16']['text_'.$lang]?> 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-b17') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-b17'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['b17']['text_'.$lang]?> 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-b18') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-b18'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['b18']['text_'.$lang]?> 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-b19') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-b19'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['b19']['text_'.$lang]?> 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-b20') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-b20'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['b20']['text_'.$lang]?> 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-b21') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-b21'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['b21']['text_'.$lang]?> 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-b22') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-b22'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['b22']['text_'.$lang]?> 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-b23') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-b23'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['b23']['text_'.$lang]?> 
										</td>
										<?php } if ($td % 2 != 0){echo '<td></td>';} if ($td % 2 ==0){echo '</tr><tr>';}?>
									</tr>
									 
									
									 
								</table>
								 <?php } ?>
								 <?php 
		 
									if ($from_type_short[$type]=='c'&&like_photo($_GET['id'].'-c') > 0) { $td=0; $part++;
								?>
								 <table   class="table table-hover table-nomargin dataTable dataTable-tools table-bordered dataTable-colvis  " style="font-size:16px;">
								 	<tr>
										<td colspan="2" align="center" bgcolor="#ccc"><strong  style="font-size:26px;">Part<?php echo $part; ?>: (檢查煙囪電控箱的電器元件)</strong></td>
									</tr>
									 <tr>
									 	<?php if (is_photo($_GET['id'].'-c0') > 0) { $td++;   ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-c0'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['c0']['text_'.$lang]?> 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-c1') > 0) { $td++;  ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-c1'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['c1']['text_'.$lang]?> 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-c2') > 0) { $td++;  ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-c2'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['c2']['text_'.$lang]?> 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-c3') > 0) { $td++;  ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-c3'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['c3']['text_'.$lang]?> 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-c4') > 0) { $td++;  ?>
										<td align="center">
											
											<img src="upload/<?php echo $_GET['id'].'-c4'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['c4']['text_'.$lang]?> 	 
										</td>
										<?php } if ($td % 2 != 0){echo '<td></td>';} if ($td % 2 ==0){echo '</tr><tr>';}?>
									</tr>
									  
								 </table>
								  <?php } ?>
								  <?php  
									if ($from_type_short[$type]=='h'&&like_photo($_GET['id'].'-h') > 0) { $td=0; $part++;
								?>
								 <table  class="table table-hover table-nomargin dataTable dataTable-tools table-bordered dataTable-colvis  " style="font-size:16px;">
								 	 
									<tr>
										<td colspan="2" align="center" bgcolor="#ccc"><strong  style="font-size:26px;">Part<?php echo $part; ?>: (檢查熱交換器機組電控箱的電器元件)</strong></td>
									</tr>
									 <tr>
									 	<?php if (is_photo($_GET['id'].'-h0') > 0) { $td++;   ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-h0'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['h0']['text_'.$lang]?> 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-h5') > 0) { $td++;  ?>
										<td align="center">
											
											<img src="upload/<?php echo $_GET['id'].'-h5'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['h5']['text_'.$lang]?> 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-h1') > 0) { $td++;  ?>
										<td align="center">
											
											<img src="upload/<?php echo $_GET['id'].'-h1'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['h1']['text_'.$lang]?> 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-h2') > 0) { $td++;  ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-h2'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['h2']['text_'.$lang]?> 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-h3') > 0) { $td++;  ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-h3'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['h3']['text_'.$lang]?> 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-h4') > 0) { $td++;  ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-h4'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['h4']['text_'.$lang]?> 	 
										</td>
										<?php } if ($td % 2 != 0){echo '<td></td>';} if ($td % 2 ==0){echo '</tr><tr>';}?>
									</tr>
									  
								 </table>
								  <?php } ?>
								  <?php $part=0;
									if ($from_type_short[$type]=='s'&&like_photo($_GET['id'].'-s') > 0) { $td=0; $part++;
								?>
								<table  class="table table-hover table-nomargin dataTable dataTable-tools table-bordered dataTable-colvis  " style="font-size:16px;">
									<tr>
										<td colspan="2" align="center" bgcolor="#ccc"><strong  style="font-size:26px;">Part<?php echo $part; ?>: (清潔鍋爐內部件)</strong></td>
									</tr>
									 
									<tr>
										<?php if (is_photo($_GET['id'].'-s0') > 0) { $td++;  ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-s0'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['s0']['text_'.$lang]?>  <?php echo $maintain_froms_list[0]['device_id']?>	 	 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-s1') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-s1'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['s1']['text_'.$lang]?> 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										
										<?php if (is_photo($_GET['id'].'-s2') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-s2'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['s2']['text_'.$lang]?> 	 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-s3') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-s3'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['s3']['text_'.$lang]?> 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-s4') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-s4'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['s4']['text_'.$lang]?> 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-s5') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-s5'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['s5']['text_'.$lang]?> 
										</td>
										
										<?php } if ($td % 2 != 0){echo '<td></td>';} if ($td % 2 ==0){echo '</tr><tr>';}?>
										
										
										
									 </tr>
									 </table><br><br> 
									 <table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered dataTable-colvis  " style="font-size:16px;">
									<tr>
										<td colspan="2" align="center" bgcolor="#ccc"><strong  style="font-size:26px;">Part<?php $part++; echo $part; ?>: (檢查部件及電器元件)</strong></td>
									</tr>
									<tr>
										<?php $td=0; if (is_photo($_GET['id'].'-s6') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-s6'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['s6']['text_'.$lang]?> 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-s7') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-s7'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['s7']['text_'.$lang]?> 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-s8') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-s8'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['s8']['text_'.$lang]?> 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-s9') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-s9'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['s9']['text_'.$lang]?> 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-s10') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-s10'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['s10']['text_'.$lang]?>      
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-s11') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-s11'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['s11']['text_'.$lang]?> 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-s12') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-s12'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['s12']['text_'.$lang]?>  
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-s13') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-s13'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['s13']['text_'.$lang]?> 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-s14') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-s14'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['s14']['text_'.$lang]?> 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-s15') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-s15'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['s15']['text_'.$lang]?> 
										</td>
										
										<?php } if ($td % 2 != 0){echo '<td></td>';} if ($td % 2 ==0){echo '</tr><tr>';}?>
									</tr>
									 
									
									 
								</table>
								 <?php } ?>
								  <?php $part=0;
									if ($from_type_short[$type]=='o'&&like_photo($_GET['id'].'-o') > 0) { $td=0; $part++;
								?>
								<table  class="table table-hover table-nomargin dataTable dataTable-tools table-bordered dataTable-colvis  " style="font-size:16px;">
									<tr>
										<td colspan="2" align="center" bgcolor="#ccc"><strong  style="font-size:26px;">Part<?php echo $part; ?>: (清潔鍋爐內部件)</strong></td>
									</tr>
									 
									<tr>
										<?php if (is_photo($_GET['id'].'-o0') > 0) { $td++;  ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-o0'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['o0']['text_'.$lang]?>  <?php echo $maintain_froms_list[0]['device_id']?>	 	 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-o100') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-o100'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['o100']['text_'.$lang]?> 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										
										<?php if (is_photo($_GET['id'].'-o1') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-o1'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['o1']['text_'.$lang]?> 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										
										<?php if (is_photo($_GET['id'].'-o2') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-o2'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['o2']['text_'.$lang]?> 	 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-o3') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-o3'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['o3']['text_'.$lang]?> 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-o4') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-o4'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['o4']['text_'.$lang]?> 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-o5') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-o5'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['o5']['text_'.$lang]?> 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-o6') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-o6'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['o6']['text_'.$lang]?> 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-o7') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-o7'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['o7']['text_'.$lang]?> 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-o8') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-o8'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['o8']['text_'.$lang]?> 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-o9') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-o9'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['o9']['text_'.$lang]?> 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-o10') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-o10'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['o10']['text_'.$lang]?>      
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-o11') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-o11'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['o11']['text_'.$lang]?> 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-o12') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-o12'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['o12']['text_'.$lang]?>  
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-o13') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-o13'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['o13']['text_'.$lang]?> 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-o14') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-o14'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['o14']['text_'.$lang]?> 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-o15') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-o15'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['o15']['text_'.$lang]?> 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-o16') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-o16'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['o16']['text_'.$lang]?> 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-o17') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-o17'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['o17']['text_'.$lang]?> 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-o101') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-o101'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['o101']['text_'.$lang]?> 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-o102') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-o102'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['o102']['text_'.$lang]?> 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-o103') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-o103'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['o103']['text_'.$lang]?> 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-o104') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-o104'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['o104']['text_'.$lang]?> 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-o105') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-o105'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['o105']['text_'.$lang]?> 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-o106') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-o106'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['o106']['text_'.$lang]?> 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-o107') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-o107'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['o107']['text_'.$lang]?> 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-o108') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-o108'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['o108']['text_'.$lang]?> 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-o109') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-o109'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['o109']['text_'.$lang]?> 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-o110') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-o110'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['o110']['text_'.$lang]?> 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-o111') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-o111'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['o111']['text_'.$lang]?> 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-o112') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-o112'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['o112']['text_'.$lang]?> 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-o113') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-o113'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['o113']['text_'.$lang]?> 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-o114') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-o114'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['o114']['text_'.$lang]?> 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-o115') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-o115'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['o115']['text_'.$lang]?> 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-o116') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-o116'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['o116']['text_'.$lang]?> 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-o117') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-o117'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['o117']['text_'.$lang]?> 
										</td>
										<?php } if ($td % 2 != 0){echo '<td></td>';} if ($td % 2 ==0){echo '</tr><tr>';}?>
										
										
										
									 </tr>
									 </table><br><br> 
									 <table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered dataTable-colvis  " style="font-size:16px;">
									<tr>
										<td colspan="2" align="center" bgcolor="#ccc"><strong  style="font-size:26px;">Part<?php $part++; echo $part; ?>: (檢查部件及電器元件)</strong></td>
									</tr>
									<tr>
										<?php $td=0; if (is_photo($_GET['id'].'-o18') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-o18'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['o18']['text_'.$lang]?> 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-o19') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-o19'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['o19']['text_'.$lang]?> 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-o20') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-o20'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['o20']['text_'.$lang]?> 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-o21') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-o21'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['o21']['text_'.$lang]?> 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-o22') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-o22'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['o22']['text_'.$lang]?>      
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-o118') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-o118'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['o118']['text_'.$lang]?> 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-o119') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-o119'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['o119']['text_'.$lang]?> 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-o120') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-o120'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['o120']['text_'.$lang]?>  
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-o121') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-o121'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['o121']['text_'.$lang]?>  
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-o122') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-o122'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['o122']['text_'.$lang]?>  
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-o123') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-o123'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['o123']['text_'.$lang]?>  
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-o124') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-o124'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['o124']['text_'.$lang]?>  
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-o125') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-o125'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['o125']['text_'.$lang]?>  
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-o126') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-o126'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['o126']['text_'.$lang]?>  
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-o127') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-o127'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['o127']['text_'.$lang]?>  
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-o128') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-o128'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['o128']['text_'.$lang]?>  
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-o129') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-o129'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['o129']['text_'.$lang]?>  
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										
										<?php if (is_photo($_GET['id'].'-o130') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-o130'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['o130']['text_'.$lang]?> 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										
										<?php if (is_photo($_GET['id'].'-o131') > 0) { $td++; ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-o131'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['o131']['text_'.$lang]?> 
										</td>
										
										<?php } if ($td % 2 != 0){echo '<td></td>';} if ($td % 2 ==0){echo '</tr><tr>';}?>
									</tr>
									 
									
									 
								</table>
								 <?php } ?>
								 <?php  
									if ($from_type_short[$type]=='cp'&&like_photo($_GET['id'].'-cp') > 0) { $td=0; $part++;
								?>
								 <table  class="table table-hover table-nomargin dataTable dataTable-tools table-bordered dataTable-colvis  " style="font-size:16px;">
								 	 
									<tr>
										<td colspan="2" align="center" bgcolor="#ccc"><strong  style="font-size:26px;">Part<?php echo $part; ?>: (檢查循環泵電控箱的電器元件)</strong></td>
									</tr>
									 <tr>
									 	<?php if (is_photo($_GET['id'].'-cp0') > 0) { $td++;   ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-cp0'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['cp0']['text_'.$lang]?> 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-cp1') > 0) { $td++;  ?>
										<td align="center">
											
											<img src="upload/<?php echo $_GET['id'].'-cp1'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['cp1']['text_'.$lang]?> 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-cp2') > 0) { $td++;  ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-cp2'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['cp2']['text_'.$lang]?> 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-cp3') > 0) { $td++;  ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-cp3'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['cp3']['text_'.$lang]?> 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-cp4') > 0) { $td++;  ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-cp4'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['cp4']['text_'.$lang]?> 	 
										</td>
										<?php } if ($td % 2 != 0){echo '<td></td>';} if ($td % 2 ==0){echo '</tr><tr>';}?>
									</tr>
									  
								 </table>
								  <?php } ?>
								   <?php  
									if ($from_type_short[$type]=='bp'&&like_photo($_GET['id'].'-bp') > 0) { $td=0; $part++;
								?>
								 <table  class="table table-hover table-nomargin dataTable dataTable-tools table-bordered dataTable-colvis  " style="font-size:16px;">
								 	 
									<tr>
										<td colspan="2" align="center" bgcolor="#ccc"><strong  style="font-size:26px;">Part<?php echo $part; ?>: (檢查加壓泵組電控箱的電器元件)</strong></td>
									</tr>
									 <tr>
									 	<?php if (is_photo($_GET['id'].'-bp0') > 0) { $td++;   ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-bp0'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['bp0']['text_'.$lang]?> 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-bp1') > 0) { $td++;  ?>
										<td align="center">
											
											<img src="upload/<?php echo $_GET['id'].'-bp1'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['bp1']['text_'.$lang]?> 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-bp2') > 0) { $td++;  ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-bp2'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['bp2']['text_'.$lang]?> 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-bp3') > 0) { $td++;  ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-bp3'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['bp3']['text_'.$lang]?> 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-bp4') > 0) { $td++;  ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-bp4'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['bp4']['text_'.$lang]?> 	 
										</td>
										<?php } if ($td % 2 != 0){echo '<td></td>';} if ($td % 2 ==0){echo '</tr><tr>';}?>
									</tr>
									  
								 </table>
								  <?php } ?>
								  <?php  
									if ($from_type_short[$type]=='ca'&&like_photo($_GET['id'].'-ca') > 0) { $td=0; $part++;
								?>
								 <table  class="table table-hover table-nomargin dataTable dataTable-tools table-bordered dataTable-colvis  " style="font-size:16px;">
								 	 
									<tr>
										<td colspan="2" align="center" bgcolor="#ccc"><strong  style="font-size:26px;">Part<?php echo $part; ?>: (檢查熱水加熱器電控箱的電器元件)</strong></td>
									</tr>
									 <tr>
									 	<?php if (is_photo($_GET['id'].'-ca0') > 0) { $td++;   ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-ca0'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['ca0']['text_'.$lang]?> 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-ca1') > 0) { $td++;  ?>
										<td align="center">
											
											<img src="upload/<?php echo $_GET['id'].'-ca1'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['ca1']['text_'.$lang]?> 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-ca2') > 0) { $td++;  ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-ca2'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['ca2']['text_'.$lang]?> 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-ca3') > 0) { $td++;  ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-ca3'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['ca3']['text_'.$lang]?> 
										</td>
										<?php } if ($td % 2 ==0){echo '</tr><tr>';}?>
										<?php if (is_photo($_GET['id'].'-ca4') > 0) { $td++;  ?>
										<td align="center">
											<img src="upload/<?php echo $_GET['id'].'-ca4'; ?>.jpg" width="250" height="202" /><br>
											<?php echo $photo_report_hash['ca4']['text_'.$lang]?> 	 
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