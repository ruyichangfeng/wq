<?php

defined('IN_IA') or exit('Access Denied');

class Wg_salesModuleProcessor extends WeModuleProcessor {

    public function respond() {
        global $_W;
        $where['name'] = "kw_".$_W['uniacid'];
        $item = pdo_get('wg_sales_setting', $where, '*');
        if($item) {
            $value = json_decode($item['value'], true);
        }
        $content = array(
            array(
                'title'       => $value['title'],
                'description' => $value['description'],
                'picurl'      => $value['picurl'],
                'url'         => $value['url'],
            ),
        );
        return $this->respNews($content);
        //这里定义此模块进行消息处理时的具体过程, 请查看微擎文档来编写你的代码
    }

}
