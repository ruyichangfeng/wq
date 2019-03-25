<?php

//待客下带
$appList=$this->getAppList();
$memberInfo = $this->findMemberInfo();
include $this->template("ad_pool");