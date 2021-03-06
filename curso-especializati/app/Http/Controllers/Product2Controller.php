<?php

/**
 * AULA 19 - Controllers Resources no Laravel 6.x 
 * Criado com o comando 
 * php artisan make:controller NomeController --resource
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class product2Controller extends Controller
{
    protected $request;

    /**AULA 20 - Injeção de Dependências no Laravel 6.x
     * O atributo do construtor $request é UMA INJEÇÃO DE DEPENDÊNCIA
     * ou seja, é o mesmo que fazer $request = new Request;
     */
    public function __construct(Request $request)
    {
        //Objeto do tipo Request que possui atributos da requisição
        $this->request = $request;

        /**AULA 21 - Middlewares em Controllers no Laravel 6.x */

        /** aplicando middleware AUTH apenas nas funções definidas no array dentro de ONLY
         * neste caso seriam as funções CREATE e SHOW*/
        $this->middleware(['auth'])->only(['create', 'show', 'store']);

        /* middleware de autenticação sendo aplicados em todas as funções deste controller, Product3Controller
         * Exceto na função index */
        $this->middleware(['auth'])->except(['index']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return "listagem de produtos";
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return "retorna formulário para criar";
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
