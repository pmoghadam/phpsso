<?php
include ('config.php');
include('functions.php');

(strlen($_SERVER['QUERY_STRING']) > 0) or die;
$qstr = $_SERVER['QUERY_STRING'];
$qstr = obfuscate("DEC", $qstr, $secret);
$arr = unserialize(urldecode($qstr));

isset($arr['service']) or die;
$service = $arr['service'];

isset($arr['referer']) or die;
$referer = $arr['referer'];

isset($arr['session']) or die;
$sid = $arr['session'];

if (isset($_COOKIE["SSOID"])) {
	$admin_login = "yes";
}

//session_id($sid);

// Check username and password
if (	isset($_POST['username']) && $_POST['username'] == $username &&
	isset($_POST['password']) && $_POST['password'] == $password ){

	$admin_login = "yes";
}


if (isset($admin_login) && $admin_login == "yes") {

	// Remote session update
        $arr = array(
			'session' => $sid, 
			'var' => "admin_login",
			'value' => "yes" 
                );
        $str = urlencode(serialize($arr));
	$str = obfuscate("ENC", $str, $secret);
	$url = "$service?$str";
	$ch = curl_init();
	curl_setopt($ch,CURLOPT_URL, $url);
	$result = curl_exec($ch);
	curl_close($ch);

	// Update Cookie
	if (isset($_COOKIE["SSOID"])) {
		$arr = unserialize($_COOKIE['SSOID']);
		$c = count($arr);
		$arr["$c"]['service'] = "$service";
		$arr["$c"]['session'] = "$sid";
		$str = serialize($arr);
	} else {
		$str = serialize(array(array('service' =>"$service",'session'=>"$sid")));
	}
	setcookie("SSOID", "$str");

	header("Location: http://$referer");
	die;
}

?>

<form action='' method='post'>
<input type='text' placeholder='Username' name='username'>
<input type='password' placeholder='Password' name='password'>
<input type='submit' value='Login'>
</form>

<?php die;
