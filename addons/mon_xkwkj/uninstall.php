<?php
if ($_GET['debug'] == 1) {
	require '../../framework/bootstrap.inc.php';
}
pdo_query("DROP TABLE IF EXISTS ".tablename('mon_xkwkj').";");
pdo_query("DROP TABLE IF EXISTS ".tablename('mon_xkwkj_user').";");
pdo_query("DROP TABLE IF EXISTS ".tablename('mon_xkwkj_firend').";");
pdo_query("DROP TABLE IF EXISTS ".tablename('mon_xkwkj_order').";");
pdo_query("DROP TABLE IF EXISTS ".tablename('mon_xkwkj_setting').";");
pdo_query("DROP TABLE IF EXISTS ".tablename('mon_xkwkj_index_setting').";");
pdo_query("DROP TABLE IF EXISTS ".tablename('mon_xkwkj_user_info').";");
pdo_query("DROP TABLE IF EXISTS ".tablename('mon_xkwkj_address').";");
pdo_query("DROP TABLE IF EXISTS ".tablename('mon_xkwkj_ppts').";");
pdo_query("DROP TABLE IF EXISTS ".tablename('mon_xkwkj_category').";");
pdo_query("DROP TABLE IF EXISTS ".tablename('mon_xkwkj_reply').";");
pdo_query("DROP TABLE IF EXISTS ".tablename('mon_xkwkj_goods').";");
pdo_query("DROP TABLE IF EXISTS ".tablename('mon_xkwkj_template').";");
pdo_query("DROP TABLE IF EXISTS ".tablename('mon_xkwkj_poster').";");
pdo_query("DROP TABLE IF EXISTS ".tablename('mon_xkwkj_poster_setting').";");

pdo_query("DROP TABLE IF EXISTS ".tablename('mon_xkwkj_tj_record').";");





