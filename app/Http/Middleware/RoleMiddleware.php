<?php
namespace App\Http\Middleware;

use Closure;
use App\Role;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $roleEnum = Role::tryFrom($role);

        if (!$roleEnum || auth()->user()->role !== $roleEnum) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Forbidden - Insufficient permissions'], 403);
            }
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}

