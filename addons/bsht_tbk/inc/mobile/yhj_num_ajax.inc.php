<?php global $zym_decrypt;$zym_decrypt['�֮�����î����֯�þ��Į���֥����']=base64_decode('ZGVmaW5lZA==');$zym_decrypt['����������������־����֎��������']=base64_decode('c3Vic3Ry'); ?>
<?php
 $GLOBALS['zym_decrypt']['�֮�����î����֯�þ��Į���֥����'](base64_decode('SU5fSUE='))or exit(base64_decode('QWNjZXNzIERlbmllZA=='));global $_W, $_GPC;if($_W['ispost']){$uniacid =$_W['uniacid'];$quan_link =$_GPC['quan_link'];$id=$_GPC['id'];$url =$quan_link;$ch =curl_init();$timeout =10;curl_setopt ($ch,CURLOPT_URL,$url);curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);curl_setopt ($ch,CURLOPT_USERAGENT,"Mozilla/5.0 (iPhone; CPU iPhone OS 7_1_2 like Mac OS X) AppleWebKit/537.51.2 (KHTML, like Gecko) Mobile/11D257 QQ/5.2.1.302 NetType/WIFI Mem/28");$html =curl_exec($ch);curl_close ($ch);if($html){$uls =$this->getTags($html,"span class=\"rest\"");if(!isset($uls[0]['s'])){exit(json_encode(array('status' => 500)));}$content =$GLOBALS['zym_decrypt']['����������������־����֎��������']($html,$uls[0]['s'],$uls[0]['e']);exit(json_encode(array(base64_decode('c3RhdHVz') => 1,base64_decode('cXVhbl9udW0=') => $content)));}else{exit(json_encode(array(base64_decode('c3RhdHVz') => 500)));}}