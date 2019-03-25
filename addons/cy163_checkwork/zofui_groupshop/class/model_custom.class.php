<?php 


class model_custom
{
	// 查询单条页面 后台
	static function getSinglePage($id){
		$id = intval($id);
		$page = Util::getDataByCacheFirst('custompage',$id,array('Util','getSingelDataInSingleTable'),array('zofui_groupshop_custom',array('id'=>$id)));

		$page['params'] = json_encode(iunserializer($page['params']));
		$page['basicparams'] = json_encode(iunserializer($page['basicparams']));		
		return $page;  //需删除缓存
	}
	
	// 查询单条页面
	static function getPage($id){
		$id = intval($id);
		$page = Util::getDataByCacheFirst('custompage',$id,array('Util','getSingelDataInSingleTable'),array('zofui_groupshop_custom',array('id'=>$id)));
		
		$page['params'] = self::decodePage( $page );
		$page['basicparams'] = json_encode(iunserializer($page['basicparams']));		
		return $page;  //需删除缓存
	}


	//查询首页模块
	static function getIndexPage(){
		global $_W;
		$page = Util::getDataByCacheFirst('custompage','index',array('Util','getSingelDataInSingleTable'),array('zofui_groupshop_custom',array('uniacid'=>$_W['uniacid'],'status'=>0)));
		//$page['params'] = json_encode(iunserializer($page['params']));

		$page['params'] = self::decodePage( $page );

		$page['basicparams'] = json_encode(iunserializer($page['basicparams']));		
		return $page;  //需删除缓存
	}	
	
	
	//编译模板
	static function decodePage($page){
		$data = $page;
		if(is_serialized($data['params'])) $data['params'] = iunserializer($data['params']);
		$str = '';
		foreach($data['params'] as $k => $v){
			$funname = 'decode'.$v['temp'];
			if(method_exists('model_custom',$funname)) $str .= self::$funname($v);
		}
		
		//var_dump($data['params']);
		return $str;
	}
	
	//搜索框
	static function decodesearch($v){
		global $_W;
		$url = Util::createModuleUrl('sort',array('op'=>'sort'));
		$str = <<<div
			<div class="app-mod app-mod-4 weui_search_bar" id="search_bar" style="background-color:{$v['params']['bgcolor']};padding:{$v['params']['padding']}px 5px">
				<form action="{$url}" method="get"  class="weui_search_outer item_cell_box" style="background-color:{$v['params']['bgcolor']}">
					<input type="hidden" name='i' value='{$_W['uniacid']}'/>
					<input type="hidden" name='c' value='entry'/>
					<input type="hidden" name='m' value='zofui_groupshop'/>
			        <input type="hidden" name='do' value='sort'/>
					<input type="hidden" name='op' value='detail'/>
					<div class="weui_search_inner item_cell_flex" style="border-radius:{$v['params']['border']}px}">
						<i class="weui_icon_search"></i>
						<input type="search" name="for" class="weui_search_input" id="search_input" placeholder="{$v['params']['placeholder']}" required/>
						<a href="javascript:" class="weui_icon_clear" id="search_clear"></a>
					</div>
					<div href="javascript:" class="toggle_search" style="color:{$v['params']['color']};background-color:{$v['params']['bgcolor']}"> 
						<input type="submit" value="搜索"/>
					</div>
				</form>
			</div>
div;
		return $str;
	}
	
	
	//幻灯片
	static function decodesolid1($v){
		global $_W;
		$url = Util::createModuleUrl('sort',array('op'=>'sort'));
		$img = '';
		foreach($v['data'] as $k=>$vv){
			$img .= '<div class="swiper-slide"><a href="'.$vv['hrefurl'].'"><img src="'.$vv['imgurl'].'" alt=""></a></div>';
		}
		$str = <<<div
			<div class="app-mod app-mod-2" >
				  <div class="swiper-container" data-space-between='50'>
					<div class="swiper-wrapper">
						{$img}
					</div>
					<div class="swiper-pagination" class="{$v['params']['shape']}" data-size="{$v['params']['btnsize']}" data-color="{$v['params']['color']}"  style="text-align:{$v['params']['align']};color:{$v['params']['color']};"></div>
				  </div>
			</div>
div;
		return $str;
	}


