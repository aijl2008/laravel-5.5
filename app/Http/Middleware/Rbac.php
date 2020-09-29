<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class Rbac
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->user()->hasPermission($request->getPathInfo())) {
            return $next($request);
        }
        Log::error('编号为' . $request->user()->getAuthIdentifier() . '的用户试图请求' . $request->url() . '被拒绝,当前用户的权限包括:' . json_encode($request->user()->permissions()));
        throw new AccessDeniedHttpException("您无权访问该资源");
    }
}
