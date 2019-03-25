<?php
/**
 * 微擎小程序模板模块小程序接口定义
 *
 * @author 微擎团队
 * @url 
 */
defined('IN_IA') or exit('Access Denied');
define('NCS_APP_NAME','ncs_meirong');
require_once IA_ROOT.'/addons/'.NCS_APP_NAME.'/core/init.php';

class Ncs_meirongModuleWxapp extends WeModuleWxapp {

    /**
     * 首页中部导航栏
     */
    public function doPageNav(){
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        /*
        $data =[
            [
                id=>1,
                icon=>"../../images/nav_icon_01.png",
                title=>"推荐"
            ],
            [
                id=>2,
                icon=>"../../images/nav_icon_02.png",
                title=>"美甲"
            ],
            [
                id=>3,
                icon=>"../../images/nav_icon_03.png",
                title=>"美容"
            ],
            [
                id=>4,
                icon=>"../../images/nav_icon_04.png",
                title=>"美发"
            ],
            [
                id=>5,
                icon=>"../../images/nav_icon_05.png",
                title=>"美睫"
            ]
        ];
        */
        $data = pdo_getall("wq_service_nav",array('status'=>1,"uniacid"=>$uniacid),array('id','name','simg'),'',"sort DESC,createtime DESC");
        foreach ($data  as $key=>$val)
        {
            $data[$key]['title'] = $val['name'];
            $data[$key]['icon'] = tomedia($val['simg']);
            unset($data[$key]['name']);
            unset($data[$key]['simg']);
        }
        echo json_encode(array("status"=>1,'msg'=>'成功',"data"=>$data));
    }

    /**
     * 首页幻灯片
     */
    public function doPageSlide(){
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $banner=pdo_getall("wq_banner",array('status'=>1,"uniacid"=>$uniacid),array(),'',"sort DESC,createtime DESC");
        if($banner){
            foreach($banner as &$x){
                $data[]=tomedia($x['bimg']);
            }
        }
        //$data = ['../../images/banner_01.png', '../../images/banner_02.png', '../../images/banner_03.png', '../../images/banner_04.png'];
        echo json_encode(array("status"=>1,'msg'=>'幻灯片获取成功',"data"=>$data));
    }

    /**
     * 推荐服务
     */
    public function doPageLists(){
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        /*
        $data = [
            [
                [

                    subject => "秋季自然特价美甲",
                    coverpath => "../../images/recommend_img_01.png",
                    price => '¥198',
                    message => '我们追求的是没有最长只有更长！',
                    'id'=>301
                ],
                [

                    subject => "睫毛稀疏 种睫毛来帮忙",
                    coverpath => "../../images/recommend_img_02.png",
                    price => '¥1888',
                    message => '我们追求的是没有最长只有更长！',
                    'id'=>302
                ],
                [

                    subject => "爱丽克EircParisSalon",
                    coverpath => "../../images/recommend_img_03.png",
                    price => '¥1588',
                    message => '我们追求的是没有最长只有更长！',
                    'id'=>303
                ],
                [

                    subject => "伊本造型",
                    coverpath => "../../images/recommend_img_05.png",
                    price => '¥198',
                    message => '伊本造型是由著名形象设计师杨进先生创办。',
                    'id'=>304
                ],
                [

                    subject => " 画对了妆，微微一笑颜值倍儿高！",
                    coverpath => "../../images/recommend_img_06.png",
                    price => '¥198',
                    message => '《微微一笑很倾城》的剧照简直美腻到不要不要的',
                    'id'=>305
                ]
            ],
            [
                [
                    artype => 'nails',
                    subject => "秋季自然特价美甲",
                    coverpath => "../../images/recommend_img_01.png",
                    price => '¥198',
                    message => '我们追求的是没有最长只有更长！',
                    'id'=>306
                ]
            ],
            [
                [
                    artype => 'beauty',
                    subject => "爱丽克EircParisSalon",
                    coverpath => "../../images/recommend_img_03.png",
                    price => '¥1588',
                    message => '我们追求的是没有最长只有更长！',
                    'id'=>307
                ],
                [
                    artype => 'beauty',
                    subject => " 画对了妆，微微一笑颜值倍儿高！",
                    coverpath => "../../images/recommend_img_06.png",
                    price => '¥198',
                    message => '《微微一笑很倾城》的剧照简直美腻到不要不要的',
                    'id'=>308
                ]
            ],
            [

                [
                    artype => 'hair',
                    subject => "伊本造型",
                    coverpath => "../../images/recommend_img_05.png",
                    price => '¥1588',
                    message => '伊本造型是由著名形象设计师杨进先生创办。',
                    'id'=>309
                ]
            ],
            [
                [
                    artype => 'eyelash',
                    subject => "睫毛稀疏 种睫毛来帮忙",
                    coverpath => "../../images/recommend_img_02.png",
                    price => '¥1888',
                    message => '我们追求的是没有最长只有更长！',
                    'id'=>401
                ]
            ]
        ];
        */
        $nav = pdo_getall("wq_service_nav",array('status'=>1,"uniacid"=>$uniacid),array('cid'),'',"sort DESC,createtime DESC");
        foreach ($nav as $key=>$val){
            if($val['cid'] == 999999){
                $tmpData= pdo_getall('wq_service',array('status'=>1,'uniacid'=>$uniacid,'recommend'=>1),array(),'','sort DESC,createtime DESC');
            }
            else{
                $tmpData = pdo_getall('wq_service',array('status'=>1,'uniacid'=>$uniacid,'cid'=>$val['cid']),array(),'','sort DESC,createtime DESC');
            }
            foreach ($tmpData as $kk=>$vv){
                $data[$key][$kk]['subject'] = $vv['name'];
                $data[$key][$kk]['coverpath'] = tomedia($vv['bimg']);
                $data[$key][$kk]['price'] = $vv['price'];
                $data[$key][$kk]['message'] = $vv['min_title'];
                $data[$key][$kk]['id'] = $vv['id'];
            }
        }
        echo json_encode(array("status"=>1,'msg'=>'返回成功',"data"=>$data));
    }

