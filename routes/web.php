<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CatalogController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('home');
});

Route::get('/login',[AuthController::class, 'show_login_form'])->name('login');
Route::post('/login',[AuthController::class, 'process_login'])->name('login');
Route::get('/register',[AuthController::class, 'show_signup_form'])->name('register');
Route::post('/register',[AuthController::class, 'process_signup']);
Route::post('/logout',[AuthController::class, 'logout'])->name('logout');

Route::any('/search', [CatalogController::class, 'search'])->name('home');
Route::post('/add-favorite', [CatalogController::class, 'add_favorite']);
Route::post('/remove-favorite', [CatalogController::class, 'remove_favorite']);
Route::get('/my-favorites', [CatalogController::class, 'my_favorites'])->name('my-favorites');
Route::post('/remove-favorite-repo', [CatalogController::class, 'remove_favorite_repo']);