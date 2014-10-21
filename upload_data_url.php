<?php include('sdba/sdba.php'); ?>
<?php

 
// 下記をレスポンスヘッダーに含める
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: X-Requested-With");
if ( isset($_POST["image"]) && !empty($_POST["image"]) ) { 
	$id=$_POST['id'];
	$dataURL = $_POST["image"];
	$new_image_name = $id.".png";
	$parts = explode(',', $dataURL);  
    $data = $parts[1];  

    // Decode base64 data, resulting in an image
    $data = base64_decode($data);  

    // create a temporary unique file name
    $file = "upload/" . $new_image_name;

    // write the file to the upload directory
    $success = file_put_contents($file, $data);
	if($success){

		$photos_service = Sdba::table('photos');
		$photo_data = array('state'=>'u','id'=>$id,'remote'=>$new_image_name);

		$photos_service->set($photo_data);
		echo "success";
	}else{
		echo "error";
	}




}
?>