	//公告
	static function decodenotice($v){
		global $_W;
		$class = $v['params']['shownum'] == 1 ? 'app_notice_single' : 'app_notice_double';
		
		foreach($v['data'] as $k=>$vv){
			$font .= '<li style="border-bottom:1px solid '.$v['params']['bottomcolor'].'"><a href="'.$vv['url'].'">'.$vv['title'].'</a></li>';
		}
		
		$str = <<<div
			<div class="app-mod app-mod-1" style="color:{$v['params']['color']};background-color:{$v['params']['bgcolor']};padding:{$v['params']['padding']}px 0px">
				<div class="item_cell_box app_notice {$class}">
					<div class="app_notice_images">
						<img data-lazy="{$v['params']['imgurl']}" />
					</div>
					<div class="item_cell_flex app_notice_font">
						<ul class="scroll_elemt" data-line="{$v['params']['shownum']}" data-timer="{$v['params']['timer']}">
							{$font}
						</ul>
					</div>
				</div>
			</div>
div;
		return $str;
	}

	//标题
	static function decodetitle($v){
		global $_W;
		$title2 = '';
		if($v['params']['showtitle2'] == 1) 
			$title2 = '<h4 style="font-size:'.$v['params']['fontsize2'].'px">'.$v['params']['title2'].'</h4>';
		$img = '';
		if($v['params']['incoshow'] == 1)
			$img  = '<img data-lazy="'.$v['params']['inco'].'" style="height:'.$v['params']['incoheight'].'px">';
			
		$str = <<<div
			<div class="app-mod app-mod-3" style="text-align:{$v['params']['align']};color:{$v['params']['color']};background-color: {$v['params']['bgcolor']};padding:{$v['params']['paddingsize']}px 10px">
				<a href="{$v['params']['titlehref']}">
				<div style="white-space:nowrap;display:inline-flex;">
					{$img}
					<span style="font-size:{$v['params']['fontsize1']}px ;line-height:{$v['params']['incoheight']}px">{$v['params']['title1']}</span>
				</div>
				{$title2}
				</a>
			</div>
div;
		return $str;
	}	
	
	//辅助空白
	static function decodeblank($v){
		global $_W;
		$str = <<<div
			<div class="fe-mod fe-mod-6" style="height:{$v['params']['height']}px;background-color:{$v['params']['bgcolor']}"></div>
div;
		return $str;
	}		
	
	
	//导航
	static function decodemenu($v){
		global $_W;
		$class1 = $v['params']['num'] == '28%' ? 'menu-nowrap': '';
		
		foreach($v['data'] as $k=>$vv){
			if($k >= 4 && $v['params']['num'] == '25%') break;
			
			$font1 = '';
			if($v['params']['position'] == 2)
				$font1 = '<div class="app-mod-12-text app-mod-12-font-style2" style="color:'.$v['params']['color'].';font-size:'.$v['params']['fontsize'].'">'.$vv['text'].'</div>';
		
			$font2 = '';
			if($v['params']['position'] == 1)
				$font2 = '<div class="app-mod-12-text app-mod-12-text" style="color:'.$v['params']['color'].';font-size:'.$v['params']['fontsize'].'">'.$vv['text'].'</div>';
				
			$div .= <<<div
				<a href="{$vv['hrefurl']}">
					<div class="app-mod-12-nav" style="width:{$v['params']['num']};float:{$v['params']['menuImgFloat']}">
						<div class="app-mod-12-img" style="padding:{$v['params']['space']}px">
							<img src="{$vv['imgurl']}" style="border-radius:{$v['params']['style']}px" />
							{$font1}
						</div>
						{$font2}
					</div>
				</a>
div;
		
		}
		
		$str = <<<div
			<div class="app-mod app-mod-12 {$class1}" style="background-color:{$v['params']['bgcolor']};padding:{$v['params']['padding']}px 0">
				{$div}
			</div>
div;
		return $str;
	}
	
	
	//富文本
	static function decoderichtext1($v){
		global $_W;
		$str = <<<div
			<div class="app-mod app-mod-7"  style="background-color:{$v['params']['bgcolor']}">
				<div>{$v['content']}</div>
			</div>
			
div;
		return $str;
	}
	
	
	//链接
	static function decodelink($v){
		global $_W;
		$num = count($v['data']);
		foreach($v['data'] as $k=>$vv){
			$nodorder = '';
			if($k+1 == $num) $nodorder = 'nodorder';
			$img = '';
			if(!empty($vv['imgurl'])) $img = '<p class="app-mod-link-lefimg"><img src="'.$vv['imgurl'].'"></p>'; 
			
			$div .= <<<div
				<div style="border-bottom: 1px {$v['params']['line']} {$v['params']['linecolor']}" class="{$nodorder}">
					<a href="{$vv['href']}">
						<div class="app-mod-link-item" style="color:{$v['params']['fontcolor']};padding:{$v['params']['padding']}px 0px;">
							<div class="app-mod-link-item-left item_cell_box" >
								{$img}
								<p class="item_cell_item">{$vv['titleleft']}</p>
							</div>
							<div class="app-mod-link-item-right pull-right"><span>{$vv['titleright']}</span> <span class="ti-angle-right" style="font-size:12px"></span></div>
						</div>
					</a>
				</div>
div;
		}
		
		$str = <<<div
			<div class="app-mod app-mod-link"  style="background-color:{$v['params']['bgcolor']};padding:0px 10px;">
				{$div}
			</div>
div;
		return $str;
	}	
	
