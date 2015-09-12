<?php 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: X-Requested-With");
include('sdba/sdba.php'); ?>
<?php
// クライアントからのPOSTを受け取る


 // 下記をレスポンスヘッダーに含める


//$_POST['MM_update']='save_new_maintain_item_result';
//$_POST['id']=10;

if(isset($_POST['MM_update'])&&($_POST['MM_update']=='save_new_maintain_item_result')) {
	$maintain_item_results = Sdba::table('maintain_item_results');
	$maintain_item_results->where('id',$_POST['id']);
  	$maintain_item_results_list = $maintain_item_results->get();
  	$result = json_decode($maintain_item_results_list[0]['result'],true);
	
	if ($result['type'] == 'bool'){
		$result['new_value'] = $_POST['newval1'];
	}elseif($result['type'] == 's_value'){
		
		$result['new_value'] = $_POST['newval1'];

	}elseif($result['type'] == 'd_value'){
		
		$result['new_value'][0] = $_POST['newval1'];
		$result['new_value'][1] = $_POST['newval2'];
	}
	//echo json_encode($result);
	$data = array('result'=> json_encode($result));
	$maintain_item_results->update($data);
	//print_r($result);
     
}

if(isset($_POST['MM_update'])&&($_POST['MM_update']=='update_maintain_items')) {
	$maintain_items = Sdba::table('maintain_items');
	$maintain_items->where('id',$_POST['id']);
  	$total_maintain_items = $maintain_items->total();
  	$maintain_items_list = $maintain_items->get();
  	$result = json_decode($maintain_items_list[0]['result_format'],true);

  	if ($_POST['type'] == 'bool'){
     	$result['type'] = 'bool'; 
     	$result['value'] = 'false'; 
     }elseif ($_POST['type'] == 's_value'){
     	$result['type'] = 's_value'; 
     	$result['value'] = ''; 
     	$result['unit'] = $_POST['s1unit'];
     	$result['hint'] = $_POST['s1hint'];
     }elseif ($_POST['type'] == 'd_value'){
     	$result['type'] = 'd_value'; 
     	$result['value'][0] = ''; 
     	$result['value'][1] = ''; 
     	$result['unit'][0] = $_POST['d1unit'];
     	$result['hint'][0] = $_POST['d1hint'];
     	$result['unit'][1] = $_POST['d2unit'];
     	$result['hint'][1] = $_POST['d2hint'];
     }else{
     	$result['type'] = 'none'; 
     		
     }
     
     $data = array(
          'group'=> $_POST['group'],
     			'item_name_cn'=> $_POST['item_name_cn'],
     			'item_name_en'=> $_POST['item_name_en'],
     			'result_format'=> json_encode($result),
          'index'=> $_POST['index'],
          'remark'=> $_POST['remark']
	
     		);
  	$maintain_items->update($data);
  	 
  	 echo 'ok';
}

if(isset($_POST['MM_update'])&&($_POST['MM_update']=='add_maintain_items')) {
	$maintain_items = Sdba::table('maintain_items');
	 	$result=array();

  	if ($_POST['type'] == 'bool'){
     	$result['type'] = 'bool'; 
     	$result['value'] = 'false'; 
     }elseif ($_POST['type'] == 's_value'){
     	$result['type'] = 's_value'; 
     	$result['value'] = ''; 
     	$result['unit'] = $_POST['s1unit'];
     	$result['hint'] = $_POST['s1hint'];
     }elseif ($_POST['type'] == 'd_value'){
     	$result['type'] = 'd_value'; 
     	$result['value'][0] = ''; 
     	$result['value'][1] = ''; 
     	$result['unit'][0] = $_POST['d1unit'];
     	$result['hint'][0] = $_POST['d1hint'];
     	$result['unit'][1] = $_POST['d2unit'];
     	$result['hint'][1] = $_POST['d2hint'];
     }else{
     	$result['type'] = 'none'; 
     		
     }
     
     $data = array(
     			'index'=> $_POST['index'],
     			'group'=> $_POST['group'],
     			'from_type'=> $_POST['from_type'],
     			'item_name_cn'=> $_POST['item_name_cn'],
     			'item_name_en'=> $_POST['item_name_en'],
     			'result_format'=> json_encode($result)
	
     		);
  	$maintain_items->insert($data);
  	 
  	 echo 'ok';
}

