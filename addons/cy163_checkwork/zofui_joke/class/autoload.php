<?php 
	function foodAutoLoad($classname){
		$file = MODULE_ROOT.'class/'.$classname.'.class.php';
		if(file_exists($file)){
			require_once ($file);
		}
	}
	spl_autoload_register('foodAutoLoad');

	class Data {

		static function webMenu(){
			global $_W,$_GPC;
			if( function_exists( 'buildframes' ) ){
				$myframes = buildframes('account');
				$seturl = $myframes['section']['platform_module_common']['menu']['platform_module_settings']['url'];
			}
			if( empty( $seturl ) ) $seturl = $_W['siteroot'].'web/index.php?c=profile&a=module&do=setting&op=set&m='.MODULE;
			
		  	$menu = array(
		  		'setting' => array(
		  			'name' => '参数设置',
		  			'icon' => 'https://res.wx.qq.com/mpres/htmledition/images/icon/menu/icon_menu_setup.png',
		  			'list'=>array(
		  				array('op'=>'set','name'=>'参数设置','url'=>$seturl),
		  			),
		  			'toplist' => array()
		  		),
		  		'joke' => array(
		  			'name'=>'整蛊内容',
		  			'icon' => 'https://res.wx.qq.com/mpres/htmledition/images/icon/menu/icon_menu_management.png',
		  			'list'=>array(
		  				array('op'=>'add','name'=>'添加整蛊内容','url'=>Util::webUrl('joke',array('op'=>'add'))),
		  				array('op'=>'list','name'=>'整蛊内容列表','url'=>Util::webUrl('joke',array('op'=>'list'))),
		  			),
		  			'toplist' => array('add','list')
		  		),
		  	);
		  	$menu['explain'] = array(
		  		'name'=>'模块使用说明',
		  		'icon' => 'https://res.wx.qq.com/mpres/htmledition/images/icon/menu/icon_menu_ad.png',
		  		'url' => Util::webUrl('explain')
		  	);
		  	return $menu;
		}
		

	}


	class topbal
	{
		

		static function OrderList(){
			global $_W;

			return array(
				'sendtype' => array(
					array('value'=>'','name'=>'配送方式','url'=>WebCommon::logUrl('sendtype','')),
					array('value'=>1,'name'=>'快递发货','url'=>WebCommon::logUrl('sendtype','1')),
					array('value'=>2,'name'=>'上店自提','url'=>WebCommon::logUrl('sendtype','2'))
				),
				'groupstatus' => array(
					array('value'=>'','name'=>'团购状态','url'=>WebCommon::logUrl('groupstatus','')),
					array('value'=>1,'name'=>'组团中','url'=>WebCommon::logUrl('groupstatus','1')),
					array('value'=>2,'name'=>'已完成','url'=>WebCommon::logUrl('groupstatus','2')),
					array('value'=>3,'name'=>'已返款','url'=>WebCommon::logUrl('groupstatus','3')),
				),
				'search' => array(
					array(
						'do'=>'order',
						'op' => 'fororderid',
						'placeholder' => '输入订单编号'
					)
							
				)
			);
		}

		static function goodList(){
			global $_W;

			return array(
				'status' => array(
					array('value'=>'','name'=>'组团中','url'=>WebCommon::logUrl('status','')),
					array('value'=>1,'name'=>'组团完成','url'=>WebCommon::logUrl('status','1')),
					array('value'=>2,'name'=>'返款完成','url'=>WebCommon::logUrl('status','2'))
				)
			);
		}




	}
