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
        $json=changeGroup($open_id,$group_id);
        $data=json_decode($json,true);
        if(0==$data['errcode']){
            pdoUpdate('user_tbl',array('groupid'=>$group_id),array('openid'=>$open_id));
        }
    }


    exit;
}
if(isset($_GET['getNotice'])){
    $open_id=$_GET['openid'];
    $group_id=$_GET['groupid'];
    $noticeQuery=pdoQuery('notice_tbl',null,array('groupid'=>$group_id),' order by create_time desc limit 1');
    if($noticeInf=$noticeQuery->fetch()){
        pdoinsert('read_mark_tbl',array('openid'=>$open_id,'notice_id'=>$noticeInf['id'],'groupid'=>$group_id),'ignore');//已读标记
        $reviewQuery=pdoQuery('review_tbl',null,array('notice_id'=>$noriceInf['id']),' order by review_time desc');
        foreach ($reviewQuery as $row) {
            if(-1==$row['f_id']){
                $review[$row['id']]['main']=$row;
            }else{
                $review[$row['f_id']]['subReview'][]=$row;
            }
        }
        if(!isset($review))$review=array();
        include 'view/notice.html.php';
    }else{
        echo '当前无通知';
    }
    exit;

}

if(isset($_GET['newsList'])){


}

echo 'web ok';
echo getArrayInf($_COOKIE);