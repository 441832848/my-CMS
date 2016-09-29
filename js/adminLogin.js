/**
 * 后台登录页面js
 * @authors Sc (hellosc@qq.com)
 * @date    2016-08-14 12:17:08
 * @version 1.0
 */

    (function($){
        $(function(){
            
            // 前端数据检测....
            // $('form').submit(function(e) {
                // 禁止默认行为
                // e.preventDefault(); 
            // });

            // 随机背景图
            $('body').css('background-image','url(https://ss1.bdstatic.com/lvoZeXSm1A5BphGlnYG/skin/'+Math.ceil(Math.random()*540)+'.jpg)');

            // 修改验证码图片的url防止缓存
            $('img.validateCodeIamge').attr('src','../config/validateCode.php?'+Math.random());

            // 实现点击图片加载验证码
            $('img.validateCodeIamge').click(function(e) {
                $(this).attr('src','../config/validateCode.php?'+Math.random());
            });



        });
    })(jQuery);