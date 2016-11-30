<?php
require_once 'wow.php';

# Variables
$username = doSafe ( $_POST['username'] );
$password = doSafe ( $_POST['password'] );

# Initialize an array
$array_query = mysqli_query ( wow ( ), "SELECT * FROM users WHERE username = '" . $username . "' OR oldusrname = '" . $username . "'" );
$user        = mysqli_fetch_assoc ( $array_query );
$user_number = mysqli_num_rows ( $array_query );

# Security Checks
if ( !$username ) {
    die ( 'You must fill in the form!' );
}

if ( $user_number != 1 ) {
    die ( 'Username is incorrect.' );
}

# Password Checking
$password = stripcslashes ( $password );
$password = hash ( 'sha512', $salt.$password );
if ( $password != $user['password'] ) {
    die ( 'Password is incorrect.' );
}

# Cookies
$user_array = $user;
$id_array = $user_array['id']; 
$expire = time ( ) + 60 * 60 * 24 * 30;
setcookie ( "username", $user_array['username'], $expire, "/" );
setcookie ( "id", $id_array, $expire, "/");
setcookie ( "password", $password, $expire, "/" );
if ( doAjax ( ) ) {
    die('success');
} else {
    header("Location: index.php");
}
