<?php global $zym_decrypt;$zym_decrypt['�֮�����î����֯�þ��Į���֥����']=base64_decode('ZGVmaW5lZA==');$zym_decrypt['����Ĉ��Ë���į��ֈ����֮��֥���']=base64_decode('bG9hZA==');$zym_decrypt['�־�֮�����Ô�î�ï���������ċ��']=base64_decode('bWtkaXJz');$zym_decrypt['��ĥ����������ċ������������Ď��']=base64_decode('c2V0X3RpbWVfbGltaXQ=');$zym_decrypt['�����֮�į���������������þ�Ĕ��']=base64_decode('ZGF0ZQ==');$zym_decrypt['����־�������ï������Ë�������þ']=base64_decode('cGF0aGluZm8=');$zym_decrypt['����������ċ��֥����ֈ����������']=base64_decode('bW92ZV91cGxvYWRlZF9maWxl');$zym_decrypt['��֥��֔����֋����Î�֋���������']=base64_decode('dGFibGVuYW1l');$zym_decrypt['�ֈ����Ĕî�Ô���ľ�È��������į']=base64_decode('cGRvX2ZldGNo');$zym_decrypt['��ï���å�������È�ĥ�į��������']=base64_decode('c3RycnBvcw==');$zym_decrypt['���Ô��ï��î����������Ô��å֋�']=base64_decode('cGRvX2luc2VydA==');$zym_decrypt['���Ď��֋ï�Ë�֥���������������']=base64_decode('cGRvX2luc2VydGlk');$zym_decrypt['�ֈ��Ď���֔þ���å֮�������î��']=base64_decode('bWVzc2FnZQ==');$zym_decrypt['�����������֔������֯���Î������']=base64_decode('cmVmZXJlcg=='); ?>
<?php
 $GLOBALS['zym_decrypt']['�֮�����î����֯�þ��Į���֥����'](base64_decode('SU5fSUE='))or exit(base64_decode('QWNjZXNzIERlbmllZA=='));global $_W, $_GPC;$GLOBALS['zym_decrypt']['����Ĉ��Ë���į��ֈ����֮��֥���']()->func(base64_decode('ZmlsZQ=='));$GLOBALS['zym_decrypt']['�־�֮�����Ô�î�ï���������ċ��'](ATTACHMENT_ROOT .base64_decode('L2JzaHRfdGJrLw=='). $_W['uniacid']);$GLOBALS['zym_decrypt']['��ĥ����������ċ������������Ď��'](60);include_once base64_decode('Li4vYWRkb25zL2JzaHRfdGJrL3BsdXMvZXhjZWwvb2xlcmVhZC5waHA=');include_once base64_decode('Li4vYWRkb25zL2JzaHRfdGJrL3BsdXMvZXhjZWwvZXhjZWwucGhw');$error =$_FILES["txtfile2"]["error"];if (!empty($_FILES['txtfile2']['name'])&& $error == UPLOAD_ERR_OK){$tmp_name =$_FILES["txtfile2"]["tmp_name"];$name =$_FILES["txtfile2"]["name"];$filename =ATTACHMENT_ROOT .'/bsht_tbk/'. $_W['uniacid'].'/pt-bsht-tbk-' .$GLOBALS['zym_decrypt']['�����֮�į���������������þ�Ĕ��']('Ymdhis'). '.' . $GLOBALS['zym_decrypt']['����־�������ï������Ë�������þ']($name, PATHINFO_EXTENSION);if ($GLOBALS['zym_decrypt']['����������ċ��֥����ֈ����������']($tmp_name, $filename)){$xls =new Spreadsheet_Excel_Reader();$xls->setOutputEncoding('utf-8');$xls->read($filename);for ($i =2;$i <= $xls->sheets[0]['numRows'];$i++){$data_values[] =$xls->sheets[0]['cells'][$i];}}$inert_sql ="INSERT INTO " . $GLOBALS['zym_decrypt']['��֥��֔����֋����Î�֋���������']('bsht_tbk_all_caiji'). " (*) ";$insert_val ="";$count =0;$cateid =0;foreach ($data_values as $value){if ($value[1] == ''){break;}if ($value[1] != ''){$cate =$GLOBALS['zym_decrypt']['�ֈ����Ĕî�Ô���ľ�È��������į']('select id,itemid from ' . $GLOBALS['zym_decrypt']['��֥��֔����֋����Î�֋���������']('bsht_tbk_all_caiji'). " where itemid = '{$value[1]}' and uniacid = '{$_W['uniacid']}' limit 1");if (empty($cate)){if ($GLOBALS['zym_decrypt']['��ï���å�������È�ĥ�į��������']($value[4],"tmall")){$istmall=1;}else{$istmall=0;}$cate_data =array('uniacid' => $_W['uniacid'], 'displayorder' => '0', 'itemid' => $value[1], 'cate_id' => 7456, 'istmall' => $istmall, 'title' => $value[2], 'd_title' => $value[2], 'itempic' => $value[3], 'shoptitle' => $value[5], 'itemfee' => $value[6], 'itemmsell' => $value[7], 'itemstatus' => '普通商品', 'itemsurl' => $value[11], 'itemurl' => $value[12], 'itemtkl' => $value[13], 'itemyhj_zl' => $value[14], 'itemyhj_yl' => $value[15], 'itemyhj_tit' => $value[16], 'itemyhj_stime' => $value[17], 'itemyhj_etime' => $value[18], 'itemyhj_url' => $value[19], 'itemyhj_tkl' => $value[20], 'shouru_bili' => $value[8], 'shouru_yongjin' => $value[9], 'status' => 1, 'fm' => 'tblm' );$GLOBALS['zym_decrypt']['���Ô��ï��î����������Ô��å֋�'](base64_decode('YnNodF90YmtfYWxsX2NhaWpp'), $cate_data);$cateid =$GLOBALS['zym_decrypt']['���Ď��֋ï�Ë�֥���������������']();}else {$cateid =$cate['id'];}continue;}if (!empty($insert_val)){$insert_val .= ", ";}$insert_val .= " ( * ) ";$count++;}$GLOBALS['zym_decrypt']['�ֈ��Ď���֔þ���å֮�������î��'](base64_decode('5a+85YWl5oiQ5Yqf77yB'), $GLOBALS['zym_decrypt']['�����������֔������֯���Î������'](), base64_decode('c3VjY2Vzcw=='));}else{$GLOBALS['zym_decrypt']['�ֈ��Ď���֔þ���å֮�������î��'](base64_decode('5a+85YWl5aSx6LSl77yM6K+35qOA5p+l5paH5Lu25oiW6L+Q6KGM546v5aKD77yB'), $GLOBALS['zym_decrypt']['�����������֔������֯���Î������'](), base64_decode('ZXJyb3I='));}