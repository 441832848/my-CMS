/**
 * clicks js
 * @authors Your Name (you@example.org)
 * @date    2016-09-24 09:30:32
 * @version 1.0
 */


(function(){
    $(function(){
        // 获取id值
        var id = window.location.search.match(/[\&|\?]id\=(\d+)\&?/i)[1];
        if (id === null) {
            return false;
        }
        // 向服务器端发送请求
        $.get('detail.php?NC=1&clicksNavID='+id,function(response,status,xhr){
            // 改变点击量值
            if (status === 'success' && /^(\d)+$/.test(response)) {
                $('span#clicks').text(response);
            }
        });
    });
})();

