<?php

use Illuminate\Support\Facades\Route;
use Redooor\Redminstore\App\Http\Controllers\StorefrontController;

Route::middleware('web')->group(function () {
    Route::get('/', [StorefrontController::class, 'home'])->name('redminstore.home');

    Route::get('page', [StorefrontController::class, 'notFound'])->name('redminstore.pages.missing');
    Route::get('page/{slug}', [StorefrontController::class, 'page'])->name('redminstore.pages.show');
    Route::get('post', [StorefrontController::class, 'notFound'])->name('redminstore.posts.missing');
    Route::get('post/{slug}', [StorefrontController::class, 'post'])->name('redminstore.posts.show');

    Route::get('products', [StorefrontController::class, 'products'])->name('redminstore.products.index');
    Route::get('products/{product}', [StorefrontController::class, 'product'])->whereNumber('product')->name('redminstore.products.show');
    Route::get('categories/{category}', [StorefrontController::class, 'category'])->whereNumber('category')->name('redminstore.categories.show');
});