    /**
     * 服务详情
     */
    public function doPageServiceDetail(){
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $tid = (int)$_GPC['sid'];
        /*
        $data = [
            'id'=>$tid,
            'title'=>'秋季自然特价美甲222',
            'price'=>55.00,
            'bg'=>'../../images/banner_02.png',
            'min_des'=>'美甲是一种对指（趾）甲进行装饰美化的工作，又称甲艺设计。美甲是根据客人的手形、甲形、肤质、服装的色彩和要求，对指（趾）甲进行消毒、清洁、护理、保养、修饰美化的过程。具有表现形式多样化的特点。',
            'des'=>'一、涂指甲油之前要涂上指甲底油
                    二、不涂面油会让美甲面不堪一击
                    三、短甲小最好涂深色指甲油
                    四、美甲颜色要保持协调
                    五、不要小看修甲工具'

        ];
        */
        $data = pdo_get('wq_service', array('id' => $tid,'uniacid'=>$uniacid,'status'=>1));
        if($data){
            $data['bimg']=tomedia($data['bimg']);
            $data['imgs']=explode(",",$data['imgs']);
            $data['title'] = $data['name'];
            $data['min_des'] = $data['min_title'];
            $data['des'] = $data['content'];
            $data['bg'] = $data['bimg'];
        }
        echo json_encode(array("status"=>1,'msg'=>'返回成功',"data"=>$data));

    }

