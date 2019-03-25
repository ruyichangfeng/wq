<?php defined('IN_IA') or exit('Access Denied');?><script src="<?php echo STATIC_ROOT;?>/js/jquery-1.11.1.min.js"></script>
<script src="<?php echo STATIC_ROOT;?>/js/template.min.js"></script>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('public/more_new', TEMPLATE_INCLUDEPATH)) : (include template('public/more_new', TEMPLATE_INCLUDEPATH));?>
<script>

var url = "<?php  echo $this->createMobileUrl('center',['_wg' => 'more'])?>";
var del_url = "<?php  echo $this->createMobileUrl('center',['_wg' => 'del'])?>";
initLoadingData_new(true, url+'&cate=1', 1, $('#tpl').html(), 'list-data',swipe_box);
$(function () {

    $('.ad-tab li').click(function () {
        $('.ad-tab li').removeClass('active');
        $(this).addClass('active');
        initLoadingData_new(true, url+'&cate='+$(this).attr('data-cate'), 1, $('#tpl').html(), 'list-data', swipe_box);
    });

    $('#list-data').delegate(".list-del-btn", "click", function() {
        var dom_in = $(this);
        var id = dom_in.attr('data-id');


    });
})
</script>