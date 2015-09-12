<?php
/**
* EasyLogin
*/
class EasyLogin
{
	public $db;
	public $errors = array();

	private $config;
	private static $instance = null;

	// Database tables
	protected $_users    = 'users';
	protected $_usermeta = 'usermeta';

	private function __construct() {
	}

	public static function getInstance() {
		if (!isset(self::$instance)) {
			self::$instance = new EasyLogin();
		}
		return self::$instance;
	}

	// Sign in
	public function signin($user, $pass, $remember = false, $encrypt_pass = true) {
		$user = $this->escape($user);
		
		if ($encrypt_pass) { 
			$pass = $this->encrypt($pass);
		}

		if (empty($user) || empty($pass)) {
			return false;
		}

		$query = $this->db->select('*', $this->_users);
		if ( $this->valid_email($user) ) {
			$query = $query->where('email', $user);
		} else {
			$query = $query->where('username', $user);
		}
		$query = $query->where('password', $pass)->limit(1);

		if ( $result = $query->get() ) {
			$result = $result[0];

			if ($result->status == 2) {
				$this->errors[] = 'disabled';
				return false;
			} else if ($result->status !=1 ) {
				$this->errors[] = 'unconfirmed';
				return false;
			}

			$session_name = $this->config_item('session_name');
			
			$userdata = $this->get_userdata('user_id');

			// Set session
			$_SESSION[ $session_name ] = array(
				'id'       => $result->id,
				'name'     => $result->name,
				'username' => $result->username,
				'avatar'   => $this->get_user_avatar($result->id),
				'role'     => $result->role
			);

			$oauth = $this->get_usermeta($result->id, 'google');
			if ($oauth) {
				$_SESSION[ $session_name ]['oauth'] = 'google';
			} else {
				$oauth = $this->get_usermeta($result->id, 'facebook');
				if ($oauth) {
					$_SESSION[ $session_name ]['oauth'] = 'facebook';
				} else {
					$oauth = $this->get_usermeta($result->id, 'twitter');
					if ($oauth) {
						$_SESSION[ $session_name ]['oauth'] = 'twitter';
					}
				}
			}

			// Set cookie
			if ($remember) {
				$cookie = base64_encode("$user/$pass");
				$this->set_cookie($session_name, $cookie);
			}

			// Update last login ip
			$this->update_usermeta($result->id, 'last_ip', $_SERVER['REMOTE_ADDR']);

			return true;
		}
		else {

			$this->errors[] = 'invalid_credentials';
			return false;
		}
	}

	// Oauth Sign in
	public function oauth_signin($oauth_id, $oauth_type) {
		$query = $this->db->select('user_id', $this->_usermeta);
		$query = $query->where('meta_key', $oauth_type)->where('meta_value', $oauth_id)->limit(1);
		if ($result = $query->get()) {
			$userdata = $this->get_userdata($result[0]->user_id);
			if ($userdata) {
				
				if ($userdata['data']['status'] == 2) {
					$this->errors[] = 'disabled';
					return false;
				} else if ($userdata['data']['status'] !=1 ) {
					$this->errors[] = 'unconfirmed';
					return false;
				}

				$session_name = $this->config_item('session_name');
				
				// Set session
				$_SESSION[ $session_name ] = array(
					'id'       => $userdata['data']['id'],
					'name'     => $userdata['data']['name'],
					'username' => $userdata['data']['username'],
					'avatar'   => $this->get_user_avatar($userdata['data']['id']),
					'role'     => $userdata['data']['role'],
					'oauth'    => $oauth_type
				);

				// Update last login ip
				$this->update_usermeta($userdata['data']['id'], 'last_ip', $_SERVER['REMOTE_ADDR']);

				return true;
			} else {
				$this->errors[] = 'invalid_oauth';
				$this->delete_usermeta($result[0]->user_id, $oauth_type);
				
			}
		}
		return false;
	}

