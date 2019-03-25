<?php
/**
 * @Yes-Admin 安装引导
 */
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
// ini_set('display_errors', '1');
//定义目录分隔符
define("DS", DIRECTORY_SEPARATOR);
//定义项目目录
define('APP_PATH', __DIR__ . '/../application/');
//定义web根目录
define('WWW_ROOT', dirname(__FILE__) . DS);
//定义CMS名称
$sitename = "掌上客商城系统";
$lockFile = "./install/install.lock";
if (is_file($lockFile)) {
    die("<script>window.location.href = '../module.php'</script>");
}
if ($_GET['c'] = 'start' && isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    //执行安装
    $host = isset($_POST['hostname']) ? $_POST['hostname'] : '127.0.0.1';
    $port = isset($_POST['port']) ? $_POST['port'] : '3306';
    //判断是否在主机头后面加上了端口号
    $hostData = explode(":", $host);
    if (isset($hostData) && $hostData && is_array($hostData) && count($hostData) > 1) {
        $host = $hostData[0];
        $port = $hostData[1];
    }
    //mysql的账户相关
    $mysqlUserName = isset($_POST['username']) ? $_POST['username'] : 'root';
    $mysqlPassword = isset($_POST['password']) ? $_POST['password'] : 'root';
    $mysqlDataBase = isset($_POST['database']) ? $_POST['database'] : '1234';
    $adminUserName = isset($_POST['adminUserName']) ? $_POST['adminUserName'] : 'admin';
    $adminPassword = isset($_POST['adminPassword']) ? $_POST['adminPassword'] : '123456';
    $rePassword = isset($_POST['rePassword']) ? $_POST['rePassword'] : '123456';

    //判断两次输入是否一致
    if ($adminPassword != $rePassword) {
        die("<script>alert('两次输入密码不一致！');history.go(-1)</script>");
    }
    if (!preg_match("/^[\S]+$/", $adminPassword)) {
        die("<script>alert('密码不能包含空格！');history.go(-1)</script>");
    }
    if (!preg_match("/^\w+$/", $adminUserName)) {
        die("<script>alert('用户名只能输入字母、数字、下划线！');history.go(-1)</script>");
    }
    if (strlen($adminUserName) < 3 || strlen($adminUserName) > 12) {
        die("<script>alert('用户名请输入3~12位字符！');history.go(-1)</script>");
    }
    if (strlen($adminPassword) < 5 || strlen($adminPassword) > 16) {
        die("<script>alert('密码请输入5~16位字符！');history.go(-1)</script>");
    }
    //检测能否读取安装文件
    $sql = @file_get_contents(WWW_ROOT . DS . "install" . DS . 'yesadmin.sql');
    if (!$sql) {
        die("<script>alert('请检查/public/install/yesadmin.sql是否有读取权限！');</script>");
    }
    //链接数据库
    $pdo = new PDO("mysql:host={$host};port={$port}", $mysqlUserName, $mysqlPassword, array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
    ));
    // 连接数据库
    $link = @new mysqli("{$host}:{$port}", $mysqlUserName, $mysqlPassword);
    // 获取错误信息
    $error = $link->connect_error;
    if (!is_null($error)) {
        // 转义防止和alert中的引号冲突
        $error = addslashes($error);
        die("<script>alert('数据库链接失败:$error');history.go(-1)</script>");
    }
    // 设置字符集
    $link->query("SET NAMES 'utf8'");
    $link->server_info > 5.0 or die("<script>alert('请将您的mysql升级到5.0以上');history.go(-1)</script>");
    // 创建数据库并选中
    if (!$link->select_db($mysqlDataBase)) {
        $create_sql = 'CREATE DATABASE IF NOT EXISTS ' . $mysqlDataBase . ' DEFAULT CHARACTER SET utf8;';
        $link->query($create_sql) or die('创建数据库失败');
        $link->select_db($mysqlDataBase);
    }
    $sqlArr = explode(';', $sql);
    foreach ($sqlArr as $key => $val) {
        if ($val) {
            $link->query($val);
        }
    }
    $password = $adminPassword;
    // $password = password_hash($adminPassword, PASSWORD_BCRYPT);
    // $result = $link->query("UPDATE zsk_baidu_adminuser SET username = '{$adminUserName}',password = '{$password}'");
     $result = $link->query("INSERT INTO `zsk_baidu_adminuser`(`username`, `password`, `uniacid`,`judge`) VALUES ('{$adminUserName}','{$password}',0,0)");
    if (!$result) {
        die("<script>alert('安装失败！:$error');history.go(-1)</script>");
    }
    $config= include "../core" . DS . "/task/dbconfig.php";
    //替换数据库相关配置
    $config = array();
