<?php
/*
	This script detects the client's IP address and fetches ISP info from ipinfo.io/
	Output from this script is a JSON string composed of 2 objects: a string called processedString which contains the combined IP, ISP, Contry and distance as it can be presented to the user; and an object called rawIspInfo which contains the raw data from ipinfo.io (will be empty if isp detection is disabled).
	Client side, the output of this script can be treated as JSON or as regular text. If the output is regular text, it will be shown to the user as is.
*/
error_reporting(0);
$ip = "";
header('Content-Type: application/json; charset=utf-8');
if(isset($_GET["cors"])){
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST');
}
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0, s-maxage=0');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');

$ip = $_SERVER['REMOTE_ADDR'];

if ($ip == "::1") { // ::1/128 is the only localhost ipv6 address. there are no others, no need to strpos this
    //echo json_encode(['processedString' => $ip . " - localhost IPv6 access", 'rawIspInfo' => ""]);
	echo '{"processedString":"'.$ip.' - localhost IPv6 access","rawIspInfo":""}';
    exit;
}
elseif (stripos($ip, 'fe80:') === 0) { // simplified IPv6 link-local address (should match fe80::/10)
    //echo json_encode(['processedString' => $ip . " - link-local IPv6 access", 'rawIspInfo' => ""]);
	echo '{"processedString":"'.$ip.' - link-local IPv6 access","rawIspInfo":""}';
    exit;
}
elseif (stripos($ip, 'fd') === 0) { // simplified IPv6 link-local address (should match fe80::/10)
    //echo json_encode(['processedString' => $ip . " - link-local IPv6 access", 'rawIspInfo' => ""]);
	echo '{"processedString":"'.$ip.' - link-local IPv6 access","rawIspInfo":""}';
    exit;
}
elseif (strpos($ip, '127.') === 0) { //anything within the 127/8 range is localhost ipv4, the ip must start with 127.0
    //echo json_encode(['processedString' => $ip . " - localhost IPv4 access", 'rawIspInfo' => ""]);
	echo '{"processedString":"'.$ip.' - localhost IPv4 access","rawIspInfo":""}';
    exit;
}
elseif (strpos($ip, '10.') === 0) { // 10/8 private IPv4
    //echo json_encode(['processedString' => $ip . " - private IPv4 access", 'rawIspInfo' => ""]);
	echo '{"processedString":"'.$ip.' - private IPv4 access","rawIspInfo":""}';
    exit;
}
elseif (preg_match('/^172\.(1[6-9]|2\d|3[01])\./', $ip) === 1) { // 172.16/12 private IPv4
    //echo json_encode(['processedString' => $ip . " - private IPv4 access", 'rawIspInfo' => ""]);
	echo '{"processedString":"'.$ip.' - private IPv4 access","rawIspInfo":""}';
    exit;
}
elseif (strpos($ip, '192.168.') === 0) { // 192.168/16 private IPv4
    //echo json_encode(['processedString' => $ip . " - private IPv4 access", 'rawIspInfo' => ""]);
	echo '{"processedString":"'.$ip.' - private IPv4 access","rawIspInfo":""}';
    exit;
}
elseif (strpos($ip, '169.254.') === 0) { // IPv4 link-local
    //echo json_encode(['processedString' => $ip . " - link-local IPv4 access", 'rawIspInfo' => ""]);
	echo '{"processedString":"'.$ip.' - link-local IPv4 access","rawIspInfo":""}';
    exit;
}
else { // IPv4 link-local
	echo '{"processedString":"'.$ip.'","rawIspInfo":""}';
    exit;
}
?>
