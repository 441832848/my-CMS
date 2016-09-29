<!-- right nav -->
<p class="rightNav"><a href="" class="returnDoc">内容管理</a> &gt;&gt; <a href="" class="returnDoc">查看文档列表</a></p>

<!-- manager list -->
<table class="docList list">
    <caption>
        <h3>文章列表</h3>
        <span class="action">
            [ <a href="" class="backLink" >返回上一步</a> ] 
            [ <a href="" class="addDoc">添加文章</a> ]
        </span>
    </caption>
    <tr>
        <th>编号</th>
        <th>标题</th>
        <th>属性</th>
        <th>
<!--             <select>
                <option>所属栏目</option>
            </select>   -->   
            {$docOptions}       
        </th>
        <th>浏览次数</th>
        <th>发布时间</th>
        <th>操作</th>
    </tr>
    {if $docInfo}
    {foreach $docInfo(key,value)}
    <tr>
        <td>{@value->id}</td>
        <td>{@value->title}</td>
        <td attrField>{@value->attr}</td>
        <td>{@value->nav_name}</td>
        <td>{@value->count}</td>
        <td>{@value->date}</td>
        <td><a href="" class="updateDoc" updateDoc="{@value->id}">修改</a> | <a href="" class="deleteDoc" deleteDoc="{@value->id}">删除</a></td>
    </tr>
    {/foreach}
    {/if}
    <div class="page docList list" current="{$currentPage}" pageSize="{$pageCount}" pageTotal="{$pageCountTotal}">
        <a href="right-content-doc.inc.php?navID={$navID}&page=" class="prevPage">上一页</a>
        <a href="right-content-doc.inc.php?navID={$navID}&page=1" class="firstPage">首页</a>
        <a href="right-content-doc.inc.php?navID={$navID}&page=1" class="pageIndex">1</a>
        <a href="right-content-doc.inc.php?navID={$navID}&page=2" class="pageIndex">2</a>
        <a href="right-content-doc.inc.php?navID={$navID}&page=3" class="pageIndex">3</a>
        <a href="right-content-doc.inc.php?navID={$navID}&page=4" class="pageIndex">4</a>
        <a href="right-content-doc.inc.php?navID={$navID}&page=5" class="pageIndex">5</a>
        <a href="right-content-doc.inc.php?navID={$navID}&page={$pageCountTotal}" class="last">...{$pageCountTotal}</a>
        <div class="pageSize">
            <input type="text" value="{$currentPage}"> /共{$pageCountTotal}页
        </div>
        <a href="right-content-doc.inc.php?navID={$navID}&page=" class="nextPage">下一页</a>
    </div>    
</table>

