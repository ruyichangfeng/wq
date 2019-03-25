<?php
session_start();
	date_default_timezone_set('PRC'); 	
	function __autoload($classname){
		require_once $classname .'.class.php';
	}
	$ac = new Actions();
	if(!isset($_SESSION['AgentUser']) || empty($_SESSION['AgentUser'])){		
		$ac->success("登陆后操作！！","login.php");
	}else{
		$data = [
			'table' => 'config',
			'where' => 'aid = '.$_SESSION['Id'].' and uniacid ='.$_SESSION['Uniacid'].'',
		];
		$cfg = $ac->Find($data);
	}