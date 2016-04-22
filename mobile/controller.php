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
    $group_id=isset($_COOKIE['group_id'])?$_COOKIE['group_id']:'0';
    mylog('group_id:'.$group_id);


}

echo 'web ok';
echo getArrayInf($_COOKIE);