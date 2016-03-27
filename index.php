<?php
require_once 'header.php';
?>
	<div class="box small no-title headline">
    
		<?php
		if ( $member_access == 0 ) {
		  echo "<h2>Welcome to " . SITE_NAME . "!</h2><h6>Create an account to get your very own " . SITE_NAME . ".</h6>";
		} else {
		  echo "<h2>Hi there, $username!</h2>";
		}
    
    ?>
    
	</div>

<?php require_once 'main.php'; ?>