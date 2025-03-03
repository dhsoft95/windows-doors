<?php
// routes/web.php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Home
Route::get('/', [SiteController::class, 'home'])->name('home');

// About
Route::get('/about', [SiteController::class, 'about'])->name('about');

// Products
Route::prefix('products')->group(function () {
    Route::get('/security-doors', [SiteController::class, 'securityDoors'])->name('products.security-doors');
    Route::get('/interior-doors', [SiteController::class, 'interiorDoors'])->name('products.interior-doors');
    Route::get('/aluminum-solutions', [SiteController::class, 'aluminumSolutions'])->name('products.aluminum-solutions');
});

// Articles
Route::prefix('articles')->group(function () {
    Route::get('/blog', [SiteController::class, 'blog'])->name('articles.blog');
    Route::get('/news', [SiteController::class, 'news'])->name('articles.news');
    Route::get('/guides', [SiteController::class, 'guides'])->name('articles.guides');
});

// Catalogue
Route::get('/catalogue', [SiteController::class, 'catalogue'])->name('catalogue');

// Support
Route::get('/support', [SiteController::class, 'support'])->name('support');

// Careers
Route::get('/careers', [SiteController::class, 'careers'])->name('careers');

// Showroom
Route::get('/showroom', [SiteController::class, 'showroom'])->name('showroom');

// Contact
Route::get('/contact', [SiteController::class, 'contact'])->name('contact');
Route::post('/contact', [SiteController::class, 'contactStore'])->name('contact.store');

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');

Route::group(['prefix' => 'blog'], function () {
    Route::get('/', [App\Http\Controllers\ArticleController::class, 'index'])->name('articles.index');
    Route::get('/article/{slug}', [App\Http\Controllers\ArticleController::class, 'show'])->name('articles.show');
    Route::get('/category/{slug}', [App\Http\Controllers\ArticleController::class, 'byCategory'])->name('articles.by-category');
    Route::get('/tag/{slug}', [App\Http\Controllers\ArticleController::class, 'byTag'])->name('articles.by-tag');
    Route::get('/author/{slug}', [App\Http\Controllers\ArticleController::class, 'byAuthor'])->name('articles.by-author');
});

Route::get('/products/featured', [ProductController::class, 'featured'])->name('products.featured');
