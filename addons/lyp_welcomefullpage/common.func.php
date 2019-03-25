<?php
	function bind_domain_code() {
		$str = <<<EOF
// --- lyp_welcomefullpage_start --- //
if(file_exists(IA_ROOT . "/addons/lyp_welcomefullpage/bind_domain.php")) {
	include IA_ROOT . "/addons/lyp_welcomefullpage/bind_domain.php";
}
// --- lyp_welcomefullpage_end --- //
EOF;
		return $str;
	}
 ?>