<?php
return [
    'home' => 'rbac.dashboard',
    'database' => [
        'connection' => 'mysql',//您的数据数据库连接名，rbac的所有模型，将使用该连接名
        'table_pre' => 'rbac_',//rbac所有表的前缀，用于区别同一数据库中的其他数据表
        'login' => 'email', //登陆属性，可以使用email或username
    ]
];
