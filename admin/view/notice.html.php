<?php
$notice=$GLOBALS['notice'];
$glist=$GLOBALS['glist'];
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



    <div class="space"></div>
</section>
<script>
    $('#groupFilter').change(function(){
        var id=$(this).val();
        if(id<0){
            window.location.href='index.php?notice=1&noticeList=0';
        }else{
            window.location.href='index.php?notice=1&noticeList=0&groupid='+id;
        }

    });
</script>