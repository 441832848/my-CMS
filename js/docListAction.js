
/**
 * 设置顶部导航条内容
 */
function docListSetNav($flag){
    switch($flag){
        case 'add':
            $('#right>p.rightNav').html('<a href="" class="returnNav">内容管理</a> &gt;&gt; <a href="" class="returnNav">查看文档列表</a> &gt;&gt; <a href="">添加文档</a>');
            break;
        case 'update':
            $('#right>p.rightNav').html('<a href="" class="returnNav">内容管理</a> &gt;&gt; <a href="" class="returnNav">查看文档列表</a> &gt;&gt; <a href="">编辑文档</a>');
            break;
        case 'list':
            $('#right>p.rightNav').html('<a href="" class="returnNav">内容管理</a> &gt;&gt; <a href="" class="returnNav">查看文档列表</a>');
            break;
        // case 'addChild':
        //     $('#right>p.rightNav').html('<a href="" class="returnNav">内容管理</a> &gt;&gt; <a href="" class="returnNav">查看文档列表</a> &gt;&gt; <a href="">添加子导航</a>');
        //     break;
    }
}

/**
 * ajax获取文章数据并显示
 * @param  {object} e event
 */
function docListSetData(e){

    $.get('right-content-doc.inc.php',{updateDoc:$(e.target).attr('updateDoc')},function(response,status,xhr){
        
        // get update contents
        var contents = JSON.parse(response);
        if (contents._error === 'null') {
            alert('This document is not found');
            return false;
        }

        // get form content
        var fm = $('#updateDocument');
        var attrStr = contents.attr;
        var img = fm.find('img#uploadPic');

        // mark nav id
        fm.attr('navID',contents.id);

        // set fields content
        fm.find('input[name=title]').val(contents.title);
        fm.find('input[name=tag]').val(contents.tag);
        fm.find('input[name=keyword]').val(contents.keyword=='none' ? '':contents.keyword);
        fm.find('input[name=source]').val(contents.source);
        fm.find('input[name=author]').val(contents.author);
        fm.find('textarea[name=info]').val(contents.info);
        fm.find('input[name=count]').val(contents.count);
        fm.find('input[name=gold]').val(contents.gold);
        
        // set checkbox(radio) field
        fm.find('input[type=checkbox]').each(function(index, ele) {
            if(attrStr.indexOf($(ele).attr('name'))>=0){
                $(ele).attr('checked','checked');
            }
        });
        
        // set thumbnail image
        img.attr('src',contents.thumbnail).css('height','150px').show().parents('p').css('height','160px');
        fm.find('#thumbnail').hide();

        // set nav name
        fm.find('select[name=nav] option').each(function(index, ele) {
            if($(ele).attr('value') == contents.nav){
                $(ele).attr('selected','selected');
            }
        });

        // set textarea contents
        window.$updateContent.setData(contents.content);

        // set comment field
        fm.find('input[name=comment][value='+contents.comment+']').attr('checked','checked');

        // set sort field
        fm.find('select[name=sort]>option[value='+contents.sort+']').attr('selected','selected');
        
        // set limits field
        fm.find('select[name=limits]>option[value='+contents.limits+']').attr('selected','selected');

        // set color field
        fm.find('select[name=color]>option[value='+contents.color+']').attr('selected','selected');


        


    });

}



/**
 * manage 获取删除操作数据
 * @param  {object} e event
 * @return {object}   ajax data
 */
function docSendDeleteData(e){
    return {action:'delete',id:$(e.target).attr('deleteDoc')};
}




/**
 * manage 获取添加操作数据
 * @param  {object} e event
 * @return {object}   data
 */
function docSendAddData(e){

    // 获取文档信息
    var data = {action:'add'};

    var dataArr = $('#right #createDocument').serializeArray();


    $.each(dataArr, function(k,v){
        if (/\d{1,3}/.test(k)) {
            data[v.name] = v.value;
            delete data[k];
        }
    });

    window.$data = data;

    // 获取单选复选属性
    $('#right #createDocument p:eq(2)>input:checked').each(function(index,ele){
        window.$data[$(ele).attr('name')] = '1';
    });
    $('#right #createDocument p:eq(9)>input[type=radio]:checked').each(function(index,ele){
        window.$data[$(ele).attr('name')] = index;
    });
    // 去除textarea 
    $('#right #createDocument>textarea').each(function(index,ele){
        if (typeof data[$(ele).attr('name')] != 'undefined') {
            delete data[$(ele).attr('name')];
        }
    });
    // 获取缩略图
    if ($('#right #uploadPic').attr('src')=='') {
        alert('请上传缩略图');
        return false;
    }
    window.$data.thumbnail = $('#right #uploadPic').attr('src').replace(/\\/,'/');
    // 获取ckeditor中的内容
    if ((typeof CKEDITOR !== 'object') && (typeof CKEDITOR.instance !== 'object')) {
        alert('ckeditor 出错...');return false;
    }
    if (CKEDITOR.instances.content.getData() === '') {
        alert('请输入文章内容');return false;
    }
    window.$data.content = CKEDITOR.instances.content.getData();
    // 处理非必选项keyword
    if (window.$data['keyword'] == '') {
        window.$data['keyword'] = 'none';
    }

    // 获取data并销毁window.$data
    data = window.$data;
    delete window.$data;

    for(var key in data){
        if (data[key] === '') {
            alert('您还有未填写的表单项'+key);
            return false;
        }
    }

    console.log(data);

    // return false;

    return data;

}



