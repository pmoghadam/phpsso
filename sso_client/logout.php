<?php
session_start();
include('config.php');

if (isset($_SESSION['admin_login'])) {
	unset($_SESSION['admin_login']);
}

$after_logout = urlencode($sso_client);

header("Location: $sso_server/logout.php?$after_logout");
