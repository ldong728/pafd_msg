<?php $newsList=$GLOBALS['newsList']?>

<section>
    <h2>
        <strong>图文列表</strong>
    </h2>
    <table class="table">
        <tr>
            <th>标题</th>
            <th>来源</th>
            <th>类型</th>
            <th>操作</th>
        </tr>
        <?php foreach($newsList as $row):?>
            <tr>
                <td><?php echo $row['title']?></td>
                <td><?php echo $row['source'] ?></td>
                <td><?php echo $row['type'] ?></td>
                <td><a class="inner_btn sendNotice"id="btn<?php echo $row['id']?>">作为通知发送</a></td>
            </tr>
        <?php endforeach?>

    </table>



    <div class="space"></div>
</section>

<script>
    $('.sendNotice').click(function(){
        var id=$(this).attr('id').slice(3);
        $.post('ajax_request.php',{sendNotice:1,newsId:id},function(data){
            var id=data;
            window.location.href='index.php?sendNotice='+id+'&notice_id='+id

        })
    });

</script>