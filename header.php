<?php
require_once 'wow.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title><?php echo SITE_NAME; ?></title>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="WOWMeter is a website where you can give and recieve wows to show how cool and awesome you are.">
  <meta name="keywords" content="cute,dog,doge,dogs,funny,kawaii,net,tk,weird,wow,wowmeter">
  <link rel="stylesheet" href="/css/bootstrap.min.css" type="text/css" />
  <link rel="stylesheet" href="/css/main.css" type="text/css" />
  <link rel="shortcut icon" href="/images/og_image.png">
  <script src="/js/main.js?v=2"></script>
</head>
  
<?php

  if ( $member_access ) {
    $bgcolors = array (
		  "orange"  => "F5D68F",
		  "red"     => "F5928F",
		  "lime"    => "D0F58F",
		  "aqua"    => "8FF2F5",
		  "blue"    => "8FAEF5",
		  "fuchsia" => "F58FE1",
		  "purple"  => "B48FF5",
		  "gray"    => "778899",
		  "rainbow" => "F5928F"
	  );
    
?>

<style type="text/css">body{ background-color: #<?php echo $bgcolors[$session_array['bg_color']]; ?>;</style>

<?php } ?>
    
<body class="bg center<?php if ( $saddoge == 1 ) echo " saddoge"; ?>">
  <a href="/index.php" class="header">WOWMeter</a>
	
