<?php

namespace App\Http\Middleware;

use Closure;

class Cors
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
    // $origin = $_SERVER['HTTP_ORIGIN'];
    // echo $origin;
    // $allowed_domains = [
    //   'http://mysite1.com',
    //   'https://www.mysite2.com',
    //   'http://www.mysite2.com',
    // ];

    return $next($request)->header('Access-Control-Allow-Origin', 'https://mysite1.com');
    // ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
  }
}
