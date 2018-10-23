<?php

namespace App\Http\Middleware;

use Session;
use Closure;
use App\Services\AdminService;

class PowerMiddleware
{
    /**
     * 检测用户是否登陆以及是否有访问管理权限
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $adminService = new AdminService;
        // 判断用户是否已经登陆

        if (!Session::get('userInfo')) {
            return redirect('/admin/login');
        }
        
        // // 判断是否为非法用户
        // if (!$adminService->getAdminAttr('admin_id')) {
        //     // 删除非法状态
        //     $adminService->delLoginStatus();
        //     return redirect('/admin/login');
        // }
        // $adminInfo = $adminService->getAdminStatus();
        // // 判断是否被冻结
        // if ($adminService->getAdminAttr('is_freeze') == 1) {
        //     // dump($adminService->getAdminAttr('is_freeze'));
        //     return redirect('/');
        // }

        // 判断是否为超级管理员
        $userInfo = Session::get('userInfo');
            if ($userInfo['is_super'] == 1) {
            return $next($request);
        }

        // 判断是否有路由访问权限
        if (!$adminService->power($request->path())) {
            return redirect('/home/index');
        }

        return $next($request);
    }
}
