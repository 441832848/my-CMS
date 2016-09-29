
/**
 * 设置顶部导航条内容
 * @return {[type]} [description]
 */
function levelListSetNav($flag){
    switch($flag){
        case 'add':
            $('#right>p.rightNav').html('<a href="" class="returnLevel">等级管理首页</a> &gt;&gt; <a href="" class="returnLevel">等级管理</a> &gt;&gt; <a href="">添加管理员等级</a>');
            break;
        case 'update':
            $('#right>p.rightNav').html('<a href="" class="returnLevel">等级管理首页</a> &gt;&gt; <a href="" class="returnLevel">等级管理</a> &gt;&gt; <a href="">修改管理员等级</a>');
            break;
        case 'list':
            $('#right>p.rightNav').html('<a href="" class="returnLevel">等级管理首页</a> &gt;&gt; <a href="" class="returnLevel">等级列表</a>');
            break;

    }
    $('#right>p.rightNav').html('<a href="" class="returnManage">管理首页</a> &gt;&gt; <a href="" class="returnManage">管理员管理</a> &gt;&gt; <a href="">添加管理员</a>');
}

/**
 * 修改时获取 level list 数据
 */
function levelListSetData(e){

    // 获取等级信息
    var levelInfo = [];
    levelInfo['level'] = $($(e.target).parents('tr')).find('td:nth-child(1)').text();
    levelInfo['level_name'] = $($(e.target).parents('tr')).find('td:nth-child(2)').text();

    // 显示更改前信息
    $('#right .levelList.update form input[name=level]').attr('placeholder',levelInfo['level']);
    $('#right .levelList.update form input[name=level_name]').attr('placeholder',levelInfo['level_name']);

}



/**
 * level 获取删除操作数据
 * @param  {object} e event
 * @return {object}   ajax data
 */
function levelSendDeleteData(e){

    // 获取用户ID
    var level = $($(e.target).parents('tr')).find('td:nth-child(1)').text();
    var level_name = $($(e.target).parents('tr')).find('td:nth-child(2)').text();

    // 发送请求
    return {action:'delete',level:level,level_name:level_name};

}




/**
 * level 获取添加操作数据
 * @param  {object} e event
 * @return {object}   data
 */
function levelSendAddData(e){

    var data = {action:'add'};

    // 获取用户信息
    data.level = $('div.levelList.add').find('input[name=level]').val();
    data.level_name = $('div.levelList.add').find('input[name=level_name]').val();
    data.level_info = $('div.levelList.add').find('textarea[name=level_info]').val();

    return data;

}




/**
 * level 获取修改操作数据
 * @param  {object} e event
 * @return {object}   data
 */
function levelSendUpdateData(e){

    var data = {action:'update'};

    // 获取用户信息
    data.old_level = $('div.levelList.update').find('input[name=level]').attr('placeholder');
    data.old_level_name = $('div.levelList.update').find('input[name=level_name]').attr('placeholder');
    data.level = $('div.levelList.update').find('input[name=level]').val();
    data.level_name = $('div.levelList.update').find('input[name=level_name]').val();
    data.level_info = $('div.levelList.update').find('textarea[name=level_info]').val();

    return data;

}