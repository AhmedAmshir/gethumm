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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('api_key')->group(function () {
    Route::post('/create-ingredient', ['as' => 'create_ingredient', 'uses' => 'HummController@createIngredient']);

    Route::get('/ingredients', ['as' => 'list_ingredients', 'uses' => 'HummController@listIngredients']);

    Route::post('/create-recipe', ['as' => 'create_recipe', 'uses' => 'HummController@createRecipe']);

    Route::get('/recipes', ['as' => 'list_recipes', 'uses' => 'HummController@listRecipes']);

    Route::post('/create-box-order', ['as' => 'create_order', 'uses' => 'HummController@createUserBoxOrder']);

    Route::get('/ingredient-required', ['as' => 'create_order', 'uses' => 'HummController@ingredientsRequiredToBeOrdered']);
});