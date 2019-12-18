<?php

/**Criado com o comando
 * php artisan make:middleware CheckAge 
 * Este middleware foi definido em $middleware no diretório /app/Http/Kernel.php 
 * Para utilizar este middleware em uma rota basta adicionar ->middleware('checkAge');
 */

namespace App\Http\Middleware;

use Closure;

class CheckAge
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
        /**verifica se o parámetro AGE da url é menor ou maior o igual a 18*/
        if ($request->age < 18) {
            return redirect('/age/menor');
        } else if($request->age == 18) {
            return redirect('/age/menor');
        } else{
            return redirect('/age/maior');
        }
    }
}
