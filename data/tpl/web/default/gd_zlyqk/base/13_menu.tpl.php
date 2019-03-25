<?php defined('IN_IA') or exit('Access Denied');?><style>
    .layui-badge{
        height: 18px;
        text-align: center;
        border-radius: 9px;
        position: relative;
        display: inline-block;
        font-size: 12px;
        background-color: #FFB800;
        color: #fff;
        line-height: 18px;
        margin-top:12px;
        padding-left: 5px;
        padding-right: 5px;
        float: right;
    }
    .layui-nav-tree .layui-nav-child a{padding-left: 25px;}
</style>
<div class="navBar layui-side-scroll" style="height: 717px;">
        <ul class="layui-nav layui-nav-tree">
            <?php  if($_GPC['is_sys']==1) { ?>
            <li class="layui-nav-item doc-help" data-art="返回系统" data-cat="">
                <a href="<?php  echo url('platform/reply', array('m' => 'gd_zlyqk'))?>" >
                    <i class="layui-icon"></i>
                    <cite>返回系统</cite>
                </a>
            </li>
            <?php  } ?>
            <?php  if($accList['data_manager']) { ?>
            <li class="layui-nav-item doc-help" data-art="" data-cat="流转中心">
                <a href="javascript:;">
                    <i class="layui-icon">&#xe629;</i>
                    <cite>流转中心</cite>
                    <span class="layui-nav-more"></span>
                </a>
                <dl class="layui-nav-child">
                    <?php  if($accList['all_plan']) { ?>
                    <dd class="doc-help" data-art="数据池列表" data-cat="流转中心">
                        <a href="javascript:;" id="all_data"  data-url="<?php  echo $this->createWebUrl('list',array('tb'=>'pool'))?>&status=-1&ac=all_plan">
                            <i class="layui-icon" >&#xe621;</i>
                            <cite>数据池列表</cite>
                        </a>
                    </dd>
                    <?php  } ?>
                    <?php  if($accList['wait_plan']) { ?>
                    <dd  class="doc-help" data-art="待处理列表" data-cat="流转中心">
                        <a href="javascript:;" id="wait_data" data-url="<?php  echo $this->createWebUrl('list',array('tb'=>'pool'))?>&status=5&ac=wait_plan">
                            <i class="layui-icon" >&#xe621;</i>
                            <cite>待处理列表</cite>
                        </a>
                    </dd>
                    <?php  } ?>
                    <?php  if($accList['fi_plan']) { ?>
                    <dd class="doc-help" data-art="已处理列表" data-cat="流转中心">
                        <a href="javascript:;" id="end_data" data-url="<?php  echo $this->createWebUrl('list',array('tb'=>'pool'))?>&status=10&ac=fi_plan">
                            <i class="layui-icon" >&#xe621;</i>
                            <cite>已处理列表</cite>
                        </a>
                    </dd>
                    <?php  } ?>
                    <?php  if($accList['do_plan']) { ?>
                    <!--<dd class="doc-help" data-art="流程中列表" data-cat="流转中心">-->
                        <!--<a href="javascript:;" data-url="<?php  echo $this->createWebUrl('list',array('tb'=>'pool'))?>&status=1&ac=do_plan">-->
                            <!--<i class="layui-icon" >&#xe621;</i>-->
                            <!--<cite>流程中列表</cite>-->
                        <!--</a>-->
                    <!--</dd>-->
                    <?php  } ?>
                    <?php  if($accList['fina_plan']) { ?>
                    <dd class="doc-help" data-art="已完成列表" data-cat="流转中心">
                        <a href="javascript:;" id="fina_data" data-url="<?php  echo $this->createWebUrl('list',array('tb'=>'pool'))?>&status=2&ac=fina_plan">
                            <i class="layui-icon" >&#xe621;</i>
                            <cite>已完成列表</cite>
                        </a>
                    </dd>
                    <?php  } ?>
                    <?php  if($accList['end_plan']) { ?>
                    <dd class="doc-help" data-art="已终止记录" data-cat="流转中心">
                        <a href="javascript:;"  id="abort_data" data-url="<?php  echo $this->createWebUrl('list',array('tb'=>'pool'))?>&status=6&ac=end_plan">
                            <i class="layui-icon" >&#xe621;</i>
                            <cite>已终止记录</cite>
                        </a>
                    </dd>
                    <?php  } ?>
                    <?php  if($accList['form_plan']) { ?>
                    <dd class="doc-help" data-art="表单提交数据" data-cat="流转中心">
                        <a href="javascript:;" data-url="<?php  echo $this->createWebUrl('list',array('tb'=>'pool'))?>&status=100&ac=form_plan">
                            <i class="layui-icon" >&#xe621;</i>
                            <cite>表单提交数据</cite>
                        </a>
                    </dd>
                    <?php  } ?>
                </dl>
            </li>
            <?php  } ?>
            <?php  if($accList['staff_manager']) { ?>
            <li class="layui-nav-item doc-help"  data-art="" data-cat="员工管理">
                <a href="javascript:;">
                    <i class="layui-icon" >&#xe612;</i>
                    <cite>员工管理</cite>
                    <span class="layui-nav-more"></span>
                </a>
                <dl class="layui-nav-child">
                    <?php  if($accList['admin']) { ?>
                    <dd class="doc-help" data-art="员工列表" data-cat="员工管理">
                        <a href="javascript:;" data-url="<?php  echo $this->createWebUrl('list',array('tb'=>'admin'))?>">
                            <i class="layui-icon" >&#xe621;</i>
                            <cite>员工列表</cite>
                        </a>
                    </dd>
                    <?php  } ?>
                    <?php  if($accList['department']) { ?>
                    <dd class="doc-help" data-art="部门管理" data-cat="员工管理">
                        <a href="javascript:;" data-url="<?php  echo $this->createWebUrl('list',array('tb'=>'department'))?>">
                            <i class="layui-icon" >&#xe621;</i>
                            <cite>部门管理</cite>
                        </a>
                    </dd>
                    <?php  } ?>
                    <?php  if($accList['acc']) { ?>
                    <dd class="doc-help" data-art="权限管理" data-cat="员工管理">
                        <a href="javascript:;" data-url="<?php  echo $this->createWebUrl('list',array('tb'=>'acc'))?>">
                            <i class="layui-icon" >&#xe621;</i>
                            <cite>权限管理</cite>
                        </a>
                    </dd>
                    <?php  } ?>
                    <?php  if($accList['staffin']) { ?>
                    <dd class="doc-help" data-art="入驻申请" data-cat="员工管理">
                        <a href="javascript:;" data-url="<?php  echo $this->createWebUrl('list',array('tb'=>'staffext'))?>">
                            <i class="layui-icon" >&#xe621;</i>
                            <cite>入驻申请</cite>
                        </a>
                    </dd>
                    <?php  } ?>
                </dl>
            </li>
            <?php  } ?>

            <?php  if($accList['member_manager']) { ?>
            <li class="layui-nav-item doc-help" data-art="" data-cat="会员管理">
                <a href="javascript:;">
                    <i class="layui-icon" data-icon=""></i>
                    <cite>会员管理</cite>
                    <span class="layui-nav-more"></span>
                </a>
                <dl class="layui-nav-child">
                    <?php  if($accList['member']) { ?>
                    <dd class="doc-help" data-art="会员列表" data-cat="会员管理">
                        <a href="javascript:;" data-url="<?php  echo $this->createWebUrl('list',array('tb'=>'member'))?>">
                            <i class="layui-icon" >&#xe621;</i>
                            <cite>会员列表</cite>
                        </a>
                    </dd>
                    <?php  } ?>
                    <?php  if($accList['label']) { ?>
                    <dd class="doc-help" data-art="会员组列表" data-cat="会员管理">
                        <a href="javascript:;" data-url="<?php  echo $this->createWebUrl('list',array('tb'=>'label'))?>">
                            <i class="layui-icon" >&#xe621;</i>
                            <cite>会员组列表</cite>
                        </a>
                    </dd>
                    <?php  } ?>
                </dl>
            </li>
            <?php  } ?>
            <?php  if($accList['app_manager']) { ?>
            <li class="layui-nav-item doc-help" data-art="" data-cat="应用管理">
                <a href="javascript:;">
                    <i class="layui-icon" >&#xe60f;</i>
                    <cite>应用管理</cite>
                    <span class="layui-nav-more"></span>
                </a>
                <dl class="layui-nav-child">
                    <?php  if($accList['app']) { ?>
                    <dd class="doc-help" data-art="应用列表" data-cat="应用管理">
                        <a href="javascript:;" data-url="<?php  echo $this->createWebUrl('list',array('tb'=>'app'))?>">
                            <i class="layui-icon" >&#xe621;</i>
                            <cite>应用列表</cite>
                        </a>
                    </dd>
                    <?php  } ?>
                    <?php  if($accList['category']) { ?>
                    <dd class="doc-help" data-art="应用分类" data-cat="应用管理">
                        <a href="javascript:;" data-url="<?php  echo $this->createWebUrl('list',array('tb'=>'category'))?>">
                            <i class="layui-icon" >&#xe621;</i>
                            <cite>应用分类</cite>
                        </a>
                    </dd>
                    <?php  } ?>
                    <?php  if($accList['property']) { ?>
                    <!--<dd class="doc-help" data-art="应用级别" data-cat="应用管理">-->
                        <!--<a href="javascript:;" data-url="<?php  echo $this->createWebUrl('list',array('tb'=>'property'))?>">-->
                            <!--<i class="layui-icon" >&#xe621;</i>-->
                            <!--<cite>应用级别</cite>-->
                        <!--</a>-->
                    </dd>
                    <?php  } ?>
                    <?php  if($accList['flow']) { ?>
                    <dd class="doc-help" data-art="流程列表" data-cat="应用管理">
                        <a href="javascript:;" data-url="<?php  echo $this->createWebUrl('list',array('tb'=>'flow'))?>">
                            <i class="layui-icon" >&#xe621;</i>
                            <cite>流程列表</cite>
                        </a>
                    </dd>
                    <?php  } ?>
                </dl>
            </li>
            <?php  } ?>
            <?php  if($accList['zl_manager']) { ?>
            <li class="layui-nav-item doc-help" data-art="" data-cat="资料管理">
                <a href="javascript:;">
                    <i class="layui-icon">&#xe622;</i>
                    <cite>资料管理</cite>
                    <span class="layui-nav-more"></span>
                </a>

                <dl class="layui-nav-child">
                    <?php  if($accList['zftj']) { ?>
                    <dd class="doc-help" data-art="支付统计" data-cat="资料管理">
                        <a href="javascript:;" data-url="<?php  echo $this->createWebUrl('list',array('tb'=>'order'))?>">
                            <i class="layui-icon" >&#xe621;</i>
                            <cite>支付统计</cite>
                        </a>
                    </dd>
                    <?php  } ?>
                    <?php  if($accList['wztj']) { ?>
                    <dd class="doc-help" data-art="位置统计" data-cat="资料管理">
                        <a href="javascript:;" data-url="<?php  echo $this->createWebUrl('location')?>">
                            <i class="layui-icon" >&#xe621;</i>
                            <cite>位置统计</cite>
                        </a>
                    </dd>
                    <?php  } ?>
                    <?php  if($accList['sjcx']) { ?>
                    <dd class="doc-help" data-art="数据查询" data-cat="资料管理">
                        <a href="javascript:;" data-url="<?php  echo $this->createWebUrl('list',array('tb'=>'datas'))?>">
                            <i class="layui-icon" >&#xe621;</i>
                            <cite>数据查询</cite>
                        </a>
                    </dd>
                    <?php  } ?>
                    <?php  if($accList['hbgl']) { ?>
                    <dd class="doc-help" data-art="红包管理" data-cat="资料管理">
                        <a href="javascript:;" data-url="<?php  echo $this->createWebUrl('list',array('tb'=>'hb'))?>">
                            <i class="layui-icon" >&#xe621;</i>
                            <cite>红包管理</cite>
                        </a>
                    </dd>
                    <?php  } ?>
                    <?php  if($accList['xlm']) { ?>
                    <dd class="doc-help" data-art="序列码" data-cat="资料管理">
                        <a href="javascript:;" data-url="<?php  echo $this->createWebUrl('list',array('tb'=>'code'))?>">
                            <i class="layui-icon" >&#xe621;</i>
                            <cite>序列码</cite>
                        </a>
                    </dd>
                    <?php  } ?>
                    <?php  if($accList['fjgl']) { ?>
                    <dd class="doc-help" data-art="附件管理" data-cat="资料管理">
                        <a href="javascript:;" data-url="<?php  echo $this->createWebUrl('list',array('tb'=>'fj'))?>">
                            <i class="layui-icon" >&#xe621;</i>
                            <cite>附件管理</cite>
                        </a>
                    </dd>
                    <?php  } ?>
                    <?php  if($accList['gqrw']) { ?>
                    <dd class="doc-help" data-art="过期任务" data-cat="过期任务">
                        <a href="javascript:;" data-url="<?php  echo $this->createWebUrl('list',array('tb'=>'gq'))?>">
                            <i class="layui-icon" >&#xe621;</i>
                            <cite>过期任务</cite>
                        </a>
                    </dd>
                    <?php  } ?>
                    <?php  if($accList['ldsj']) { ?>
                    <dd class="doc-help" data-art="联动数据" data-cat="资料管理">
                        <a href="javascript:;" data-url="<?php  echo $this->createWebUrl('list',array('tb'=>'ld'))?>">
                            <i class="layui-icon" >&#xe621;</i>
                            <cite>联动数据</cite>
                        </a>
                    </dd>
                    <?php  } ?>
                    <?php  if($accList['create_order']) { ?>
                    <li class="layui-nav-item doc-help" data-art="创数据单" data-cat="">
                        <a href="javascript:;" data-url="<?php  echo $this->createWebUrl('addPool')?>">
                            <i class="layui-icon">&#xe62d;</i>
                            <cite>创数据单</cite>
                        </a>
                    </li>
                    <?php  } ?>
                </dl>
            </li>
            <?php  } ?>
            <?php  if($accList['index_setting']) { ?>
            <li class="layui-nav-item doc-help" data-art="" data-cat="首页设置">
                <a href="javascript:;">
                    <i class="layui-icon" >&#xe638;</i>
                    <cite>首页设置</cite>
                    <span class="layui-nav-more"></span>
                </a>
                <dl class="layui-nav-child">
                    <?php  if($accList['ad_set']) { ?>
                    <dd class="doc-help" data-art="广告管理" data-cat="首页设置">
                        <a href="javascript:;" data-url="<?php  echo $this->createWebUrl('list',array('tb'=>'ad'))?>&ac=ad_set">
                            <i class="layui-icon" >&#xe621;</i>
                            <cite>广告管理</cite>
                        </a>
                    </dd>
                    <?php  } ?>
                    <?php  if($accList['cat_set']) { ?>
                    <dd class="doc-help" data-art="分类菜单" data-cat="首页设置">
                        <a href="javascript:;" data-url="<?php  echo $this->createWebUrl('list',array('tb'=>'mu'))?>&ac=cat_set">
                            <i class="layui-icon" >&#xe621;</i>
                            <cite>分类菜单</cite>
                        </a>
                    </dd>
                    <?php  } ?>
                </dl>
            </li>
            <?php  } ?>
            <?php  if($accList['notice_manager']) { ?>
            <li class="layui-nav-item doc-help" data-art="" data-cat="最新公告">
                <a href="javascript:;">
                    <i class="layui-icon" >&#xe611;</i>
                    <cite>最新公告</cite>
                    <span class="layui-nav-more"></span>
                </a>
                <dl class="layui-nav-child">
                    <?php  if($accList['article']) { ?>
                    <dd class="doc-help" data-art="公告列表" data-cat="最新公告">
                        <a href="javascript:;" data-url="<?php  echo $this->createWebUrl('list',array('tb'=>'article'))?>">
                            <i class="layui-icon" >&#xe621;</i>
                            <cite>公告列表</cite>
                        </a>
                    </dd>
                    <?php  } ?>
                </dl>
            </li>
            <?php  } ?>
            <!--<li class="layui-nav-item ">-->
                <!--<a href="javascript:;">-->
                    <!--<i class="layui-icon" >&#xe646;</i>-->
                    <!--<cite>我的插件</cite>-->
                    <!--<span class="layui-nav-more"></span>-->
                <!--</a>-->
                <!--<dl class="layui-nav-child">-->
                    <!--<dd>-->
                        <!--<a href="javascript:;" data-url="<?php  echo $this->createWebUrl('havePlugin')?>">-->
                            <!--<i class="layui-icon" >&#xe621;</i>-->
                            <!--<cite>插件列表</cite>-->
                        <!--</a>-->
                    <!--</dd>-->
                <!--</dl>-->
            <!--</li>-->
            <?php  if($accList['system_manager']) { ?>
            <li class="layui-nav-item doc-help" data-art="" data-cat="系统设置">
                <a href="javascript:;">
                    <i class="layui-icon" >&#xe614;</i>
                    <cite>系统设置</cite>
                    <span class="layui-nav-more"></span>
                </a>
                <dl class="layui-nav-child">
                    <?php  if($accList['register_set']) { ?>
                    <dd class="doc-help" data-art="注册设置" data-cat="系统设置">
                        <a href="javascript:;" data-url="<?php  echo $this->createWebUrl('list',array('tb'=>'setting','group'=>8))?>&ac=register_set" >
                            <i class="layui-icon" >&#xe621;</i>
                            <cite>注册设置</cite>
                        </a>
                    </dd>
                    <?php  } ?>
                    <?php  if($accList['mset']) { ?>
                    <dd class="doc-help" data-art="菜单设置" data-cat="系统设置">
                        <a href="javascript:;" data-url="<?php  echo $this->createWebUrl('list',array('tb'=>'menu'))?>" >
                            <i class="layui-icon" >&#xe621;</i>
                            <cite>菜单设置</cite>
                        </a>
                    </dd>
                    <?php  } ?>
                    <?php  if($accList['msg_set']) { ?>
                    <dd class="doc-help" data-art="消息设置" data-cat="系统设置">
                        <a href="javascript:;" data-url="<?php  echo $this->createWebUrl('list',array('tb'=>'setting','group'=>2))?>&ac=msg_set" >
                            <i class="layui-icon" >&#xe621;</i>
                            <cite>消息设置</cite>
                        </a>
                    </dd>
                    <?php  } ?>
                    <?php  if($accList['sms_set']) { ?>
                    <dd class="doc-help" data-art="短信设置" data-cat="系统设置">
                        <a href="javascript:;" data-url="<?php  echo $this->createWebUrl('list',array('tb'=>'setting','group'=>7))?>&ac=sms_set" >
                            <i class="layui-icon" >&#xe621;</i>
                            <cite>短信设置</cite>
                        </a>
                    </dd>
                    <?php  } ?>
                    <?php  if($accList['save_set']) { ?>
                    <dd class="doc-help" data-art="存储设置" data-cat="系统设置">
                        <a href="javascript:;" data-url="<?php  echo $this->createWebUrl('list',array('tb'=>'setting','group'=>3))?>&ac=save_set">
                            <i class="layui-icon" >&#xe621;</i>
                            <cite>存储设置</cite>
                        </a>
                    </dd>
                    <?php  } ?>
                    <?php  if($accList['page_set']) { ?>
                    <dd class="doc-help" data-art="页面设置" data-cat="系统设置">
                        <a href="javascript:;" data-url="<?php  echo $this->createWebUrl('list',array('tb'=>'setting','group'=>5))?>&ac=lang_set">
                            <i class="layui-icon" >&#xe621;</i>
                            <cite>页面设置</cite>
                        </a>
                    </dd>
                    <?php  } ?>
                    <?php  if($accList['link_set']) { ?>
                    <dd class="doc-help" data-art="系统链接" data-cat="系统设置">
                        <a href="javascript:;" data-url="<?php  echo $this->createWebUrl('list',array('tb'=>'setting','group'=>110))?>&ac=lang_set">
                            <i class="layui-icon" >&#xe621;</i>
                            <cite>系统链接</cite>
                        </a>
                    </dd>
                    <?php  } ?>
                </dl>
            </li>
            <?php  } ?>
            <?php  if($_W['isfounder']==1) { ?>
            <?php  if($_GPC['__api']==0) { ?>
            <li class="layui-nav-item doc-help " data-art="" data-cat="云端管理">
                <a href="javascript:;">
                    <i class="layui-icon">&#xe62e;</i>
                    <cite>云端管理</cite>
                    <span class="layui-nav-more"></span>
                </a>
                <dl class="layui-nav-child">
                    <dd class="doc-help" data-art="微擎账号" data-cat="云端管理">
                        <a href="javascript:;" data-url="<?php  echo $this->createWebUrl('wqBd')?>">
                            <i class="layui-icon" >&#xe621;</i>
                            <cite>微擎账号</cite>
                        </a>
                    </dd>
                    <!--<dd>-->
                        <!--<a href="javascript:;" data-url="<?php  echo $this->createWebUrl('shop')?>&ac=shop_down">-->
                            <!--<i class="layui-icon" >&#xe621;</i>-->
                            <!--<cite>市场下载</cite>-->
                        <!--</a>-->
                    <!--</dd>-->
                    <!--<dd>-->
                        <!--<a href="javascript:;" data-url="<?php  echo $this->createWebUrl('pluginList')?>">-->
                            <!--<i class="layui-icon" >&#xe621;</i>-->
                            <!--<cite>插件管理</cite>-->
                        <!--</a>-->
                    <!--</dd>-->
                    <dd class="doc-help" data-art="市场注册" data-cat="云端管理">
                        <a href="javascript:;" data-url="<?php  echo $this->createWebUrl('list',array('tb'=>'setting','group'=>9))?>&ac=shop_register">
                            <i class="layui-icon" >&#xe621;</i>
                            <cite>市场注册</cite>
                        </a>
                    </dd>
                    <!--<dd>-->
                        <!--<a href="javascript:;" data-url="<?php  echo $this->createWebUrl('systemUpdate')?>&ac=system_update">-->
                            <!--<i class="layui-icon" >&#xe621;</i>-->
                            <!--<cite>系统修复</cite>-->
                        <!--</a>-->
                    <!--</dd>-->
                </dl>
            </li>
            <?php  } ?>
            <?php  } ?>
            <span class="layui-nav-bar" style="top: 202.5px; height: 0px; opacity: 0;"></span>
        </ul>
    </div>
<script>
    function click(act){
        $("#"+act).trigger("click");
    }
</script>
