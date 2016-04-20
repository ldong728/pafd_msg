

//通过分享链接获得用户公开信息
//var imgPath=window.location.protocol+'//'+window.location.host+'/'+'<?php echo DOMAIN.'/'.$inf['url']?>';
//var oauthUrl='https://open.weixin.qq.com/connect/oauth2/authorize?'
//    +'appid=<?php echo APP_ID ?>'
//    +'&redirect_uri='+encodeURIComponent('http://115.29.202.69/gshop/mobile/controller.php?oauth=1&g_id=<?php echo $inf['g_id']?>')
//+'&response_type=code&scope=snsapi_userinfo'
//+'&state=111#wechat_redirect';
//wx.ready(function(){
////
//    wx.onMenuShareTimeline({
//        title: 'oAuth2.0鉴权测试', // 分享标题
//        link: oauthUrl, // 分享链接
//        imgUrl: imgPath, // 分享图标
//        success: function () {
//            // 用户确认分享后执行的回调函数
//        },
//        cancel: function () {
//            // 用户取消分享后执行的回调函数
//        }
//    });
//});