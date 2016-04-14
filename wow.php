<?php
// This is the backend of WOWMeter, most of the server-side code is placed here, the rest is placed randomly.
// PHP Functions, SQL configuration, etc. are all here
// Don't expect JS code to be here, as that is flying around everywhere.


# Configuration
$start = microtime( true );
header('content-type: text/html; charset=utf-8');
mb_internal_encoding ( "UTF-8" );
date_default_timezone_set ( 'America/New_York' );
@session_start ( );
error_reporting ( E_ALL ^ E_NOTICE );

mysqli_query ( wow ( ),'SET NAMES UTF8;');
mysqli_query ( wow (  ),'SET COLLATION_CONNECTION=utf8_general_ci;');

# Constants
define ( 'SITE_NAME', 'WOWMeter' );
define ( 'CONTACT', 'preston@cammarata.info' );

define ( 'USERNAME_MAX', 20 );
define ( 'USERNAME_MIN', 3 );
define ( 'PASSWORD_MAX', 50 );
define ( 'IP_MAX', 3 );

# Variables
$ip            = doSafe ( $_SERVER['REMOTE_ADDR'] );
$salt          = "yourSaltHere";
$member_access = 0;
$no_script     = 0;
$username      = '';
  
# SQL Configuration
function wow ( ) {
  $host     = 'localhost';
  $username = 'root';
  $password = 'password';
  $database = 'database';
  
  $db = new mysqli ( $host, $username, $password, $database );
  
  if ( $db->connect_error ) {
    die ( '<br /><br /><strong>In English:</strong><br />Doge cannot connect to the MySQL database, so instead it went to the moon. <br /><br /> <img src=\'http://revelwallpapers.net/d/735A64776548374C7670323971377143784B4E7632747650375A64766E673D3D/doge-dog-astronaut-meme-moon-landing-earth-planet-flag.jpg\' width=800 height=500></img> ' );
  }
  
  return $db;
  
}

# Sessions
$session_query = mysqli_query ( wow ( ), "SELECT * FROM users WHERE username = '" . doSafe ( $_COOKIE['username'] ) . "' AND id = '" . doSafe ( $_COOKIE['id'] ) . "' AND password = '" . doSafe ( $_COOKIE['password'] ) . "'" );
$session_array = mysqli_fetch_assoc ( $session_query );
$session_rows  = mysqli_num_rows ( $session_query );

if ( $session_rows != 1 ) {
  $member_access = false;
  
  setcookie ( "username", "", time ( ) - 3600 );
  setcookie ("id", "", time ( ) - 3600 );
  setcookie ( "password", "", time ( ) - 3600 );
  unset ( $_SESSION['username'] );
  unset ( $_SESSION['id'] );
  unset ( $_SESSION['password'] );
  
} else {
  
  $member_access = true;
  
  mysqli_query( wow ( ), "UPDATE users SET new_ip = '".$ip."' WHERE username='".doSafe ( $_COOKIE['username'] )."' AND id='".doSafe ( $_COOKIE['id'] )."' AND password='".doSafe ( $_COOKIE['password'] )."'" ) or die("Error updating the user database!");

}

if ( $session_array['is_banned'] ) {
  die ( 'Sorry, you are banned. such sad.' );
}

if ( $username == '' ) $username = doSafe ( $_COOKIE['username'] );

if ( $login_required )
  if ( !$member_access )
    die ( 'You need to be logged in to view this page.' );

# Functions
function doSafe ( $string ) {
  return htmlentities ( mysqli_real_escape_string ( wow ( ), $string ) );
}

function doEmailCheck( $email ) {
  if ( filter_var ( $email, FILTER_VALIDATE_EMAIL ) )
    return true;
  else
    return false;
}

function doAjax() {
  if ( isset ( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && strtolower ( $_SERVER['HTTP_X_REQUESTED_WITH'] ) == 'xmlhttprequest' ) {
    
    return true;
    
  } else {
    
    return false;
    
  }
  
}

function no_ajax_support ( ) {
  if ( strpos ( $_SERVER['HTTP_USER_AGENT'], 'Nintendo DSi') !== false || strpos ( $_SERVER['HTTP_USER_AGENT'], 'Nintendo 3DS' ) !== false ) {
    return true;
  } else {
    return false;
  }
}

function nicetime( $date ) {
    if ( empty ( $date ) ) {
        return "No date provided";
    }
    
    $periods         = array ( "second", "minute", "hour", "day", "week", "month", "year", "decade" );
    $lengths         = array ( "60","60","24","7","4.35","12","10" );
    
    $now             = time ( );
    $unix_date       = strtotime ( $date );
    
    if ( empty ( $unix_date ) ) {    
        return "some time ago";
    }

    if ( $now > $unix_date ) {    
        $difference  = $now - $unix_date;
        $tense       = "ago";
        
    } else {
        $difference  = $unix_date - $now;
        $tense       = "from now";
    }
    
    for ( $j = 0; $difference >= $lengths[$j] && $j < count ( $lengths ) - 1; $j++ ) {
        $difference /= $lengths[$j];
    }
    
    $difference = round ( $difference );
    
    if ( $difference != 1 ) {
        $periods[$j].= "s";
    }
    if ( substr ( $periods[$j], 0, 6 ) === "second" && $difference <= 59 ) {
      return "few seconds ago";
    } else {
      return "$difference $periods[$j] {$tense}";
    }
}

function readableColour ( $bg ) {
    $r = hexdec ( substr ( $bg, 0, 2 ) );
    $g = hexdec ( substr ( $bg, 2, 2 ) );
    $b = hexdec ( substr ( $bg, 4, 2 ) );
    $contrast = sqrt (
        $r * $r * .241 +
        $g * $g * .691 +
        $b * $b * .068
    );
    if ( $contrast > 160 ) {
        return true;
    } else {
        return false;
    }
}

# Quick Patches
if ( doAjax ( ) ) {
    $ajax_linebreak = "\n";
} else {
    $ajax_linebreak = "</br>";
}

?>
