<?php
/**
 * Created by PhpStorm.
 * User: godlee
 * Date: 2015/11/3
 * Time: 23:20
 */
define('SDP_KEY','329qkd98ekjd9aqkrmr87t');

function printView($addr,$title='abc'){
    $mypath= $GLOBALS['mypath'];
    include $mypath.'/admin/templates/header.html.php';
    include $mypath.'/'.$addr;
    include $mypath.'/admin/templates/footer.html.php';
}
function putUserInfToDb(array $inf){
    foreach ($inf as $k => $v) {
        if ('subscribe_time' == $k) {
            $v = date('Y-m-d H:i:s', $v);
        }
        $data[$k] = addslashes($v);
    }
    $re = pdoInsert('user_tbl', $data, 'update');
    return $re;
}
function getUserInf($open_id){
    $query=pdoQuery('user_tbl',null,array('openid'=>$open_id),' limit 1');
    if($inf=$query->fetch()){
        return $inf;
    }else{
        include_once '../wechat/serveManager.php';
        $inf=getUnionId($open_id);
        if(isset($inf['nickname'])){
            putUserInfToDb($inf);
        }
        return $inf;
    }
}
function getReview($g_id,$index=0,$limit=3){
    $query=pdoQuery('user_output_review_view',null,array('g_id'=>$g_id,'father_v_id'=>'-1'),
        ' and (c_id="'.$_SESSION['customerId'].'" or public=1) order by priority asc,review_time desc limit '.$index.','.$limit*5);
    $numquery=pdoQuery('review_tbl',array('count(*) as num'),array('g_id'=>$g_id,'father_v_id'=>'-1'),' and (public=1 or c_id="'.$_SESSION['customerId'].'")');
    $count=$numquery->fetch();
    $reviewcount=0;
    foreach ($query as $row) {
        if(!isset($review[$row['id']])){
            $review[$row['id']]=$row;
            $reviewcount++;
            if($reviewcount>$limit-1)break;
        }
        $review[$row['id']]['img'][]=$row['url'];
    }
    if(!isset($review))$review=array();
    if(!isset($count['num']))$count['num']=0;
    $back['num']=$count['num'];
    $back['inf']=$review;
    return $back;

}
function getConfig($path){
    $data=file_get_contents($path);
    return json_decode($data,true);
}
function saveConfig($path,array $config){
    $data=json_encode($config);
    file_put_contents($path,$data);
}