	// Sign up
	public function signup($data) {
		extract($data);
		$data = array();
		$name = $this->escape(@$name);
		$password = trim($password);
		
		if ($this->config_item('require_name')) {
			if (empty($name))
				$this->errors[] = 'invalid_name';
			else $data['name'] = $name;
		}

		if ($this->config_item('require_username')) {
			if (!$this->valid_username($username)) 
				$this->errors[] = 'invalid_username';
		 	elseif (!$this->is_unique($username, "$this->_users.username"))
				$this->errors[] = 'unique_username';
			else $data['username'] = $username;
		}

		if (!$this->valid_email($email)) {
			$this->errors[] = 'invalid_email';
		} elseif (!$this->is_unique($email, "$this->_users.email")) {
			$this->errors[] = 'unique_email';
		}

		if (strlen($password) < 4 || strlen($password) > 20) {
			$this->errors[] = 'invalid_password';
		}

		if ( $this->config_item('require_captcha') && !$this->valid_captcha(@$captcha_challenge, @$captcha_response) ) {
			$this->errors[] = 'invalid_captcha';
		}

		if (empty($this->errors)) {
			$activation_key = md5($email . time());
			
			$data['email'] = $email;
			$data['password'] = $this->encrypt($password);
			$data['activation_key'] = $activation_key;
			$data['role'] = $this->config_item('default_role');

			if (!$this->config_item('email_activation')) {
				$data['status'] = 1;
			}

			if ($this->db->insert($this->_users, $data)) {
				// Send email confirmation
				if (empty($data['status'])) {
					$subject = $this->config_item('email_templates/signup_subject');
					$message = $this->config_item('email_templates/signup_message');
					if ($this->config_item('activate_url')) 
						$activate_url = $this->config_item('activate_url').$activation_key;
					else
						$activate_url = $this->config_item('script_url').'#activate-'.$activation_key;
					$message = sprintf($message, $activate_url);
					$this->send_email($email, $subject, $message);
				}

				return true;
			}
		}

		return false;
	}

	// Oauth Sign up
	public function oauth_signup($data, $oauth_type) {
		extract($data);
		$data = array();
		$name = $this->escape(@$name);

		$query = $this->db->select('user_id', $this->_usermeta);
		$query = $query->where('meta_key', $oauth_type)->where('meta_value', $oauth_id)->limit(1);

		if ($query->get()) {
			if ($this->oauth_signin($oauth_id, $oauth_type)) {
				return true;
			} else {
				$this->errors = array('error');
				return false;
			}
		}
		
		if ($this->config_item('require_name')) {
			if (empty($name))
				$this->errors[] = 'invalid_name';
			else $data['name'] = $name;
		}

		if ($this->config_item('require_username')) {
			if (!$this->valid_username($username))
				$this->errors[] = 'invalid_username';
		 	elseif (!$this->is_unique($username, "$this->_users.username"))
				$this->errors[] = 'unique_username';
			else $data['username'] = $username;
		}

		if ($oauth_type != 'twitter') {
			if (!$this->valid_email($email)) {
				$this->errors[] = 'invalid_email';
			} elseif (!$this->is_unique($email, "$this->_users.email")) {
				$this->errors[] = 'unique_email';
			}
			else $data['email'] = $email;
		}

		if ($this->valid_url(@$url)) {
			$data['url'] = $url;
		}

		if (empty($this->errors)) {
			$data['role'] = $this->config_item('default_role');
			$data['status'] = 1;
			$data['avatar'] = $oauth_type;
			
			if ($this->db->insert($this->_users, $data)) {
				$user_id = $this->db->insert_id();
				$this->update_usermeta($user_id, $oauth_type, $oauth_id);
				if ($oauth_type == 'twitter') {
					$this->update_usermeta($user_id, 'twitter_avatar', str_replace('_normal', '', $avatar));
				}
				return true;
			}
			else 
				$this->errors[] = 'error';
		}

		return false;
	}

	// Sign out
	public function signout() {
		session_destroy();
		$session_name = $this->config_item('session_name');
		$this->set_cookie($session_name, '');
	}

