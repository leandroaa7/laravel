<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/* Para utilizar as rotas não precisa importar nada
 * porém estou importando apenas para a IDE não acusar algum erro 
 * para endender melhor procure sobre PSR e autoload
 * */

/**Importação errada das rotas
 * use Illuminate\Routing\Route;
 */

/**importação correta */

use Illuminate\Support\Facades\Route;

/** Referência do conteúdo está 
 * no curso https://www.youtube.com/playlist?list=PLVSNL1PHDWvQBtcH_4VR82Dg-aFiVOZBY)
 * e no link https://laravel.com/docs/master/routing */

Route::get('/', function () {
    return view('welcome');
});

Route::get("/teste", function () {
    return "rota teste";
});

Route::get('/view-teste', function () {
    return view("teste");
});

Route::get('/empresa', function () {
    return view('site.contact');
});

Route::get('/contato', function () {
    return 'contato';
});

/**
 * Rota do tipo POST
 */
Route::post("/register", function () {
    return '';
});

/** Rota do tipo ANY, ela recebe todos os tipos de requisições HTTP e trata da mesma forma */
Route::any('/any', function () {
    return 'any';
});

/** Rota do tipo MATCH, similar a rota do tipo any, porém é necessário definir quais métodos HTTP são permitidos */
Route::match(['post', 'put', 'get'], '/match', function () {
    return 'match';
});

/**AULA 11 - Rotas com parâmetros no Laravel*/

/**Rota do tipo GET com um parámetro chamado flag
 * Para utilizar o valor do parámetro adicione um atributo a função de callback 
 * Caso seja apenas um atributo a variável não precisa ter o mesmo nome do parámetro */
Route::get('/categorias/{flag}', function ($prim) {
    return "Produtos da categoria: {$prim}";
});

Route::get('/categoria/{flag}/posts', function ($flag) {
    return "Posts da categoria: {$flag}";
});

/**Parâmetros opcionais */
/** Rota do tipo GET com um parámetro chamado idProduct, o ? indica que é um parámetro opcional
 * é preciso definir o valor padrão no callback
 */
Route::get('/produtos/{idProduct?}', function ($idProduct = "valor default") {
    return "produto(s) {$idProduct}";
});

/** AULA 12 - Rotas no Laravel - redirect e view */
/**Para redirecionar para uma rota utilize um HELPER do laravel chamado REDIRECT
 * HELPERS são funções que estão disponíveis em todo o código
 * https://laravel.com/docs/master/helpers*/

/** REDIRECT */
Route::get('/redirect1', function () {
    return redirect('/redirect2');
});

Route::get('/redirect2', function () {
    return 'redirect2';
});

/** Rota /redirect3 que redireciona para /redirect2 */
Route::redirect('/redirect3', '/redirect2');

/** VIEW */
/**Rota /view que não possui lógica, ela apenas renderiza a página view */
Route::view('/view', 'welcome');

/**Rota view que renderiza página que está na pasta site no diretório /resources/views/site/ */
Route::view('/view/contact', 'site.contact');

/** Rota view com o parámetro ID com valor padrão de teste  */
Route::view('/view/contact/id', 'site.contact', ['id' => 'teste']);

/** AULA 13 - Rotas nomeadas no Laravel */
/**Rota com nome url.name */
Route::get('/nome-url', function () {
    return 'hey hey hey';
})->name('url.name');

/** rota que redireciona pelo nome da rota */
Route::get('/redirect4', function () {
    return  redirect()->route('url.name');
});

/** AULA 14 - Grupo de Rotas no Laravel */

/** Rota autenticada  */
/** rota que utiliza o middleware auth, quem acessar /auth deve estar autenticado
 * caso contrário será redirecionado para o /login  
 * está rota retornará um erro enquanto não existir a rota COM O NOME login
 */
Route::get('/auth', function () {
    return 'rota autenticada';
})->middleware(['auth']);

Route::get('/login', function () {
    return 'login';
})->name('login');

/**Grupo de rotas */

/**GRUPO DE ROTAS 1 - Define individualmente MIDDLEWARE, PREFIX, NAMESPACE E NAME */

