<?php

/**
 * 初始化配置文件
 * @authors Your Name (you@example.org)
 * @date    2016-08-02 19:22:32
 * @version $Id$
 */

    /////////////
    // 数据库配置信息 //
    /////////////

    define('DB_HOST', '127.0.0.1');                         // 数据库URL
    define('DB_USERNAME', 'root');                          // 数据库用户名
    define('DB_PASSWORD', '');                              // 数据库密码
    define('DB_NAME', 'cms');                               // 数据库名

    /////////////
    // 文件夹配置信息 //
    /////////////

    define('TPL_DIR', ROOT_PATH.'/templates/');             // 存放模版的文件夹
    define('TPL_C_DIR', ROOT_PATH.'/templates_c/');         // 编译文件夹
    define('CACHE_DIR', ROOT_PATH.'/cache/');               // 缓存文件夹
    define('UPLOAD_DIR', ROOT_PATH.'/upload_files/');       // 存放上传文件的文件夹

    ////////////
    // 页面配置信息 //
    ////////////
    define('PAGE_COUNT', 8);                                // 每页显示的条数
    define('FRONT_PAGE_COUNT', 1);                          // 每页显示的条数
    define('NAV_SIZE', 10);                                 // 页面头部导航数量
    define('WATER_TEXT', 'CMS 内容管理系统');               // 缩略图水印文字
    define('IS_CACHE', false);                              // 前台是否开启缓存
    define('NO_CACHE', 'index.php&list.php&/admin/&/action/&/ckeditor/&/config/&/includes/&/model/&/templates/');       // 开启缓存时不需要缓存的页面

    ////////////
    // 脚本配置信息 //
    ////////////
    define('TIMEZONE','Asia/Shanghai');                     // 时区设置