	// Checks if the user is logged
	public function is_logged() {
		return $this->get_current_user('id');
	}

	// Activate account
	public function activate_account($activation_key) {
		$activation_key = $this->escape($activation_key);

		$query = $this->db->select('id, status', $this->_users)->where('activation_key', $activation_key)->limit(1);
		if ($result = $query->get()) {
			if (empty($result[0]->status)) {
				$query = $this->db->where('id', $result[0]->id)->limit(1);
				$query->update($this->_users, array('status' =>1 ));
				return true;
			} elseif ($result[0]->status == 1) {
				$this->errors[] = 'already_activated';
			} elseif ($result[0]->status == 2) {
				$this->errors[] = 'disabled';
			}
		} else {
			$this->errors[] = 'invalid_activation_key';
		}
		return false;
	}

	// Check if recover key is valid
	public function check_recover_key($recover_key) {
		$recover_key = $this->escape($recover_key);
		$query = $this->db->select('id, status', $this->_users)->where('activation_key', $recover_key)->limit(1);
		if ($result = $query->get()) {
			if ($result[0]->status == 1)
				return true;
			else 
				$this->errors[] = 'disabled';
		} else {
			$this->errors[] = 'invalid_recover_key';
		}
		return false;
	}

	// Send recover passsword link
	public function forgot_pass($email, $captcha_challenge, $captcha_response) {
		if (!$this->valid_email($email)) {
			$this->errors[] = 'invalid_email';
		} 
		if ( $this->config_item('require_captcha') && !$this->valid_captcha(@$captcha_challenge, @$captcha_response) ) {
			$this->errors[] = 'invalid_captcha';
		}
		else {
			$query = $this->db->select('id', $this->_users)->where('email', $email)->limit(1);
			if ($query->get()) {
				$recover_key = md5($email . time());
				$query = $this->db->where('email', $email)->limit(1);
				if ($query->update($this->_users, array('activation_key' => $recover_key) )) {
					// Send recover email
					$subject = $this->config_item('email_templates/recover_subject');
					$message = $this->config_item('email_templates/recover_message');
					if ($this->config_item('recover_url')) 
						$recover_url = $this->config_item('recover_url').$recover_key;
					else
						$recover_url = $this->config_item('script_url').'#recover-'.$recover_key;
					$message = sprintf($message, $recover_url);
					$this->send_email($email, $subject, $message);

					return true;
				}
			}
			else $this->errors[] = 'no_account';
		}
		return false;
	}

	// Recover the password with the recover link
	public function recover_pass($password, $confirm_password, $recover_key) {
		$password = trim($password);
		$recover_key = $this->escape($recover_key);
		if ($this->check_recover_key($recover_key)) {	
			if (strlen($password) < 4 || strlen($password) > 20) {
				$this->errors[] = 'invalid_password';
			} elseif ($password != $confirm_password) {
				$this->errors[] = 'pass_not_match';
			} else {
				$data = array(
					'password' => $this->encrypt($password),
					'activation_key' => time() // reset key
				);

				$query = $this->db->where('activation_key', $recover_key)->limit(1);
				$query->update($this->_users, $data);

				return true;
			}
		}
		return false;
	}

	// Resend the activation email
	public function resend_activation($email, $captcha_challenge, $captcha_response) {
		if (!$this->valid_email($email)) {
			$this->errors[] = 'invalid_email';
		} 
		if ( $this->config_item('require_captcha') && !$this->valid_captcha(@$captcha_challenge, @$captcha_response) ) {
			$this->errors[] = 'invalid_captcha';
		}
		else {
			$query = $this->db->select('id, status', $this->_users)->where('email', $email)->limit(1);
			if ($result = $query->get()) {
				if ($result[0]->status == 1) {
					$this->errors[] = 'already_activated';
				}
				else if ($result[0]->status == 2) {
					$this->errors[] = 'disabled';
				} else  {
					$query = $this->db->where('email', $email)->limit(1);
					$activation_key =  md5($email . time());
					if ($query->update($this->_users, array('activation_key' => $activation_key) )) {
						
						// Send email activation
						$subject = $this->config_item('email_templates/activation_subject');
						$message = $this->config_item('email_templates/activation_message');
						if ($this->config_item('activate_url')) 
							$activate_url = $this->config_item('activate_url').$activation_key;
						else
							$activate_url = $this->config_item('script_url').'#activate-'.$activation_key;
						$message = sprintf($message, $activate_url);
						$this->send_email($email, $subject, $message);

						return true;
					}
				}
			}
			else $this->errors[] = 'no_account';
		}
		return false;
	}

