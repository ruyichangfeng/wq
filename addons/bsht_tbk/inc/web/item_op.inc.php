<?php global $zym_decrypt;$zym_decrypt['�֮�����î����֯�þ��Į���֥����']=base64_decode('ZGVmaW5lZA==');$zym_decrypt['��ïĈ������Ô�þ�Ë������������']=base64_decode('cGRvX2ZldGNoYWxs');$zym_decrypt['��֥��֔����֋����Î�֋���������']=base64_decode('dGFibGVuYW1l');$zym_decrypt['����ï�������î��Ď���֋ï����֋']=base64_decode('dGltZQ==');$zym_decrypt['����������Ë������������������Î']=base64_decode('c3RydG90aW1l');$zym_decrypt['��֮��������ֈ�������������Ĕ���']=base64_decode('cGRvX3VwZGF0ZQ==');$zym_decrypt['�ֈ��Ď���֔þ���å֮�������î��']=base64_decode('bWVzc2FnZQ==');$zym_decrypt['��֯��ľ�ï�ľ֋ֈ�����֯����֔�']=base64_decode('cGRvX2RlbGV0ZQ=='); ?>
<?php
$GLOBALS['zym_decrypt']['�֮�����î����֯�þ��Į���֥����'](base64_decode('SU5fSUE='))or exit(base64_decode('QWNjZXNzIERlbmllZA=='));global $_W,$_GPC;$op =!empty($_GPC['op'])? $_GPC['op'] : 'display';if(base64_decode('eGlhamlhX2Rhb3Fp') == $op){$list =$GLOBALS['zym_decrypt']['��ïĈ������Ô�þ�Ë������������']("SELECT * FROM ".$GLOBALS['zym_decrypt']['��֥��֔����֋����Î�֋���������']($this->tableitem)." WHERE uniacid = '{$_W['uniacid']}'");foreach ($list as $key => $value){if ($GLOBALS['zym_decrypt']['����ï�������î��Ď���֋ï����֋']()-$GLOBALS['zym_decrypt']['����������Ë������������������Î']($list[$key]['itemyhj_etime'])>=86400 && !empty($list[$key]['itemyhj_url'])){$data=array('status' => 0, );$GLOBALS['zym_decrypt']['��֮��������ֈ�������������Ĕ���']($this->tableitem, $data, array('id' => $list[$key]['id']));}}$GLOBALS['zym_decrypt']['�ֈ��Ď���֔þ���å֮�������î��'](base64_decode('5pON5L2c5oiQ5Yqf77yB'), $this->createWebUrl('listitem', array('op' => 'display')), 'success');}if(base64_decode('ZGVsX2Rhb3Fp') == $op){$list =$GLOBALS['zym_decrypt']['��ïĈ������Ô�þ�Ë������������']("SELECT * FROM ".$GLOBALS['zym_decrypt']['��֥��֔����֋����Î�֋���������']($this->tableitem)." WHERE uniacid = '{$_W['uniacid']}'");foreach ($list as $key => $value){if ($GLOBALS['zym_decrypt']['����ï�������î��Ď���֋ï����֋']()-$GLOBALS['zym_decrypt']['����������Ë������������������Î']($list[$key]['itemyhj_etime'])>=86400 && !empty($list[$key]['itemyhj_url'])){$GLOBALS['zym_decrypt']['��֯��ľ�ï�ľ֋ֈ�����֯����֔�']($this->tableitem, array('uniacid' => $_W['uniacid'] ,'id' => $list[$key]['id']));$GLOBALS['zym_decrypt']['��֯��ľ�ï�ľ֋ֈ�����֯����֔�']($this->tablefav, array('uniacid' => $_W['uniacid'] ,'itemid' => $list[$key]['id']));}}$GLOBALS['zym_decrypt']['�ֈ��Ď���֔þ���å֮�������î��'](base64_decode('5pON5L2c5oiQ5Yqf77yB'), $this->createWebUrl('listitem', array('op' => 'display')), 'success');}if(base64_decode('eGlhamlhX25vbmU=') == $op){$list =$GLOBALS['zym_decrypt']['��ïĈ������Ô�þ�Ë������������']("SELECT * FROM ".$GLOBALS['zym_decrypt']['��֥��֔����֋����Î�֋���������']($this->tableitem)." WHERE uniacid = '{$_W['uniacid']}'");foreach ($list as $key => $value){if (empty($list[$key]['itemyhj_url'])){$data=array('status' => 0, );$GLOBALS['zym_decrypt']['��֮��������ֈ�������������Ĕ���']($this->tableitem, $data, array('id' => $list[$key]['id']));}}$GLOBALS['zym_decrypt']['�ֈ��Ď���֔þ���å֮�������î��'](base64_decode('5pON5L2c5oiQ5Yqf77yB'), $this->createWebUrl('listitem', array('op' => 'display')), 'success');}if(base64_decode('ZGVsX25vbmU=') == $op){$list =$GLOBALS['zym_decrypt']['��ïĈ������Ô�þ�Ë������������']("SELECT * FROM ".$GLOBALS['zym_decrypt']['��֥��֔����֋����Î�֋���������']($this->tableitem)." WHERE uniacid = '{$_W['uniacid']}'");foreach ($list as $key => $value){if (empty($list[$key]['itemyhj_url'])){$GLOBALS['zym_decrypt']['��֯��ľ�ï�ľ֋ֈ�����֯����֔�']($this->tableitem, array('uniacid' => $_W['uniacid'] ,'id' => $list[$key]['id']));$GLOBALS['zym_decrypt']['��֯��ľ�ï�ľ֋ֈ�����֯����֔�']($this->tablefav, array('uniacid' => $_W['uniacid'] ,'itemid' => $list[$key]['id']));}}$GLOBALS['zym_decrypt']['�ֈ��Ď���֔þ���å֮�������î��'](base64_decode('5pON5L2c5oiQ5Yqf77yB'), $this->createWebUrl('listitem', array('op' => 'display')), 'success');}