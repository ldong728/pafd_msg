<?php $userlist=$GLOBALS['userlist'];
        $glist=$GLOBALS['glist'];
        $getStr=$GLOBALS['getStr'];
$page=$GLOBALS['page'];
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
        <select class="select"id="groupFilter">
            <option value="-1">全部分组</option>
            <option value="0"<?php echo $_GET['category']==0?'selected="selected"':''?>>未分组</option>
            <?php foreach($glist as $crow):?>
                <option value="<?php echo $crow['id']?>"<?php echo $_GET['groupid']==$crow['id']?'selected="selected"':''?>><?php echo $crow['name']?></option>
            <?php endforeach ?>
        </select>
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
                <td><a href="consle.php?userdetail=<?php echo $row['openid']?>"><?php echo $row['nickname']?></a></td>
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
    <aside class="paging"><?php if($page>0):?><a href="index.php?<?php echo $getStr?>&page=<?php echo $page-1?>">上一页</a><?php endif ?><a href="index.php?<?php echo $getStr?>&page=<?php echo $page+1?>">下一页</a></aside>
    <button class="link_btn reflashUsers">刷新列表</button>

</section>
<div class="space"></div>

<script>
    $('#groupFilter').change(function(){
        var id=$(this).val();
        if(id<0){
            window.location.href='index.php?user=1&userList=1';
        }else{
            window.location.href='index.php?user=1&userList=1&groupid='+id;
        }

    });
    $('.reflashUsers').click(function(){
        $.post('ajax_request.php',{reflashUsers:1},function(data){
            window.location.href='index.php?users=1&userList=1';
        });
    });
    $('#search-button').click(function(){
        $.post('ajax_request.php',{reflashUserList:1},function(data){

        });
    });

    $('.changeGroup').change(function(){

        var openid=$(this).attr('id').slice(3);
        var groupid=$(this).val();
        $.post('ajax_request.php',{changeGroupSingle:1,openid:openid,groupid:groupid},function(data){
            var inf =eval('('+data+')');
            if(inf.errcode==0){
                showToast('修改成功');
            }else{
                showToast('修改不成功，请稍后再试');
            }
        });
    });

</script>