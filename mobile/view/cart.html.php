<head>
    <?php include 'templates/header.php'?>
    <link rel="stylesheet" href="stylesheet/cart.css"/>
    <script src="../js/lazyload.js"></script>
<!--    <script src="../js/swiper.min.js"></script>-->
</head>
<body>
    <div class="wrap">
        <div class="myCart">
            <ul class="cartList">
                <?php foreach($cartlist as $row):?>
                <li id="list<?php echo $row['cart_id']?>">
                    <dl class="cart_list">
                        <dd>
                            <a class="imgA"href="controller.php?goodsdetail=1&g_id=<?php echo $row['g_id']?>&d_id=<?php echo $row['d_id']?>&number=<?php echo $row['number']?>">
                                <img class="pro_img"src="../<?php echo $row['url']?>"style="width: 48px; height: 48px; border: 1px solid rgb(204, 204, 204); display: block;">
                            </a>
                            <div class="cDetail">
                                <a class="cName"href="controller.php?goodsdetail=1&g_id=<?php echo $row['g_id']?>&d_id=<?php echo $row['d_id']?>&number=<?php echo $row['number']?>"><?php echo $row['made_in'].$row['produce_id']?></a>
                                <p>规格：<span class="cl_grey"><?php echo $row['category']?></span></p>
<!--                                <div class="cCount">-->
                                    <div class="countBox">
                                        <a class="minus change-number"id="mins<?php echo $row['cart_id']?>">
                                            -
                                        </a>
                                        <input readonly="1" class="count"id="number<?php echo $row['cart_id']?>"value="<?php echo $row['number']?>"type="tel"maxlength="3">
                                        <a class="plus change-number"id="plus<?php echo $row['cart_id']?>">
                                            +
                                        </a>
                                    </div>
                                    <span class="cPrice">￥</span><span class="cPrice real-price"id="price<?php echo $row['cart_id']?>"><?php echo $row['price']?></span>

<!--                                </div>-->
                            </div>
                            <a class="delete"id="<?php echo $row['cart_id']?>"></a>
                        </dd>

                            <?php foreach($row['parts'] as $prow):?>
                                <dd>
                                    <a class="imgA"href="#">
                                        <img class="pro_img"src="../<?php echo $prow['part_url']?>"style="width: 48px; height: 48px; border: 1px solid rgb(204, 204, 204); display: block;">
                                    </a>
                                    <div class="cDetail">
                                        <a class="cName"href="#"><?php echo $prow['part_name']?></a>
                                        <p><span class="cl_grey"><?php echo $prow['part_produce_id']?></span></p>
                                        <!--                                <div class="cCount">-->
                                        <div class="countBox"id="count<?php echo $row['cart_id']?>">
                                            <a class="minus part-change-number"id="mins<?php echo $prow['part_id']?>">
                                                -
                                            </a>
                                            <input readonly="1" class="count"id="partnum<?php echo $prow['part_id']?>"value="<?php echo $prow['part_number']?>"type="tel"maxlength="3">
                                            <a class="plus part-change-number"id="plus<?php echo $prow['part_id']?>">
                                                +
                                            </a>
                                        </div>
                                        <span class="cPrice">￥</span><span class="cPrice real-price"id="price<?php echo $prow['part_id']?>"><?php echo $prow['part_sale']?></span>

                                        <!--                                </div>-->
                                    </div>
                                </dd>
                            <?php endforeach?>


                    </dl>
                    <p class="cart_ft">
                        合计：￥
                        <span class="price sub-total-price" id="sub-total<?php echo $row['cart_id']?>"><?php echo number_format($row['total'],2,'.','')?></span>
                    </p>


                </li>
                <?php endforeach?>
            </ul>
            <div class="fixedCartMenu">
                <div class="settleBox">
                    <p>总计：￥<span class="total"id="total-price"><?php echo number_format($list['totalPrice'],2,'.','')?></span>
                    </p>
                    <a class="settleBtn"id="buy-btn"href="controller.php?settleAccounts=1">结算</a>
                </div>
            </div>
        </div>

    </div>
    <?php include_once 'templates/foot.php'?>
<script>
    $(document).ready(function(){
//        flushPrice();
        $(document).on('click','.change-number',function(){
           var id=$(this).attr('id');
            var button=id.slice(0,4);
            var cart_id=id.slice(4);
            var currentNum = parseInt($('#number'+cart_id).val());
            var singlePrice=parseFloat($('#price'+cart_id).text());
//            alert(button);
            if('mins'==button){
                if(currentNum>1){
//                    alert('minus')
                    currentNum--;
                    singlePrice=-singlePrice;
                }else{
                    singlePrice=0;
                }
            }else{
//                alert('plus');
                currentNum++;

            }
            $('#number'+cart_id).val(currentNum);
//            alert('currentNum:'+currentNum)
            $.post('ajax.php', {alterCart: 1, cart_id: cart_id, number: currentNum},function(data){
//                alert(data)
                flushPrice(cart_id,singlePrice);
            });
        });
        $(document).on('click','.part-change-number',function(){
            var id=$(this).attr('id');
            var button=id.slice(0,4);
            var cart_id=$(this).parent().attr('id').slice(5);
            var g_id=id.slice(4)
            var currentNum = parseInt($('#partnum'+g_id).val());
            var singlePrice=parseFloat($('#price'+g_id).text());
//            alert(currentNum);
//            alert(singlePrice);
            if('mins'==button){
                if(currentNum>1){
                    currentNum--;
                    singlePrice=-singlePrice;
                }else{
                singlePrice=0;
            }
            }else{
                currentNum++;
            }
            $('#partnum'+g_id).val(currentNum);
            $.post('ajax.php', {alterPartCart: 1, cart_id:cart_id, g_id: g_id, number: currentNum},function(data){
                flushPrice(cart_id,singlePrice);
            });
        });


        $(document).on('click','.delete',function(){
            var cart_id=$(this).attr('id');
            var price=-parseFloat($('#sub-total'+cart_id).text());
            $.post('ajax.php',{deleteCart:1,cart_id:cart_id},function(data){
                $('#list'+cart_id).fadeOut('slow',function(){
                    $('#list'+cart_id).remove();
                    flushPrice(cart_id,price);
                });
            });
        });
    });
    var flushPrice=function(cart_id,price){
        var sub =parseFloat($('#sub-total'+cart_id).text())
        sub+=price;
        sub=sub.toFixed(2);
        $('#sub-total'+cart_id).text(sub);
        var total =parseFloat($('#total-price').text());
        total+=price;
        total=total.toFixed(2);
        $('#total-price').text(total);

    }

</script>
</body>