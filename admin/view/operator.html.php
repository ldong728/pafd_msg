<?php
$opList = $GLOBALS['opList'];
if(!isset($opList))$opList=array();
$pmsList = $GLOBALS['pmsList'];
$pmsCount = count($pmsList);
?>

<div class="op-container">
    <div class="op-block">
        <div class="op-name">
            操作员
        </div>
        <div class="op-name op-psw">
            密码
        </div>
        <div class="op-pms">
            <?php foreach ($pmsList as $row): ?>
                <div class="op-pms-block" style="width: <?php echo(100 / $pmsCount) ?>%">
                    <?php echo $row['name'] ?>
                </div>
            <?php endforeach ?>
        </div>
    </div>
    <?php foreach ($opList as $row): ?>
        <div class="op-block">
            <div class="op-name">
                <input class="alt-name" id="name<?php echo $row['id'] ?>" value="<?php echo $row['name'] ?>">
            </div>
            <div class="op-name op-psw">
                <input class="alt-pwd" id="pwd<?php echo $row['id'] ?>" value="<?php echo $row['pwd'] ?>">
            </div>
            <div class="op-pms">
                <?php foreach ($row['pms'] as $r): ?>
                    <div class="op-pms-block" style="width: <?php echo(100 / $pmsCount) ?>%">
                        <input type="checkbox" class="pms-alt" id="<?php echo $row['id'] ?>"
                               value="<?php echo $r['value'] ?>"<?php echo isset($r['checked']) ? 'checked="checked"' : '' ?>>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
    <?php endforeach ?>
    <div class="op-block">
        <div class="op-name">
            <input type="input" class="new-name"/>
        </div>
        <div class="op-name op-psw">
            <input type="input" class="new-pwd"/>
        </div>
        <div class="op-add">
            <button class="op-add-btn">
                添加操作员
            </button>
        </div>

    </div>

</div>
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