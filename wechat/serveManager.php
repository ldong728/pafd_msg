
<?php
//session_start();
include_once  $GLOBALS['mypath']. '/wechat/interfaceHandler.php';
$mInterface=new interfaceHandler(WEIXIN_ID);
function deleteButton()
{
    $data = $GLOBALS['mInterface']->sendGet('https://api.weixin.qq.com/cgi-bin/menu/delete?access_token=ACCESS_TOKEN');
    return $data;
}
function createButtonTemp()
{

    $url='http://'.$_SERVER['HTTP_HOST'].DOMAIN.'/mobile/controller.php?mainSite=1';
    $button1sub1=array('name'=>'国防法规','type'=>'view','url'=>$url.'&cate=1');
    $button1sub2=array('name'=>'志在军营','type'=>'view','url'=>$url.'&cate=2');
    $button1sub3=array('name'=>'每月一课','type'=>'view','url'=>$url.'&cate=4');
    $button1sub4=array('name'=>'军民融合','type'=>'click','key'=>'blank');
    $button1sub5=array('name'=>'军人荣誉榜','type'=>'click','key'=>'blank');
    $button1=array('name'=>'兴武征程','sub_button'=>array($button1sub3,$button1sub1,$button1sub4,$button1sub2,$button1sub5));
    $button2=array('name'=>'学习平台','type'=>'click','key'=>'study');
    $button3sub1=array('type'=>'click','name'=>'互动','key'=>'moldule2');
    $button3sub2=array('type'=>'click','name'=>'互动社区','key'=>'bbs');
    $button3=array('name'=>'互动社区','sub_button'=>array($button3sub1,$button3sub2));
    $mainButton=array('button'=>array($button1,$button2,$button3));
    $jsondata = json_encode($mainButton,JSON_UNESCAPED_UNICODE);
    mylog($jsondata);
//    mylog($jsondata);
    $response = $GLOBALS['mInterface']->postJsonByCurl('https://api.weixin.qq.com/cgi-bin/menu/create?access_token=ACCESS_TOKEN', $jsondata);
    mylog('createOk'.$response);
    echo $response;
}
function createUniButton($jsondata){
    $response = $GLOBALS['mInterface']->postJsonByCurl('https://api.weixin.qq.com/cgi-bin/menu/addconditional?access_token=ACCESS_TOKEN', $jsondata);
    mylog('createOk'.$response);
    return $response;
}
function createButton($buttonInf){
    $responInf=$GLOBALS['mInterface']->postJsonByCurl('https://api.weixin.qq.com/cgi-bin/menu/create?access_token=ACCESS_TOKEN', $buttonInf);

    return $responInf;
}
function getMenuInf()
{
    $json = $GLOBALS['mInterface']->getByCurl('https://api.weixin.qq.com/cgi-bin/get_current_selfmenu_info?access_token=ACCESS_TOKEN');
    return $json;
}
function getUserButton(){
    $json = $GLOBALS['mInterface']->getByCurl('https://api.weixin.qq.com/cgi-bin/menu/get?access_token=ACCESS_TOKEN');
    return $json;
}
function createNewKF($account_name, $name, $psw)
{
    $password = md5($psw);
    $createInf = array('kf_account' => $account_name . '@' . wexinId, 'nickname' => $name, 'password' => $password);
    $json = json_encode($createInf, JSON_UNESCAPED_UNICODE);
    echo $json . "\n";
    $data = $GLOBALS['mInterface']->postJsonByCurl('https://api.weixin.qq.com/customservice/kfaccount/add?access_token=ACCESS_TOKEN', $json);
    return $data;

}
function getKFinf(){
    $data=$GLOBALS['mInterface']->getByCurl('https://api.weixin.qq.com/cgi-bin/customservice/getkflist?access_token=ACCESS_TOKEN');
    return $data;
}
function getOnlineKfList(){
    $data=$GLOBALS['mInterface']->getByCurl('https://api.weixin.qq.com/cgi-bin/customservice/getonlinekflist?access_token=ACCESS_TOKEN');
    return $data;
}
function chooseKF($kf='default'){
    $inf=getOnlineKfList();
//    mylog($inf);
    $inf=json_decode($inf,true);
    $return='ok';
    if(count($inf['kf_online_list'])>0){
        $linkNum=100;
        $kfAc='';
        foreach ($inf['kf_online_list'] as $row) {
            if($linkNum>$row['accepted_case']){
                $linkNum=$row['accepted_case'];
                $kfAc=$row['kf_account'];
            }
        }
        $kfAc=$kf=='default'? $kfAc:$kf;
    }else{
        $kfAc=false;
    }
    return $kfAc;
}
function connectKF($openId,$kfAc,$remark){
    $linkinf=array(
        'kf_account'=>$kfAc,
        'openid'=>$openId,
        'text'=>$remark
    );
    $request=$GLOBALS['mInterface']->postArrayByCurl('https://api.weixin.qq.com/customservice/kfsession/create?access_token=ACCESS_TOKEN',$linkinf);
    return $request;
}
function linkKf($openId,$kf='default',$remark='用户从网页接入'){
//    $inf=getOnlineKfList();
//    $inf=json_decode($inf,true);
    $return=0;
    if($kfAc=chooseKF($kf)){
        $request=connectKF($openId,$kfAc,$remark);
        $request=json_decode($request,true);
        if($request['errcode']==0){
            sendKFMessage($openId,'已为您接入人工客服，请稍候');
            $return=0;
        }else{
            sendKFMessage($openId,'客服不在线或者忙碌中，请稍候再试');
            $return=1;
        }

    }else{
        sendKFMessage($openId,'当前无在线客服，请稍候再试');
        $return=2;
    }
    return $return;


}
function sendKFMessage($userId,$content){
    $formatedContent=array('touser'=>$userId,'msgtype'=>'text','text'=>array('content'=>$content));
    $data=$GLOBALS['mInterface']->postArrayByCurl('https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=ACCESS_TOKEN',$formatedContent);
//    $data=$GLOBALS['mInterface']->postArrayByCurl('http://www.anmiee.com/ashtonmall/test.php?access_token=ACCESS_TOKEN',$formatedContent);
    mylog('sendKfinfo:'.$data);
    return $data;
}
function uploadTempMedia($file, $type)
{
    $localSavePath = $GLOBALS['mypath'] . '/tmpmedia/' . $file['name'];
    move_uploaded_file($file['tmp_name'], $localSavePath);
    $back = $GLOBALS['mInterface']->uploadFileByCurl('https://api.weixin.qq.com/cgi-bin/media/upload?access_token=ACCESS_TOKEN&type=' . $type, $localSavePath);
    $upInf = json_decode($back, true);
    mylog($back);
    if (isset($upInf['media_id'])) {
//        pdoInsert('up_temp_tbl', array('local_name' => $localSavePath, 'media_id' => $upInf['media_id'], 'expires_time' => $upInf['created_at'] + 259200, 'media_type' => $type));
        return '上传成功';
    } else {
        output('上传错误，错误代码：' . $upInf['errcode']);
    }
}
function downloadImgToHost($media_id,$filePath)
{
    $url = 'https://api.weixin.qq.com/cgi-bin/media/get?access_token=ACCESS_TOKEN&media_id=';
    $imgData = $GLOBALS['mInterface']->getByCurl($url . $media_id);
    file_put_contents($filePath, $imgData);
    return 'ok';
}
function getUnionId($openId)
{
    $sI=new interfaceHandler(WEIXIN_ID);
    $url = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token=ACCESS_TOKEN&openid=' . $openId . '&lang=zh_CN';
    $jsonData = $sI->getByCurl($url);
    $inf=json_decode($jsonData,true);
    return $inf;
}
function getOpenidList($openid=''){
    $url = 'https://api.weixin.qq.com/cgi-bin/user/get?access_token=ACCESS_TOKEN&next_openid='.$openid;
    $jsonData = $GLOBALS['mInterface']->getByCurl($url);
    return $jsonData;
}
function getOauthToken($code){
    $url='https://api.weixin.qq.com/sns/oauth2/access_token?appid='.APP_ID.'&secret='.APP_SECRET.'&code='.$code.'&grant_type=authorization_code';
    $jsonData=$GLOBALS['mInterface']->getByCurl($url);
    return json_decode($jsonData,true);
}
function getUserInfByToken($data){
    $openId=$data['openid'];
    $token=$data['access_token'];
    $url='https://api.weixin.qq.com/sns/userinfo?access_token='.$token.'&openid='.$openId.'&lang=zh_CN';
    $jsonData=$GLOBALS['mInterface']->getByCurl($url);
    return $jsonData;

}
function createQrcode($str){
    $data=array('action_name'=>'QR_LIMIT_STR_SCENE','action_info'=>array('scene'=>array('scene_str'=>$str)));
    $json = $GLOBALS['mInterface']->postArrayByCurl('https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=ACCESS_TOKEN', $data);
    $ticket=json_decode($json,true);
    if(!isset($ticket['errcode'])){
        $urticket=urlencode($ticket['ticket']);
        $url='https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='.$urticket;
        $qr=$GLOBALS['mInterface']->getByCurl($url);
        $filePath=$GLOBALS['mypath'].'/img/'.$str.'.jpg';
        file_put_contents($filePath,$qr);
        return $qr;
    }else{
        return false;
    }

}
function getMediaList($type, $offset,$count='15')
{
    $request = array('type' => $type, 'offset' => $offset, 'count' => $count);
    $json = $GLOBALS['mInterface']->postArrayByCurl('https://api.weixin.qq.com/cgi-bin/material/batchget_material?access_token=ACCESS_TOKEN', $request);
    return json_decode($json, true);
}
function changeGroup($openid,$groupId){
    $data=array('openid'=>$openid,'to_groupid'=>$groupId);
    $data=json_encode($data);
    mylog($data);
    $json = $GLOBALS['mInterface']->postJsonByCurl('https://api.weixin.qq.com/cgi-bin/groups/members/update?access_token=ACCESS_TOKEN', $data);
    mylog($json);
    return $json;
}
function getGroupListOnline(){
    $handler=new interfaceHandler(WEIXIN_ID);
    $json=$handler->getByCurl('https://api.weixin.qq.com/cgi-bin/groups/get?access_token=ACCESS_TOKEN');
    $list=json_decode($json,true);
    return $list['groups'];
}
function createGroup($name){
    $list=array('group'=>array('name'=>$name));
    $listjson=json_encode($list,JSON_UNESCAPED_UNICODE);
    $json=$GLOBALS['mInterface']->postJsonByCurl('https://api.weixin.qq.com/cgi-bin/groups/create?access_token=ACCESS_TOKEN',$listjson);
    return $json;
}
function altGroup($name,$id){
    $list=array('group'=>array('id'=>$id,'name'=>$name));
    $listjson=json_encode($list,JSON_UNESCAPED_UNICODE);
    $json=$GLOBALS['mInterface']->postJsonByCurl('https://api.weixin.qq.com/cgi-bin/groups/update?access_token=ACCESS_TOKEN',$listjson);
    return $json;
}
function deleteGroup($id){
    $list=array('group'=>array('id'=>$id));
    $listjson=json_encode($list,JSON_UNESCAPED_UNICODE);
    $json=$GLOBALS['mInterface']->postJsonByCurl('https://api.weixin.qq.com/cgi-bin/groups/delete?access_token=ACCESS_TOKEN',$listjson);
    return $json;
}
function textSandAll($text,$groupid=-1){
    if(-1==$groupid){
        $filter=array('is_to_all'=>true);
    }else{
        $filter=array('is_to_all'=>false,'group_id'=>$groupid);
    }
    $text=array('content'=>$text);
    $type='text';
    $data=array('filter'=>$filter,'text'=>$text,'msgtype'=>$type);
    $listjson=json_encode($data,JSON_UNESCAPED_UNICODE);
    mylog($listjson);
    $json=$GLOBALS['mInterface']->postJsonByCurl('https://api.weixin.qq.com/cgi-bin/message/mass/sendall?access_token=ACCESS_TOKEN',$listjson);
    return $json;
}
function getMedia($jsonMediaId)
{
//    $GLOBALS['mInterface']=($GLOBALS['ready']?$GLOBALS['mInterface']:new interfaceHandler($weixinId) );
    $json = $GLOBALS['mInterface']->postJsonByCurl('https://api.weixin.qq.com/cgi-bin/material/get_material?access_token=ACCESS_TOKEN', $jsonMediaId);
//    mylog($json);
    return $json;
}
function reflashAutoReply()
{
    $replyinf = $GLOBALS['mInterface']->getByCurl('https://api.weixin.qq.com/cgi-bin/get_current_autoreply_info?access_token=ACCESS_TOKEN');
//    output(addslashes($replyinf));
//    exit;
    $replyRule = json_decode($replyinf, true);
    if ($replyRule['is_autoreply_open'] == 1) {
        if (isset($replyRule['add_friend_autoreply_info'])) {
            $readyContent=formatContent($replyRule['add_friend_autoreply_info']['type'],$replyRule['add_friend_autoreply_info']['content']);
            $readyContent['request_type']='event';
            $readyContent['key_word']='add_friend_autoreply_info';
            $readyContent['update_time']=time();
            pdoInsert('default_reply_tbl', $readyContent, ' ON DUPLICATE KEY UPDATE content="' .$readyContent['content']. '",update_time='.time());
        }

        foreach ($replyRule['keyword_autoreply_info']['list'] as $row) {
            $readyContent=formatContent( $row['reply_list_info'][0]['type'],$row['reply_list_info'][0]['news_info']['list']);
            $readyContent['key_word'] = $row['keyword_list_info'][0]['content'];
            pdoInsert('default_reply_tbl', $readyContent, ' ON DUPLICATE KEY UPDATE content="' .$readyContent['content']. '",update_time='.time());
        }
    }
}
function requestTemplate($templateId){
    $data=array('template_id_short'=>$templateId);
    $data=json_encode($data);
    $re=$GLOBALS['mInterface']->postJsonByCurl('https://api.weixin.qq.com/cgi-bin/template/api_add_template?access_token=ACCESS_TOKEN',$data);
    $re=json_decode($re,true);
    if($re['errcode']==0){
        return $re['template_id'];
    }else{
        return false;
    }
}
function sendTemplateMsg($customerId,$templateId,$url,array $msg){
    $fullMsg=array(
        'touser'=>$customerId,
        'template_id'=>$templateId,
        'url'=>$url,
        'data'=>$msg
    );
    $mInterface=new interfaceHandler(WEIXIN_ID);
    $response=$mInterface->postArrayByCurl('https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=ACCESS_TOKEN',$fullMsg);
    return $response;
}
function formatContent($type, $content)
{
    $insertArray['reply_type']=$type;
    $insertArray['weixin_id']=$_SESSION['weixinId'];
    $insertArray['source']=1;
    switch ($type) {
        case 'text': {
            $insertArray['content']=$content;
                         break;
        }
        case 'news':{
            $data=formatNewsContent($content);
            $insertArray['content']=$data;
                break;
        }
            default:{

                break;
            }
    }
    return $insertArray;

}
function formatNewsContent(array $contentArray)
{
    $content = json_encode(array('news_item' => $contentArray),JSON_UNESCAPED_UNICODE);
    $content = addslashes($content);
    return $content;
}
function curlTest(){
    $data=array('text'=>"testok");
//    $data=$GLOBALS['mInterface']->postArrayByCurl('http://www.anmiee.com/ashtonmall/test.php',$data);
    $data=$GLOBALS['mInterface']->postArrayByCurl('http://web.gooduo.net/ashton/test.php',$data);
    return $data;
}
function getFromUrl($url){
    $replyinf = $GLOBALS['mInterface']->getByCurl($url);
    return $replyinf;
}
function getMediaCount(){
    $replyinf = $GLOBALS['mInterface']->getByCurl('https://api.weixin.qq.com/cgi-bin/material/get_materialcount?access_token=ACCESS_TOKEN');
    return $replyinf;
}
function deleteMedia($media_id){
    $data=array('media_id'=>$media_id);
    $data=json_encode($data);
    $re=$GLOBALS['mInterface']->postJsonByCurl('https://api.weixin.qq.com/cgi-bin/material/del_material?access_token=ACCESS_TOKEN',$data);
    return $re;
}
