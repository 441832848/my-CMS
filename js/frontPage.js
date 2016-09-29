/**
 * 前台页面列表页分页功能
 * @authors Your Name (you@example.org)
 * @date    2016-09-18 11:24:34
 * @version $Id$
 */


(function(){
    $(function(){

        // 判断是否有分页元素
        if (!$('#page')[0] || !$('*[page]')) {
            return false;
        }

        // 如果没有任何数据,就隐藏.page
        if (!$('*[page]:first *[pageElement]')[0]) {
            $('#page:first').hide();
            // 设置未找到任何数据的样式,并提供返回按钮
            backStyle();
            return false;
        }else{
            $('#page:first').show();
        }


        // 初始化值
        var page = $('#page:first');                            // 分页元素
        var contentList = $('*[page]:first');                   // 分页内容元素
        var current = page.attr('current');                     // 当前页
        var pageSize = page.attr('pageSize');                   // 每页条数
        var pageTotal = page.attr('pageTotal');                 // 总页数
        var pageURL = page.find('a.prevPage').attr('href');     // url

        var prev = page.find('a:first');                        // 上一页
        var next = page.find('a:last');                         // 下一页
        var pageLength = page.find('.pageIndex').length;        // 页码元素数量
        var centerPage = parseInt(pageLength/2)+1;              // 页码中间值  


        // 实现填写页码跳转
        $('#page input').keydown(function(e){
            // 如果按回车提交了页码值
            if (e.which == 13) {
                location.href = pageURL+$(e.target).val();
            }
        });


        // 初始化上一页
        if (current>1) {
            prev.attr('href',function(idnex,value){
                return value+(parseInt(current)-1).toString();
            }).off('click',preventDefault);
        }else{
            prev.css('color','#ccc');
            prev.on('click',preventDefault);
        }

        // 初始化下一页
        if (parseInt(current)<parseInt(pageTotal)) {
            next.attr('href',function(idnex,value){
                return value+(parseInt(current)+1).toString();
            }).off('click',preventDefault);
        }else{
            next.css('color','#ccc');
            next.on('click',preventDefault);
        }

        // 初始化首页
        if (current>centerPage) {
            page.find('.firstPage').show();
        }else{
            page.find('.firstPage').hide();
        }

        // 设置页码值
        if (pageTotal>pageLength && current>centerPage) {
            $('#page>a.pageIndex').each(function(index,ele){
                var pageIndex = (parseInt(current)+(parseInt(index)-(centerPage-1))).toString();
                $(ele).text(pageIndex).attr('href',pageURL+pageIndex);
            });
        }

        // 初始化最后一页
        if (pageTotal<=pageLength) {
            page.find('a.last').hide();
        }else if (current==pageTotal.substr(pageTotal.length-2)) {
            page.find('a.last').css({backgroundColor:'#E5EDF2',fontWeight:'bold'});
        }

        // 页数小于pageLength时隐藏相应页码
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
                $(ele).text(pageIndex).attr('href',pageURL+pageIndex);
            });
        }

        // 初始化当前页码按钮样式
        page.find('a.pageIndex').each(function(index,ele){
            if ($(ele).text()==current) {
                $(ele).css({backgroundColor:'#E5EDF2',fontWeight:'bold'});
            }
        });


        ///////////////
        // functions //
        ///////////////

        // back style
        function backStyle(){

            var tips = '本栏目下暂时没有文章 ...'
            var htmlStr = '<div style="padding: 20px 20px;background-color:#FAFACC;width:90%;margin:0 auto;"><img src="http://tb1.bdstatic.com/tb/zt/tengfei/404-error.png" alt=":(" style="float:left;" /><div style="margin-left:70px;line-height:180px;font-size:25px;font-family:Sim Sun;color:#333;letter-spacing:1px;">'+tips+'</div></div>';

            $(htmlStr).insertAfter('*[page]:first');

        }

        // prevent default
        function preventDefault(e){e.preventDefault();}

    });
})();





