	// Update user data
	public function update_userdata($user_id, $data) {
		extract($data);
		$data = array();
		$name = $this->escape(@$name);
		$session_name = $this->config_item('session_name');
			
		if ($this->config_item('require_name') && !empty($name)) {
			$data['name'] = $name;
			if ($this->get_current_user('id') == $user_id) {
				$_SESSION[ $session_name ]['name'] = $name;
			}
		}
		
		if ($this->valid_email($email)) {
			$query = $this->db->select('id', $this->_users);
			$query = $query->where('email', $email)->where('id', $user_id, '!=')->limit(1);
			if (!$query->get()) {
				$data['email'] = $email;
				if ($this->get_current_user('id') == $user_id) {
					$_SESSION[ $session_name ]['email'] = $email;
				}
			}
		}

		if ($this->valid_url($url)) {
			$data['url'] = $url;
		}

		if (isset($username)) {
			if ($this->valid_username($username)) {
				$query = $this->db->select('id', $this->_users);
				$query = $query->where('username', $username)->where('id', $user_id, '!=')->limit(1);
				if (!$query->get()) {
					$data['username'] = $username;
					if ($this->get_current_user('id') == $user_id) {
						$_SESSION[ $session_name ]['username'] = $email;
					}
				}
			}
		}

		if (isset($password)) {
			$password = trim($password);
			if (strlen($password) < 4 || strlen($password) > 20) {
				$this->errors[] = 'invalid_password';
			} else {
				$data['password'] = $this->encrypt($password);
				$this->pass_changed = true;
			}
		}

		if (isset($status)) {
 			$data['status'] = $status;
 		}

 		if (isset($role)) {
 			$data['role'] = $this->escape($role);
 			if ($this->get_current_user('id') == $user_id) {
				$_SESSION[ $session_name ]['role'] = $role;
			}
 		}

		if (isset($avatar) && in_array($avatar, array('uploaded', 'gravatar', 'facebook', 'twitter', 'google'))) {
			$data['avatar'] = $avatar;
			if ($this->get_current_user('id') == $user_id) {
				$_SESSION[ $session_name ]['avatar'] = $this->get_user_avatar($user_id, 200, $avatar);
			}
		}

		if (!empty($data)) {
			$query = $this->db->where('id', $user_id)->limit(1);
			$query->update($this->_users, $data);

			if (isset($usermeta)) {
				foreach ($usermeta as $key => $value) {
					$this->update_usermeta($user_id, $key, $this->escape($value));
				}
			}
			return true;
		}

		return false;
	}

	// Returns avatar image
	public function get_user_avatar($user_id, $size = 200, $by_type = null) {
		
		if ($this->get_current_user('id') == $user_id && !$by_type) {
			return $this->get_current_user('avatar');
		}

		$userdata = $this->get_userdata($user_id);
		if ($userdata) {
			$avatar = $userdata['data']['avatar'];
			
			if ($by_type) {
				$avatar = $by_type;
			}
			
			$default_avatar = urlencode($this->config_item('default_avatar'));

			switch ($avatar) {
				case 'gravatar':
					$email = $userdata['data']['email'];
					$avatar = "http://www.gravatar.com/avatar/".md5(strtolower(trim($email)))."?d=".$default_avatar."&s=$size";
				break;
				
				case 'facebook':
					$avatar = 'https://graph.facebook.com/'.@$userdata['usermeta']['facebook']."/picture?width=$size&height=$size";
				break;

				case 'google':
					$avatar = 'https://www.google.com/s2/photos/profile/'.@$userdata['usermeta']['google'];
				break;

				case 'twitter':
					$avatar = $this->get_usermeta($user_id, 'twitter_avatar');
				break;

				default:
					if (empty($userdata['usermeta']['avatar'])) {
						return $this->config_item('script_url') . 'assets/img/default_avatar.png';
					}

					$upload_dir = 'uploads/';
					$avatar = $this->config_item('script_url') . $upload_dir . $userdata['usermeta']['avatar'];
				break;
			}

			return $avatar;
		}
	}

