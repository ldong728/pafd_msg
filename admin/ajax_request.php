<?php
include_once '../includePackage.php';
session_start();

if(isset($_SESSION['login'])) {
    if (isset($_POST['newGoods'])) {
        $query = pdoQuery('g_inf_tbl', array('id', 'name'), array('id' => $_POST['newGoods']), '');
        $row = $query->fetch();
        echo json_encode($row);
        exit;
    }
    //更改规格的名称售价
    if (isset($_POST['changeCategory'])) {
        pdoUpdate('g_detail_tbl', array('category' => $_POST['value']), array('id' => $_POST['d_id']));
        echo 'category update ok';
        exit;

    }
    if (isset($_POST['changeSale'])) {
        pdoUpdate('g_detail_tbl', array('sale' => $_POST['value']), array('id' => $_POST['d_id']));
        echo 'sale update ok';
        exit;

    }
    if (isset($_POST['changeWholesale'])) {
        pdoUpdate('g_detail_tbl', array('wholesale' => $_POST['value']), array('id' => $_POST['d_id']));
        echo 'wholesale update ok';
        exit;
    }
    //更改种类名称
    if(isset($_POST['alterCategory'])){
        pdoUpdate('g_inf_tbl',array('sc_id'=>$_POST['alterCategory']),array('id'=>$_POST['g_id']));
        echo 'ok';
        exit;
    }
    if (isset($_POST['set_cover_id'])) {
        pdoUpdate('g_image_tbl', array('front_cover' => 0), array('g_id' => $_POST['g_id']));
        pdoUpdate('g_image_tbl', array('front_cover' => 1), array('id' => $_POST['set_cover_id']));
        echo 'set ok';
        exit;


    }
    if (isset($_POST['addNewCategory'])) {
        $d_id = pdoInsert('g_detail_tbl', array('g_id' => $_POST['g_id']));
        echo $d_id;
        exit;

    }
    if(isset($_POST['getConfigCate'])){
        $query=pdoQuery('sub_category_tbl',null,array('id'=>$_POST['sc_id']),' limit 1');
        $inf=$query->fetch();
        $inf=json_encode($inf,JSON_UNESCAPED_UNICODE);
        echo $inf;
        exit;
    }
    if(isset($_POST['configCate'])){
        pdoUpdate('sub_category_tbl',array('name'=>$_POST['name'],'e_name'=>$_POST['e_name']),array('id'=>$_POST['sc_id']));
        echo 'ok';
        exit;
    }
    if(isset($_POST['delCate'])){
        pdoDelete('sub_category_tbl',array('id'=>$_POST['sc_id']));
        pdoUpdate('g_inf_tbl',array('sc_id'=>'-1'),array('sc_id'=>$_POST['sc_id']));
        init();
        echo 'ok';
        exit;
    }
    if(isset($_POST['remarkAlter'])){
        pdoUpdate('index_remark_tbl',array('title'=>$_POST['title'],'remark'=>$_POST['remark']),array('id'=>$_POST['id']));
        echo 'ok';
        exit;
    }
//    if (isset($_POST['countryCheck'])) {
//        if ($_POST['sc_id'] == 0) {
//            $query = 'SELECT id,name FROM g_inf_tbl WHERE made_in = :country';
//            $myquery = $pdo->prepare($query);
//            $myquery->bindValue(':country', $_POST['countryCheck']);
//            $myquery->execute();
//        } else {
//            $query = 'SELECT id,name FROM g_inf_tbl WHERE made_in = :country AND g_inf_tbl
//            .sc_id = :sc_id';
//            $myquery = $pdo->prepare($query);
//            $myquery->bindValue(':country', $_POST['countryCheck']);
//            $myquery->bindValue(':sc_id', $_POST['sc_id']);
//            $myquery->execute();
//        }
//        $back = '<option value = "0">请选择商品</option>';
//        foreach ($myquery as $row) {
//            $back = $back . '<option value = "' . $row['id'] . '">' . $row['name'] . '</option>';
//        }
//        echo $back;
//        exit;
//    }
    if (isset($_POST['categoryCheck'])) {
        $where=array('sc_id'=>$_POST['categoryCheck'],'situation'=>$_POST['situation']);
        $myquery=pdoQuery('g_inf_tbl',array('id','name'),$where,null);
        $back = '<option value = "0">请选择商品</option>';
        foreach ($myquery as $row) {
            $back = $back . '<option value = "' . $row['id'] . '">' . $row['name'] . '</option>';
        }
        echo $back;
        exit;
    }
    if (isset($_POST['filte'])) {
        $where = array();
        if ($_POST['made_in'] != 'none') {
            $where['made_in'] = $_POST['made_in'];
        }
        if ($_POST['sc_id'] != 'none') {
            $where['sc_id'] = $_POST['sc_id'];
        }
        $query = pdoQuery('g_detail_view', null, $where, 'and d_id not in (select d_id from promotions_tbl)');
        $data = array();
        foreach ($query as $row) {
            $data[] = $row;
        }
//    echo $_POST['made_in'].'and'.$_POST['sc_id'];
//    exit;
        $json = json_encode($data);
        echo $json;
        exit;
    }
    if (isset($_POST['adfilte'])) {
        $where = array();
        if ($_POST['made_in'] != 'none') {
            $where['made_in'] = $_POST['made_in'];
        }
        if ($_POST['sc_id'] != 'none') {
            $where['sc_id'] = $_POST['sc_id'];
        }
        $query = pdoQuery('g_inf_tbl', array('id', 'name', 'on_ad'), $where, null);
        $data = array();
        foreach ($query as $row) {
            $data[] = $row;
        }
        $json = json_encode($data);
        echo $json;
        exit;


    }
    if (isset($_POST["get_g_inf"])) {
        $query = pdoQuery('g_inf_tbl', array('name', 'intro','inf','situation','sc_id','produce_id','made_in'), array('id' => $_POST['g_id']), ' limit 1');
        if ($goodsInf = $query->fetch()) {
            $back['goodsInf']=$goodsInf;
            $sc_id=$back['goodsInf']['sc_id'];
            $query = pdoQuery('g_detail_tbl', array('id', 'category', 'sale', 'wholesale'), array('g_id' => $_POST['g_id']), null);
            foreach ($query as $detailRow) {
                $back['detail'][]=$detailRow;
            }
            $img = pdoQuery('g_image_tbl', array('id', 'url', 'front_cover','remark'), array('g_id' => $_POST['g_id']), ' order by id asc');
            foreach($img as $imgrow){
                $back['img'][]=$imgrow;
            }
            $parts=pdoQuery('admin_parts_view',null,array('g_id'=>$_POST['g_id']),null);
            foreach($parts as $partRow){
                $back['parts'][]=$partRow;
            }
            if(!isset($back['parts'])){
                $cooplist=pdoQuery('g_inf_tbl',array('id','name','produce_id'),array('situation'=>'1'),null);
                foreach ($cooplist as $cooprow) {
                    $coops[$cooprow['id']]=$cooprow;
                }
                $coopChoosen=pdoQuery('coop_tbl',null,array('g_id'=>$_POST['g_id']),null);
                foreach ($coopChoosen as $ccrow) {
                    $coops[$ccrow['part_g_id']]['checked']=1;
                }
                $back['coop']=$coops;
//                mylog(getArrayInf($back['coop']));
            }
            $back['parm']=getGoodsPar($_POST['g_id'],$sc_id);
            $afterQuery=pdoQuery('after_inf_tbl',null,array('g_id'=>$_POST['g_id']),' limit 1');
            $after=$afterQuery->fetch();
            $back['afterInf']=$after['after_inf'];
            $jsonBack=json_encode($back,JSON_UNESCAPED_UNICODE);
//            mylog($jsonBack);
            echo $jsonBack;
            exit;
        }
    }
    if(isset($_POST['get_parts_inf'])){
        $query=pdoQuery('parts_view',null,array('g_id'=>$_POST['g_id']),' limit 1');
        if($partsInf=$query->fetch()){
            $back['goodsInf']=$partsInf;
        }
        $sc_id=$back['goodsInf']['sc_id'];
        $query=pdoQuery('g_inf_tbl',array('id','name','produce_id'),array('sc_id'=>$sc_id,'situation'=>1),null);
        foreach ($query as $row) {
            $back['hostGoods'][$row['id']]=$row;
        }
        $Query=pdoQuery('part_tbl',array('g_id'),array('part_g_id'=>$_POST['g_id']),null);
        foreach ($Query as $row) {
            $back['hostGoods'][$row['g_id']]['checked']=1;
        }

        $jsonBack=json_encode($back,JSON_UNESCAPED_UNICODE);
        echo $jsonBack;
        exit;
    }
    if (isset($_POST['start_time_change'])) {
        pdoUpdate('promotions_tbl', array('start_time' => $_POST['value']), array('id' => $_POST['id']));
        echo $_POST['value'];
        exit;
    }
    if (isset($_POST['end_time_change'])) {
        pdoUpdate('promotions_tbl', array('end_time' => $_POST['value']), array('id' => $_POST['id']));
        echo $_POST['value'];
        exit;
    }
    if (isset($_POST['price_change'])) {
        pdoUpdate('promotions_tbl', array('price' => $_POST['value']), array('id' => $_POST['id']));
        echo $_POST['value'];
        exit;
    }
    if (isset($_POST['p_name_change'])){
        pdoUpdate('promotions_tbl', array('p_name' => $_POST['value']), array('id' => $_POST['id']));
        echo $_POST['value'];
        exit;
    }
    if (isset($_POST['time_filter'])) {
        $preWhere = '';
        switch ($_POST['time_filter']) {

            case 'on': {
                $preWhere = ' where now()<end_time and now()>start_time';
                break;
            }
            case 'before': {
                $preWhere = ' where now()<start_time';
                break;
            }
            case 'after': {
                $preWhere = 'where now()>end_time';
                break;
            }
            default: {
            break;
            }
        }
        $data = array();
        $query = pdoQuery('promotions_view', null, null, $preWhere);
        foreach ($query as $row) {
            $date[] = array(
                'id' => $row['id'],
                'd_id' => $row['d_id'],
                'name' => $row['name'],
                'category' => $row['category'],
                'sale' => $row['sale'],
                'price' => $row['price'],
                'start_time' => date("Y-m-d\TH:i:s", strtotime($row['start_time'])),
                'end_time' => date("Y-m-d\TH:i:s", strtotime($row['end_time'])),
                'img'=>$row['img'],
                'p_name'=>$row['p_name']
            );
        }
        $json = json_encode($date);
//    mylog($json);
        echo $json;
        exit;
    }
    if (isset($_POST['switch_ad'])) {
//    $inf=pdoUpdate('g_inf_tbl',array('on_ad'=>"on_ad+1"),array('id'=>$_POST['ad_g_id']));
        $sqlstr = 'update g_inf_tbl set on_ad=on_ad+1 where id=' . $_POST['ad_g_id'];
        $inf = exeNew($sqlstr);
        echo $inf;
        exit;
    }
    if(isset($_POST['getOrderDetail'])){
        $query=pdoQuery('user_order_view',null,array('o_id'=>$_POST['o_id']),null);
        $recordQuery=pdoQuery('order_record_tbl',null,array('order_id'=>$_POST['o_id']),null);
        foreach ($recordQuery as $row) {
            $record[]=$row;
        }
        if(!isset($record))$record=array();

        foreach ($query as $row) {
            $detail['orderInf'][]=$row;
        }
        $detail['record']=$record;
//        mylog(getArrayInf($record));
        echo json_encode($detail);
    }
    if(isset($_POST['changeCateHome'])){
        $configPath=$GLOBALS['mypath'].'/mobile/config/config.json';
        pdoUpdate('category_tbl',array('remark'=>$_POST['stu']),array('id'=>$_POST['id']));
        $query=pdoQuery('category_tbl',array('count(*) as num'),array('remark'=>'home'),null);
        $num=$query->fetch();
        $config=getConfig($configPath);
        $config['cateWidth']=100/$num['num']<20? 20:100/$num['num'];
        saveConfig($configPath,$config);
        echo 'ok';
        exit;
    }
    if(isset($_POST['add_sc_parm'])){
        for($i=25;$i>0;$i--){
            $colList[]='col'.$i;
        }
        $colQuery=pdoQuery('par_col_tbl',array('col_name'),array('sc_id'=>$_POST['sc_id']),null);
        $colExist=array();
        foreach ($colQuery as $row) {
            $colExist[]=$row['col_name'];
        }
        $namePool=array_diff($colList,$colExist);
        $col_name=array_pop($namePool);
//        mylog($col_name);
        $id=pdoInsert('par_col_tbl',array('sc_id'=>$_POST['sc_id'],'col_name'=>$col_name,'name'=>$_POST['name'],
            'par_category'=>$_POST['par_category'],'dft_value'=>$_POST['dft_value']),'update');
        echo $id;
        exit;
    }
    if(isset($_POST['get_sc_parm'])){
        $query=pdoQuery('par_col_tbl',null,array('sc_id'=>$_POST['sc_id']),'');
        $remark=pdoQuery('sub_category_tbl',null,array('id'=>$_POST['sc_id']),' limit 1');
        $remark=$remark->fetch();
        $parList=array();
        foreach($query as $row){
            $parList[$row['par_category']][]=$row;
        }
        $data=array('remark'=>$remark['remark'],'parm'=>$parList);
        $data=json_encode($data);

        echo $data;
        exit;
    }
    if(isset($_POST['del_sc_parm'])){
        pdoDelete('par_col_tbl',array('id'=>$_POST['id']));
        echo 'ok';
        exit;
    }
    if(isset($_POST['del_parm'])){
//        mylog($_POST['cate']);
        pdoDelete('par_col_tbl',array('sc_id'=>$_POST['sc_id'],'par_category'=>$_POST['cate']));
        echo 'ok';
        exit;
    }
    if(isset($_POST['cateRemark'])){
        $content=addslashes($_POST['content']);
        pdoUpdate('sub_category_tbl',array('remark'=>$content),array('id'=>$_POST['sc_id']));
        echo 'ok';
        exit;
    }
    if(isset($_POST['p_alt_key'])){
        pdoUpdate('par_col_tbl',array('name'=>$_POST['value']),array('id'=>$_POST['p_alt_key']));
        echo 'ok';
        exit;
    }
    if(isset($_POST['hostGoodsSet'])){
//        mylog($_POST['situation']);

        if($_POST['situation']=='true'){
            pdoInsert('part_tbl',array('g_id'=>$_POST['g_id'],'part_g_id'=>$_POST['part_g_id']),'ignore');
        }else{
//            mylog('delete');
            pdoDelete('part_tbl',array('g_id'=>$_POST['g_id'],'part_g_id'=>$_POST['part_g_id']));
        }
        echo 'ok';
        exit;

    }
    if(isset($_POST['del_g_img'])){
        $urlquery=pdoQuery('g_image_tbl',array('url'),array('g_id'=>$_POST['g_id'],'remark'=>$_POST['md5']),'limit 1');
        $url=$urlquery->fetch();
        pdoDelete('g_image_tbl',array('g_id'=>$_POST['g_id'],'remark'=>$_POST['md5']));
        $query1=pdoQuery('image_view',array('id'),array('remark'=>$_POST['md5']),' limit 1');
        $query2=pdoQuery('ad_tbl',array('id'),array('img_url'=>$url['url']),' limit 1');
        if(!$query1->fetch()&&!$query2->fetch()){
            unlink('../'.$url['url']);
        }
        echo 'ok';
        exit;
    }
    if(isset($_POST['del_front_img'])){
        $query=pdoQuery('ad_tbl',array('img_url'),array('id'=>$_POST['id']),null);
        $row=$query->fetch();
        pdoDelete('ad_tbl',array('id'=>$_POST['id']));
        $tquery=pdoQuery('image_view',null,array('url'=>$row['img_url']),' limit 1');
        if(!$tquery->fetch()){
            unlink('../'.$row['img_url']);
        }
        echo 'ok';
        exit;
    }
    if(isset($_POST['change_part_stu'])){
        pdoUpdate('part_tbl',array('dft_check'=>$_POST['value']),array('id'=>$_POST['id']));
        echo $_POST['value'];
        exit;
    }
    if(isset($_POST['change_coop_stu'])){
        if($_POST['value']==0){
            pdoDelete('coop_tbl',array('part_g_id'=>$_POST['part_id'],'g_id'=>$_POST['g_id']));
            $data=0;
        }else if($_POST['value']==1){
            pdoInsert('coop_tbl',array('part_g_id'=>$_POST['part_id'],'g_id'=>$_POST['g_id']),'ignore');
            $data=1;
        }
        echo $data;
        exit;
    }
    if(isset($_POST['manageReview'])){
        $id=pdoUpdate('review_tbl',array('priority'=>$_POST['priority'],'public'=>$_POST['public']),array('id'=>$_POST['id']));
        echo $id;
    }
    if(isset($_POST['operator'])){
        if($_POST['altPms']){
            if($_POST['stu']=='true'){
                pdoInsert('op_pms_tbl',array('o_id'=>$_POST['id'],'pms'=>$_POST['altPms']),'ignore');
                echo 'ok';
            }else{
                pdoDelete('op_pms_tbl',array('o_id'=>$_POST['id'],'pms'=>$_POST['altPms']));
                echo 'ok';
            }
            exit;
        }
        if(isset($_POST['altName'])){
            pdoUpdate('operator_tbl',array('name'=>$_POST['altName']),array('id'=>$_POST['id']));
            echo 'ok';
            exit;
        }
        if(isset($_POST['altPwd'])){
            pdoUpdate('operator_tbl',array('pwd'=>$_POST['altPwd'],'md5'=>md5($_POST['altPwd'])),array('id'=>$_POST['id']));
            echo 'ok';
            exit;
        }
        if(isset($_POST['new'])){
            pdoInsert('operator_tbl',array('name'=>$_POST['new'],'pwd'=>$_POST['pwd'],'md5'=>md5($_POST['pwd'])),'ignore');
            echo 'ok';
            exit;
        }
        exit;
    }
    if(isset($_POST['alteTblVal'])){
//        mylog(getArrayInf($_POST));
        $data=pdoUpdate($_POST['tbl'],array($_POST['col']=>$_POST['value']),array($_POST['index']=>$_POST['id']));
        echo $data;
        exit;
    }
    if(isset($_POST['altConfig'])){
        mylog($_POST['key'].$_POST['value']);
        $config=getConfig('../mobile/config/config.json');
        $config[$_POST['key']]=$_POST['value'];
        saveConfig('../mobile/config/config.json',$config);
        echo 'ok';
        exit;
    }

    if(isset($_POST['sdp'])){
        if(isset($_POST['addSdpLevel'])){
            $id=pdoInsert('sdp_level_tbl',array('level_name'=>'新建分销商','discount'=>1,'min_sell'=>1,'max_sell'=>1));
            echo $id;
            exit;
        }
        if(isset($_POST['alterSdpLevel'])){
            $sdp_id=$_POST['sdp_id'];
            $level=$_POST['alterSdpLevel'];
            pdoDelete('sdp_gainshare_tbl',array('root'=>$sdp_id));//清除用户自设的佣金比例
            pdoDelete('sdp_price_tbl',array('sdp_id'=>$sdp_id));//清除用户自设的商品价格
            if(1==$level){
                $rootQuery=pdoQuery('sdp_relation_view',array('root','level'),array('sdp_id=>$sdp_id'),' limit 1');
                $r=$rootQuery->fetch();
                if($r['level']>1){
                    $fullQuery=pdoQuery('sdp_relation_tbl',array('sdp_id','f_id'),array('root'=>$sdp_id),null);
                    foreach ($fullQuery as $row) {
                        $fullList[$row['f_id']]=$row['sdp_id'];
                    }
                    $list=getSubSdp($fullList,array($sdp_id));
                    pdoUpdate('sdp_relation_tbl',array('root'=>'root'),array('sdp_id'=>$list));
                    pdoInsert('sdp_relation_tbl',array('sdp_id'=>$sdp_id,'f_id'=>'root','root'=>'id'),'update');
                }
            }elseif($level>1){
                $rootQuery=pdoQuery('sdp_relation_view',array('root','level'),array('sdp_id=>$sdp_id'),' limit 1');
                $r=$rootQuery->fetch();
                if($r['level']==1){
                    $root=$r['root'];
                    $fullQuery=pdoQuery('sdp_relation_tbl',array('sdp_id','f_id'),array('root'=>$root),null);
                    foreach ($fullQuery as $row) {
                        $fullList[$row['f_id']]=$row['sdp_id'];
                    }
                    $list=getSubSdp($fullList,array($sdp_id));
                    pdoUpdate('sdp_relation_tbl',array('root'=>$sdp_id),array('sdp_id'=>$list));
                    pdoDelete('sdp_relation_tbl',array('sdp_id'=>$sdp_id));
                }
                pdoUpdate('sdp_user_level_tbl',array('level'=>$level),array('sdp_id'=>$sdp_id));
                echo 'ok';
            }

        }
        if(isset($_POST['alterWholesale'])){
            $id=pdoInsert('sdp_wholesale_tbl',array('level_id'=>$_POST['alterWholesale'],'g_id'=>$_POST['g_id'],'price'=>$_POST['wholesale'],'min_sell'=>$_POST['min'],'max_sell'=>$_POST['max']),'update');
            if($id>-1){
                echo 'ok';

            }else{
                echo 'not ok';
            }
        }
        if(isset($_POST['getGainshareList'])){
            $gainshare=getGainshareConfig($_POST['root'],$_POST['g_id']);
            echo json_encode($gainshare);
            exit;
        }
        if(isset($_POST['altGainshare'])){
            $temp='hello';
            foreach ($_POST['data'] as $row) {
                $id=pdoInsert('sdp_gainshare_tbl',array('root'=>$_POST['root'],'g_id'=>$_POST['g_id'],'rank'=>(int)$row['rank'],'value'=>(float)$row['value']),'update');
            }
            echo 'ok';
            exit;
        }



        exit;
    }
}
?>