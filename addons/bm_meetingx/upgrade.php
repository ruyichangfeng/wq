<?php
//V1.1
if(!pdo_fieldexists('bm_meetingx_reply', 'paytype')) {  
	pdo_query("ALTER TABLE ".tablename('bm_meetingx_reply')." ADD `paytype` int(1) NOT NULL DEFAULT 0;");
}
//V10.1定制版
if(!pdo_fieldexists('bm_meetingx_reply', 'templateid1title')) {  
	pdo_query("ALTER TABLE ".tablename('bm_meetingx_reply')." ADD `templateid1title` varchar(100) NOT NULL DEFAULT '';");
}
if(!pdo_fieldexists('bm_meetingx_reply', 'templateid1msg')) {  
	pdo_query("ALTER TABLE ".tablename('bm_meetingx_reply')." ADD `templateid1msg` varchar(100) NOT NULL DEFAULT '';");
}