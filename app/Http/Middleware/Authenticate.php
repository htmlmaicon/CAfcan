<?php
 

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            if ($request->is('admin/products*')) {
                return route('admin.login');
            }
            return route('cliente.login');
        }
    }
}