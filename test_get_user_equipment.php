    <?php include('sdba/sdba.php'); ?>
    <?php
        $users = Sdba::table('users');
            $users->where('username','admin');
            $user=$users->get_one();
            $machine_attributes= Sdba::table('machine_attributes');
             $equipments = Sdba::table('equipments');
               $indicators= Sdba::table('indicators');
                 $projects= Sdba::table('projects');
            if($user!=null){
              
                $response["status"]=200;
                $response["message"] = "Load equipments successlly!";
               
                $projects->fields('name_en');
                $projects->fields('name_cn');
                $equipments->fields('photo');
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
                     
                        $machine_attributes->where('machine_id',$equipment["machine_id"] );
                        $equipment["machine_attributes"]=$machine_attributes->get();

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

    ?> 