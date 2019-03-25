<?php defined('IN_IA') or exit('Access Denied');?>    <div class="m-search">
        <form id="form_search" method="get" action="./index.php">
        			<input type="hidden" name="c" value="entry"/>
        			<input type="hidden" name="i" value="<?php  echo $_W['uniacid'];?>"/>
        			<input type="hidden" name="m" value="numa_vote"/>
        			<input type="hidden" name="do" value="index"/>
        			<input type="hidden" name="id" value="<?php  echo $activity['id'];?>"/>
		            <div class="search-input">
		                <input type="text" name="keyword" id="search" placeholder="请输入选手编号或姓名投票...">
		            </div> 
		            <div class="btn-search">
		               <a href="javascript:void(0)" class="btn-search" onclick="$('#form_search').submit()"><img src="<?php  echo $this->staticPath?>/app/images/search.png"></a>
		            </div>
        </form>
    </div>
    <!--m-search--> 
    <!--m-menu-->
    <div class="m-menu">
        <div class="col-3 f-fl menu-list ">
            <a href="<?php  echo $index_url;?>" <?php  if((($_GPC['do']!='sponsor') && $_GPC['do']=='index' && $operation!='rank' && $operation!='myvote' ) || ($_GPC['do']=='item' && $operation=='info')) { ?> class="cur"<?php  } ?>>参赛选手</a>
        </div>
         <div class="col-3 f-fl menu-list">
	            <a href="<?php  echo $myvote_url;?>"  <?php  if($_GPC['do']=='index' && $operation=='myvote') { ?>class="cur"<?php  } ?>>我的投票</a>
	     </div> 
        <div class="col-3 f-fl menu-list">
            <a href="<?php  echo $rank_url;?>" <?php  if($_GPC['do']=='index' && $operation=='rank') { ?>class="cur"<?php  } ?> >排行榜</a>
        </div>  
    </div>
    <!--m-menu--> 