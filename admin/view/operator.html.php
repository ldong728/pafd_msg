<?php
$opList = $GLOBALS['opList'];
if(!isset($opList))$opList=array();
$pmsList = $GLOBALS['pmsList'];
$pmsCount = count($pmsList);
?>

<section>
    <div class="page_title">
        <h2>操作员管理</h2>
    </div>
    <table class="table">
        <tr>
            <th>操作员</th>
            <th>密码</th>
            <?php foreach ($pmsList as $row): ?>
                <th>
                    <?php echo $row['name'] ?>
                </th>
            <?php endforeach ?>
        </tr>
        <?php foreach ($opList as $row): ?>
            <tr>
                <td><input type="text" class="alt-name textbox" id="name<?php echo $row['id'] ?>" value="<?php echo $row['name'] ?>" style="width: 70px"></td>
                <td><input type="text" class="alt-pwd textbox" id="pwd<?php echo $row['id'] ?>" value="<?php echo $row['pwd'] ?>" style="width: 70px"></td>
                <?php foreach ($row['pms'] as $r): ?>
                    <td>
                        <input type="checkbox" class="pms-alt" id="<?php echo $row['id'] ?>"
                               value="<?php echo $r['value'] ?>"<?php echo isset($r['checked']) ? 'checked="checked"' : '' ?>>
                    </td>
                <?php endforeach ?>
            </tr>
        <?php endforeach ?>
        <tr>
            <td>
                <input type="input" class="new-name"/>
            </td>
            <td>
                <input type="input" class="new-pwd"/>
            </td>
            <td>
                <a class="inner-button op-add-btn">
                    添加操作员
                </a>
            </td>
        </tr>


    </table>
</section>


<script>
    $('.pms-alt').change(function () {
        var stu = $(this).prop('checked');
        var id = $(this).attr('id');
        var pms = $(this).val();
        $.post('ajax_request.php', {operator: 1, altPms: pms, id: id, stu: stu}, function (data) {
            if (data == 'ok') {
                showToast('权限已修改')
            }
        });
    });
    $('.alt-name').change(function () {
        var id = $(this).attr('id').slice(4);
        var name = $(this).val();
        $.post('ajax_request.php', {operator: 1, altName: name, id: id}, function (data) {
            if (data == 'ok') {
                showToast('名称已修改');
            }
        });
    });
    $('.alt-pwd').change(function () {
        var id = $(this).attr('id').slice(3);
        var pwd = $(this).val();
        $.post('ajax_request.php', {operator: 1, altPwd: pwd, id: id}, function (data) {
            if (data == 'ok') {
                showToast('密码已修改');
            }
        });
    });
    $('.op-add-btn').click(function () {
        var name = $('.new-name').val();
        var pwd = $('.new-pwd').val();
        if (name != '' && pwd != '') {
            $.post('ajax_request.php', {operator: 1, new: name, pwd: pwd}, function (data) {
                if (data == 'ok') {
                    window.location = "index.php?operator=1";
                }
            });
        }
    })

</script>