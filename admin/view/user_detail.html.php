<?php $userinf=$GLOBALS['userinf'];
$markList=$GLOBALS['markList'];
$unmarkList=$GLOBALS['unmarkList'];
?>

<section>
<h2><strong><?php echo $userinf['nickname'].'('.$userinf['remark'].')'?>已阅列表</strong></h2>
    <table class="table">
        <tr>
            <th>
                通知名称
            </th>
            <th>发布时间</th>
            <th>阅读时间</th>
        </tr>
        <?php foreach($markList as $row):?>
            <tr>
                <td><?php echo $row['title']?></td>
                <td><?php echo date('Y-m-d H:i:s',$row['create_time'])?></td>
                <td><?php echo $row['mark_time']?></td>
            </tr>
        <?php endforeach ?>
    </table>
</section>
<section>
    <h2><strong>未阅列表</strong></h2>
    <table class="table">
        <tr>
            <th>
                通知名称
            </th>
            <th>发布时间</th>
        </tr>
        <?php foreach($unmarkList as $row):?>
            <tr>
                <td><?php echo $row['title']?></td>
                <td><?php echo date('Y-m-d h:i:sa',$row['create_time'])?></td>
            </tr>
        <?php endforeach ?>
    </table>
</section>