<?php
$EL = EasyLogin::getInstance();

$script_url = $EL->config_item('script_url');
$connect_url = $script_url . 'connect.php?method=';

$connect_with = array(
	'facebook' => $EL->api_key('facebook/app_id'),
	'twitter'  => $EL->api_key('twitter/api_key'),
	'google'   => $EL->api_key('google/client_id')
);
?>

<link rel="stylesheet" href="<?php echo $script_url; ?>assets/css/easylogin.css">
<link rel="stylesheet" href="<?php echo $script_url; ?>assets/css/imgPicker.css">

<script src="<?php echo $script_url; ?>assets/js/bootstrap.min.js"></script>
<script src="<?php echo $script_url; ?>assets/js/imgPicker.min.js"></script>
<script src="<?php echo $script_url; ?>assets/js/easylogin.min.js"></script>

<script>
	EasyLogin.config = {
		script_url: '<?php echo $script_url; ?>',
		ajax_url: '<?php echo $script_url; ?>includes/ajax.php'
	};
</script>

<?php if (!$EL->is_logged()): ?>
<!-- Sign in Modal -->
<div class="modal fade easylogin" id="EL_signin" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">登入 / Sign in</h4>
			</div>
			<form action="" method="POST" class="easylogin-form">
			<div class="modal-body">
				<div class="alert alert-warning">
					<button type="button" class="close dismiss">&times;</button><span></span>
				</div>
				<div class="form-group connect-with">
					<div class="info">使用社交網絡帳戶登入 <br>Connect with a social network</div>
					<?php if ($connect_with['facebook']): ?>
						<a href="<?php echo $connect_url.'facebook'; ?>" class="connect facebook" title="Connect with Facebook" style="height: 39px;width: 150px;">Facebook</a>
			        <?php endif; ?>
			        <?php if ($connect_with['google']): ?>
			        	<a href="<?php echo $connect_url.'google'; ?>" class="connect google" title="Connect with Google" style="height: 39px;width: 150px;">Google</a>
			        <?php endif; ?>
			        <?php if ($connect_with['twitter']): ?>
			        	<a href="<?php echo $connect_url.'twitter'; ?>" class="connect twitter" title="Connect with Twitter">Twitter</a>
			    	<?php endif; ?>
				</div>
				<hr />
				<div class="info">使用電郵地址登入 <br>Sign in with your email address</div>
				<div class="form-group">
					<label>電郵地址 / Email<br>
						<input type="text" name="username" class="form-input">
					</label>
					<!-- <input type="text" name="username" class="form-input" placeholder="Enter your username or email address"> -->
				</div>	
				<div class="form-group">
					<label>密碼 / Password <br>
						<input type="password" name="password" class="form-input">
					</label>
					<!-- <input type="password" name="password" class="form-input" placeholder="Enter your password"> -->
				</div>
				<div class="form-group">
					<a href="#" data-toggle="modal" data-target="#EL_forgot_pass">忘記密碼? / Forgot Password?</a><br>
					<a href="#" data-toggle="modal" data-target="#EL_resend_activation">重新發送激活郵件 / Resend activation email</a>
				</div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary" style="float: left;">登入 / Sign in</button>
				<span class="ajax-loader"></span>
				<!---
				<div class="pull-right align-right">
					還未申請帳號嗎? <a href="#" data-toggle="modal" data-target="#EL_signup">立即申請!</a><br>Don't have an account yet? <a href="#" data-toggle="modal" data-target="#EL_signup">Sign Up!</a>
				</div>
				--->
			</div>
			<input type="hidden" name="action" value="signin">
			</form>
		</div>
	</div>
</div>

