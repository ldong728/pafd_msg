<head>
    <?php include 'templates/header.php' ?>
    <link rel="stylesheet" href="stylesheet/pafd.css?v=<?php echo rand(1000,9999)?>"/>
    <link rel="stylesheet" href="stylesheet/study.css?v=<?php echo rand(1000, 9999) ?>"/>
    <link rel="stylesheet" href="stylesheet/login.css?v=<?php echo rand(1000,9999) ?>"/>
</head>

<body>
<div class="content">
    <h1>用户登录</h1>
    <div class="container">
        <div class="input-block">
            <div class="label">
               请输入真实姓名或身份证号
            </div>
            <div class="input-container">
                <input type="text" class="input value" placeholder="请输入真实姓名或身份证号">
            </div>

        </div>
        <div class="input-block">
            <div class="label">
                请输入密码：<span class="pswWarning" style="color: red;display: none">密码错误</span>
            </div>
            <div class="input-container">
                <input type="password" class="input psw" id="psw1" placeholder="请输入密码">
            </div>

        </div>

        <div class="confirm-block">
            <button class="confirm">
                登录
            </button>
        </div>
    </div>
</div>
<div class="toast"></div>
<div class="loading"></div>
</body>
<script>
    var getStr='<?php echo $getStr?>';
    $('.confirm').click(function(){
        var value = $('.value').val();
        var psw=$('.psw').val();
        if(psw!=''&& value!=''){
            loading();
            $.post('ajax.php',{logIn:1,value:value,psw:psw},function(data){
                stopLoading();
                if(data==1){
//                    alert(getStr);
//                    window.location.href="http://www.sohu.com";
                    window.location.href='controller.php?temp=1&'+getStr;
//                    alert('jump');
                }else{
                    showToast(data);
                }
            });
        }else{
            showToast('请填写完整');
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