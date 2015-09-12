<?php

// Custom validation for the about field
// function validate_custom_field_about($val) {
// 	return false;
// }

// Checks if the user is logged
function is_user_logged_in() {
	$EL = EasyLogin::getInstance();
	return $EL->is_logged();
}

// Returns id / name / username / avatar / role (eg: current_user('username'))
function current_user($var = null) {
	$EL = EasyLogin::getInstance();
	return $EL->get_current_user($var);
}

// Returns current user id
function get_current_user_id() {
	$EL = EasyLogin::getInstance();
	return $EL->current_user('id');
}

// Returns user avatar by id
function get_user_avatar($user_id, $size = 200) {
	$EL = EasyLogin::getInstance();
	return $EL->get_user_avatar($user_id, $size);
}

// Returns raw data from database (users & usermeta)
function get_userdata($user_id) {
	$EL = EasyLogin::getInstance();
	return $EL->get_userdata($user_id);
}

// Returns user meta
function get_usermeta($user_id, $meta_key) {
	$EL = EasyLogin::getInstance();
	return $EL->get_usermeta($user_id, $meta_key);
}

// Add user meta
function add_usermeta($user_id, $meta_key, $meta_value) {
	$EL = EasyLogin::getInstance();
	return $EL->add_usermeta($user_id, $meta_key, $meta_value);
}

// Update user meta
function update_usermeta($user_id, $meta_key, $meta_value) {
	$EL = EasyLogin::getInstance();
	return $EL->update_usermeta($user_id, $meta_key, $meta_value);
}

// Delete user meta
function delete_usermeta($user_id, $meta_key) {
	$EL = EasyLogin::getInstance();
	return $EL->delete_usermeta($user_id, $meta_key);
}

// Sign out the current user
function signout() {
	$EL = EasyLogin::getInstance();
	$EL->signout();
}

// Returns all users
function get_users() {
	$EL = EasyLogin::getInstance();
	return $EL->get_users();
}

// Loads the modal templates
function load_templates() {
	require_once( dirname(__FILE__).'/templates.php' );
}

function json_success($data = array()) {
	echo json_encode(array('success' => true, 'data' => $data));
}

function json_error($data = array()) {
	echo json_encode(array('success' => false, 'data' => $data));
}
?>