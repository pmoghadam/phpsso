<?php

function obfuscate($job, $str, $secret)
{
	$method = "AES-128-ECB";

	if (strtoupper($job) == "ENC")
		return openssl_encrypt($str, $method, $secret);

	if (strtoupper($job) == "DEC")
		return openssl_decrypt($str, $method, $secret);

	return FALSE;
} 

