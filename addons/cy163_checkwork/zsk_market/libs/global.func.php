 <?php
 function is_error($data) {
  if (empty($data) || !is_array($data) || !array_key_exists('errno', $data) || (array_key_exists('errno', $data) && $data['errno'] == 0)) {
    return false;
  } else {
    return true;
  }
}
 function local_salt($length = 8) {
  $result = '';
  while(strlen($result) < $length) {
    $result .= sha1(uniqid('', true));
  }
  return substr($result, 0, $length);
}
 // 加密算法
function user_hash($passwordinput, $salt) {
    global $_W;
    $passwordinput = "{$passwordinput}-{$salt}-{$_W['config']['setting']['authkey']}";
    return sha1($passwordinput);
  }
  // 用户是否存在
 function user_single($user_or_uid) {
    $user = $user_or_uid;
    if (empty($user)) {
      return false;
      die();
    }
    if (is_numeric($user)) {
      $user = array('uid' => $user);
    }
    if (!is_array($user)) {
      return false;
      die();
    }
    $model = Model("shop");
    $sql = 'SELECT * FROM ims_users WHERE uid='.$user['uid'];
    $res = $model->query($sql);
    return $res[0];
  }
//存储添加用户信息
function user_register($user){
  if (empty($user) || !is_array($user)) {
    return 0;
  }
  if (isset($user['uid'])) {
    unset($user['uid']);
  }
  $user['salt'] = random(8);
  $user['password'] = user_hash($user['password'], $user['salt']);
  $user['joindate'] = time();
  if (empty($user['status'])) {
    $user['status'] = 2;
  }
  if (empty($user['type'])) {
    $user['type'] = 2;
  }

  foreach($user as $k=>$v){
    $k1[] = '`'.$k.'`';  //将字段作为一个数组；
    $v1[] = '"'.$v.'"';  //将插入的值作为一个数组； 
  }
  $strv.=implode(',',$v1);   
  $strk.=implode(",",$k1); 
  $sql = "INSERT INTO ims_users ($strk) values ($strv)";
  $model = Model('shop');
  return $model->query($sql);
}
  // 存储修改信息
