<?php

/*
|--------------------------------------------------------------------------
| Package Routes
|--------------------------------------------------------------------------
*/

Route::group(['namespace' => 'Redooor\Redminstore\App\Http\Controllers'], function () {
    Route::get('/', 'PageController@showHome');
    Route::get('page', 'PageController@show404');
    Route::get('page/{slug}', 'PageController@loadPage');
    Route::get('post', 'PostController@show404');
    Route::get('post/{slug}', 'PostController@loadPost');
});