// $_W['config']['setting']['authkey'] = "095448f7";
    $config['db']['master']['host']= $host;
    $config['db']['master']['database']= $mysqlDataBase;
    $config['db']['master']['username']= $mysqlUserName;
    $config['db']['master']['password']= $mysqlPassword;
    $putConfig = @file_put_contents("../core" . DS . "/task/dbconfig.php", "<?php\nreturn \n" . var_export($config, true) . "\n;");
    if (!$putConfig) {
        die("<script>alert('安装失败、请确定database.php是否有写入权限！:$error');history.go(-1)</script>");
    }
    $result = @file_put_contents($lockFile, 1);
    if (!$putConfig) {
        die("<script>alert('安装失败、请确定install.lock是否有写入权限！:$error');history.go(-1)</script>");
    }
    die("<script>alert('系统安装成功、点击跳转！');window.location.href = '/admin'</script>");
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>安装<?php echo $sitename; ?></title>
    <meta name="renderer" content="webkit">
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script type="text/javascript" src="./install/static/vue.min.js"></script>
     <link rel="stylesheet" type="text/css" href="./install/static/layout.css">
   <!--  <style type="text/css">
        html, body {
            height: 100%;
            background-image: url("./install/img/installbg.jpg");
            background-size: cover;
        }
    </style> -->
