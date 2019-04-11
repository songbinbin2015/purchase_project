<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Arr;
use Overtrue\Socialite\User as SocialiteUser;

class MoniMiddleUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = [];
        $user = [
            'openid'=>'w2323232323233',
            'nickname'=>'moni_name',
            'headimgurl'=>'moni_headimgurl',
            'email'=>'moni_email',
            'unquid'=>'moniunquid'
            ];
        $user = new SocialiteUser([
            'id' => Arr::get($user, 'openid'),
            'name' => Arr::get($user, 'nickname'),
            'nickname' => Arr::get($user, 'nickname'),
            'avatar' => Arr::get($user, 'headimgurl'),
            'email' => Arr::get($user, 'email'),
            'original' => [],
            'provider' => 'WeChat',
        ]);
        session(['wechat.oauth_user.default' => $user]);
        return $next($request);
    }
}
