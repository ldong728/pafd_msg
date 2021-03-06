<?php
/**
 * Created by PhpStorm.
 * User: godlee
 * Date: 2015/10/26
 * Time: 13:09
 */
include_once '../includePackage.php';;
session_start();

if(isset($_SESSION['customerId'])){
    if(isset($_POST['alterCart'])){
        pdoUpdate('cart_tbl',array('number'=>$_POST['number']),array('c_id'=>$_SESSION['customerId'],'id'=>$_POST['cart_id']));
        echo 'ok';
        exit;
    }
    if(isset($_POST['alterPartCart'])){
        pdoUpdate('part_cart_tbl',array('part_number'=>$_POST['number']),array('part_id'=>$_POST['g_id'],'cart_id'=>$_POST['cart_id']));
        echo 'ok';
        exit;
    }
    if(isset($_POST['deleteCart'])){
        pdoDelete('cart_tbl',array('c_id'=>$_SESSION['customerId'],'id'=>$_POST['cart_id']));
        pdoDelete('part_cart_tbl',array('cart_id'=>$_POST['cart_id']));
        echo 'ok';
        exit;
    }
    if(isset($_POST['altAddr'])){
        $addrquery=pdoQuery('address_tbl',null,array('id'=>$_POST['id']),' limit 1');
        $addr=$addrquery->fetch();
        echo json_encode($addr);
        exit;

    }
    if(isset($_POST['deleteAddr'])){
        pdoDelete('address_tbl',array('id'=>$_POST['id']));
        echo 'ok';
        exit;
    }
    if(isset($_POST['addrNumRequest'])){
        $query=pdoQuery('address_tbl',array('count(*) as num'),array('c_id'=>$_SESSION['customerId']),'');
        $num=$query->fetch();
        echo $num['num'];
    };
    if(isset($_POST['setDefaultAdress'])){
      pdoUpdate('address_tbl',array('dft_a'=>0),array('c_id'=>$_SESSION['customerId']));
        pdoUpdate('address_tbl',array('dft_a'=>1),array('id'=>$_POST['id']));
        echo 'ok';
        exit;
    };
    if(isset($_GET['getOrderList'])){
        $where=array('c_id'=>$_SESSION['customerId']);
        foreach ($_POST as $k=>$v) {
            if($v==1){
                $where[$k]=array(1,9);
            }else{
                $where[$k]=$v;
            }
        }

        $query=pdoQuery('order_tbl',null,$where,'');
        $list=array();
        foreach ($query as $row) {
            $list[]=array(
                'id'=>$row['id'],
                'stu'=>getOrderStu($row['stu'])
            );
        }
        echo json_encode($list);

    }
    if(isset($_POST['addToFav'])){
        pdoInsert('favorite_tbl',array('c_id'=>$_SESSION['customerId'],'g_id'=>$_POST['g_id']),'ignore');
        echo('ok');
        exit;
    }
    if(isset($_POST['deletFav'])){
        pdoDelete('favorite_tbl',array('g_id'=>$_POST['g_id'],'c_id'=>$_SESSION['customerId']));
        echo 'ok';
        exit;
    }
    if(isset($_POST['changePart'])){
        if($_POST['mode']=='true'){
            unset($_SESSION['buyNow']['partsList'][$_POST['part_id']]);
        }else{
            $_SESSION['buyNow']['partsList'][$_POST['part_id']]=$_POST['number'];
        }
//        mylog(getArrayInf($_SESSION['buyNow']['partsList']));
        echo 'ok';
        exit;
    }
    if(isset($_POST['buyNow'])){
//        pdoQuery('g_inf_tbl',null,array('sc_id'=>'5','id'=>array('4','5')),null);
//        pdoQuery('g_inf_tbl',null,array('sc_id'=>5,'id'=>array(4,5)),null);
//        pdoQuery('g_inf_tbl',null,array('sc_id'=>'5','id'=>array(4,5)),null);
        exit;
    }
    if(isset($_POST['userRemark'])){
        $_SESSION['customer_remark']=html(trim($_POST['remark']));
        echo 'ok';
        exit;

    }
    if(isset($_POST['submitReview'])){
        $insert=array(
            'c_id'=>$_SESSION['customerId'],
            'order_id'=>$_POST['order_id'],
            'g_id'=>$_POST['g_id'],
            'd_id'=>$_POST['d_id'],
            'score'=>$_POST['score'],
        );
        if(isset($_POST['review'])&&$_POST['review']!=''){
            $insert['review']=html(trim($_POST['review']));
        }
        $id=pdoInsert('review_tbl',$insert,'ignore');

        $v1q=pdoQuery('review_tbl',array('count(*) as num'),array('order_id'=>$_POST['order_id']),null);
        $reviewed=$v1q->fetch();
        $v2q=pdoQuery('user_input_review_view',array('count(*) as num'),array('order_id'=>$_POST['order_id']),null);
        $unreview=$v2q->fetch();
        if($reviewed['num']==$unreview['num']){
            pdoUpdate('order_tbl',array('stu'=>'3'),array('id'=>$_POST['order_id']));
            echo'done';
        }else{
            echo $id;
        }
        foreach ($_POST['image'] as $row) {
            include_once $GLOBALS['mypath'] . '/wechat/serveManager.php';
            $imgPath='g_img/'.$row.'.jpg';
            downloadImgToHost($row,$mypath.'/'.$imgPath);
            pdoInsert('review_img_tbl',array('review_id'=>$id,'url'=>$imgPath,'remark'=>md5_file($imgPath)));
        }
        exit;
    }
    if(isset($_POST['linkKf'])){
        include_once $GLOBALS['mypath'] . '/wechat/serveManager.php';
        if($_POST['gid']!=-1){
            $inf=pdoQuery('user_g_inf_view',null,array('g_id'=>$_POST['gid']),' limit 1');
            $ginf=$inf->fetch();
            $string='当前商品：'.$ginf['produce_id'];
            $response=linkKf($_SESSION['customerId'],'default',$string);
        }else{
            $response=linkKf($_SESSION['customerId'],'default');
        }

        echo $response;
        exit;
    }
    if(isset($_GET['chooseCard'])){
        $card_id=$_POST['card_id'];
        $encrypt_code=$_POST['encrypt_code'];
        $total_price=$_POST['totalPrice'];
        include_once '../wechat/cardManager.php';
        $cardinf=getCardCode($encrypt_code);
//        mylog(getArrayInf($cardinf));
        $save=-1000;
        $cardCode=$cardinf['card']['card_code'];
        if($cardinf['can_consume']==1) {
            $data = getCardDetail($card_id);
            $dataArray = json_decode($data, true);
            $cardType = $dataArray['card']['card_type'];

            switch ($cardType) {
                case 'CASH': {
                    $least_cost = $dataArray['card']['cash']['least_cost'] / 100;
                    $reduce_cost = $dataArray['card']['cash']['reduce_cost'] / 100;
                    if ($total_price > $least_cost) {
                        $save = $reduce_cost;
//                    $price=$total_price-$reduce_cost;
                    } else {
                        $save = -1000;
                    }
                    break;
                }
                case 'DISCOUNT': {
                    $discount = $dataArray['card']['discount']['discount'] / 100;
                    $save = $total_price * $discount;
                    break;
                }
                default: {
                break;
                }
            }
            pdoInsert('card_record_tbl',array('card_code'=>$cardCode,'card_id'=>$card_id,'fee'=>$save),'update');
        }

        $return=array('save'=>$save,'cardId'=>$card_id,'cardCode'=>$cardCode);
        $return=json_encode($return);
        echo $return;

        exit;
    }
    if(isset($_POST['getMedia'])){
        $mediaId=$_POST['mediaId'];
        include_once $GLOBALS['mypath'] . '/wechat/serveManager.php';
        $imgPath='g_img/review_img/'.$_POST['mediaId'].'.jpg';
        downloadImgToHost($mediaId,$imgPath);
//        pdoInsert('review_img_tbl')
        $response=array('url'=>$imgPath);
        $response=json_encode($response,JSON_UNESCAPED_UNICODE);
        echo $imgPath;
    }
    if(isset($_POST['cancel_order'])){
        $orderstu=pdoQuery('order_tbl',array('stu'),array('id'=>$_POST['order_id']),' limit 1');
        $stu=$orderstu->fetch();
        if(isset($stu['stu'])){
            if($stu['stu']==0){
                pdoDelete('order_tbl',array('id'=>$_POST['order_id']));
                pdoDelete('order_detail_tbl',array('o_id'=>$_POST['order_id']));
                echo 0;
                exit;
            }
            if($stu['stu']==1){
                echo 1;
                exit;
            }

        }
        echo -1;
        exit;
    }
    if(isset($_POST['sdp'])){
        if(isset($_POST['create_sdp'])){
            createSdp($_POST['phone']);
            echo ('ok');
            exit;
        }
        if($_SESSION['sdp']['level']>1){
            if(isset($_POST['alterSdpPrice'])){
                $priceLimit=pdoQuery('sdp_wholesale_tbl',null,array('level_id'=>$_SESSION['sdp']['level'],'g_id'=>$_POST['g_id']),' limit 1');
                if($priceLimit=$priceLimit->fetch()){
                    if((float)$_POST['price']<$priceLimit['min_sell']||(float)$_POST['price']>$priceLimit['max_sell']){
                        echo 'not ok';
                        exit;
                    }else{

                    }
                }

                $id=pdoInsert('sdp_price_tbl',array('sdp_id'=>$_SESSION['sdp']['root'],'g_id'=>$_POST['g_id'],'price'=>(float)$_POST['price']),'update');
                if($id>-1){
                    $_SESSION['sdp']['price'][$_POST['g_id']]=$_POST['price'];
                    echo 'ok';
                    exit;
                }else{
                    echo ' not ok';
                    exit;
                }
             }
        }
        if(isset($_POST['altGainshare'])){
            if($_SESSION['sdp']['level']>1){
            foreach ($_POST['data'] as $row) {
                $id=pdoInsert('sdp_gainshare_tbl',array('root'=>$_SESSION['sdp']['root'],'rank'=>(int)$row['rank'],'value'=>(float)$row['value'],'g_id'=>$_POST['g_id']),'update');
            }
            echo 'ok';
            exit;
            }
        }
    }

}

//未登录
if(isset($_POST['inputReview'])){
    $reviewTimeout=30;
    $openid=$_POST['openid'];
    $query=pdoQuery('review_tbl',array('review_time'),array('open_id'=>$openid),' order by review_time desc limit 1');
    if($time=$query->fetch()){
        $waite=$reviewTimeout-(time()-strtotime($time['review_time']));
        if($waite>0){
            echo $waite;
            exit;
        }
    }
    $content=html($_POST['content']);
    $noticeid=$_POST['noticeid'];
    $f_id=$_POST['f_id'];
    $id=pdoInsert('review_tbl',array('notice_id'=>$noticeid,'open_id'=>$openid,'content'=>addslashes($content),'f_id'=>$f_id));
    echo 'ok';
    exit;
}
