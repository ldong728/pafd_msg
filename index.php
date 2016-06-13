<?php
include_once 'includePackage.php';
include_once 'wechat/serveManager.php';
include_once 'wechat/cardManager.php';
session_start();

if(isset($_GET['share'])){
    $groupid=$_GET['share'];
    setcookie('group_id',$_GET['share'],time()+172800);
    header('location:mobile/controller.php?showShareSite=1');
    exit;
}
if(isset($_GET['mainSite'])){
    header('location:mobile/controller.php?mainSite=1');
    exit;
//    $groupid=isset($_COOKIE['group_id'])?$_COOKIE['group_id']:0;
//    echo $groupid;
//    exit;
}

//$markList=pdoQuery('mark_view',null,null,null);
//ob_start();
//printView('admin/view/mark.html.php', '已读列表');
//$content=ob_get_contents();
//file_put_contents('temp.html',$content);
//ob_clean();



exit;
?>