<!-- Sign up Modal -->
<div class="modal fade easylogin" id="EL_signup" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">註冊 / Sign up</h4>
			</div>
			<form action="" method="POST" class="easylogin-form">
			<div class="modal-body">
				<div class="alert alert-warning">
					<button type="button" class="close dismiss">&times;</button><span></span>
				</div>
				<div class="form-group connect-with">
					<div class="info">使用社交網絡帳戶註冊登入 / Connect with a social network</div>
					<?php if ($connect_with['facebook']): ?>
						<a href="<?php echo $connect_url.'facebook'; ?>" class="connect facebook" title="Connect with Facebook" style="height: 39px;width: 150px;">Facebook</a>
			        <?php endif; ?>
			        <?php if ($connect_with['google']): ?>
			        	<a href="<?php echo $connect_url.'google'; ?>" class="connect google" title="Connect with Google" style="height: 39px;width: 150px;">Google</a>
			        <?php endif; ?>
			        <?php if ($connect_with['twitter']): ?>
			        	<a href="<?php echo $connect_url.'twitter'; ?>" class="connect twitter" title="Connect with Twitter">Twitter</a>
			    	<?php endif; ?>
				</div>
				<hr style="margin: 12px 0 12px 0;"/>
				<div class="info">使用電郵地址註冊 / Sign up with your email address</div>
				<?php if ($EL->config_item('require_username')): ?>
				<div class="form-group">
					<label>帳戶名稱 / Username <br>
						<input type="text" name="username" class="form-input">
					</label>
					<!-- <input type="text" name="username" class="form-input" placeholder="Enter your username"> -->
				</div>	
				<?php endif; ?>
				<div class="form-group">
					<label>電郵地址 / Email<br>
						<input type="text" name="email" class="form-input">
					</label>
					<!-- <input type="text" name="email" class="form-input" placeholder="Enter your email address"> -->
				</div>
				<?php if ($EL->config_item('require_name')): ?>
				<div class="form-group">
					<label>姓名 / Full Name <br>
						<input type="text" name="name" class="form-input">
					</label>
					<!-- <input type="text" name="name" class="form-input" placeholder="Enter your full name"> -->
				</div>
				<?php endif; ?>
				<div class="form-group">
					<label>密碼 / Password <br>
						<input type="password" name="password" class="form-input">
					</label>
					<!-- <input type="text" name="password" class="form-input" placeholder="Enter your password"> -->
				</div>
				<?php if ($EL->config_item('require_captcha')): ?>
				<div class="form-group recaptcha-group"></div>
				<?php endif; ?>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary" style="float: left;">註冊 / Sign up</button>
				<span class="ajax-loader"></span>
				<div class="pull-right align-right">
					已經申請了帳號? <a href="#" data-toggle="modal" data-target="#EL_signin">按此登入!</a><br>
					Already have an account? <a href="#" data-toggle="modal" data-target="#EL_signin">Log In!</a>
				
				</div>
			</div>
			<input type="hidden" name="action" value="signup">
			</form>
		</div>
	</div>
</div>

<!-- Sign up complete Modals -->
<div class="modal fade easylogin" id="EL_signup_complete1" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">確認您的帳戶 / Confirm your account !</h4>
			</div>
			<div class="modal-body">
				<p>我們已經發送一則帳戶確認的電子郵件給您</p>
    			<p>請您點擊該電子郵件中的激活鏈接，你就可以登錄系統</p>
				<p>We emailed you to make sure we have the right email address.</p>
    			<p>Once you click the activation link in that email, you`ll be ready to sign in.</p>
			</div>
		</div>
	</div>
</div>
<div class="modal fade easylogin" id="EL_signup_complete2" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">註冊完成 / Sign up complete !</h4>
			</div>
			<div class="modal-body">
				<p>您的帳戶已建立！</p>
				<p>請立該 <a href="#" data-toggle="modal" data-target="#EL_signin">登入</a> 吧！</p>
				<p>Your account has been created !</p>
				<p>You can <a href="#" data-toggle="modal" data-target="#EL_signin">sign in</a> now.</p>
			</div>
		</div>
	</div>
</div>

<!-- Forgot password Modal -->
<div class="modal fade easylogin" id="EL_forgot_pass" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">忘記密碼 / Forgot Password</h4>
			</div>
			<form action="" method="POST" class="easylogin-form">
			<div class="modal-body">
				<div class="alert alert-warning">
					<button type="button" class="close dismiss">&times;</button><span></span>
				</div>
				<div class="form-group">
					<label>電郵地址 / Email <br>
						<input type="text" name="email" class="form-input" placeholder="請輸入您的電郵地址 / Enter your email address">
					</label>
					<!-- <input type="text" name="email" class="form-input" placeholder="Enter your email address"> -->
				</div>
				<?php if ($EL->config_item('require_captcha')): ?>
				<div class="form-group recaptcha-group"></div>
				<?php endif; ?>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary" style="float: left;">發送 / Send instructions</button>
				<span class="ajax-loader"></span>
				<div class="pull-right align-right">
					<a href="#" data-toggle="modal" data-target="#EL_signin">返回登入 / Back to Sign in</a><br>
				</div>
			</div>
			<input type="hidden" name="action" value="forgot_pass">
			</form>
		</div>
	</div>
</div>
<div class="modal fade easylogin" id="EL_recover_sent" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">忘記密碼 / Forgot Password</h4>
			</div>
			<div class="modal-body">
				<p>我們已經把一個鏈結發送到您的電郵地址</p>
				<p>只要按下連結便可以更改新的密碼</p>
				<p>A recover link has been sent to your email address.</p>
				<p>Once you click that link you`ll be able to change your password.</p>
			</div>
		</div>
	</div>
