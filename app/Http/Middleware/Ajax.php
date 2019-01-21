<?php
namespace App\Http\Middleware;

use Closure;
use App\Http\Helpers\AjaxHelper;

class Ajax
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (!$request->isXmlHttpRequest()) {
            abort(403);
        }

        $bearerToken = $request->bearerToken();

        if ($bearerToken == null) {
            abort(403);
        }

        if ($request->path() == 'api/token') { 
            if (!AjaxHelper::validateJWT($bearerToken, 'web')) {
                abort(401);
            }
        } else {
            if (!AjaxHelper::validateJWT($bearerToken, 'api')) {
                abort(401);
            }
        }

        $response = $next($request);

        return AjaxHelper::formatAjaxResponse($response);
    }
}
