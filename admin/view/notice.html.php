<?php
$notice=$GLOBALS['notice'];
$glist=$GLOBALS['glist'];
$getStr=$GLOBALS['getStr'];
$page=$GLOBALS['page'];
?>

<section>
    <h2>
        <strong>内容分类</strong>
    </h2>
    <select class="select"id="groupFilter">
        <option value="-1">全部分组</option>
        <option value="0"<?php echo isset($_GET['groupid'])&&$_GET['groupid']==0?'selected="selected"':''?>>未分组</option>
        <?php foreach($glist as $crow):?>
            <option value="<?php echo $crow['id']?>"<?php echo $_GET['groupid']==$crow['id']?'selected="selected"':''?>><?php echo $crow['name']?></option>
        <?php endforeach ?>
    </select>
    <select class="select"id="stuFilter">
        <option value="-1">状态</option>
        <option value="0" <?php echo $_GET['situation']=='0'?'selected="selected"':''?>>未发送</option>
        <option value="1"<?php echo $_GET['situation']==1?'selected="selected"':''?>>已发送</option>
    </select>

    <table class="table">
        <tr>
            <th>名称</th>
            <th>已阅数</th>
            <th>留言数</th>
        </tr>
        <?php foreach($notice as $row):?>
            <tr>
                <td><?php echo $row['title']?></td>
                <td><a href="index.php?notice=1&markList=<?php echo $row['id']?>"><?php echo $row['mark_num']?></a></td>
                <td><a href="index.php?notice=1&reviewList=<?php echo $row['id']?>"><?php echo $row['review_num']?></a></td>
            </tr>
        <?php endforeach?>

    </table>
    <aside class="paging"><?php if($page>0):?><a href="index.php?<?php echo $getStr?>&page=<?php echo $page-1?>">上一页</a><?php endif ?><a href="index.php?<?php echo $getStr?>&page=<?php echo $page+1?>">下一页</a></aside>



    <div class="space"></div>
</section>
<script>
    var getStr='<?php echo json_encode($_GET)?>';
    var getInf=eval('('+getStr+')');
    delete getInf.page;
</script>
<script>
    $('#groupFilter').change(function(){
        var id=$(this).val();
        if(id<0){
            delete getInf.groupid
        }else{
            getInf.groupid=id;
        }
        var getStr= setGetStr(getInf);
        window.location.href='index.php?'+getStr;
    });
    $('#stuFilter').change(function(){
        var id=$(this).val();
        if(id<0){
           delete getInf.situation;
        }else{
            getInf.situation =id;
        }
        getStr=setGetStr(getInf);
        window.location.href='index.php?'+getStr;
    });
</script>
<script>
    function setGetStr(getInf){
        var str='';
        $.each(getInf,function(k,v){
            str+= (k+'='+v+'&');
        });
        str=str.replace(/&$/,'');
        return str;
    }
</script>