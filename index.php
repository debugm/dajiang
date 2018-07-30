<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2011 http://topthink.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用入口文件


// 检测PHP环境
if (version_compare(PHP_VERSION, '5.4.0', '<')) {
    die('require PHP > 5.4.0 !');
}
    
// 定义应用目录
define('APP_PATH', './Application/');
// 开启调试模式
define('APP_DEBUG', true);

//系统安装及开发模式检测
if (is_file(APP_PATH. 'Common/Conf/install.lock') === false) {
    define('BIND_MODULE', 'Install');
}

// 引入ThinkPHP入口文件
require './core/ThinkPHP.php';

// 亲^_^ 后面不需要任何代码了 就是如此简单