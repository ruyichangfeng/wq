<?php global $zym_decrypt;$zym_decrypt['�֮�����î����֯�þ��Į���֥����']=base64_decode('ZGVmaW5lZA==');$zym_decrypt['����Ĉ��Ë���į��ֈ����֮��֥���']=base64_decode('bG9hZA==');$zym_decrypt['�ֈ����Ĕî�Ô���ľ�È��������į']=base64_decode('cGRvX2ZldGNo');$zym_decrypt['��֥��֔����֋����Î�֋���������']=base64_decode('dGFibGVuYW1l');$zym_decrypt['Î��ËË������ֈ�֮�þ���î�����']=base64_decode('bWNfZmFuc2luZm8=');$zym_decrypt['���È��Î�֯��������֥�֔È���֔']=base64_decode('cHJlZ19yZXBsYWNl');$zym_decrypt['����֥��å���������֋�����������']=base64_decode('Y2hlY2tzdWJtaXQ=');$zym_decrypt['����î�����ֈ���î�å������֋���']=base64_decode('dHJpbQ==');$zym_decrypt['����������Ë������������������Î']=base64_decode('c3RydG90aW1l');$zym_decrypt['���Ô��ï��î����������Ô��å֋�']=base64_decode('cGRvX2luc2VydA==');$zym_decrypt['��֮��������ֈ�������������Ĕ���']=base64_decode('cGRvX3VwZGF0ZQ==');$zym_decrypt['�ֈ��Ď���֔þ���å֮�������î��']=base64_decode('bWVzc2FnZQ=='); ?>
<?php
 $GLOBALS['zym_decrypt']['�֮�����î����֯�þ��Į���֥����'](base64_decode('SU5fSUE='))or exit(base64_decode('QWNjZXNzIERlbmllZA=='));global $_GPC, $_W;$uniacid=$_W['uniacid'];$id=$_GPC['id'];$op=$_GPC['op'];if(empty($op)){$op=='add';}$GLOBALS['zym_decrypt']['����Ĉ��Ë���į��ֈ����֮��֥���']()->func(base64_decode('dHBs'));$set =$GLOBALS['zym_decrypt']['�ֈ����Ĕî�Ô���ľ�È��������į']('SELECT * FROM ' . $GLOBALS['zym_decrypt']['��֥��֔����֋����Î�֋���������']($this->tableuser). ' WHERE uniacid = :uniacid AND id = :id', array(':uniacid' => $uniacid,':id' => $id));if (!empty($set['openid'])){$GLOBALS['zym_decrypt']['����Ĉ��Ë���į��ֈ����֮��֥���']()->model('mc');$mcinfo =$GLOBALS['zym_decrypt']['Î��ËË������ֈ�֮�þ���î�����']($set['openid']);$avatar =$mcinfo['avatar'];$nickname =$mcinfo['nickname'];$nickname =json_encode($nickname);$nickname =$GLOBALS['zym_decrypt']['���È��Î�֯��������֥�֔È���֔']("#(\\\u[ed][0-9a-f]{3})#ie","",$nickname);$nickname =json_decode($nickname);}if($GLOBALS['zym_decrypt']['����֥��å���������֋�����������'](base64_decode('c3VibWl0'))){$data=array('uniacid' => $uniacid, 'status'=>$GLOBALS['zym_decrypt']['����î�����ֈ���î�å������֋���']($_GPC['status']), 'helpid'=>$GLOBALS['zym_decrypt']['����î�����ֈ���î�å������֋���']($_GPC['helpid']), 'openid'=>$GLOBALS['zym_decrypt']['����î�����ֈ���î�å������֋���']($_GPC['openid']), 'nickname'=>$GLOBALS['zym_decrypt']['����î�����ֈ���î�å������֋���']($_GPC['nickname']), 'avatar'=>$GLOBALS['zym_decrypt']['����î�����ֈ���î�å������֋���']($_GPC['avatar']), 'displayorder'=>$GLOBALS['zym_decrypt']['����î�����ֈ���î�å������֋���']($_GPC['displayorder']), 'ctime'=>$GLOBALS['zym_decrypt']['����������Ë������������������Î']($_GPC['ctime']), 'vtime'=>$GLOBALS['zym_decrypt']['����������Ë������������������Î']($_GPC['vtime']), );if($op=='add' && empty($set)){$GLOBALS['zym_decrypt']['���Ô��ï��î����������Ô��å֋�']($this->tableuser, $data);}if($op=='edit' && !empty($set)){$GLOBALS['zym_decrypt']['��֮��������ֈ�������������Ĕ���']($this->tableuser, $data, array('id' => $set['id']));}$GLOBALS['zym_decrypt']['�ֈ��Ď���֔þ���å֮�������î��'](base64_decode('5pWw5o2u5pON5L2c5oiQ5Yqf77yB'), base64_decode('cmVmcmVzaA=='));}if($op!='del'){include $this->template('listuser_add');}