<?php 
	$sh="openssl rsa -RSAPublicKey_in -in /www/wwwroot/cs/addons/zsk_market/core/cert/d41d8cd98f00b204e9800998ecf8427e/1490016592/rsa_public_key.pem -pubout -out /www/wwwroot/cs/addons/zsk_market/core/cert/d41d8cd98f00b204e9800998ecf8427e/1490016592/public_key.pem";
	shell_exec($sh);