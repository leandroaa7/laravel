<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    private $products = ['Product 01', 'Product 02', 'Product 03'];
    /**AULA 16 - Introdução aos Controllers no Laravel 6.x */

    /**para listagem é interessante utilizar o nome de INDEX */
    /**Listar produtos */
    public function index()
    {
        //return 'listagem de produtos ';        
        /**
         * o laravel retorna um json 
         * pois entende que é uma função de api
         */
        return $this->products;
    }

    /**AULA 17 - Controllers com Parâmetros de Rotas no Laravel 6.x */

    /**para listagem de um item específico é interessante utilizar o nome SHOW */
    /**Lista um produto específico pelo id/indice da lista de produtos*/
    public function show($id)
    {

        //verifica se existe elemento no índice indicado em $id
        if (array_key_exists($id, $this->products)) {
            //existe elemento
            return "exibindo produto do id {$id} " . $this->products[$id];
        } else {
            return "produto indisponível";
        }
        return "erro";
    }

    /** AULA 18 - Controllers de CRUD no Laravel 6.x */

    public function create()
    {
        return 'Exibindo o form de cadastro de um novo produto';
    }

    public function edit($id)
    {
        return "Form para editar o produto {$id}";
    }

    public function store()
    {
        return 'cadastrando um novo produto';
    }

    public function update($id)
    {
        return "editando produto {$id}";
    }
 
    public function destroy($id)
    {
        return "deletar produto {$id}";
    }
}
