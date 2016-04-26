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
    if(isset($_POST['sendNotice'])){
        $newsId=$_POST['newsId'];
        $newsInf=pdoQuery('news_tbl',null,array('id'=>$newsId),' limit 1');
        $newsInf=$newsInf->fetch();
        $notice_id=pdoInsert('notice_tbl',array('title'=>addslashes($newsInf['title']),'intro'=>addslashes($newsInf['digest']),'title_img'=>$newsInf['title_img'],'inf'=>addslashes($newsInf['content']),'create_time'=>time()));
        pdoUpdate('news_tbl',array('type'=>'notice'),array('id'=>$newsId));
        echo $notice_id;
        exit;

    }
}
?>