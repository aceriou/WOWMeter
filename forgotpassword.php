<?php
die ('soon');

include_once($_SERVER['DOCUMENT_ROOT']."/wow.php");
include_once($_SERVER['DOCUMENT_ROOT']."/header.php");
$get_password_token = $_GET['password_token'];
$password_reset = false;

// Send verification email
if (isset($_POST['submit'])) {
	// Email variable
	$email = safe($_POST['email']);
	
	// Check if email exists
	$email_exists = mysqli_query(db(), "SELECT * FROM users WHERE email = '".$email."'");
	if (mysqli_num_rows($email_exists) < 1) {
		// Email does not exist
		echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert">&times;</a><strong>Sorry!</strong> The email you entered is not valid :(</div>';
		
	} else {
		// The email exists
		// Generate a password reset token (with salting)
		$password_token = hash('sha256', $salt.$email);
		// Add the token to your account
		$update_token = mysqli_query(db(), "UPDATE users SET password_token = '".$password_token."' WHERE email = '".$email."'");
		
		// If it updated correctly
		if ($update_token) {
			// Do the email thing
			$to      = $email;
			$subject = 'WOWMeter Password Reset';
			$message = 'Goto http://'.$url.'/forgotpassword.php?password_token='.$password_token.' to reset your password.';
			$headers = 'From: prestotron7@gmail.com' . "\r\n" .
    		'Reply-To: prestotron7@gmail.com' . "\r\n" .
    		'X-Mailer: PHP/' . phpversion();
			mail($to, $subject, $message, $headers);
		} else {
			// Error
			die("Email could not send. Unknown error occured. (L36)");
		}
		
		// Alert the user, that an email has been sent
		echo '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert">&times;</a><strong>Success!</strong> A password reset has been sent to your email. Please check your spam folder if it is not there! :)</div>';
		
	}
	
}


// Reset the password
if (isset($_POST['passwordsubmit'])) {
	// Get the password
	$newpassword = safe($_POST['password']);
	$confirmpassword = safe($_POST['confirmpassword']);
	// Requirements check
	if ($newpassword != $confirmpassword) {
		die("The passwords do not match!");
	}
	if (strlen($newpassword) > 50){
		die("Your password is too long. 50 characters maximum.");
	}
	if ($newpassword == 123456) { 
		die("Your password is too easy!"); 
	} 
	// Salt the password
	$hashedpassword = hash('sha256', $salt.$newpassword);
	// Change the password
	$change_password = mysqli_query(db(), "UPDATE users SET password = '".$hashedpassword."' WHERE password_token = '".$get_password_token."'");
	if ($change_password) {
		// Password has been changed
		echo '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert">&times;</a><strong>Success!</strong> Your password has been changed :)</div>';
		
	} else {
		// Password has not been changed
		echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert">&times;</a><strong>Sorry!</strong> Your password was not changed :(</div>';
	}
}

// If we have a confirmed our email
if ($_GET['password_token'] != "") {
	// Check if the token exists
	$check_token = mysqli_query(db(), "SELECT * FROM users WHERE password_token = '".$_GET['password_token']."'");
	if (mysqli_num_rows($check_token) < 1) {
		// The password token is incorrect. We cannot reset our password
		$password_reset = false;
	} else {
		// The password token is correct. We can reset our password	
		$password_reset = true;
	}
	
}

?>
<div class="box small" style="width: 85%;">	
	<div class="title">Forgot Password</div>
	<form action method="post">
		<?php if ($password_reset == false) { ?>
		<h6>Forgot your password?
		<p>Forgot your password? Send a password reset request to your email in which you registered your <?php echo $sitename; ?> account with.</p></h6>
		<br />
		<input type="text" class="form-control" placeholder="Your email" name="email"><br />
		<button type="submit" class="button cosmo ico-save" name="submit" id="submit">Send email</button>
		<a href="/" class="button blue ico-left">Go back</a>
		<?php } else { ?>
		<h6>Recover a password<p>Please enter a new password for your account.</p></h6>
		<input type="password" class="form-control" placeholder="Enter a new password" name="password"><br />
		<input type="password" class="form-control" placeholder="Confirm password" name="confirmpassword"><br />
		<button type="submit" class="button cosmo ico-save" name="passwordsubmit" id="submit">Reset</button>
		<a href="/" class="button blue ico-left">Go back</a>
		<?php } ?>
	</form>
</div>
<?php
$noprofile_n_shit = 1;
include_once($_SERVER['DOCUMENT_ROOT']."/main.php");
?>