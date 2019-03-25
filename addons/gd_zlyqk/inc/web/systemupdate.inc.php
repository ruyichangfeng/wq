<?php
$url =$this->OsUrl."checkUpdates?version=0";
$result =file_get_contents($url);
$serverVersion =json_decode(trim($result),true);
include $this->template("system_update");