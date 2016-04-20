//$(document).ready(function(){
//    $(document).on('click','.daohang',function(){
//       triggNav();
//    });
//    $(document).on('click','#search-button',function(){
//        window.location.href='controller.php?getList=1&name='+$('#key-word').val();
//    });
//
//});
//var triggNav=function(){
//    if('none'==$('.head_nav').css('display')){
//        $('.head_nav').css('display','block');
//    }else{
//        $('.head_nav').css('display','none');
//    }
//
//}
function showToast(str){
    $('.toast').empty();
    $('.toast').append(str)
    $('.toast').fadeIn('fast')
    var t = setTimeout('$(".toast").fadeOut("slow")', 800);
}
function antCacheRand(){
    return Math.random().toString(36).substr(2);
}
function closeWindow(text){
    if
    (confirm(text)){
        window.opener=null;
        window.open('','_self');
        window.close();
    }
    else{}
}
function selectCate(o){
        //alert(o.id);
    var id= o.id.slice(4)
    window.location.href='controller.php?getFcList=1&fc_id='+id;
}

function linkKf(g_id){
    var gid=g_id||'-1';
    $.post('ajax.php',{linkKf:1,gid:gid},function(data){

        if(0==data){
            alert('客服已接通，请关闭当前页面以便与客服交流');
        }
        if(1==data){
            alert('客服不在线或者忙碌中，请稍候再试');
        }
        if(2==data){
            alert('当前无在线客服，请稍候再试');
        }

    })
}