<?php include('sdba/sdba.php'); ?>
<?php

    if ( isset($_POST["txtUName"]) && !empty($_POST["txtUName"]) &&isset($_POST["txtToken"]) ) { 

        $Uname = $_POST["txtUName"];
        $Token = $_POST["txtToken"];
         $equipment_attributes= Sdba::table('equipment_attributes');
         $equipments = Sdba::table('equipments');
               
         $projects= Sdba::table('projects');

           $indicators= Sdba::table('indicators');
    	$users = Sdba::table('users');
    	$users->where('username',$Uname)->and_where('current_token',$Token);
    	$user=$users->get_one();
        if($user!=null){
          
              $response["status"]=200;
                $response["message"] = "Load equipments successlly!";
               
                $projects->fields('name_en');
                $projects->fields('photo');
                $projects->fields('name_cn');
                $projects->left_join('id','project_users','project_id');
                $projects->where('user_id',$user["id"],'project_users');
                $project_list=$projects->get();
                foreach ($project_list as &$project) {
                
                    $equipments->fields('phone_num');
                    $equipments->fields('ref_no');
                     $equipments->fields('note');
                    $equipments->fields('photo');
                    $equipments->fields('type');
                    $equipments->fields('model_id');
                     $equipments->fields('gallery');
                     $equipments->fields('com_method');
                    $equipments->fields('equipment_id',false,'user_equipments');
                   // $equipments->fields('type','model_id','name','description',false,'machines');
                    
                    $equipments->left_join('id','user_equipments','equipment_id');
                   
                    $equipments->where('user_id',$user["id"],"user_equipments" );
                    $equipments->and_where('project_id',$project["project_id"] );

                    $project["equipments"]=$equipments->get();

                    foreach ($project["equipments"] as &$equipment) {
                        $equipment_attributes->fields('value');
                        $equipment_attributes->fields('name_en',false,'equipment_attribute_names');
                         $equipment_attributes->fields('name_cn',false,'equipment_attribute_names');
                        $equipment_attributes->left_join('equipment_attribute_name_id','equipment_attribute_names','id');
                         $equipment_attributes->fields('name_en','name_cn',true,'equipment_attribute_names');
                        $equipment_attributes->where('equipment_id',$equipment["equipment_id"] );
                        $equipment["equipment_attributes"]=$equipment_attributes->get();


                           $indicators->fields('type');
                        $indicators->fields('channel');
                        $indicators->fields('name_en');
                        $indicators->fields('name_cn');
                        $indicators->fields('unit');
                        $indicators->fields('equipments_id');
                        $indicators->fields('normal_status',false,'indicator_display_styles');
                        $indicators->fields('is_show_text',false,'indicator_display_styles');
                         $indicators->fields('style_type',false,'indicator_display_styles');
                        $indicators->left_join('indicator_display_style_id','indicator_display_styles','id');
                         $indicators->where('equipments_id',$equipment["equipment_id"] );
                         $equipment["indicators"]=$indicators->get();
                    }
                }
                $response["project_list"]=$project_list;
                die(json_encode($response));
        }
        else {
            $response["status"]=400;
       		$response["message"] = "User name or token is incorrected!";
       		die(json_encode($response));
        }



    }else{
      $response["status"]=500;
        $response["message"] = "User name or token is empty!";
        die(json_encode($response));
    }
?> 