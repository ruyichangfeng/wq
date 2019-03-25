/*只能在jquery被引入后才能使用的调用*/
var spec;
spec_sid   = '408';
spec_topic = '头条128元8平尺小图';
spec_dates = '20160729';
spec_areas = '全国';
spec_mates = '0005';
spec_corp  = '北京华夏珍宝博物馆';
spec_gspec = spec_topic;//'头条 腾讯 天天快报';
spec_exurl = window.location+"";
spec_filen = getQueryString("choice");
req_array  = spec_filen.split("_");
spec_seqs  = req_array[0];//'201604271';
spec_provi = req_array[1];//'yn';
spec_gname = spec_topic+'-'+spec_dates+'-'+spec_areas+'-'+spec_mates;

spec_urih  = '/index.php?app=maotai&act=';
spec_add   = 'add';
spec_page  = 'page';
spec_trans = 'trans';//使用此项需要页面POSTajaxform参数
spec_body  = '&choice=';
spec_index = spec_seqs+'_'+spec_provi+'_'+'index';
spec_tijiao= spec_seqs+'_'+spec_provi+'_'+'tijiao';
spec_iadd  = spec_urih+spec_add+spec_body+spec_index+'';
spec_iidx  = spec_urih+spec_page+spec_body+spec_index+'';
spec_itra  = spec_urih+spec_trans+spec_body+spec_index+'';
spec_tadd  = spec_urih+spec_add+spec_body+spec_tijiao+'';
spec_tidx  = spec_urih+spec_page+spec_body+spec_tijiao+'';
spec_ttra  = spec_urih+spec_trans +spec_body+spec_tijiao+'';


function statistics()
{
  $.post("/index.php?app=maotai&act=statistics",{
      sid : spec_sid,
      goods_name:spec_gname,
      special:spec_gspec,
      exurl:spec_exurl
      });
} 
           
function setLeave()
{
  $.post("/index.php?app=maotai&act=confirmLeft",{
      sid : spec_sid,
      goods_name:spec_gname,
      special:spec_gspec,
      exurl:spec_exurl
      });
}

function doPos(){
  $.post("/index.php?app=maotai&act=confirmPos",{
      sid : spec_sid,
      goods_name:spec_gname,
      special:spec_gspec,
      exurl:spec_exurl
      });
} 

function doNeg(){
  $.post("/index.php?app=maotai&act=confirmNeg",{
      sid : spec_sid,
      goods_name:spec_gname,
      special:spec_gspec,
      exurl:spec_exurl
      });
} 

$.post("/index.php?app=maotai&act=setAuthSeed",{
      sid : spec_sid,
      goods_name:spec_gname,
      special:spec_gspec,
      exurl:spec_exurl
      });

function getQueryString(name) {
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
    var r = window.location.search.substr(1).match(reg);
    if (r != null) return unescape(r[2]);
    return null;
}
window.onbeforeunload = setLeave;
