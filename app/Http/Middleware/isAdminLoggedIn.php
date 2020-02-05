<?php

namespace App\Http\Middleware;

use Closure;

class isAdminLoggedIn
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
    if (session('petugas_username') != null) {
      return redirect('petugas');
    }
    if (session('admin_username') == null) {
      return redirect('admin/login');
    }
    return $next($request);
  }
}