	// Returns id / name / username / avatar / role
	public function get_current_user($var = false) {
		$session = $this->config_item('session_name');
		
		if ($var && isset($_SESSION[$session])) {
			return @$_SESSION[$session][$var];
		} elseif (isset($_SESSION[$session])) {
			return $_SESSION[$session];
		}
		return false;
	}

	// Returns userdata (users + usermeta tables)
	public function get_userdata($user_id) {
		$query = $this->db->select('*', $this->_users)->where('id', $user_id)->limit(1);
		if ($result = $query->get()) {
			$userdata['data'] = (array)$result[0];
			$query = $this->db->select('*', $this->_usermeta)->where('user_id', $user_id);
			if ($result = $query->get()) {
				foreach ($result as $key => $r) {
					$userdata['usermeta'][$r->meta_key] = $r->meta_value;
				}
			}
			return $userdata;
		}
		return false;
	}
	
	// Returns usermeta
	public function get_usermeta($user_id, $meta_key = false) {
		$query = $this->db->where('user_id', $user_id);
		if ($meta_key) {
			$query = $query->where('meta_key', $meta_key)->limit(1);
		}

		if ( $result = $query->get($this->_usermeta) ) {
			if ($meta_key) {
				return $result[0]->meta_value;
			}

			$meta_arr = array();
			foreach ($result as $m) {
				$meta_arr[$m->meta_key] = $m->meta_value;
			}
			return $meta_arr;
		}

		return false;
	}

	// Add usermeta
	public function add_usermeta($user_id, $meta_key, $meta_value) {
		if (is_array($meta_value)) {
			$meta_value = json_encode($meta_value);
		}
		$data = array('user_id' => $user_id, 'meta_key' => $meta_key, 'meta_value' => $meta_value);
		if ($this->db->insert($this->_usermeta, $data)) {
			return true;
		}
		return false;
	}

	// Update usermeta
	public function update_usermeta($user_id, $meta_key, $meta_value) {
		if ($this->get_usermeta($user_id, $meta_key) === false) {
			return $this->add_usermeta($user_id, $meta_key, $meta_value);
		}
		$query = $this->db->where('user_id', $user_id)->where('meta_key', $meta_key)->limit(1);
		if ( $query->update($this->_usermeta, array('meta_value' => $meta_value)) ) {
			return true;
		}
		return false;
	}

	// Delete usermeta
	public function delete_usermeta($user_id, $meta_key) {
		$query = $this->db->where('user_id', $user_id)->where('meta_key', $meta_key)->limit(1);
		if ($query->delete($this->_usermeta)) {
			return true;
		}
		return false;
	}

	// Reurns all users

	public function get_users() {
		$query = $this->db->select('*', $this->_users)->orderby('id', 'DESC');
		return $query->get();
	}

	// Returns the api key
	public function api_key($path) {
		return $this->config_item("api_keys/$path");
	}

	// Load config settings from file
	public function load_config($file) {
		if (is_file($file)) {
			require_once($file);

			$this->config = $config;

		} else {
			die('<h1>Unable to load config file.</h1>');
		}
	}

	// Returns config item
	public function config_item($path) {
		$config = $this->config;
		$path = explode('/', $path);

		foreach ($path as $bit) {
			if (isset($config[$bit])) {
				$config = $config[$bit];
			}
			else $config = null;

		}

		return $config;
	}


