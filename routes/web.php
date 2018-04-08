<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

// API users

// Путь для добовления нового пользователя
$router->post('api/users/add', 'UserController@postUserAdd');
// Путь для авторизации
$router->get('api/users/login', 'UserController@getLogin');

// API receipts

// Путь для добавления рецепта
$router->post('api/receipts/add', 'ReceiptController@postReceiptAdd');

// Путь для редактирования рецепта
$router->post('api/receipts/edit/{id}', 'ReceiptController@postReceiptEdit');

// Путь для удаления рецепта
$router->delete('api/receipts/remove/{id}', 'ReceiptController@deleteReceiptRemove');
