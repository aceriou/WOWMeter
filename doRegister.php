<?php
require 'wow.php';

# Variables
$username = doSafe ( $_POST ['username'] );
$password = doSafe ( $_POST ['password'] );
$email    = doSafe ( $_POST ['email'] );

# Security Checks
$name_sql    = "SELECT username FROM users WHERE username = '".$username."' OR oldusrname = '".$username."'";
$ip_sql      = "SELECT username FROM users WHERE ip = '".$ip."'"; 
$email_sql   = "SELECT username FROM users WHERE email = '".$email."'"; 
$members     = mysqli_query ( wow ( ), $name_sql ); 
$ip_check    = mysqli_query ( wow ( ), $ip_sql );
$email_check = mysqli_query ( wow ( ), $email_sql );
$name_check  = mysqli_fetch_assoc ( $members ); 
$name        = mysqli_num_rows ( $members ); 
$ip_addr     = mysqli_num_rows ( $ip_check );
$email_addr  = mysqli_num_rows ( $email_check );

if ( strlen ( $username ) > USERNAME_MAX )
    die ( 'Username is too long for a Doge to understand. ' . USERNAME_MAX . ' maximum.' );

if ( strlen ( $username ) < USERNAME_MIN )
    die ( 'Username is too short for a Doge\'s likings. ' . USERNAME_MIN . ' character minimum.' );

if ( strlen ( $password ) > PASSWORD_MAX )
    die ( 'Password is much long very scary. ' . PASSWORD_MAX . ' max.' );

if ( !doEmailCheck ( $email ) )
    die ( 'Email is much invalid, very bad.' );

if ( preg_match('/[^\w-]+/i', $username ) )
    die ( 'Your username is too complex. We only allow alphanumeric characters, hyphens and underscores.' );

if ( $name >= 1 )
    die ( 'This username has already been registered.' );

if ( $ip_addr >= IP_MAX )
    die ( 'You have created too many accounts on this IP.' );

if ( $email_addr >= 1 )
    die ( 'You have already created an account under this email address.' );
    
# Prepare the password, and insert into the database
$password = hash ( 'sha512', $salt.$password );
  
$reg_query  = "INSERT INTO users (username, password, email, ip, sig_font) VALUES ( '".$username."', '".$password."', '".$email."', '".$ip."', '2')"; 
$sql_commit = mysqli_query ( wow ( ), $reg_query ); 
    
# Set the cookie
$user = mysqli_query ( wow ( ), "SELECT * FROM users WHERE username = '".$username."'" ); 
$user_array = mysqli_fetch_assoc ( $user ); 
$id_array = $user_array['id']; 
$expire = time ( ) + 60 * 60 * 24 * 30;
setcookie ( "username", $user_array['username'], $expire, "/" );
setcookie ( "id", $id_array, $expire, "/");
setcookie ( "password", $password, $expire, "/" );
if ( doAjax ( ) ) {
    die('success');
} else {
    header("Location: /");
}

?>
