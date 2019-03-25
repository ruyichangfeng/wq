<?php
/**
 * 专属日历模块定义
 *
 * @author junsion
 * @url http://s.we7.cc/index.php?c=store&a=author&uid=74516
 */
defined('IN_IA') or exit('Access Denied');

class Junsion_calendarModule extends WeModule {

	public function settingsDisplay($settings) {
		global $_W, $_GPC;
		//点击模块设置时将调用此方法呈现模块设置页面，$settings 为模块设置参数, 结构为数组。这个参数系统针对不同公众账号独立保存。
		//在此呈现页面中自行处理post请求并保存设置参数（通过使用$this->saveSettings()来实现）
		if(checksubmit()) {
			//字段验证, 并获得正确的数据$dat
			$dat = array('logo'=>$_GPC['logo'],'title'=>$_GPC['title'],'words'=>$_GPC['words'],'adv'=>$_GPC['adv'],'bgsong'=>$_GPC['bgsong'],'pics'=>$_GPC['pics'],'qr'=>$_GPC['qr'],'stitle'=>$_GPC['stitle'],'sthumb'=>$_GPC['sthumb'],'sdesc'=>$_GPC['sdesc']);
			$this->saveSettings($dat);
			message('保存成功！','refresh');
		}
		if (empty($settings)){
			$url = "../addons/junsion_calendar/template/mobile/img/";
			$settings['title'] = "生成你的专属日历";
			$settings['logo'] = $url."logo.png";
			$settings['qr'] = $url."qr.png";
			$settings['adv'] = $url."adv.png";
			$settings['bgsong'] = $url."bgm.mp3";
			$settings['pics'] = array($url.'page2-pic1.png',$url.'page2-pic2.png',$url.'page2-pic3.png');
			$settings['sthumb'] = $url."logo.png";
			$settings['stitle'] = '日历生成器—快来生成自己的专属日历！';
			$settings['sdesc'] = '记录生活是一种快乐，快来生成你的专属日历吧！';
			$settings['sthumb'] = $url."logo.png";
			$settings['words'] = "初秋的每一天都是蓝色的，我们头顶着美丽干净的天空。\n每个独立而丰富的灵魂，都有处可栖。\n生活不可能像你想象得那么好，但也不会像你想象得那么糟。\n不跟你计较不是原谅你的意思，望周知。\n仅活着是不够的，还需要有阳光、自由，和一点花的芬芳。";
		}
		//这里来展示设置项表单
		include $this->template('setting');
	}

}