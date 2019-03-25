<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
    <link href="https://cdn.bootcss.com/bootstrap-table/1.10.1/bootstrap-table.min.css" rel="stylesheet">
    <link href="https://cdn.bootcss.com/bootstrap-sweetalert/1.0.1/sweetalert.min.css" rel="stylesheet">
    <script src="https://cdn.bootcss.com/bootstrap-table/1.10.1/bootstrap-table.min.js"></script>
    <script src="https://cdn.bootcss.com/bootstrap-table/1.10.1/extensions/mobile/bootstrap-table-mobile.min.js"></script>
    <script src="https://cdn.bootcss.com/bootstrap-table/1.10.1/locale/bootstrap-table-zh-CN.min.js"></script>
    <script src="https://cdn.bootcss.com/bootstrap-sweetalert/1.0.1/sweetalert.min.js"></script>
    <ul class="we7-page-tab">
        <?php  if(is_array($opList)) { foreach($opList as $index => $item) { ?>
            <?php  if($item['active'] == 1) { ?>
                <li class="active"><?php  echo $item['title'];?></li>
            <?php  } else { ?>
                <li><a href="<?php  echo $item['url'];?>"><?php  echo $item['title'];?></a></li>
            <?php  } ?>
        <?php  } } ?>
    </ul>
    <div class="main">
        <table id="table" class=""
               data-classes="table table-condensed table-hover table-striped"
               data-undefined-text="-"
               data-toggle="table"
               data-sort-name="id"
               data-sort-order="desc"
               data-query-params="queryparams"
               data-page-number="1"
               data-page-size="15"
               data-mobile-responsive="true"
               data-show-refresh="true"
               data-show-toggle="true"
               data-pagination="true"
               data-side-pagination="client"
               data-search="true"
               data-search-on-enter-key="true"
               data-trim-on-search="true"
               data-show-fullscreen="true"
        >
            <thead>
                <tr>
                    <th data-checkbox="true" data-field="id"></th>
                    <th>产品名</th>
                    <th>图片</th>
                    <th>排序</th>
                    <th>状态</th>
                    <th>最后更新</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <?php  if(is_array($dataList)) { foreach($dataList as $index => $item) { ?>
                    <tr>
                        <td></td>
                        <td><?php  echo $item['name'];?></td>
                        <td>
                            <img src="/attachment/<?php  echo $item['img'];?>" style="max-height: 50px;" alt="">
                        </td>
                        <td><?php  echo $item['sort'];?></td>
                        <td><?php  echo $item['status'];?></td>
                        <td><?php  echo $item['update_time'];?></td>
                        <td>
                            <a href="<?php  echo $item['edit_url'];?>" class="btn btn-xs btn-primary">编辑</a>
                            <a href="<?php  echo $item['del_url'];?>" class="btn btn-xs btn-danger _btn-del">删除</a>
                        </td>
                    </tr>
                <?php  } } ?>
            </tbody>
        </table>
    </div>
    <script>
        $(function(){
            $('._btn-del').click(function(){
                var _href=$(this).attr('href');swal({title:'提示',text:'确认要删除么?',type:'warning',showCancelButton:true,confirmButtonClass:'btn-danger',confirmButtonText:'确认',cancelButtonText:'取消',closeOnConfirm:false},function(){location.href=_href});return false;
            });
        });
    </script>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>