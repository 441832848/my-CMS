<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="UTF-8">
    <title>CMS内容管理系统</title>
    <link rel="stylesheet" type="text/css" href="style/Basic.css">
    <link rel="stylesheet" type="text/css" href="style/index.css">
    <link rel="icon" type="image/x-icon" href="images/Favicon.ico">
    <script type="text/javascript" src="js/jQuery.min.js"></script>
    <script type="text/javascript" src="js/indexLogin.js"></script>
</head>
<body>
{include file='header.tpl'}
    <div id="user">
        <h2>会员信息</h2>
        <form autocomplete="off" login style="display: block;">
            <label>用户名：<input type="text" name="username" class="text" /></label>
            <label>密　码：<input type="password" name="password" class="text" /></label>
            <label>验证码：<input type="text" name="validateCode" class="text code" /></label>
            <img src="config/validateCode.php" class="validateCodeIamge code" alt="验证码" />
            <p><input type="submit" name="send" value="登录" class="submit" /> <a href="user.php">注册会员</a> <a href="###">忘记密码?</a></p>
        </form>
        <div class="is-login" style="display: none;">
            <hr>
            <div class="tips">您好， <span class="name">username</span> 欢迎您</div>
            <hr>
            <div class="user-info">
                <img src="images/01.gif" alt="face" class="face">
                <div class="user-link">
                    <a href="">个人中心</a><br>
                    <a href="">我的评论</a><br>
                    <a href="" class="logout">退出登陆</a>
                </div>
            </div>
        </div>
        <h3>最近登录会员 <span> ──────────────────</span></h3>
        {if $loginUserList}
        {foreach $loginUserList(key,value)}
        <dl>
            <dt><img src="images/{@value->face}.gif" alt="头像" /></dt>
            <dd>{@value->username}</dd>
        </dl>
        {/foreach}
        {/if}
