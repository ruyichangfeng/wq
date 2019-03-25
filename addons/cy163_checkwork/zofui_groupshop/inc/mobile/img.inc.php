<?php 

	//error_reporting(E_ERROR); //e_all

	header('Content-Type: image/png');
	$url = urldecode($_GET['url']);
	
	QRcode::png($url,false,'L',6.4,1);
	