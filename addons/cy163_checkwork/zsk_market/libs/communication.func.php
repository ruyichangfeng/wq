<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
function ihttp_email($to, $subject, $body, $global = false) {
	static $mailer;
	set_time_limit(0);
	if (empty($mailer)) {
		if (!class_exists('PHPMailer')) {
			include ZSK_PATH."/libs/phpmailer/class.phpmailer.php"; 
		}
		$mailer = new PHPMailer();
		global $_W;
		$config = $GLOBALS['_W']['setting']['mail'];
			$config['smtp']['server'] = 'ssl://smtp.qq.com';
			$config['smtp']['port'] = 465;
		$mailer->signature = $config['signature'];
		$mailer->isSMTP();
		$mailer->CharSet = $config['charset'];
		$mailer->Host = $config['smtp']['server'];
		$mailer->Port = $config['smtp']['port'];
		$mailer->SMTPAuth = true;
		$mailer->Username = $config['username'];
		$mailer->Password = $config['password'];
		!empty($config['smtp']['authmode']) && $mailer->SMTPSecure = 'ssl';

		$mailer->From = $config['username'];
		$mailer->FromName = $config['sender'];
		$mailer->isHTML(true);
	}
	if ($body) {
		if (is_array($body)) {
			$newbody = '';
			foreach($body as $value) {
				if (substr($value, 0, 1) == '@') {
					if(!is_file($file = ltrim($value, '@'))){
						return error(1, $file . ' 附件不存在或非文件！');
					}
					$mailer->addAttachment($file);
				} else {
					$newbody .= $value . '\n';
				}
			}
			$body = $newbody;
		} else {
			if (substr($body, 0, 1) == '@') {
				$mailer->addAttachment(ltrim($body, '@'));
				$body = '';
			}
		}
	}
	if (!empty($mailer->signature)) {
		$body .= htmlspecialchars_decode($mailer->signature);
	}
	$mailer->Subject = $subject;
	$mailer->Body = $body;
	$mailer->addAddress($to);
	if ($mailer->send()) {
		return true;
	} else {
		return error(1, $mailer->ErrorInfo);
	}
}
