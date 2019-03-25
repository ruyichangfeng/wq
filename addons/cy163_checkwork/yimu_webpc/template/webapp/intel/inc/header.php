<?php
//      global $_W, $_GPC;
//      load()->func('tpl');
//      $id = $_GPC['i'];
        $setting = pdo_fetch("SELECT * FROM ".tablename('ym_webpc_shezhi')." WHERE acid = :acid", array(':acid' => $id));
        if (empty($setting)){
        	$setting = pdo_fetch("SELECT * FROM ".tablename('ym_webpc_shezhi')." WHERE acid = :acid", array(':acid' => '0'));
        }
        $nemu = pdo_fetch("SELECT * FROM ".tablename('ym_webpc_nemun')." WHERE acid = :acid", array(':acid' => $id));
        if (empty($nemu)){
        	$nemu = pdo_fetch("SELECT * FROM ".tablename('ym_webpc_nemun')." WHERE acid = :acid", array(':acid' => '0'));
        }
        $unnemu = unserialize($nemu['userbt']);
        $inx = pdo_fetch("SELECT * FROM ".tablename('ym_webpc_index_set')." WHERE acid = :acid", array(':acid' => $id));
        if (empty($inx)){
        	$inx = pdo_fetch("SELECT * FROM ".tablename('ym_webpc_index_set')." WHERE acid = :acid", array(':acid' => '0'));
        }
       
?>