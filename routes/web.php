<?php

/**
 * 后台路由
 */

/**后台模块**/
Route::group(['namespace' => 'Admin','prefix' => 'admin'], function (){

    Route::get('login','AdminsController@showLoginForm')->name('login');  //后台登陆页面

    Route::post('login-handle','AdminsController@loginHandle')->name('login-handle'); //后台登陆逻辑

    Route::get('logout','AdminsController@logout')->name('admin.logout'); //退出登录

    /**需要登录认证模块**/
    Route::middleware(['auth:admin','rbac'])->group(function (){

        Route::resource('index', 'IndexsController', ['only' => ['index']]);  //首页

        Route::get('index/main', 'IndexsController@main')->name('index.main'); //首页数据分析

        Route::get('admins/status/{statis}/{admin}','AdminsController@status')->name('admins.status');

        Route::get('admins/delete/{admin}','AdminsController@delete')->name('admins.delete');

        Route::resource('admins','AdminsController',['only' => ['index', 'create', 'store', 'update', 'edit']]); //管理员

        Route::get('roles/access/{role}','RolesController@access')->name('roles.access');

        Route::post('roles/group-access/{role}','RolesController@groupAccess')->name('roles.group-access');

        Route::resource('roles','RolesController',['only'=>['index','create','store','update','edit','destroy'] ]);  //角色

        Route::get('rules/status/{status}/{rules}','RulesController@status')->name('rules.status');

        Route::resource('rules','RulesController',['only'=> ['index','create','store','update','edit','destroy'] ]);  //权限

        Route::resource('actions','ActionLogsController',['only'=> ['index','destroy'] ]);  //日志

        Route::resource('purchases','PurchasesController', ['only' => ['index','create', 'store', 'update', 'edit','delete']]);//采购列表
        Route::get('purchases/status/{status}/{id}','PurchasesController@status')->name('purchases.status');
        Route::get('purchases/delete/{id}','PurchasesController@delete')->name('purchases.delete');
        Route::get('purchases/edit/{id}','PurchasesController@edit')->name('purchases.edit');
        Route::any('purchases/import','PurchasesController@import')->name('purchases.import');
        Route::any('purchases/upload','PurchasesController@upload')->name('purchases.upload');
        Route::any('purchases/show','PurchasesController@show')->name('purchases.show');
        Route::resource('categorys','CategorysController', ['only' => ['index','create', 'store', 'update', 'edit','destroy']]);  //无限极分类列表
    });
});

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
//Route::any('/rcreate', 'RegisterController@create')->name('RegisterCreate');

Route::any('/wechat', 'WeChatController@serve');

Route::group(['middleware' => ['web', 'wechat.oauth']], function () { //wechat.oauth 正式调用wechat.oauth:snsapi_base基本信息 wechat.oauth:snsapi_userinfo用户详细信息 moni.auth测试使用
    Route::get('/user', function () {
       // echo 1111;exit;
        $user = session('wechat.oauth_user.default'); // 拿到授权用户资料
        dd($user);
    });
});

/*Route::group(['middleware' => 'mock.user'], function () {//这个中间件开发环境模拟一个用户授权页面
    Route::middleware('wechat.oauth:snsapi_base')->group(function () {
        Route::get('/login', 'SelfAuthController@autoLogin')->name('login');
    });
    Route::middleware('wechat.oauth:snsapi_userinfo')->group(function () {
        Route::get('/register', 'SelfAuthController@autoRegister')->name('register');
    });
});*/