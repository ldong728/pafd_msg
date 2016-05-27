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
    if(isset($_POST['issue_topic'])){//发帖
        $query=pdoQuery('bbs_topic_tbl',array('issue_time'),array('open_id'=>$_SESSION['openid']),' order by issue_time desc limit 1');
        $query=$query->fetch();
//        mylog(json_encode($query));
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
            $img_num=count($_POST['image']);
            $id=pdoInsert('bbs_topic_tbl',array('title'=>$title,'content'=>$content,'open_id'=>$_SESSION['openid'],'issue_time'=>time(),'reply_time'=>time(),'reply_count'=>0,'groupid'=>$userInf['groupid'],'img_count'=>$img_num));
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
            $err='error';
            $code=$e->getCode();
            mylog($e->getMessage());
            pdoRollBack();
            if($code=='23000')$err='已发表过相同文章';
            echo $err;
            exit;
        }


    }if(isset($_POST['issue_reply'])){//回复输入
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
        $f_id=isset($_POST['f_id'])? $_POST['f_id']: -1;
        pdoTransReady();
        try{
            $id=pdoInsert('bbs_reply_tbl',array('t_id'=>$t_id,'f_id'=>$f_id,'content'=>$content,'openid'=>$_SESSION['openid'],'issue_time'=>time()));
            $sql='update bbs_topic_tbl set reply_time='.time().',reply_count=reply_count+1 where id='.$t_id;
            mylog($sql);
            exeNew($sql);
//            pdoUpdate('bbs_topic_tbl',array('reply_time'=>time(),'reply_count'=>'reply_count+1'),array('id'=>$t_id));
            if($f_id<0){
                foreach ($_POST['image'] as $row) {
                    include_once $GLOBALS['mypath'] . '/wechat/serveManager.php';
                    $imgPath='img/bbs/'.$row.'.jpg';
                    $bytes=downloadImgToHost($row,$mypath.'/'.$imgPath);
                    mylog($bytes);
                    $imgList[]=array('t_id'=>$t_id,'r_id'=>$id,'url'=>$imgPath,'openid'=>$_SESSION['openid'],'create_time'=>time());
                }
                if(isset($imgList)){
                    pdoBatchInsert('bbs_reply_img_tbl',$imgList);
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
    if(isset($_POST['topic_like'])){
        $str='ok';
        $t_id=$_POST['t_id'];
        $r_id=isset($_POST['r_id'])? $_POST['r_id']:-1;
        $query=pdoQuery('bbs_like_tbl',array('id'),array('openid'=>$_SESSION['openid'],'t_id'=>$t_id,'r_id'=>$r_id),' limit 1');
        if(!$row=$query->fetch()){
            pdoTransReady();
            try{
                pdoInsert('bbs_like_tbl',array('openid'=>$_SESSION['openid'],'t_id'=>$t_id,'r_id'=>$r_id,'like_time'=>time()));
                $sql='update bbs_topic_tbl set like_count=like_count+1 where id="'.$t_id.'"';
                exeNew($sql);
                pdoCommit();
            }catch (PDOException $e){
                pdoRollBack();
                $str='datebase error';
            }
        }else{
            $str="duplicate";
        }
        echo $str;
        exit;

    }
    if(isset($_POST['std'])){
        if(isset($_POST['getQuestion'])){
            $id=isset($_POST['id'])?$_POST['id'] : -1;
            $inf=getQuestionDetail($id);
            $inf=json_encode($inf);
            echo $inf;
            exit;
        }
        if(isset($_POST['uploadScore'])){
            $openid=$_SESSION['openid'];
            $count=$_POST['q_count'];
            $score=$_POST['score'];
            if($score>2){
                pdoInsert('std_user_score_tbl',array('openid'=>$openid,'q_count'=>$count,'score'=>$score,'create_time'=>time()));
            }
            echo 'ok';
        }

    }

}else{
    echo 'time_out';
    exit;
}


