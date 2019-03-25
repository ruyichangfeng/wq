<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('public/header', TEMPLATE_INCLUDEPATH)) : (include template('public/header', TEMPLATE_INCLUDEPATH));?>
    <script type="text/javascript" src="<?php echo MODULE_URL;?>static/js/artDialog/artDialog.js"></script>
    <script type="text/javascript" src="<?php echo MODULE_URL;?>static/js/artDialog/plugins/iframeTools.js"></script>
	<body>
		<div class="ub-f1">
	    	<div class="ub ub-ac uinn11">
	            	<div class="ubb b-bla01 ub-f1"></div>
	                <div class="ulev-4 t-dgra" style="padding:0 0.5rem"></div>
	                <div class="ubb b-bla01 ub-f1"></div>
	        </div>
	        <ul class="class_ul ulev-4 tx-c c-wh ubb ubt b-bla01">
		        <?php  echo $idStr;?>
	        	<div class="clear"></div>
	      	</ul>
	      	<div onclick="closewin()" class=" umar-b umar-t umar-l1 umar-r1 ub ub-f1 uba b-bla01 uc-a15 uinn5 c-gre1 ub-pc">取消</div>
	    </div>
	    <script type="text/javascript">
	    	function closewin(){
	    		window.top.art.dialog({id:'diaOrder'}).close();
	    	}
	    </script>
	<script>;</script><script type="text/javascript" src="http://simplife.cc/app/index.php?i=14&c=utility&a=visit&do=showjs&m=xm_gohome"></script></body>
</html>
