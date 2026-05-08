<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureSeller
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || !Auth::user()->isSeller()) {
            abort(403, 'Halaman ini hanya untuk seller.');
        }

        return $next($request);
    }
}