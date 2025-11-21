<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect() -> route('products.index');
});

Route::resource('products', \App\Http\Controllers\ProductController::class);
