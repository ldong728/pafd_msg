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
        $groupid=$userinf['groupid'];
        $markquery=pdoQuery('user_mark_view',null,array('openid'=>$openid),null);
        $markStr='';
        foreach ($markquery as $row) {
            $markStr.=($row['notice_id'].',');
            $markList[]=$row;
        }
        $markStr=rtrim($markStr,',');
        $str=$markStr!=''?' and id not in('.$markStr.')':'';
        $unmarkQuery=pdoQuery('notice_tbl',array('title','create_time'),array('situation'=>1,'groupid'=>$groupid),$str);
        $unmarkList=$unmarkQuery->fetchAll();
        printView('admin/view/user_detail.html.php','详细信息');

    }

    //公众号操作
    if (isset($_GET['wechat'])) {
        include_once '../wechat/serveManager.php';
//        $re='';
        if (isset($_GET['createButton'])) {
            deleteButton();
            createButtonTemp();
            exit;
        }
        if(isset($_GET['createUniButton'])){
            $url='http://'.$_SERVER['HTTP_HOST'].DOMAIN.'/mobile/controller.php?mainSite=1';
            $button1sub1=array('name'=>'政策法规','type'=>'view','url'=>$url.'&cate=1');
            $button1sub2=array('name'=>'征兵工作','type'=>'view','url'=>$url.'&cate=2');
            $button1sub3=array('name'=>'政治教育','type'=>'view','url'=>$url.'&cate=4');
            $button1=array('name'=>'文章列表','sub_button'=>array($button1sub1,$button1sub2,$button1sub3));
            $button2=array('name'=>'军民融合','type'=>'view','url'=>$url.'&cate=3');
//            $button3=array('type'=>'click','name'=>'专武干部','key'=>'moldule2');
            $mainButton=array('button'=>array($button1,$button2,$button3),'matchrule'=>array('group_id'=>100));
//            $jsondata = json_encode($mainButton,JSON_UNESCAPED_UNICODE);
            $button3=array('type'=>'click','name'=>'应急力量','key'=>'moldule2');
            $mainButton=array('button'=>array($button1,$button2,$button3),'matchrule'=>array('group_id'=>101));
            $jsondata = json_encode($mainButton,JSON_UNESCAPED_UNICODE);
            echo createUniButton($jsondata);
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

