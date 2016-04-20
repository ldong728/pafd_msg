//$(document).ready(function () {
$(document).on('change', '#category-select', function () {
    d_id = $('#category-select option:selected').val();
    $('#select-display').empty();
    $('#select-display').append($('#category-select option:selected').text());

    $.post('ajax.php', {getdetailprice: 1, d_id: $('#category-select option:selected').val()}, function (data) {
        var inf = eval('(' + data + ')');
        $('.price').empty();
        $('.sale').empty();
        if (inf.price == null) {
            realPrice = inf.sale;
        } else {
            realPrice = inf.price;
            $('.sale').append('RMB' + inf.sale);
        }
        $('.price').append('RMB' + realPrice);

    });

});
$(document).on('click','#review-title',function(){
    $(this).toggleClass('con-dis');
    $('#detail-review').fadeToggle('fast');
});
$(document).on('click','#param-title',function(){
    $(this).toggleClass('con-dis');
    $('.param-container').fadeToggle('fast');
})
$(document).on('click','#part-title',function(){
    $(this).toggleClass('con-dis');
    $('.scroll-box').fadeToggle('fast');
})

$(document).on('click', '.number-button', function () {

    if ('plus' == $(this).attr('id')) {
        var input = $(this).prev('input');
        var currentNum = parseInt(input.val());
        var price=parseFloat($('.total-price').text().slice(3))/currentNum;
        input.val(currentNum + 1)

    } else if ('minus' == $(this).attr('id')) {
        var input = $(this).next('input');
        var currentNum = parseInt(input.val());

        if (currentNum > 1) {
            input.val(currentNum - 1);
            var price=-parseFloat($('.total-price').text().slice(3))/currentNum;
        }else{
            var price=0;
        }
    }
    number = parseInt($('#number').val());
    flushPrice(parseFloat(price));
    if (1 == $('#fromCart').val()) {
        $.post('ajax.php', {alterCart: 1, d_id: d_id, number: number});
    }
    //alert(number);
});
$(document).on('change', '#number', function () {
    number = $(this).val();
});

//立刻购买按钮
$(document).on('click', '.buy-now', function () {
    window.location.href = 'controller.php?settleAccounts=1&from=buy_now&d_id=' + d_id + '&number=' + number + '&rand=' + antCacheRand();
})
$(document).on('click', '.add-cart', function () {
    $.post('ajax.php', {addToCart: 1, g_id: g_id, d_id: d_id, number: number}, function (data) {
        showToast('加入购物车成功');
    })

});
$(document).on('click', '#fav', function () {
    $.post('ajax.php', {addToFav: 1, g_id: g_id}, function (data) {
        showToast('收藏成功');
    });
});
$(document).on('click', '#getGoodsInf', function () {
    $('#goodsInf').empty();
    $.post('ajax.php', {getGoodsInf: 1, g_id: g_id}, function (data) {
        $('#goodsInf').append(data)
    });
    $('#goodsInf').fadeToggle('slow');
});
$(document).on('click','.kf-icon',function(){
   linkKf(g_id);
});

$(document).on('click','.title-kf',function(){
    linkKf(g_id);
});



//配件栏
$(document).on('click', '.check-box', function () {
    var id = $(this).attr('id').slice(4);
    var selected = $(this).hasClass('checked')
    var price=$(this).prev('input').val();
    if (selected) {
        $(this).removeClass('checked');

        showToast('-￥'+price);
        price=-price;
        //$('#num' + id).val(0)
    } else {
        $(this).addClass('checked');
        showToast('+￥'+price);
        //$('#num' + id).val(1)
    }
    $.post('ajax.php', {changePart: 1, g_id: g_id, part_id: id, mode: selected, number: number}, function (data) {
        if(data=='ok'){
            flushPrice(price*number);
        }

    });
});
$(document).on('click', '.more-review', function () {
    window.location.href='controller.php?getMoreReview=1&g_id='+g_id;
});
/**
 * 商品信息-参数栏切换
 */
$(document).on('click', '.nav', function () {
    var index = $(this).attr('id').slice(3);
    detailSwiper.slideTo(index);

})
function flushPrice(p){
    var price=parseFloat($('.total-price').text().slice(3));
    price+=p;
    price=price.toFixed(2)

    $('.total-price').text('合计￥'+price);
}


//});