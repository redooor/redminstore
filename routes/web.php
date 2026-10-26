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

    // Pages at the root ("/about"). A fallback route only runs when nothing else matched, so it
    // can never shadow the host app's routes, whatever order they were registered in.
    if (config('redminstore.pages_at_root')) {
        Route::fallback([StorefrontController::class, 'rootPage'])->name('redminstore.pages.root');
    }
});
