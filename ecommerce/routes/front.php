<?php

Route::get('/','frontend\HomeController@index');
Route::get('/product','frontend\ProductController@show');
Route::get('/product/{id}','frontend\ProductController@showSingel');

Route::get('category','frontend\CategoryController@show');