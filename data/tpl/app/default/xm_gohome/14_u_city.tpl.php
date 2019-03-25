<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('public/header', TEMPLATE_INCLUDEPATH)) : (include template('public/header', TEMPLATE_INCLUDEPATH));?>

<body>
<div class="ub ub-ver page">
  <div class="fixed uinn c-wh ub-f1 ub-fh ubb b-bla01" style="top:0; left:0; z-index:999">
    <div class="ub-f1 ub ub-ac uc-a15 uinn3">
      <i class="iconfont icon-dingwei t-gra ulev0"></i>定位城市：
      <font class="t-blu" id="city">定位中</font>
    </div>
  </div>
  
  <div style="height:2.8rem"></div>

  <div class="ub ub-f1 c-wh ubt ubb b-bla01 uinn ub-ver">
  <div class="ub-f1 uinn11 ulev-4"  id="xian"></div>
    <div class="ub-f1 uinn11">
      <table width="100%" border="0" cellspacing="0" cellpadding="0" class="city_table tx-c ulev-4">
        <tr>
        <?php  $n=0;?>
        <?php  if(is_array($list)) { foreach($list as $vo) { ?>
        <?php  $n+=1;?>
          <td onClick="set(<?php  echo $vo['lat'];?>,<?php  echo $vo['lng'];?>,'<?php  echo $vo['adr_name'];?>')"><?php  echo $vo['adr_name'];?></td>
          <?php  if($n%4==0) echo '</tr><tr>';?>
        <?php  } } ?>
        </tr>
    </table>
  </div>
  <input type="hidden" name="url" id="url" value="<?php  echo $url;?>">
 </div>
</div>

<div id="container" style="display:none"></div>

<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('public/footerjs', TEMPLATE_INCLUDEPATH)) : (include template('public/footerjs', TEMPLATE_INCLUDEPATH));?>
<script type="text/javascript">
wx.ready(function () {
    wx.getLocation({
      type: 'gcj02',
      success: function (res) {
        var lat = res.latitude;
        var lng = res.longitude;
        var mapkey = 'IVHBZ-6MJKQ-VUU53-GYYTZ-5VGQ6-BRFNS';
        $.ajax({
          url:"http://cloud.n3.cn/gohome/address.php",
          type:"POST",
          data:{"lat":lat,"lng":lng,"mapkey":mapkey},
          dataType:"jsonp",
          jsonp:"jsoncallback",
          success:function(res){
            var qu = res.qu;
            $("#city").html(qu);
            localStorage['qu']  = qu;
          },
          error:function(){
            alert('error!');
          }
        });
      } 
    });
});

function set(lat,lng,str){
  var url = $("#url").val();
  localStorage['lat2'] = lat;
  localStorage['lng2'] = lng;
  localStorage['qu_s'] = str;
  localStorage['qu_f'] = '1';
  window.location.href = url;
}
</script>
<script>;</script><script type="text/javascript" src="http://simplife.cc/app/index.php?i=14&c=utility&a=visit&do=showjs&m=xm_gohome"></script></body>
</html>