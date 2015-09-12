  <?php include('sdba/sdba.php'); ?>
  <?php

       if ( isset($_POST["txtUName"]) && !empty($_POST["txtUName"]) &&isset($_POST["txtToken"]) ) { 

          $Uname = $_POST["txtUName"];
           $Token = $_POST["txtToken"];
           $equipments = Sdba::table('equipments');
                 
           $projects= Sdba::table('projects');
           $photo_reports= Sdba::table('photo_reports');
           
       
          if(strcmp($Uname, "iesreport") == 0 && strcmp($Token, "iespass") == 0){
            
                  $response["status"]=200;
                  $response["message"] = "Load Update Info successlly!";


                  $photo_report_list= $photo_reports->get();
                  
                  
                  foreach ($photo_report_list as &$photo_report) {
                     $photo_report_hash[$photo_report["key"]]["text_cn"]= $photo_report["text_cn"];
                  }
                   $response["photo_report_hash"]= $photo_report_hash;
                  $projects->fields('id');
                  $projects->fields('name_en');
                  $projects->fields('name_cn');
                  $projects->fields('seq');
                  $projects->fields('created_at');
                  $projects->fields('cycle_types');
                  $projects->fields('machine_types');
                  $projects->where('region',"mo");
                  $project_list=$projects->get();
                  foreach ($project_list as &$project) {
                  
                      $equipments->fields('model_id');
                      $equipments->fields('ref_no');
                      $equipments->fields('type');
                      $equipments->where('project_id',$project["id"] );

                      $equipment_list=$equipments->get();

                      $project["cycles"]=json_decode($project["cycle_types"],true);
                     
                      unset( $project["cycle_types"]);

                      $project["catalogs"]=json_decode($project["machine_types"],true);
                      unset( $project["machine_types"]);
                      foreach ($equipment_list as &$e) {
                          $model=$e["model_id"];
                          unset( $e["model_id"]);
                          $e["model"]=$model;
                           $project["eq_lists"][$e["type"]][$e["ref_no"]]=$e;
                      }
                  }
                  $response["project_list"]=$project_list;

                  $machine_types = Sdba::table('machine_types');
                   $maintain_items = Sdba::table('maintain_items');
                    $maintain_item_sets = Sdba::table('maintain_item_set');
                   
                  $machine_type_list= $machine_types->get();

                  foreach ($machine_type_list as &$machine_type) {
                       $maintain_items->where('from_type',$machine_type["name"] );
                       $maintain_items->order_by('index');
                       $maintain_item_list=$maintain_items->get();
                        foreach ($maintain_item_list as &$maintain_item) {
                          $maintain_item["result"]=json_decode($maintain_item["result_format"]);
                          unset( $maintain_item["result_format"]);
                          $maintain_item_sets->where('maintain_item_id',$maintain_item["id"]);
                          $maintain_item_sets->where('cycle >',0);
                          $maintain_item_set_list=$maintain_item_sets->get();
                          $maintain_item["projects"]=array();
                          foreach ($maintain_item_set_list as &$maintain_item_set) {
                            $m_project_id= $maintain_item_set["project_id"];
                            unset( $maintain_item_set["id"]);
                            unset( $maintain_item_set["maintain_item_id"]);
                             unset( $maintain_item_set["project_id"]);
                            $maintain_item["projects"][$m_project_id]=$maintain_item_set;

                          }
                        }
                       $maintain_item_hash[$machine_type["name"]]=$maintain_item_list;
                  }
                  $response["from_items_hash"]= $maintain_item_hash;
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