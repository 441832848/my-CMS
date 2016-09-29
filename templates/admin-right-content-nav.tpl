<!-- right nav -->
<p class="rightNav"><a href="" class="returnLevel">内容管理</a> &gt;&gt; <a href="" class="returnLevel">设置网站导航</a></p>

<!-- nav list -->
<table class="navList list">
    <caption>
        <h3>导航列表</h3>
        <span class="action">
            [ <a href="" class="backLink" >返回上一步</a> ]
            [ <a href="" class="addNav">添加导航</a> ]
        </span>
    </caption>
    <tr>
        <th>编号</th>
        <th>导航名称</th>
        <th>导航说明</th>
        <th>子类</th>
        <th>排序</th>
        <th>操作</th>
    </tr>
    {if $navInfo}
    {foreach $navInfo(key,value)}
    <tr>
        <td>{@value->id}</td>
        <td>{@value->nav_name}</td>
        <td>{@value->nav_info}</td>
        <td data="{@value->pid}"> <a href="" class="childListNav">查看</a> | <a href="" class="addChildNav">增加子类</a></td>
        <td>{@value->sort}</td>
        <td><a href="" class="updateNav">修改</a> | <a href="" class="deleteNav">删除</a></td>
    </tr>
    {/foreach}
    {/if}
    <div class="page navList list" current="{$currentPage}" pageSize="{$pageCount}" pageTotal="{$pageCountTotal}">
        <a href="right-content-nav.inc.php?page=" class="prevPage">上一页</a>
        <a href="right-content-nav.inc.php?page=1" class="firstPage">首页</a>
        <a href="right-content-nav.inc.php?page=1" class="pageIndex">1</a>
        <a href="right-content-nav.inc.php?page=2" class="pageIndex">2</a>
        <a href="right-content-nav.inc.php?page=3" class="pageIndex">3</a>
        <a href="right-content-nav.inc.php?page=4" class="pageIndex">4</a>
        <a href="right-content-nav.inc.php?page=5" class="pageIndex">5</a>
        <a href="right-content-nav.inc.php?page={$pageCountTotal}" class="last">...{$pageCountTotal}</a>
        <div class="pageSize">
            <input type="text" value="{$currentPage}"> /共{$pageCountTotal}页
        </div>
        <a href="right-content-nav.inc.php?page=" class="nextPage">下一页</a>
    </div>
</table>

<!-- add -->
<div class="navList add" style="display: none;">
    <fieldset>
        <legend>add nav</legend>
        <form action="" method="post" autocomplete="off">
            <p>导航名称: <input type="text" name="nav_name"><span>(* 导航名不得大于6位 )</span></p>
            <p>子 分 类: <input type="text" name="pid"><span>(* 子分类不得大于5位 )</span></p>
            <p>排&nbsp;&nbsp;序: <input type="text" name="sort"><span>(* 排序不得大于5位 )</span></p>
            <p>导航说明: </p>
            <textarea name="nav_info" class="navInfo"></textarea><span>(* 描述不得大于200字节 )</span>
            <p><button type="submit" class="addNav">添加</button> <button type="button"  class="returnNav">返回</button></p>
        </form>
    </fieldset>
</div>

<!-- add child -->
<div class="navList addChild" style="display: none;">
    <fieldset>
        <legend>add nav child</legend>
        <form action="" method="post" autocomplete="off">
            <p>导航名称: <input type="text" name="nav_name"><span>(* 导航名不得大于6位 )</span></p>
            <p>父 导 航: <input type="text" name="pid"><span></span></p>
            <p>排&nbsp;&nbsp;序: <input type="text" name="sort"><span>(* 排序不得大于5位 )</span></p>
            <p>导航说明: </p>
            <textarea name="nav_info" class="navInfo"></textarea><span>(* 描述不得大于200字节 )</span>
            <p><button type="submit" class="addChildNav">添加</button> <button type="button"  class="returnNav">返回</button></p>
        </form>
    </fieldset>
</div>

<!-- update -->
<div class="navList update" style="display: none;">
    <fieldset>
        <legend>update nav</legend>
        <form action="" method="post" autocomplete="off">
            <p>导航名称: <input type="text" name="nav_name"><span>(* 导航名不得大于6位 )</span></p>
            <p>子 分 类: <input type="text" name="pid"><span>(* 子分类不得大于5位 )</span></p>
            <p>排&nbsp;&nbsp;序: <input type="text" name="sort"><span>(* 排
序不得大于5位 )</span></p>
            <p>导航说明: </p>
            <textarea name="nav_info" class="navInfo"></textarea><span>(* 描述不得大于200字节 )</span>
            <p><button type="submit" class="updateNav">提交</button> <button type="button" class="returnNav">返回</button></p>
        </form>
    </fieldset>
</div>