    /**
     * 技师列表
     */
    public function doPageTechnicianList(){
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $cid = (int)$_GPC['cid'];
        $limit = 20;
        $p = 1;
        $page = ($p-1) * $limit;
        /*
        $data = [
            [
                company => "西狮独品美容美发有限公司",
                avatar => "../../images/skilledt_img_01.png",
                nickname => '张技师',
                price => '¥500',
                message => '从事美发行业60余年，有丰富经验',
                distance => '100m',
                id=>101
            ],
            [
                company => "圆月亮美甲沙龙",
                avatar => "../../images/skilledt_img_02.png",
                nickname => '包技师',
                price => '¥800',
                message => '从事美发行业60余年，有丰富经验',
                distance => '200m',
                id=>102
            ]
        ];
        */
        //$server = pdo_getall('wq_service',array('status'=>1,'uniacid'=>$uniacid,'cid'=>$cid),array(),'','sort DESC,createtime DESC');
        $serviceTable = tablename('wq_service');
        $tTable = tablename('wq_service_technician');
        $storeTable = tablename('wq_service_store');
        $sql = "SELECT t.id as id,t.name AS nickname,store.name AS company,t.simg AS avatar,t.min_title AS message,store.address_id AS latlng ,store.address AS address
                FROM {$serviceTable} AS s 
                    LEFT JOIN {$tTable} AS t ON s.t_id = t.id 
                    LEFT JOIN {$storeTable} AS store ON t.store_id = store.id
                    WHERE s.uniacid = $uniacid and s.status=1 and s.cid=:cid GROUP BY t.id ORDER BY t.sort DESC LIMIT $page,$limit";
        $data = pdo_fetchall($sql, array(':cid'=>$cid));
        //echo $sql;
        foreach ($data as $key=>$val){
            $data[$key]['avatar'] = tomedia($val['avatar']);
        }
        echo json_encode(array("status"=>1,'msg'=>'返回成功',"data"=>$data));
    }

    /**
     * 获取用户信息
     */
    public function doPageUserAddress(){
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $uid = $_W['fans']['uid'];


        $list = [];
        $address = pdo_getall('mc_member_address', array('uniacid'=>$uniacid,'uid' => $uid), array());
        foreach ($address as $key=>$val){
            $list[$key]['addrid'] = $val['id'];
            $list[$key]['name'] = $val['username'];
            $list[$key]['phone'] = $val['mobile'];
            $list[$key]['province'] = $val['province'];
            $list[$key]['city'] = $val['city'];
            $list[$key]['area'] = $val['district'];
            $list[$key]['addr'] = $val['address'];
        }

        $data['uid'] = $uid;
        $data['openid'] = $_W['openid'];
        $data['nickname'] = $_W['nickname'];
        $data['name'] = '';
        $data['phone'] = '';
        $data['avatar'] = '';

        $data['addrs'] = $list;
        /*
        $data = [
            uid => '1',
            'openid'=>$openId,
            nickname => '山炮',
            name => '张三',
            phone => '13833337998',
            avatar => '../../images/avatar.png',
            addrs => [
                [
                    addrid => '1',
                    name => '张三',
                    phone => '13812314563',
                    province => '北京',
                    city => '直辖市',
                    area=>'朝阳区',
                    addr => '朝阳区望京悠乐汇A座8011'
                ],
                [
                    addrid => '2',
                    name => '李四',
                    phone => '13812314563',
                    province => '北京',
                    city => '直辖市',
                    area=>'朝阳区',
                    addr => '朝阳区望京悠乐汇A座4020'
                ]
            ]
        ];
        */

        echo json_encode(array("status"=>1,'msg'=>'返回成功',"data"=>$data));

    }

    /**
     * 获取服务分类
     */
    public function doPageCate(){
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $data=pdo_getall('wq_service_class',array('status'=>1,'uniacid'=>$uniacid),array('id','name'),'','sort DESC,createtime DESC');
        foreach ($data as $key=>$val){
            $data[$key]['title'] = $val['name'];
        }
        echo json_encode(array("status"=>1,'msg'=>'返回成功',"data"=>$data));
    }

    /**
     * 技师详情
     */
    public function doPageTechnicianDetail(){
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $tid = $_GPC['aid'];
        /*
        $data = [
            "list"=>[
                [
                    'title'=>'盐水沐足',
                    'price'=>251.00,
                    'id'=>201,
                    'tid'=>5,
                ],
                [
                    'title'=>'头部按摩',
                    'price'=>251.00,
                    'id'=>207,
                    'tid'=>5,
                ],
                [
                    'title'=>'背部按摩',
                    'price'=>251.00,
                    'id'=>209,
                    'tid'=>5,
                ],
            ],

            "info"=>[
                'tid'=>5,
                't_name'=>'王技师',
                'avatar'=>'../../images/skilledt_banner.png',
                'des'=>'高级美容师就是指美容师中技术能力更好，获得了高级美容师资格证的美容师。美容师是一种专业美容领域的职业称谓'
            ]
        ];
        */

        $list = pdo_getall('wq_service',array('status'=>1,'uniacid'=>$uniacid,'t_id'=>$tid),array(),'','sort DESC,createtime DESC');
        foreach ($list as $key=>$val){
            $data['list'][$key]['title'] = $val['name'];
            $data['list'][$key]['price'] = $val['price'];
            $data['list'][$key]['id'] = $val['id'];
            $data['list'][$key]['tid'] = $tid;
        }

        $info = pdo_get('wq_service_technician', array('id' => $tid,'uniacid'=>$uniacid,'status'=>1));
        $data['info']['tid'] = $info['id'];
        $data['info']['t_name'] = $info['name'];
        $data['info']['avatar'] = tomedia($info['simg']);
        $data['info']['banner'] = tomedia($info['bimg']);
        $data['info']['des'] = $info['content'];

        echo json_encode(array("status"=>1,'msg'=>'返回成功',"data"=>$data));
    }

