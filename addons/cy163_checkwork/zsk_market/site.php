 <?php
/*
 * v2.0.0模块微站定义
 * @author zskcms
 * @url 
 */   
defined('IN_IA') or exit('Access Denied'); 
require_once IA_ROOT.'/addons/zsk_market/defines.php';

//require_once ZSK_PATH."/libs/checkdb.php"; 
require_once ZSK_PATH."/libs/function.php";  
require_once ZSK_PATH."/libs/wechat.class.php"; 
require_once ZSK_PATH."/libs/model.class.php";   
require_once ZSK_PATH."/libs/tpl.func.php"; 
require_once ZSK_PATH."/libs/wxpay/wxpay.class.php";  
require_once ZSK_PATH."/libs/wxpush.func.php"; 
class Zsk_marketModuleSite extends WeModuleSite { 
	public function doWebLogin(){
		 
	}
	public function doWebRoute(){  
		if(intval($_GPC['reloadShop'])>0){
			session_start();
			$_SESSION['currentShop']=NULL;
		}
		route();
	}  
	public function doWebDebug(){
		route();
	}
	public function doWebcheckout999(){
		//导入数据库结构json
		global $_W;
		$records=array(); 
		$tabs=pdo_fetchall("SHOW TABLES LIKE '%".ZSK_PREFIX."%'"); 
		$tables=array(); 
		foreach ($tabs as $sss => $ss) {  
			$tt=array_values($ss); 
			$tab=$tt[0];
			$table=pdo_fetchall("desc `$tab`");
			$s=strpos($tab,ZSK_PREFIX); 
			$tab2=substr($tab,$s,strlen($tab)-$s);
			$tables[$tab2]=$table; 
		} 
		$content=file_get_contents(ZSK_PATH.'/libs/checkdb.bak.php');
		$jj=fopen(ZSK_PATH."/libs/checkdb.php", "w+") or die("打开checkdb失败"); 
		$stream=str_replace('There is a json string', json_encode($tables) , $content);
		fwrite($jj,$stream);
		fclose($jj);  
		$strpos=stripos($stream,"update-end");
		 
		$jj=fopen(ZSK_PATH."/libs/checkdb.tab.php", "w+") or die("打开checkdb2失败"); 
		$stream2=substr($stream,0,$strpos);
		fwrite($jj,$stream2);
		fclose($jj); 
		die("输出完成");
	}
	public function doWebcheckdb(){
		//导入数据库结构json
		header("Content-Type:text/html;charset=utf-8;");
	 
		$debug=true; 
		include ZSK_PATH."/libs/checkdb.tab.php";

	}
	public function doWebcheckdb2(){
		//导入数据库结构json
		$debug=true;
		include ZSK_PATH."/libs/checkdb.php";
		die("操作完成");
	}
	public function doWebcheckup(){
		//导入数据库结构json
		header("Content-Type:text/html;charset=utf-8;");
	 
		$debug=true; 
		include ZSK_PATH."/libs/checkdb.php";

	}
 
