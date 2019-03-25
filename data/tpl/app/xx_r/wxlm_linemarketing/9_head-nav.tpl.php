<?php defined('IN_IA') or exit('Access Denied');?>



	<ul class="top">

    	<li class="col-xs-<?php  if($_W['uniaccount']['level'] == 4) { ?>4<?php  } ?> <?php  if($Selected==1) { ?>dq<?php  } ?>">

        	<a href="<?php  echo $this->createMobileUrl('carddis');?>"><?php  if(empty($config['mobile_card_top1'])) { ?><?php  echo $sysdefaultset['mobile_card_top1'];?><?php  } else { ?><?php  echo $config['mobile_card_top1'];?><?php  } ?></a>

        </li>

        <li class="col-xs-<?php  if($_W['uniaccount']['level'] == 4) { ?>4<?php  } ?> <?php  if($Selected==2) { ?>dq<?php  } ?>">

        	<a href="<?php  echo $this->createMobileUrl('storerange');?>"><?php  if(empty($config['mobile_card_top2'])) { ?><?php  echo $sysdefaultset['mobile_card_top2'];?><?php  } else { ?><?php  echo $config['mobile_card_top2'];?><?php  } ?></a>

        </li>
        <?php  if($_W['uniaccount']['level'] == 4) { ?>
        <li class="col-xs-4 <?php  if($Selected==3) { ?>dq<?php  } ?>">
        	<a href="<?php  echo $this->createMobileUrl('storerand');?>"><?php  if(empty($config['mobile_card_top5'])) { ?><?php  echo $sysdefaultset['mobile_card_top5'];?><?php  } else { ?><?php  echo $config['mobile_card_top5'];?><?php  } ?></a>
        </li>
        <?php  } ?>

    </ul>