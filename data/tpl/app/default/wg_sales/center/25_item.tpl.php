<?php defined('IN_IA') or exit('Access Denied');?><script id="tpl" type="text/html">
    <%for(var i in list){%>
    <li>
        <a href="<%if(list[i].status==1){%>
        <?php  echo $this->createMobileUrl('detail');?>&category_id=<%=list[i].category_id%>&id=<%=list[i].article_id%>
        <%}%>">
        <div class="swipe-box">
            <div class="list-con">
                <p class="ad-tit"><%=list[i].title%></p>
                <div >
                    <!-- em标签有三种颜色，默认、红色、黄色 -->
                    <span>状态：<em style="font:inherit;" class="list-status-red">
                        <%if(list[i].status==0){%>
                        审核中
                        <%}else if(list[i].status==1){%>
                        通过
                        <%}else if(list[i].status==2){%>
                        拒绝
                        <%}%>
                    </em></span>
                    <!--<span>浏览量：<em style="font:inherit;">1000</em></span>-->
                    <!--<span>稿费：<em class="list-status-yellow">+8.00</em></span>-->
                </div>
            </div>
            <button class="list-del-btn" id="<%=list[i].id%>">删除</button>
        </div>
        </a>
    </li>
<%}%>
</script>
                    