<!-- add -->
<div class="docList add edit" style="display: none;">
    <fieldset>
        <legend>create new document</legend>
        <form id="createDocument" action="" method="post" autocomplete="off">
            <p>文档标题: 
                <input type="text" name="title" required="">
                <span class="checkData">(* [<span class="red">必填</span>]，不得大于50字节 )</span></p>
            <p>栏&nbsp;&nbsp;目: 
                {$docOptions}
                <span class="checkData"> (* [<span class="red">必填</span>]，请选择一个栏目 ) </span>
            </p>
            <p>定义属性: 
                <input type="checkbox" name="front" value="">头条 
                <input type="checkbox" name="rec" value="">推荐
                <input type="checkbox" name="bold" value="">加粗
                <input type="checkbox" name="skip" value="">跳转
            <p>标&nbsp;&nbsp;签: 
                <input type="text" name="tag" required=""><span class="checkData">
                <span class="checkData"> (* [<span class="red">必填</span>]，用中文'，'分隔，单个标签小于12字节 ) </span>
            </p>
            <p>关 键 字: 
                <input type="text" name="keyword"><span class="checkData">
                <span class="checkData"> (* [<span class="green">选填</span>]，用中文'，'分隔，长度小于30字节 ) </span>
            </p>
            <p id="thumbnailLine" class="thumbnailLine">缩 略 图: 
                <input type="text" disabled="" id="thumbnail" class="thumbnail">
                <img src="" name="pic" id="uploadPic" class="uploadPic" style="display: none;">
                <button class="uploadFile">上传图片</button>
                <!-- <input type="file" name="thumbnail"> -->
                <span class="checkData"> (* [<span class="red">必填</span>]，图片小于200k/jpg/gif/png ) </span>
            </p>
            <p>文章来源: 
                <input type="text" name="source" placeholder="例：原创/腾讯新闻 小腾" required=""><span class="checkData">
                <span class="checkData"> (* [<span class="red">必填</span>]，多个来源用'，'分隔，长度小于20字节 ) </span>
            </p>
            <p>作&nbsp;&nbsp;者: 
                <input type="text" name="author" required=""><span class="checkData">
                <span class="checkData"> (* [<span class="red">必填</span>]，多名作者用'，'分开，长度小于10字节 ) </span>
            </p>
            <p class="bg-p">内容摘要: 
                <textarea name="info" class="lg-textarea" required=""></textarea>
                <span class="checkData"> (* [<span class="red">必填</span>]，长度不得大于200字节 ) </span>
            </p>
                <!-- <script src="//cdn.ckeditor.com/4.5.10/full/ckeditor.js"></script> -->
                <!-- <script type="text/javascript">$.getScript('../ckeditor/ckeditor.js');</script> -->
                <!-- <textarea id="TextArea1" name="contents" class="ckeditor"></textarea> -->

                <!-- <script type="text/javascript">$.getScript('../ckeditor/ckeditor.js');</script> -->
                
                <textarea name="content" class="ckeditor"></textarea>
                <script type="text/javascript">
                    CKEDITOR.replace('content',{
                        // uiColor : '#0F0',
                        language : 'zh-cn',
                        filebrowserImageUploadUrl : '../config/ckeditorUpload.php?type=img',
                        image_previewText : ' ',
                    });
                </script>
            <br>
            <p>评论选项: 
                <input type="radio" name="comment" value="0" checked=""> 允许评论
                <input type="radio" name="comment" value="1"> 禁止评论
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                浏览次数：
                <input type="number" name="count" class="sm-field" value="0" min="0" placeholder="请输入正整数" required="">
            </p>
            <p>文档排序: 
                <select name="sort" class="sm-field" required="">
                    <option value="0">默认排序</option>
                    <option value="1">置顶一天</option>
                    <option value="2">置顶一周</option>
                    <option value="3">置顶一月</option>
                    <option value="4">置顶一年</option>
                </select>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                消费金币：
                <input type="number" name="gold" class="sm-field" value="0" min="0" placeholder="请输入正整数" required="">
            </p>
            <p>阅读权限: 
                <select name="limit" class="sm-field" required="">
                    <option value="0">开放浏览</option>
                    <option value="1">登录用户</option>
                    <option value="2">管理员测试</option>
                </select>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                标题颜色：
                <select name="color" class="sm-field" required="">
                    <option value="black">默认颜色</option>
                    <option value="olive" style="color:olive;">灰绿色</option>
                    <option value="orange" style="color:orange;">橙色</option>
                    <option value="red" style="color:red;">红色</option>
                </select>
            </p>
            <p class="sm-button">
                <button type="submit" class="addDoc lg-button saveContents">添加</button> <button type="button"  class="returnDoc lg-button">返回</button>
            </p>
        </form>
    </fieldset>
</div>