    /**
     * 提交预约
     */
    public function doPageServiceOnline(){
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $sid = (int)$_GPC['sid'];
        $uid = $_W['fans']['uid'];
        $openid = $_W['fans']['openid'];
        $service_date = $_GPC['service_date'];
        $service_time = $_GPC['service_time'];
        $msg = $_GPC['msg'];

        $address_id = (int)$_GPC['address_id'];
        if($sid<=0){
            return json_encode(array("status"=>0,'msg'=>'缺少服务参数',"data"=>[]));
        }
        //判断当前用户未处理的预约数是否已经超过10个
        $countNum = pdo_getall('wq_online',array('status'=>0,'uniacid'=>$uniacid,'openid'=>$openid),array(),'','');
        if(count($countNum)>=10){
            return json_encode(array("status"=>0,'msg'=>'未处理预约过多',"data"=>[]));
        }

        $address = pdo_get('mc_member_address', array('uniacid'=>$uniacid,'uid' => $uid,'id'=>$address_id), array());
        $orderNo = function(){
            $yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
            return $yCode[intval(date('Y')) - 2011] . strtoupper(dechex(date('m'))) . date('d') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf('%02d', rand(0, 99));

        };
        $data['out_trade_no'] = $orderNo();
        $data['uniacid'] = $uniacid;
        $data['openid'] = $openid;
        $data['pid'] = $sid;
        $data['amount'] = '';
        $data['name'] = $address['username'];
        $data['mobile'] = $address['mobile'];
        $data['plan_date'] = $service_date.$service_time;
        $data['content'] = $msg;
        $data['wx_out_trade_no'] = '';
        $data['address'] = $address['province'].$address['city'].$address['district'].$address['address'];

       $res = pdo_insert('wq_online',$data);
        if($res){
            return json_encode(array("status"=>1,'msg'=>'提交成功',"data"=>[]));
        }
       return json_encode(array("status"=>0,'msg'=>'提交失败',"data"=>[]));


    }

    /**
     * 更新地址
     */
    public function doPageAddressUpdate(){
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $uid = $_W['fans']['uid'];
        $u_name = $_GPC['u_name'];
        $data_phone = $_GPC['data_phone'];
        $data_addr = $_GPC['data_addr'];
        $addressId = (int)$_GPC['aid'];
        if($addressId<=0){
            return json_encode(array("status"=>0,'msg'=>'出错了',"data"=>[]));
        }
        list($province,$city,$district) = explode(',',$_GPC['region']);
        $data = [
            'uniacid'=>$uniacid,
            'uid'=>$uid,
            'username'=>$u_name,
            'mobile'=>$data_phone,
            'province'=>$province,
            'city'=>$city,
            'district'=>$district,
            'address'=>$data_addr,
        ];
        $res = pdo_update('mc_member_address', $data, array('id' => $addressId,'uniacid'=>$uniacid));
        if($res){
            return json_encode(array("status"=>1,'msg'=>'更新成功',"data"=>[]));
        }
        return json_encode(array("status"=>0,'msg'=>'出错了',"data"=>[]));
    }

