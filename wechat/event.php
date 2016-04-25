<?php

function VIEW($msg)
{
//    mylog('it work');

}


function CLICK($msg)
{
//    mylog('click');
    $openid = $msg['from'];
    switch ($msg['EventKey']) {
        case 'moldule2': {
            $inf = getUserInf($openid);
            $groupid = $inf['groupid'];
            $notice=pdoQuery('notice_tbl',null,array('groupid'=>$groupid),' order by create_time desc limit 1');
            if($notice=$notice->fetch()) {
                $title = $notice['title'];
                $intro = $notice['intro'];
                $img = $notice['title_img'];
                $url = 'http://' . $_SERVER['HTTP_HOST'] . DOMAIN . '/mobile/controller.php?getNotice=1&openid=' . $openid . '&groupid=' . $groupid;
                $newsArray = array('news_item' => [array('title' => $title, 'digest' => $intro, 'cover_url' => 'http://' . $_SERVER['HTTP_HOST'] . DOMAIN . '/' . $img, 'url' => $url)]);
                $json = json_encode($newsArray);
                $content = $GLOBALS['weixin']->prepareNewsMsg($msg['from'], $msg['me'], $json);
//                mylog($content);
                echo $content;
            }else{
                $GLOBALS['weixin']-> replytext('当前无通知');
            }



            break;
        }
        case 'moldule3': {
            break;
        }
        case 'module1' : {


            $GLOBALS['weixin']->replytext('请点击');
            break;
        }
    }
    if ($msg['EventKey'] == 'kf') {
//        mylog('kf');
        sendKFMessage($msg['FromUserName'], '已为您接入人工客服，请稍候');
        $GLOBALS['weixin']->toKFMsg();
    }
    return;
}


function subscribe($msg)
{
    $openid = $msg['FromUserName'];
    if (isset($msg['EventKey'])) {
        $group_id = preg_replace('/qrscene_/', '', $msg['EventKey']);
        changeGroup($openid, $group_id);
    }
    $userinf = getUnionId($msg['FromUserName']);
    if (isset($userinf)) {
        putUserInfToDb($userinf);
    }
    $url = 'http://' . $_SERVER['HTTP_HOST'] . DOMAIN . '/mobile/controller.php?signIn=1&code=' . $openid;
    $newsArray = array('news_item' => [array('title' => '欢迎信息', 'digest' => '请进入本条图文信息', 'cover_url' => 'http://' . $_SERVER['HTTP_HOST'] . DOMAIN . '/img/0.jpg', 'url' => $url)]);
    $json = json_encode($newsArray);
    $content = $GLOBALS['weixin']->prepareNewsMsg($msg['from'], $msg['me'], $json);
//    mylog($content);
    echo $content;


    return;
}