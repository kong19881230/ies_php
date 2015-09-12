<?php include('sdba/sdba.php'); ?>
<?php
// クライアントからのPOSTを受け取る


 
// 下記をレスポンスヘッダーに含める
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: X-Requested-With");


if(isset($_POST['report'])) {
    $report = json_decode($_POST['report']);
    $details=$report->details;
    $report_service = Sdba::table('reports');
    $details_service = Sdba::table('emergency_details');
     $photos_service = Sdba::table('photos');
    //$report->customer_id
    $report_data = array('name_cn'=>$report->name_cn,'name_en'=>$report->name_en,'signature'=>$report->signature,'type'=>(int)$report->type,'project_id'=>(int)$report->project_id,
      'created_by'=>$report->created_by,'created_at'=>$report->created_at,'updated_at'=>$report->updated_at);
    if(!is_null($report->id)){
      $report_data['id']=$report->id;
    }
 	  $report_service->set($report_data);
    if(is_null($report->id)){
      $report->id = $report_service->insert_id();
    }
    
    $detail_data=array('report_id'=>$report->id,'problem_reported'=>$details->problem_reported,'project_name'=>$details->project_name,'device_name'=>$details->device_name,'is_system_down'=>$details->is_system_down,
      'reported_by'=>$details->reported_by,'device_model'=>$details->device_model,'device_id'=>$details->device_id,'power'=>$details->power,
      'machine_type'=>$details->machine_type,'location'=>$details->location,'situation'=>json_encode($details->situation),'inspection_found'=>$details->inspection_found,
      'status_after_service'=>$details->status_after_service,'remarks'=>$details->remarks,'contact_name'=>$details->contact_name,'designation'=>$details->designation,
      'phone'=>$details->phone,'fax'=>$details->fax,'email'=>$details->email,'reported_at'=>$details->reported_at,'end_service_at'=>$details->end_service_at,'start_service_at'=>$details->start_service_at);
    //'signature'=>$details->signature,
    if(!is_null($details->id)){
      $detail_data['id']=$details->id;
    }
    $details_service->set($detail_data);
    if(is_null($details->id)){
      $report->details->id= $details_service->insert_id();
    }
 	 foreach ($report->photos as $id => $photo) {
           $photo_data = array('id'=>$photo->id,'state'=>$photo->state,'local'=>$photo->local);
           $photos_service->set($photo_data);
           
      }

    echo "#####".json_encode($report);
  } else {
    echo "Noooooooob";
  }
//$report = Sdba::table('report');
//$data = array('description'=>$main_report ,'device_model'=>$device_model,'device_id'=>$device_id,'company_id'=>$company,'name'=>'Emergency Report','submit_by'=>$submit_by,'type'=>1);

//$report->insert($data);

// 処理結果($result)などクライアントに返す値を連想配列で設定し、json_encodeを通す。
// 処理結果($result)などクライアントに返す値を連想配列で設定し、json_encodeを通す。
//$result='success';
//echo 'success';
//print_r($data);
//print json_encode(array('result' => $result));
?>