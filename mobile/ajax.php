<?php
/**
 * Created by PhpStorm.
 * User: godlee
 * Date: 2015/10/26
 * Time: 13:09
 */
include_once '../includePackage.php';;
session_start();

if (isset($_SESSION['openid'])) {
    if (isset($_POST['issue_topic'])) {//发帖
        $query = pdoQuery('bbs_topic_tbl', array('issue_time'), array('open_id' => $_SESSION['openid']), ' order by issue_time desc limit 1');
        $query = $query->fetch();
//        mylog(json_encode($query));
        if ($query && (time() - $query['issue_time'] < 120)) {
            $time = 120 - (time() - $query['issue_time']);
            mylog($time);
            echo "请于 $time 秒后重试";
            exit;
        }
        $userInf = getUserInf($_SESSION['openid']);
        if (!isset($_POST['title']) || strlen($_POST['title']) < 2) {
            echo '请输入标题';
            exit;
        }
        $title = addslashes(trim($_POST['title']));
        $content = addslashes(trim($_POST['content']));
        pdoTransReady();
        try {
            $img_num = count($_POST['image']);
            $id = pdoInsert('bbs_topic_tbl', array('title' => $title, 'content' => $content, 'open_id' => $_SESSION['openid'], 'issue_time' => time(), 'reply_time' => time(), 'reply_count' => 0, 'groupid' => $userInf['groupid'], 'img_count' => $img_num));
            if (!file_exists($GLOBALS['mypath'] . '/img/bbs')) mkdir($GLOBALS['mypath'] . '/img/bbs');  //首次部署使用后可删除
            foreach ($_POST['image'] as $row) {
                include_once $GLOBALS['mypath'] . '/wechat/serveManager.php';
                $imgPath = 'img/bbs/' . $row . '.jpg';
                $bytes = downloadImgToHost($row, $mypath . '/' . $imgPath);
                mylog($bytes);
                $imgList[] = array('t_id' => $id, 'url' => $imgPath, 'openid' => $_SESSION['openid'], 'create_time' => time());
            }
            if (isset($imgList)) {
                pdoBatchInsert('bbs_topic_img_tbl', $imgList);
            }
            pdoCommit();
            echo 'ok';
        } catch (PDOException $e) {
            $err = 'error';
            $code = $e->getCode();
            mylog($e->getMessage());
            pdoRollBack();
            if ($code == '23000') $err = '已发表过相同文章';
            echo $err;
            exit;
        }


    }
    if (isset($_POST['issue_reply'])) {//回复输入
        $query = pdoQuery('bbs_reply_tbl', array('issue_time'), array('openid' => $_SESSION['openid']), ' order by issue_time desc limit 1');
        $query = $query->fetch();
        mylog(json_encode($query));
        if ($query && (time() - $query['issue_time'] < 60)) {
            $time = 120 - (time() - $query['issue_time']);
            mylog($time);
            echo "请于 $time 秒后重试";
            exit;
        }
        $userInf = getUserInf($_SESSION['openid']);
        $content = addslashes(trim($_POST['content']));
        $t_id = $_POST['t_id'];
        $f_id = isset($_POST['f_id']) ? $_POST['f_id'] : -1;
        pdoTransReady();
        try {
            $id = pdoInsert('bbs_reply_tbl', array('t_id' => $t_id, 'f_id' => $f_id, 'content' => $content, 'openid' => $_SESSION['openid'], 'issue_time' => time()));
            $sql = 'update bbs_topic_tbl set reply_time=' . time() . ',reply_count=reply_count+1 where id=' . $t_id;
            mylog($sql);
            exeNew($sql);
//            pdoUpdate('bbs_topic_tbl',array('reply_time'=>time(),'reply_count'=>'reply_count+1'),array('id'=>$t_id));
            if ($f_id < 0) {
                foreach ($_POST['image'] as $row) {
                    include_once $GLOBALS['mypath'] . '/wechat/serveManager.php';
                    $imgPath = 'img/bbs/' . $row . '.jpg';
                    $bytes = downloadImgToHost($row, $mypath . '/' . $imgPath);
                    mylog($bytes);
                    $imgList[] = array('t_id' => $t_id, 'r_id' => $id, 'url' => $imgPath, 'openid' => $_SESSION['openid'], 'create_time' => time());
                }
                if (isset($imgList)) {
                    pdoBatchInsert('bbs_reply_img_tbl', $imgList);
                }
            }
            pdoCommit();
            echo 'ok';
        } catch (PDOException $e) {
            mylog($e->getMessage());
            pdoRollBack();
            echo 'error';
            exit;
        }
    }
    if (isset($_POST['topic_like'])) {
        $str = 'ok';
        $t_id = $_POST['t_id'];
        $r_id = isset($_POST['r_id']) ? $_POST['r_id'] : -1;
        $query = pdoQuery('bbs_like_tbl', array('id'), array('openid' => $_SESSION['openid'], 't_id' => $t_id, 'r_id' => $r_id), ' limit 1');
        if (!$row = $query->fetch()) {
            pdoTransReady();
            try {
                pdoInsert('bbs_like_tbl', array('openid' => $_SESSION['openid'], 't_id' => $t_id, 'r_id' => $r_id, 'like_time' => time()));
                $sql = 'update bbs_topic_tbl set like_count=like_count+1 where id="' . $t_id . '"';
                exeNew($sql);
                pdoCommit();
            } catch (PDOException $e) {
                pdoRollBack();
                $str = 'datebase error';
            }
        } else {
            $str = "duplicate";
        }
        echo $str;
        exit;

    }
    if (isset($_POST['std'])) {
        if (isset($_POST['getQuestion'])) {
            $id = isset($_POST['id']) ? $_POST['id'] : -1;
            $inf = getQuestionDetail($id);
            $inf = json_encode($inf);
            echo $inf;
            exit;
        }
        if (isset($_POST['uploadScore'])) {
            $openid = $_SESSION['openid'];
            $count = $_POST['q_count'];
            $score = $_POST['score'];
            if ($score > 2) {
                pdoInsert('std_user_score_tbl', array('openid' => $openid, 'q_count' => $count, 'score' => $score, 'create_time' => time()));
            }
            echo 'ok';
        }
        exit;

    }

}
    if (isset($_POST['signIn'])) {
        $group_id = $_POST['groupid'];
        $openid = $_POST['openid'];
        $id = $_POST['id'];
        $name = $_POST['real_name'];
        $phone = $_POST['phone'];
        $psw = $_POST['psw'];
        $verify=array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10 ,5 ,8 ,4 ,2);
        $final=array(1, 0, 'x', 9, 8, 7, 6, 5, 4, 3, 2,);
        $value=0;
        for($i=0;$i<17;$i++){
           $value+= $id[$i]*$verify[$i];
        }
        $value=$value%11;
        if($final[$value]!=$id[17]){
            echo '身份证号校验失败';
            exit;
        }

        include_once '../wechat/serveManager.php';
        $re = changeGroup($openid, $group_id);
        $re = json_decode($re, true);
        if ($re['errcode'] == '0') {
            pdoTransReady();
            try{
                pdoInsert('user_reg_tbl',array('id'=>$id,'openid'=>$openid,'name'=>$name,'phone'=>$phone,'password'=>md5($psw),'groupid'=>$group_id));
                pdoUpdate('user_tbl',array('groupid'=>$group_id),array('openid'=>$openid));
                pdoCommit();
                $_SESSION['openid']=$openid;
            }catch(PDOException $e){
                mylog($e->getMessage());
                pdoRollBack();
                echo '数据库错误，请重试';
                exit;
            }
            echo '1';
            exit;

        } else {
            mylog(getArrayInf($re));
            echo '微信服务器错误';
            exit;
        }
    }
    if(isset($_POST['logIn'])){
        $value=$_POST['value'];
        $psw=md5($_POST['psw']);
        $inf=pdoQuery('user_reg_tbl',null,array('password'=>$psw)," and (name =\"$value\" or id=\"$value\" or phone=\"$value\") limit 1");
        if($inf=$inf->fetch()){
            $_SESSION['openid']=$inf['openid'];
            mylog('login success');
            echo '1';
            exit;
        }else{
            echo '用户名或密码错误';
            exit;
        }
    }
    echo 'time_out';
    exit;