/**
 * manage 获取修改操作数据
 * @param  {object} e event
 * @return {object}   data
 */
function docSendUpdateData(e){

    // 获取修改后文档信息
    var data = {action:'update'};

    var dataArr = $('#right #updateDocument').serializeArray();


    $.each(dataArr, function(k,v){
        if (/\d{1,3}/.test(k)) {
            data[v.name] = v.value;
            delete data[k];
        }
    });

    window.$data = data;

    // 获取单选复选属性
    $('#right #updateDocument p:eq(2)>input:checked').each(function(index,ele){
        window.$data[$(ele).attr('name')] = '1';
    });
    $('#right #updateDocument p:eq(9)>input[type=radio]:checked').each(function(index,ele){
        window.$data[$(ele).attr('name')] = index;
    });
    // 去除textarea 
    $('#right #updateDocument>textarea').each(function(index,ele){
        if (typeof data[$(ele).attr('name')] != 'undefined') {
            delete data[$(ele).attr('name')];
        }
    });
    // 获取缩略图
    if ($('#right #uploadPic').attr('src')=='') {
        alert('请上传缩略图');
        return false;
    }
    window.$data.thumbnail = $('#right #uploadPic').attr('src').replace(/\\/,'/');
    // 获取ckeditor中的内容
    if ((typeof CKEDITOR !== 'object') && (typeof CKEDITOR.instance !== 'object')) {
        alert('ckeditor 出错...');return false;
    }
    if (window.$updateContent.getData() === '') {
        alert('请输入文章内容');return false;
    }
    window.$data.content = window.$updateContent.getData();
    // 处理非必选项keyword
    if (window.$data['keyword'] == '') {
        window.$data['keyword'] = 'none';
    }

    // 获取data并销毁window.$data
    data = window.$data;
    delete window.$data;

    for(var key in data){
        if (data[key] === '') {
            alert('您还有未填写的表单项'+key);
            return false;
        }
    }

    // 获取文章id值
    if (!(/\d+/.test($('#right #updateDocument').attr('navID')))) {
        alert('nav id error');
        return false;
    }
    data.id = $('#right #updateDocument').attr('navID');
    console.log(data);

    // return false;

    return data;

}


////////////
// 其他操作函数 //
////////////


/**
 * 添加子导航时设置id
 * @param  {object} e event
 */
// function navListSetAddChildData(e){

//     // 获取list信息
//     var navInfo = [];
//     navInfo['pid'] = $($(e.target).parents('tr')).find('td:nth-child(1)').text();

//     // 显示更改前信息
//     $('#right .navList.addChild form input[name=pid]').val(navInfo['pid']).attr('readonly','on');


// }

/**
 * 绑定添加子导航操作函数
 * @param  {object} e event
 */
// function navSendAddChildData(e){

//     var data = {action:'add'};

//     // 获取用户信息
//     data.nav_name = $('div.navList.addChild').find('input[name=nav_name]').val();
//     data.pid = $('div.navList.addChild').find('input[name=pid]').val();
//     data.sort = $('div.navList.addChild').find('input[name=sort]').val();
//     data.nav_info = $('div.navList.addChild').find('textarea[name=nav_info]').val();

//     return data;

// }


(function($){
    $(function(){

        // 绑定上传文件事件
        $(document).on('click','button.uploadFile',function(e){

            // 弹出居中window
            var width = (window.screen.width-400)/2;
            var height = (window.screen.height-100)/2;
            window.open('../templates/upfile.html','newwindow','height=200,width=500,top='+height+',left='+width+',toolbar=no,menubar=no,scrollbars=no,resizable=no,location=no');
            

        });

        // 点击栏目筛选
        $(document).on('change','.list select',function(e){
            var nav = $(e.target).find('option:selected').attr('value');
            if (nav) {
                window.loadTo($('#right'),'right-content-doc.inc.php?navID='+nav);
            }
        });

        // 显示正确的属性值
        window.ajaxRightAttr = function(){

            // front,rec,bold,skip
            // 头条  推荐  加粗  跳转

            if ($('table.docList td[attrField]')) {
                $('table.docList td[attrField]').text(function(index,value){
                    var attributes = value.replace(/front/i,'头条').replace(/rec/i,'推荐').replace(/bold/i,'加粗').replace(/skip/i,'跳转')
                    return attributes;
                });
            }

        }



    });
})(jQuery);















