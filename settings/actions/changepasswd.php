<?php
require '../../wow.php';

# Login restriction
if ( !$member_access ) {
    header ( "Location: ../../index.php" );
    exit;
}

if ( isset ( $_POST['submit'] ) ) {
  
  # Variables
  $old_password       = doSafe ( hash ( 'sha512', $salt.$_POST['oldpasswd'] ) );
  $new_password       = doSafe ( $_POST['newpasswd'] );
  $new_password_again = doSafe ( $_POST['newpasswdagain'] );
  $expire             = time ( ) + 60 * 60 * 24 * 30;
  
  # Query
  $old_password_check = mysqli_query ( wow ( ), "SELECT password FROM users WHERE password = '" . $old_password . "' AND username = '" . $username . "'" );
  
  # Checks
  if ( mysqli_num_rows ( $old_password_check ) != 1 )
    die ( 'Your old password is not correct.' );
  
  else if ( $new_password != $new_password_again )
    die ( 'Your passwords did not match.' );
  
  else if ( strlen ( $new_password ) > PASSWORD_MAX )
    die ( 'Your password is too long.' );
  
  else if ( strlen ( $new_password ) < PASSWORD_MIN )
    die ( 'Your password is too short.' );
  
  # Secure the passwords and insert into the database
  $new_password    = hash ( 'sha512', $salt.$new_password );
  $password_update = mysqli_query ( wow ( ), "UPDATE users SET password = '" . $new_password . "' WHERE username = '" . $username . "'" );
  
  # Error Handling + Cookies
  if ( !$password_update ) {
    die ( 'Invalid query request to the database.' );
  } else {
    setcookie ( "password", hash ( 'sha512', $salt.$new_password ), $expire, "/" );
		header ( 'Location: /' );
		exit;
  }
  
  
}

require '../header.php';
?>


<div class="box small" style="width: 85%;">	
	<div class="title">Change password</div>
	<form action method="POST">
	<h6>Please enter your current password and your new password in the form below.</h6><br>
			<input type="password" class="form-control" placeholder="Current password" name="oldpasswd">
			<input type="password" class="form-control" placeholder="New password" name="newpasswd">
			<input type="password" class="form-control" placeholder="New password again" name="newpasswdagain">
			<button type="submit" class="button cosmo ico-save right" name="submit" id="submit">Change password</button>
			<a href="/settings" class="button blue ico-left left">Go back</a>
	</form>
</div>

<?php $no_script = 1; require '../../main.php'; ?>
