<?php
$notice=$GLOBALS['notice'];
?>

<section>
    <h2>
        <strong>内容分类</strong>
    </h2>
    <table class="table">
        <tr>
            <th>名称</th>
            <th>已阅数</th>
            <th>留言数</th>
        </tr>
        <?php foreach($notice as $row):?>
            <tr>
                <td><?php echo $row['title']?></td>
                <td><?php echo $row['mark_num']?></td>
                <td><?php echo $row['review_num']?></td>
            </tr>
        <?php endforeach?>

    </table>



    <div class="space"></div>
</section>