if(isset($_POST['MM_update'])&&($_POST['MM_update']=='update_maintain_items_set')) {
	$maintain_item_set = Sdba::table('maintain_item_set');
	$maintain_item_set->where('id',$_POST['id']);
  	$total_maintain_item_set = $maintain_item_set->total();
  	$maintain_item_set_list = $maintain_item_set->get();
  	
  	if ($total_maintain_item_set > 0){ 
  		$maintain_item_set->delete($data);

  		echo 'ok';
  	}else{
      $maintain_item_set->where('maintain_item_id',$_POST['maintain_item_id'])->and_where('project_id',$_POST['project_id']);
      $total_delete_maintain_item_set = $maintain_item_set->total();
      $delete_maintain_item_set_list = $maintain_item_set->get();
      if($delete_maintain_item_set_list > 0){
        $maintain_item_set->delete();
      }

  		$maintain_item_set = Sdba::table('maintain_item_set');
  		$data = array('maintain_item_id'=>$_POST['maintain_item_id'],'project_id'=>$_POST['project_id'],'cycle'=>$_POST['cycle']);
		$maintain_item_set->insert($data);
		$insert_id = $maintain_item_set->insert_id();
		echo 'ok'.$insert_id;
  	}

}
if(isset($_POST['MM_update'])&&($_POST['MM_update']=='update_maintain_form')) {
	$maintain_froms = Sdba::table('maintain_froms');
	$maintain_froms->where('id',$_POST['id']);
  	$total_maintain_froms_set = $maintain_froms->total();
  	$maintain_froms_list = $maintain_froms->get();
  	
  	$data = array(
  				'inspector'=> $_POST['inspector'],
  				'inspector_datetime'=> $_POST['inspector_datetime'],
  				'maintenance_datetime'=> $_POST['maintenance_datetime'],
  				'maintenance_technician'=> $_POST['maintenance_technician'],
  				'Inspector_remark'=> $_POST['Inspector_remark']
  				
  			);
  			
	$maintain_froms->update($data);
	
	echo 'ok';

}

if(isset($_POST['MM_update'])&&($_POST['MM_update']=='update_indicators')) {
	$indicators = Sdba::table('indicators');
	$indicators->where('id',$_POST['id']);
  	//$total_indicators = $indicators->total();
  	//$indicators_list = $indicators->get();
  	
  	$data = array(
  				'type'=> $_POST['type'],
  				'channel'=> $_POST['channel'],
  				'name_en'=> $_POST['name_en'],
  				'name_cn'=> $_POST['name_cn'],
  				'unit'=> $_POST['unit'],
  				'equipments_id'=> $_POST['equipments_id'],
  				'indicator_display_style_id'=> $_POST['indicator_display_style_id'] 
  				
  			);
  			
	$indicators->update($data);
	
	echo 'ok/'.$_POST['id'].'/'.$_POST['type'].'/'.$_POST['channel'].'/'.$_POST['name_en'].'/'.$_POST['name_cn'].'/'.$_POST['unit'];

}

if(isset($_POST['MM_update'])&&($_POST['MM_update']=='add_indicators')) {
	$indicators = Sdba::table('indicators');
	//$indicators->where('id',$_POST['id']);
  	//$total_indicators = $indicators->total();
  	//$indicators_list = $indicators->get();
  	
  	$data = array(
  				'type'=> $_POST['type'],
  				'channel'=> $_POST['channel'],
  				'name_en'=> $_POST['name_en'],
  				'name_cn'=> $_POST['name_cn'],
  				'unit'=> $_POST['unit'],
  				'equipments_id'=> $_POST['equipments_id'],
  				'indicator_display_style_id'=> $_POST['indicator_display_style_id'] 
  				
  			);
  			
	$indicators->insert($data);
	
	echo 'ok';

}

if(isset($_POST['MM_update'])&&($_POST['MM_update']=='update_maintain_items_set_cycle')) {
	$maintain_item_set = Sdba::table('maintain_item_set');
	$maintain_item_set->where('id',$_POST['id']);
  	//$total_maintain_item_set = $maintain_item_set->total();
  	//$maintain_item_set_list = $maintain_item_set->get();
  	$data = array('cycle'=>$_POST['cycle']);
  	$maintain_item_set->update($data);
  	 echo 'ok';

}
if(isset($_POST['MM_update'])&&($_POST['MM_update']=='update_photo_report')) {
  $photo_reports= Sdba::table('photo_reports');
  $photo_reports->where('key',$_POST['key']);
 
    
    $data = array('text_cn'=>$_POST['text_cn'],'text_en'=>$_POST['text_en']);
    $photo_reports->update($data);
     echo 'ok';

}
if(isset($_POST['MM_del'])&&($_POST['MM_del']=='del_projects')) {

	
	$articles = Sdba::table('projects');
	$articles->where('id', $_POST['id']);	 
	$articles->delete();

	 
	echo 'ok';

}

