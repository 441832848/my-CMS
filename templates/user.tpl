<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="UTF-8">
    <title>CMS 会员{$actionType}</title>
    <link rel="stylesheet" type="text/css" href="style/Basic.css">
    <link rel="stylesheet" type="text/css" href="style/index.css">
    <link rel="stylesheet" type="text/css" href="style/user.css">
    <link rel="icon" type="image/x-icon" href="images/Favicon.ico">
    <script type="text/javascript" src="js/jQuery.min.js"></script>
    <script type="text/javascript" src="js/user.js"></script>
</head>
<body>

    <div id="reg">
        <h2>会员{$actionType}</h2>
        <form autocomplete="off">
            <dl>
                {if $login}
                <dd>用 户 名：<input type="text" class="text" name="username" /> <span class="red"></span></dd>
                <dd>密　　码：<input type="password" class="text" name="password" /> <span class="red"></span></dd>
                <dd>验 证 码：<input type="text" class="text" name="validateCode" /> <span class="red"></span></dd>
                <dd><img src="config/validateCode.php" class="validateCodeIamge code"> <span>点击图片刷新</span></dd>
                <dd>登录保留：<input type="radio" name="cookie" value="0" checked=""> 不保留 <input type="radio" name="cookie" value="7"> 一周 <input type="radio" name="cookie" value="30"> 一月</dd>
                <dd><input type="submit" class="submit" name="send" value="登录" />&nbsp;&nbsp;&nbsp;<a href="?action=reg">立即注册</a></dd>
                {else}
                <dd>用 户 名：<input type="text" class="text" name="username" /> <span class="red">[必填]</span> ( *用户名在2到20位之间 )</dd>
                <dd>密　　码：<input type="password" class="text" name="password" /> <span class="red">[必填]</span> ( *密码不得小于6位 )</dd>
                <dd>密码确认：<input type="password" class="text" name="password2" /> <span class="red">[必填]</span> ( *密码确认和密码一致 )</dd>
                <dd>电子邮件：<input type="text" class="text" name="email" /> <span class="red">[必填]</span> ( *每个电子邮件只能注册一个ID )</dd>
                <dd>选择头像：<img src="images/01.gif" alt="01" width="100px" height="100px" id="face" faceCount="{$faceCount}"> ( *点击更换图片 )</dd>
                <dd>安全问题：<select name="question">
                                            <option value="">没有任何安全问题</option>
                                            <option value="0">您父亲的姓名？</option>
                                            <option value="1">您母亲的职业？</option>
                                            <option value="2">您配偶的姓名？</option>
                              </select>
                </dd>
                <dd>问题答案：<input type="text" class="text" name="answer" /></dd>
                <dd>验 证 码：<input type="text" class="text" name="validateCode" /> <span class="red">[必填]</span></dd>
                <dd><img src="config/validateCode.php" class="validateCodeIamge code"> <span>点击图片刷新</span></dd>
                <dd>登录保留：<input type="radio" name="cookie" value="0" checked=""> 不保留 <input type="radio" name="cookie" value="7"> 一周 <input type="radio" name="cookie" value="30"> 一月</dd>
                <dd><input type="submit" class="submit" name="send" value="注册" />&nbsp;&nbsp;&nbsp;<a href="?action=login">立即登录</a></dd>
                {/if}
            </dl>
        </form>
    </div>

</body>
</html>