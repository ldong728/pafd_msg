<?php
$reviewList=$GLOBALS['reviewList'];
?>
<h2>
    <strong>留言列表</strong>
</h2>
<table class="table">
    <tr>
        <th>昵称</th>
        <th>内容</th>
        <th>发表时间</th>
        <th>操作</th>
    </tr>
    <?php foreach($reviewList as $row):?>
        <tr>
            <td><?php echo $row['nickname']?></td>
            <td><?php echo $row['content']?></td>
            <td><?php echo $row['review_time'] ?></td>
            <td>
                <a class="inner_btn delete"id="<?php echo $row['id']?>">删除</a>
            </td>
        </tr>
    <?php endforeach?>

</table>
<aside class="paging"><?php if($page>0):?><a href="index.php?notice=1&reviewList=<?php echo $_GET['reviewList']?>&page=<?php echo $page-1?>">上一页</a><?php endif ?><a href="index.php?notice=1&reviewList=<?php echo $_GET['reviewList']?>&page=<?php echo $page+1?>">下一页</a></aside>




<div class="space"></div>
</section>
<script>


</script>