if(isset($_POST['MM_del'])&&($_POST['MM_del']=='del_reports')) {

  
  $reports = Sdba::table('reports');
  $reports->where('id', $_POST['id']);  
  $data = array(
          'state'=> 0
        );
        
  $reports->update($data);
   
  echo 'ok';

}
if(isset($_POST['MM_del'])&&($_POST['MM_del']=='del_equipments')) {

	$user_equipments = Sdba::table('user_equipments');
	$user_equipments->where('equipment_id', $_POST['id']);	 
	$user_equipments->delete();
	
	$equipment_attributes = Sdba::table('equipment_attributes');
  	$equipment_attributes->where('equipment_id',$_POST['id']);
  	$equipment_attributes->delete();
	
	$indicators = Sdba::table('indicators');
	$indicators->where('equipments_id', $_POST['id']);	 
	$indicators->delete();
	 
	$equipments = Sdba::table('equipments');
	$equipments->where('id', $_POST['id']);	 
	$total_equipments = $equipments->total();
	$equipments_list = $equipments->get();
	/*
	unlink('photo/equipment/'.$equipments_list[0]['photo']);
	
	$gallerys = json_decode($equipments_list[0]['gallery'],true);
	foreach($gallerys as $value){
		unlink('photo/equipment/'.$value);
	}
	*/
	$equipments->delete();
	
	
	
	
	echo 'ok';

}

if(isset($_POST['MM_del'])&&($_POST['MM_del']=='del_gallery')) {
	
	$gid = $_POST['gid'];
	
	$equipments = Sdba::table('equipments');
	$equipments->where('id', $_POST['id']);	 
	$total_equipments = $equipments->total();
	$equipments_list = $equipments->get();
	
	$gallerys = json_decode($equipments_list[0]['gallery'],true);
	
	//unlink('photo/equipment/'.$gallerys[$gid]);
	unset($gallerys[$gid]);
	$gallery = array();
	foreach($gallerys as $value){
		$gallery[] = $value;
	}
	
	$data = array(
		'gallery'=> json_encode($gallery)
	);
	$equipments ->update($data);
	
	//print_r($gallery);
	
	echo 'ok';

}

if(isset($_POST['MM_copy'])&&($_POST['MM_copy']=='copy_equipments')) {
 	$equipments = Sdba::table('equipments');
	$equipments->where('id', $_POST['id']);	 
	$total_equipments = $equipments->total();
	$equipments_list = $equipments->get();
	
	$data = array(
  				'project_id'=> $equipments_list[0]['project_id'],
  				'model_id'=> $equipments_list[0]['model_id'],
  				'type'=> $equipments_list[0]['type'],
  				'phone_num'=> $equipments_list[0]['phone_num'],
  				'ref_no'=> $equipments_list[0]['ref_no'],
  				'photo'=> $equipments_list[0]['photo'],
  				'gallery'=> $equipments_list[0]['gallery'],
  				'com_method'=> $equipments_list[0]['com_method'],
  				'note'=> $equipments_list[0]['note'] 
  				
  			);
  	$equipments->insert($data);
  	$insert_id = $equipments->insert_id();
  	
  	$equipment_attributes = Sdba::table('equipment_attributes');
  	$equipment_attributes->where('equipment_id',$_POST['id']);
  	$total_equipment_attributes = $equipment_attributes->total();
  	$equipment_attributes_list = $equipment_attributes->get();	
  	
  	for ($j=0; $j<$total_equipment_attributes; $j++){	
  		$data = array(
  				'equipment_id'=> $insert_id,
  				'equipment_attribute_name_id'=> $equipment_attributes_list[$j]['equipment_attribute_name_id'],
  				'value'=> $equipment_attributes_list[$j]['value']
  			);
  		$equipment_attributes->insert($data);
  	}
  		
  	
  	$indicators = Sdba::table('indicators');
	$indicators->where('equipments_id', $_POST['id']);	
	$total_indicators = $indicators->total();
  	$indicators_list = $indicators->get();
  	
  	for ($i=0; $i<$total_indicators; $i++){
  		$data = array(
  				'type'=> $indicators_list[$i]['type'],
  				'channel'=> $indicators_list[$i]['channel'],
  				'name_en'=> $indicators_list[$i]['name_en'],
  				'name_cn'=> $indicators_list[$i]['name_cn'],
  				'unit'=> $indicators_list[$i]['unit'],
  				'equipments_id'=> $insert_id,
  				'indicator_display_style_id'=> $indicators_list[$i]['indicator_display_style_id'] 
  				
  			);
  		$indicators->insert($data);
  	}
	 
	echo 'ok';

}

if(isset($_POST['MM_del'])&&($_POST['MM_del']=='del_indicators')) {

	
	$indicators = Sdba::table('indicators');
	$indicators -> where('id', $_POST['id']);	 
	$indicators->delete();

	 
	echo 'ok';

}
if(isset($_POST['MM_get'])&&($_POST['MM_get']=='get_indicator_photo')) {

	
	$indicator_display_styles = Sdba::table('indicator_display_styles');
	$indicator_display_styles -> where('id', $_POST['id']);	 
	$indicator_display_styles_list = $indicator_display_styles->get();

	 
	echo $indicator_display_styles_list[0]['exm_photo'];

}
?>