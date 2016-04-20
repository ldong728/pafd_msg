<head>
    <?php include 'templates/header.php' ?>
</head>

<body>
<div class="wrap">
    <div class="category-name">
        <?php echo $cateName['e_name']?>
    </div>
    <div class="h-slash"></div>
    <div class="goods-list-container">
        <?php foreach ($list as $row): ?>
            <a href="controller.php?goodsdetail=1&g_id=<?php echo $row['g_id'] ?>">
                <div class="goods-list-box">
                    <img src="../<?php echo $row['url'] ?>"/>
                    <div class="name">
                        <span class="goods-list-name"><?php echo $row['made_in'] ?></span></br>
                        <span class="goods-list-cid"><?php echo $row['produce_id']?></span>
                    </div>
<!--                    <div class="intro">-->
<!--                        --><?php //echo $row['intro'] ?>
<!--                    </div>-->
                    <div class="price">
                        RMB<?php echo isset($row['price'])? $row['price']:$row['sale']?>
                    </div>
                    <a class="buy"href="controller.php?goodsdetail=1&g_id=<?php echo $row['g_id'] ?>">
                        选购
                    </a>
                </div>
            </a>
        <?php endforeach ?>
    </div>
    <div class="part-list-title">
        <?php if(count($partList)>0) echo $cateName['sub_name'].'配件' ?>
    </div>
    <div class="part-list-container">
        <?php foreach ($partList as $row): ?>
        <a class="buy"href="controller.php?partsdetail=1&g_id=<?php echo $row['g_id'] ?>">
            <div class="part-list-box">
                <img class="part-img" src="../<?php echo $row['url'] ?>"/>
                <div class="box-slash"></div>
                <div class="part-intro">
                    <?php echo $row['intro'] ?>
                    <p>￥<?php echo $row['sale'] ?></p>
                </div>

            </div>
            </a>
        <?php endforeach ?>

    </div>

    <div class="foot-blank"></div>

    <?php include_once 'templates/foot.php' ?>


</div>


</body>

