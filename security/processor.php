<?php
session_start();

//報告類型
$reports_type = array(
    '0' => "Maintenance Report",
    '1' => "Service Report " 
);
//報告類型連結
$reports_type_link = array(
    '0' => "?page=maintain_froms",
    '1' => "?page=emergency_details_view" 
);

//檢查周期
$reports_cycles_cn = array(
    '1' => "月檢",
    '2' => "雙月檢",
    '3' => "三月檢",
    '6' => "半年檢" ,
    '12' => "年檢" 
);

$reports_cycles_en = array(
    '1' => "Monthly",
    '2' => "Even Monthly",
    '3' => "three Monthly",
    '6' => "Semi-Annually" ,
    '12' => "Annually" 
);

//類型
$from_type = array(
    'boiler' => "熱水煱爐",
    'sboiler'=>"蒸氣煱爐",
    'heat' => "熱交換器",
    'chimney' => "煙通系統",
    'cpump'=>"熱煤循環泵",
    'calorifier'=>"熱水加熱器",
    'opump'=>"供油泵"
);

//空值表示
function chkempty($A){
  if (!isset($A)){
  	$show =  'N/A';
  }elseif (empty($A)){
  	$show =  'N/A';
  }elseif ($A==''){
  	$show =  'N/A';
  }elseif ($A =='0000-00-00'){
  	$show =  '';
  }else{
  	$show = $A; 
  }
  
  return $show; 
}

//符號編碼
function like_photo($id){
$photos = Sdba::table('photos');
//$maintain_item_results->where('from_type','heat');
$photos->like('id', $id);
//$photos->where('id',$_GET['id'].'-b12');
//$maintain_item_results->sort_by('maintain_from_id');
$total_photos = $photos->total();
$photos_list = $photos->get();

return $total_photos;
}

function is_photo($id){
$photos = Sdba::table('photos');
//$maintain_item_results->where('from_type','heat');
$photos->where('id', $id);
//$photos->where('id',$_GET['id'].'-b12');
//$maintain_item_results->sort_by('maintain_from_id');
$total_photos = $photos->total();
$photos_list = $photos->get();

return $total_photos;
}

//security
$key = strip_tags(trim($_POST["key"]));

$seq = strip_tags(trim($_POST["seq"]));
$con_espr_date = strip_tags(trim($_POST["con_espr_date"]));
$con_start_date = strip_tags(trim($_POST["con_start_date"]));
$maintain_type = strip_tags(trim($_POST["maintain_type"]));
$report_style = strip_tags(trim($_POST["report_style"]));
$device_position = strip_tags(trim($_POST["device_position"]));
$contact_person = strip_tags(trim($_POST["contact_person"]));
$contact_phone = strip_tags(trim($_POST["contact_phone"]));

$remark = strip_tags(trim($_POST["remark"]));
$updated_at = strip_tags(trim($_POST["updated_at"]));
//$cycle_types = strip_tags(trim($_POST["cycle_types"]));
//$machine_types = strip_tags(trim($_POST["machine_types"]));
$name_cn = strip_tags(trim($_POST["name_cn"]));
$name_en = strip_tags(trim($_POST["name_en"]));


$problem_reported = strip_tags(trim($_POST["problem_reported"]));
$is_system_down = strip_tags(trim($_POST["is_system_down"]));
$reported_by = strip_tags(trim($_POST["reported_by"]));
$device_model = strip_tags(trim($_POST["device_model"]));
$device_id = strip_tags(trim($_POST["device_id"]));
$power = strip_tags(trim($_POST["power"]));
$machine_type = strip_tags(trim($_POST["machine_type"]));
$location = strip_tags(trim($_POST["location"]));
$engineer_remarks = strip_tags(trim($_POST["engineer_remarks"]));
$inspection_found = strip_tags(trim($_POST["inspection_found"]));
$status_after_service = strip_tags(trim($_POST["status_after_service"]));
$remarks = strip_tags(trim($_POST["remarks"]));
$contact_name = strip_tags(trim($_POST["contact_name"]));
$designation = strip_tags(trim($_POST["designation"]));
$signature = strip_tags(trim($_POST["signature"]));
$phone = strip_tags(trim($_POST["phone"]));
$fax = strip_tags(trim($_POST["fax"]));
$email = strip_tags(trim($_POST["email"]));

$name = strip_tags(trim($_POST["name"]));
$type = strip_tags(trim($_POST["type"]));
$description = strip_tags(trim($_POST["description"]));
$model_id = strip_tags(trim($_POST["model_id"]));

$machine_id = strip_tags(trim($_POST["machine_id"]));
$phone_num = strip_tags(trim($_POST["phone_num"]));
$ref_no = strip_tags(trim($_POST["ref_no"]));
$photo = strip_tags(trim($_POST["photo"]));

$finalproblem_reported = htmlspecialchars($problem_reported, ENT_QUOTES, 'UTF-8');
$finalis_system_down = htmlspecialchars($is_system_down, ENT_QUOTES, 'UTF-8');
$finalreported_by = htmlspecialchars($reported_by, ENT_QUOTES, 'UTF-8');
$finaldevice_model = htmlspecialchars($device_model, ENT_QUOTES, 'UTF-8');
$finaldevice_id = htmlspecialchars($device_id, ENT_QUOTES, 'UTF-8');
$finalpower = htmlspecialchars($power, ENT_QUOTES, 'UTF-8');
$finalmachine_type = htmlspecialchars($machine_type, ENT_QUOTES, 'UTF-8');
$finallocation = htmlspecialchars($location, ENT_QUOTES, 'UTF-8');
$finalengineer_remarks = htmlspecialchars($engineer_remarks, ENT_QUOTES, 'UTF-8');
$finalinspection_found = htmlspecialchars($inspection_found, ENT_QUOTES, 'UTF-8');
$finalstatus_after_service = htmlspecialchars($status_after_service, ENT_QUOTES, 'UTF-8');
$finalremarks = htmlspecialchars($remarks, ENT_QUOTES, 'UTF-8');
$finalcontact_name = htmlspecialchars($contact_name, ENT_QUOTES, 'UTF-8');
$finaldesignation = htmlspecialchars($designation, ENT_QUOTES, 'UTF-8');
$finalsignature = htmlspecialchars($signature, ENT_QUOTES, 'UTF-8');
$finalphone = htmlspecialchars($phone, ENT_QUOTES, 'UTF-8');
$finalfax = htmlspecialchars($fax, ENT_QUOTES, 'UTF-8');
$finalemail = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');

