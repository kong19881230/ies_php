<?php include('sdba/sdba.php'); ?>
<?php
require_once('easylogin/includes/load.php');

function RandomString()
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randstring = '';
    for ($i = 0; $i < 10; $i++) {
        $randstring .= $characters[rand(0, strlen($characters))];
    }
    return $randstring;
}
if ( isset($_POST["txtUName"]) && !empty($_POST["txtUName"]) &&isset($_POST["txtPass"]) ) { 

$Uname = $_POST["txtUName"];
$Pass = $_POST["txtPass"];

$EL = EasyLogin::getInstance();


    if ( $EL->signin($Uname, $Pass, false) ) {
    	$users = Sdba::table('users');
		$users->where('username',$Uname);
		$user=$users->get_one();
      	$response["token"]=RandomString();
        $response["status"]=200;
        $response["message"] = "Login Success!";
        $user['current_token'] = $response["token"];
		$users->set($user); 
        die(json_encode($response));
    }
    else {
        $response["status"]=400;
   		$response["message"] = "User name or password is incorrected!";
   		die(json_encode($response));
    }


}else{
	  $response["status"]=500;
   		$response["message"] = "User name or password is empty!";
   		die(json_encode($response));
}
?> 