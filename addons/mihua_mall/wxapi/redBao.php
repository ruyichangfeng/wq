<?php
ini_set('date.timezone','Asia/Shanghai');
error_reporting(E_ERROR);
require_once "lib/WxPay.Api.php";
require_once 'log.php';

//初始化日志
$logHandler= new CLogFileHandler("./logs/".date('Y-m-d').'.log');
$log = Log::Init($logHandler, 15);

$inputObj=new WxHongBao;

$inputObj->SetMch_billno(time());
$inputObj->SetOpenid('ozdcIj1KN57niPsGq4XVCBpphvKE');
$inputObj->setNick_name('米花');
$inputObj->SetSend_name('米花');
$inputObj->SetTotal_amount(100);
$inputObj->SetMin_value(100);
$inputObj->SetMax_value(100);
$inputObj->SetTotal_num(1);
$inputObj->SetWishing('米花的红包');
$inputObj->SetClient_ip('192.168.1.1');
$inputObj->SetAct_name('米花');
$inputObj->SetRemark('米花');
$inputObj->SetWxAppid('wxd2f406bed7de9fb9');
$inputObj->SetLogo_imgurl('http://www.szmihua.com/skin/logo.png');
$inputObj->SetShare_content('米花');
$inputObj->SetShare_url('http://www.szmihua.com');
$inputObj->SetShare_imgurl('http://www.szmihua.com/skin/logo.png');

WxPayApi::weixinHongBao($inputObj);