	// Helpers

	// Send email
	public function send_email($to, $subject, $message) {
		if ($this->config_item('phpmailer')) {
			require_once(dirname(__FILE__) . '/PHPMailer/phpmailer.php');
			$mail = new PHPMailer();
			
			$gmail_username = $this->api_key('gmail/username');
			$gmail_password = $this->api_key('gmail/password');
			
			if ($gmail_username && $gmail_password) {
				$mail->IsSMTP();
				$mail->SMTPAuth   = true;
				$mail->Host       = 'ssl://smtp.gmail.com';
				$mail->Port       = '465';
				$mail->Username   = $gmail_username;
				$mail->Password   = $gmail_password;
			} else {
				$mail->IsSendmail();
			}
			
			$mail->From     = $this->config_item('email/from_email');
			$mail->FromName = $this->config_item('email/from_name');
			
			$bcc = false;
			if (is_array($to)) {
				foreach ($to as $sendTo) {
					if ($bcc) {
						$mail->AddBCC($sendTo);
					} else {
						$mail->AddAddress($sendTo);
						$bcc = true;
					}
				}
			} else
				$mail->AddAddress($to);

			$mail->Subject = $subject;
			$mail->MsgHTML($message);

			return $mail->Send();
		
		} else {
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= 'From: '.$this->config_item('email/from_name').' <'.$this->config_item('email/from_email').'>';
			
			if (is_array($to)) {
				foreach ($to as $sendTo)
					@mail($to, $subject, $message, $headers);
			} else
				return @mail($to, $subject, $message, $headers);
		}
	}

	// Checks if capcha is valid
	public function valid_captcha($captcha_challenge, $captcha_response) {
		$captcha_response = $this->escape($captcha_response);

		if (empty($captcha_challenge) || empty($captcha_response))
			return false;

		require_once(dirname(__FILE__). '/recaptchalib.php');
		
		return recaptcha_check_answer($this->api_key('recaptcha/private_key'), $_SERVER['REMOTE_ADDR'],  $captcha_challenge, $captcha_response)->is_valid;
	}

	// Checks if the field is unique
	public function is_unique($str, $field) {
		list($table, $field) = explode('.', $field);
		$query = $this->db->select($field)->limit(1)->where($field, $str);
		$query = $query->get($table);
		
		return count($query) === 0;
    }

    // Checks if the username is valid
	public function valid_username($str) {
		return preg_match('/^[a-zA-Z0-9]+[a-zA-Z0-9\_\.]+[a-zA-Z0-9]+$/i', $str);
	}

	// Checks if the email is valid
	public function valid_email($str) {
		return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? false : true;
	}

	// Checks if the url is valid
	public function valid_url($str) {
		return !(preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $str)) ? false : true;
	}

	// Encrypt password
	public function encrypt($str) {
		$salt = $this->config_item('auth_salt');
		$encryption_algorithm = $this->config_item('encryption_algorithm');
		
		if ($encryption_algorithm == 'bcrypt‎' && defined('CRYPT_BLOWFISH') && CRYPT_BLOWFISH) {
			$salt = substr(str_replace('+', '.', base64_encode($salt)), 0, 22);
	        $hash = crypt($str, '$2a$12$' . $salt);
	    } else {
	    	if ($encryption_algorithm == 'bcrypt‎')
	    		$encryption_algorithm = 'md5';

	    	$salt = substr($salt, 0, 10);
	    	$hash = hash($encryption_algorithm, $str . $salt);
	    }

	    return $hash;
	}

	// Returns encoded string
	public function escape($str) {
		return trim( htmlentities($str, ENT_QUOTES, 'UTF-8') );
	}

	// Set cookie
	public function set_cookie($name, $value, $time = null) {
		$time = ($time) ? $time : 60 * 60 * 24 * 60;
		setcookie($name , $value , $time + time() , '/');
    	//setcookie($name , $value , 60 * 60 * 24 * 60 + time() , '/' , DOMAIN , false , true);
	}
}