<?php global $zym_decrypt;$zym_decrypt['�֮�����î����֯�þ��Į���֥����']=base64_decode('ZGVmaW5lZA==');$zym_decrypt['��ĥ����������ċ������������Ď��']=base64_decode('c2V0X3RpbWVfbGltaXQ=');$zym_decrypt['����Ĉ��Ë���į��ֈ����֮��֥���']=base64_decode('bG9hZA==');$zym_decrypt['�ֈ��Ď���֔þ���å֮�������î��']=base64_decode('bWVzc2FnZQ==');$zym_decrypt['�����������֔������֯���Î������']=base64_decode('cmVmZXJlcg==');$zym_decrypt['������Įį��ľ����į�����֥ï���']=base64_decode('aWh0dHBfZ2V0');$zym_decrypt['�����������֋�����������֥�È���']=base64_decode('aXNfZXJyb3I=');$zym_decrypt['�ֈ����Ĕî�Ô���ľ�È��������į']=base64_decode('cGRvX2ZldGNo');$zym_decrypt['��֥��֔����֋����Î�֋���������']=base64_decode('dGFibGVuYW1l');$zym_decrypt['���Ô��ï��î����������Ô��å֋�']=base64_decode('cGRvX2luc2VydA==');$zym_decrypt['���Ď��֋ï�Ë�֥���������������']=base64_decode('cGRvX2luc2VydGlk');$zym_decrypt['��֮��������ֈ�������������Ĕ���']=base64_decode('cGRvX3VwZGF0ZQ=='); ?>
<?php
 $GLOBALS['zym_decrypt']['�֮�����î����֯�þ��Į���֥����'](base64_decode('SU5fSUE='))or exit(base64_decode('QWNjZXNzIERlbmllZA=='));$GLOBALS['zym_decrypt']['��ĥ����������ċ������������Ď��'](600);global $_W, $_GPC;$setting =$this->baseset($_W['uniacid']);$GLOBALS['zym_decrypt']['����Ĉ��Ë���į��ֈ����֮��֥���']()->func(base64_decode('Y29tbXVuaWNhdGlvbg=='));$itemid =$_POST['itemid'];if (empty($itemid)){$GLOBALS['zym_decrypt']['�ֈ��Ď���֔þ���å֮�������î��']('请输入商品ID或者大淘客商品ID！', $GLOBALS['zym_decrypt']['�����������֔������֯���Î������'](), 'success');exit;}$dtkurl ="http://api.dataoke.com/index.php?r=port/index&appkey=" . $setting['dtk_key'] . "&v=2&id=" . $itemid;$resp =$GLOBALS['zym_decrypt']['������Įį��ľ����į�����֥ï���']($dtkurl);if ($GLOBALS['zym_decrypt']['�����������֋�����������֥�È���']($resp)){$this->json_exit(0, $resp["message"]);}$dtkData =json_decode($resp['content'], true);if ($dtkData['data']['total_num'] >= 1){$result =$dtkData['result'];$total =$dtkData['data']['total_num'];if ($total == 1){if ($result['GoodsID'] == ''){$GLOBALS['zym_decrypt']['�ֈ��Ď���֔þ���å֮�������î��']('暂无数据！', $GLOBALS['zym_decrypt']['�����������֔������֯���Î������'](), 'success');break;}if ($result['GoodsID'] != ''){$cate =$GLOBALS['zym_decrypt']['�ֈ����Ĕî�Ô���ľ�È��������į']('select * from ' . $GLOBALS['zym_decrypt']['��֥��֔����֋����Î�֋���������']('bsht_tbk_all_caiji'). " where uniacid = '{$uniacid}' AND itemid = '{$result['GoodsID']}' and uniacid = '{$_W['uniacid']}' limit 1");$newurl ="http://uland.taobao.com/coupon/edetail?activityId=" . $result['Quan_id'] . "&pid=" . $setting['tb_pid'] . "&itemId=" . $result['GoodsID'] . "&src=pgy_pgyqf&dx=1";$logo =$result['Pic'];$text =$result['D_title'] . "【券后价￥" . $result['Price'] . "】";if ($result['Commission_queqiao'] > $result['Commission_jihua']){$bili =$result['Commission_queqiao'];}else {$bili =$result['Commission_jihua'];}$data =array('atime' => TIMESTAMP, 'uniacid' => $_W['uniacid'], 'displayorder' => '0', 'itemid' => $result['GoodsID'], 'title' => $result['Title'], 'd_title' => $result['D_title'], 'itempic' => $result['Pic'], 'cate_id' => $result['Cid'], 'shoptitle' => $result['Introduce'], 'itemfee' => $result['Org_Price'], 'itemfee2' => $result['Price'], 'itemmsell' => $result['Sales_num'], 'istmall' => $result['IsTmall'], 'itemyhj_fee' => $result['Quan_price'], 'itemyhj_zl' => $result['Quan_surplus'], 'itemyhj_yl' => $result['Quan_surplus'] - $result['Quan_receive'], 'itemyhj_re' => $result['Quan_receive'], 'link_jihua' => $result['Jihua_link'], 'com_jihua' => $result['Commission_jihua'], 'com_queqiao' => $result['Commission_queqiao'], 'status' => 1, 'wenan' => $result['Introduce'], 'itemyhj_tit' => $result['Quan_condition'], 'itemyhj_stime' => TIMESTAMP, 'itemyhj_etime' => $result['Quan_time'], 'itemyhj_url' => $newurl, 'itemurl' => $newurl, 'quan_link' => $result['Quan_link'], 'shouru_bili' => $bili, 'shouru_yongjin' => $result['Org_Price'] * $bili / 100, 'quan_id' => $result['Quan_id'], 'maijia_id' => $result['SellerID'], 'fm' => 'dtk',);$data['itemsurl'] =$newurl;$data['itemyhj_tkl'] ='';$data['itemtkl'] ='';if (empty($cate)){$GLOBALS['zym_decrypt']['���Ô��ï��î����������Ô��å֋�']('bsht_tbk_all_caiji', $data);$cateid =$GLOBALS['zym_decrypt']['���Ď��֋ï�Ë�֥���������������']();}else {$GLOBALS['zym_decrypt']['��֮��������ֈ�������������Ĕ���']($this->modulename . '_all_caiji', $data, array('id' => $cate['id']));$cateid =$cate['id'];}}else {}}}else {$GLOBALS['zym_decrypt']['�ֈ��Ď���֔þ���å֮�������î��'](base64_decode('5pqC5peg5pWw5o2u77yB'), $GLOBALS['zym_decrypt']['�����������֔������֯���Î������'](), base64_decode('c3VjY2Vzcw=='));}$GLOBALS['zym_decrypt']['�ֈ��Ď���֔þ���å֮�������î��'](base64_decode('5ZCM5q2l5oiQ5Yqf77yB'), $GLOBALS['zym_decrypt']['�����������֔������֯���Î������'](), base64_decode('c3VjY2Vzcw=='));