<?php
$jmCate = $GLOBALS['jmCate'];
$jmSCate = $GLOBALS['jmSCate'];
$newsList = $GLOBALS['newsList'];
$page = $GLOBALS['page'];
$num = $GLOBALS['num'];
$getStr = $GLOBALS['getStr']
?>

<section>
    <section>
        <h2>筛选</h2>
        <select class="select f_select" name="f_id">
            <option value="-1">请选择分类</option>
            <option value="s-1" <?php echo $_GET['cate']==-1 ? 'selected="selected"':''?>>全部分类</option>
            <?php foreach ($jmCate as $row): ?>
                <option
                    value="<?php echo $row['sub_num'] == 0 ? 's' : 'm' ?><?php echo $row['id'] ?>" <?php echo $_GET['f_id']==$row['id'] ? 'selected="selected"':''?>><?php echo $row['name'] ?></option>
            <?php endforeach ?>
        </select>
        <?php foreach ($jmSCate as $key => $row): ?>
            <?php if ($row['sub_num'] > 0): ?>
                <select class="select s_select" id="sub<?php echo $key ?>" <?php echo $_GET['f_id']==$key ? '':'style="display: none"'?>>
                    <option value="-1">请选择子分类</option>
                    <?php foreach ($row['option'] as $oRow): ?>
                        <option value="<?php echo $oRow['id'] ?>" <?php echo $_GET['cate']==$oRow['id'] ? 'selected="selected"':''?>><?php echo $oRow['name'] ?></option>
                    <?php endforeach ?>
                </select>
            <?php endif ?>

        <?php endforeach ?>
    </section>
    <h2>
        <strong>文章列表</strong>
    </h2>
    <table class="table">
        <tr>
            <th>标题</th>
            <th>类别</th>
            <th>首页</th>
            <th>操作</th>
        </tr>
        <?php foreach ($newsList as $row): ?>
            <tr>
                <td><?php echo $row['title'] ?></td>
                <td><select class="select changeCategory" id="sle<?php echo $row['id'] ?>">
                        <option value="0"<?php echo $row['category'] == 0 ? 'selected="selected"' : '' ?>>未分类</option>
                        <?php foreach ($cateList as $crow): ?>
                            <option
                                value="<?php echo $crow['id'] ?>"<?php echo $row['category'] == $crow['id'] ? 'selected="selected"' : '' ?>><?php echo $crow['name'] ?></option>
                        <?php endforeach ?>

                    </select></td>
                <td><input type="checkbox" class="addToTitle" id="tit<?php echo $row['id'] ?>"
                           <?php echo 'title' == $row['type'] ? 'checked="checked"' : '' ?>value="<?php echo $row['id'] ?>"/>
                </td>
                <td>
                    <a class="inner_btn delete" id="new<?php echo $row['id']?>"
                       data-source="<?php echo $row['source'] ?>">删除</a>
                </td>
            </tr>
        <?php endforeach ?>

    </table>
    <button class="link_btn reflash">刷新</button>
    <aside class="paging"><?php if ($page > 0): ?><a
            href="index.php?<?php echo $getStr ?>&page=<?php echo $page - 1 ?>">上一页</a><?php endif ?><a
            href="index.php?<?php echo $getStr ?>&page=<?php echo $page + 1 ?>">下一页</a></aside>


    <div class="space"></div>
</section>
<script>
    $('.f_select').change(function () {
        var id = $(this).val().slice(1);
        var mode=$(this).val().slice(0,1);
        if('m'==mode){
            $('.s_select').css('display', 'none');
            $('#sub' + id).show();
        }
        if('s'==mode){
            window.location.href='index.php?jm=1&jm_list=1&cate='+id+'&f_id='+id;
        }
    });
    $('.s_select').change(function(){
       var id=$(this).val();
        var f_id=$('.f_select').val().slice(1);
        window.location.href='index.php?jm=1&jm_list=1&cate='+id+'&f_id='+f_id;
    });
    $('.addToTitle').change(function(){
            var type=$(this).prop('checked')?'title':'normal';
            var id=$(this).attr('id').slice(3);
            loading();
        $.post('ajax_request.php',{altJmType:1,type:type,id:id},function(data){
           stopLoading();

        });
        });

</script>