</head>
<body>
<div class="col-md-12 _layout" id="elm">
        <div class="_layout_nav">
            <div class="_layout_nav_left"><img src="./install/static/logo.png" class="_logo"></div>
            <div class="_layout_nav_right">安装掌上客系统</div>
        </div>
        <div class="center-block _layout_top">
            <div class="col-md-2 text-center">
                <ul class="_layout_ul">
                    <li class="_layout_li" style="background-color: #F5F5F5
                    ">安装步骤</li>
                    <li class="_layout_li" :style="{book}">许可协议</li>
                    <li class="_layout_li" :style="{check}">环境检测</li>
                    <li class="_layout_li" :style="{config}">参数配置</li>
                    <li class="_layout_li">完成</li>
                </ul>
            </div>
            <div class="col-md-9 _layout_content" style="padding: 0px">
                <div class="_layout_text" v-if="judge==1">阅读许可协议</div>
                <!-- start -->
                    <div v-if="judge==1" class="panel-body" style="overflow-y:scroll;max-height:400px;line-height:20px;">
                        <h3>版权所有 (c)2018，掌上客保留所有权利。 </h3>
                        <p>
                            感谢您选择掌上客商城软件(基于基于 PHP + MySQL的技术开发)。 <br>
                            为了使你正确并合法的使用本软件，请你在使用前务必阅读清楚下面的协议条款：
                        </p>
                        <p>
                            <strong>一、本授权协议适用且仅适用于掌上客系统(zskcms,  以下简称掌上客)任何版本，掌上客官方对本授权协议的最终解释权。</strong>
                        </p>
                        <p>
                            <strong>二、协议许可的权利 </strong>
                            </p><ol>
                                <li>您可以在完全遵守本最终用户授权协议的基础上，将本软件应用于非商业用途，而不必支付软件版权授权费用。</li>
                                <li>您可以在协议规定的约束和限制范围内修改掌上客源代码或界面风格以适应您的网站要求。</li>
                                <li>您拥有使用本软件构建的网站全部内容所有权，并独立承担与这些内容的相关法律义务。</li>
                                <li>获得商业授权之后，您可以将本软件应用于商业用途，同时依据所购买的授权类型中确定的技术支持内容，自购买时刻起，在技术支持期限内拥有通过指定的方式获得指定范围内的技术支持服务。商业授权用户享有反映和提出意见的权力，相关意见将被作为首要考虑，但没有一定被采纳的承诺或保证。</li>
                            </ol>
                        <p></p>
                        <p>
                            <strong>三、协议规定的约束和限制 </strong>
                            </p><ol>
                                <li>未获商业授权之前，不得将本软件用于商业用途（包括但不限于企业网站、经营性网站、以营利为目的或实现盈利的网站）。</li>
                                <li>未经官方许可，不得对本软件或与之关联的商业授权进行出租、出售、抵押或发放子许可证。</li>
                                <li>未经官方许可，禁止在掌上客的整体或任何部分基础上以发展任何派生版本、修改版本或第三方版本用于重新分发。</li>
                                <li>如果您未能遵守本协议的条款，您的授权将被终止，所被许可的权利将被收回，并承担相应法律责任。</li>
                            </ol>
                        <p></p>
                        <p>
                            <strong>四、有限担保和免责声明 </strong>
                            </p><ol>
                                <li>本软件及所附带的文件是作为不提供任何明确的或隐含的赔偿或担保的形式提供的。</li>
                                <li>用户出于自愿而使用本软件，您必须了解使用本软件的风险，在尚未购买产品技术服务之前，我们不承诺对免费用户提供任何形式的技术支持、使用担保，也不承担任何因使用本软件而产生问题的相关责任。</li>
                                <li>电子文本形式的授权协议如同双方书面签署的协议一样，具有完全的和等同的法律效力。您一旦开始确认本协议并安装  zskcms，即被视为完全理解并接受本协议的各项条款，在享有上述条款授予的权力的同时，受到相关的约束和限制。协议许可范围以外的行为，将直接违反本授权协议并构成侵权，我们有权随时终止授权，责令停止损害，并保留追究相关责任的权力。</li>
                                <li>如果本软件带有其它软件的整合API示范例子包，这些文件版权不属于本软件官方，并且这些文件是没经过授权发布的，请参考相关软件的使用许可合法的使用。</li>
                            </ol>
                        <p>
                    </p>
                </div>
                <div class="_layout_text" v-if="judge==2">环境检测</div>
                <div class="_layout_jiance" v-if="judge==2">
                    <div class="_layout_center_top">
                        <div class="col-md-3">参数</div>
                        <div class="col-md-9">值</div>
                    </div>
                    <div class="_layout_center_top">
                        <div class="col-md-3">域名</div>
                        <div class="col-md-9"><?php echo $_SERVER['SERVER_NAME']?></div>
                    </div>
                    <div class="_layout_center_top">
                        <div class="col-md-3">运行环境</div>
                        <div class="col-md-9"><?php echo $_SERVER["SERVER_SOFTWARE"]?></div>
                    </div>
                    <div class="_layout_center_top">
                        <div class="col-md-3">端口</div>
                        <div class="col-md-9"><?php echo $_SERVER['SERVER_PORT']?></div>
                    </div>
                    <div class="_layout_center_top">
                        <div class="col-md-3">服务器域名</div>
                        <div class="col-md-9"><?php echo $_SERVER['SERVER_NAME']?></div>
                    </div>
                    <div class="_layout_center_top">
                        <div class="col-md-3">IP地址</div>
                        <div class="col-md-9"><?php echo $_SERVER['REMOTE_ADDR']?></div>
                    </div>
                </div>
                <div class="_layout_text" v-if="judge==2" style="margin-top: 20px">目录权限检测</div>
                <div v-if="judge==2" style="margin-bottom:30px">
                    <div class="_layout_center_top">
                        <div class="col-md-3">目录</div>
                        <div class="col-md-4">要求</div>
                        <div class="col-md-4">状态</div>
                    </div>
                    <div class="_layout_center_top" >
                        <div class="col-md-3">/</div>
                        <div class="col-md-4">整个目录可写</div>
                        <?php if(is_writable(__DIR__)){
                        ?>
                        <div class="col-md-4">正常</div>
                        <?php }else{?>
                        <div class="col-md-4">无法写入</div>
                        <?php }?>
                    </div>
                </div>
                <!-- end -->
                <div class="container-fluid" v-if="judge==3">
                    <div class="row">
                        <div class="col-md-12" style="background-color: rgba(255,255,255,.5);border-radius: 5px;padding:0px">
                            <div id="cms-box">
                                <form class="form-horizontal" action="./install.php?c=start" method="post" id="formid">
