<?php
namespace App\Http\Middleware;

use Closure;
use Lcobucci\JWT\ValidationData;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use App\Http\Helpers\AjaxHelper;
use Illuminate\Support\Facades\Log;

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
                abort(403);
            }
        } else {
            if (!AjaxHelper::validateJWT($bearerToken, 'api')) {
                abort(403);
            }
        }

        $response = $next($request);

        return AjaxHelper::formatAjaxResponse($response);
    }
}
