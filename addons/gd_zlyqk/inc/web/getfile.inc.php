<?php
global $_GPC;
$file = $_GPC["name"];
$local = $_GPC["local"];
$this->getServerFile($file,$local);