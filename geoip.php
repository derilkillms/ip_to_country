<?php
// saya mengembangkan dari https://github.com/magorski/php-ip-2-country.git
function chceckIpAddr($ip=''){
	return preg_match('/^([1-9]|[1-9][0-9]|1[0-9][0-9]|2[0-4][0-9]|25[0-5])(\.([0-9]|[1-9][0-9]|1[0-9][0-9]|2[0-4][0-9]|25[0-5])){3}$/i',$ip);
}

function getIpValue($ip){
	$ipArr = explode('.',$ip);
	return $ipArr[3] + ( $ipArr[2] * 256 ) + ( $ipArr[1] * 256 * 256 ) + ( $ipArr[0] * 256 * 256 * 256 );
}


function getIpFromValue($value=0,$returnAsStr=true){
	$ip[0] = floor( intval($value) / (256*256*256) );
	$ip[1] = floor( ( intval($value) - $ip[0]*256*256*256 ) / (256*256) );
	$ip[2] = floor( ( intval($value) -$ip[0]*256*256*256 -$ip[1]*256*256 ) / 256 );
	$ip[3] = intval($value) - $ip[0]*256*256*256 - $ip[1]*256*256 - $ip[2]*256;
	if($returnAsStr){
		return $ip[0].'.'.$ip[1].'.'.$ip[2].'.'.$ip[3];
	}else{
		return $ip;
	}
}


$db = new mysqli('localhost','root','','db_country');

$getipna = getIpValue("103.28.12.168");
// echo $getipna;
// echo "<br>".getIpFromValue($getipna);

if ($result = $db -> query("SELECT * FROM `ip_to_country` WHERE IP_FROM <= ".intval($getipna)." AND IP_TO >= ".intval($getipna))) {
	foreach ($result as $key => $value) {
		echo $value['COUNTRY']." <img src='./image/".strtolower($value['CTRY'].".png' width='15px' />");
	}
}

