<?php
header ( 'Content-Type: image/gif' );
readfile ( 'mapcache.gif' );

require 'wow.php';
require 'geoip/geoipcity.inc';
require 'geoip/geoip.inc';

$image  = imagecreatefromgif ( "images/map.gif" );
$offset = 0;

if ( date('Y-m-d', filemtime ( 'mapcache.gif' ) ) != date ( 'Y-m-d' ) || isset ( $_GET['refresh'] ) ) {
    $gi        = geoip_open ( "geoip/GeoLiteCity.dat", GEOIP_STANDARD );
    $rsGeoData = geoip_record_by_addr ( $gi, $ip );

    $dot    = imagecolorallocate ( $image, 143, 0, 0 );
    $normal = imagecolorallocate ( $image, 0, 0, 0 );
    $red    = imagecolorallocate ( $image, 255, 0, 0 );
    $dota   = imagecolorallocatealpha ( $image, 0, 0, 255, 50 );

    $sql = mysqli_query ( wow ( ), "SELECT * FROM wow" );
    while ( $wow = mysqli_fetch_assoc ( $sql ) ){
        $rsGeoData = geoip_record_by_addr ( $gi, $wow["wow_from"] );
        $scale_x   = imagesx ( $image );
        $scale_y   = imagesy ( $image );
        $lat       = $rsGeoData->latitude;
        $long      = $rsGeoData->longitude;
        $pt        = getlocationcoords ( $lat, $long, $scale_x, $scale_y );
        if ( $lat != 0 && $long != 0 )
            ImageRectangle ( $image, $pt["x"] - $offset, $pt["y"], $pt["x"] - $offset, $pt["y"], $dot );
    }
    
    imagestring ( $image, 2, 1, 0, "WOWMeter World Map - http://wowmeter.us", $normal );
    imagestring ( $image, 2, 1, 240, "Updated every 24 hours", $normal );
    imagestring ( $image, 2, 450, 0, date ( 'Y/m/d' ), $normal );
    imagestring ( $image, 2, 450, 240, mysqli_num_rows ( $sql ) . " wows", $normal );

    imagegif ( $image, 'mapcache.gif' );
    imagedestroy ( $im );
}

function getlocationcoords ( $lat, $lon, $width, $height ) { 
   $x = ( ( $lon + 180 ) * ( $width / 360 ) ); 
   $y = ( ( ( $lat * -1 ) + 90 ) * ( $height / 180 ) );
   return array ( "x"=>$x, "y"=>$y ); 
}

function draw ( $lat, $lon, $color = NULL ) {
	global $image;
	global $offset;
	global $dot;
	if ( $color == NULL )
		$color = $dot;
	$pt = getlocationcoords ( $lat, $long, imagesx ( $image ), imagesy ( $image ) );
	ImageRectangle ( $image, $pt["x"] - $offset, $pt["y"], $pt["x"] + 1 - $offset, $pt["y"] + 1, $dot );
}
