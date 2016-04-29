<?php
/**
 * Created by PhpStorm.
 * User: godlee
 * Date: 2015/10/29
 * Time: 10:50
 */
include_once '../includePackage.php';
session_start();


if (isset($_SESSION['login'])) {
    if (isset($_GET['createNews'])) {
        $title = addslashes(trim($_POST['title']));
        $digest = addslashes(trim($_POST['digest']));
        $title_img = isset($_POST['title_img']) ? $_POST['title_img']: 'img/0.jpg';
        $content = addslashes($_POST['content']);
        if ($title != '' && $content != '') {
            pdoInsert('news_tbl', array('title' => $title, 'digest' => $digest, 'title_img' => $title_img, 'content' => $content, 'source' => 'local','media_id'=>'local'.time().rand(100,999), 'create_time' => time()),'ignore');
            header('location:index.php?newslist=1');
            exit;
        } else {
        }
    }
    if (isset($_GET['getNotice'])) {//在预览框架中显示
        $css = '<style type="text/css">'
  .'img {max-width:100%;}'
.'</style>';

        $noticeId = $_GET['getNotice'];
        if ($noticeId == -1) {
            echo '预览';
            exit;
        }
        $notice = pdoQuery('notice_tbl', array('inf'), array('id' => $noticeId), ' limit 1');
        $notice = $notice->fetch();
        echo $css;
        echo $notice['inf'];
        exit;
    }
    if(isset($_GET['userdetail'])){
        $openid=$_GET['userdetail'];
        $userinf=getUserInf($openid);
        $markquery=pdoQuery('user_mark_view',null,array('openid'=>$openid),null);
        $markStr='';
        foreach ($markquery as $row) {
            $markStr.=($row['notice_id'].',');
            $markList[]=$row;
        }
        $markStr=rtrim($markStr,',');
        $str=$markStr!=''?' and id not in('.$markStr.')':'';
        $unmarkQuery=pdoQuery('notice_tbl',array('title','create_time'),array('situation'=>1),$str);
        $unmarkList=$unmarkQuery->fetchAll();
        printView('admin/view/user_detail.html.php','详细信息');

    }

    //公众号操作
    if (isset($_GET['wechat'])) {
        include_once '../wechat/serveManager.php';
//        $re='';
        if (isset($_GET['createButton'])) {
//            $inf=getConfig('../config/buttonInf.json');
//            if(count($inf)>1){
                deleteButton();
//                foreach ($inf as $row) {
//                    if($row['name']=='default'){
//                        $buttoninf=json_encode($row['inf'],JSON_UNESCAPED_UNICODE);
//                        $return=createButton($buttoninf);
//
//                    }else{
//                        $buttoninf=json_encode($row['inf'],JSON_UNESCAPED_UNICODE);
//                        $return=createUniButton($buttoninf);
//                    }
//                    $re.=$return;
//                }
//
//                echo $re;
//            }else{
//                echo count($inf);
//            }
            createButtonTemp();
            exit;
        }
        if (isset($_GET['getMenuInf'])) {
            echo getUserButton();
            exit;
        }
        if (isset($_GET['test'])) {
//            $data=curlTest();
            $data = sendKFMessage('o_Luwt9OgYENChNK0bBZ4b1tl5hc', '你好');
            echo $data;
            exit;
        }

    }

    exit;
}
header('location:index.php');
exit;

