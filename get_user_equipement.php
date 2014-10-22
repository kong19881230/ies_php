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
            $user_equipments = Sdba::table('equipments');
           
            $projects= Sdba::table('projects');
             $projects= Sdba::table('projects');
            $projects->left_join('id','project_users','project_id');
            $projects->where('user_id',$user["id"],'project_users');
            $project_list=$projects->get();
            foreach ($project_list as &$project) {
                $user_equipments->left_join('id','user_equipments','equipment_id');
                $user_equipments->where('user_id',$user["id"],"user_equipments" );
                $user_equipments->and_where('project_id',$project["project_id"] );
                $project["equipments"]=$user_equipments->get();
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