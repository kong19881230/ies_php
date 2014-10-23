<?php include('sdba/sdba.php'); ?>
<?php

    if ( isset($_POST["txtUName"]) && !empty($_POST["txtUName"]) &&isset($_POST["txtToken"]) ) { 

        $Uname = $_POST["txtUName"];
        $Token = $_POST["txtToken"];


  
    	$users = Sdba::table('users');
    	$users->where('username',$Uname)->and_where('current_token',$Token);
    	$user=$users->get_one();
        if($user!=null){
          
              $response["status"]=200;
                $response["message"] = "Load equipments successlly!";
               
                $projects->fields('name_en');
                $projects->fields('name_cn');
                $projects->left_join('id','project_users','project_id');
                $projects->where('user_id',$user["id"],'project_users');
                $project_list=$projects->get();
                foreach ($project_list as &$project) {
                
                    $equipments->fields('machine_id');
                    $equipments->fields('phone_num');
                    $equipments->fields('ref_no');
                    $equipments->fields('photo');
                    $equipments->fields('type',false,'machines');
                    $equipments->fields('model_id',false,'machines');
                    $equipments->fields('model_id',false,'machines');
                    $equipments->fields('equipment_id',false,'user_equipments');
                   // $equipments->fields('type','model_id','name','description',false,'machines');
                    
                    $equipments->left_join('id','user_equipments','equipment_id');
                    $equipments->left_join('machine_id','machines','id');
                    $equipments->where('user_id',$user["id"],"user_equipments" );
                    $equipments->and_where('project_id',$project["project_id"] );

                    $project["equipments"]=$equipments->get();

                    foreach ($project["equipments"] as &$equipment) {
                        $machine_attributes->fields('value');
                        $machine_attributes->fields('name_en',false,'machine_attribute_names');
                         $machine_attributes->fields('name_cn',false,'machine_attribute_names');
                        $machine_attributes->left_join('machine_attribute_name_id','machine_attribute_names','id');
                         $machine_attributes->fields('name_en','name_cn',true,'machine_attribute_names');
                        $machine_attributes->where('machine_id',$equipment["machine_id"] );
                        $equipment["machine_attributes"]=$machine_attributes->get();
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