	public function doMobilebindNotice(){
		 //绑定公众号订单提醒人
		global $_W,$_GPC;
		$uniacid=intval($_W['uniacid']);
		$m=Model("shop"); 
		$curUrl=$_W['siteurl'] ;//当前页面链接
		 
		$setting=getSetting("all");
		$appid=$setting["wx_appid"];//公众号appid
		$secret=$setting["wx_secret"];//公众号secret
		if(intval($setting['wx_auth_uniacid'])){
			$wechat=pdo_fetch("SELECT `key` as appid,secret FROM ".tablename("account_wechats")." WHERE uniacid='".intval($setting['wx_auth_uniacid'])."' LIMIT 1");
			$appid=$wechat['appid'];
			$secret=$wechat['secret'];
		} 
		$shopid=intval($_GPC['shopid']);

		if(isset($_GET['code'])){ 
			 
			$sdk=new WeixinJS($appid,$secret);
			 
			$user_url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$appid.'&secret='.$secret.'&code='.$_GET['code'].'&grant_type=authorization_code';
			$json1=CURL_send($user_url); 
			$openid=$json1['openid'];

			$url2='https://api.weixin.qq.com/sns/userinfo?access_token='.$json1['access_token'].'&openid='.$openid.'&lang=zh_CN'; 
			$user=CURL_send($url2);   
			$icon='warn';
			$msg="绑定失败"; 

			if(strlen($openid)>20){
				$p=array(
					"type"=>2,
					"shopid"=>$shopid,
					'uniacid'=>$_W['uniacid'], 
					'nickname'=>$user['nickname'],
					'openid'=>$openid,
					'avatarUrl'=>$user['headimgurl'],
					'city'=>$user['city'],
					'status'=>1
				);
				if($_GPC['type']=="platform"){
					$p['type']=5;
					$m=Model("pusher");
					$p0=$m->where("openid='".$openid."' and uniacid=$uniacid and type=5")->get("*");
					 $count=Model("pusher")->where("uniacid=$uniacid and type=5 ")->count();
					if($count>0){
						$msg="只能绑定一个平台通知人";
						 
					}else{
						$msg="绑定成功";
						if($p0){
							$id=$m->where("openid='".$openid."' and uniacid=$uniacid and type=5 ")->limit(1)->save($p) ;
						}else{
							$m->add($p);
						}
					}
					
				}else{
					$m=Model("pusher");
					$p0=$m->where("openid='".$openid."' and uniacid=$uniacid and shopid=$shopid ")->get("*");
					 $count=Model("pusher")->where("uniacid=$uniacid and shopid=$shopid ")->count();
					if($count>4){
						$msg="为保障运行效率，每个小程序最多绑定5个订单管理员";
						 
					}else{
						$msg="绑定成功";
						if($p0){
							$id=$m->where("openid='".$openid."' and uniacid=$uniacid and shopid=$shopid ")->limit(1)->save($p) ;
						}else{
							$m->add($p);
						}
					}
					
				
			 	}
			 	
				$icon='success'; 
			}else{
				$msg="code:".$user['errcode'];
			}
			$sign=$sdk->getSignPackage();	
			echo '
			<!DOCTYPE html>
			<html>
			<head>
				<title>通知绑定推送</title>
				<meta charset="utf-8">
				<meta name="X-UA-Compatible" content="IE=Edge, chrome=1">
				<meta name="format-detection" content="telephone=no">
				<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">    
				<script type="text/javascript" src="'.ZSK_STATIC.'js/jquery.min.js"></script>
				<script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script> 
				<link rel="stylesheet" type="text/css" href="https://cdn.bootcss.com/weui/1.1.2/style/weui.min.css">
				<style type="text/css">
					.tab1{width: 100%;}
					.tab1 td{padding: 10px 10px;}
					.tab1 .left{text-align: right;width: 28%;}
					.tab1 .right{text-align: left;width: 72%;}
					.right .input{width: 80%;}
					.need{color:#ff4444;font-size:13px;}
					.form-control{display: inline-block !important;}
				</style>
			</head> 
			<body  >
			 
				<div class="weui-msg">
			  <div class="weui-msg__icon-area"><i class="weui-icon-'.$icon.' weui-icon_msg"></i></div>
			  <div class="weui-msg__text-area">
			    <h2 class="weui-msg__title">'.$msg.'</h2>
			    <p class="weui-msg__desc" style="font-size:18px;"><?php echo $icon=="warn"?"code: ".$user["errcode"]:"";?></p>
			  </div>
			  <div class="weui-msg__opr-area">
			    <p class="weui-btn-area">'; 
			    if(strlen($url0)>2){  
			    	echo  '<a href="{$url0}" class="weui-btn weui-btn_primary">返回上一页</a>';
			    }else{  
			    	echo  '<a href="javascript:;" onclick="closePage()" class="weui-btn weui-btn_primary">关闭</a>'; 
				}
			   	echo '</p>
			  </div>
			 
			</div>
			</body>
			<script type="text/javascript"> 
			    wx.config({
			        debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
			        appId: "'.$sign["appId"].'", // 必填，公众号的唯一标识
			        timestamp: '.$sign["timestamp"].', // 必填，生成签名的时间戳
			        nonceStr: "'.$sign["nonceStr"].'", // 必填，生成签名的随机串
			        signature: "'.$sign["signature"].'",// 必填，签名，见附录1
			        jsApiList: [] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
			    });
			    
			  function closePage(){
			    wx.closeWindow();
			  }
			</script>
			</html>';
			
		}else{
		    $url1="https://open.weixin.qq.com/connect/oauth2/authorize?appid=$appid&redirect_uri=".urlencode($curUrl)."&response_type=code&scope=snsapi_base&state=flower#wechat_redirect";

		      header("location:".$url1);
		      
		} 
	}
}