<!-- right nav -->
<p class="rightNav"><a href="" class="returnLevel">等级管理首页</a> &gt;&gt; <a href="" class="returnLevel">等级列表</a></p>

<!-- level list -->
<table class="levelList list">
    <caption>
        <h3>等级列表</h3>
        <span class="action">
            [ <a href="" class="addLevel">添加等级</a> ]
        </span>
    </caption>
    <tr>
        <th>等级</th>
        <th>称号</th>
        <th>操作</th>
    </tr>
    {foreach $levelInfo(key,value)}
    <tr>
        <td>{@value->level}</td>
        <td>{@value->level_name}</td>
        <td><a href="" class="updateLevel">修改</a> | <a href="" class="deleteLevel">删除</a></td>
    </tr>
    {/foreach}
    <div class="page levelList list" current="{$currentPage}" pageSize="{$pageCount}" pageTotal="{$pageCountTotal}">
        <a href="right-manage-level.inc.php?page=" class="prevPage">上一页</a>
        <a href="right-manage-manager.inc.php?page=1" class="firstPage">首页</a>
        <a href="right-manage-level.inc.php?page=1" class="pageIndex">1</a>
        <a href="right-manage-level.inc.php?page=2" class="pageIndex">2</a>
        <a href="right-manage-level.inc.php?page=3" class="pageIndex">3</a>
        <a href="right-manage-level.inc.php?page=4" class="pageIndex">4</a>
        <a href="right-manage-level.inc.php?page=5" class="pageIndex">5</a>
        <a href="right-manage-level.inc.php?page={$pageCountTotal}" class="last">...{$pageCountTotal}</a>
        <div class="pageSize">
            <input type="text" value="{$currentPage}"> /共{$pageCountTotal}页
        </div>
        <a href="right-manage-level.inc.php?page=" class="nextPage">下一页</a>
    </div>
</table>


<!-- add -->
<div class="levelList add" style="display: none;">
    <fieldset>
        <legend>add level</legend>
        <form action="" method="post" autocomplete="off">
            <p>等级: <input type="text" name="level"><span>(* 等级必须是0~2 )</span></p>
            <p>称号: <input type="text" name="level_name"><span>(* 称号不得小于2位,不得大于20位 )</span></p>
            <p>等级信息: </p>
            <textarea name="level_info" class="levelInfo"></textarea><span>(* 描述不得大于200字节 )</span>
            <p><button type="submit" class="addLevel">添加</button> <button type="button"  class="returnLevel">返回</button></p>
        </form>
    </fieldset>
</div>

<!-- update -->
<div class="levelList update" style="display: none;">
    <fieldset>
        <legend>update level</legend>
        <form action="" method="post" autocomplete="off">
            <p>等级: <input type="text" name="level"><span>(* 等级必须是0~2 )</span></p>
            <p>称号: <input type="text" name="level_name"><span>(* 称号不得小于2位,不得大于20位 )</span></p>
            <p>等级信息: </p>
            <textarea name="level_info" class="levelInfo"></textarea><span>(* 描述不得大于200字节 )</span>
            <p><button type="submit" class="updateLevel">提交</button> <button type="button"  class="returnLevel">返回</button></p>
        </form>
    </fieldset>
</div>