<?php
$sql =<<<EOF
DROP TABLE IF EXISTS `ims_newfootball_baoming`;
DROP TABLE IF EXISTS `ims_newfootball_matches`;
DROP TABLE IF EXISTS `ims_newfootball_players`;
DROP TABLE IF EXISTS `ims_newfootball_teams`;
DROP TABLE IF EXISTS `ims_newfootball_groups`;
EOF;
pdo_run($sql);
