<!--<a href="consle.php?wechat=1&createButton=1">创建按钮</a>-->
<!--<a href="consle.php?wechat=1$sendTemplateMsg=1">模板信息测试</a>-->


<!--<div class="module-block">-->
<!--    <div class="module-title">-->
<!--        模板信息设置-->
<!--    </div>-->
<!--    <div class="module-block paychecked" >-->
<!--        <div class="module-title">-->
<!--        </div>-->
<!--    </div>-->
<!---->
<!--</div>-->
<?php
    $button=$GLOBALS['button'];
?>

<section>
    <div class="page_title">
        <h2><strong>公众号按钮设置</strong></h2>
    </div>
    <?php foreach($button['button'] as $row):?>
    <section>
        <input type="text" class="textbox" value="<?php echo $row['name']?>">
        <?php if($row['sub_button']):?>
            <?php foreach($row['sub_button'] as $subRow):?>
                <section style="margin-left: 50px">
                    <input type="text" class="textbox" value="<?php echo $subRow['name']?>"/>
                    <input type="text" class="textbox" value="<?php echo $subRow['type']?>"/>
                    <input type="text" class="textbox" value="<?php echo end($subRow)?>"/>
                </section>
                <?php endforeach ?>
            <?php endif ?>
        <?php if($row['type']):?>
            <input type="text" class="textbox" value="<?php echo $row['type']?>"/>
            <input type="text" class="textbox" value="<?php echo end($row)?>"/>
        <?php endif ?>
    </section>
    <?php endforeach ?>

    <button class="link_btn altmenu">提交修改</button>

</section>

<script>
    var buttonInf="<?php echo json_encode($button) ?>";
    $.each($button,function(k,v){

    });
    $('.altmenu').click(function(){

    })
</script>

<div class="module-block">
    <div class="module-title">
        测试块
    </div>
    <a href="consle.php?wechat=1&getMenuInf=1">获取按钮信息</a>
    <a href="consle.php?wechat=1&createUniButton=1">创建个性化按钮</a>
    <a href="consle.php?wechat=1&createButton=1">初始化按钮</a>
    <a href="consle.php?wechat=1&test=1">curl测试</a>
</div>