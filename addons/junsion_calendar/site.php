<?php
/**
 * 专属日历模块微站定义
 *
 * @author junsion
 * @url http://s.we7.cc/index.php?c=store&a=author&uid=74516
 */
defined('IN_IA') or exit('Access Denied');
define('RES',"../addons/junsion_calendar/template/mobile/");
class Junsion_calendarModuleSite extends WeModuleSite {

	public function doMobileCover() {
		//这个操作被定义用来呈现 功能封面
		global $_W,$_GPC;
		$cfg = $this->module['config'];
		$nickname = $_W['fans']['nickname'];
		$avatar = $_W['fans']['tag']['avatar'];
		if (empty($nickname) || empty($avatar)){
			load()->model('mc');
			$fans = mc_oauth_userinfo();
			$nickname = $fans['nickname'];
			$avatar = $fans['avatar'];
		}		
		if (empty($nickname) || empty($avatar)){
			$nickname = "游客";
			$avatar = RES."img/name.png";
		}else{
			$avatar = $this->saveImage($avatar,$_W['openid']);
		}
		load()->func('communication');
		$res = ihttp_get('http://ip.taobao.com/service/getIpInfo.php?ip='.$_W['clientip']);
		$res = @json_decode($res['content'],true);
		$addr = $res['data'];
		$weather = file_get_contents("http://op.juhe.cn/onebox/weather/query?cityname={$addr['city']}&key=adc0ce4e9ba0ac19df0b59821dfac789");
		$weather = json_decode($weather,true);
		$weather = $weather['result']['data']['realtime']['weather'];
		$temperature = ($weather['temperature']-2)."℃~". ($weather['temperature']+2)."℃";
		$img = array(
			'00'=>'sun.png',
			'01'=>'sun_cloud.png',
			'02'=>'cloud.png',
			'03'=>'temp_rain.png',
			'04'=>'tsun_rain.png',
			'07'=>'s_rain.png',
			'08'=>'m_rain.png',
			'09'=>'b_rain.png',
			'10'=>'bb_rain.png',
			'0'=>'sun.png',
			'1'=>'sun_cloud.png',
			'2'=>'cloud.png',
			'3'=>'temp_rain.png',
			'4'=>'tsun_rain.png',
			'7'=>'s_rain.png',
			'8'=>'m_rain.png',
			'9'=>'b_rain.png',
		);
		$icon = $img[$weather['img']];
		if (empty($icon)){
			$icon = "sun.png";
		}
		$icon = toimage(RES."img/".$icon);
		$doneurl = $this->createMobileUrl('done');
		$words = explode("\n", $cfg['words']);
		foreach ($words as $key => $value) {
			if(empty($value)) unset($words[$key]);
		}
		include $this->template('index');
	}
	
	public function doMobileDone(){
		global $_W;
		@unlink("../attachment/images/calendaravatar".$_W['openid'].".jpg");
	}
	
	function saveImage($url,$tag = '') {
		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_CUSTOMREQUEST, 'GET' );
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt ( $ch, CURLOPT_URL, $url );
		ob_start ();
		curl_exec ( $ch );
		$return_content = ob_get_contents ();
		ob_end_clean ();
		$return_code = curl_getinfo ( $ch, CURLINFO_HTTP_CODE );
		$filename = "../attachment/images/calendaravatar{$tag}.jpg";
		$fp= @fopen($filename,"a"); //将文件绑定到流 
		fwrite($fp,$return_content); //写入文件
		return $filename;
	}

}