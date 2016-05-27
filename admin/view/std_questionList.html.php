<?php
$type = $GLOBALS['type'];
$nearList = $GLOBALS['nearList'];
$page=$_GET['page'];
$getStr=$GLOBALS['getStr'];
?>

<section>
    <div class="page_title"><h2>分类</h2></div>
    <ul class="admin_tab">
        <?php foreach ($type as $row): ?>
            <li id="type<?php echo $row['id'] ?>">
                <a href="index.php?std=1&questionList=1&type=<?php echo $row['id'] ?>"
                   class="level_select <?php echo $_GET['type'] == $row['id'] ? 'active' : '' ?>"><?php echo $row['name'] ?></a>
            </li>
        <?php endforeach ?>
    </ul>
    <div class="page_title"><h2>列表</h2></div>
    <table class="table">
        <tr>
            <th>内容</th>
            <th>创建时间</th>
            <th>操作</th>
        </tr>
        <?php foreach($nearList as $row):?>
            <tr>
                <td><a href="index.php?std=1&editQuestion=1&q_id=<?php echo $row['id']?>"><?php echo $row['content']?></a></td>
                <td><?php echo $row['create_time']?></td>
                <td><a class="inner_btn delete" id="<?php echo $row['id']?>">删除</a></td>
            </tr>
        <?php endforeach ?>
    </table>
    <aside class="paging"><?php if($page>0):?><a href="index.php?<?php echo $getStr?>&page=<?php echo $page-1?>">上一页</a><?php endif ?><a href="index.php?<?php echo $getStr?>&page=<?php echo $page+1?>">下一页</a></aside>
</section>
<div class="space"></div>
<script>
    $('.delete').click(function(){
        var q_id=$(this).attr('id');
        if(confirm('确定要删除本题？')){
            $.post('ajax_request.php',{std:1,deleteQuestion:1,q_id:q_id},function(data){
                location.reload(true);
            })
        }

    });
</script>