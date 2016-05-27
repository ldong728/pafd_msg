<?php
$scoreList = $GLOBALS['scoreList'];
$page = $_GET['page'];
$order = $GLOBALS['order'];
$order_rule = $GLOBALS['order_rule'];
$groupList = $GLOBALS['groupList'];
$getStr=$GLOBALS['getStr'];

?>
<style>
    a {
        cursor: pointer;
    }

</style>

<section>
    <h2>
        <strong>成绩列表</strong>
    </h2>
    <ul class="admin_tab">

        <?php foreach ($groupList as $row): ?>
            <li id="<?php echo $row['level_id'] ?>">
                <a href="index.php?std=1&userScore=2&groupid=<?php echo $row['id'] ?>"
                   class="level_select <?php echo $_GET['groupid'] == $row['id'] ? 'active' : '' ?>"><?php echo $row['name'] ?></a>
            </li>
        <?php endforeach ?>
    </ul>
    <table class="table">
        <tr>
            <th>昵称</th>
            <th>姓名</th>
            <th><a class="order" id="create_time" data-rule="desc">交卷时间</a></th>
            <th><a class="order" id="q_count" data-rule="desc">答题数</a></th>
            <th><a class="order" id="score" data-rule="desc">成绩</a></th>

        </tr>
        <?php foreach ($scoreList as $row): ?>
            <tr>
                <td><?php htmlout($row['nickname']) ?></td>
                <td><?php htmlout($row['real_name']) ?></td>
                <td><?php echo date('Y-m-d H:i:s', $row['create_time']) ?></td>
                <td><?php echo $row['q_count'] ?></td>
                <td><?php echo $row['score'] ?></td>
            </tr>
        <?php endforeach ?>
    </table>
    <aside class="paging"><?php if($page>0):?><a href="index.php?<?php echo $getStr?>&page=<?php echo $page-1?>">上一页</a><?php endif ?><a href="index.php?<?php echo $getStr?>&page=<?php echo $page+1?>">下一页</a></aside>


</section>
<div class="space"></div>
<script>
    var order = "<?php echo $order ?>";
    var order_rule = "<?php echo $order_rule ?>";
    var groupid =<?php echo isset($_GET['groupid'])? $_GET['groupid'] : 0 ?>;
</script>
<script>
    $(document).ready(function () {
        var rule = order_rule == 'desc' ? 'asc' : 'desc';
        $('#' + order).data('rule', rule);

        $('.order').click(function () {
            var nOrder = $(this).attr('id');
            var nRule = $(this).data('rule');
            window.location.href = 'index.php?std=1&userScore=2&groupid=' + groupid + '&order=' + nOrder + '&order_rule=' + nRule;
        });
    });

</script>