<!--         <dl>
            <dt><img src="images/01.gif" alt="头像" /></dt>
            <dd>蜡笔小新</dd>
        </dl>
        <dl>
            <dt><img src="images/18.gif" alt="头像" /></dt>
            <dd>圣斗士星矢</dd>
        </dl>
        <dl>
            <dt><img src="images/18.gif" alt="头像" /></dt>
            <dd>黑崎一护</dd>
        </dl>
        <dl>
            <dt><img src="images/01.gif" alt="头像" /></dt>
            <dd>我叫MT</dd>
        </dl>
        <dl>
            <dt><img src="images/18.gif" alt="头像" /></dt>
            <dd>海贼王路飞</dd>
        </dl> -->
    </div>
    <div id="news">
        <h3><a href="###">联合利华因散布涨价信息被罚</a></h3>
        <p>核心提示：国家发改委发布公告称，3月下旬，联合利华(中国)有限公司有关负责人多次接受采访发表日化产品涨价言论。此行为导致日化产品涨价的信息广泛传播，增强了消费者涨价预...<a href="###">[查看全文]</a></p>
        <p class="link">
            <a href="###">优酷计划通过增发再融6亿美元</a> | 
            <a href="###">网秦上市次日收盘大跌9.68%</a> 
            <a href="###">电子书市场遭遇优质内容缺失之困</a> | 
            <a href="###">人人IPO次日收盘下跌6％</a> 
        </p>
        <ul>
            <li><em>11-06-04</em><a href="###">报告预计2011年全球3D电视出货量同比增500%...</a></li>
            <li><em>11-05-03</em><a href="###">58同城获日本分类信息公司Recruit战略...</a></li>
            <li><em>11-06-04</em><a href="###">DisplaySearch：全球3D电视销量将达22OO万台..</a></li>
            <li><em>11-04-08</em><a href="###">前程无忧一季度净利1400万美元 同比增81.6%...</a></li>
            <li><em>11-08-04</em><a href="###">人人上市次日早盘大跌9%报16.39美元...</a></li>
            <li><em>11-11-18</em><a href="###">优酷来自手机及平板电脑播放量已占整站10%...</a></li>
            <li><em>11-06-12</em><a href="###">报告称Android一季度在美市场份额扩至34.7%...</a></li>
            <li><em>11-12-11</em><a href="###">阿尔卡特朗讯2011第一财季营收同比增15%...</a></li>
            <li><em>11-01-09</em><a href="###">HTC第一季度智能手机销量970万 年成长率192% ...</a></li>
            <li><em>11-04-07</em><a href="###">一季度苹果占全球智能机份额升至18.7%居次席会...</a></li>
        </ul>
    </div>
    <div id="pic">
        <img src="images/adverleft.png" alt="新闻图片" />
    </div>
    <div id="rec">
        <h2>特别推荐</h2>
        <ul>
            <li><em>06-20</em><a href="###">银监会否认首套房贷首付将提至...</a></li>
            <li><em>04-02</em><a href="###">发改委曝房价违规开发商名单央...</a></li>
            <li><em>02-13</em><a href="###">社科院预测更严厉楼市政策年内...</a></li>
            <li><em>05-05</em><a href="###">比亚迪拟“缩水”回归A股 以缓解...</a></li>
            <li><em>07-11</em><a href="###">第一线：北京限制高价盘预售证...</a></li>
            <li><em>03-18</em><a href="###">电网主辅分离或年内完成 葛洲坝...</a></li>
            <li><em>05-02</em><a href="###">京沪高铁将于6月9日起试运行10天...</a></li>
        </ul>
    </div>
    <div id="sidebar-right">
        <div class="adver">
            <img src="images/adverleft.png">
        </div>
            <div class="hot block_total">
                <h2>本月热点</h2>
                <ul class="block_div">
                    <li><em>06-20</em><a href="###">银监会否认首套房贷首付将提至...</a></li>
                    <li><em>04-02</em><a href="###">发改委曝房价违规开发商名单央...</a></li>
                    <li><em>02-13</em><a href="###">社科院预测更严厉楼市政策年内...</a></li>
                    <li><em>05-05</em><a href="###">比亚迪拟“缩水”回归A股 以缓解...</a></li>
                    <li><em>07-11</em><a href="###">第一线：北京限制高价盘预售证...</a></li>
                    <li><em>03-18</em><a href="###">电网主辅分离或年内完成 葛洲坝...</a></li>
                    <li><em>05-02</em><a href="###">京沪高铁将于6月9日起试运行10天...</a></li>
                </ul>    
            </div>
            <div class="comm block_total">
                <h2>本月评论</h2>
                <ul class="block_div">
                    <li><em>06-20</em><a href="###">银监会否认首套房贷首付将提至...</a></li>
                    <li><em>04-02</em><a href="###">发改委曝房价违规开发商名单央...</a></li>
                    <li><em>02-13</em><a href="###">社科院预测更严厉楼市政策年内...</a></li>
                    <li><em>05-05</em><a href="###">比亚迪拟“缩水”回归A股 以缓解...</a></li>
                    <li><em>07-11</em><a href="###">第一线：北京限制高价盘预售证...</a></li>
                    <li><em>03-18</em><a href="###">电网主辅分离或年内完成 葛洲坝...</a></li>
                    <li><em>05-02</em><a href="###">京沪高铁将于6月9日起试运行10天...</a></li>
                </ul>    
            </div>
            <div class="vote block_total">
                <h2>调查投票</h2>
                <h3>请问您是怎么知道本站的:</h3>
                <form>
                    <label for=""><input type="radio" name="vote"> 门户网站的搜索引擎</label>
                    <label for=""><input type="radio" name="vote"> Google或百度搜索</label>
                    <label for=""><input type="radio" name="vote"> 别的网站上的链接</label>
                    <label for=""><input type="radio" name="vote"> 朋友介绍或者电视广告</label>
                    <p>
                        <button>投票</button>
                        <button>查看</button>                    
                    </p>
                </form>   
            </div>
        </div>
    </div>
    <div id="picnews">
            <h2>图文资讯</h2>
            <dl>
                <dt><a href="###"><img src="images/pic1.jpg" alt="标题" /></a></dt>
                <dd><a href="###">以色列总理出访法国 士兵在迎接仪式上晕倒</a></dd>
            </dl>
            <dl>
                <dt><a href="###"><img src="images/pic2.jpg" alt="标题" /></a></dt>
                <dd><a href="###">江西数百学生操场上给母亲洗脚</a></dd>
            </dl>
            <dl>
                <dt><a href="###"><img src="images/pic1.jpg" alt="标题" /></a></dt>
                <dd><a href="###">歼20照片再现 地勤人员钻入起落架舱</a></dd>
            </dl>
            <dl>
                <dt><a href="###"><img src="images/pic1.jpg" alt="标题" /></a></dt>
                <dd><a href="###">摄影师拍“水下工程” 波浪如蘑菇云</a></dd>
            </dl>
    </div>
    <div id="newslist">
    <div class="list bottom">
        <h2><a href="###">更多</a>军事动态</h2>
        <ul>
            <li><em>06-04</em><a href="###">报告预计2011年全球3D电视出货量同比增500%...</a></li>
            <li><em>05-03</em><a href="###">58同城获日本分类信息公司Recruit战略...</a></li>
            <li><em>06-04</em><a href="###">DisplaySearch：全球3D电视销量将达22OO万台..</a></li>
            <li><em>04-08</em><a href="###">前程无忧一季度净利1400万美元 同比增81.6%...</a></li>
            <li><em>08-04</em><a href="###">人人上市次日早盘大跌9%报16.39美元...</a></li>
            <li><em>11-18</em><a href="###">优酷来自手机及平板电脑播放量已占整站10%...</a></li>
            <li><em>06-12</em><a href="###">报告称Android一季度在美市场份额扩至34.7%...</a></li>
            <li><em>12-11</em><a href="###">阿尔卡特朗讯2011第一财季营收同比增15%...</a></li>
            <li><em>01-09</em><a href="###">HTC第一季度智能手机销量970万 年成长192% ...</a></li>
            <li><em>04-07</em><a href="###">一季度苹果占全球智能机份额升至18.7%席会...</a></li>
            <li><em>08-04</em><a href="###">人人上市次日早盘大跌9%报16.39美元...</a></li>
        </ul>
    </div>
    <div class="list right bottom">
        <h2><a href="###">更多</a>八卦娱乐</h2>
        <ul>
            <li><em>06-04</em><a href="###">报告预计2011年全球3D电视出货量同比增500%...</a></li>
            <li><em>05-03</em><a href="###">58同城获日本分类信息公司Recruit战略...</a></li>
            <li><em>06-04</em><a href="###">DisplaySearch：全球3D电视销量将达22OO万台..</a></li>
            <li><em>04-08</em><a href="###">前程无忧一季度净利1400万美元 同比增81.6%...</a></li>
            <li><em>08-04</em><a href="###">人人上市次日早盘大跌9%报16.39美元...</a></li>
            <li><em>11-18</em><a href="###">优酷来自手机及平板电脑播放量已占整站10%...</a></li>
            <li><em>06-12</em><a href="###">报告称Android一季度在美市场份额扩至34.7%...</a></li>
            <li><em>12-11</em><a href="###">阿尔卡特朗讯2011第一财季营收同比增15%...</a></li>
            <li><em>01-09</em><a href="###">HTC第一季度智能手机销量970万 年成长192% ...</a></li>
            <li><em>04-07</em><a href="###">一季度苹果占全球智能机份额升至18.7%席会...</a></li>
            <li><em>08-04</em><a href="###">人人上市次日早盘大跌9%报16.39美元...</a></li>
        </ul>
    </div>
    <div class="list">
        <h2><a href="###">更多</a>时尚女人</h2>
        <ul>
            <li><em>06-04</em><a href="###">报告预计2011年全球3D电视出货量同比增500%...</a></li>
            <li><em>05-03</em><a href="###">58同城获日本分类信息公司Recruit战略...</a></li>
            <li><em>06-04</em><a href="###">DisplaySearch：全球3D电视销量将达22OO万台..</a></li>
            <li><em>04-08</em><a href="###">前程无忧一季度净利1400万美元 同比增81.6%...</a></li>
            <li><em>08-04</em><a href="###">人人上市次日早盘大跌9%报16.39美元...</a></li>
            <li><em>11-18</em><a href="###">优酷来自手机及平板电脑播放量已占整站10%...</a></li>
            <li><em>06-12</em><a href="###">报告称Android一季度在美市场份额扩至34.7%...</a></li>
            <li><em>12-11</em><a href="###">阿尔卡特朗讯2011第一财季营收同比增15%...</a></li>
            <li><em>01-09</em><a href="###">HTC第一季度智能手机销量970万 年成长192% ...</a></li>
            <li><em>04-07</em><a href="###">一季度苹果占全球智能机份额升至18.7%席会...</a></li>
            <li><em>08-04</em><a href="###">人人上市次日早盘大跌9%报16.39美元...</a></li>
        </ul>
    </div>
    <div class="list right">
        <h2><a href="###">更多</a>科技频道</h2>
        <ul>
            <li><em>06-04</em><a href="###">报告预计2011年全球3D电视出货量同比增500%...</a></li>
            <li><em>05-03</em><a href="###">58同城获日本分类信息公司Recruit战略...</a></li>
            <li><em>06-04</em><a href="###">DisplaySearch：全球3D电视销量将达22OO万台..</a></li>
            <li><em>04-08</em><a href="###">前程无忧一季度净利1400万美元 同比增81.6%...</a></li>
            <li><em>08-04</em><a href="###">人人上市次日早盘大跌9%报16.39美元...</a></li>
            <li><em>11-18</em><a href="###">优酷来自手机及平板电脑播放量已占整站10%...</a></li>
            <li><em>06-12</em><a href="###">报告称Android一季度在美市场份额扩至34.7%...</a></li>
            <li><em>12-11</em><a href="###">阿尔卡特朗讯2011第一财季营收同比增15%...</a></li>
            <li><em>01-09</em><a href="###">HTC第一季度智能手机销量970万 年成长192% ...</a></li>
            <li><em>04-07</em><a href="###">一季度苹果占全球智能机份额升至18.7%席会...</a></li>
            <li><em>08-04</em><a href="###">人人上市次日早盘大跌9%报16.39美元...</a></li>
        </ul>
    </div>
</div>
{include file='footer.tpl'}
</body>
</html>