<?php
require 'header.php';

$random_strings = array ( 'Hi there', 'Hey', 'What\'s up', 'Hello', 'Yo' );
$rs_key         = array_rand ( $random_strings );


?>
	<div class="box small no-title headline">
    
		<?php
		if ( $member_access == 0 ) {
		  echo "<h2>Welcome to " . SITE_NAME . "!</h2><h6>Create an account to get your very own " . SITE_NAME . ".</h6>";
		} else {
		  echo "<h2>" . $random_strings[$rs_key] . ", $username!</h2>";
		}
    
    ?>
    
	</div>

<?php require 'main.php'; ?>
