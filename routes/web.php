<?php

use Illuminate\Support\Facades\Route;

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
Route::get('/',   'HomeController@checkLogin')->name('home');
Route::get('home','HomeController@checkLogin')->name('home');


Route::get('login',  'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout','Auth\LoginController@logout')->name('logout');
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');


Route::group(['middleware' => ['auth']], function() {
    
    /** AREA ADMINISTRATIVA */
    Route::group(['middleware' => ['administrativeArea']], function() {

        Route::group(['prefix' => 'admin'], function () {
            
            Route::group(['prefix' => 'home'], function () {
                Route::get('', ['as' => 'admin.home', 'uses' => 'HomeAdminController@index']);
               
            });

            /*
            * PEDIDO
            */
            Route::group(['prefix' => 'pedido'], function () {
                Route::get('',              ['as' => 'pedido', 'uses' => 'PedidoController@index']);
                Route::get('novo',          ['as' => 'pedido.novo', 'uses' => 'PedidoController@create']);
                Route::post('salvar',       ['as' => 'pedido.salvar', 'uses' => 'PedidoController@store']);
                Route::get('editar/{id}',   ['as' => 'pedido.editar', 'uses' => 'PedidoController@edit']);
                Route::post('alterar',      ['as' => 'pedido.alterar', 'uses' => 'PedidoController@update']);
                Route::post('cancelar',     ['as' => 'pedido.cancelar', 'uses' => 'PedidoController@cancelar']);
            });
            

            //Permissão de administrador
            Route::group(['middleware' => ['controleGeral']], function() {
                /*
                * PERFIL
                */
                Route::group(['prefix' => 'perfil'], function () {
                    Route::get('',              ['as' => 'perfil', 'uses' => 'PerfilController@index']);
                    Route::get('novo',          ['as' => 'perfil.novo', 'uses' => 'PerfilController@create']);
                    Route::post('salvar',       ['as' => 'perfil.salvar', 'uses' => 'PerfilController@store']);
                    Route::get('editar/{id}',   ['as' => 'perfil.editar', 'uses' => 'PerfilController@edit']);
                    Route::post('alterar/{id}', ['as' => 'perfil.alterar', 'uses' => 'PerfilController@update']);
                    Route::post('ativar_inativar',     ['as' => 'perfil.ativar_inativar', 'uses' => 'PerfilController@ativarInativar']);
                });


                /*
                * GRUPOS USUARIO
                */
                Route::group(['prefix' => 'grupo'], function () {
                    Route::get('',                          ['as' => 'grupo',                       'uses' => 'GrupoController@index']);
                    Route::get('novo',                      ['as' => 'grupo.novo',                  'uses' => 'GrupoController@create']);
                    Route::post('salvar',                   ['as' => 'grupo.salvar',                'uses' => 'GrupoController@store']);
                    Route::get('editar/{id}',               ['as' => 'grupo.editar',                'uses' => 'GrupoController@edit']);
                    Route::post('alterar',                  ['as' => 'grupo.alterar',               'uses' => 'GrupoController@update']);
                    Route::post('ativar_inativar',	        ['as' => 'grupo.ativar_inativar',       'uses' => 'GrupoController@ativarInativar']);
                });


                /*
                * USUÁRIO
                */
                Route::group(['prefix' => 'usuario'], function () {
                    Route::get('',                  ['as' => 'usuario',                 'uses'  => 'UsuarioController@index']);
                    Route::get('novo',              ['as' => 'usuario.novo',            'uses'  => 'UsuarioController@create']);
                    Route::post('salvar',           ['as' => 'usuario.salvar',          'uses'  => 'UsuarioController@store']);
                    Route::get('editar/{id}',       ['as' => 'usuario.editar',          'uses'  => 'UsuarioController@edit']);
                    Route::post('alterar',          ['as' => 'usuario.alterar',         'uses'  => 'UsuarioController@update']);
                    Route::post('ativar_inativar',  ['as' => 'usuario.ativar_inativar', 'uses' => 'UsuarioController@ativar_inativar']);
                });

                /*
                * EMPRESAS
                */
                Route::group(['prefix' => 'empresa'], function () {
                    Route::get('',                          ['as' => 'empresa',                     'uses' => 'EmpresaController@index']);
                    Route::get('nova',                      ['as' => 'empresa.nova',                'uses' => 'EmpresaController@create']);
                    Route::post('salvar',                   ['as' => 'empresa.salvar',              'uses' => 'EmpresaController@store']);
                    Route::get('editar/{id}',               ['as' => 'empresa.editar',              'uses' => 'EmpresaController@edit']);
                    Route::post('alterar',                  ['as' => 'empresa.alterar',             'uses' => 'EmpresaController@update']);
                    Route::post('ativar_inativar',          ['as' => 'empresa.ativar_inativar',     'uses' => 'EmpresaController@ativar_inativar']);
                });

                /*
                * Cidade
                */
                Route::group(['prefix' => 'cidade'], function () {
                    Route::get('',              ['as' => 'cidade', 'uses' => 'CidadeController@index']);
                    Route::get('novo',          ['as' => 'cidade.novo', 'uses' => 'CidadeController@create']);
                    Route::post('salvar',       ['as' => 'cidade.salvar', 'uses' => 'CidadeController@store']);
                    Route::get('editar/{id}',   ['as' => 'cidade.editar', 'uses' => 'CidadeController@edit']);
                    Route::post('alterar',      ['as' => 'cidade.alterar', 'uses' => 'CidadeController@update']);
                    Route::post('inativar',     ['as' => 'cidade.inativar', 'uses' => 'CidadeController@inativar']);
                });


                /*
                * Tipo Pedido
                */
                Route::group(['prefix' => 'tipoPedido'], function () {
                    Route::get('',                     ['as' => 'tipoPedido', 'uses' => 'TipoPedidoController@index']);
                    Route::get('novo',                 ['as' => 'tipoPedido.novo', 'uses' => 'TipoPedidoController@create']);
                    Route::post('salvar',              ['as' => 'tipoPedido.salvar', 'uses' => 'TipoPedidoController@store']);
                    Route::get('editar/{id}',          ['as' => 'tipoPedido.editar', 'uses' => 'TipoPedidoController@edit']);
                    Route::post('alterar',             ['as' => 'tipoPedido.alterar', 'uses' => 'TipoPedidoController@update']);
                    Route::post('ativar_inativar',     ['as' => 'tipoPedido.ativar_inativar', 'uses' => 'TipoPedidoController@ativar_inativar']);
                });


                /*
                * Status Pedido
                */
                Route::group(['prefix' => 'statusPedido'], function () {
                    Route::get('',              ['as' => 'statusPedido', 'uses' => 'StatusPedidoController@index']);
                    Route::get('novo',          ['as' => 'statusPedido.novo', 'uses' => 'StatusPedidoController@create']);
                    Route::post('salvar',       ['as' => 'statusPedido.salvar', 'uses' => 'StatusPedidoController@store']);
                    Route::get('editar/{id}',   ['as' => 'statusPedido.editar', 'uses' => 'StatusPedidoController@edit']);
                    Route::post('alterar',      ['as' => 'statusPedido.alterar', 'uses' => 'StatusPedidoController@update']);
                    Route::post('ativar_inativar',['as' => 'statusPedido.ativar_inativar', 'uses' => 'StatusPedidoController@ativar_inativar']);
                });

                /*
                * Grupo Produto
                */
                Route::group(['prefix' => 'grupoProduto'], function () {
                    Route::get('',              ['as' => 'grupoProduto', 'uses' => 'GrupoProdutoController@index']);
                    Route::get('novo',          ['as' => 'grupoProduto.novo', 'uses' => 'GrupoProdutoController@create']);
                    Route::post('salvar',       ['as' => 'grupoProduto.salvar', 'uses' => 'GrupoProdutoController@store']);
                    Route::get('editar/{id}',   ['as' => 'grupoProduto.editar', 'uses' => 'GrupoProdutoController@edit']);
                    Route::post('alterar',      ['as' => 'grupoProduto.alterar', 'uses' => 'GrupoProdutoController@update']);
                    Route::post('ativar_inativar',['as' => 'grupoProduto.ativar_inativar', 'uses' => 'GrupoProdutoController@ativar_inativar']);
                });

                /*
                * Produto
                */
                Route::group(['prefix' => 'produto'], function () {
                    Route::get('',              ['as' => 'produto', 'uses' => 'ProdutoController@index']);
                    Route::get('novo',          ['as' => 'produto.novo', 'uses' => 'ProdutoController@create']);
                    Route::post('salvar',       ['as' => 'produto.salvar', 'uses' => 'ProdutoController@store']);
                    Route::get('editar/{id}',   ['as' => 'produto.editar', 'uses' => 'ProdutoController@edit']);
                    Route::post('alterar',      ['as' => 'produto.alterar', 'uses' => 'ProdutoController@update']);
                    Route::post('ativar_inativar',     ['as' => 'produto.ativar_inativar', 'uses' => 'ProdutoController@ativar_inativar']);
                });

                /*
                * CONFIGURACAO
                */
                Route::group(['prefix' => 'configuracao'], function () {
                    Route::get('',                  ['as' => 'configuracao',                 'uses'  => 'ConfiguracaoController@index']);
                    Route::post('alterar',          ['as' => 'configuracao.alterar',         'uses'  => 'ConfiguracaoController@update']);
                    Route::post('importar',         ['as' => 'configuracao.importar',        'uses'  => 'ConfiguracaoController@import']);
                });
            });    


        });
    });

    /** AREA ECOMMERCE */
    Route::group(['middleware' => ['ecommerceArea']], function() {

        Route::group(['prefix' => 'ecommerce'], function () {

            Route::group(['prefix' => 'home'], function () {
                Route::get('', ['as' => 'ecommerce.home', 'uses' => 'HomeEcommerceController@index']);
               
            });

            Route::group(['prefix' => 'produto'], function () {
                Route::get('', ['as' => 'ecommerce.produto', 'uses' => 'ProdutoEcommerceController@index']);
                Route::get('detalhe/{id}',   ['as' => 'ecommerce.produto.detalhe', 'uses' => 'ProdutoEcommerceController@detalhe']);
                
            });

           
            Route::group(['prefix' => 'carrinho'], function () {
                Route::get('', ['as' => 'ecommerce.carrinho', 'uses' => 'CarrinhoEcommerceController@index']);
               
            });

            Route::group(['prefix' => 'checkout'], function () {
                Route::get('', ['as' => 'ecommerce.checkout', 'uses' => 'CheckoutEcommerceController@index']);
               
            });

        });
    });


});

