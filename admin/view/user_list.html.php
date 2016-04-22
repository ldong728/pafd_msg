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

        <tr class="dyn-tr">

        </tr>

    </table>

</section>

<script>
    $('#search-button').click(function(){
        $.post('ajax_request.php',{reflashUserList:1},function(data){

        });
    });

</script>