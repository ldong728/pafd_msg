<?php $list=$GLOBALS['list']?>
<section>
    <section>
        <h2>
            分组列表
        </h2>
        <table class="table">
            <tr>
                <th>组名</th>
                <th>编号</th>
                <th>人数</th>
                <th>操作</th>
            </tr>
            <?php foreach($list as $row):?>
                <tr>
                    <td id="name<?php echo $row['id']?>"><?php echo $row['name']?></td>
                    <td><?php echo $row['id']?></td>
                    <td><?php echo $row['count']?></td>
                    <td>
                        <?php if(0!=$row['id']):?><a class="inner_btn altGroup"id="upd<?php echo $row['id']?>">修改组名</a><?php endif ?>
                        <a class="inner_btn notice"id="not<?php echo $row['id']?>">发布通知</a>
                        <a class="inner_btn Qr"id="qrr<?php echo $row['id']?>">二维码</a>
                    <?php if(0!=$row['id']):?><a class="inner_btn delGroup"id="del<?php echo $row['id']?>">删除分组</a><?php endif ?>
                    </td>
                </tr>

            <?php endforeach ?>
        </table>
        <a class="link_btn create_group">新建分组</a>
    </section>

</section>
<div class="pop_bg">
    <div class="pop_cont">
        <h3 id="modeName">新建分组</h3>
        <div class="pop_cont_input">
            <ul>
                <li>
                    <span>组名</span><input type="text"class="textbox "id="newGroupName"placeholder="请输入新建组的组名"/>
                </li>
            </ul>
        </div>
        <div class="btm_btn">
            <input type="hidden"id="altid"value="0">
            <input type="button"value="确认"class="input_btn trueBtn">
            <input type="button"value="关闭"class="input_btn falseBtn">
        </div>
    </div>
</div>
<div class="hidden-content qr-block"style="
display: none;
position: fixed;
z-index: 999;
max-width: 50%;
height: auto;
border-radius: 5px;
padding: 10px;
top:20%;
left: 25%;
background-color: #ccc;
">


</div>

<script>
    $('.create_group').click(function(){
        $('#modeName').text('新建分组');
        $('#altid').val(0);
        $('#newGroupName').val('');
        $('.pop_bg').fadeIn('fast');
    });
    $('.falseBtn').click(function(){
        $('.pop_bg').fadeOut('fast');
    });
    $('.trueBtn').click(function(){
        var name=$('#newGroupName').val();
        $.post('ajax_request.php',{altGroup:1,name:name,id:$('#altid').val()},function(data){
            var inf=eval('('+data+")");
            if(inf.group||inf.errcode==0){
                location.reload(true);
            }
        });
    });
    $('.altGroup').click(function(){

        $('#modeName').text('修改组名');
        var id=$(this).attr('id').slice(3);
        $('#altid').val(id);
        $('#newGroupName').val($('#name'+id).text());
        $('.pop_bg').fadeIn('fast');

    });
    $('.delGroup').click(function(){
        var id=$(this).attr('id').slice(3);
        if(confirm('此操作将删除一个分组，原属于此分组的用户将会处于未分组状态，确认执行此步？')){
            $.post('ajax_request.php',{deleteGroup:1,id:id},function(data){
                var inf=eval('('+data+")");
                if(inf.errcode==0){
                    location.reload(true);
                }
            });
        }
    });
    $('.Qr').click(function(){
       var group_id=$(this).attr('id').slice(3);
        $.post('ajax_request.php',{groupQr:1,group_id:group_id},function(data){
            $('.qr-block').html('<img src="http://qr.topscan.com/api.php?text='+data+'"/>');
            $('.qr-block').fadeIn('fast');

        });
    });
    $('.qr-block').click(function(){
        $(this).fadeOut('fast');
    });


</script>