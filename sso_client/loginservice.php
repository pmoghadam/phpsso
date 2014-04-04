<?php
session_start();
include('config.php');
include('functions.php');

(strlen($_SERVER['QUERY_STRING']) > 0) or die;
$qstr = $_SERVER['QUERY_STRING'];
$qstr = obfuscate("DEC", $qstr, $secret);
$arr = unserialize(urldecode($qstr));

isset($arr['session']) or die;
$sid = $arr['session'];

isset($arr['var']) or die;
$var = $arr['var'];

isset($arr['value']) or die;
$value = $arr['value'];

session_id($sid);
$_SESSION["$var"] = $value;

