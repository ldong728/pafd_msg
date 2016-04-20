<?php
include_once 'includePackage.php';
include_once 'wechat/serveManager.php';
include_once 'wechat/cardManager.php';
session_start();

$temp=pdoQuery('notice_tbl',null,null,null);
$temp=$temp->fetch();



echo '404 notFound';
exit;
?>
