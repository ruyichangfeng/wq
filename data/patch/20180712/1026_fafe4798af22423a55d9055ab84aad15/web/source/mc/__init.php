<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */

$account_api = WeAccount::create();
if (is_error($account_api)) {
	message($account_api['message'], url('account/display'));
}
$check_manange = $account_api->checkIntoManage();

if (is_error($check_manange)) {
	$account_display_url = $account_api->accountDisplayUrl();
	itoast('', $account_display_url);
} else {
	$account_type = $account_api->menuFrame;
	define('FRAME', $account_type);
}
