<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
    <li><a href="<?php  echo  $this->createWebUrl('company', array('foo'=>'index'));?>">公司管理</a></li>
    <li class="active"><a href="">审核公司信息</a></li>
</ul>

<div class="clearfix">    
    <form id="theform" class="form form-horizontal" action="<?php  echo $this->createWebUrl('company', array('foo'=>'shengok'));?>" method="post">
    <input type="hidden" name="id" value="<?php  echo $item['id'];?>" /> 
	
    <div class="panel panel-default">
        <div class="panel-heading">
            审核公司信息[公司名称：<?php  echo $item['company_name'];?>]
        </div>
		
        <div class="panel-body">
			<ul class="ub-f1 uinn8 c-wh">
				<?php  if($item['license'] != '') { ?>
                <div class="uba b-bla01 uc-a15 ub ub-ac umar-b" style="padding:0.2rem 0">
					<div class="ub-f1 ub ub-ver ubl ubr b-bla01" style=" padding:0.3rem 0.5rem">
						<div class="ub ub-ac">
							<div class="ulev-4 t-sbla">营业执照注册码：<?php  echo $item['license'];?></div>
						</div>
						<div class="ulev-4 t-gra" style="padding:0.3rem 0">
							<?php  if(substr($item['license_pic'],0,6) == 'images') { ?>
                            <a href="<?php  echo $_W['attachurl'];?><?php  echo $item['license_pic'];?>" target="_parent">
                                <img src="<?php  echo $_W['attachurl'];?><?php  echo $item['license_pic'];?>" style="width:150px; height:150px;">
                            </a>
                            <?php  } else { ?>
                            <a href="<?php  echo $_W['attachurl'];?>gohome/license/<?php  echo $item['license_pic'];?>" target="_parent">
                                <img src="<?php  echo $_W['attachurl'];?>gohome/license/<?php  echo $item['license_pic'];?>" style="width:150px; height:150px;">
                            </a>
                            <?php  } ?>
						</div>
					</div>
				</div>
                <?php  } ?>
                        
                <?php  if(is_array($list)) { foreach($list as $vo) { ?>
                    <div class="uba b-bla01 uc-a15 ub ub-ac umar-b" style="padding:0.2rem 0">
						<div class="ub-f1 ub ub-ver ubl ubr b-bla01" style=" padding:0.3rem 0.5rem">
								<div class="ub ub-ac">
									<div class="ulev-4 t-sbla"><?php  echo $vo['card_name'];?></div>
								</div>
								<div class="ulev-4 t-gra" style="padding:0.3rem 0">
                                    <?php  if(substr($vo['pic1'],0,6) == 'images') { ?>
                                    <a href="<?php  echo $_W['attachurl'];?><?php  echo $vo['pic1'];?>" target="_parent">
										<img src="<?php  echo $_W['attachurl'];?><?php  echo $vo['pic1'];?>" style="width:150px; height:150px;">
                                    </a>
                                    <?php  } else { ?>
                                    <a href="<?php  echo $_W['attachurl'];?>gohome/cardpic/<?php  echo $vo['pic1'];?>" target="_parent">
										<img src="<?php  echo $_W['attachurl'];?>gohome/cardpic/<?php  echo $vo['pic1'];?>" style="width:150px; height:150px;">
                                    </a>
                                    <?php  } ?>
                                    
                                    <?php  if($vo['pic2'] != '') { ?>
                                        <?php  if(substr($vo['pic2'],0,6) == 'images') { ?>
                                        <a href="<?php  echo $_W['attachurl'];?><?php  echo $vo['pic12'];?>" target="_parent">
                                            <img src="<?php  echo $_W['attachurl'];?><?php  echo $vo['pic2'];?>" style="width:150px; height:150px;">
                                        </a>
                                        <?php  } else { ?>
                                        <a href="<?php  echo $_W['attachurl'];?>gohome/cardpic/<?php  echo $vo['pic2'];?>" target="_parent">
                                            <img src="<?php  echo $_W['attachurl'];?>gohome/cardpic/<?php  echo $vo['pic2'];?>" style="width:150px; height:150px;">
                                        </a>
                                        <?php  } ?>
                                    <?php  } ?>    
                                    
                                    <?php  if($vo['pic3'] != '') { ?>
                                 		<?php  if(substr($vo['pic3'],0,6) == 'images') { ?>
                                        <a href="<?php  echo $_W['attachurl'];?><?php  echo $vo['pic3'];?>" target="_parent">
                                            <img src="<?php  echo $_W['attachurl'];?><?php  echo $vo['pic3'];?>" style="width:150px; height:150px;">
                                        </a>
                                        <?php  } else { ?>
                                        <a href="<?php  echo $_W['attachurl'];?>gohome/cardpic/<?php  echo $vo['pic3'];?>" target="_parent">
                                            <img src="<?php  echo $_W['attachurl'];?>gohome/cardpic/<?php  echo $vo['pic3'];?>" style="width:150px; height:150px;">
                                        </a>
                                        <?php  } ?>
                                    <?php  } ?>     
							    </div>
						</div>
				    </div>
                <?php  } } ?>
				</ul>
			
			</div>
            
			<div class="panel-body">
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">上传证件名称</label>
                    <div class="col-sm-9 col-xs-12">
                        <input type="text" name="card_all" id="card_all" value="<?php  echo $card_v;?>" class="form-control">
                        <span class="help-block">文本框中数据为已添加的证件，不要清除，请继续添加，多个证件以半角逗号分割</span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">备注说明</label>
                        <div class="col-sm-9 col-xs-12">
                            <textarea name="shuoming" id="shuoming" class="form-control"></textarea>
                            <span class="help-block"></span>
                        </div>
                </div>
                
				<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">审核</label>
                    <div class="col-sm-9 col-xs-12">
                    	<div>
                            <label class="radio-inline">
                                <input type="radio" name="flag" value="1" checked >通过
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="flag" value="0">不通过
                            </label>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
                    <div class="col-md-2 col-lg-1">
                        <input name="submit" type="submit" value="保存" class="btn btn-primary btn-block" />
                        <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
                    </div>
                </div>
				
            </div>
			
			<div class="panel-heading"></div>
            <div class="panel-body">
				<span style="color:red;"> </span>
			</div>
        </div>
    </form>
</div>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>