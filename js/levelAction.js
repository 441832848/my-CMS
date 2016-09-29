/**
 * 管理员等级管理页面js
 *     检测是否重复加载该文件
 *     实现页面切换功能
 */
(function($){
    $(function(){

        //
        // 检测是否重复加载
        //
        
        if (window.isLevelAction) {
            return false;
        }
        window.isLevelAction = true;

        console.log('first load levelAction.js .....');

        //
        // 实现页面切换功能
        //
        
        // 绑定页面切换事件
        $(document).on('click','#right a,#right button',function(e){


            // 切换到添加页面
            // if ($(e.target).is('a.addLevel')) {
            //     console.log('addLevel...');
            //     $('#right>p.rightNav').html('<a href="" class="returnLevel">等级管理首页</a> &gt;&gt; <a href="" class="returnLevel">等级管理</a> &gt;&gt; <a href="">添加管理员等级</a>');
            //     $('.levelList:visible').fadeOut(500,function(){
            //         $('#right .levelList.add').fadeIn(500);
            //     });
            // }

            // 切换到修改页面
            if ($(e.target).is('a.updateLevel')) {
                console.log('updateLevel...');

                $('#right>p.rightNav').html('<a href="" class="returnLevel">等级管理首页</a> &gt;&gt; <a href="" class="returnLevel">等级管理</a> &gt;&gt; <a href="">修改管理员等级</a>');
                $('.levelList:visible').fadeOut(500,function(){
                    $('#right .levelList.update').fadeIn(500);
                });

                // 获取等级信息
                var levelInfo = [];
                levelInfo['level'] = $($(e.target).parents('tr')).find('td:nth-child(1)').text();
                levelInfo['level_name'] = $($(e.target).parents('tr')).find('td:nth-child(2)').text();
 

                // 显示更改前信息
                $('#right .levelList.update form input[name=level]').attr('placeholder',levelInfo['level']);
                $('#right .levelList.update form input[name=level_name]').attr('placeholder',levelInfo['level_name']);
            
            }

            // 切换到列表页面
            if ($(e.target).is('.returnLevel')) {
                console.log('returnLevel...');
                $('#right>p.rightNav').html('<a href="" class="returnLevel">等级管理首页</a> &gt;&gt; <a href="" class="returnLevel">等级列表</a>');
                $('.levelList:visible').fadeOut(500,function(){
                    $('#right .levelList.list').fadeIn(500);
                });
            }

        });

        
        //
        //实现发送功能
        //
        
        $(document).on('click','#right a,#right button',function(e){

            // 
            // 向服务器发送请求
            // @param  {object} data post请求的数据
            
            function send(data){

                // 发送删除用户请求
                $.post('right-manage-level.inc.php',data,function(response,status,xhr){
                    if (status == 'error') {
                        $(e.target).html('<p style="color:red;text-align:center;margin:30px auto;">请求失败...</p>');
                    }else if(response == 'success'){
                        alert('操作成功');
                        window.loadTo($('#right'),'right-manage-level.inc.php');
                    }else{
                        alert('error: '+response);
                    }
                });

            }


            // 绑定删除管理员等级操作函数
            if (e.target.className == 'deleteLevel') {
                if (!confirm('您确定要删除该等级吗?')) {
                    return false;
                }
                // 获取用户ID
                var level = $($(e.target).parents('tr')).find('td:nth-child(1)').text();
                var level_name = $($(e.target).parents('tr')).find('td:nth-child(2)').text();
                // 发送请求
                send({action:'delete',level:level,level_name:level_name});

            }

            // 绑定添加管理员等级操作函数
            if ($(e.target).is('button[type=submit].addLevel') && $(e.target).parents('div.levelList.add')[0]) {

                // 数据对象
                var data = {};
                data.action = 'add';

                // 获取用户信息
                data.level = $('div.levelList.add').find('input[name=level]').val();
                data.level_name = $('div.levelList.add').find('input[name=level_name]').val();
                data.level_info = $('div.levelList.add').find('textarea[name=level_info]').val();


                // 发送请求
                send(data);

            }


            // 绑定修改管理员等级操作函数
            if ($(e.target).is('button[type=submit].updateLevel') && $(e.target).parents('div.levelList.update')[0]) {

                // 数据对象
                var data = {};
                data.action = 'update';

                // 获取用户信息
                data.old_level = $('div.levelList.update').find('input[name=level]').attr('placeholder');
                data.old_level_name = $('div.levelList.update').find('input[name=level_name]').attr('placeholder');
                data.level = $('div.levelList.update').find('input[name=level]').val();
                data.level_name = $('div.levelList.update').find('input[name=level_name]').val();
                data.level_info = $('div.levelList.update').find('textarea[name=level_info]').val();
                
                // 发送请求
                send(data);

            }


        });




    });
})(jQuery);
//# sourceURL=levelAction.js