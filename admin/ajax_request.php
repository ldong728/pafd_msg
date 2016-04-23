<?php
include_once '../includePackage.php';
session_start();

if(isset($_SESSION['login'])) {
    if(isset($_POST['reflashUserList'])){

    }

    if(isset($_POST['altGroup'])){
        $name=$_POST['name'];
        $id=$_POST['id'];
        include_once '../wechat/serveManager.php';
        if(0==$id){
            $inf=createGroup($name);
        }else{
            $inf=altGroup($name,$id);
        }

        echo $inf;
        exit;
    }
    if(isset($_POST['deleteGroup'])){
        $id=$_POST['id'];
        include_once '../wechat/serveManager.php';
        $inf=deleteGroup($id);
        echo $inf;
        exit;

    }
    if(isset($_POST['groupQr'])){
        $group_id=$_POST['group_id'];
        $url='http://' . $_SERVER['HTTP_HOST'] . DOMAIN . '/index.php?share='.$group_id;
        echo urlencode($url);
        exit;
    }
}
?>