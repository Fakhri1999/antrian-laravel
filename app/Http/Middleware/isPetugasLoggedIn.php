<?php

namespace App\Http\Middleware;

use Closure;

class isPetugasLoggedIn
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
    if (session('petugas_username') == null) {
      return redirect('petugas/login');
    } else if (session('admin_username') != null) {
      return redirect('admin');
    }
    return $next($request);
  }
}
