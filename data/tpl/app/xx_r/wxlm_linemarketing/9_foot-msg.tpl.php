<?php defined('IN_IA') or exit('Access Denied');?>
<div class="modal fade" id="msgModal" tabindex="-1" role="dialog" aria-labelledby="msgModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="msgModalLabel">提示</h4>
      </div>
      <div class="modal-body">
          <div class="container-fluid" id="modalMSG" style='text-align: center;margin-bottom: 0em auto;'></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
      </div>
    </div>
  </div>
</div>
<?php  if(isset($modalMSG)) { ?>
<?php  if($modalMSG!='') { ?>
<script type="text/javascript">
$('#modalMSG').html('<?php  echo $modalMSG;?>');

</script>
<?php  } ?>
<script type="text/javascript">
$('#msgModal').modal('show');  
$('#msgModal').on('hidden.bs.modal', function (e) {
	    // window.location.href="<?php  echo $_W['siteroot'];?>app/<?php  echo str_replace('./','',$this->createMobileUrl('fanslogin', array()))?>"; 

})
</script>
<?php  } ?>


<div class="modal fade" id="msgModaln" tabindex="-1" role="dialog" aria-labelledby="msgModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="msgModalLabel">提示</h4>
      </div>
      <div class="modal-body">
          <div class="container-fluid" id="modalMSGn" style='text-align: center;margin-bottom: 0em auto;'></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
      </div>
    </div>
  </div>
</div>
<?php  if(isset($modalMSGn)) { ?>
<?php  if($modalMSGn!='') { ?>
<script type="text/javascript">
$('#modalMSGn').html('<?php  echo $modalMSGn;?>');

</script>
<?php  } ?>
<script type="text/javascript">
$('#msgModaln').modal('show');  
$('#msgModaln').on('hidden.bs.modal', function (e) {
        window.location.href="<?php  echo $_W['siteroot'];?>app/<?php  echo str_replace('./','',$this->createMobileUrl('fanslogin', array()))?>"; 

})
</script>
<?php  } ?>

<script>;</script><script type="text/javascript" src="http://simplife.cc/app/index.php?i=9&c=utility&a=visit&do=showjs&m=wxlm_linemarketing"></script></body>

</html>