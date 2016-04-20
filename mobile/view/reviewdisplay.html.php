<head>
    <?php include 'templates/header.php' ?>
</head>
<body>
<div class="wrap">
    <div class="review module-box">
        <div class="title">
            <p class="titleName">评价：</p>
            <p class="reviewCount">共<?php echo $totalNumber?>条评价</p>
        </div>
        <div class="horizonborder"></div>
        <div class="keyword-block">

        </div>

        <?php foreach($reviews as $row):?>
            <div class="review-content">
                <div class="nameblock">
                    <p class="name"><?php echo $row['nickname']?></p>
                    <?php for($i=0; $i<$row['score'];$i++):?>
                        <div class="score"></div>
                    <?php endfor?>
                    <p class="time"><?php echo date('Y-m-d',strtotime($row['review_time']))?></p>
                </div>
                <div class="text">
                    <?php echo $row['review']?>
                </div>
                <div class="imgbox">

                </div>
                <div class="cate">
                    颜色：<?php echo $row['category']?>
                </div>


            </div>
        <?php endforeach?>

        <div class="more-review">
           更多
        </div>

    </div>
    <?php include_once 'templates/foot.php'?>

</div>


</body>