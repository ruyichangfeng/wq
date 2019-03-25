<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<link rel="stylesheet" href="<?php echo MODULE_URL;?>static/takeout/css/iconfont/iconfont.css">
<ul class="nav nav-tabs">
    <li class="active"><a href="<?php  echo  $this->createWebUrl('commentlist', array('foo'=>''));?>">评论列表</a></li>
</ul>

<div class="clearfix">
	<div class="search">
            <form action="index.php" method="get">
            <input type="hidden" name="c" value="site" />
            <input type="hidden" name="a" value="entry" />
            <input type="hidden" name="do" value="commentlist" />
            <input type="hidden" name="foo" value="index" />
            <input type="hidden" name="m" value="xm_gohome" />
            <table width="861" class="table table-bordered tb">
                <tbody>
                    <tr>
                      <td>
                    	<?php  echo tpl_form_field_daterange('time', $gettime);?>
					  </td>
                      <td>
                      	<button class="btn pull-right span2"><i class="icon-search icon-large"></i> 搜索</button>
                      </td>
                    </tr>
                    
                </tbody>
            </table>
            </form>
        </div>   
        
    <div class="panel panel-default">
    	<div class="panel-heading">
            评论列表
        </div>
        <?php  if($list[0]['id'] == '') { ?>
        <div class="tx-c">暂无数据</div>
        <?php  } else { ?>
        <div class="table-responsive panel-body" style="overflow:visible;">
            <table class="table table-hover">
            	<thead>
                	<tr class="active">
                    	<td>评论人昵称</td>
                        <td>所属类别</td>
                        <td>员工姓名</td>
                        <td>星数</td>
                        <td>评论内容</td>
                        <td>评论时间</td>
                        <td>操作</td>
                    </tr>
                </thead>
                <tbody>
                	<?php  if(is_array($list)) { foreach($list as $val) { ?>
                	<tr>
                    	<td>
                        	<p class="form-control-static"><?php  echo $this->getMemberInfo($val['openid'], 'nickname')?></p>
                        </td>
                        <td>
                            <p class="form-control-static">
                            <?php  if($val['type'] == 'takeout') { ?>
                            外卖评论
                            <?php  } else { ?>
                            服务评论
                            <?php  } ?>
                            </p>
                        </td>
                        <td>
							<p class="form-control-static"><?php  echo $this->getStaffInfo($val['staff_id'],'staff_name')?></p>
                        </td>
						<td>
							<p class="form-control-static">
                            <?php  if($val['xing']==1) { ?>
                            <i class="iconfont icon-pingjiaxingxing ulev0 t-org"></i>
                        	<?php  } ?>
                            <?php  if($val['xing']==1) { ?>
                            <i class="iconfont icon-pingjiaxingxing ulev0 t-org"></i>
                        	<i class="iconfont icon-pingjiaxingxing ulev0 t-org"></i>
                        	<?php  } ?>
                            <?php  if($val['xing']==3) { ?>
                            <i class="iconfont icon-pingjiaxingxing ulev0 t-org"></i>
                        	<i class="iconfont icon-pingjiaxingxing ulev0 t-org"></i>
                        	<i class="iconfont icon-pingjiaxingxing ulev0 t-org"></i>
                            <?php  } ?>
                            <?php  if($val['xing']==4) { ?>
                            <i class="iconfont icon-pingjiaxingxing ulev0 t-org"></i>
                        	<i class="iconfont icon-pingjiaxingxing ulev0 t-org"></i>
                        	<i class="iconfont icon-pingjiaxingxing ulev0 t-org"></i>
                        	<i class="iconfont icon-pingjiaxingxing ulev0 t-org"></i>
                        	<?php  } ?>
                            <?php  if($val['xing']==5) { ?>
                            <i class="iconfont icon-pingjiaxingxing ulev0 t-org"></i>
                        	<i class="iconfont icon-pingjiaxingxing ulev0 t-org"></i>
                        	<i class="iconfont icon-pingjiaxingxing ulev0 t-org"></i>
                        	<i class="iconfont icon-pingjiaxingxing ulev0 t-org"></i>
                        	<i class="iconfont icon-pingjiaxingxing ulev0 t-org"></i>
                            <?php  } ?>
                            </p>
                        </td>
                        <td>
							<p class="form-control-static"><?php  echo $val['comment'];?></p>
                        </td>
                        <td>
							<p class="form-control-static"><?php  echo $val['addtime'];?></p>
                        </td>
                        <td style="overflow:visible;">
                        	<div class="btn-group btn-group-sm">
                                <a class="btn btn-default" href="<?php  echo $this->createWebUrl('commentlist', array('foo'=>'delete','id'=>$val['id']))?>" onClick="return confirm('确认删除该条评论?');"><i class="fa fa-remove"></i> 删除</a>
                            </div>
                        </td>
                    </tr>
                    <?php  } } ?>
                    
                </tbody>
            </table>
        </div>
        
        <div class="panel-body text-center">
            <?php  echo $pager;?>
        </div>
        <?php  } ?>
        
    </div>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>