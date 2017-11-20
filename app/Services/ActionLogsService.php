<?php
/**
 * YICMS
 * ============================================================================
 * 版权所有 2014-2017 YICMS，并保留所有权利。
 * 网站地址: http://www.yicms.vip
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * Created by PhpStorm.
 * Author: kenuo
 * Date: 2017/11/17
 * Time: 下午4:38
 */

namespace App\Services;

use Auth;
use Route;
use Zhuzhichao\IpLocationZh\Ip;
use App\Repositories\RulesRepository;
use App\Repositories\ActionLogsRepository;

class ActionLogsService
{
    protected $rulesRepository;

    protected $actionLogsRepository;

    /**
     * ActionLogsService constructor.
     * @param $actionLogsRepository
     */
    public function __construct(RulesRepository $rulesRepository, ActionLogsRepository $actionLogsRepository)
    {
        $this->rulesRepository = $rulesRepository;

        $this->actionLogsRepository = $actionLogsRepository;
    }

    /**
     * 后台操作日志
     * @param $request
     * @return mixed
     */
    public function create($request)
    {
        $path = Route::currentRouteName();

        $rule = $this->rulesRepository->ByRoute($path);

        if(is_null($rule)) return false;

        //获取当前登录管理员信息
        $admin = Auth::guard('admin')->user();

        $address = Ip::find($request->getClientIp());

        $data = [
            'ip'=> $request->getClientIp(),
            'address'=> $address[0].$address[1].$address[2],
            'action'=> $action = $admin->name.' 操作了 '.$rule->name . ' 模块',
        ];

        $datas['admin_id'] = $admin->id;
        $datas['data'] = json_encode($data);

        return $this->actionLogsRepository->create($datas);
    }
}