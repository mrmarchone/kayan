<?php
/*
 * Kayan Routes
 */

use Mrmarchone\Kayan\app\Http\Controllers\PagesController;

Route::group(['prefix' => config('kayan.routes.prefix')], function () {
    Route::get('/', function () {
        return view('kayan::index');
    });
    Route::resource('/pages', PagesController::class);
});
