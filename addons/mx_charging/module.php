<?php
defined('IN_IA') or exit('Access Denied');
class mx_chargingModule extends WeModule {
	public function welcomeDisplay(){
		header('location:'.$this->createWeburl('default'));
		exit();
	}
}