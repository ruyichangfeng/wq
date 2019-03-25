<?php

global $_W, $_GPC;
$doName = 'register';

return header('Location: ' . url('entry', array('m' => $_GPC['m'], 'do' => 'complete')));
include $this->template('register');
