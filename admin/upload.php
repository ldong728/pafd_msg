<?php
include_once '../includePackage.php';
include_once 'upload.class.php';
session_start();
if(isset($_SESSION['login'])) {
    $uploader= new uploader();
//    if (isset($_POST['altAd'])) {
//
//        if (isset($_FILES['adPic'])) {
//            $file = $_FILES['adPic'];
//            if (fileFilter($file, array('image/gif', 'image/jpeg', 'image/pjpeg','image/png'), 500000)) {
//                $temp = move_uploaded_file($file['tmp_name'], $_POST['adImg']);
//                if (false == $temp) mylog('fileerrer');
//            }
//        }
//        if (isset($_POST['g_id'])) {
//            pdoUpdate('ad_tbl', array('g_id' => $_POST['g_id']), array('id' => $_POST['altAd']));
//        }
//        header('location:index.php?ad=1');
//        exit;
//    }
    if (isset($_GET['infImgUpload'])){
        $file=$_FILES['upfile'];
        $uploader->upFile(time().rand(1000,9999));
        $inf=$uploader->getFileInfo();
        $jsonInf=json_encode($inf,JSON_UNESCAPED_UNICODE);
        echo $jsonInf;
        if('SUCCESS'==$inf['state']) {
            pdoInsert('inf_image_tbl', array('url' => $inf['url'], 'remark' => $inf['md5']), 'ignore');
        }
        exit;
    }
    if(isset($_FILES['g-img-up'])){
        $uploader=new uploader('g-img-up');
        $uploader->upFile($_GET['g_id'].'_'.time().rand(1000,9999));
        $inf=$uploader->getFileInfo();

        if('SUCCESS'==$inf['state']) {
            $query=pdoQuery('image_view',array('g_id'),array('g_id'=>$_GET['g_id']),null);
            $is_cover='0';
            if(!$query->fetch()){
                $is_cover='1';
                $inf['cover']=true;
            }
           $id= pdoInsert('g_image_tbl', array('g_id' => $_GET['g_id'], 'url' => $inf['url'], 'remark' => $inf['md5'],'front_cover'=>$is_cover), '');
            $inf['id']=$id;
        }
        $jsonInf=json_encode($inf,JSON_UNESCAPED_UNICODE);
//        mylog($jsonInf);
        echo $jsonInf;
        exit;
    }
    if(isset($_GET['alt_img'])){
        $query=pdoQuery('g_image_tbl',null,array('id'=>$_GET['alt_img']),' limit 1');
        $old_img=$query->fetch();
        $uploader=new uploader('alt_img'.$_GET['alt_img']);
        $uploader->upFile($_GET['g_id'].'_'.time().rand(1000,9999));
        $inf=$uploader->getFileInfo();
        $id=pdoUpdate('g_image_tbl',array('url'=>$inf['url'],'remark'=>$inf['md5']),array('id'=>$_GET['alt_img']));

        $query1=pdoQuery('image_view',array('id'),array('remark'=>$old_img['md5']),' limit 1');
        $query2=pdoQuery('ad_tbl',array('id'),array('img_url'=>$old_img['url']),' limit 1');
        if(!$query1->fetch()&&!$query2->fetch()){
            unlink('../'.$url['url']);
        }
        $jsonInf=json_encode($inf,JSON_UNESCAPED_UNICODE);
        echo $jsonInf;

        exit;
    }
    if(isset($_FILES['front-img-up'])){
        $uploader=new uploader('front-img-up');
        $uploader->upFile('9999_'.time().rand(1000,9999));
//        mylog('frontUp');
        $inf=$uploader->getFileInfo();
        if('SUCCESS'==$inf['state']) {
            $id= pdoInsert('ad_tbl', array('category'=>'banner', 'img_url' => $inf['url']), '');
            $inf['id']=$id;
        }
//        header('contentType:application/json');
        $jsonInf=json_encode($inf,JSON_UNESCAPED_UNICODE);
//        mylog('imgUploaded:'.$jsonInf);
        echo $jsonInf;
        exit;
    }
    if(isset($_FILES['parts-img-up'])){
        $uploader=new uploader('parts-img-up');
        $uploader->upFile($_GET['g_id'].'_'.time().rand(1000,9999));
        $inf=$uploader->getFileInfo();
        $jsonInf=json_encode($inf,JSON_UNESCAPED_UNICODE);

        if('SUCCESS'==$inf['state']) {
//            mylog('success');
            $temp=pdoQuery('g_image_tbl',null,array('g_id'=>$_GET['g_id']),'limit 1');
            if(!$row=$temp->fetch()){
                pdoInsert('g_image_tbl', array('g_id' => $_GET['g_id'], 'url' => $inf['url'], 'remark' => $inf['md5'],'front_cover'=>'1'), 'ignore');
//                mylog("create record");
            }else{
                pdoUpdate('g_image_tbl',array('remark'=>$inf['md5'],'url'=>$inf['url'],'front_cover'=>'1'),array('g_id'=>$_GET['g_id']));
                $query=pdoQuery('image_view',null,array('remark'=>$row['remark']), ' limit 1');
                if(!$t=$query->fetch()){
                    unlink('../'.$row['url']);
//                    mylog('unlink"../'.$row['url']);
                }else{
//                    mylog('not unlink');
                }

            }

        }
//        mylog($jsonInf);
        echo $jsonInf;
        exit;
    }
    if(isset($_GET['proImgUp'])){
        foreach($_FILES as $k=>$v) {
            $uploader = new uploader($k);
            $uploader->upFile($k);
            $inf = $uploader->getFileInfo();
            $jsonInf = json_encode($inf, JSON_UNESCAPED_UNICODE);
            if ('SUCCESS' == $inf['state']) {
                pdoUpdate('promotions_tbl', array( 'img' => $inf['url']), array('id' => $_GET['proImgUp']));
                echo $jsonInf;
            }
        }
        exit;
    }
    if(isset($_GET['index_remark_img'])){
        foreach($_FILES as $k=>$v) {
            $uploader = new uploader($k);
            $uploader->upFile($k);
            $inf = $uploader->getFileInfo();
            $jsonInf = json_encode($inf, JSON_UNESCAPED_UNICODE);
//            mylog($jsonInf);
            if ('SUCCESS' == $inf['state']) {
                pdoUpdate('index_remark_tbl', array( 'img' => $inf['url']), array('id' => $_GET['index_remark_img']));
                echo $jsonInf;
            }
        }
        exit;
    }
    if(isset($_FILES['card-img-up'])){
        $uploader = new uploader('card-img-up');
        $uploader->upFile('cardLogo');
        $inf=$uploader->getFileInfo();
        include_once '../wechat/cardManager.php';
        $logo=uploadLogo($GLOBALS['mypath'].'/'.$inf['url']);
        if($logo!='error'){
            $inf['logo']=$logo;

            echo json_encode($inf);
        }else{
            $inf['state']='logo Error';
            echo json_encode($inf);
        }
    }
    exit;
}
function fileFilter($file, array $type, $size)
{
    if (in_array($file['type'], $type) && $file['size'] < $size) {
        if ($file['error'] > 0) {
            return false;
        } else {
            return true;
        }
    } else {
        return false;
    }
}
?>