<?php


if (!pdo_fieldexists('jfb_setting', 'footerimg')) {
	pdo_query("ALTER TABLE " . tablename('jfb_setting') . " add `footerimg` varchar(500);");
}
if (!pdo_fieldexists('jfb_setting', 'footerCopyright')) {
	pdo_query("ALTER TABLE " . tablename('jfb_setting') . " add `footerCopyright` varchar(300);");
}
if (!pdo_fieldexists('jfb_setting', 'appid')) {
	pdo_query("ALTER TABLE " . tablename('jfb_setting') . " add `appid` varchar(200) DEFAULT '';");
}
if (!pdo_fieldexists('jfb_setting', 'appsecret')) {
	pdo_query("ALTER TABLE " . tablename('jfb_setting') . " add `appsecret` varchar(200) DEFAULT '';");
}

if (!pdo_fieldexists('jfb_jifenlist', 'weid')) {
	pdo_query("ALTER TABLE " . tablename('jfb_jifenlist') . " add `weid` int(11) NOT NULL;");
}
if (!pdo_fieldexists('jfb_jifenlist', 'ruleid')) {
	pdo_query("ALTER TABLE " . tablename('jfb_jifenlist') . " add `ruleid` int(11) NOT NULL;");
}
if (!pdo_fieldexists('jfb_jifenlist', 'codetype')) {
	pdo_query("ALTER TABLE " . tablename('jfb_jifenlist') . " add `codetype` int(11) DEFAULT '0';");
}

if (!pdo_fieldexists('jfb_mendian', 'number')) {
	pdo_query("ALTER TABLE " . tablename('jfb_mendian') . " add `number` int(11);");
}
if (!pdo_fieldexists('jfb_mendian', 'numtime')) {
	pdo_query("ALTER TABLE " . tablename('jfb_mendian') . " add `numtime` int(10);");
}
if (!pdo_fieldexists('jfb_mendian', 'addyue')) {
	pdo_query("ALTER TABLE " . tablename('jfb_mendian') . " add `addyue` int(11) NOT NULL;");
}


if (!pdo_fieldexists('jfb_jifenjilu', 'bzcon')) {
	pdo_query("ALTER TABLE " . tablename('jfb_jifenjilu') . " add `bzcon` text(0);");
}
if (!pdo_fieldexists('jfb_jifenjilu', 'codetype')) {
	pdo_query("ALTER TABLE " . tablename('jfb_jifenjilu') . " add `codetype` int(11) DEFAULT '0';");
}


$sql = "
CREATE TABLE IF NOT EXISTS `ims_jfb_zqsetting` (
`id` int(10) NOT NULL AUTO_INCREMENT,
`weid` int(10) NOT NULL,
`template` varchar(200) NOT NULL,
`msgcon` varchar(500) NOT NULL,
`turl` varchar(300),
`tbottom` varchar(300),
PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
";
		
pdo_run($sql);

$sqlcz = "
CREATE TABLE IF NOT EXISTS `ims_jfb_jifencz` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`weid` int(11) NOT NULL,
`mendian` int(10) NOT NULL,
`number` int(10) NOT NULL,
`numtime` int(10) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
";
pdo_run($sqlcz);


if (!pdo_fieldexists('jfb_zqsetting', 'turl')) {
	pdo_query("ALTER TABLE " . tablename('jfb_zqsetting') . " add `turl` varchar(300);");
}

if (!pdo_fieldexists('jfb_zqsetting', 'tbottom')) {
	pdo_query("ALTER TABLE " . tablename('jfb_zqsetting') . " add `tbottom` varchar(300);");
}
