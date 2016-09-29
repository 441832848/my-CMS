/**
 * index user login js
 * @authors Sc (hellosc@qq.com)
 * @date    2016-09-28 08:59:28
 * @version 1.0
 */

(function(){
    $(function(){

            $('form').submit(function(e) {
                // 禁止默认行为
                e.preventDefault();
                // 前端数据检测 ...
                
            });

            // 如果登录就加载用户信息
            $.get('user.php',{checkLogin:"1"},function(response,status){
                if (status === 'success' && response !== '#fail') {
                    // 如果获取头像失败就使用游客头像
                    if (response === '00') alert('获取用户头像失败，已使用其他系统头像');
                    // 显示用户信息
                    console.log(response);
                    toggleUserInfo('login',response.match(/.*\#(\d{1,2})/)[1]);
                }else{
                    // console.log(response);
                }
            });

            // 退出登录
            $('a.logout').click(function(e){
                // 禁止默认行为
                e.preventDefault();
                // 请求退出登录
                $.get('user.php?logout=1');
                alert('您已成功退出登录');
                // 清理cookie
                document.cookie = 'username=;expires=0;';
                toggleUserInfo('logout');
            });
            
            // 首页表单登录
            $('form[login]').submit(function(e){
                // 提交到服务器
                login(e);
            });

            // 实现点击图片加载验证码
            $('img.validateCodeIamge').click(function(e) {
                $(this).attr('src','config/validateCode.php?'+Math.random());
            });

            /**
             * 提交登录信息到服务器
             */
            function login(e){

                // 获取data
                var data = 'action=login&getFace=1&'+$(e.target).serialize();
                // console.log(data);
                // 发送data
                $.post('user.php',data,function(response,status,xhr){
                    if (status === 'success') {
                        if (/success\#\d{1,2}/.test(response)) {
                            var date = new Date();
                            var saveTime = 3;
                            date.setDate(date.getDate()+saveTime);
                            // 保存 cookie
                            document.cookie = 'username='+encodeURIComponent($(e.target).find('input[name=username]').val())+';expires='+date+';';
                            alert('登录成功，欢迎您'+decodeURIComponent(document.cookie.match(/username=(.+);.+/)[1]));
                            // console.log(new Date()+'\\\\\\\\\\'+date);
                            // 登录成功后切换
                            toggleUserInfo('login',response.match(/^success\#(\d{1,2})/)[1]);
                        }else{
                            alert(response);
                            // console.log(response);
                            $('img.validateCodeIamge').attr('src','config/validateCode.php?'+Math.random());
                        }
                    }else{
                        alert('请求失败...');
                    }
                });

            }


            function toggleUserInfo(flag,data=null){

                if (flag === 'login') {
                    // 将登录框切换为用户信息
                    $('#user>form[login]').slideUp(1000);
                    $('#user>div.is-login').slideDown(1000);
                    // 更新头像
                    data = data<10?('0'+data):data;
                    // console.log('test:'+data);
                    $('#user>div.is-login img.face').attr('src',function(index,value){
                        return value.replace(/\d{2}(\.)/,data+'$1');
                    });
                    // 显示用户名
                    $('#user>div.is-login span.name').text(decodeURIComponent(document.cookie.match(/username=(.*)\;/)[1]));
                }else if (flag === 'logout') {
                    // 清除登录框内容
                    $('#user>form[login] input:not([type=submit])').val('');
                    // 刷新验证码
                    $('img.validateCodeIamge').attr('src','config/validateCode.php?'+Math.random());
                    // 将用户信息切换为登录框
                    $('#user>div.is-login').slideUp(1000);
                    $('#user>form[login]').slideDown(1000);
                }

            }







    });
})();