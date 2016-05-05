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
if(isset($_GET['mainSite'])){

    $cateid=isset($_GET['cate'])?$_GET['cate']:1;
    $titleQuery=pdoQuery('news_tbl',array('id','category','title','digest','title_img','url','source','type','create_time'),array('type'=>'title','category'=>$cateid),'order by create_time desc limit 6');
    $title=$titleQuery->fetchAll();
    $cateQuery=pdoQuery('category_tbl',null,array('front'=>'1'),' limit 4');
    $cate=$cateQuery->fetchAll();
    $newsList=pdoQuery('news_tbl',array('id','category','title','digest','title_img','url','source','type','create_time'),array('category'=>$cateid),' order by create_time desc limit 30');
    include 'view/newsList.html.php';
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
    header('location:controller.php?mainSite=1');
    exit;
}

if(isset($_GET['getNews'])){
    $newsId=$_GET['getNews'];
    $newInf=pdoQuery('news_tbl',null,array('id'=>$newsId),' limit 1');
    $newsInf=$newInf->fetch();
    if($newsInf['source']=='local'){
        include 'view/new.html.php';
    }else{
        include_once '../wechat/serveManager.php';
        $data=getFromUrl($newsInf['url']);
        mylog(preg_match_all('/(?<=data-src=").+(?=")/',$data,$list));
        mylog(json_encode($list));
//        echo $data;
//        echo '<script>alert('ok');</script>';
//        include 'view/wechatNew.html.php';
        header('location:'.$newsInf['url']);
    }

    exit;
}
//if(isset($_GET['getWechatNews'])){
//    $newsId=$_GET['getNews'];
//    $newInf=pdoQuery('news_tbl',null,array('id'=>$newsId),' limit 1');
//    $newsInf=$newInf->fetch();
//    include 'view/wechatNew.html.php';
//}
if(isset($_GET['getNotice'])){
    $open_id=$_GET['openid'];
    $group_id=$_GET['groupid'];
    $noticeQuery=pdoQuery('notice_tbl',null,array('groupid'=>$group_id,'situation'=>'1'),' order by create_time desc limit 1');
    if($noticeInf=$noticeQuery->fetch()){
        pdoinsert('read_mark_tbl',array('openid'=>$open_id,'notice_id'=>$noticeInf['id'],'groupid'=>$group_id),'ignore');//已读标记
        $reviewQuery=pdoQuery('review_view',null,array('notice_id'=>$noticeInf['id'],'f_id'=>'-1'),' order by review_time desc');
        foreach ($reviewQuery as $row) {
            $review[$row['id']]['main']=$row;
        }
        $subRviewQuery=pdoQuery('review_view',null,array('notice_id'=>$noticeInf['id']),' and f_id<>"-1" order by review_time asc');
        foreach ($subRviewQuery as $srow) {
            $review[$srow['f_id']]['subReview'][]=$srow;
        }


//        foreach ($reviewQuery as $row) {
//            if(-1==$row['f_id']){
//                $review[$row['id']]['main']=$row;
//            }else{
//                $review[$row['f_id']]['subReview'][]=$row;
//            }
//        }
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