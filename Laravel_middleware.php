<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAge {
    public function handle(Request $request, Closure $next) {
        if ($request->input('age') < 18) {
            return redirect('home');
        }
        
        return $next($request);
    }
}

// With parameters
class SetLocale {
    public function handle(Request $request, Closure $next, string $locale) {
        app()->setLocale($locale);
        return $next($request);
    }
}

// Register in Kernel.php
protected $routeMiddleware = [
    'auth' => \App\Http\Middleware\Authenticate::class,
    'age' => \App\Http\Middleware\CheckAge::class,
];

// Using in routes
Route::get('/admin', function() {
    // ...
})->middleware(['auth', 'age:18']);