function user_update($user) {
  if (empty($user['uid']) || !is_array($user)) {
    return false;
  }
  $record = array();
  if (!empty($user['username'])) {
    $record['username'] = $user['username'];
  }
  if (!empty($user['password'])) {
    $record['password'] = user_hash($user['password'], $user['salt']);
  }
  if (!empty($user['lastvisit'])) {
    $record['lastvisit'] = (strlen($user['lastvisit']) == 10) ? $user['lastvisit'] : strtotime($user['lastvisit']);
  }
  if (!empty($user['lastip'])) {
    $record['lastip'] = $user['lastip'];
  }
  if (isset($user['joinip'])) {
    $record['joinip'] = $user['joinip'];
  }
  if (isset($user['remark'])) {
    $record['remark'] = $user['remark'];
  }
  if (isset($user['type'])) {
    $record['type'] = $user['type'];
  }
  if (isset($user['status'])) {
    $status = intval($user['status']);
    if (!in_array($status, array(1, 2))) {
      $status = 2;
    }
    $record['status'] = $status;
  }
  if (isset($user['groupid'])) {
    $record['groupid'] = $user['groupid'];
  }
  if (isset($user['starttime'])) {
    $record['starttime'] = $user['starttime'];
  }
  if (isset($user['endtime'])) {
    $record['endtime'] = $user['endtime'];
  }
  if(isset($user['lastuniacid'])) {
    $record['lastuniacid'] = intval($user['lastuniacid']);
  }
  if (empty($record)) {
    return false;
  }
    $model = Model("shop");
    $set ="";
    foreach ($record as $key => $val) {
      $set.="`$key`='".$val."',";
    }
    $set=substr($set,0,strlen($set)-1);
    $where = "uid =".$user['uid'];
    $sql = "UPDATE ims_users SET $set $where";
    return $model->query($sql);
}
// 查询权限
function permission_account_user_role($uid = 0, $uniacid = 0) {
  $a = "ims_uni_account_users";
  $model = Model("shop");
  $sql = "SELECT * FROM $a where uid=$uid and uniacid=$uniacid";
  $res = $model->query($sql);
  return $res[0];
}
// 查询当前用户名
function user_check($res){
  $a = "ims_users";
  $sql = "SELECT * FROM $a WHERE username='".$res['username']."'";
  $model = Model("shop");
  $ret = $model->query($sql);
  if($ret[0]){
    return true;
  }
}
// 查询当前版本
function permission_account_user_menu($uid, $uniacid, $type){
    $uid = intval($uid);
    $uniacid = intval($uniacid);
    $type = trim($type);
    if (empty($uid) || empty($uniacid) || empty($type)) {
      return error(-1, '参数错误！');
    }
}
// $_W['config']['setting']['authkey'] = local_salt(8);
 //密码加密算法
		$_GPC = array_merge($_POST,$_GET);
      function scriptname() {
          global $_W;
          $_W['script_name'] = basename($_SERVER['SCRIPT_FILENAME']);
          if(basename($_SERVER['SCRIPT_NAME']) === $_W['script_name']) {
              $_W['script_name'] = $_SERVER['SCRIPT_NAME'];
          } else {
              if(basename($_SERVER['PHP_SELF']) === $_W['script_name']) {
                  $_W['script_name'] = $_SERVER['PHP_SELF'];
              } else {
                  if(isset($_SERVER['ORIG_SCRIPT_NAME']) && basename($_SERVER['ORIG_SCRIPT_NAME']) === $_W['script_name']) {
                      $_W['script_name'] = $_SERVER['ORIG_SCRIPT_NAME'];
                  } else {
                      if(($pos = strpos($_SERVER['PHP_SELF'], '/' . $scriptName)) !== false) {
                          $_W['script_name'] = substr($_SERVER['SCRIPT_NAME'], 0, $pos) . '/' . $_W['script_name'];
                      } else {
                          if(isset($_SERVER['DOCUMENT_ROOT']) && strpos($_SERVER['SCRIPT_FILENAME'], $_SERVER['DOCUMENT_ROOT']) === 0) {
                              $_W['script_name'] = str_replace('\\', '/', str_replace($_SERVER['DOCUMENT_ROOT'], '', $_SERVER['SCRIPT_FILENAME']));
                          } else {
                              $_W['script_name'] = 'unknown';
                          }
                      }
                  }
              }
          }
          return $_W['script_name'];
      }
      function random($length, $numeric = FALSE) {
        $seed = base_convert(md5(microtime() . $_SERVER['DOCUMENT_ROOT']), 16, $numeric ? 10 : 35);
        $seed = $numeric ? (str_replace('0', '', $seed) . '012340567890') : ($seed . 'zZ' . strtoupper($seed));
        if ($numeric) {
          $hash = '';
        } else {
          $hash = chr(rand(1, 26) + rand(0, 1) * 32 + 64);
          $length--;
        }
        $max = strlen($seed) - 1;
        for ($i = 0; $i < $length; $i++) {
          $hash .= $seed{mt_rand(0, $max)};
        }
        return $hash;
      }
      function safe_bad_str_replace($string) {
          if (empty($string)) {
              return '';
          }
          $badstr = array("\0", "%00", "%3C", "%3E", '<?', '<%', '<?php', '{php', '../');
          $newstr = array('_', '_', '&lt;', '&gt;', '_', '_', '_', '_', '.._');
          $string  = str_replace($badstr, $newstr, $string);

          return $string;
      }
      function safe_gpc_string($value, $default = '') {
          $value = safe_bad_str_replace($value);
          $value  = preg_replace('/&((#(\d{3,5}|x[a-fA-F0-9]{4}));)/', '&\\1', $value);

          if (empty($value) && $default != $value) {
              $value = $default;
          }
          return $value;
      }
      function ihtmlspecialchars($var) {
          if (is_array($var)) {
              foreach ($var as $key => $value) {
                  $var[htmlspecialchars($key)] = ihtmlspecialchars($value);
              }
          } else {
              $var = str_replace('&amp;', '&', htmlspecialchars($var, ENT_QUOTES));
          }
          return $var;
      }
    	function error() {
            return errors;
        }
