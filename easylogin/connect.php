<?php

require_once(dirname(__FILE__).'/includes/load.php');
$EL = EasyLogin::getInstance();

$login_redirect = $EL->config_item('login_redirect');
if (empty($login_redirect)) {
	$login_redirect = $EL->config_item('home_url');
}

if ($EL->is_logged()) {
	header('Location:' . $login_redirect);
}

$script_url = $EL->config_item('script_url');

if (isset($_GET['method'])) {
	switch ($_GET['method']) {
		case 'facebook':
			require_once(dirname(__FILE__) . '/includes/oauth/facebook/facebook.php');
			
			$facebook = new Facebook(array(
				'appId'  => $EL->api_key('facebook/app_id'),
				'secret' => $EL->api_key('facebook/secret')
			));

			$user = $facebook->getUser();
			if ($user) {
				$user = $facebook->api('/me');
				if ($user) {
					if ($EL->oauth_signin($user['id'], 'facebook')) {
		 				header('Location: ' . $login_redirect);
		 			} else {
		 				$data = array(
							'oauth_id' => $user['id'],
							'username' => $user['username'],
							'email'    => $user['email'],
							'name'     => $user['name'],
							'url'      => $user['link'],
						);
						
						if ($EL->oauth_signup($data, 'facebook')) {
							$EL->oauth_signin($user['id'], 'facebook');
							header('Location: ' . $login_redirect);
						} else { 
							$errors = $EL->errors;
						}
					}
				} else 
					$errors = 'data_error';
			} else {
				$authUrl = $facebook->getLoginUrl(array(
			  		'scope' => 'email',
			  		'redirect_uri' => $script_url . 'connect.php?method=facebook'
				));
				header('Location: ' . $authUrl);
			}
		break;

		case 'google':
			require_once(dirname(__FILE__) . '/includes/oauth/google/Google_Client.php');
			require_once(dirname(__FILE__) . '/includes/oauth/google/contrib/Google_PlusService.php');
			require_once(dirname(__FILE__) . '/includes/oauth/google/contrib/Google_Oauth2Service.php');

			$redirect_uri = $script_url . 'connect.php?method=google';

			$client = new Google_Client();
			$client->setClientId( $EL->api_key('google/client_id') );
			$client->setClientSecret( $EL->api_key('google/client_secret') );
			$client->setDeveloperKey( $EL->api_key('google/dev_key') );
			$client->setRedirectUri( $redirect_uri );
			$plus = new Google_PlusService($client);
			$oauth2 = new Google_Oauth2Service($client);

			if (isset($_GET['code'])) {
				$client->authenticate($_GET['code']);
			  	$_SESSION['_google_access_token'] = $client->getAccessToken();
			  	header('Location: '. $redirect_uri);
			}

			if (isset($_SESSION['_google_access_token'])) {
				$client->setAccessToken($_SESSION['_google_access_token']);
			}

			if ($client->getAccessToken()) {
				$_SESSION['_google_access_token'] = $client->getAccessToken();
				$user = $plus->people->get('me');
				if ($user) {
					$userinfo = $oauth2->userinfo->get();
					if ($EL->oauth_signin($user['id'], 'google')) {
		 				header('Location: ' . $login_redirect);
		 			} else {
		 				$data = array(
							'oauth_id' => $user['id'],
							'username' => str_replace(' ', '', $user['displayName']),
							'email'    => $userinfo['email'],
							'name'     => $user['displayName'],
							'url'      => $user['url']
						);

						if ($EL->oauth_signup($data, 'google')) {
							$EL->oauth_signin($user['id'], 'google');
							header('Location: ' . $login_redirect);
						} else { 
							$errors = $EL->errors;
							unset($_SESSION['_google_access_token']);
						}
					}
				} else {
					$errors = 'data_error';
					unset($_SESSION['_google_access_token']);
				}
			} else {
				$authUrl = $client->createAuthUrl();
			}

			if (isset($_GET['error'])) {
				$errors = 'Error: Access Denied.';
				unset($_SESSION['_google_access_token']);
			} elseif (isset($authUrl)) {
				header('Location: ' . $authUrl);
			}

		break;

		case 'twitter':
			require_once(dirname(__FILE__) . '/includes/oauth/twitter/twitteroauth.php');

			$api_key = $EL->api_key('twitter/api_key');
			$api_secret = $EL->api_key('twitter/api_secret');

			if (isset($_GET['oauth_token'])) {
				if (isset($_REQUEST['oauth_token']) && @$_SESSION['_twitter_oauth_token'] !== $_REQUEST['oauth_token']) {
				  	unset($_SESSION['_twitter_oauth_token'], $_SESSION['_twitter_oauth_token_secret']);
					$errors = 'error';
				} else {
					$connection = new TwitterOAuth($api_key, $api_secret, $_SESSION['_twitter_oauth_token'], $_SESSION['_twitter_oauth_token_secret']);
					$token = $connection->getAccessToken($_REQUEST['oauth_verifier']);
					unset($_SESSION['_twitter_oauth_token'], $_SESSION['_twitter_oauth_token_secret']);
					
					if ($connection->http_code == 200) {
					  	$content = $connection->get('account/verify_credentials');
						$user = get_object_vars($content);
					  	if ($user) {
					  		$data =  array(
								'oauth_id' => $user['id'],
								'username' => $user['screen_name'],
								'avatar'   => $user['profile_image_url'],
								//'email'    => '',
								'name'     => $user['name'],
								'url'      => $user['url']
		 					);
					  		if ($EL->oauth_signup($data, 'twitter')) {
								$EL->oauth_signin($user['id'], 'twitter');
								header('Location: ' . $login_redirect);
							} else { 
								$errors = $EL->errors;
							}
					  	} else 
					  		$errors = 'data_error';
					} else 
						$errors = 'error';
				}
			} else {
				$connection = new TwitterOAuth($api_key, $api_secret);
				$token = $connection->getRequestToken( $script_url . 'connect.php?method=twitter' );

				$_SESSION['_twitter_oauth_token'] = $token['oauth_token'];
				$_SESSION['_twitter_oauth_token_secret'] = $token['oauth_token_secret'];
				
				if ($connection->http_code == 200) {
					$authUrl = $connection->getAuthorizeURL( $token['oauth_token'] );
				   	header('Location: ' . $authUrl);
				} else {
					unset($_SESSION['_twitter_oauth_token'], $_SESSION['_twitter_oauth_token_secret']);
					$errors = 'error';
				}
			}
			
		break;
	}
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>EasyLogin Connect</title>
	<link rel="stylesheet" href="<?php echo $script_url; ?>assets/css/easylogin.css">
	<style>
		body {
			margin: 0px;
			background: #F3F3F3;
			font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
			font-size: 14px;
			color: #333;
		}
		h2 {
			margin-top: 0px;
		}
		ul {
			margin: 0px;
			padding: 5px 5px 5px 20px;
		}
		#container {
			background: #fff;
			max-width: 600px;
			min-width: 420px;
			min-height: 100px;
			margin: 1.5em auto;
			padding: 1em;
			border: 1px solid #D8D8D8;
			-webkit-box-shadow: 0 1px 4px rgba(0, 0, 0, .065);
			-moz-box-shadow: 0 1px 4px rgba(0,0,0,.065);
			box-shadow: 0 1px 4px rgba(0, 0, 0, .065);
		}
	</style>
</head>
<body>
	<div id="container">
		<?php
		echo '<h2>Connecting with '.(in_array(@$_GET['method'], array('facebook', 'twitter', 'google')) ? ucfirst($_GET['method']) : '').'...</h2>';

		$error_messsages = array(
			'error' => 'Unexpected Error.',
			'data_error' =>  'Error: Could not retrieve user data.',
			'invalid_name' => 'Name is invalid',
			'invalid_username' => 'Username is invalid',
			'unique_username' => 'Username is already taken',
			'invalid_email' => 'Email is not valid',
			'unique_email' => 'Email already registed'
		);
		
		if (isset($errors)) {
			echo '<div class="alert alert-danger">';
			if (is_array($errors)) {
				echo '<ul>';
				foreach ($errors as $err_code) {
					if (isset($error_messsages[$err_code]))
						echo '<li>'.$error_messsages[$err_code].'</li>';
				}
				echo '</ul>';
			}
			elseif (isset($error_messsages[$errors]))
				echo $error_messsages[$errors];
			else
				echo $errors;

			echo '</div>
				<p style="text-align: center;"><a href="'.$EL->config_item('home_url').'">Go back Home</a></p>';
		}
		?>
	</div>
</body>
</html>