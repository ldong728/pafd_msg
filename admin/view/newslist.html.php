<?php
$newsList=$GLOBALS['newsList'];
$cateList=$GLOBALS['cateList'];
$page=$GLOBALS['page'];
$num=$GLOBALS['num'];
$getStr=$GLOBALS['getStr']
?>

<section>
    <section>
        <h2>筛选</h2>
        <select class="select"id="cateFilter">
            <option value="-1">全部内容</option>
            <option value="0"<?php echo $_GET['category']==0?'selected="selected"':''?>>未分类内容</option>
            <?php foreach($cateList as $crow):?>
                <option value="<?php echo $crow['id']?>"<?php echo $_GET['category']==$crow['id']?'selected="selected"':''?>><?php echo $crow['name']?></option>
            <?php endforeach ?>
        </select>
    </section>
    <h2>
        <strong>图文列表</strong>
    </h2>
    <table class="table">
        <tr>
            <th>标题</th>
            <th>类别</th>
            <th>首页</th>
            <th>操作</th>
        </tr>
        <?php foreach($newsList as $row):?>
            <tr>
                <td><?php echo $row['title']?></td>
                <td><select class="select changeCategory"id="sle<?php echo $row['id']?>">
                        <option value="0"<?php echo $row['category']==0?'selected="selected"':''?>>未分类</option>
                        <?php foreach($cateList as $crow):?>
                            <option value="<?php echo $crow['id']?>"<?php echo $row['category']==$crow['id']?'selected="selected"':''?>><?php echo $crow['name']?></option>
                        <?php endforeach ?>

                    </select></td>
                <td><input type="checkbox"class="addToTitle"id="tit<?php echo $row['id']?>"<?php echo 'title'==$row['type']? 'checked="checked"':''?>value="<?php echo $row['id']?>"/></td>
                <td>
                    <a class="inner_btn sendNotice"id="btn<?php echo $row['id']?>">作为通知发送</a>
                    <?php if($row['source']!='local'):?><a class="inner_btn singleReflash" id="ref<?php echo $row['media_id']?>">更新</a><?php endif ?>
                    <a class="inner_btn delete"id="<?php echo $row['media_id']?>"data-source="<?php echo $row['source']?>">删除</a>

                </td>
            </tr>
        <?php endforeach?>

    </table>
    <button class="link_btn reflash">刷新</button>
    <aside class="paging"><?php if($page>0):?><a href="index.php?<?php echo $getStr?>&page=<?php echo $page-1?>">上一页</a><?php endif ?><a href="index.php?<?php echo $getStr?>&page=<?php echo $page+1?>">下一页</a></aside>




    <div class="space"></div>
</section>

<script>
    $('.singleReflash').click(function(){
       var media_id=$(this).attr('id').slice(3);
        $.post('ajax_request.php',{reflashSingleNews:1,media_id:media_id},function(data){
            location.reload(true);
        });
    });
    $('#cateFilter').change(function(){
        var id=$(this).val();
        if(id<0){
            window.location.href='index.php?news=1&newslist=1';
        }else{
            window.location.href='index.php?news=1&newslist=1&category='+id;
        }

    });
    $('.sendNotice').click(function(){
        var id=$(this).attr('id').slice(3);
        $.post('ajax_request.php',{sendNotice:1,newsId:id},function(data){
            var id=data;
            window.location.href='index.php?sendNotice='+id+'&notice_id='+id

        })
    });
    $('.reflash').click(function(){
        alert('reflash');
        $.post('ajax_request.php',{reflashNews:1},function(data){
            if(data=='ok'){
                location.reload(true);
            }

        })
    });
    $('.changeCategory').change(function(){
        var news_id=$(this).attr('id').slice(3);
        var category=$(this).val();
        $.post('ajax_request.php',{changeCategory:1,newsId:news_id,category:category},function(data){
           if(data=='ok')showToast('设置完成')
        });
    });
    $('.delete').click(function(){
       var media_id=$(this).attr('id');
        var source=$(this).data('source');
        if(confirm('确定要删除此条图文信息吗？')){
            $.post('ajax_request.php',{deleteNews:1,media_id:media_id,source:source},function(data){
                location.reload(true);
            })
        }
        alert(source);
    });
    $('.addToTitle').change(function(){
        var v =$(this).prop('checked');
        var newsid=$(this).val();
        $.post('ajax_request.php',{setTitle:1,newsid:newsid,stu:v},function(data){
            if(data=='ok'){
                if(v){
                    showToast('已设置');
                }else{
                    showToast('已取消');
                }
            }
        });

    });

</script>