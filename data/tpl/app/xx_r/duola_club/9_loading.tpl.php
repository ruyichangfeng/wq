<?php defined('IN_IA') or exit('Access Denied');?><?php  if($school['is_comload']) { ?>
<?php  
$comad = pdo_fetch("select * from " . tablename($this->table_banners) . " where id = :id And weid = :weid ", array(":id" => $school['is_comload'], ":weid" => $weid));
?>
<?php  if($comad['begintime']<TIMESTAMP && $comad['endtime']>TIMESTAMP && $comad['enabled'] ==1) { ?>
<div id="loadingDiv" style="position: fixed; top: 0; bottom: 0; width: 100%; left: 0; background-color: #fff; z-index: 999999; display: block;">
    <div class="ajax_loading" style="display: box; display: -webkit-box; -webkit-box-orient: vertical; -webkit-box-pack: center; -webkit-box-align: center; width: 100%; height: 100%;">
        <img style="width: 38%; display: block;" src="<?php  echo tomedia($comad['thumb'])?>">
    </div>
</div>
<script>
    setTimeout(loadDelay, 1000);
    function loadDelay() {
        var loadingMask = document.getElementById('loadingDiv');
        loadingMask.style.display = "none";

    }
</script>
<?php  } ?>
<?php  } ?>