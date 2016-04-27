<?php $userlist=$GLOBALS['userlist'];
        $glist=$GLOBALS['glist']
?>
<section>
    <section>
        <h2>
            <strong>
                搜索
            </strong>
        </h2>
        <input type="text"class="textbox"placeholder="输入关键词"/>
        <input type="button"value="搜索"class="group_btn"/>
    </section>

    <div class="page_title">
        <h2 class="fl"?>已关注用户列表</h2>
    </div>

    <table class="table">
        <tr>
            <th>头像</th>
            <th>昵称</th>
            <th>省</th>
            <th>市</th>
            <th>关注时间</th>
            <th>分组</th>
            <th>操作</th>
        </tr>
        <?php foreach($userlist as $row): ?>
            <tr class="dyn-tr">
                <td><img src="<?php echo $row['headimgurl']?>"style="width: 60px"/></td>
                <td><?php echo $row['nickname']?></td>
                <td><?php echo $row['province']?></td>
                <td><?php echo $row['city']?></td>
                <td><?php echo $row['subscribe_time']?></td>
                <td><select class="select changeGroup" id="grp<?php echo $row['openid']?>">
                        <option value="0"<?php echo $grow['id']==0?'selected="selected"':''?>>未分组</option>
                        <?php foreach($glist as $grow):?>
                            <option value="<?php echo $grow['id']?>"<?php echo $grow['id']==$row['groupid']?'selected="selected"':''?>><?php echo $grow['name']?></option>
                        <?php endforeach ?>
                </select></td>
                <td></td>

            </tr>
        <?php endforeach ?>


    </table>

</section>

<script>
    $('#search-button').click(function(){
        $.post('ajax_request.php',{reflashUserList:1},function(data){

        });
    });

    $('.changeGroup').change(function(){

        var openid=$(this).attr('id').slice(3);
        var groupid=$(this).val();
        $.post('ajax_request.php',{changeGroupSingle:1,openid:openid,groupid:groupid},function(data){
            alert(data);

        })
    });

</script>