	//辅助线
	static function decodeline($v){
		global $_W;
		$str = <<<div
			<div class="app-mod app-mod-5" style="background:{$v['params']['bgcolor']}">
				<div class="app-mod-5-line" style="border-top-width:{$v['params']['height']}px;border-top-style:{$v['params']['style']};border-top-color:{$v['params']['color']};margin:{$v['params']['padding']}px 0px"></div>
			</div>
div;
		return $str;
	}		
	
	//图片组
	static function decodecube($v){
		global $_W;	

		$tr = '';
		foreach($v['params']['layout'] as $kk=>$vv){
			
			$td = '';
			foreach ($vv as $kkk => $vvv) {

				$class = $vvv['isempty'] ? 'empty' : 'not-empty';

				$ifstr = '';
				if( !$vvv['isempty'] && $vvv['imgurl'] ){

					$url = empty( $vvv['url'] ) ? 'javascript:;' : $vvv['url'];

					$ifstr = <<<div
	                    <div>
							<a href="{$url}">
								<img src="{$vvv['imgurl']}" animate-speed="0.5s" animate-visible="true" style="width:100%;height:100%;"  style="border-top':{$vvv['topborder']} 1px {$vvv['bordercolor']},border-right:{$vvv['rightborder']} 1px {$vvv['bordercolor']},border-bottom:{$vvv['bottomborder']} 1px {$vvv['bordercolor']},border-left:{$vvv['leftborder']} 1px {$vvv['bordercolor']}" />
							</a>
						</div>
div;
				}

				$td .= <<<div
	                <td class="{$vvv['classname']} {$class} rows-{$vvv['rows']} cols-{$vvv['cols']}" 
	                    rowspan="{$vvv['rows']}" 
	                    colspan="{$vvv['cols']}">
	                    {$ifstr}
	                </td>
div;
			}
			
			$tr .= <<<div
	            <tr >{$td}</tr> 
div;
		}
		
		$str = <<<div
		<div class="app-mod app-mod-cube" style="background-color:{$v['params']['bgcolor']}">
		    <div class="inner">
		        <table>
		        	{$tr}
		        </table>
		    </div>
		</div>
div;
		return $str;
	}
	
	//卡券
	static function decodecard($v){
		global $_W;
		foreach($v['data'] as $k=>$vv){
			$fullmoney = $vv['fullmoney'] * 100/100;
			$cardvalue = $vv['cardvalue'] * 100/10;
			
			if($vv['cardtype'] == 1){
				$cardvalue = $vv['cardvalue'] * 100/100;
				$cardstr = '<p style="'.$v['params']['topleftcolor'].'"><span class="app-card-value-inco">￥</span><span class="app-card-value-num">'.$cardvalue.'</span></p>';
			}elseif($vv['cardtype'] == 2){
				$cardvalue = $vv['cardvalue'] * 100/10;
				$cardstr = '<p style="color:'.$v['params']['topleftcolor'].'"><span class="app-card-value-num">'.$cardvalue.'</span><span class="app-card-value-inco">折</span></p>';				
			}
			
			$div .= <<<div
				<div class="app-card"  data-id="{$vv['cardid']}" data-credit="{$vv['needcredit']}">
					<span class="arrow_up card_cut_up"></span>
					<span class="arrow_up card_cut_down"></span>
					<li class="app-card-value item_cell_box" style="background:{$v['params']['topbgcolor']}">
						{$cardstr}
						<p class="item_cell_flex app-card-condition"  style="color:{$v['params']['toprightcolor']}">满{$fullmoney}可使用</p>
					</li>
					<li class="app-card-bottom"  style="background:{$v['params']['botbgcolor']};color:{$v['params']['botcolor']}">
						<p>{$vv['cardname']}</p>
					</li>
				</div>
div;
		}		
		
		$str = <<<div
			<div class="app-card-box" style="background:{$v['params']['bgcolor']},padding:{$v['params']['padding']}px 0">
				{$div}
			</div>
div;
		return $str;
	}
	
