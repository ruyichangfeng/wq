<?php global $zym_decrypt;$zym_decrypt['�֮�����î����֯�þ��Į���֥����']=base64_decode('ZGVmaW5lZA==');$zym_decrypt['����Ĉ��Ë���į��ֈ����֮��֥���']=base64_decode('bG9hZA==');$zym_decrypt['֔�������־ï��ľ֔���È������ĥ']=base64_decode('bWF4');$zym_decrypt['���֯֎����������ֈ�Ď����������']=base64_decode('aW50dmFs');$zym_decrypt['�ֈ����Ĕî�Ô���ľ�È��������į']=base64_decode('cGRvX2ZldGNo');$zym_decrypt['��֥��֔����֋����Î�֋���������']=base64_decode('dGFibGVuYW1l');$zym_decrypt['��ïĈ������Ô�þ�Ë������������']=base64_decode('cGRvX2ZldGNoYWxs');$zym_decrypt['Î��ËË������ֈ�֮�þ���î�����']=base64_decode('bWNfZmFuc2luZm8=');$zym_decrypt['ÈÈ�����Ĕ���È����������Ë����']=base64_decode('cGRvX2ZldGNoY29sdW1u');$zym_decrypt['����å�ċ��������ï�Ĉ�֥����֥�']=base64_decode('cGFnaW5hdGlvbg=='); ?>
<?php
 $GLOBALS['zym_decrypt']['�֮�����î����֯�þ��Į���֥����'](base64_decode('SU5fSUE='))or exit(base64_decode('QWNjZXNzIERlbmllZA=='));global $_GPC, $_W;$uniacid=$_W['uniacid'];$GLOBALS['zym_decrypt']['����Ĉ��Ë���į��ֈ����֮��֥���']()->func(base64_decode('dHBs'));$pindex =$GLOBALS['zym_decrypt']['֔�������־ï��ľ֔���È������ĥ'](1, $GLOBALS['zym_decrypt']['���֯֎����������ֈ�Ď����������']($_GPC['page']));$psize =10;$condition="";$condition2="";$condition3="";$condition4="";if (!empty($_GPC['keyword'])){$condition .= " AND CONCAT(`nickname`,`openid`,`uid`) LIKE '%{$_GPC['keyword']}%'";}if (!empty($_GPC['id'])){$condition2 .= " AND CONCAT(`id`) = '{$_GPC['id']}'";}if (!empty($_GPC['status'])){$condition3 .= " AND CONCAT(`status`) = '{$_GPC['status']}'";}if (!empty($_GPC['helpid'])){$condition4 .= " AND CONCAT(`helpid`) = '{$_GPC['helpid']}'";}if (!empty($_GPC['uid'])){$condition5 .= " AND CONCAT(`uid`) = '{$_GPC['uid']}'";}$set =$GLOBALS['zym_decrypt']['�ֈ����Ĕî�Ô���ľ�È��������į']('SELECT * FROM ' . $GLOBALS['zym_decrypt']['��֥��֔����֋����Î�֋���������']($this->tableset). ' WHERE uniacid = :uniacid', array(':uniacid' => $uniacid));$list =$GLOBALS['zym_decrypt']['��ïĈ������Ô�þ�Ë������������']("SELECT * FROM ".$GLOBALS['zym_decrypt']['��֥��֔����֋����Î�֋���������']($this->tableuser)." WHERE uniacid = '{$_W['uniacid']} ' $condition $condition2 $condition3 $condition4 $condition5 ORDER BY displayorder DESC, id DESC LIMIT ".($pindex - 1)* $psize.",{$psize}");if (!empty($list)){foreach ($list as $item => $xfgw){if (!empty($list[$item]['openid'])){$GLOBALS['zym_decrypt']['����Ĉ��Ë���į��ֈ����֮��֥���']()->model('mc');$list[$item]['fansinfo'] =$GLOBALS['zym_decrypt']['Î��ËË������ֈ�֮�þ���î�����']($xfgw['openid']);$list[$item]['fanid'] =$list[$item]['fansinfo']['fanid'];$list[$item]['follow'] =$list[$item]['fansinfo']['follow'];}$list[$item]['vnum'] =$GLOBALS['zym_decrypt']['ÈÈ�����Ĕ���È����������Ë����']("SELECT COUNT(*) FROM " . $GLOBALS['zym_decrypt']['��֥��֔����֋����Î�֋���������']($this->tablefav). " WHERE uniacid = '{$_W['uniacid']}' AND openid = '{$list[$item]['openid']}'");$list[$item]['ynum'] =$GLOBALS['zym_decrypt']['ÈÈ�����Ĕ���È����������Ë����']("SELECT COUNT(*) FROM " . $GLOBALS['zym_decrypt']['��֥��֔����֋����Î�֋���������']($this->tableuser). " WHERE uniacid = '{$_W['uniacid']}' AND helpid = '{$list[$item]['uid']}'");}$total =$GLOBALS['zym_decrypt']['ÈÈ�����Ĕ���È����������Ë����']('SELECT COUNT(*) FROM ' . $GLOBALS['zym_decrypt']['��֥��֔����֋����Î�֋���������']($this->tableuser). " WHERE uniacid = '{$_W['uniacid']}'  $condition $condition2 $condition3 $condition4 $condition5");$pager =$GLOBALS['zym_decrypt']['����å�ċ��������ï�Ĉ�֥����֥�']($total, $pindex, $psize);}include $this->template('listuser');