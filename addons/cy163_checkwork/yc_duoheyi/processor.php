<?php
/**
 * 一键关注|一键拔号|一键生成引导关注H5模块处理程序
 *
 * @author flyerzsk
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');

class Yc_duoheyiModuleProcessor extends WeModuleProcessor {
	public function respond() {

        //这里定义此模块进行消息处理时的具体过程, 请查看微赞文档来编写你的代码

        global $_W;
        $rid = $this->rule;
		$lng=$this->module['config']['map']['lng'];
		$lat=$this->module['config']['map']['lat'];  	
        $url = $_W['siteroot'] . 'app/index.php?i=' . $_W['uniacid'] . "&c=entry&m=yc_duoheyi&do=lead&rid=".$rid;
        return $this->respNews(array(
            'Title' => $this->module['config']['name'],
            'Description' => $this->module['config']['description'],
            'PicUrl' => "http://api.map.baidu.com/staticimage?center=".$lng.",".$lat."&width=360&height=200&zoom=18&copyright=1&markers=".$lng.",".$lat,
            'Url' => $url
        ));
	}
    private function httpGet($url)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);
        curl_setopt($curl, CURLOPT_URL, $url);

        $res = curl_exec($curl);
        curl_close($curl);

        return $res;
    }
}