	//幻灯片
	static function decodetime($v){
		global $_W;
		$time = strtotime($v['params']['time']);
		$str = <<<div
			<div class="app-mod app-mod-3 app-time" style="background:{$v['params']['bgcolor']};padding:{$v['params']['padding']}px 10px">
				<div class="app_time_box">
					<div class="app_time_left">
						<span style="font-size:{$v['params']['fontsize1']}px;color:{$v['params']['fontcolor']}">{$v['params']['title1']}</span>
					</div>
					<div class="app_time_right" style="font-size:{$v['params']['fontsize2']}px;color:{$v['params']['fontcolor']};line-height:{$v['params']['lineheight']}px">
						<ul class="app_time_endtime lasttime" data-time="{$time}">
							<span>{$v['params']['title2']}</span>
							<span class='day' style="color:{$v['params']['timecolor']};background:{$v['params']['timebgcolor']}">00</span> 天
							<span class='hour' style="color:{$v['params']['timecolor']};background:{$v['params']['timebgcolor']}">00</span> :
							<span class='minite' style="color:{$v['params']['timecolor']};background:{$v['params']['timebgcolor']}">00</span> :
							<span class='second' style="color:{$v['params']['timecolor']};background:{$v['params']['timebgcolor']}">00</span>
						</ul>
					</div>
				</div>
			</div>
div;
		return $str;
	}
	
	//商品
	static function decodegoods1($v){
		global $_W;
		
		foreach($v['data'] as $k=>$vv){
			$url = Util::createModuleUrl('good',array('id'=>$vv['gid']));
			
			if($v['params']['style'] == 'hp'){
				$pricestr = '';
				if($v['params']['price'] != 0) {
					$pricestr = '<div class="p1" style="color:'.$v['params']['pricecolor'].';font-size:'.$v['params']['pricesize'].'">￥'.$vv['price'].' </div>';
					if($v['params']['price'] == 1) $pricestr .= '<div class="p2">￥'.$vv['oldprice'].' </div>';
				}
				$div .= <<<div
					<div class="hpoutbox"> 
						<a href="{$url}">
							<div class="app-mod-8-hp-line" style="border-bottom:{$v['params']['hplinecolor']} 1px {$v['params']['hpline']}">
								<div class="app-mod-8-hp-line-img">
									<img style="height:100%" src="{$vv['img']}" /> 
								</div> 
								<div class="app-mod-8-hp-line-info">
									<div class="custom_goodtitle">{$vv['title']}</div>
									<div class="app-mod-8-main-name price">
										{$pricestr}
									</div>
								</div>
							</div>
						</a>
					</div>
div;
				
			}elseif($v['params']['style'] == 'group'){
				$div .= <<<div
					<li class="groupon_item">
						<a href="{$url}">
							<div class="cover"><img data-lazy="{$vv['img']}"></div>
							<p class="group_goodtitle">{$vv['title']}</p>
							<div class="info">
								<span class="join-num">{$vv['groupnum']}人团</span>
								<span>￥</span>
								<span class="price">{$vv['price']}</span>
								<span class="join-text">去开团 </span>
							</div>
						</a>
					</li>
div;
			}else{
				$pricestr1 = '';
				$pricestr2 = '';
				if($v['params']['price'] != 0){
					$oldpricestr = '';
					if($v['params']['price'] == 1){
						$oldpricestr = '<span style="text-decoration:line-through;font-size:12px;color:#eee;">￥'.$vv['oldprice'].'</span>';
					}
					$pricestr = <<<div
						<div class="{$v['params']['onetyle']}">
							<span style="color:{$v['params']['pricecolor']};font-size:{$v['params']['pricesize']}px">￥{$vv['price']} </span>
							{$oldpricestr}
						</div>
div;
					if($v['params']['onetyle'] == 'onetyle-4'){
						$pricestr1 = '';
						$pricestr2 = $pricestr;
					}else{
						$pricestr1 = $pricestr;
						$pricestr2 = '';
					}
				}
				$titlestr = '';
				if($v['params']['showname'] == 1){
					$titlestr = '<div class="app-mod-8-main-name"><div class="app-mod-8-main-name-name">'.$vv['title'].'</div></div>';
				}
				
				$div .= <<<div
					<div class="app-mod-8-good" style="width:{$v['params']['style']}">
						<a href="{$url}">
							<div class="app-mod-8-main">
								<div class="app-mod-8-main-img">
									<!-- 分前端与后台 -->
									<img  src="{$vv['img']}"  />
									{$pricestr1}
								</div>
								{$titlestr}
								{$pricestr2}
							</div>
						</a>
					</div>
div;
			}
		}
		$str = <<<div
			<div class="app-mod app-mod-8 router" style="background-color:{$v['params']['bgcolor']}">
				{$div}
			</div>
div;
		return $str;
	}	

	
	
}