<!-- update -->
<div class="docList update edit" style="display: none;">
    <fieldset>
        <legend>update this document</legend>
        <form id="updateDocument" action="" method="post" autocomplete="off">
            <p>文档标题: 
                <input type="text" name="title" required="">
                <span class="checkData">(* [<span class="red">必填</span>]，不得大于50字节 )</span></p>
            <p>栏&nbsp;&nbsp;目: 
                {$docOptions}
                <span class="checkData"> (* [<span class="red">必填</span>]，请选择一个栏目 ) </span>
            </p>
            <p>定义属性: 
                <input type="checkbox" name="front" value="">头条 
                <input type="checkbox" name="rec" value="">推荐
                <input type="checkbox" name="bold" value="">加粗
                <input type="checkbox" name="skip" value="">跳转
            <p>标&nbsp;&nbsp;签: 
                <input type="text" name="tag" required=""><span class="checkData">
                <span class="checkData"> (* [<span class="red">必填</span>]，用中文'，'分隔，单个标签小于12字节 ) </span>
            </p>
            <p>关 键 字: 
                <input type="text" name="keyword"><span class="checkData">
                <span class="checkData"> (* [<span class="green">选填</span>]，用中文'，'分隔，长度小于30字节 ) </span>
            </p>
            <p id="thumbnailLine" class="thumbnailLine">缩 略 图: 
                <input type="text" disabled="" id="thumbnail" class="thumbnail">
                <img src="" name="pic" id="uploadPic" class="uploadPic" style="display: none;">
                <button class="uploadFile">上传图片</button>
                <!-- <input type="file" name="thumbnail"> -->
                <span class="checkData"> (* [<span class="red">必填</span>]，图片小于200k/jpg/gif/png ) </span>
            </p>
            <p>文章来源: 
                <input type="text" name="source" placeholder="例：原创/腾讯新闻 小腾" required=""><span class="checkData">
                <span class="checkData"> (* [<span class="red">必填</span>]，多个来源用'，'分隔，长度小于20字节 ) </span>
            </p>
            <p>作&nbsp;&nbsp;者: 
                <input type="text" name="author" required=""><span class="checkData">
                <span class="checkData"> (* [<span class="red">必填</span>]，多名作者用'，'分开，长度小于10字节 ) </span>
            </p>
            <p class="bg-p">内容摘要: 
                <textarea name="info" class="lg-textarea" required=""></textarea>
                <span class="checkData"> (* [<span class="red">必填</span>]，长度不得大于200字节 ) </span>
            </p>

                <textarea name="content2">test</textarea>
                <script type="text/javascript">
                    window.$updateContent = CKEDITOR.replace('content2',{
                        // uiColor : '#0F0',
                        language : 'zh-cn',
                        filebrowserImageUploadUrl : '../config/ckeditorUpload.php?type=img',
                        image_previewText : ' ',
                    });
                </script>
            <br>
            <p>评论选项: 
                <input type="radio" name="comment" value="0" checked=""> 允许评论
                <input type="radio" name="comment" value="1"> 禁止评论
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                浏览次数：
                <input type="number" name="count" class="sm-field" value="0" min="0" placeholder="请输入正整数" required="">
            </p>
            <p>文档排序: 
                <select name="sort" class="sm-field" required="">
                    <option value="0">默认排序</option>
                    <option value="1">置顶一天</option>
                    <option value="2">置顶一周</option>
                    <option value="3">置顶一月</option>
                    <option value="4">置顶一年</option>
                </select>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                消费金币：
                <input type="number" name="gold" class="sm-field" value="0" min="0" placeholder="请输入正整数" required="">
            </p>
            <p>阅读权限: 
                <select name="limit" class="sm-field" required="">
                    <option value="0">开放浏览</option>
                    <option value="1">登录用户</option>
                    <option value="2">管理员测试</option>
                </select>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                标题颜色：
                <select name="color" class="sm-field" required="">
                    <option value="black">默认颜色</option>
                    <option value="olive" style="color:olive;">灰绿色</option>
                    <option value="orange" style="color:orange;">橙色</option>
                    <option value="red" style="color:red;">红色</option>
                </select>
            </p>
            <p class="sm-button">
                <button type="submit" class="updateDoc lg-button saveContents">确定</button> <button type="button"  class="returnDoc lg-button">返回</button>
            </p>
        </form>
    </fieldset>
</div>