<!--                                     <p style="font-size: 28px;font-weight: bolder;text-align: center;color: #fff;"><?= $sitename ?> 安装向导</p> -->
                                    <div class="panel panel-default">
                                        <div class="panel-heading">数据库相关设置</div>
                                        <div class="panel-body">
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">主机地址</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="hostname" class="form-control" placeholder="请输入主机地址、端口号可选">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">数据库名</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="database" class="form-control" placeholder="请输入数据库名">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">用户名</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="username" class="form-control" placeholder="请输入用户名">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">密码</label>
                                                <div class="col-sm-10">
                                                    <input type="password" name="password" class="form-control" placeholder="请输入数据库密码">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel panel-default">
                                        <div class="panel-heading">管理员账户相关设置</div>
                                        <div class="panel-body">
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">用户名</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="adminUserName" class="form-control" placeholder="请输入管理员账号">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">密码</label>
                                                <div class="col-sm-10">
                                                    <input type="password" name="adminPassword" class="form-control" placeholder="请输入密码">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">重复密码</label>
                                                <div class="col-sm-10">
                                                    <input type="password" name="rePassword" class="form-control" placeholder="请再次输入密码">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <button type="button" class="btn btn-info" style="width: 80%;" onclick="onsub()">立即安装</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-offset-9 btn btn-info" v-on:click="setbook()" v-if="judge==1">已阅读并同意本条约</div>
            <div class="col-md-offset-9 btn btn-info" v-on:click="checkbook()" v-if="judge==2">下一步</div>
        </div>
    </div>
<script type="text/javascript" src="./install/static/jquery.min.js"></script>
<script type="text/javascript" src="./install/static/jquery.ripples.js"></script>
<script type="text/javascript">
    var vm = new Vue({
        el:"#elm",
        data:{
            judge:1,
            book:"background-color:#fff",
            check:"background-color:#fff",
            config:"background-color:#fff",
        },
        methods:{
            setbook:function(){
                vm.book = "background-color:#D9EDF7"
                vm.judge =2;
            },
            checkbook:function(){
                vm.book = "background-color:#D9EDF7"
                vm.check = "background-color:#D9EDF7"
                vm.judge =3;
            }
        }
    })
    function onsub(){
         //判断两次输入是否一致
        var adminPassword = $("input[name='adminPassword']").val()
        var rePassword = $("input[name='rePassword']").val()
        var adminUserName = $("input[name='adminUserName']").val()
        if (adminUserName.length < 3 || adminUserName.length > 12) {
            alert('用户名请输入3~12位字符！');
            return false;
        }
        if (adminPassword.length < 5 || adminPassword.length > 16) {
            alert('密码请输入5~16位字符！');
            return false;
        }
        if (adminPassword != rePassword) {
            alert('两次输入密码不一致！');
            return false;
        }
        var pattern=/\s/;
        if (pattern.test(adminPassword)) {
            alert('密码不能包含空格！');
            return false;
        }
        var reg = /(^([a-zA-Z]+[0-9]+)$)|(^[0-9]+[a-zA-Z]+$)/;
        if (reg.test(adminUserName)) {
            alert('用户名只能输入字母、数字、下划线！');
            return false;
        }
        $("#formid").submit();
    }
    $(function () {
        $('body').ripples({
            resolution: 512,
            dropRadius: 20, //px
            perturbance: 0.04,
        });
    });
</script>
</body>
</html>