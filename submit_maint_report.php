<?php include('sdba/sdba.php'); ?>

<?php date_default_timezone_set("Asia/Hong_Kong");
// クライアントからのPOSTを受け取る


 
// 下記をレスポンスヘッダーに含める
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: X-Requested-With");


if(isset($_POST['report'])) {
    $report = json_decode($_POST['report']);
    $froms= $report->froms;
    $report_service = Sdba::table('reports');
    $from_service = Sdba::table('maintain_froms');
    $audit_log_service = Sdba::table('audit_logs');
    $photos_service = Sdba::table('photos');
    $from_item_service = Sdba::table('maintain_item_results');
    //$report->customer_id
    $report_data = array('name_cn'=>$report->name_cn,'name_en'=>$report->name_en,'type'=>$report->type,'project_id'=>$report->project_id,
      'cycle_type'=>$report->cycle_type,'created_by'=>$report->technican,'created_at'=>$report->created_at,'updated_at'=>$report->updated_at);
 	  if(!is_null($report->id)){
      $report_data['id']=$report->id;
    }
    $report_service->set($report_data);
    if(is_null($report->id)){
      $report->id = $report_service->insert_id();
    }


     foreach ($froms as &$from) {
      #'device_photo_id'=>$from->device_photo_id
      $from_data = array('id'=>$from->id ,'from_type'=>$from->from_type,'device_id'=>$from->device_id,'device_model'=>$from->device_model,
      'maintenance_technician'=>$from->technican,'signature'=>$from->signature,'name_cn'=>$from->name_cn,'name_en'=>$from->name_en,'report_id'=>$report->id,
      'maintenance_datetime'=>$from->created_at,'remark'=>json_encode($from->remark));
      if(!is_null($from->sign_at)){
        $from_data['inspector_datetime']=$from->sign_at;
      }
      $from_service->set($from_data);
      if(!is_null($from->note)){
              $audit_log_data = array('type_id'=>$from->id,'type'=>'from','update_at'=>date('Y-m-d H:i:s'),'note'=>$from->note);
              
              if(!is_null($from->note_id)){
                $audit_log_data['id']=$from->note_id;
              }
             
              $audit_log_service->set($audit_log_data);
              
               if(is_null($from->note_id)){
                  $from->note_id = $audit_log_service->insert_id();
              }
      }

   		$items =$from->items;
   		foreach ($items as &$item) {


         $item_data= array('item_name_en'=>$item->item_name_en ,'item_name_cn'=>$item->item_name_cn,'index'=>$item->index,'cycle'=>$item->cycle,
      'group'=>$item->group,'result'=>json_encode($item->result),'maintain_from_id'=>$from->id);
        



         if(!is_null($item->real_id)){
            $item_data['id']=$item->real_id;
         }
         $from_item_service->set($item_data);
         if(is_null($item->real_id)){
            $item->real_id = $from_item_service->insert_id();
         }
         
   			 $lastItem=$item;
   		}
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