    /**
     * 增加地址
     */
    public function doPageAddressAdd(){
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $uid = $_W['fans']['uid'];
        $u_name = $_GPC['u_name'];
        $data_phone = $_GPC['data_phone'];
        $data_addr = $_GPC['data_addr'];
        list($province,$city,$district) = explode(',',$_GPC['region']);
        $data = [
            'uniacid'=>$uniacid,
            'uid'=>$uid,
            'username'=>$u_name,
            'mobile'=>$data_phone,
            'province'=>$province,
            'city'=>$city,
            'district'=>$district,
            'address'=>$data_addr,
            'zipcode'=>'000000',
            'isdefault'=>1,
        ];

        $address = pdo_get('mc_member_address', array('uniacid'=>$uniacid,'uid' => $uid,'is_default'=>1), array('id'));
        if($address['id']>0){
            pdo_update('mc_member_address', ['is_default'=>0], array('id' => $address['id'],'uniacid'=>$uniacid));
        }
        $res = pdo_insert('mc_member_address',$data);
        if($res){
            return json_encode(array("status"=>1,'msg'=>'添加成功',"data"=>[]));
        }
        return json_encode(array("status"=>0,'msg'=>'出错了',"data"=>[]));
    }

    /**
     * 获取当前用户预约数据
     */
    public function doPageOnline(){
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $uid = $_W['fans']['openid'];
        $limit = 100;
        $p = 1;
        $page = ($p-1) * $limit;
        $data = [];
        $onlieTable = tablename('wq_online');
        $serviceTable = tablename('wq_service');
        $technicianTable = tablename('wq_service_technician');
        $sql = "SELECT o.id,o.plan_date AS p_time,o.status,o.createtime AS create_time ,o.address ,s.name AS service_name ,s.bimg AS service_img ,t.name AS t_name ,t.simg AS t_img
                FROM {$onlieTable} AS o
                    LEFT JOIN {$serviceTable} AS s ON s.id = o.pid 
                    LEFT JOIN {$technicianTable} AS t ON t.id = s.t_id
                    WHERE o.uniacid = $uniacid  and o.openid=:cid GROUP BY o.id ORDER BY o.createtime DESC LIMIT $page,$limit";
        $data = pdo_fetchall($sql, array(':cid'=>$uid));

        $status = ['待接单','已接单','服务中','已完成','已拒绝'];

        if($data){
            foreach($data as $key=>$v){
                $data[$key]['service_img']=tomedia($v['service_img']);
                $data[$key]['t_img']=tomedia($v['t_img']);
                $data[$key]['status']=$status[$v['status']];
            }
        }

        return json_encode(array("status"=>1,'msg'=>'获取成功',"data"=>$data));

    }

    /**
     * 系统配置
     */
    public function doPageSiteConfig(){
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $config = [];
        $res=pdo_getall('wq_config',array('xkey'=>'web','uniacid'=>$uniacid));
        foreach ($res as $key=>$val){
            $list[$val['name']] = $val['content'];
        }

        $diy=pdo_getall('wq_config',array('xkey'=>'wxapp_diy','uniacid'=>$uniacid));
        foreach ($diy as $key=>$val){
            $list[$val['name']] = $val['content'];
        }

        $menuData=pdo_getall('wq_footmenu',array('uniacid'=>$uniacid,'m_status'=>1),array(),'',array('m_sort DESC,id DESC'));
        foreach ($menuData as $key=>$val){
            $list['menu'][$key]['text'] = $val['name'];
            $list['menu'][$key]['pagePath'] = '/'.$val['page_path'];
            $list['menu'][$key]['iconPath'] = tomedia($val['icon_path']);
            $list['menu'][$key]['selectedIconPath'] = tomedia($val['selected_icon_path']);
        }
        $list['nav'] = [];
        $nav = pdo_getall('wq_top_nav',array('uniacid'=>$uniacid,'m_status'=>1),array(),'','id DESC');
        foreach ($nav as $key=>$val){
            $list['nav'][$val['nav_name']]['nav_bg_color'] = empty($val['nav_bg_color'])?'':'#'.$val['nav_bg_color'];
            $list['nav'][$val['nav_name']]['nav_font_color'] = empty($val['nav_font_color'])?'':'#'.$val['nav_font_color'];
            $list['nav'][$val['nav_name']]['nav_title'] = $val['nav_title'];
            $list['nav'][$val['nav_name']]['nav_name'] = $val['nav_name'];
        }

        return json_encode(array("status"=>1,'msg'=>'获取成功',"data"=>$list));
    }

}