<?php include('sdba/sdba.php'); ?>
<?php
// クライアントからのPOSTを受け取る
$main_report = $_POST['main_report'];
$device_model = $_POST['device_model'];
$device_id = $_POST['device_id'];
$company = $_POST['company'];
$submit_by = $_POST['submit_by'];
// 何らかの処理（サンプルなので加算するだけ）

 
// 下記をレスポンスヘッダーに含める
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: X-Requested-With");



$report = Sdba::table('report');
$data = array('description'=>$main_report ,'device_model'=>$device_model,'device_id'=>$device_id,'company_id'=>$company,'name'=>'Emergency Report','submit_by'=>$submit_by,'type'=>1);

$report->insert($data);

// 処理結果($result)などクライアントに返す値を連想配列で設定し、json_encodeを通す。
// 処理結果($result)などクライアントに返す値を連想配列で設定し、json_encodeを通す。
//$result='success';
echo 'success';
//print_r($data);
//print json_encode(array('result' => $result));
?>