<?php $newsList=$GLOBALS['newsList']?>

<section>
    <h2>
        <strong>图文信息列表</strong>
    </h2>
    <table class="table">
        <tr>
            <th>标题</th>
            <th>作者</th>
            <th>图文数量</th>
            <th>操作</th>
        </tr>
        <?php foreach($newsList['item'] as $row):?>
            <tr>
                <td><?php echo $row['content']['news_item'][0]['title']?></td>
                <td><?php echo $row['content']['news_item'][0]['author']?></td>
                <td><?php echo count($row['content']['news_item'])?></td>
                <td>操作</td>
            </tr>
        <?php endforeach?>

    </table>



    <div class="space"></div>
</section>