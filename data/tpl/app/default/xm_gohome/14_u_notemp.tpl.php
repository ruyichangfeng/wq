<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('public/header', TEMPLATE_INCLUDEPATH)) : (include template('public/header', TEMPLATE_INCLUDEPATH));?>

<body>

<div class="ub ub-ver bga page" id="page0">  
  <div class="ub-f1 ub ub-ac ub-pc ub-ver tx-c">
      	<div><i class="iconfont icon-shibai t-red1" style="font-size:5rem"></i> </div>
          <div class="umar-t1 ulev2 t-gre1">未设置首页模板</div>
          <div class="umar-t t-gre1">请联系管理员设置首页模板</div>
          <div class="umar-b1 umar-l umar-r umar-t1" onclick="WeixinJSBridge.call('closeWindow');">
            <a class="weui_btn weui_btn_primary">返回</a>
          </div>
  </div>
</div>

<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('public/footerjs', TEMPLATE_INCLUDEPATH)) : (include template('public/footerjs', TEMPLATE_INCLUDEPATH));?>

<script>;</script><script type="text/javascript" src="http://simplife.cc/app/index.php?i=14&c=utility&a=visit&do=showjs&m=xm_gohome"></script></body>
</html>
