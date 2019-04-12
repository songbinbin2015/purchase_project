<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use EasyWeChatComposer\EasyWeChat;
use EasyWeChat\Factory;

class WeChatController extends Controller
{
    //
    /**
     * 处理微信的请求消息
     *
     * @return string
     */
    public function serve()
    {
      //  dd($user = session('wechat.oauth_user.default'));
       /* Log::info('request arrived.'); # 注意：Log 为 Laravel 组件，所以它记的日志去 Laravel 日志看，而不是 EasyWeChat 日志

        $app = app('wechat.official_account');
        $app->server->push(function($message){
            return "欢迎关注 overtrue！";
        });
        return $app->server->serve();*/

        $config = [
            'app_id' => 'wxadc04d30b09de6a3',
            'secret' => '80b598ac021684e520c52fc95a44bc28',
            'token' => 'weixin',
            'response_type' => 'array',
            //...
        ];
        $app = Factory::officialAccount($config);
        $response = $app->server->serve();
        return $response;
    }
}
