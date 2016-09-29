    <div id="top">
        {$topTips1}
        {$topTips2}
        &nbsp;&nbsp;&nbsp;
        <a href="###">这里是文字广告1</a>
        <a href="###">这里是文字广告2</a>
    </div>
    <div id="header">
        <h1><a href="###">CMS内容管理系统</a></h1>
        <div id="adver">
            <a href="#"><img src="images/header3.png"></a>
        </div>
    </div>
    <div id="nav">
        <ul>
            <li><a href="index.php">首页</a></li>
            {if $frontNav}
            {foreach $frontNav(key,value)}
            <li><a href="list.php?nav={@value->id}">{@value->nav_name}</a></li>
            {/foreach}
            {/if}
        </ul>
    </div>
    <div id="search">
        <form autocomplete="off">
            <select name="search">
                <option selected="selected">按标题</option>
                <option>按关键字</option>
                <option>全局查询</option>
            </select>
            <input type="text" name="keyword" class="text" />
            <input type="submit" name="send" class="submit" value="搜索" />
        </form>
        <strong>TAG标签：</strong>
        <ul>
            <li><a href="###">基金(3)</a></li>
            <li><a href="###">美女(1)</a></li>
            <li><a href="###">白兰地(3)</a></li>
            <li><a href="###">音乐(1)</a></li>
            <li><a href="###">体育(1)</a></li>
            <li><a href="###">直播(1)</a></li>
            <li><a href="###">会晤(1)</a></li>
            <li><a href="###">韩日(1)</a></li>
            <li><a href="###">警方(1)</a></li>
            <li><a href="###">广州(1)</a></li>
        </ul>
    </div>