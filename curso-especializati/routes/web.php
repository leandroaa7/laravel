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

 /* Rota inicial que usa o metódo estático get da classe Route cujos atributos são 
  * A string da rota e uma função de callback
  * Neste caso a função de callback retorna a função view que é responsável por renderizar uma página
  * As páginas ficam no diretório /resources/views/
  */
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

/** Controllers **
 * Responsáveis pelas lógicas aplicadas ao sistema
 * Ficam em app/Http/Controllers
 * Para criar um controller que possui apenas UMA AÇÃO digite o comando - php artisan make:controller NomeDoControllerDesejadoController --invokable -
 * invokable define a função com nome __invoke que será "invocada" quando o controller for "chamado"
 * 
 * Para criar um controller com TODAS AS FUNÇÕES DE CRUD basta - php artisan make:controller NomeDoControllerDesejadoController --resource
 * resource são utilizados em rotas, Route::resource, ele define todas as rotas para o seu CRUD
 * 
 * Controllers ANINHADOS(Nested)
 * Imagine que você tem as rotas de cidades e de países e gostaría de visualizar 
 * cidades por país /pais/cidades
 * Essa mistura de rotas é UM NESTED
 * A sintaxe para aninhar rotas é unir rotas com ponto
 * exemplo da sintaxe /pais.cidade 
 * exemplo do código Route::resource('paises.cidades', 'CidadesController'); 
 * Os exemplos acima indicam que todas as URLs possuem o prefixo /paises/[pais_id]/ e o pais_id
 * deve ser parámetros de todas as funções de CidadesControllers
 * logo a função index, show deve ser index($pais_id), show($pais_id, City $cidade_id)
 * você pode ver mais detalhes em https://laraveldaily.com/nested-resource-controllers-and-routes-laravel-crud-example/
 * 
 * Defina o nome dos controllers com primeira letra Maiúscula e com o nome, por convenção,  Controller após o nome desejado
 * DOCUMENTAÇÃO https://laravel.com/docs/6.x/controllers
 */

 
 /**Exemplo de controller que possui apenas uma ação */
 Route::get('/single','SingleActionController');

 /**Exemplo de resource que utiliza apenas as rotas desejadas
  * tente digitar /products5/show
  */
 Route::resource('products5', 'Product2Controller')->only([
     'index'
 ]);

  /**Exemplo de resource que utiliza todas as rotas exceto index  */
 Route::resource('products6', 'Product2Controller')->except([
    'index'
]);

/**Exemplo de Nested Resource */
Route::resource('countries.cities', 'CitiesController');

/**AULA 20 e 21 estão no arquivo Product2Controller */

/** Middlewares **
 * Middlewares são filtros, ou funções intermediárias entre a requisição e a resposta do servidor
 * Um exemplo é um middleware de autenticação, quando o usuário faz uma requisição de uma página, a requisição "passa" por vários middlewares
 * Que vão passando por $next($request) no php
 * Quando chegar no middleware de autenticação ele vai verificar se o usuário tem permissão de acessar a página, caso ele tenha o middleware vai retornar a página
 * Caso contrário irá redirecionar para uma página específica
 * 
 * Os middlewares podem ser encontrados no diretório app/Http/Middleware
 * para criar um middleware basta utilizar o comando - php artisan make:middleware NomeDoMiddleware -
 * Para definir o seu middleware em TODAS as requisições basta adicionar o diretório do middleware em app/Http/Kernel.php no array $middleware 
 * Para definir o seu middleware nas rotas desejadas basta adicionar o diretório do middleware em app/Http/Kernel.php no array routeMiddleware
 * Existem outros tipos de middlewares basta verificar na documentação, link abaixo
 * 
 * Middlewares é um padrão, não confundir com o middleware https://pt.wikipedia.org/wiki/Middleware,
 * procure por middleware pattern (existe em ruby, node, laravel etc)
 * 
 * DOCUMENTAÇÃO https://laravel.com/docs/6.x/middleware
 */

/**Exemplo de uso de middleware
 * a rota /age/{age} utiliza o middleware, definido em routeMiddleware no diretório app/Http/Kernel.php, checkAge para 
 * verificar se a idade é menor,
 * igual ou maior que 18 e trata conforme cada valor  */

Route::get('/age/maior', function () {
    return "maior de 18";
});
Route::get('/age/menor', function () {
    return "menor de 18";
});
Route::get('/age/igual', function () {
    return "igual de 18";
});

Route::get('/age/{age}')->middleware('checkAge');
