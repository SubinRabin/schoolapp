<?php
namespace App\Http\Middleware;
use Closure;
use Session;
class localization
{
  /**
  * Handle an incoming request.
  *
  * @param \Illuminate\Http\Request $request
  * @param \Closure $next
  * @return mixed
  */
  public function handle($request, Closure $next)
  {
     // Check header request and determine localizaton

      if (Session::get('languageval') == "ar") {
        app()->setLocale("ar");
      } else {
      	Session::put('languageval','en');
        app()->setLocale("en");
      }

     // $local = ($request->hasHeader('X-localization')) ? $request->header('X-localization') : 'en';
     // // set laravel localization
     // app()->setLocale($local);
    // continue request
    return $next($request);
  }
}