$finalname = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
$finaltype = htmlspecialchars($type, ENT_QUOTES, 'UTF-8');
$finaldescription = htmlspecialchars($description, ENT_QUOTES, 'UTF-8');
$finalmodel_id = htmlspecialchars($model_id, ENT_QUOTES, 'UTF-8');

$finalmachine_id = htmlspecialchars($machine_id, ENT_QUOTES, 'UTF-8');
$finalphone_num = htmlspecialchars($phone_num, ENT_QUOTES, 'UTF-8');
$finalref_no = htmlspecialchars($ref_no, ENT_QUOTES, 'UTF-8');
$finalphoto = htmlspecialchars($photo, ENT_QUOTES, 'UTF-8');
$finaltype = htmlspecialchars($type, ENT_QUOTES, 'UTF-8');
$finalmodel_id = htmlspecialchars($model_id, ENT_QUOTES, 'UTF-8');

$finalkey = htmlspecialchars($key, ENT_QUOTES, 'UTF-8');
$finalseq = htmlspecialchars($seq, ENT_QUOTES, 'UTF-8');
$finalcon_espr_date = htmlspecialchars($con_espr_date, ENT_QUOTES, 'UTF-8');
$finalcon_start_date = htmlspecialchars($con_start_date, ENT_QUOTES, 'UTF-8');
$finalmaintain_type = htmlspecialchars($maintain_type, ENT_QUOTES, 'UTF-8');
$finalreport_style = htmlspecialchars($report_style, ENT_QUOTES, 'UTF-8');
$finaldevice_position = htmlspecialchars($device_position, ENT_QUOTES, 'UTF-8');
$finalcontact_person = htmlspecialchars($contact_person, ENT_QUOTES, 'UTF-8');
$finalcontact_phone = htmlspecialchars($contact_phone, ENT_QUOTES, 'UTF-8');

$finalremark = htmlspecialchars($remark, ENT_QUOTES, 'UTF-8');
$finalupdated_at = htmlspecialchars($updated_at, ENT_QUOTES, 'UTF-8');
$finalcycle_types = htmlspecialchars($cycle_types, ENT_QUOTES, 'UTF-8');
$finalmachine_types = htmlspecialchars($machine_types, ENT_QUOTES, 'UTF-8');
$finalname_cn = htmlspecialchars($name_cn, ENT_QUOTES, 'UTF-8');
$finalname_en = htmlspecialchars($name_en, ENT_QUOTES, 'UTF-8');

function squarenailByGd($dir, $file, $sizex, $sizey,$fname) {
	//echo $dir.'/'.$file.'/'. $sizex.'/'.$sizey.'/'.$fname;
    $ratioSize =380; // 預先縮圖，無論圖片大小，先強制縮成指定像素為基準的大小
    $realPosition = $dir . $file; // 圖片加路徑
    $thumbDir = $dir; // 縮圖目錄

    if (file_exists($realPosition)) {
        $fileName = current(explode('.', $file)); // 檔名
        $ext = strtolower(end(explode('.', $realPosition))); // 副檔名
        $newName =  $fname; //新檔名
        
        // 如果該縮圖存在則直接出圖
        if (file_exists($thumbDir . $newName)) {
            echo '<img src="' . $thumbDir . $newName . '" />';
            return;
        }
        
        switch ($ext) {
            case 'jpg':
            case 'jpeg':
                $src = imagecreatefromjpeg($realPosition);
                break;
            case 'gif':
                $src = imagecreatefromgif($realPosition);
                break;
            case 'png':
                $src = imagecreatefrompng($realPosition);
                break;
        }
        
        $srcW = imagesx($src); // 原始寬度
        $srcH = imagesy($src); // 原始高度
        
        if ($srcW >= $srcH) {
            // 以高來等比例縮第一次圖
            $newW = ceil($srcW / $srcH * $ratioSize); // 新寬度
            $newH = $ratioSize; // 新高度
        } else {
            // 以寬來等比例縮第一次圖
            $newW = $ratioSize; // 新寬度
            $newH = ceil($srcH / $srcW * $ratioSize); // 新高度
        }
        
        // 縮第一次圖
        $im = imagecreatetruecolor($newW, $newH);
        imagecopyresampled($im, $src, 0, 0, 0, 0, $newW, $newH, $srcW, $srcH);
        
        // 縮需求大小的圖
        $im2 = imagecreatetruecolor($sizex, $sizey);
        $coordX = ($newW - $sizex) / 2;
        $coordY = ($newH - $sizey) / 2;

        imagecopyresampled($im2, $im, 0, 0, $coordX, $coordY, $newW, $newH, $newW, $newH);
        
        imagejpeg($im, $thumbDir . $newName, 90); //輸出
        imagedestroy($im);
        imagedestroy($im2);
		unlink($dir.$file);

        //echo '<img src="' . $thumbDir . $newName . '" />';
    }
}
?>
