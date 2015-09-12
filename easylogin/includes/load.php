<?php
@session_start();

spl_autoload_register(function($class) {
	if (in_array($class, array('EasyLogin', 'Database'))) {
		require_once(dirname(__FILE__) . "/$class.class.php");
	}
});

require_once(dirname(__FILE__) . '/functions.php');

$EL = EasyLogin::getInstance();
$EL->load_config( dirname(__FILE__).'/../config.php' );
$EL->db = new Database();


// Check if the user & pass is set in cookie
if (!$EL->is_logged()) {
	$session_name = $EL->config_item('session_name');
	$cookie = base64_decode(@$_COOKIE[$session_name]);
	$cookie = explode('/', $cookie); // $cookie[0] - user | $cookie[1] - pass

	if (isset($cookie[0], $cookie[1])) {
		if ( !$EL->signin($cookie[0], $cookie[1], true, false) ) {
			$EL->set_cookie($session_name, '');
		}
	}
}