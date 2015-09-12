<?php

function get_filename($object_id, $type) {
    return substr(md5( $object_id ), 0 , 20); 
}

function imgPickerDB($image, $object_id, $type = '', $data = array()) {
    $EL = EasyLogin::getInstance();
    $user_id = $EL->get_current_user('id');
	$EL->update_usermeta($user_id, 'avatar', $image);
}

?>