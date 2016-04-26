<script src="js/ajaxfileupload.js"></script>
<section>
    <h2>
        新建图文信息
    </h2>


    <form action="consle.php?createNews=1" method="post">
        <section>
            <h2><strong style="color: gray">显示在微信界面的信息</strong></h2>
            <ul>
                <li>
                    <span class="item_name" style="width:120px">标题：</span>
                    <input type="text" class="textbox textbox_225" placeholder="请输入标题" name="title"/>
                </li>
                <li>
                    <span class="item_name" style="width:120px">摘要：</span>
                    <textarea class="textarea" name="digest" style="width:220px;height: 70px"
                              placeholder="请输入摘要"></textarea>
                </li>
                <li>
                    <span class="item_name" style="width:120px">首页图片：</span>
                    <label class="uploadImg" >
                        <span>插入图片</span>
                    </label>
                    <img class="uploadedImg" id="title_demo"style="max-width: 70px;height: auto;display: none"/>
                    <input type="file"id="title-img-up"name="title-img-up"style="display: none">
                    <input type="hidden"name="title_img"id="title_name"/>
                </li>
            </ul>
            <script>
                $(document).on('click','.uploadImg',function(){
                    $('#title-img-up').click();
                });
                $(document).on('change','#title-img-up',function(){
                    $.ajaxFileUpload({
                        url:'upload.php',
                        secureuri: false,
                        fileElementId: $(this).attr('id'), //文件上传域的ID
                        dataType: 'json', //返回值类型 一般设置为json
                        success: function (v, status){
                            if('SUCCESS'== v.state){
//                                var content = '<a href="#"class="delete-front-img"id="'+ v.id+'"><img src="../'+ v.url+'"/></a>';
//                                $('.front-img-upload').before(content);
                                $('#title_demo').attr('src','../'+ v.url);
                                $('#title_demo').fadeIn('fast');
                                $('.uploadImg').hide();
                                $('#title_name').val(v.url);
                            }else{
                                showToast(v.state);
                            }
                        },//服务器成功响应处理函数
                        error:function(d){
                            alert('error');
                        }
                    });
                });
            </script>

        </section>

            <script id="container" name="content" type="text/plain">
                请输入内容
            </script>
            <script type="text/javascript" src="../uedit/ueditor.config.js"></script>
            <script type="text/javascript" src="../uedit/ueditor.all.js"></script>
            <script type="text/javascript">
                var ue = UE.getEditor('container');
            </script>
        <input type="button" class="link_btn" value="创建新图文信息"onclick="submit()"/>

    </form>


</section>
<div class="space"></div>