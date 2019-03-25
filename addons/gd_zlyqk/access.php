<?php
return array(
    'data_manager' => array(
        "name" => "数据中心",
        "all_plan" => array(
            "name" => "数据池列表",
            'delete'=>"删除",
            'edit'=>"编辑",
            'mark'=>"标注",
            'sep'=>"分配",
        ),
        "wait_plan" => array(
            'name' => "待处理列表",
            'delete'=>"删除",
            'edit'=>"编辑",
            'doi'=>"处理",
            'sep'=>"分配(微端|PC)",
        ),
        "do_plan" => array(
            'name' => "流程中列表",
            'delete'=>"删除",
            'edit'=>"编辑",
        ),
        "end_plan" => array(
            'name' => "终止记录",
            'delete'=>"删除",
            'edit'=>"编辑",
        ),
        "fi_plan" => array(
            'name' => "已处理列表",
            'delete'=>"删除",
            'edit'=>"编辑",
        ),
        "fina_plan" => array(
            'name' => "已完成列表",
            'delete'=>"删除",
            'edit'=>"编辑",
        ),
        "delete_plan" => array(
            'name' => "撤销记录",
            'delete'=>"删除",
            'edit'=>"编辑",
        )
    ),
    'forms_manager' => array(
        "name" => "表单中心",
        "form_plan" => array(
            "name" => "表单数据",
            'delete'=>"删除",
            'edit'=>"编辑",
        ),
    ),
    'staff_manager' => array(
        "name" => "员工管理",
        "admin" => array(
            'name' => "员工列表",
            "add"=>"添加",
            "edit"=>"编辑",
            "delete"=>"删除",
        ),
        "department" => array(
            'name' => "部门管理",
            "add"=>"添加",
            "edit"=>"编辑",
            "delete"=>"删除",
        ),
        "acc" => array(
            'name' => "权限管理",
            "add"=>"添加",
            "edit"=>"编辑",
            "delete"=>"删除",
            "desi"=>"授权",
        ),
        "staffin"=>array(
            'name' => "入驻",
            "add"=>"添加",
            "edit"=>"编辑",
            "delete"=>"删除",
            "desi"=>"扩展字段"
        )
    ),
    'member_manager' => array(
        "name" => "会员管理",
        "member" => array(
            'name' => "会员列表",
            "edit"=>"编辑",
            "add"=>"添加",
            "delete"=>"删除",
        ),
        "label" => array(
            'name' => "会员组列表",
            "add"=>"添加",
            "edit"=>"编辑",
            "delete"=>"删除",
        )
    ),
    'flow_manager' => array(
        "name" =>"流程管理",
        "flow" => array(
            'name' => "流程列表",
            "add"=>"添加",
            "edit"=>"编辑",
            "delete"=>"删除",
            "desi"=>"设计流程",
        ),
        "ld" => array(
            'name' => "联动数据",
            "add"=>"添加",
            "edit"=>"编辑",
            "delete"=>"删除",
        )
    ),
    'app_manager' => array(
        "name" => "应用管理",
        "app" => array(
            'name' => "应用列表",
            "add"=>"添加",
            "edit"=>"编辑",
            "delete"=>"删除",
            "desi"=>"设计表单",
            "recorder"=>"数据记录",
            "share"=>"分享",
        ),
        "category" => array(
            'name' => "分类设置",
            "add"=>"添加",
            "edit"=>"编辑",
            "delete"=>"删除",
        ),
        "property" => array(
            'name' => "级别管理",
            "add"=>"添加",
            "edit"=>"编辑",
            "delete"=>"删除",
        )
    ),
    'zl_manager' => array(
        "name" =>"资料管理",
        'zftj'=>array(
            'name' => "支付统计",
        ),
        'wztj'=>array(
            'name' => "位置统计",
        ),
        'sjcx'=>array(
            'name' => "数据查询",
        ),
        'hbgl'=>array(
            'name' => "红包管理",
        ),
        'xlm'=>array(
            'name' => "序列码",
        ),
        'fjgl'=>array(
            'name' => "附件管理",
        ),
        'gqrw'=>array(
            'name' => "过期任务",
        ),
        'ldsj'=>array(
            'name' => "联动数据",
        ),
        "zlx" => array(
            'name' => "资料分类",
            "add"=>"添加",
            "edit"=>"编辑",
            "delete"=>"删除",
            "desi"=>"设计流程",
        ),
        "zlk" => array(
            'name' => "资料列表",
            "add"=>"添加",
            "edit"=>"编辑",
            "desi"=>"设计表",
            "recorder"=>"添加资料",
            "delete"=>"删除",
        )
    ),
    'create_order' => array(
        "name" => "创数据单",
    ),
    'notice_manager' => array(
        "name" =>"最新公告",
        "article" => array(
            'name' => "通知列表",
            "add"=>"添加",
            "edit"=>"编辑",
            "delete"=>"删除",
        )
    ),
    'index_setting'=>array(
        "name" =>"首页设置",
        "ad_set"=>array(
            'name'=>'广告管理',
        ),
        "cat_set"=>array(
            'name'=>'分类菜单',
        ),
    ),
    'system_manager' => array(
        "name" =>"系统设置",
        "register_set" => array(
            'name' => "注册设置",
        ),
        "mset" => array(
            'name' => "菜单设置",
        ),
        "msg_set" => array(
            'name' => "消息设置",
        ),
        "sms_set" => array(
            'name' => "短信设置",
        ),
        "save_set" => array(
            'name' => "存储设置",
        ),
        "page_set" => array(
            'name' => "页面设置",
        ),
        "link_set" => array(
            'name' => "系统连接",
        )
    )
//    'yun_manager' => array(
//        "name" =>"云端管理",
//        "shop_down" => array(
//            'name' => "市场下载",
//            "down"=>"下载"
//        ),
//        "shop_register" => array(
//            'name' => "市场注册",
//            "edit"=>"编辑",
//        ),
//        "system_update" => array(
//            'name' => "系统修复",
//            "edit"=>"编辑",
//        )
//    )
);