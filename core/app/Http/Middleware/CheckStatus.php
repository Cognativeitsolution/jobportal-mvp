<?php

namespace App\Http\Middleware;

use Closure;

class CheckStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = 'user')
    {
        $authCheck = $guard != 'user' ?  auth()->guard($guard)->check() : auth()->check();
        if ($authCheck) {
            $user = $guard != 'user' ?  auth()->guard($guard)->user() : auth()->user();

            if ($user->status  && $user->ev  && $user->sv  && $user->tv) {
                return $next($request);
            } else {
                if ($request->is('api/*')) {
                    $notify[] = 'You need to verify your account first.';
                    return response()->json([
                        'remark' => 'unverified',
                        'status' => 'error',
                        'message' => ['error' => $notify],
                        'data' => [
                            'user' => $user
                        ],
                    ]);
                } else {
                    return to_route("$guard.authorization");
                }
            }
        }
        abort(403);
    }
}
