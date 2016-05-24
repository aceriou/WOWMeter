<?php
require '../wow.php';

# Login restriction
if ( !$member_access ) {
    header ( "Location: ../" );
    exit;
}

# Variables
$action = doSafe ( $_GET['action'] );

# Run scripts
if ( $action == "deleteacc" || $action == "update" || $action == "changeusrname" || $action == "changepasswd" ) {
  require_once 'actions/' . $action . '.php';
  exit;
} else {
  die ( 'WOWRequest invalid.' );
}


