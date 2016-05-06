<?php


 function normalReply($weixin, $msg){
     $openid=$msg['from'];
     if($msg['MsgType']=='voice'){

     }elseif($msg['MsgType']=='img'){

     }else{
         $match=array('专武干部','应急力量','基干民兵');
         $content=$msg['content'];
         if(in_array($content,$match)){
             if($content=='专武干部'){
                 $groupid=100;
             }
             if($content=='应急力量'){
                $groupid=101;
             }
             if($content=='基干民兵'){
                 $groupid=102;
             }
             $re=changeGroup($openid,$groupid);
             mylog($re);
             $re=json_decode($re,true);
             if($re['errcode']=='0'){
                 pdoUpdate('user_tbl',array('groupid'=>$groupid),array('openid'=>$openid));
                 $weixin->replytext('已加入“'.$content.'”分组');
             }else{
                 $weixin->replytext('服务器错误，请稍后再试');
             }

//             $userInf=pdoQuery('user_tbl',null,array('openid'=>$openid),' limit 1');
//             $userInf=$userInf->fetch();
//             if(content=='');
         }
     }

 }


function expressQuery($msg,$str){
    $query=pdoQuery('user_express_query_view',null,array('id'=>$str),' limit 1');
    $content='订单'.$str;
    if($row=$query->fetch()){
        if($row['c_id']==$msg['from']){
            if($row['express_order']!=null){
                $name=$row['express_name'];
                $eorder=$row['express_order'];
                $content.='已发货'."/n".'物流公司：'.$name."/n".'物流单号：'.$eorder;
            }else{
                $content.='尚未发货';
            }
        }else{
            $content='无法查询他人创建的订单';
        }
    }else{
        $content.='不存在，请检查输入';
    }
    return $content;
}