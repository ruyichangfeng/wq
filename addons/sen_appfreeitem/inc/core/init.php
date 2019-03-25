<?php

/*
初始化文件
用于加载扩展类，和数据库操作
*/
// 扩展


require_once dirname(__FILE__).'/Exception/Function.php';
require_once dirname(__FILE__).'/Exception/S.class.php';
require_once dirname(__FILE__).'/Exception/Filter.class.php';
require_once dirname(__FILE__).'/Exception/Notice.class.php';
require_once dirname(__FILE__).'/Exception/Vip.class.php';
require_once dirname(__FILE__).'/Exception/ChatRobot.class.php';
require_once dirname(__FILE__).'/Exception/Forbid.class.php';

// 数据库操作
require_once dirname(__FILE__).'/Model/Defriend.model.php';
require_once dirname(__FILE__).'/Model/Member.model.php';
require_once dirname(__FILE__).'/Model/Admin.model.php';
require_once dirname(__FILE__).'/Model/ChatroomLog.model.php';
require_once dirname(__FILE__).'/Model/ChatroomDefriend.model.php';
require_once dirname(__FILE__).'/Model/Chatroom.model.php';
require_once dirname(__FILE__).'/Model/Growth.model.php';
require_once dirname(__FILE__).'/Model/Credit.model.php';
require_once dirname(__FILE__).'/Model/Album.model.php';
require_once dirname(__FILE__).'/Model/Comment.model.php';
require_once dirname(__FILE__).'/Model/Settings.model.php';
require_once dirname(__FILE__).'/Model/Chat.model.php';
require_once dirname(__FILE__).'/Model/ChatMessage.model.php';
require_once dirname(__FILE__).'/Model/Moments.model.php';

