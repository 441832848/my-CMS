
/**
 * 设置顶部导航条内容
 * @return {[type]} [description]
 */
function manageListSetNav($flag){
    switch($flag){
        case 'add':
            $('#right>p.rightNav').html('<a href="" class="returnManage">管理首页</a> &gt;&gt; <a href="" class="returnManage">管理员管理</a> &gt;&gt; <a href="">添加管理员</a>');
            break;
        case 'update':
            $('#right>p.rightNav').html('<a href="" class="returnManage">管理首页</a> &gt;&gt; <a href="" class="returnManage">管理员管理</a> &gt;&gt; <a href="">编辑管理员</a>');
            break;
        case 'list':
            $('#right>p.rightNav').html('<a href="" class="returnManage">管理首页</a> &gt;&gt; <a href="" class="returnManage">管理员管理</a>');
            break;
    }
}

/**
 * 修改时获取 manage list 数据
 */
function manageListSetData(e){

    // 获取用户信息
    var userInfo = [];
    userInfo['admin_user'] = $($(e.target).parents('tr')).find('td:nth-child(2)').text();
    userInfo['level'] = $($(e.target).parents('tr')).find('td:nth-child(3)').text().replace(/lv.\d{1}\s{1}/,'');

    // 显示更改前信息
    $('#right .manageList.update form input[name=admin_user]').attr('placeholder',userInfo['admin_user']);
    $('#right .manageList.update form select[name=level]>option').each(function(){
        if ($(this).text() == userInfo['level']) {
            $(this).attr('selected','');
        }
    });

}



/**
 * manage 获取删除操作数据
 * @param  {object} e event
 * @return {object}   ajax data
 */
function manageSendDeleteData(e){
    return {action:'delete',id:$($(e.target).parents('tr')).find('td:nth-child(1)').text()}
    // return $($(e.target).parents('tr')).find('td:nth-child(1)').text();
}




/**
 * manage 获取添加操作数据
 * @param  {object} e event
 * @return {object}   data
 */
function manageSendAddData(e){

    var data = {action:'add'};

    // 获取用户信息
    data.admin_user = $('div.manageList.add').find('input[name=admin_user]').val();
    data.admin_pass = $('div.manageList.add').find('input[name=admin_pass]').val();
    data.admin_pass2 = $('div.manageList.add').find('input[name=admin_pass2]').val();
    data.level = $('div.manageList.add').find('select[name=level]').val();

    return data;

}



/**
 * manage 获取修改操作数据
 * @param  {object} e event
 * @return {object}   data
 */
function manageSendUpdateData(e){

    var data = {action:'update'};

    // 获取用户信息
    data.old_admin_user = $('div.manageList.update').find('input[name=admin_user]').attr('placeholder');
    data.admin_user = $('div.manageList.update').find('input[name=admin_user]').val();
    data.admin_pass = $('div.manageList.update').find('input[name=admin_pass]').val();
    data.admin_pass2 = $('div.manageList.update').find('input[name=admin_pass2]').val();
    data.level = $('div.manageList.update').find('select[name=level]').val();

    return data;

}