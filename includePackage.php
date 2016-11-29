<?php
//以下为测试公众号用
//define('APP_ID','wx03393af10613da23');
//define('APP_SECRET','40751854901cc489eddd055538224e8a');
//define('WEIXIN_ID','gh_964192c927cb');
//define('MCH_ID','now is null');
//define('KEY','now is null');
//define("TOKEN", "godlee");
//define('DOMAIN',"mmzrb");
//define('NOTIFY_URL',"now is null");
//define("DB_NAME","gshop_db");
//define("DB_USER","gshopUser");
//define("DB_PSW","cT9vVpxBLQaFQYrh");
//$mypath = $_SERVER['DOCUMENT_ROOT'] . '/'.DOMAIN;   //用于直接部署




define('ADMIN','admin');
define('PASSWORD','admin');
define("TOKEN", "godlee");
//测试号
//define('APP_ID','wx03393af10613da23');
//define('APP_SECRET','40751854901cc489eddd055538224e8a');
//define('WEIXIN_ID','gh_964192c927cb');
//define('DOMAIN',"/pafd_msg");
//define('DB_IP','localhost');
//define("DB_NAME","pafd_msg_db");
//define("DB_USER","pafd_manageer");
//define("DB_PSW","drfM6q7XyTtDMPde");

//三北武装
define('APP_ID','wx129c8ca8e941b363');
define('APP_SECRET','e1b4156dfe4e0b514601c0f8077f253f ');
define('WEIXIN_ID','gh_24f814827d29');
define('DOMAIN',"/rmwzb");
define('DB_IP','localhost');
define("DB_NAME","wechat_rmwzb");
define("DB_USER","wechat_rmwzb");
define("DB_PSW","F6w6m3s6");
$mypath = $_SERVER['DOCUMENT_ROOT'] .DOMAIN;   //用于直接部署
include_once $mypath . '/includes/magicquotes.inc.php';
include_once $mypath . '/includes/db.inc.php';
include_once $mypath . '/includes/helpers.inc.php';
include_once $mypath.'/includes/db.class.php';
include_once $mypath . '/includes/pafd.php';
header("Content-Type:text/html; charset=utf-8");