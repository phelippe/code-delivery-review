<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::group(['middleware'=> 'auth.checkrole:admin','prefix'=>'admin', 'as'=>'admin.'], function(){

    Route::group(['prefix'=>'categories', 'as'=>'categories.'], function(){
        Route::get('', ['as'=>'index', 'uses'=>'CategoriesController@index']);
        Route::get('create', ['as'=>'create', 'uses'=>'CategoriesController@create']);
        Route::post('store', ['as'=>'store', 'uses'=>'CategoriesController@store']);
        Route::get('edit/{id}', ['as'=>'edit', 'uses'=>'CategoriesController@edit']);
        Route::post('update/{id}', ['as'=>'update', 'uses'=>'CategoriesController@update']);
        Route::get('destroy/{id}', ['as'=>'destroy', 'uses'=>'CategoriesController@destroy']);
    });

    Route::group(['prefix'=>'products', 'as'=>'products.'], function(){
        Route::get('', ['as'=>'index', 'uses'=>'ProductsController@index']);
        Route::get('create', ['as'=>'create', 'uses'=>'ProductsController@create']);
        Route::post('store', ['as'=>'store', 'uses'=>'ProductsController@store']);
        Route::get('edit/{id}', ['as'=>'edit', 'uses'=>'ProductsController@edit']);
        Route::post('update/{id}', ['as'=>'update', 'uses'=>'ProductsController@update']);
        Route::get('destroy/{id}', ['as'=>'destroy', 'uses'=>'ProductsController@destroy']);
    });

    Route::group(['prefix'=>'clients', 'as'=>'clients.'], function(){
        Route::get('', ['as'=>'index', 'uses'=>'ClientsController@index']);
        Route::get('create', ['as'=>'create', 'uses'=>'ClientsController@create']);
        Route::post('store', ['as'=>'store', 'uses'=>'ClientsController@store']);
        Route::get('edit/{id}', ['as'=>'edit', 'uses'=>'ClientsController@edit']);
        Route::post('update/{id}', ['as'=>'update', 'uses'=>'ClientsController@update']);
        Route::get('destroy/{id}', ['as'=>'destroy', 'uses'=>'ClientsController@destroy']);
    });

    Route::group(['prefix'=>'orders', 'as'=>'orders.'], function(){
        Route::get('', ['as'=>'index', 'uses'=>'OrdersController@index']);
        Route::get('show/{id}', ['as'=>'show', 'uses'=>'OrdersController@show']);
        Route::get('edit/{id}', ['as'=>'edit', 'uses'=>'OrdersController@edit']);
        Route::post('update/{id}', ['as'=>'update', 'uses'=>'OrdersController@update']);
        /*Route::get('create', ['as'=>'create', 'uses'=>'ClientsController@create']);
        Route::post('store', ['as'=>'store', 'uses'=>'ClientsController@store']);

        Route::get('destroy/{id}', ['as'=>'destroy', 'uses'=>'ClientsController@destroy']);*/
    });

    Route::group(['prefix'=>'cupoms', 'as'=>'cupoms.'], function(){
        Route::get('create', ['as'=>'create', 'uses'=>'CupomsController@create']);
        Route::get('', ['as'=>'index', 'uses'=>'CupomsController@index']);
        Route::post('store', ['as'=>'store', 'uses'=>'CupomsController@store']);
    });

});

Route::group(['prefix'=>'customer', 'as'=>'customer.', 'middleware'=>'auth.checkrole:client'], function(){
    Route::group(['prefix'=>'order', 'as'=>'order.'], function(){
        Route::get('', ['as'=>'index', 'uses'=>'CheckoutController@index']);
        Route::get('create', ['as'=>'create', 'uses'=>'CheckoutController@create']);
        Route::post('store', ['as'=>'store', 'uses'=>'CheckoutController@store']);
    });
});

Route::group(['middleware'=>'cors'], function(){

    Route::post('oauth/access_token', function(){
        return Response::json(Authorizer::issueAccessToken());
    });
    /*Route::post('oauth/access_token/revoke', function(){
        return Response::json(Authorizer::issueAccessToken());
    });*/


    Route::group(['prefix'=>'api', 'middleware'=>'oauth', 'as'=>'api.'], function(){

        Route::get('authenticated', 'ClientsController@getAuthenticated');


        Route::group(['prefix'=>'client', 'as'=>'client.', 'middleware'=>'oauth.checkrole:client'], function(){

            Route::resource('order', 'Api\Client\ClientCheckoutController',
                ['except' => ['create', 'edit', 'destroy']]
            );
            Route::get('products', 'Api\Client\ClientProductController@index');
        });

        Route::group(['prefix'=>'deliveryman', 'as'=>'deliveryman.', 'middleware'=>'oauth.checkrole:deliveryman'], function(){
            Route::resource('order', 'Api\Deliveryman\DeliverymanCheckoutController',
                ['except' => ['create', 'edit', 'destroy', 'store']]
            );
            Route::patch('order/{id}/update-status', [
                'uses'=> 'Api\Deliveryman\DeliverymanCheckoutController@updateStatus',
                'as'=> 'order.update-status'
            ]);
            Route::post('order/{id}/geo', [
                'as'=>'orders.geo', 'uses'=>'Api\Deliveryman\DeliverymanCheckoutController@geo'
            ]);
        });

        Route::get('cupom/{code}', 'Api\CupomController@show');





        Route::get('pedidos', function(){
            return [
                'id' => 1,
                'client' => 'JOão usuário tete',
                'total' => 10.5
            ];
        });
    });
});