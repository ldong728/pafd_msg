<?php
$mode = isset($GLOBALS['notice']) ? $GLOBALS['notice'] : 1;
$mode = isset($GLOBALS['mode']) ? $GLOBALS['mode'] : $mode;
$inf = isset($GLOBALS['inf']) ? $GLOBALS['inf'] : false;
$jmCate = isset($GLOBALS['jmCate']) ? $GLOBALS['jmCate'] : array();
$jmSCate = isset($GLOBALS['jmSCate']) ? $GLOBALS['jmSCate'] : array();
?>

<style>
    .newsInput li {
        margin-bottom: 20px;
    }
</style>

<script src="js/ajaxfileupload.js"></script>
<section>
    <div class="page_title"><h2><?php echo $inf ? '修改' : '新建' ?><?php echo $mode == 2 ? '通知' : '图文' ?></h2></div>
    <form action="consle.php?createNews=<?php echo $mode ?>" method="post">
        <section style="padding-left: 120px">
            <ul class="newsInput">
                <li>
                    <span class="item_name" style="width:120px">标题：</span>
                    <input type="text" class="textbox textbox_225" placeholder="请输入标题" name="title" <?php echo $inf? 'value='.$inf['title']:''?>/>
                </li>
                <?php if ($mode != 3): ?>
                    <li>
                        <span class="item_name" style="width:120px">摘要：</span>
                        <textarea class="textarea" name="digest" style="width:220px;height: 70px"
                                  placeholder="请输入摘要"><?php echo $inf ? $inf['digest']:''?></textarea>
                    </li>
                <?php endif ?>
                <?php if ($mode == 3): ?>
                    <li>
                        <span class="item_name" style="width:120px">文章分类：</span>
                        <select class="select f_select" name="f_id">
                            <option value="-1">请选择分类</option>
                            <?php foreach ($jmCate as $row): ?>
                                <option value="<?php echo $row['id'] ?>"><?php echo $row['name'] ?></option>
                            <?php endforeach ?>
                        </select>
                        <?php foreach ($jmSCate as $key => $row): ?>
                            <?php if ($row['sub_num'] > 0): ?>
                                <select class="select s_select" id="sub<?php echo $key ?>" style="display: none">
                                    <?php foreach ($row['option'] as $oRow): ?>
                                        <option value="<?php echo $oRow['id'] ?>"><?php echo $oRow['name'] ?></option>
                                    <?php endforeach ?>
                                </select>
                            <?php endif ?>
                            <?php if ($row['sub_num'] == 0): ?>
                                <input class="s_select" type="hidden" id="sub<?php echo $key ?>"
                                       value="<?php echo $row['id'] ?>"/>
                            <?php endif ?>
                        <?php endforeach ?>
                    </li>
                <?php endif ?>
                <li>
                    <span class="item_name" style="width:120px">首页图片：</span>
                    <label class="uploadImg">
                        <span>插入图片</span>
                    </label>
                    <img class="uploadedImg" id="title_demo" style="max-width: 70px;height: auto;display: none"/>
                    <input type="file" id="title-img-up" name="title-img-up" style="display: none">
                    <input type="hidden" name="title_img" id="title_name"/>
                    <input type="hidden" name="type" value="<?php $inf ? $inf['id'] : 'add' ?>"
                </li>
            </ul>
            <script>
                $(document).on('click', '.uploadImg', function () {
                    $('#title-img-up').click();
                });
                $(document).on('change', '#title-img-up', function () {
                    $.ajaxFileUpload({
                        url: 'upload.php',
                        secureuri: false,
                        fileElementId: $(this).attr('id'), //文件上传域的ID
                        dataType: 'json', //返回值类型 一般设置为json
                        success: function (v, status) {
                            if ('SUCCESS' == v.state) {
//                                var content = '<a href="#"class="delete-front-img"id="'+ v.id+'"><img src="../'+ v.url+'"/></a>';
//                                $('.front-img-upload').before(content);
                                $('#title_demo').attr('src', '../' + v.url);
                                $('#title_demo').fadeIn('fast');
                                $('.uploadImg').hide();
                                $('#title_name').val(v.url);
                            } else {
                                showToast(v.state);
                            }
                        },//服务器成功响应处理函数
                        error: function (d) {
                            alert('error');
                        }
                    });
                });
            </script>

        </section>
        <section style="padding-left: 120px">
            <script id="container" name="content" type="text/plain">
                请输入内容

            </script>
            <script type="text/javascript" src="../uedit/ueditor.config.js"></script>
            <script type="text/javascript" src="../uedit/ueditor.all.js"></script>
            <script type="text/javascript">
                var ue = UE.getEditor('container');
            </script>
            <?php if ($mode == 1): ?>
                <input type="button" class="link_btn" value="保存图文" onclick="submit()"/>
            <?php endif ?>
            <?php if ($mode == 2): ?>
                <input type="hidden" id="sendNow" name="sendNow" value="0"/>
                <input type="button" class="link_btn" value="保存通知" onclick="submit()"/>
                <input type="button" class="link_btn send" value="直接发送"/>
            <?php endif ?>
            <?php if ($mode == 3): ?>
                <input type="button" class="link_btn" value="保存文章" onclick="submit()"/>
            <?php endif ?>
        </section>

    </form>


</section>
<div class="space"></div>
<script>
    $('.f_select').change(function () {
        var f_id = $(this).val();
        $('.s_select').css('display', 'none');
        $('.s_select').removeAttr('name');
        $('#sub' + f_id).attr('name', 'jm_cate');
        $('#sub' + f_id).show();
    });
</script>
<script>

    $('.send').click(function () {
        $('#sendNow').val(1);
        $('form').submit();
    });
</script>