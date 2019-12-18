<?php

/**Criado com o comando php artisan make:controller SingleAction --invokable */

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SingleActionController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        return "controller de ação única";
    }
}
