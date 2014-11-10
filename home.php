 
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
  										if (isset($_GET['type'])){
											$reports->where('type',$_GET['type']);
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
  											
  									?>
  										<tr>
  											<td style="display:none;"><?php echo $reports_list[$i]['updated_at']; ?></td>
											<td><?php echo $reports_list[$i]['name_en']; ?><br><?php echo $reports_list[$i]['name_cn']; ?></td>
											<td><?php echo $reports_type[$reports_list[$i]['type']]; ?></td>
											<td><?php echo $reports_cycles_cn[$reports_list[$i]['cycle_type']].'<br>'.$reports_cycles_en[$reports_list[$i]['cycle_type']]; ?></td>
											<td><?php echo $reports_list[$i]['created_by']; ?></td>
											<td><?php echo $reports_list[$i]['created_at']; ?></td>
											<td><?php echo $reports_list[$i]['updated_at']; ?></td>
											<td><?php echo $customers_list[0]['name_cn']; ?><br><?php echo $customers_list[0]['name_en']; ?></td>
											<td><a href="<?php echo $reports_type_link[$reports_list[$i]['type']] ?>&id=<?php echo $reports_list[$i]['id']; ?>" class="btn" rel="tooltip" title="" data-original-title="View">
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