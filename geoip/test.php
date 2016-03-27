<?php
header('content-type: text/html; charset=utf-8');
mb_internal_encoding("UTF-8");
require_once($_SERVER['DOCUMENT_ROOT']."/geoip/geoipregionvars.php");
require_once($_SERVER['DOCUMENT_ROOT']."/geoip/geoipcity.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/geoip/geoip.inc");
 
$ipaddress = $_GET['ip'];
$gi = geoip_open($_SERVER['DOCUMENT_ROOT']."/geoip/GeoLiteCity.dat", GEOIP_STANDARD);
$rsGeoData = geoip_record_by_addr($gi, $ipaddress);
$lat = $rsGeoData->latitude;
$long = $rsGeoData->longitude;
$city = utf8_encode($rsGeoData->city);
$state = $GEOIP_REGION_NAME[$rsGeoData->country_code][$rsGeoData->region];
$country = $rsGeoData->country_name;
geoip_close($gi);
echo "<h1>ip: ".$_GET['ip']."</h1>";
echo $city . ":" . $state . ":" . $country;
?>