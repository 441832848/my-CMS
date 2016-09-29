<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="UTF-8">
    <title>CMS内容管理系统</title>
    <link rel="stylesheet" type="text/css" href="style/Basic.css">
    <link rel="stylesheet" type="text/css" href="style/list.css">
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/frontPage.js"></script>
    <link rel="icon" type="image/x-icon" href="images/Favicon.ico">
</head>
<body>
{include file='header.tpl'}
    
<div id="list">
    <h2>
        <div class="childNavList">        
        {if $childNavInfo}
        {foreach $childNavInfo(key,value)}
        <span class="childNavName"><span class="gt">&gt;&gt;</span> <a href="list.php?nav={@value->id}">{@value->nav_name}</a></span> 
        {/foreach}
        {/if}
        </div>
    </h2>
    <div page>
        {if $docModule}
        {foreach $docModule(key,value)}
        <div>
            <dl pageElement>
                <dt style="background-image:url({@value->thumbnail});"></dt>
                <dd>[<strong>{@value->nav_name}</strong>] <a href="detail.php?id={@value->id}">{@value->title}</a></dd>
                <dd>日期：{@value->date} 点击量：{@value->count} 好评：0</dd>
                <dd>{@value->info}</dd>
            </dl>
        </div>
        {/foreach}
        {/if}
    </div>

<!-- 
    <dl>
        <dt><img src="images/none.jpg" alt="" /></dt>
        <dd>[<strong>军事动态</strong>] <a href="###">联合利华因散布涨价信息被罚200万</a></dd>
        <dd>日期：2011年10月10日 17:17:17 点击率：224 好评：0</dd>
        <dd>核心提示：国家发改委发布公告称，3月下旬，联合利华(中国)有限公司有关负责人多次接受采访发表日化产品涨价言论。此行为导致日化产品涨价的信息广泛传播，增强了消费者涨价预此行为导致日化产品涨价的信息广泛传播，增强了消费者涨价预...</dd>
    </dl>
 -->
    <!-- <div id="page">分页</div> -->
    <div id="page" class="page navList list" current="{$currentPage}" pageSize="{$pageCount}" pageTotal="{$pageCountTotal}">
        <a href="list.php?nav={$navId}&page=" class="prevPage">上一页</a>
        <a href="list.php?nav={$navId}&page=1" class="firstPage">首页</a>
        <a href="list.php?nav={$navId}&page=1" class="pageIndex">1</a>
        <a href="list.php?nav={$navId}&page=2" class="pageIndex">2</a>
        <a href="list.php?nav={$navId}&page=3" class="pageIndex">3</a>
        <a href="list.php?nav={$navId}&page=4" class="pageIndex">4</a>
        <a href="list.php?nav={$navId}&page=5" class="pageIndex">5</a>
        <a href="list.php?nav={$navId}&page={$pageCountTotal}" class="last">...{$pageCountTotal}</a>
        <div class="pageSize">
            <input type="text" value="{$currentPage}"> /共{$pageCountTotal}页
        </div>
        <a href="list.php?nav={$navId}&page=" class="nextPage">下一页</a>
    </div>
</div>
<div id="sidebar">
    <div class="nav">
        <h2>子栏目列表</h2>
        {if $childNavList}
        {foreach $childNavList(key,value)}
        <strong><a href="list.php?nav={@value->id}">{@value->nav_name}</a></strong>
        {/foreach}
        {/if}
    </div>
    <div class="right">
        <h2>本类推荐</h2>
        <ul>
            <li><em>06-20</em><a href="###">银监会否认首套房贷首付将提至...</a></li>
            <li><em>04-02</em><a href="###">发改委曝房价违规开发商名单央...</a></li>
            <li><em>02-13</em><a href="###">社科院预测更严厉楼市政策年内...</a></li>
            <li><em>05-05</em><a href="###">比亚迪拟“缩水”回归A股 以缓解...</a></li>
            <li><em>07-11</em><a href="###">第一线：北京限制高价盘预售证...</a></li>
            <li><em>03-18</em><a href="###">电网主辅分离或年内完成 葛洲坝...</a></li>
            <li><em>05-02</em><a href="###">京沪高铁将于6月9日起试运行10...</a></li>
        </ul>
    </div>
    <div class="right">
        <h2>本类热点</h2>
        <ul>
            <li><em>06-20</em><a href="###">银监会否认首套房贷首付将提至...</a></li>
            <li><em>04-02</em><a href="###">发改委曝房价违规开发商名单央...</a></li>
            <li><em>02-13</em><a href="###">社科院预测更严厉楼市政策年内...</a></li>
            <li><em>05-05</em><a href="###">比亚迪拟“缩水”回归A股 以缓解...</a></li>
            <li><em>07-11</em><a href="###">第一线：北京限制高价盘预售证...</a></li>
            <li><em>03-18</em><a href="###">电网主辅分离或年内完成 葛洲坝...</a></li>
            <li><em>05-02</em><a href="###">京沪高铁将于6月9日起试运行10...</a></li>
        </ul>
    </div>
    <div class="right">
        <h2>本类图文</h2>
        <ul>
            <li><em>06-20</em><a href="###">银监会否认首套房贷首付将提至...</a></li>
            <li><em>04-02</em><a href="###">发改委曝房价违规开发商名单央...</a></li>
            <li><em>02-13</em><a href="###">社科院预测更严厉楼市政策年内...</a></li>
            <li><em>05-05</em><a href="###">比亚迪拟“缩水”回归A股 以缓解...</a></li>
            <li><em>07-11</em><a href="###">第一线：北京限制高价盘预售证...</a></li>
            <li><em>03-18</em><a href="###">电网主辅分离或年内完成 葛洲坝...</a></li>
            <li><em>05-02</em><a href="###">京沪高铁将于6月9日起试运行10...</a></li>
        </ul>
    </div>
</div>

{include file='footer.tpl'}
</body>
</html>