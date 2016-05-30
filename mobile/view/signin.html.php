<head>
    <?php include 'templates/header.php' ?>
    <!--        <link rel="stylesheet" href="stylesheet/pafd.css?v=--><?php //echo rand(1000,9999)?><!--"/>-->
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
                <input type="text" class="input" placeholder="请输入真实姓名">
            </div>

        </div>
        <div class="input-block">
            <div class="label">
                请输入身份证号：<span style="color: red">(必填)</span>
            </div>
            <div class="input-container">
                <input type="text" class="input" placeholder="请输入身份证号">
            </div>

        </div>
        <div class="input-block">
            <div class="label">
                请输入手机号码：<span style="color: orange">(选填)</span>
            </div>
            <div class="input-container">
                <input type="text" class="input" placeholder="请输入手机号码">
            </div>

        </div>
        <div class="confirm-block">
            <button class="confirm">
                注册
            </button>
        </div>
    </div>



</div>
</body>