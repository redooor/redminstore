<?php

/*
|--------------------------------------------------------------------------
| Package Routes
|--------------------------------------------------------------------------
*/

Route::group(['namespace' => 'Redooor\Redminstore\App\Http\Controllers'], function () {
    Route::controller('/', 'HomeController');
});
