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



////以下为测试号专用
//define('APP_ID','wx03393af10613da23');
//define('APP_SECRET','40751854901cc489eddd055538224e8a');
//define('WEIXIN_ID','gh_964192c927cb');
//define('MCH_ID','now is null');
//define('KEY','now is null');
//define("TOKEN", "godlee");
//define('DOMAIN',"ashtonmall");
//define('NOTIFY_URL',"now is null");
//define("DB_NAME","ashton_db");
//define("DB_USER","aston_db_manager");
//define("DB_PSW","c6cychNznJWGhQC8");
//$mypath = $_SERVER['DOCUMENT_ROOT'] . '/'.DOMAIN;   //用于直接部署


define('ADMIN','admin');
define('PASSWORD','admin');
//测试号
define('APP_ID','wx03393af10613da23');
define('APP_SECRET','40751854901cc489eddd055538224e8a');
define('WEIXIN_ID','gh_964192c927cb');
//承天
//define('APP_ID','wxe351f7bfd5b5e2a6');
//define('APP_SECRET','1eb1e0701b845f183ff2843fcddb4b7e');
//define('WEIXIN_ID','gh_bc1d700f0582');

define("TOKEN", "godlee");
define('DOMAIN',"/pafd_msg");
define('NOTIFY_URL',"now is null");
define('DB_IP','localhost');
define("DB_NAME","pafd_msg_db");
define("DB_USER","pafd_manageer");
define("DB_PSW","drfM6q7XyTtDMPde");
$mypath = $_SERVER['DOCUMENT_ROOT'] .DOMAIN;   //用于直接部署

include_once $mypath . '/includes/magicquotes.inc.php';
include_once $mypath . '/includes/db.inc.php';
include_once $mypath . '/includes/helpers.inc.php';
include_once $mypath.'/includes/db.class.php';
include_once $mypath . '/includes/pafd.php';
header("Content-Type:text/html; charset=utf-8");