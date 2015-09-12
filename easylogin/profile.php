<?php 

require_once('includes/load.php'); 
$EL = EasyLogin::getInstance();

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>User Profile</title>
	<!-- Demo CSS -->
	<link rel="stylesheet" href="assets/css/demo.css">
	<!-- jQuery -->
	<script src="assets/js/jquery-1.11.0.min.js"></script>
</head>
<body>
<?php load_templates(); ?>
<div id="container">
	<a href="index.php">&larr; Back Home</a>
	<div style="float:right;">
		<?php if (is_user_logged_in()): ?>	
			Logged as <?php echo current_user('username'); ?> | 
			<a href="#" data-toggle="modal" data-target="#EL_account">My Account</a> | 
			<?php if (current_user('role') == 'admin'): ?>
				<a href="admin/">Admin</a> |
			<?php endif; ?>
			<a href="#" onclick="EasyLogin.signout();">Sign out</a>
		<?php else: ?>
			<a href="#" data-toggle="modal" data-target="#EL_signin">Sign in</a> |
			<a href="#" data-toggle="modal" data-target="#EL_signup">Sign up</a>
		<?php endif; ?>
	</div>
	<br clear="all"><br>

	<div class="profile">
	<?php
		if (!empty($_GET['uid']) && is_numeric($_GET['uid'])) {
			$user_id = $_GET['uid'];
			$userdata = $EL->get_userdata($user_id);
			if ($userdata) {
				$user = $userdata['data'];
				?>
				<img src="<?php echo get_user_avatar($user_id); ?>" width="200" height="200" class="profile-image">
				<div class="user-info">
					<p><strong><?php echo $user['name']; ?></strong></p>
					<p>Joined <?php echo date('M d, Y', strtotime($user['registered'])); ?></p>
					<?php
					if (!empty($user['url'])) {
						echo '<p><a href="'.$user['url'].'">'.$user['url'].'</a></p>';
					}
					?>
				</div>
				<br clear="all">
				<?php
				if (!empty($userdata['usermeta']['about'])) {
					echo '<p>'.$userdata['usermeta']['about'].'</p>';
				}
				
			} else {
				echo '<p>Profile page not found.</p>';
			} 

		} else {
			echo '<p>Invalid user id.</p>';
		}
	?>		
	</div>
</div>
</body>
</html>