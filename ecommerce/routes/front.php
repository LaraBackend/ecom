<?php

Route::get('/','frontend\HomeController@index');
Route::get('/','frontend\HomeController@allProduct');
Route::get('/','frontend\HomeController@allCategories');
Route::get('/product','frontend\ProductController@show');
Route::get('/product/{id}','frontend\ProductController@showSingel');

