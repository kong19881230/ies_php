<?php include('sdba/sdba.php'); ?>
<?php require 'security/processor.php';	?>
<?php 
define('EL_ADMIN', true);

require_once('easylogin/includes/load.php');
$EL = EasyLogin::getInstance();

if (isset($_GET['logout'])) {
	$EL->signout();
	header('Location: login.php');
}

// Check if is logged
if (!$EL->is_logged()) {
	header('Location: login.php');
}

// Check if is admin
if ( $EL->get_current_user('role') != 'admin' ) {
	die('<h2>You do not have sufficient permissions to access this page</h2>');
}

if (!isset($_GET['page'])) {
		$_GET['page'] = 'home';
}
?>