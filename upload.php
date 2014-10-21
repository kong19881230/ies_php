<?php include('sdba/sdba.php'); ?>
<?php
// クライアントからのPOSTを受け取る


 
// 下記をレスポンスヘッダーに含める
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: X-Requested-With");
$id=$_POST['id'];
$result=print_r($_FILES,true);
$photos_service = Sdba::table('photos');
$new_image_name = $id.".jpg";
move_uploaded_file($_FILES["file"]["tmp_name"], "upload/".$new_image_name);
$photo_data = array('state'=>'u','id'=>$id,'remote'=>$new_image_name);
$photos_service->set($photo_data);

echo $result;
?>