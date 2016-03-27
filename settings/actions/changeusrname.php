<?php
require_once '../wow.php';

$expire = time ( ) + 60 * 60 * 24 * 30;

# Login restriction
if ( !$member_access ) {
    header ( "Location: ../index.php" );
    exit;
}

if ( isset ( $_POST['submit'] ) ) {
  
  # Update Modes
  if ( $session_array['oldusrname'] == "" ) {
    # Variables
    $new_username = doSafe ( $_POST['usrname'] );
    
    # Queries
    $user_check   = mysqli_query ( wow ( ), "SELECT * FROM users WHERE username = '" . $new_username . "' OR oldusrname = '" . $new_username . "'" );
    
    # Checks
    if ( mysqli_num_rows ( $user_check ) >= 1 )
      die ( 'This username has already been registered.' );
    else if ( strlen ( $new_username ) > PASSWORD_MAX )
      die ( 'Your username is too long.' );
    else if ( strlen ( $new_username ) < PASSWORD_MIN )
      die ( 'Your username is too short.' );
    
    # Change username, error handling, and set new cookies
    $change_username = mysqli_query ( wow ( ), "UPDATE users SET username = '" . $new_username . "', oldusrname = '" . $username . "' WHERE id = '" . $session_array['id'] . "'" );
    
    if ( !$change_username ) {
      die ( 'Invalid query request to the database.' );
    } else {
        setcookie ( "username", $new_username, $expire, "/" );
				header ( 'Location: /' );
				exit;
    }
    
  } else {
    # Query
    $swap_username = mysqli_query ( wow ( ), "UPDATE users SET username = '" . $session_array['oldusrname'] . "', oldusrname = '" . $username . "' WHERE id = '" . $session_array['id'] . "'" );
    
    # Cookies and Errors
    if ( !$swap_username ) {
      die ( 'Unexpected database error.' );
    } else {
      setcookie ( "username", $session_array['oldusrname'], $expire, "/" );
			header ( 'Location: /' );
			exit;
    }
      
  }
  
}

require_once '../header.php';
?>

<div class="box small" style="width: 85%;">	
	<div class="title">Change username</div>
  
	<form action method="POST">
	<?php if ( $session_array['oldusrname'] != "" ) { ?>
	<h6>You can't change your username since<br>you've already changed it once.<br><br>
	However, you can still switch back into<br>your old username.</h6>
    
	<button type="submit" class="button cosmo ico-save" name="submit" id="submit">Switch back to <?php echo $session_array['oldusrname']; ?></button>
	<a href="/settings" class="button blue ico-left">Go back</a>
  
	<?php } else { ?>
	<h6>You can change your username only <strong>ONCE</strong>.<br><br>
	You can switch back into your old username anytime you wish. Your old codes will still work.</h6>
			<input type="text" class="form-control" placeholder="Your new username" name="usrname">
			<button type="submit" class="button cosmo ico-save" name="submit" id="submit">Change my username</button>
			<a href="/settings" class="button blue ico-left">Go back</a>
	<?php } ?>
	</form>
</div>

<?php $no_script = 1; require_once '../main.php'; ?>