/**Rota MIDDLEWARE com um grupo de rotas, em todas as rotas que estão dentro do grupo abaixo será aplicado o middleware ou o conjunto de middlewares  */
Route::middleware([])->group(function () {

    /**Rota PREFIX com um grupo de rotas, em todas as rotas que estão dentro do grupo abaixo será aplicado o prefixo /admin
     * ou seja
     * para acessar a /dashboard será necessário acessar a url /admin/dashboard
     */
    Route::prefix('admin')->group(function () {

        /**Rota NAMESPACE com um grupo de rotas, 
         * todos os controllers utilizados nas funções deste grupo estão em uma pasta com o nome definido pelo namespace
         * Neste caso é o Admin, então ao invés de definir o controller de uma rota com Admin\TesteController@teste basta adicionar o TesteController*/
        Route::namespace('Admin')->group(function () {

            /**Rota NAME com um grupo de rotas
             * todas as rotas podem possuir um nome, o NAME define um prefixo antes do nome
             * neste caso seria admin, Route::name('admin.') . 
             * logo qualquer nome de rota como por exemplo, Route::get('/', 'TesteController@teste')->name('home'); poderá ser acessado por admin.home
             */
            Route::name('admin.')->group(function () {
                Route::get('/', 'TesteController@teste')->name('home');
                Route::get('/dashboard', 'TesteController@teste');
                Route::get('/financeiro', 'TesteController@teste');
                Route::get('/produtos', 'TesteController@teste');
                Route::get('/redirect', function () {
                    return redirect()->route('admin.home');
                });
            });
        });

        /* Rota utilizando um controller
         * Ficar atento com a pasta onde o diretório está, se está em um pasta, exemplo Admin, deve colocar antes do controler o Admin\
         * Controller criado no diretório app/Http/Controllers/Admin
         * Para criar o controller foi utilizado o comando php artisan make:controller Admin/TesteControlle
         */
        Route::get('/teste', 'Admin\TesteController@teste');
        /**
         * não é recomendado retornar uma função de callback
         * defina as lógicas nos controllers 
         * diretório /app/Http/Controllers/NomeController
         * Route::get('user', 'NomeController@nomeMetodo');
         * Se houver algum sub diretório adicionar antes do controler ou um grupo de rotas
         * Exemplo de rota com sub diretório Route::get('user', 'NomeDoDiretorioCasoExista\NomeController@nomeMetodo');
         */
    });
});

/**GRUPO DE ROTAS 2 - Parâmetros middleware,prefix,name e namespace são definidos em um Route::group apenas 
 * para definir o name é necessário utilizar a chave AS dentro do array do group
 */
Route::group([
    'middleware' => [],
    'prefix' => 'admin2',
    'namespace' => 'Admin',
    'as' => 'admin.'
], function () {
    Route::get('/', 'TesteController@teste')->name('home');
    Route::get('/dashboard', 'TesteController@teste');
    Route::get('/financeiro', 'TesteController@teste');
    Route::get('/produtos', 'TesteController@teste');
    Route::get('/redirect', function () {
        return redirect()->route('admin.home');
    });
});

/**Rota middleware com um grupo de rotas que utilizam o middleware AUTH */
Route::middleware(['auth'])->group(function () {
    Route::get('/secret/', function () {
        return 'secret admin';
    });
});

/**AULA 15 - Comandos do Artisan para Rotas no Laravel  */

/** php artisan route:list 
 * lista todos as rotas com detalhes
 */

/**AULA 16 - Introdução aos Controllers no Laravel 6.x */

Route::get('/products', 'ProductController@index')
    ->name('products.index');

/** AULA 17 - Controllers com Parâmetros de Rotas no Laravel 6.x */
Route::get('/products/{id}/', 'ProductController@show')
    ->name('products.show');

/** AULA 18 - Controllers de CRUD no Laravel 6.x */

/**Rota para exibir formulário de cadastro de produto */
Route::get('/products/create', 'ProductController@create')
    ->name('products.create');
/**Rota para exibir formulário de edição de produto */
Route::get('/products/{id}/edit/', 'ProductController@edit')
    ->name('products.edit');
/**Rota para cadastrar um novo produto */
Route::post('/products', 'ProductController@store')
    ->name('products.store');
/**Rota para editar produto */
Route::put('/products/{id}/', 'ProductController@update')
    ->name('products.update');

/**Rota para editar produto */
Route::delete('/products/{id}/', 'ProductController@destroy')
    ->name('products.destroy');

/** Refatorando Rotas dos produtos */
Route::group([
    'middleware' => [],
    'prefix' => 'products2',
    'as' => 'product.'
], function () {
    /**Defina primeiro as rotas "fixas", como por exemplo /create, antes de rotas que usam id
     * pois elas podem sobrescrever
     * tente inverter as rotas, a /create é acessada pelo /{id}
     */
    Route::get('/', 'ProductController@index')->name('index');
    Route::get('/create', 'ProductController@create')->name('create');
    Route::get('/{id}', 'ProductController@show')->name('show');
    Route::get('/{id}/edit', 'ProductController@edit')->name('edit');
    Route::post('/', 'ProductController@store')->name('store');
    Route::put('/{id}/', 'ProductController@update')->name('update');
    Route::delete('/{id}/', 'ProductController@destroy')->name('destroy');
});


/** AULA 19 - Controllers Resources no Laravel 6.x 
 *Resources cria todas as rotas para o seu controler
 * sejam elas index,create,show,edit,store,update e destroy
 * para criar o controller com todos os métodos basta digitar o comando abaixo
 * php artisan make:controller NomeController --resource
 */
Route::resource('products3', 'Product2Controller');

/**exemplo de resources utilizando group com middleware de autenticação */
Route::group(["middleware" => ["auth"]], function () {
    Route::resource('products4', 'Product2Controller');
});
