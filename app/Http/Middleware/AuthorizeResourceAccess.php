<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AuthorizeResourceAccess
{
    public function handle($request, Closure $next, $resource_id)
    {
        $user = Auth::user();
        if ($user->role !== 'admin' && $user->id != $request->route($resource_id)) {
            return response()->json([
                'error' => true,
                'message' => 'Forbidden',
            ], 403);
        }

        return $next($request);
    }
}
