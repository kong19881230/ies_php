<?php session_start(); ?>
<?php include('sdba/sdba.php');?>
<?php
												$articles = Sdba::table('serviceA_step1');
												 
												$articles->where('status <',4);
												$total_rows = $articles->total();
												
												echo $total_rows;
												?>
												<div style="float:left; width:138px;height:138px; ">
												<a href="?page=account&go=SA1" style="height:138px;width:138px;color:#33B8FF;border-color: #33B8FF;" class="btn btn-default">
													<i class="icon icon-plus-circle" style="font-size:66px; " ></i><br>
													<span>新增代購訂單 <br>New Quote</span>
												</a>