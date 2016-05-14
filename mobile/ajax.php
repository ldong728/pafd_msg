<?php
/**
 * Created by PhpStorm.
 * User: godlee
 * Date: 2015/10/26
 * Time: 13:09
 */
include_once '../includePackage.php';;
session_start();

if(isset($_SESSION['openid'])){
    if(isset($_POST['issue_topic'])){
        $query=pdoQuery('bbs_topic_tbl',array('issue_time'),array('open_id'=>$_SESSION['openid']),' order by issue_time desc limit 1');
        $query=$query->fetch();
        mylog(json_encode($query));
        if($query&&(time()-$query['issue_time']<120)){
            $time=120-(time()-$query['issue_time']);
            mylog($time);
            echo "请于 $time 秒后重试";
            exit;
        }
        $userInf=getUserInf($_SESSION['openid']);
        if(!isset($_POST['title'])||strlen($_POST['title'])<2){
            echo '请输入标题';
            exit;
        }
        $title=addslashes(trim($_POST['title']));
        $content=addslashes(trim($_POST['content']));
        pdoTransReady();
        try{
            $id=pdoInsert('bbs_topic_tbl',array('title'=>$title,'content'=>$content,'open_id'=>$_SESSION['openid'],'issue_time'=>time(),'reply_time'=>time(),'reply_count'=>0,'groupid'=>$userInf['groupid']));
            if(!file_exists($GLOBALS['mypath'].'/img/bbs'))mkdir($GLOBALS['mypath'].'/img/bbs');  //首次部署使用后可删除
            foreach ($_POST['image'] as $row) {
                include_once $GLOBALS['mypath'] . '/wechat/serveManager.php';
                $imgPath='img/bbs/'.$row.'.jpg';
                $bytes=downloadImgToHost($row,$mypath.'/'.$imgPath);
                mylog($bytes);
                $imgList[]=array('t_id'=>$id,'url'=>$imgPath,'openid'=>$_SESSION['openid'],'create_time'=>time());
            }
            if(isset($imgList)){
                pdoBatchInsert('bbs_topic_img_tbl',$imgList);
            }
            pdoCommit();
            echo 'ok';
        }catch(PDOException $e){
            mylog($e->getMessage());
            pdoRollBack();
            echo 'error';
            exit;
        }


    }if(isset($_POST['issue_reply'])){
        $query=pdoQuery('bbs_reply_tbl',array('issue_time'),array('openid'=>$_SESSION['openid']),' order by issue_time desc limit 1');
        $query=$query->fetch();
        mylog(json_encode($query));
        if($query&&(time()-$query['issue_time']<60)){
            $time=120-(time()-$query['issue_time']);
            mylog($time);
            echo "请于 $time 秒后重试";
            exit;
        }
        $userInf=getUserInf($_SESSION['openid']);
        $content=addslashes(trim($_POST['content']));
        $t_id=$_POST['t_id'];
        $f_id=$_POST['f_id'];
        pdoTransReady();
        try{
            $id=pdoInsert('bbs_reply_tbl',array('t_id'=>$t_id,'f_id'=>$f_id,'content'=>$content,'openid'=>$_SESSION['openid'],'issue_time'=>time()));
            pdoUpdate('bbs_topic_tbl',array('reply_time'=>time(),'reply_count'=>'reply_count+1'),array('id'=>$t_id));
            if($f_id>0){
                foreach ($_POST['image'] as $row) {
                    include_once $GLOBALS['mypath'] . '/wechat/serveManager.php';
                    $imgPath='img/bbs/'.$row.'.jpg';
                    $bytes=downloadImgToHost($row,$mypath.'/'.$imgPath);
                    mylog($bytes);
                    $imgList[]=array('r_id'=>$id,'url'=>$imgPath,'openid'=>$_SESSION['openid'],'create_time'=>time());
                }
                if(isset($imgList)){
                    pdoBatchInsert('bbs_topic_img_tbl',$imgList);
                }
            }
            pdoCommit();
            echo 'ok';
        }catch(PDOException $e){
            mylog($e->getMessage());
            pdoRollBack();
            echo 'error';
            exit;
        }


    }

}else{
    echo 'time_out';
    exit;
}


