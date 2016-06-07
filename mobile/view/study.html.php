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
            <div>
                <a href="controller.php?mainSite=1&cate=4">
                    <img src="stylesheet/images/i_11.png">
                    <br>

                    <p style="font-size: 12px;">
                        每月一课
                    </p>
                </a>
            </div>
        </li>
        <li>
            <div><a href="controller.php?study=1&questionList=1">
                    <img src="stylesheet/images/i_11.png">
                    <br>

                    <p style="font-size: 12px;">
                        理论学习
                    </p>
                </a>
            </div>
        </li>
        <li>
            <div><a href="controller.php?study=1&practice=1">
                    <img src="stylesheet/images/i_31.png">
                    <br>

                    <p style="font-size: 12px;">
                        自我练习
                    </p>
                </a>
            </div>
        </li>
        <li>
            <div>
                <a href="controller.php?study=1&test=1">
<!--                    <div><a href="controller.php?study=1&practice=1">-->
                    <img src="stylesheet/images/i_31.png">
                    <br>

                    <p style="font-size: 12px;">
                        每月一考
                    </p>
                </a>
            </div>
        </li>
<!--        <li>-->
<!--            <div>-->
<!--                <div><a href="controller.php?logout=1">-->
<!--                        <img src="stylesheet/images/i_31.png">-->
<!--                        <br>-->
<!---->
<!--                        <p style="font-size: 12px;">-->
<!--                            退出-->
<!--                        </p>-->
<!--                    </a>-->
<!--                </div>-->
<!--        </li>-->


    </ul>
</div>

<div class="floot">技术支持：慈溪谷多计算机网络科技有限公司</div>

</body>