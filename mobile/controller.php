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
    $url=preg_replace('/#.+$/','',$newsInf['url']);
    if($newsInf['source']=='local'){
        include 'view/new.html.php';
    }elseif($newsInf['source']=='hybrid') {
//        echo $newsInf['content'];
        header('location:'.$url.'#wechat_redirect');
    }else{
        header('location:'.$url.'#wechat_redirect');
    }

    exit;
}
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

        if(!isset($review))$review=array();
        include 'view/notice.html.php';
    }else{
        echo '当前无通知';
    }
    exit;
}
if(isset($_GET['bbs'])){
    if(!isset($_SESSION['openid'])){
        $open_id=$_GET['openid'];
        $_SESSION['openid']=$open_id;
    }else{
        $open_id=$_SESSION['openid'];
    }
    $userInf=getUserInf($open_id);
    $num = 25;
    $page = isset($_GET['page']) ? $_GET['page'] : 0;
    $topicQuery=pdoQuery('bbs_topic_view',array('title','issue_time','reply_time','reply_count','nickname','real_name','headimgurl','img_id','url'),array('groupid'=>(string)$userInf['groupid']),' or groupid=-1 order by priority desc,reply_time desc limit '.$page*$num.' ,'.$num);
    foreach ($topicQuery as $row) {
        if(isset($topicList[$row['id']])){
            $topicList[$row['id']]['img'][]=$row['url'];
        }else{
            $topicList[$row['id']]=array(
                'title'=>$row['title'],
                'issue_time'=>$row['issue_time'],
                'reply_count'=>$row['reply_count'],
                'nickname'=>$row['nickname'],
                'real_name'=>$row['real_name'],
                'headimgurl'=>$row['headimgurl'],
            );
        }
    }

    include 'view/bbs_list.html.php';
    exit;
//    $noticeQuery=pdo
}
if(isset($_GET['bbs_content'])){

}
if(isset($_GET['create_topic'])){
    $type=isset($_GET['type'])?$_GET['type']:'issue';
    $t_id=isset($_GET['t_id'])?$_GET['t_id']:'-1';
    $f_id=isset($_GET['f_id'])?$_GET['f_id']:'-1';
    if('reply'==$type){

    }
//    echo 'ok';
    include 'view/bbs_input.html.php';
    exit;
}


if(isset($_GET['newsList'])){


}

echo 'web ok';
echo getArrayInf($_COOKIE);