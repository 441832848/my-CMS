/**
 * 后台页面js
 * @authors Sc (you@example.org)
 * @date    2016-08-03 11:15:03
 * @version $Id$
 */

    (function($){

        $(function(){

            // 定义location数组
            window.$loadURL = [location.href];

            // 定义要实现页面切换和数据发送功能的页面名
            window.$webName = '(Level|Manage|Nav|Doc)';

            // 定义是否是返回上一步
            window.$isBackLink = false;

            // 定义需要实现页面切换和数据发送功能的页面正则匹配规则
            window.$addPattern = new RegExp('add'+$webName);
            window.$updatePattern = new RegExp('update'+$webName);
            window.$returnPattern = new RegExp('return'+$webName);
            window.$deletePattern = new RegExp('delete'+$webName);
            
            window.$addChildPattern = new RegExp('addChild'+$webName);
            window.$childListPattern = new RegExp('childList'+$webName);

            
            
            /**
             * 定义跳转函数,实现异步加载文档
             * @param  {jQuery} ele element
             * @param  {string} URL URL
             */
            window.loadTo = function(ele,URL){

                // 判断指定元素的正确性
                if (!ele.is('.frame')) {
                    return false;
                }

                // 判断URL正确性
                if (/[\#\s]+|^$/.test(URL)) {
                    return false;
                }

                // 在指定元素内加载
                ele.load(URL,{load:'load'},function(response,status){
                    if (status == 'success') {

                        // 当url记录达到10条时进行出队列操作
                        if (window.$loadURL.length>9) {
                            window.$loadURL.shift();
                        }

                        // 记录当前url
                        window.$loadURL.push(URL);

                        // #right 加载成功时的回调函数
                        if ($(this).is('#right')) {
                            // 分页
                            window.ajaxRightPage();
                            // 初始化返回上一步
                            window.ajaxRightBackLink();
                            // 初始化导航排序样式
                            // window.ajaxRightNavSort();
                            // 初始化文档列表属性字段值
                            window.ajaxRightAttr();
                        }

                        // #left 加载成功时在#right中载入首个菜单项链接
                        if (ele.is('#left')) {
                            window.loadTo($('#right'),$('#left a:first').attr('href'));
                        }


                    }else if(status == 'error'){
                        $(this).text('').append('<p style="color:red;text-align:center;margin:30px auto;">请求失败...</p>');
                    }
                });

            }


            /**
             * 绑定跳转函数
             */
            $(document).on('click','a[href]',function(e){
                // 禁止<a>的跳转行为
                e.preventDefault();

                // 允许ckeditor编辑器的请求
                if ($(e.target).parents().is('#cke_content')) {
                    return false;
                }

                // 设置正常的跳转
                if ($(e.target).attr('jump') === 'jump') {
                    window.location.href = $(e.target).attr('href');
                }

                // 获取指定元素和URL
                var loadTo = $(e.target).parents('.frame');
                var loadURL = $(e.target).attr('href');

                // 获取loadTo属性
                if ($(e.target).attr('loadTo')) {
                    loadTo = $('#'+$(e.target).attr('loadTo'));
                }

                // 调用跳转函数
                window.loadTo(loadTo,loadURL);

            });

            /**
             * 禁止表单提交默认行为
             */
            $(document).on('submit','form',function(e){
                e.preventDefault();
            });

            /**
             * 初始化顶部导航区菜单
             */
            $('#top>ul>li>a').click(function(e){
                // 初始化样式
                $('#top>ul>li>a').removeClass('selected');

                // 设置选中样式
                $(e.target).addClass('selected');
            });

            /**
             * 初始化左侧导航列表样式
             */
            $('#left').on('click','dl>dd>a',function(e){
                // 初始化样式
                $('#left>dl>dd>a').removeClass('selected');

                // 设置选中样式
                $(e.target).addClass('selected');

            });

            
            //////////
            // 其他操作 //
            //////////



            // back function

            window.ajaxRightBackLink = function(){

                if (!$('#right a.backLink')[0]) {
                    return false;
                }

                // 返回上一步
                if(/right\-/.test(window.$loadURL[window.$loadURL.length-2]) && /[\s\#]*/.test($('#right a.backLink').attr('href'))){
                    // 兼容不同列表返回上一部行为
                    if (!checkURL(window.$loadURL[window.$loadURL.length-2],window.$loadURL[window.$loadURL.length-1])) {
                        $('#right .backLink').css('color','#ccc');
                        return false;
                    }
                    
                    $('#right .backLink').click(backLinkFun);
                }else{
                    $('#right .backLink').css('color','#ccc');
                    return false;
                }

                // 返回操作处理函数
                function backLinkFun(){
                    $('#right .backLink').attr('href',window.$loadURL[window.$loadURL.length-2]);
                    // 清除当前url和上一步url再进行跳转
                    window.$loadURL.pop();
                    window.$loadURL.pop();
                }

                // 检测URL是否属于统一列表
                function checkURL(previous,current){
                    if ((typeof window.$loadURL == undefined) || previous==='' || current==='') {
                        return false;
                    }
                    if (previous.substr(previous.lastIndexOf('-')-1,previous.indexOf('.')-previous.lastIndexOf('-')-1) === 
                        current.substr(current.lastIndexOf('-')-1,current.indexOf('.')-current.lastIndexOf('-')-1)) {
                        return true;
                    }
                    return false;
                }

            }






        });





    })(jQuery);


























