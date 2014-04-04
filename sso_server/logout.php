<?php
include ('config.php');
include('functions.php');

if (isset($_COOKIE['SSOID'])) {
	$arr = unserialize($_COOKIE['SSOID']);
	setcookie("SSOID", "",1);
	
	foreach($arr as $i) { 
		$service = $i['service'];
		$sid = $i['session'];

        	$q_arr = array(
                        'session' => $sid,
                        'var' => "admin_login",
                        'value' => "unset"
                );
        	$str = urlencode(serialize($q_arr));
		$str = obfuscate("ENC", $str, $secret);
        	$url = "$service?$str";
        	$ch = curl_init();
        	curl_setopt($ch,CURLOPT_URL, $url);
        	$result = curl_exec($ch);
        	curl_close($ch);
	}
}

if (strlen($_SERVER['QUERY_STRING']) > 0) {
	$url = urldecode($_SERVER['QUERY_STRING']);
	header("Location: $url");
} else {
	echo "You Are Logged Out !!!";
}
