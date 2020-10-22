<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Preuser;


class CheckStatus
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
        $id = $request->id;
        $token = $request->token;
        $status = $request->status;
        $preuser = Preuser::where('id', $id)->where('token', $token)->where('status', $status);
        if (!$preuser->exists()) {
            return redirect('/');
        }

        return $next($request);
    }
}
