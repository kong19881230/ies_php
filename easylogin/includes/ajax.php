<?php

require_once('load.php');
$EL = EasyLogin::getInstance();

$url_components = parse_url( $EL->config_item('script_url') );
if (isset($url_components['host'])) {
	$host = $url_components['host'];
	$host = (substr($host, 0, 3) == 'www') ? substr($host, 0, 4) : $host;

	header("Access-Control-Allow-Origin: $host");
	header("Access-Control-Allow-Origin: www.$host");
}

if (isset($_POST['action'])) {
	switch ($_POST['action']) {
		
		case 'signin':
			if ($EL->is_logged()) die();

			if (isset($_POST['remember']))
				$_POST['remember'] = true;
			parse_str($_POST['data']);
			if ( $EL->signin($username, $password, @$remember) )
				json_success( $EL->config_item('login_redirect') );
			else 
				json_error( $EL->errors );
		break;

		case 'signup':
			if ($EL->is_logged()) die();

			parse_str($_POST['data']);
			$data = array(
				'username' => @$username,
				'email' => $email,
				'name' => @$name,
				'password' => $password,
				'captcha_challenge' => @$recaptcha_challenge_field,
				'captcha_response' => @$recaptcha_response_field
			);

			if ( $EL->signup($data) )
				json_success( $EL->config_item('email_activation') );
			else 
				json_error( $EL->errors );
		break;

		case 'forgot_pass':
			if ($EL->is_logged()) die();

			parse_str($_POST['data']);
			if ( $EL->forgot_pass($email, @$recaptcha_challenge_field, @$recaptcha_response_field) )
				json_success();
			else 
				json_error( $EL->errors );
		break;

		case 'recover_pass':
			if ($EL->is_logged()) die();

			parse_str($_POST['data']);
			if ( $EL->recover_pass($password, $confirm_password, $recover_key) )
				json_success();
			else 
				json_error( $EL->errors );
		break;

		case 'resend_activation':
			if ($EL->is_logged()) die();

			parse_str($_POST['data']);
			if ( $EL->resend_activation($email, @$recaptcha_challenge_field, @$recaptcha_response_field) )
				json_success();
			else 
				json_error( $EL->errors );
		break;

		case 'activate_account':
			if ($EL->is_logged()) die();

			$activation_key = $_POST['activation_key'];
			if ($EL->activate_account($activation_key))
				json_success();
			else 
				json_error( $EL->errors );
		break;

		case 'check_recover_key':
			if ($EL->is_logged()) die();

			$recover_key = $_POST['recover_key'];
			if ($EL->check_recover_key($recover_key))
				json_success();
			else 
				json_error( $EL->errors );
		break;

		case 'signout':
			$EL->signout();
			json_success();
		break;

		case 'account':
			if (!$EL->is_logged()) die();

			parse_str($_POST['data'], $post);
			$data = array(
				'name' => @$post['name'],
				'email' => $post['email'],
				'url' => $post['url'],
				'password' => $post['password'],
				'avatar' => $post['avatartype'],
			);
			$user_id = $EL->get_current_user('id');

			$EL->update_userdata($user_id, $data);
			
			// Update custom fields
			$custom_fields = $EL->config_item('custom_fields');
			if ($custom_fields) {
				foreach ($custom_fields as $field) {
					$validate_cb = 'validate_custom_field_'.$field['name'];
					$meta_value = $EL->escape(@$post[$field['name']]);
					
					if (function_exists($validate_cb)) {
						if ( $validate_cb($post[$field['name']]) )
							$EL->update_usermeta($user_id, $field['name'], $meta_value);
					} else {
						$EL->update_usermeta($user_id, $field['name'], $meta_value);
					}
				}
			}
			if (isset($EL->pass_changed))
				json_success(array('pass_changed' => true));
			else
				json_success();
		break;

		// imgPicker
		case 'upload':
			if (!$EL->is_logged()) die();
			
			require_once('imgPicker/config.php');
			require_once('imgPicker/functions.php');
			require_once('imgPicker/imgPicker.php');

			$imgPickerConfig['upload_dir'] = '../' . $EL->config_item('upload_dir');
			$IP = new imgPicker($imgPickerConfig);

			$file   = @$_FILES['ip-file'];
			$user_id = $EL->get_current_user('id');
			
			$IP->upload($file, 'avatar', $user_id);
		break;

		case 'save-image':
			if (!$EL->is_logged()) die();

			require_once('imgPicker/config.php');
			require_once('imgPicker/functions.php');
			require_once('imgPicker/imgPicker.php');

			$imgPickerConfig['upload_dir'] = '../' . $EL->config_item('upload_dir');
			$IP = new imgPicker($imgPickerConfig);

			$user_id = $EL->get_current_user('id');
			$_POST['obj_id'] = $user_id;
			$_POST['type'] = 'avatar';

			$IP->save_cropped($_POST);
		break;

	}
} 
else if (isset($_GET['action'])) {
	switch ($_GET['action']) {
		
		case 'userdata':
			if (!$EL->is_logged()) die();
			
			$user_id = $EL->get_current_user('id');
			$userdata = $EL->get_userdata($user_id);
			
			if ($userdata) {
				unset($userdata['data']['password']);
				$userdata['data']['custom_fields_html'] = get_custom_fields_html();
				$userdata['data']['avatarUrl'] = $EL->get_user_avatar($user_id);
				json_success($userdata['data']);
			}
			else 
				json_error();
		break;

		case 'get_avatar':
			if (!$EL->is_logged()) die();
			$user_id = $EL->get_current_user('id');
			json_success( $EL->get_user_avatar($user_id, 200, $_GET['type']) );
		break;
	}
}

function get_custom_fields_html() {
	$EL = EasyLogin::getInstance();

	if (!$EL->is_logged()) 
		return false;

	$output = '';
	$custom_fields = $EL->config_item('custom_fields');
	if ($custom_fields) {
	   	$user_id = $EL->get_current_user('id');
		$userdata = $EL->get_userdata($user_id);

	    foreach ($custom_fields as $field) {
	        $meta = @$userdata['usermeta'][$field['name']];
	        
	        $output .= '<div class="form-group">';
	        switch ( $field['type'] ) {
	            case 'text':
	                $output .= '<label>'. $field['label'] . '<br><input type="text" name="'. $field['name'] .'" value="'.$meta.'" class="form-input"></label>';
	            break;
	            case 'textarea':
	                $output .= '<label>'. $field['label'] . '<br><textarea name="'. $field['name'] .'" class="form-input">'.$meta.'</textarea></label>';
	            break;
	            case 'select':
	                $output .= '<label>'. $field['label'] . '<select name="'. $field['name'] .'" class="form-input"><br>';
	                foreach ($field['options'] as $key => $value)
	                    $output .= '<option value="'.$key.'" '.( $meta == $key ? 'selected' : '' ).'>'.$value.'</option>';
	                $output .= '</select></label>';
	            break;
	            case 'checkbox':
	                $output .= '<label><input type="checkbox" name="'. $field['name'] .'" value="1" '.($meta == '1' ? 'checked' : '').'> '. $field['label'] .'</label>';
	            break;
	        }
	        $output .= '</div>';
	    }
	}
	return $output;
}