<?php include('sdba/sdba.php'); ?>
<?php
    $users = Sdba::table('users');
        $users->where('username','admin');
        $user=$users->get_one();
        if($user!=null){
          
            $response["status"]=200;
            $response["message"] = "Load equipments successlly!";
            $equipments = Sdba::table('equipments');
           
            $projects= Sdba::table('projects');
             $projects= Sdba::table('projects');
            $projects->left_join('id','project_users','project_id');
            $projects->where('user_id',$user["id"],'project_users');
            $project_list=$projects->get();
            foreach ($project_list as &$project) {
                $equipments->left_join('id','user_equipments','equipment_id');
                $equipments->left_join('machine_id','machines','id');
                $equipments->where('user_id',$user["id"],"user_equipments" );
                $equipments->and_where('project_id',$project["project_id"] );
                $project["equipments"]=$equipments->get();
            }
            $response["project_list"]=$project_list;
            die(json_encode($response));
        }

?> 