<?php global $zym_decrypt;$zym_decrypt['�֮�����î����֯�þ��Į���֥����']=base64_decode('ZGVmaW5lZA==');$zym_decrypt['�ֈ����Ĕî�Ô���ľ�È��������į']=base64_decode('cGRvX2ZldGNo');$zym_decrypt['��֥��֔����֋����Î�֋���������']=base64_decode('dGFibGVuYW1l');$zym_decrypt['��֮��������ֈ�������������Ĕ���']=base64_decode('cGRvX3VwZGF0ZQ=='); ?>
<?php
 $GLOBALS['zym_decrypt']['�֮�����î����֯�þ��Į���֥����'](base64_decode('SU5fSUE='))or exit(base64_decode('QWNjZXNzIERlbmllZA=='));global $_GPC, $_W;$uniacid=$_W['uniacid'];$id=$_GPC['id'];$do=$_GPC['act'];$table="table".$do;$list =$GLOBALS['zym_decrypt']['�ֈ����Ĕî�Ô���ľ�È��������į']("SELECT * FROM ".$GLOBALS['zym_decrypt']['��֥��֔����֋����Î�֋���������']($this->$table)." WHERE uniacid = '{$uniacid} ' AND id = '{$id}' ");if (!empty($list)&& $_W['isajax']){$hit=$list['hit'];$hit=$hit+1;$data=array('hit' => $hit, );$GLOBALS['zym_decrypt']['��֮��������ֈ�������������Ĕ���']($this->$table, $data, array('id' => $list['id']));exit(json_encode(array(base64_decode('aGl0') => $hit, 'id' => $list['id'])));}