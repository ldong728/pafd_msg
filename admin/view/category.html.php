<?php
$cate=$GLOBALS['cate'];
?>

<section>
    <h2>
        <strong>内容分类</strong>
    </h2>
    <table class="table">
        <tr>
            <th>名称</th>
            <th>图文数</th>
            <th>操作</th>
        </tr>
        <?php foreach($cate as $row):?>
            <tr>
                <td><?php echo $row['name']?></td>
                <td><?php echo $row['num']?></td>
                <td>
                    <a class="inner_btn sendNotice"id="btn<?php echo $row['id']?>">修改</a>
                    <a class="inner_btn delete"id="<?php echo $row['media_id']?>"data-source="<?php echo $row['source']?>">删除</a>
                </td>
            </tr>
        <?php endforeach?>

    </table>



    <div class="space"></div>
</section>