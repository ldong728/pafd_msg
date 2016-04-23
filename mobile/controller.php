<?php
/**
 * Created by PhpStorm.
 * User: godlee
 * Date: 2015/10/28
 * Time: 15:14
 */
include_once '../includePackage.php';
session_start();

if(isset($_GET['showShareSite'])){
 include 'view/share.html.php';
    exit;
}
if(isset($_GET['signIn'])){
    $open_id=$_GET['code'];
    $group_id=isset($_COOKIE['group_id'])?$_COOKIE['group_id']:'0';
    if($group_id!=0){
        include_once '../wechat/serveManager.php';
        changeGroup($open_id,$group_id);

    }
//    mylog('group_id:'.$group_id);


}

echo 'web ok';
echo getArrayInf($_COOKIE);