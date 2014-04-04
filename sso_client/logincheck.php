<?php
session_start();
include('config.php');
include('functions.php');

// Logout admin if "unset" value set from sso server
if (isset($_SESSION['admin_login']) && ($_SESSION['admin_login'] == "unset")) {
	unset($_SESSION['admin_login']);
}

// Redirct if admin not logged in
if (!isset($_SESSION['admin_login'])) {

	$arr = array( 
			'service' => "${sso_client}/loginservice.php",
			'referer' => $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'],
			'session' => session_id()
		);

	$str = urlencode(serialize($arr));
	$str = obfuscate("ENC", $str, $secret);

	header("Location: $sso_server/login.php?".$str);
	die;
}

