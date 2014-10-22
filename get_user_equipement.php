<?php include('sdba/sdba.php'); ?>
<?php

    if ( isset($_POST["txtUName"]) && !empty($_POST["txtUName"]) &&isset($_POST["txtToken"]) ) { 

        $Uname = $_POST["txtUName"];
        $Token = $_POST["txtToken"];


  
    	$users = Sdba::table('users');
    	$users->where('username',$Uname)->and_where('curren_token',$Token);
    	$user=$users->get_one();
        if($user!=null){
          
            $response["status"]=200;
            $response["message"] = "Load equipements successlly!";
            $user_equipements = Sdba::table('user_equipements');
            $user_equipements->left_join('equipement_id','equipements','id');
            $user_equipements->where('user_id',$user->id );
            $equipements=$user_equipements->get();
            $projects= Sdba::table('projects');
            $projects->where('id',$user->project_id);
            $project=$projects->get_one();
            $response["project"]=$project;
            $response["equipements"]=$equipements;
            die(json_encode($response));
        }
        else {
            $response["status"]=400;
       		$response["message"] = "User name or token is incorrected!";
       		die(json_encode($response));
        }



    }
?> 