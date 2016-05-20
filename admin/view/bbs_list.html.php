<?php
$bbsList=$GLOBALS['bbsList'];
$page=$_GET['page'];
$order=$GLOBALS['order'];
$order_rule=$GLOBALS['order_rule'];
$groupList=$GLOBALS['groupList'];

?>
<style>
    a {
        cursor: pointer;
    }

</style>

<section>
    <h2>
        <strong>帖子列表</strong>
    </h2>
    <ul class="admin_tab">

        <?php foreach ($groupList as $row): ?>
            <li id="<?php echo $row['level_id'] ?>">
                <a href="index.php?bbs=1&bbslist=1&groupid=<?php echo $row['id'] ?>"
                   class="level_select <?php echo $_GET['groupid'] == $row['id'] ? 'active' : '' ?>"><?php echo $row['name'] ?></a>
            </li>
        <?php endforeach ?>
    </ul>
    <table class="table">
        <tr>
            <th>标题</th>
            <th>内容摘要</th>
            <th><a class="order" id="issue_time" data-rule="desc">发布时间</a></th>
            <th><a class="order" id="img_num" data-rule="desc" >图片</a></th>
            <th><a class="order" id="reply_count" data-rule="desc" >回帖</a></th>
            <th><a class="order" id="reply_img_num" data-rule="desc" >回帖图</a></th>
            <th><a class="order" id="priority" data-rule="desc" >优先级</a></th>
            <th>公开</th>
            <th>操作</th>
        </tr>
        <?php foreach($bbsList as $row):?>
            <tr>
                <td><?php htmlout($row['title'])?></td>
                <td><?php htmlout(substr($row['content'],0,20))?></td>
                <td><?php echo date('Y-m-d H:i:s', $row['issue_time']) ?></td>
                <td><?php echo $row['img_num']?></td>
                <td><?php echo $row['reply_count']?></td>
                <td><?php echo $row['reply_img_num']?></td>
                <td>
                    <select class="select priority" id="pri<?php echo $row['id']?>">

                        <?php for($i=1;$i<10;$i++):?>
                            <option value="<?php echo $i?>" <?php echo $i==$row['priority']? ' selected="selected"':''?>><?php echo $i?></option>
                        <?php endfor ?>
                        <option value="11" <?php echo 11==$row['priority']? ' selected="selected"':''?>>置顶</option>
                    </select></td>
                <td>
                    <input type="checkbox" class="hide" id="hid<?php echo $row['id']?>"<?php echo $row['public']==1? 'checked="checked"' : ''?>/>
                </td>
                <td>
                    <a class="inner_btn delete" id="del<?php echo $row['id']?>">删除</a>

                </td>
            </tr>
        <?php endforeach ?>
    </table>



</section>
<script>
    var order="<?php echo $order ?>";
    var order_rule="<?php echo $order_rule ?>";
    var groupid=<?php echo isset($_GET['groupid'])? $_GET['groupid'] : 0 ?>;
</script>
<script>
    $(document).ready(function(){
        var rule=order_rule=='desc'?'asc':'desc';
        $('#'+order).data('rule',rule);

        $('.order').click(function(){
           var nOrder=$(this).attr('id');
            var nRule=$(this).data('rule');
            window.location.href='index.php?bbs=1&bbslist=1&groupid='+groupid+'&order='+nOrder+'&rule='+nRule;
        });
        $('.delete').click(function(){
            var id=$(this).attr('id').slice(3);
            if(confirm('将删除此贴及所有回复')){
                $.post('ajax_request.php',{bbs:1,deleteTopic:id},function(data){
                    location.reload(true);
                });
            }
        });
        $('.priority').change(function(){
            var t_id=$(this).attr('id').slice(3);
            var priority=$(this).val();
            $.post('ajax_request.php',{bbs:1,altPriority:priority,t_id:t_id},function(data){
//                location.reload(true);
            });
        });
        $('.hide').change(function(){
            var t_id=$(this).attr('id').slice(3);
           var public= $(this).prop('checked')? 1 : 0;
            $.post('ajax_request.php',{bbs:1,altPublic:public,t_id:t_id},function(data){

            });

        });
    });

</script>