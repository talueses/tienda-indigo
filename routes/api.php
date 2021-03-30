<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/free_delivery_text', 'Admin\Dashboard\DashboardController@getFreeDeliveryText');

Route::post('/giftproduct/detail', 'GiftRegistryController@getDetailFromApi');
Route::post('/giftproduct/detail/update', 'GiftRegistryController@updateListFromApi');
Route::post('/giftproduct/detail/picture/update', 'GiftRegistryController@updateListPictureFromApi');
Route::post('/giftproduct/remove', 'GiftRegistryController@removeProductFromApi');
Route::post('/giftproduct/update', 'GiftRegistryController@updateProductFromApi');
Route::post('/giftproduct/list', 'GiftRegistryController@getProductsFromApi');

Route::post('/country/list', 'Admin\Departamentos\DepartamentosController@destroy');

Route::post('/department/list', 'Admin\Departamentos\DepartamentosController@getDepartmentsByCountry');
Route::post('/department/create', 'Admin\Departamentos\DepartamentosController@store');
Route::post('/department/update', 'Admin\Departamentos\DepartamentosController@update');
Route::post('/department/delete', 'Admin\Departamentos\DepartamentosController@destroy');

Route::post('/district/list', 'Admin\Distritos\DistritosController@getDistrtictByDepartment');
Route::post('/district/create', 'Admin\Distritos\DistritosController@store');
Route::post('/district/update', 'Admin\Distritos\DistritosController@update');
Route::post('/district/delete', 'Admin\Distritos\DistritosController@destroy');
Route::post('/district/isfreedelivery', 'Admin\Distritos\DistritosController@isFreeDelivery');

//Route::post('/pruebas', 'GiftRegistryController@updateListPictureFromApi');
