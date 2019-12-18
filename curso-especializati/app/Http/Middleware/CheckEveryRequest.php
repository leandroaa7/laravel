<?php

/* Criado com o comando
 * php artisan make:middleware checkEveryRequest
 * Este middleware foi definido como global em $middleware no diretório /app/Http/Kernel.php */

namespace App\Http\Middleware;

use Closure;

class CheckEveryRequest
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
        return $next($request);
    }
}
