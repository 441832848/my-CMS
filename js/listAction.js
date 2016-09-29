/**
 * list页面js
 *     检测是否重复加载该文件
 *     实现页面切换功能
 *     实现相应操作的请求
 *         [修改时设置的数据...]
 *         [获取删除操作的数据...]
 *         [获取添加操作的数据...]
 *         [获取修改操作的数据...]
 */
(function($){
    $(function(){

        //////////////
        // 检测是否重复加载 //
        //////////////
        
        if (window.isManageAction) {
            return false;
        }
        window.isManageAction = true;

        //////////////
        // 实现页面切换功能 //
        //////////////
        
        // 绑定页面切换事件
        $(document).on('click','#right a,#right button',function(e){

            // 切换到添加页面
            if (window.$addPattern.test($(e.target).attr('class')) && $(e.target).is('a')) {

                // 清除表单内容
                if (!$(e.target).is('.saveContents')) {
                    $('#right>:nth-child(n).add input').val('');
                }

                $('#right> :nth-child(n):visible').fadeOut(500,function(){

                    // 切换#right 顶部导航条业务流程控制
                    if ($('#right>div.manageList')[0]) {
                        manageListSetNav('add');
                    }else if($('#right>div.levelList')[0]){
                        levelListSetNav('add');
                    }else if($('#right>div.navList')[0]){
                        navListSetNav('add');
                    }else if($('#right>div.docList')[0]){
                        docListSetNav('add');
                    }

                    $('#right>:nth-child(n).add,#right>p.rightNav').fadeIn(500);
                });
            }

            // 切换到修改页面
            if (window.$updatePattern.test($(e.target).attr('class')) && $(e.target).is('a')) {

                $('#right> :nth-child(n):visible').fadeOut(500,function(){

                    // 编辑文章内容时不清空
                    if (!$(e.target).parents('div.docList.update')) {
                        $('#right>:nth-child(n).update input').val('');
                    }

                    // 切换#right 顶部导航条业务流程控制
                    if ($('#right>div.manageList')[0]) {
                        manageListSetNav('update');
                    }else if($('#right>div.levelList')[0]){
                        levelListSetNav('update');
                    }else if($('#right>div.navList')[0]){
                        navListSetNav('update');
                    }else if($('#right>div.docList')[0]){
                        docListSetNav('update');
                    }

                    $('#right>:nth-child(n).update,#right>p.rightNav').fadeIn(500);
                });


                // listAction 数据获取与设置业务流程控制器
                if ($('#right>div.manageList')[0]) {
                    manageListSetData(e);
                }else if($('#right>div.levelList')[0]){
                    levelListSetData(e);
                }else if($('#right>div.navList')[0]){
                    navListSetData(e);
                }else if($('#right>div.docList')[0]){
                    docListSetData(e);
                }

                
            }

            // 切换到列表页面
            if (window.$returnPattern.test($(e.target).attr('class'))) {
                $('#right> :nth-child(n):visible').fadeOut(500,function(){

                    // 切换#right 顶部导航条业务流程控制
                    if ($('#right>div.manageList')[0]) {
                        manageListSetNav('list');
                    }else if($('#right>div.levelList')[0]){
                        levelListSetNav('list');
                    }else if($('#right>div.navList')[0]){
                        navListSetNav('list');
                    }else if($('#right>div.docList')[0]){
                        docListSetNav('list');
                    }

                    $('#right>:nth-child(n).list,#right>p.rightNav').fadeIn(500);
                });
            }


            //////////////////
            // 其他list扩展功能页面切换 //
            //////////////////


            // 切换到添加子导航页面
            if (window.$addChildPattern.test($(e.target).attr('class')) && $(e.target).is('a')) {

                $('#right> :nth-child(n):visible').fadeOut(500,function(){

                    // 切换#right 顶部导航条业务流程控制
                    if ($('#right>div.manageList')[0]) {
                        manageListSetNav('addChild');
                    }else if($('#right>div.levelList')[0]){
                        levelListSetNav('addChild');
                    }else if($('#right>div.navList')[0]){
                        navListSetNav('addChild');
                    }else if($('#right>div.docList')[0]){
                        docListSetNav('addChild');
                    }

                    $('#right>:nth-child(n).addChild,#right>p.rightNav').fadeIn(500);

                });

                // 清空表单项
                $('#right>:nth-child(n).add input').val('');

                // listAction 数据获取与设置业务流程控制器
                if ($('#right>div.manageList')[0]) {
                    manageListSetAddChildData(e);
                }else if($('#right>div.levelList')[0]){
                    levelListSetAddChildData(e);
                }else if($('#right>div.navList')[0]){
                    navListSetAddChildData(e);
                }else if($('#right>div.docList')[0]){
                    docListSetAddChildData(e);
                }

            }




        });


        //////////////
        // 实现发送功能 //
        //////////////

        $(document).on('click','#right a,#right button',function(e){

            /**
             * 向服务器发送请求
             * @param  {object} data post请求的数据
             */
            function send(data){
                if (!data) {
                    return false;
                }

                $.post(window.$loadURL[window.$loadURL.length-1].replace(/\?.*$/i,''),data,function(response,status,xhr){
                    if (status == 'error') {
                        $(e.target).html('<p style="color:red;text-align:center;margin:30px auto;">请求失败...</p>');
                    }else if(response == 'success'){
                        alert('操作成功');
                        window.loadTo($('#right'),window.$loadURL[window.$loadURL.length-1]);
                    }else{
                        alert('error: '+response);
                    }
                });
            }


            // 绑定删除操作函数
            if (window.$deletePattern.test(e.target.className)) {

                // 删前提示
                if (!confirm('您确定要删除该条记录吗?')) {
                    return false;
                }

                // list删除操作业务流程控制
                if ($('#right>div.manageList')[0]) {
                    send(manageSendDeleteData(e));
                }else if ($('#right>div.levelList')[0]) {
                    send(levelSendDeleteData(e));
                }else if ($('#right>div.navList')[0]) {
                    send(navSendDeleteData(e));
                }else if ($('#right>div.docList')[0]) {
                    send(docSendDeleteData(e));
                }

            }


            // 绑定添加操作函数
            if ($(e.target).is('button[type=submit]') && window.$addPattern.test($(e.target).attr('class'))) {

                // list删除操作业务流程控制
                if ($('#right>div.manageList')[0]) {
                    send(manageSendAddData(e));
                }else if ($('#right>div.levelList')[0]) {
                    send(levelSendAddData(e));
                }else if ($('#right>div.navList')[0]) {
                    send(navSendAddData(e));
                }else if ($('#right>div.docList')[0]) {
                    send(docSendAddData(e));
                }

            }


            // 绑定修改管理员操作函数
            if ($(e.target).is('button[type=submit]') && window.$updatePattern.test($(e.target).attr('class'))) {
                
                // list修改操作业务流程控制
                if ($('#right>div.manageList')[0]) {
                    send(manageSendUpdateData(e));
                }else if ($('#right>div.levelList')[0]) {
                    send(levelSendUpdateData(e));
                }else if ($('#right>div.navList')[0]) {
                    send(navSendUpdateData(e));
                }else if ($('#right>div.docList')[0]) {
                    send(docSendUpdateData(e));
                }

            }

            ////////////
            // 其他操作函数 //
            ////////////


            // 绑定添加子导航操作函数
            if ($(e.target).is('button[type=submit]') && window.$addChildPattern.test($(e.target).attr('class'))) {
                
                // list添加操作业务流程控制
                if ($('#right>div.manageList')[0]) {
                    send(manageSendAddChildData(e));
                }else if ($('#right>div.levelList')[0]) {
                    send(levelSendAddChildData(e));
                }else if ($('#right>div.navList')[0]) {
                    send(navSendAddChildData(e));
                }else if ($('#right>div.docList')[0]) {
                    send(docSendAddChildData(e));
                }

            } 

            // 绑定查看子导航操作函数
            if (window.$childListPattern.test($(e.target).attr('class'))) {
                
                // list查看子导航操作业务流程控制[直接获取数据跳转页面]
                if ($('#right>div.manageList')[0]) {
                    manageLoadChildList(e);
                }else if ($('#right>div.levelList')[0]) {
                    levelLoadChildList(e);
                }else if ($('#right>div.navList')[0]) {
                    navLoadChildList(e);
                }else if ($('#right>div.docList')[0]) {
                    docLoadChildList(e);
                }

            } 
      




        });


    });
})(jQuery);