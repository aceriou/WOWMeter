<?php
require_once '../wow.php';

# Login restriction
if ( !$member_access ) {
    header ( "Location: ../index.php" );
    exit;
}

# Security input checks
if ( !isset ( $_POST['submit'] ) ) {
    header ( "Location: ../index.php" );
    exit;
}

# Variables and Array
$background     = doSafe ( $_POST['bg'] );
$username_color = doSafe ( $_POST['usrname_color'] );
$text_color     = doSafe ( $_POST['text_color'] );
$font           = doSafe ( $_POST['font'] );
$bg_color       = "orange";

$bgcolors = array(
  	"orange",
  	"red",
  	"lime",
  	"aqua",
  	"blue",
  	"fuchsia",
  	"purple",
	"gray",
	"rainbow"
);

# Security
if ( in_array ( $_POST['bgcolor'], $bgcolors ) )
  $bg_color = doSafe ( $_POST['bgcolor'] );

if ( !is_numeric ( $font ) || $font < 1 || $font > 5 || !is_numeric ( $background ) || $background < 1 || $background > 7 || !preg_match('/^[a-f0-9]{6}$/i', $username_color || !preg_match('/^[a-f0-9]{6}$/i', $text_color ) ) {
  header( "Location: ../settings/index.php?alert=no" );
  exit;
}

# Query
$setbg            = mysqli_query ( wow ( ), "UPDATE users SET sig_bg = '$background' WHERE username = '$username'" );
$setusrname_color = mysqli_query ( wow ( ), "UPDATE users SET usrname_color = '$username_color' WHERE username = '" . $username . "'" );
$settext_color    = mysqli_query ( wow ( ), "UPDATE users SET text_color = '$text_color' WHERE username = '" . $username . "'" );
$setfont          = mysqli_query ( wow ( ), "UPDATE users SET sig_font = '$font' WHERE username = '" . $username . "'" );
$setbg_color      = mysqli_query ( wow ( ), "UPDATE users SET bg_color = '$bg_color' WHERE username = '$username'" );

# Get out of here you bitch
if ( !$setusrname_color || !$settext_color || !$setbg || !$setfont || !$setbg_color ) {
  header ( "Location: ../settings/index.php?alert=error" );
} else {
	header( "Location: ../settings/index.php?alert=success" );
}
