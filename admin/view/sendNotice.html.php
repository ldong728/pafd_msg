<?php $ready = $GLOBALS['ready'];
$glist = $GLOBALS['glist'];
?>

<section>
    <h2><strong>发送通知</strong></h2>
    <section>
        <ul class="ulColumn2">
       <li> <span class="item_name" style="width: 120px">提示信息：</span>
        <textarea class="textarea" class="pre_notice" placeholder="请输入通知提醒信息"style="width: 300px;height: 100px"></textarea></li>
        <li><span class="item_name" style="width: 120px">分组：</span>
        <select class="select groupid">
            <option value="-1">全部分组</option>
            <?php foreach ($glist as $row): ?>
                <option value="<?php echo $row['id'] ?>"<?php echo $row['id']?>"<?php echo $row['id']==$_GET['group_id']?'selected="selected"':''?>><?php echo $row['name'] ?></option>
            <?php endforeach ?>
        </select>
        </li>
            <li><span class="item_name" style="width: 120px">选择通知</span>
                <select class="select noticeid">
                    <option value="-1">请选择通知</option>
                    <?php foreach($ready as $row):?>
                        <option value="<?php echo $row['id']?>"<?php echo $row['id']==$_GET['notice_id']?'selected="selected"':''?>><?php echo $row['title']?></option>
                    <?php endforeach ?>
                </select>
            </li>
            <li>
                <span class="item_name" style="width: 120px"></span>
                <button class="link_btn sendNotice">发送通知</button>
            </li>
        </ul>

    </section>
    <script>
        $('.groupid').change(function () {
                var groupid = $(this).val();
                alert('ok');
                alert(groupid);
            }
        );
        $('.noticeid').change(function(){
//            alert("what?");
            var noticeid=$(this).val();
//            alert(noticeid);
//            alert($('.preview').attr('src'));
            $('.preview').attr('src','consle.php?getNotice='+noticeid);
            $('.preview').get(0).location.href='consle.php?getNotice='+noticeid;
        });
        $('.sendNotice').click(function(){

        });

    </script>

    <iframe class="iframe preview" width="480px"height="640px" src="consle.php?getNotice=<?php echo isset($_GET['notice_id'])?$_GET['notice_id']:-1?>">
        <div class="space"></div>
</section>