function message($msg="",$url=false,$ajax=0){
  global $_GPC,$_W;
  $_W['sitescheme'] = $_W['ishttps'] ? 'https://' : 'http://';
      $_W['script_name'] = htmlspecialchars(scriptname());
      $sitepath = substr($_SERVER['PHP_SELF'], 0, strrpos($_SERVER['PHP_SELF'], '/'));
      $_W['siteroot'] = htmlspecialchars($_W['sitescheme'] . $_SERVER['HTTP_HOST'] . $sitepath);
  $zskpath= $_W['siteroot'];
  $referer=$_SERVER['HTTP_REFERER'];
  $title=$msg;
  $notice="点击返回上一页";

  $type="fail";
  $png="success";
  $script='';
  if($url){ 
    $url1=$url;
    $notice="如果浏览器没有跳转，请点此跳转";
    $type="success";
    $png="success";
    $script='setTimeout(function(){window.location.href="'.$url1.'";},2500);';
  }else{
    $png="warning";
    $url1="javascript:history.go(-1);";
  }
  if($ajax!==0){
    $res=['message'=>$msg,"redirect"=>$url,'type'=>false];
    if($ajax){
      $res['type']=true;
    }
    echo json_encode($res);
    die();
  }
   
$content=
<<<EOF
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title></title>
    <style>
      html,body{width:100%;backgroun-color:#f2f2f2;height:100%;}
      body{margin:0 0;font-family: "Helvetica Neue,Helvetica,Arial,sans-serif"}
      a,a:active,a:visited,a:hover,a:link{text-decoration: none;color:#000;} 
    </style>
    <script src="../addons/zsk_waimai/static/js/jquery.min.js"></script>
     
    <style type="text/css">
      .td{display: table-cell;vertical-align: middle;}
      .container{width:400px;height: 350px;border-radius: 5px;margin:10% auto;text-align: center;display: inline-block;background-color: #f8f8f8;position: relative;}
      .container img{border-radius: 50%;background-color: #fff;width:150px;height:150px;margin:20px auto;padding:20px 20px}
      .link{display: block;padding:10px 10px;background-color: #fff;position: absolute;bottom: 0;left: 0;right: 0;}
      .link .message{color:#55BEEB;font-size:24px;text-align: center;font-weight: 600;margin:10px auto;}
      .link .notice{color:#999;font-size:14px;text-align: center;font-weight: 500;margin:10px auto;}
      .fail .message{color:#000000!important;} 
    </style>
  </head>
  <body style="background-color:#f2f2f2;text-align: center;display: table;" >
    <div class="td"> 
      <div class="container">
        <img src="{$zskpath}/static/images/{$png}.png" > 
        <a class="link {$type}" href="{$url1}">
          <div class="message">{$msg}</div>
          <div class="notice">{$notice}</div>
        </a>
      </div>
    </div>
  </body>
  <script>
     {$script} 
  </script>
</html>
EOF;
  echo $content;
  die();
}
function istrlen($string, $charset = '') {
  global $_W;
  if (empty($charset)) {
    $charset = "utf8";
  }
  if (strtolower($charset) == 'gbk') {
    $charset = 'gbk';
  } else {
    $charset = 'utf8';
  }
  if (function_exists('mb_strlen') && extension_loaded('mbstring')) {
    return mb_strlen($string, $charset);
  } else {
    $n = $noc = 0;
    $strlen = strlen($string);

    if ($charset == 'utf8') {

      while ($n < $strlen) {
        $t = ord($string[$n]);
        if ($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
          $n++;
          $noc++;
        } elseif (194 <= $t && $t <= 223) {
          $n += 2;
          $noc++;
        } elseif (224 <= $t && $t <= 239) {
          $n += 3;
          $noc++;
        } elseif (240 <= $t && $t <= 247) {
          $n += 4;
          $noc++;
        } elseif (248 <= $t && $t <= 251) {
          $n += 5;
          $noc++;
        } elseif ($t == 252 || $t == 253) {
          $n += 6;
          $noc++;
        } else {
          $n++;
        }
      }

    } else {

      while ($n < $strlen) {
        $t = ord($string[$n]);
        if ($t > 127) {
          $n += 2;
          $noc++;
        } else {
          $n++;
          $noc++;
        }
      }

    }

    return $noc;
  }
}