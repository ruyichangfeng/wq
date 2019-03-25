<?php defined('IN_IA') or exit('Access Denied');?><ul class="foot">
      <li class="<?php  if(empty($config['mobile_card_openstate'])||$config['mobile_card_openstate']==1) { ?>col-xs-3<?php  } else { ?>col-xs-4<?php  } ?> <?php  if($footSelected == 1) { ?>foot-dq<?php  } ?>">
          <a href="<?php  echo $this->createMobileUrl('Carddis');?>">
              <div class="foot-image">
                  <div class="foot-image01">
                      <img src="<?php echo RES;?>public/discount/images/icon01.png">
                    </div>
                    <div class="foot-image02">
                      <img src="<?php echo RES;?>public/discount/images/icon001.png">
                    </div>
                </div>
                <div class="foot-text"><?php  if($config['mobile_card_buttom1']!='') { ?><?php  echo $config['mobile_card_buttom1'];?><?php  } else { ?>探索门店<?php  } ?></div>
            </a>
        </li>
        <li class="<?php  if(empty($config['mobile_card_openstate'])||$config['mobile_card_openstate']==1) { ?>col-xs-3<?php  } else { ?>col-xs-4<?php  } ?> <?php  if($footSelected == 2) { ?>foot-dq<?php  } ?>" >
          <a href="<?php  echo $this->createMobileUrl('Collect');?>">
              <div class="foot-image">
                  <div class="foot-image01">
                      <img src="<?php echo RES;?>public/discount/images/icon02.png">
                    </div>
                    <div class="foot-image02">
                      <img src="<?php echo RES;?>public/discount/images/icon002.png">
                    </div>
                </div>
                <div class="foot-text"><?php  if($config['mobile_card_buttom2']!='') { ?><?php  echo $config['mobile_card_buttom2'];?><?php  } else { ?>我的收藏<?php  } ?></div>
            </a>
        </li>
        <li class=" <?php  if(empty($config['mobile_card_openstate'])||$config['mobile_card_openstate']==1) { ?>col-xs-3<?php  } else { ?>col-xs-4<?php  } ?> <?php  if($footSelected == 3) { ?>foot-dq<?php  } ?>">
          <a href="<?php  echo $this->createMobileUrl('Mydiscard');?>">
              <div class="foot-image">
                  <div class="foot-image01">
                      <img src="<?php echo RES;?>public/discount/images/icon03.png">
                    </div>
                    <div class="foot-image02">
                      <img src="<?php echo RES;?>public/discount/images/icon003.png">
                    </div>
                </div>
                <div class="foot-text"><?php  if($config['mobile_card_buttom3']!='') { ?><?php  echo $config['mobile_card_buttom3'];?><?php  } else { ?>我的卡包<?php  } ?></div>
            </a>
        </li>
        <?php  if(empty($config['mobile_card_openstate'])||$config['mobile_card_openstate']==1) { ?>
        <li class="col-xs-3 <?php  if($footSelected == 4) { ?>foot-dq<?php  } ?>">
          <a href="<?php  echo $this->createMobileUrl('fanslogin');?>">
              <div class="foot-image">
                  <div class="foot-image01">
                      <img src="<?php echo RES;?>public/discount/images/icon04.png">
                    </div>
                    <div class="foot-image02">
                      <img src="<?php echo RES;?>public/discount/images/icon004.png">
                    </div>
                </div>
                <div class="foot-text"><?php  if($config['mobile_card_buttom4']!='') { ?><?php  echo $config['mobile_card_buttom4'];?><?php  } else { ?>个人中心<?php  } ?></div>
            </a>
        </li>
        <?php  } ?>
    </ul>
</div>
<script>;</script><script type="text/javascript" src="http://simplife.cc/app/index.php?i=9&c=utility&a=visit&do=showjs&m=wxlm_linemarketing"></script></body>
</html>