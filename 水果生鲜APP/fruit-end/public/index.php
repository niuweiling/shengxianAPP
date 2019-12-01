<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

/*
 * 跨域  协议  域名  端口号
 * 1、jsonp ：动态插入script   src
 *2、代理
 * 3、服务器
 *  */
// [ 应用入口文件 ]
//JWT方式验证请求配置头信息
header("Access-Control-Allow-Origin: *");//允许跨域访问
header("Access-Control-Allow-Headers: Origin, X-Requested-With,Authorization,Content-Type,RetryAfter,retry-after,Accept, token");//允许请求字段
header('Access-Control-Allow-Methods: GET, POST, PUT,DELETE,OPTIONS');//请求方式


//判断请求方式  过滤掉options方式
if ($_SERVER['REQUEST_METHOD']=='OPTIONS'){
	exit;
}
// 定义应用目录
define('APP_PATH', __DIR__ . '/../application/');
// 加载框架引导文件
require __DIR__ . '/../thinkphp/start.php';
