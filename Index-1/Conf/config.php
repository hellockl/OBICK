<?php
return array(
    //'配置项'=>'配置值'
    //'配置项'=>'配置值' 
    'DB_TYPE'               =>  'mysql',     // 数据库类型 
    'DB_HOST'               =>  'localhost', // 服务器地址 
    'DB_NAME'               =>  'newapp',          // 数据库名 
    'DB_USER'               =>  'root',      // 用户名 
    'DB_PWD'                =>  'ckliang',          // 密码 
    'DB_PORT'               =>  '3306',        // 端口 
    'DB_PREFIX'             =>  'n_',    // 数据库表前缀 
    'DB_CHARSET'            =>  'utf8',      // 数据库编码 
    'DB_DEBUG'  =>  TRUE, // 数据库调试模式 开启后可以记录SQL日志
    'HTTP_UPLOAD'    =>  __ROOT__.'/Public/upload/',
    '__PUBLIC__'    =>  __ROOT__.'/Public/'
);