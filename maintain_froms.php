<?php if (!defined('EL_ADMIN')) exit('No direct script access allowed'); ?>
 		<div id="main">
			<div class="container-fluid">
				<div class="page-header">
					<?php 
					$maintain_froms = Sdba::table('maintain_froms');
  					$maintain_froms->where('report_id',$_GET['id']);
  					$total_maintain_froms = $maintain_froms->total(); 
  					$maintain_froms_list = $maintain_froms->get();
  					
  					
  					$reports = Sdba::table('reports');
  					$reports->where('id',$maintain_froms_list[0]['report_id']);
  					$total_reports = $reports->total();
  					$reports_list = $reports->get();
					?>
					<div class="pull-left">
						<h1><?php echo $reports_list[0]['name_cn']; ?></h1>
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
							<a href="?page=home">Home</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="?page=home">Reports</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a><?php echo $reports_list[0]['name_en']; ?></a>
							 
						</li>
						 
					</ul>
					<div class="close-bread">
						<a href="#">
							<i class="fa fa-times"></i>
						</a>
					</div>
				</div>
 				<?php  
 					
 					
  					//echo '<pre>';
  					//print_r($maintain_froms_list);
  					//echo '</pre>';
  					for ($i=0; $i<$total_maintain_froms;$i++){ 
  						$from_type_arr[] = $maintain_froms_list[$i]['from_type'];
  					}
  					$from_type_unique = array_unique($from_type_arr);
  					//echo '<pre>';
  					//print_r(array_unique($from_type_unique));
  					//echo '</pre>';
  					if (!isset($_GET['ft'])){$_GET['ft']=$from_type_unique[0];}
  				?>
				<div class="row">
					<div class="col-sm-12">
						<h6>　</h6>
						<p>
							<ul class="nav nav-tabs">
							<?php foreach($from_type_unique as $value){ 
								if ($value == $_GET['ft']){$active = 'class="active"';}else{$active='';}
							?>
								<li <?php echo $active; ?>>
									<a href="?page=maintain_froms&id=<?php echo $_GET['id'].'&ft='.$value; ?>"><?php echo $from_type[$value]; ?></a>
								</li>
								 
							<?php } ?>
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
											<th>#ID</th>
											<th style="display:none;">Remark</th>
											<th>Device ID</th>
											<th>Device model</th>
											<th>Inspector</th>
											<th>Name</th>
											<th>Options</th>
										</tr>
									</thead>
									<tbody>
									<?php  
  										$maintain_froms = Sdba::table('maintain_froms');
  										$maintain_froms->where('from_type',$_GET['ft']);
  										$maintain_froms->where('report_id',$_GET['id']);
  										$total_maintain_froms = $maintain_froms->total();
  										$maintain_froms_list = $maintain_froms->get();
  										
  										//echo $total_rows;
  										//print_r($reportlist);
  									?>
  									<?php 
  										for ($i=0; $i<$total_maintain_froms;$i++){
  											 
  											
  									?>
  										<tr>
											<td><?php echo $maintain_froms_list[$i]['id']; ?></td>
											<td style="display:none;"><?php echo chkempty($maintain_froms_list[$i]['remark']); ?></td>
											<td><?php echo chkempty($maintain_froms_list[$i]['device_id']); ?></td>
											<td><?php echo chkempty($maintain_froms_list[$i]['device_model']); ?></td>
											<td><?php echo chkempty($maintain_froms_list[$i]['inspector']); ?></td>
											<td><?php echo $maintain_froms_list[$i]['name_cn']; ?><br><?php echo $maintain_froms_list[$i]['name_en']; ?></td>
											<td><a href="?page=maintain_ltem_results&id=<?php echo $maintain_froms_list[$i]['id']; ?>" class="btn" rel="tooltip" title="" data-original-title="View">
													<i class="fa fa-search"></i>
												</a>
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