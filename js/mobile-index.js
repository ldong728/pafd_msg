$(document).ready(function(){

    $(document).on('click','div.hsTabItem',function(){
        $('.hsTabItem').removeClass('curItem');
        $(this).addClass('curItem');
        swiper.slideTo($(this).attr('id'));
    });
    $('div#0').addClass('curItem');
    var swiper = new Swiper('#hotsale', {
        lazyLoading : true,
        onSlideChangeEnd: function(swiper){
            $('.hsTabItem').removeClass('curItem');
            $('div#'+swiper.activeIndex).addClass('curItem');
        }
    });

    $(document).scroll(function(){
        var hsPosition=$('.hotsellBox').position().top;
        var scroll=$('body').scrollTop();
        if(scroll>hsPosition-50){
            $('.hsTab').css('position','fixed','z-index','1');
        }else{
            $('.hsTab').css('position','inherit');
        }
    });

});
