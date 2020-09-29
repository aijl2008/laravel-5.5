<?php

Route::group([
    'middleware' => [
        'web',
//        'auth:rbac',
//            'rbac'
    ],
    'namespace' => 'Rbac\\',
    'prefix' => 'rbac'
], function () {
    /**
     * 个人资料
     */
    Route::get('dashboard/{id?}', 'DashboardController@index')->name('rbac.dashboard');
    Route::get('profile', 'ProfileController@edit')->name('rbac.profile');
    Route::post('profile', 'ProfileController@update')->name('rbac.profile.update');
    /**
     * 菜单
     */
    Route::resource('{parent}/menu', 'MenuController', ['as' => 'rbac']);
    /**
     * 用户
     */
    Route::resource('user', 'UserController', ['as' => 'rbac']);
    Route::get('user/{user}/role', 'UserController@role')->name('rbac.user.role');
    Route::post('user/{user}/role/update', 'UserController@updateRole')->name('rbac.user.role.update');
    /**
     * 角色
     */
    Route::resource('role', 'RoleController', ['as' => 'rbac']);
    Route::match([
        'get',
        'post'
    ], 'role/{role}/user', 'RoleController@user')->name('rbac.role.user');
    /**
     * 权限
     */
    Route::resource('{role}/permission', 'PermissionController', ['as' => 'rbac']);
    /**
     * 日志
     */
    Route::resource('log', 'LogController', [
        'only' => [
            'index',
            'destroy'
        ],
        'as' => 'rbac'
    ]);
});
