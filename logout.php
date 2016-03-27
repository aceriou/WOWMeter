<?php

$member_access = 0;
setcookie ( "username", "", time ( )-3600, "/" );
setcookie ( "id", "", time ( )-3600, "/" );
setcookie ( "password", "", time ( )-3600, "/" );
unset ( $_SESSION['username'] );
unset ( $_SESSION['id'] );
unset ( $_SESSION['password'] );
header ( 'Location: /' );

?>