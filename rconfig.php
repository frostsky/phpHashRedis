<?php 
define('ENVIRONMENT', 'development');
 
// 所有redis key需要在这里配置下
const REDISC_FANS_LIST           = 'fans:'; // 粉丝列表
const REDISC_IP_INFO             = 'ipinfo:ip'; // 用户登录时的IP信息 存放在默认服务器
const REDISC_NICKNAMETOUID       = 'cnu:';  // 用户UID的关系
const REDISC_COMMENT_LIST        = 'comment:list';  // 首页最新评论列表
