<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class accountant
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
        $check = 0;
        foreach(Auth::user()->permission as $permission){
            if($permission->slug_name == 'xem-danh-sach-cong-tac-vien'){
                $check = 1;
                return $next($request);
            }
        }
        if($check == 0){
            echo "<script>alert('Bạn không có quyền thực hiện hành động này');history.back();</script>";
        }
    }
}
