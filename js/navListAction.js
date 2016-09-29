
/**
 * 设置顶部导航条内容
 */
function navListSetNav($flag){
    switch($flag){
        case 'add':
            $('#right>p.rightNav').html('<a href="" class="returnNav">内容管理</a> &gt;&gt; <a href="" class="returnNav">设置网站导航</a> &gt;&gt; <a href="">添加导航</a>');
            break;
        case 'update':
            $('#right>p.rightNav').html('<a href="" class="returnNav">内容管理</a> &gt;&gt; <a href="" class="returnNav">设置网站导航</a> &gt;&gt; <a href="">编辑导航</a>');
            break;
        case 'list':
            $('#right>p.rightNav').html('<a href="" class="returnNav">内容管理</a> &gt;&gt; <a href="" class="returnNav">设置网站导航</a>');
            break;
        case 'addChild':
            $('#right>p.rightNav').html('<a href="" class="returnNav">内容管理</a> &gt;&gt; <a href="" class="returnNav">设置网站导航</a> &gt;&gt; <a href="">添加子导航</a>');
            break;
    }
}

/**
 * 修改时获取 list 数据
 * @param  {object} e event
 */
function navListSetData(e){

    // 获取list信息
    var navInfo = [];
    navInfo['id'] = $($(e.target).parents('tr')).find('td:nth-child(1)').text();
    navInfo['nav_name'] = $($(e.target).parents('tr')).find('td:nth-child(2)').text();
    navInfo['nav_info'] = $($(e.target).parents('tr')).find('td:nth-child(3)').text();
    navInfo['pid'] = $($(e.target).parents('tr')).find('td:nth-child(4)').attr('data');
    navInfo['sort'] = $($(e.target).parents('tr')).find('td:nth-child(5)').text();

    // 显示更改前信息
    $('#right .navList.update form input[name=nav_name]').attr('placeholder',navInfo['nav_name']);
    $('#right .navList.update form input[name=pid]').attr('placeholder',navInfo['pid']);
    $('#right .navList.update form input[name=sort]').attr('placeholder',navInfo['sort']);
    $('#right .navList.update form textarea[name=nav_info]').attr('placeholder',navInfo['nav_info']);

}



/**
 * manage 获取删除操作数据
 * @param  {object} e event
 * @return {object}   ajax data
 */
function navSendDeleteData(e){
    return {action:'delete',id:$($(e.target).parents('tr')).find('td:nth-child(1)').text()}
}




/**
 * manage 获取添加操作数据
 * @param  {object} e event
 * @return {object}   data
 */
function navSendAddData(e){

    var data = {action:'add'};

    // 获取用户信息
    data.nav_name = $('div.navList.add').find('input[name=nav_name]').val();
    data.pid = $('div.navList.add').find('input[name=pid]').val();
    data.sort = $('div.navList.add').find('input[name=sort]').val();
    data.nav_info = $('div.navList.add').find('textarea[name=nav_info]').val();

    return data;

}



/**
 * manage 获取修改操作数据
 * @param  {object} e event
 * @return {object}   data
 */
function navSendUpdateData(e){

    var data = {action:'update'};

    // 获取list信息
    data.old_nav_name = $('div.navList.update').find('input[name=nav_name]').attr('placeholder');
    data.old_pid = $('div.navList.update').find('input[name=pid]').attr('placeholder');
    data.nav_name = $('div.navList.update').find('input[name=nav_name]').val();
    data.pid = $('div.navList.update').find('input[name=pid]').val();
    data.sort = $('div.navList.update').find('input[name=sort]').val();
    data.nav_info = $('div.navList.update').find('textarea[name=nav_info]').val();

    return data;

}


////////////
// 其他操作函数 //
////////////


/**
 * 添加子导航时设置id
 * @param  {object} e event
 */
function navListSetAddChildData(e){

    // 获取list信息
    var navInfo = [];
    navInfo['pid'] = $($(e.target).parents('tr')).find('td:nth-child(1)').text();

    // 显示更改前信息
    $('#right .navList.addChild form input[name=pid]').val(navInfo['pid']).attr('readonly','on');


}

/**
 * 绑定添加子导航操作函数
 * @param  {object} e event
 */
function navSendAddChildData(e){

    var data = {action:'add'};

    // 获取用户信息
    data.nav_name = $('div.navList.addChild').find('input[name=nav_name]').val();
    data.pid = $('div.navList.addChild').find('input[name=pid]').val();
    data.sort = $('div.navList.addChild').find('input[name=sort]').val();
    data.nav_info = $('div.navList.addChild').find('textarea[name=nav_info]').val();

    return data;

}


/**
 * 跳转到子导航
 * @param  {object} e event
 */
function navLoadChildList(e){

    window.loadTo($('#right'),window.$loadURL[window.$loadURL.length-1].replace(/\?.*$/i,'')+'?action=child&child='+$(e.target).parents('tr').find(':first').text());

}















