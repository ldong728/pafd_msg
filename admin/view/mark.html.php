<?php
$markList=$GLOBALS['markList'];
?>
<h2>
    <strong>已读列表</strong>
</h2>
<table class="table">
    <tr>
        <th>昵称</th>
        <th>阅读时间</th>
        <th>操作</th>
    </tr>
    <?php foreach($markList as $row):?>
        <tr>
            <td><?php echo $row['nickname']?></td>
            <td><?php echo $row['mark_time'] ?></td>
            <td>
                <a class="inner_btn delete"id="<?php echo $row['id']?>">删除</a>
            </td>
        </tr>
    <?php endforeach?>

</table>
<aside class="paging"><?php if($page>0):?><a href="index.php?notice=1&reviewList=<?php echo $_GET['markList']?>&page=<?php echo $page-1?>">上一页</a><?php endif ?><a href="index.php?notice=1&reviewList=<?php echo $_GET['markList']?>&page=<?php echo $page+1?>">下一页</a></aside>




<div class="space"></div>
</section>
<script>


</script>