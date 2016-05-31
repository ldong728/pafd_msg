<head>
    <?php include 'templates/header.php' ?>
            <link rel="stylesheet" href="stylesheet/pafd.css?v=<?php echo rand(1000,9999)?>"/>
    <link rel="stylesheet" href="stylesheet/study.css?v=<?php echo rand(1000, 9999) ?>"/>
    <link rel="stylesheet" href="stylesheet/login.css?v=<?php echo rand(1000,9999) ?>"/>
</head>

<body>
<div class="content">
    <h1>用户注册</h1>
    <div class="container">
        <div class="input-block">
            <div class="label">
                请输入真实姓名：<span style="color: red">(必填)</span>
            </div>
            <div class="input-container">
                <input type="text" class="input real_name" placeholder="请输入真实姓名">
            </div>

        </div>
        <div class="input-block">
            <div class="label">
                请输入身份证号：<span style="color: red">(必填)</span>
            </div>
            <div class="input-container">
                <input type="text" class="input id" placeholder="请输入身份证号">
            </div>

        </div>
        <div class="input-block">
            <div class="label">
                请输入手机号码：<span style="color: orange">(选填)</span>
            </div>
            <div class="input-container">
                <input type="text" class="input phone" placeholder="请输入手机号码">
            </div>

        </div>

        <div class="input-block"style="position: relative">
            <div class="label">
                请选择分组：<span style="color: red">(必选)</span>
            </div>
            <div class="input-container">
                <div class="select-box">请选择分组</div>
                <select class="group-select">
                    <option value="-1">选择分组</option>
                    <?php foreach($glist as $row):?>
                        <option value="<?php echo $row['id']?>"><?php echo $row['name']?></option>
                    <?php endforeach ?>
                </select>
            </div>

        </div>
        <div style="width: 100%; height: 25px; border-top: dashed 1px #A1A1A1;margin-top: 10px"></div>
        <div class="input-block">
            <div class="label">
                请输入密码：<span class="pswWarning" style="color: red;display: none">密码输入不一致</span>
            </div>
            <div class="input-container">
                <input type="password" class="input psw" id="psw1" placeholder="请输入密码">
            </div>

        </div>
        <div class="input-block">
            <div class="label">
                请再次输入密码：
            </div>
            <div class="input-container">
                <input type="password" class="input psw" id="psw2" placeholder="请再次输入密码">
            </div>

        </div>


        <div class="confirm-block">
            <button class="confirm">
                注册
            </button>
        </div>
    </div>
</div>
<div class="toast"></div>
</body>
<script>
    var getStr='<?php echo $getStr?>';
    var openid='<?php echo $_GET['openid']?>';
    var groupid=-1;

    $('.confirm').click(function(){
        var real_name=$('.real_name').val();
        var id=$('.id').val();
        var phone=$('.phone').val();
        var p2=$('#psw2').val();
        var p1=$('#psw1').val();
        var check=inputCheck();
        if('ok'==check){
            $.post('ajax.php',{signIn:1,openid:openid,real_name:real_name,id:id,phone:phone,groupid:groupid,psw:p1},function(data){
                alert(data);
                if(data==1){
                    window.location.href='controller.php?'+getStr;
                }else{
                    showToast(data);
                }
            });
        }else{
            showToast(check);
        }

    });


    $('.group-select').change(function(){
        groupid=$(this).val();
        var content=$('.group-select option:selected').text();
        $('.select-box').text(content);
    });

    function inputCheck(){
        var real_name=$('.real_name').val();
        var id=$('.id').val();
        var phone=$('.phone').val();
        var p2=$('#psw2').val();
        var p1=$('#psw1').val();
        var nameRule=/^[^x00-xff]{2,6}$/;
        if(!nameRule.test(real_name))return '姓名输入有误';
        var idRule=/^\d{17}[0-9x]$/;
        if(!idRule.test(id))return '身份证号码输入有误';
        var phoneRule=/^\d{11}$/;
        if(phone!=''&&!phoneRule.test(phone))return '手机号码输入有误';
        if(groupid<100)return '请选择分组';
        if(p2==p1&& p1 !=''&& p2 !=''){
            $('.pswWarning').hide();
        }else{
            $('.pswWarning').show();
            return '密码输入有误';
        }
        return 'ok';

    }
</script>