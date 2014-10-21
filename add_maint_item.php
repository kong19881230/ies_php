<?php include('sdba/sdba.php'); ?>
<?php
// クライアントからのPOSTを受け取る


 
// 下記をレスポンスヘッダーに含める
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: X-Requested-With");


if(isset($_POST['maint_items'])) {
    $froms = json_decode($_POST['maint_items']);
    $maintain_item_service = Sdba::table('maintain_items');
    $maintain_item_set_service = Sdba::table('maintain_item_set');
    //$report->customer_id
    
     foreach ($froms as &$from) {
      #'device_photo_id'=>$from->device_photo_id
   		$items =$from->items;
   		foreach ($items as &$item) {
         $item_data= array('item_name_en'=>$item->item_name_en ,'item_name_cn'=>$item->item_name_cn,'index'=>$item->index,
      'group'=>$item->group,'result_format'=>json_encode($item->result),'from_type'=>$from->from_type);
         $maintain_item_service->insert($item_data);
         $item_id = $maintain_item_service->insert_id();
         foreach($item->projects as $project_id => $project) {
            $item_set_data= array('maintain_item_id'=>$item_id ,'project_id'=>(int)$project_id,'cycle'=>$project->cycle);
            $maintain_item_set_service->insert($item_set_data);
        }
         
   		}
	}
      
    echo json_encode($froms);
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