<!-- right nav -->
<p class="rightNav"><a href="" class="returnManage">管理首页</a> &gt;&gt; <a href="" class="returnManage">管理员管理</a></p>

<!-- manager list -->
<table class="manageList list">
    <caption>
        <h3>管理员列表</h3>
        <span class="action">
            [ <a href="" class="addManage">添加管理员</a> ]
        </span>
    </caption>
    <tr>
        <th>ID</th>
        <th>帐号</th>
        <th>等级</th>
        <th>登录次数</th>
        <th>最后登录ip</th>
        <th>最后登录时间</th>
        <th>注册时间</th>
        <th>操作</th>
    </tr>
    {foreach $manageInfo(key,value)}
    <tr>
        <td>{@value->id}</td>
        <td>{@value->admin_user}</td>
        <td>lv.{@value->level} {@value->level_name}</td>
        <td>{@value->login_count}</td>
        <td>{@value->login_ip}</td>
        <td>{@value->login_time}</td>
        <td>{@value->reg_time}</td>
        <td><a href="" class="updateManage">修改</a> | <a href="" class="deleteManage">删除</a></td>
    </tr>
    {/foreach}
    <div class="page manageList list" current="{$currentPage}" pageSize="{$pageCount}" pageTotal="{$pageCountTotal}">
        <a href="right-manage-manager.inc.php?page=" class="prevPage">上一页</a>
        <a href="right-manage-manager.inc.php?page=1" class="firstPage">首页</a>
        <a href="right-manage-manager.inc.php?page=1" class="pageIndex">1</a>
        <a href="right-manage-manager.inc.php?page=2" class="pageIndex">2</a>
        <a href="right-manage-manager.inc.php?page=3" class="pageIndex">3</a>
        <a href="right-manage-manager.inc.php?page=4" class="pageIndex">4</a>
        <a href="right-manage-manager.inc.php?page=5" class="pageIndex">5</a>
        <a href="right-manage-manager.inc.php?page={$pageCountTotal}" class="last">...{$pageCountTotal}</a>
        <div class="pageSize">
            <input type="text" value="{$currentPage}"> /共{$pageCountTotal}页
        </div>
        <a href="right-manage-manager.inc.php?page=" class="nextPage">下一页</a>
    </div>    
</table>

<!-- add -->
<div class="manageList add" style="display: none;">
    <fieldset>
        <legend>add manager</legend>
        <form action="" method="post" autocomplete="off">
            <p>用 户 名: <input type="text" name="admin_user"><span class="checkData"> (* 不得小于2位,不得大于20位 ) </span></p>
            <p>密&nbsp;&nbsp;码: <input type="password" name="admin_pass"><span class="checkData"> (* 不得小于6位 ) </span></p>
            <p>密码确认: <input type="password" name="admin_pass2"><span class="checkData"> (* 密码必须一致 ) </span></p>
            <p>等&nbsp;级: 
                <select name="level">
                    <option value="7">菜鸟管理员</option>    
                    <option value="8">牛逼管理员</option>    
                    <option value="9">开挂管理员</option>
                    <option value="6">邪恶怪叔叔</option>
                    <option value="5">狂躁毕业生</option>
                    <option value="4">暴走大学生</option>
                    <option value="3">猥琐高中生</option>
                    <option value="2">傲娇初中生</option>
                    <option value="1">智障小学生</option>
                </select>
            </p>
            <p><button type="submit" class="addManage">添加</button> <button type="button"  class="returnManage">返回</button></p>
        </form>
    </fieldset>
</div>

<!-- update -->
<div class="manageList update" style="display: none;">
    <fieldset>
        <legend>update manager</legend>
        <form action="" method="post" autocomplete="off">
            <p>用 户 名: <input type="text" name="admin_user"><span class="checkData"> (* 不得小于2位,不得大于20位 ) </span></p>
            <p>密&nbsp;&nbsp;码: <input type="password" name="admin_pass"><span class="checkData"> (* 不得小于6位 ) </span></p>
            <p>密码确认: <input type="password" name="admin_pass2"><span class="checkData"> (* 密码必须一致 ) </span></p>
            <p>等&nbsp;级: 
                <select name="level">
                    <option value="7">菜鸟管理员</option>
                    <option value="8">牛逼管理员</option>
                    <option value="9">开挂管理员</option>
                    <option value="6">邪恶怪叔叔</option>
                    <option value="5">狂躁毕业生</option>
                    <option value="4">暴走大学生</option>
                    <option value="3">猥琐高中生</option>
                    <option value="2">傲娇初中生</option>
                    <option value="1">智障小学生</option>
                </select>
            </p>
            <p><button type="submit" class="updateManage">提交</button> <button type="button"  class="returnManage">返回</button></p>
        </form>
    </fieldset>
</div>