<?php
include_once('rcache.php');

$uid = 1111113;
$redis = new Rcache();
$redis->set(REDISC_GROUP_VIP_MSG . $uid, 10);
var_dump($redis->get(REDISC_GROUP_VIP_MSG . $uid));

