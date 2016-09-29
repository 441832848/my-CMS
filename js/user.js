/**
 * 前端注册页面js
 * @authors Your Name (you@example.org)
 * @date    2016-09-24 19:11:24
 * @version 1.0
 */

    (function($){
        $(function(){
            
            $('form').submit(function(e) {
                // 禁止默认行为
                e.preventDefault();
                // 前端数据检测 ...
                
                // 提交到服务器
                submitInfo(e);
            });

            // 修改验证码图片的url防止缓存
            // $('img.validateCodeIamge').attr('src','config/validateCode.php?'+Math.random());

            // 实现点击图片加载验证码
            $('img.validateCodeIamge').click(function(e) {
                $(this).attr('src','config/validateCode.php?'+Math.random());
            });

            // 实现点击头像更换
            $('img#face').click(function(e) {
                $(this).attr('src',function(index,value){
                    var rand = Math.floor((Math.random())*parseInt($(this).attr('faceCount'))+1);
                    rand<10 ? rand='0'+rand : rand = ''+rand;
                    return value.replace(/(\/)(\w{2})(\.gif)/,'$1'+rand+'$3');
                });
            });

            /**
             * 提交注册或登录信息到服务器
             */
            function submitInfo(e){

                // 判断注册还是登录
                var isReg = $(e.target).find('input[type=submit]:first').attr('value')==='注册'?true:false;
                // 获取face
                var face = isReg ? '&face='+$('img#face').attr('src').match(/\d{2}/)[0] : '';
                // 获取data
                var data = 'action='+(isReg?'reg&':'login&')+$(e.target).serialize()+face;
                // 验证两次输入的密码是否正确
                if (isReg && $(e.target).find('input[name=password]').val()!==$(e.target).find('input[name=password2]').val()) {
                    alert('两次输入的密码不一致');
                    return false;
                }
                // console.log(data);
                // 发送data
                $.post('user.php',data,function(response,status,xhr){
                    if (status === 'success') {
                        if (response === 'success') {
                            var date = new Date();
                            var saveTime = $('form input[type=radio][name=cookie]:checked:first').val();
                            if (typeof saveTime === 'undefined' || parseInt(saveTime) === NaN) {
                                saveTime = 0;
                            }
                            date.setDate(date.getDate()+parseInt(saveTime));
                            // 保存 cookie
                            document.cookie = 'username='+encodeURIComponent($(e.target).find('input[name=username]').val())+';expires='+date+';';
                            alert((isReg?'注册':'登录')+'成功，欢迎您'+decodeURIComponent(document.cookie.match(/username=(.+);.+/)[1]));
                            // console.log(new Date()+'\\\\\\\\\\'+date);
                        }else{
                            alert(response);
                            // console.log(response);
                            if (response === '验证码错误') {
                                $('img.validateCodeIamge').attr('src','config/validateCode.php?'+Math.random());
                            }
                        }
                    }else{
                        alert('请求失败...');
                    }
                });





                // console.log();

            }

        });
    })(jQuery);
