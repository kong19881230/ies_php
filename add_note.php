<?php include('sdba/sdba.php'); ?>
<?php

    if ( isset($_POST["txtUName"]) && !empty($_POST["txtUName"]) &&isset($_POST["txtToken"]) ) { 

        $Uname = $_POST["txtUName"];
        $Token = $_POST["txtToken"];
        $note = $_POST["note"];
        $equipment_id = $_POST["equipment_id"];
         $equipments = Sdba::table('equipments');

    	$users = Sdba::table('users');
    	$users->where('username',$Uname)->and_where('current_token',$Token);
    	$user=$users->get_one();
        if($user!=null){
          
             
               
                $equipments->where('id',$equipment_id ); 
                $equipment=$equipments ->get_one();
                if($equipment!=null){
                       $response["status"]=200;
                      $equipment["note"].="\n".$note;
                     $equipments->set($equipment);
                     $response["equipment_note"]=$equipment["note"];

                      $response["message"] = "Add equipment note successlly!";
                       die(json_encode($response));
                }else{
                       $response["status"]=410;
                       $response["message"] = "Equipment is not found!";
                       die(json_encode($response));
                }

              
             
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