<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use EasyWeChatComposer\EasyWeChat;

class WeChatController extends Controller
{
    //
    /**
     * 处理微信的请求消息
     *
     * @return string
     */
    private $app = 'wechat.official_account';
    public function serve()
    {
      //  dd($user = session('wechat.oauth_user.default'));
       // Log::info('request arrived.'); # 注意：Log 为 Laravel 组件，所以它记的日志去 Laravel 日志看，而不是 EasyWeChat 日志

        $app = app($this->app);
        $app->server->push(function($message){
            return "欢迎关注 我的测试公众号！";
        });

        return $app->server->serve();
    }

    /**
     * @return mixed
     * 用户授权
     */
    public function scoap(){
        $app = app($this->app);
        $response = $app->oauth->scopes(['snsapi_userinfo'])->redirect();
        return $response;
    }

    /**
     * 获取用户信息
     */
    public function getUser(){
        $app = app($this->app);
        $user = $app->oauth->user();
        dd($user);
    }
}
