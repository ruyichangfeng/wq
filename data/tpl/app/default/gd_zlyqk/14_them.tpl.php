<?php defined('IN_IA') or exit('Access Denied');?><style>
    <?php  if($them['bg']) { ?>
        .them-page{background-image:url('/<?php  echo $them['bg'];?>') ;background-size:100%;}
    <?php  } ?>
    <?php  if($them['top']) { ?>
        .them-tab{padding-top:<?php  echo $them['top'];?>px ;padding-bottom:100px; }
    <?php  } ?>
    <?php  if($them['margin']) { ?>
    .them-cell{margin-bottom:<?php  echo $them['margin'];?>px  }
    <?php  } ?>
    <?php  if($them['radius']) { ?>
    .them-cell{border-radius:<?php  echo $them['radius'];?>px  }
    <?php  } ?>
    <?php  if($them['width']) { ?>
    .them-tab{width:<?php  echo $them['width'];?> ;display:block;margin:0 auto }
    <?php  } ?>
    <?php  if(isset($them['border']) && $them['border']==0) { ?>
    .them-cell:before{border:0 ;}
    <?php  } else { ?>
    .them-cell:before{border-top: 1px solid #e5e5e5;}
    <?php  } ?>
    <?php  if($them['body']) { ?>
    .them-cell{color:<?php  echo $them['body'];?>}
    .them-color{color:<?php  echo $them['body'];?>}
    <?php  } ?>
    <?php  if($them['title']) { ?>
    .them-title{color:<?php  echo $them['title'];?> ;}
    <?php  } ?>
    <?php  if($them['title']) { ?>
    .them-title{color:<?php  echo $them['title'];?> ;}
    <?php  } ?>
    <?php  if($them['them']) { ?>
    .weui-btn_primary{background:<?php  echo $them['them'];?>}
    .weui-cells_radio .weui-check:checked + .weui-icon-checked:before{color:<?php  echo $them['them'];?>}
    .weui-cells_checkbox .weui-check:checked + .weui-icon-checked:before{color:<?php  echo $them['them'];?>}
    .weui-agree__checkbox:checked:before{color:<?php  echo $them['them'];?>}
    <?php  } ?>
</style>