</div>

<!-- Resend activation email Modal -->
<div class="modal fade easylogin" id="EL_resend_activation" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">激活郵件 / Activation email</h4>
			</div>
			<form action="" method="POST" class="easylogin-form">
			<div class="modal-body">
				<div class="alert alert-warning">
					<button type="button" class="close dismiss">&times;</button><span></span>
				</div>
				<div class="form-group">
					<label>電郵地址 / Email <br>
						<input type="text" name="email" class="form-input">
					</label>
					<!-- <input type="text" name="email" class="form-input" placeholder="Enter your email address"> -->
				</div>
				<?php if ($EL->config_item('require_captcha')): ?>
				<div class="form-group recaptcha-group"></div>
				<?php endif; ?>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary" style="float: left;">發送 / Send</button>
				<span class="ajax-loader"></span>
				<div class="pull-right align-right">
					<a href="#" data-toggle="modal" data-target="#EL_signin">返回登入 / Back to Sign in</a><br>
				</div>
			</div>
			<input type="hidden" name="action" value="resend_activation">
			</form>
		</div>
	</div>
</div>
<div class="modal fade easylogin" id="EL_recover_sent" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">忘記密碼 / Forgot Password</h4>
			</div>
			<div class="modal-body">
				<p>我們已經把一個鏈結發送到您的電郵地址</p>
				<p>只要按下鏈結便可以更改新的密碼</p>
				<p>A recover link has been sent to your email address.</p>
				<p>Once you click that link you`ll be able to change your password.</p>
			</div>
		</div>
	</div>
</div>

<!-- Activate completed Modal -->
<div class="modal fade easylogin" id="EL_account_activated" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">帳號激活 / Account activated</h4>
			</div>
			<div class="modal-body">
				<p>您的帳戶已建立！</p>
				<p>請立該 <a href="#" data-toggle="modal" data-target="#EL_signin">登入</a> 吧！</p>
				<p>Your account has been activated !</p>
				<p>You can <a href="#" data-toggle="modal" data-target="#EL_signin">sign in</a> now.</p>
			</div>
		</div>
	</div>
</div>

<!-- Recover password Modal -->
<div class="modal fade easylogin" id="EL_recover_pass" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">更改密碼 / Change Password</h4>
			</div>
			<form action="" method="POST" class="easylogin-form">
			<div class="modal-body">
				<div class="alert alert-warning">
					<button type="button" class="close dismiss">&times;</button><span></span>
				</div>
				<div class="form-group">
					<label>新密碼 / New Password <br>
						<input type="password" name="password" class="form-input">
					</label>
				</div>	
				<div class="form-group">
					<label>確認密碼 / Confirm Password <br>
						<input type="password" name="confirm_password" class="form-input">
					</label>
				</div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary">更改密碼 / Change Password</button>
				<span class="ajax-loader"></span>
			</div>
			<input type="hidden" name="action" value="recover_pass">
			<input type="hidden" name="recover_key">
			</form>
		</div>
	</div>
</div>

<?php else: ?>

<!-- My account Modal -->
<div class="modal fade easylogin" id="EL_account" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">我的帳戶 / My account</h4>
			</div>
			<form action="" method="POST" class="easylogin-form">
			<div class="modal-body">
				
				<ul class="nav nav-pills">
					<li class="active" style="text-align: center;margin-right: 10px;"><a href="#account_general" data-toggle="tab">一般<br>General</a></li>
					<?php if($EL->config_item('custom_fields')): ?>
					<li style="text-align: center;margin-right: 10px;"><a href="#account_settings" data-toggle="tab">設置<br>Settings</a></li>
					<?php endif; ?>
					<li style="text-align: center;margin-right: 10px;"><a href="#account_password" data-toggle="tab">密碼<br>Password</a></li>
					<li style="text-align: center;margin-right: 10px;"><a href="#account_avatar" data-toggle="tab">頭像<br>Avatar</a></li>
				</ul>

				<div class="alert alert-warning">
					<button type="button" class="close dismiss">&times;</button><span></span>
				</div>

				<div class="tab-content">
					<div class="tab-pane active" id="account_general">
						<div class="form-group">
							<label>電郵地址 / Email <br>
								<?php $userdata = get_userdata(current_user('id')); echo $userdata['data']['email'];?>
								<input type="hidden" name="email" class="form-input" readonly="readonly">
							</label>
						</div>
						<?php if ($EL->config_item('require_name')): ?>
						<div class="form-group">
							<label>姓名 / Full Name <br>
								<input type="text" name="name" class="form-input">
							</label>
						</div>
						<?php endif; ?>
						<div class="form-group">
							<label>網址 / Website <br>
								<input type="text" name="url" class="form-input">
							</label>
						</div>
					</div>
					<div class="tab-pane" id="account_settings">
						
					</div>
					<div class="tab-pane" id="account_password">
						<div class="info">如果您想更改密碼，請於下面更改 <br>If you would like to change the password type a new one.</div>
						<div class="form-group">
							<label>新密碼 / New Password <br>
								<input type="password" name="password" class="form-input">
							</label>
						</div>
						<div class="form-group">
							<label>確認新密碼 / Confirm New Password <br>
								<input type="password" name="confirm_password" class="form-input">
							</label>
						</div>
					</div>
					<div class="tab-pane" id="account_avatar">
						<div class="pull-left" style="width:60%">
							<div class="info">選擇您要顯示的頭像 <br>Chose how your avatar is displayed.</div>
							<label><input type="radio" name="avatartype" value="gravatar"> 預設 / Default</label>
							<label><input type="radio" name="avatartype" value="uploaded"> 上傳 / Uploaded</label>
							<?php $oauth_type = $EL->get_current_user('oauth'); ?>
							<?php if ($oauth_type == 'facebook'): ?>
							<label><input type="radio" name="avatartype" value="facebook"> Facebook</label>
							<?php elseif ($oauth_type == 'twitter'): ?>
							<label><input type="radio" name="avatartype" value="twitter"> Twitter</label>
							<?php elseif ($oauth_type == 'google'): ?>
							<label><input type="radio" name="avatartype" value="google"> Google+</label>
							<?php endif; ?>
							<br>
							<button type="button" class="btn btn-primary btn-sm edit-avatar">編輯頭像 / Edit Avatar</button>
						</div>
						<div class="pull-right">
							<img src="<?php echo $EL->get_current_user('avatar'); ?>" class="user-avatar">
						</div>
					</div>
				</div>	
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary">保存設置 / Save Changes</button>
				<span class="ajax-loader"></span>
			</div>
			<input type="hidden" name="action" value="account">
			</form>
		</div>
	</div>
</div>

<?php endif; ?>

<?php if (!$EL->is_logged() && $EL->config_item('require_captcha')): ?>
<script type="text/template" id="recaptchaTemplate">
	<label for="recaptcha_response_field">請輸下列文字 / Enter the words below</label>
	<div id="easylogin_recaptcha" class="recaptcha" style="display:none">
		<div id="recaptcha_image"></div>
	    <div class="recaptcha-btns">
			<div><a href="javascript:Recaptcha.reload()">刷新 / Reload</a> |</div>
			<div class="recaptcha_only_if_image"><a href="javascript:Recaptcha.switch_type('audio')">語音 / Listen</a> |</div>
			<div class="recaptcha_only_if_audio"><a href="javascript:Recaptcha.switch_type('image')">圖片 / Image</a> |</div>
			<div><a href="javascript:Recaptcha.showhelp()">幫助 / Help</a></div>
		</div>
		<input type="text" name="recaptcha_response_field" id="recaptcha_response_field" class="form-input">
	</div>
</script>
<input type="hidden" name="recaptcha_public_key" value="<?php echo $EL->api_key('recaptcha/public_key'); ?>">
<?php endif; ?>