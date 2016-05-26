<head>
    <?php include 'templates/header.php' ?>
    <!--        <link rel="stylesheet" href="stylesheet/pafd.css?v=--><?php //echo rand(1000,9999)?><!--"/>-->
    <link rel="stylesheet" href="stylesheet/study.css?v=<?php echo rand(1000, 9999) ?>"/>
</head>

<body>
<div class="content">
    <h1>学习平台</h1>
    <ul class="inforSerch">
        <li>
            <div><a href="controller.php?study=1&practice=1">
                    <img src="stylesheet/images/i_11.png">
                    <br>

                    <p style="font-size: 12px;">
                        练习
                    </p>
                </a>
            </div>
        </li>
        <li>
            <div>
                <a href="controller.php?study=1&test=1">
                    <img src="stylesheet/images/i_31.png">
                    <br>

                    <p style="font-size: 12px;">
                        每月一考
                    </p>
                </a>
            </div>
        </li>
        <li>
            <div>
                <img src="stylesheet/images/i_11.png">
                <br>

                <p style="font-size: 12px;">
                    每月一课
                </p>
            </div>
        </li>

    </ul>
</div>

<div class="floot">技术支持：慈溪谷多计算机网络科技有限公司</div>

</body>