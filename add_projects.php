<?php include('sdba/sdba.php'); ?>
<?php
// クライアントからのPOSTを受け取る


 
// 下記をレスポンスヘッダーに含める
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: X-Requested-With");


if(isset($_POST['projects'])) {
    $projects = json_decode($_POST['projects']);
   
    $project_service = Sdba::table('projects');
   foreach ($projects as &$project) {
    //$report->customer_id
    $project_data = array('id'=>(int)$project->id,'name_en'=>$project->name_en,'name_cn'=>$project->name_cn,'seq'=>$project->seq,
      'cycle_types'=>$project->cycles_str,'machine_types'=>$project->machine_str,'created_at'=>$project->created_at,'updated_at'=>$project->updated_at);
 	  $project_service->insert($project_data);
   
   	}

    
    echo json_encode($projects);
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