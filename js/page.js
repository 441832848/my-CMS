/**
 * 分页效果
 * @authors Sc (hellosc@qq.com)
 * @date    2016-08-11 21:16:19
 * @version 1.0
 *          可自适应页码元素数量
 */

(function(){
    $(function(){

        // 定义#right 加载成功时的分页函数
        window.ajaxRightPage = page;

        function page(){

            // 判断是否有需要分页
            if (!$('#right .page')[0]) {
                return false;
            }

            // 初始化值
            var page = $('#right .page:first');
            var current = page.attr('current');                     // 当前页
            var pageSize = page.attr('pageSize');                   // 每页条数
            var pageTotal = page.attr('pageTotal');                 // 总页数
            var pageURL = page.find('a.prevPage').attr('href');     // url

            var prev = page.find('a:first');                        // 上一页
            var next = page.find('a:last');                         // 下一页
            var pageLength = page.find('.pageIndex').length;        // 页码元素数量
            var centerPage = parseInt(pageLength/2)+1;              // 页码中间值

            // 如果没有任何数据,就隐藏.page
            if (!$('#right .list tr')[1]) {
                page.hide();
                // 设置未找到任何数据的样式,并提供返回按钮
                backStyle();
                return false;
            }else{
                page.show();
            }

            // 调整分页元素的位置
            $('#right .page').insertAfter('#right table.list');

            // 实现填写页码跳转
            $('#right .page input').keydown(function(e){
                // 如果按回车提交了页码值
                if (e.which == 13) {
                    window.loadTo($('#right'),pageURL+$(e.target).val());
                }
            });

            // 初始化上一页
            if (current>1) {
                prev.attr('href',function(idnex,value){
                    return value+(parseInt(current)-1).toString();
                });
            }else{
                prev.attr('href','').css('color','#ccc');
            }

            // 初始化下一页
            if (parseInt(current)<parseInt(pageTotal)) {
                next.attr('href',function(idnex,value){
                    return value+(parseInt(current)+1).toString();
                });
            }else{
                next.attr('href','').css('color','#ccc');
            }

            // 初始化首页
            if (current>centerPage) {
                page.find('.firstPage').show();
            }else{
                page.find('.firstPage').hide();
            }

            // 设置页码值
            if (pageTotal>pageLength && current>centerPage) {
                $('.page>a.pageIndex').each(function(index,ele){
                    var pageIndex = (parseInt(current)+(parseInt(index)-(centerPage-1))).toString();
                    $(ele).text(pageIndex).attr('href','right-manage-manager.inc.php?page='+pageIndex);
                });
            }

            // 初始化最后一页
            if (pageTotal<=pageLength) {
                page.find('a.last').hide();
            }else if (current==pageTotal.substr(pageTotal.length-2)) {
                page.find('a.last').css({backgroundColor:'#E5EDF2',fontWeight:'bold'});
            }

            // 页数小于pageLength时隐藏相应页码==============
            if (pageTotal<=pageLength) {
                page.find('a.pageIndex').each(function(index,ele){
                    if ($(ele).text() > pageTotal) {
                        $(ele).hide();
                    }
                });
            }

            // 当接近最后一页时保持结构
            if (pageTotal>pageLength && current>(pageTotal-centerPage)) {
                page.find('a.pageIndex').each(function(index,ele){
                    var pageIndex = (parseInt(pageTotal)-(pageLength-parseInt(index))).toString();
                    $(ele).text(pageIndex).attr('href','right-manage-manager.inc.php?page='+pageIndex);
                });
            }

            // 初始化当前页码按钮样式
            page.find('a.pageIndex').each(function(index,ele){
                if ($(ele).text()==current) {
                    $(ele).css({backgroundColor:'#E5EDF2',fontWeight:'bold'});
                }
            });


        }


        ///////////////
        // functions //
        ///////////////

        // back style
        function backStyle(){

            var htmlStr = '<div style="padding: 20px 20px;background-color:#FAFACC;width:90%;margin:0 auto;"><img src="http://tb1.bdstatic.com/tb/zt/tengfei/404-error.png" alt=":(" style="float:left;" /><div style="margin-left:70px;line-height:180px;font-size:25px;font-family:Sim Sun;color:#333;letter-spacing:1px;">未找到任何数据，<a href="" class="backLink" style="color:#99CCCC;">点此返回上一步</a></div></div>';

            $(htmlStr).insertAfter('#right table.list');

        }




    });
})();















