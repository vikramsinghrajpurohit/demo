<?php

use Illuminate\Support\Facades\Route;

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

// ************************************ ADMIN SECTION **********************************************

Route::prefix('admin')->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\LoginController::class, 'showLoginForm'])->name('admin.login');
    Route::get('/login', [App\Http\Controllers\Admin\LoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [App\Http\Controllers\Admin\LoginController::class, 'login'])->name('admin.login.submit');
    Route::get('/logout', [App\Http\Controllers\Admin\LoginController::class, 'logout'])->name('admin.logout');

    Route::get('/admin-post', [App\Http\Controllers\Admin\PostController::class, 'index'])->name('admin-post');
    Route::get('/admin-post-edit/{id}', [App\Http\Controllers\Admin\PostController::class, 'edit'])->name('admin-post-edit');
    Route::get('/admin-post-delete/{id}', [App\Http\Controllers\Admin\PostController::class, 'delete'])->name('admin-post-delete');
    Route::post('/admin-post-update', [App\Http\Controllers\Admin\PostController::class, 'update'])->name('admin-post-update');

    Route::get('/admin-user', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('admin-user');
    Route::get('/admin-user-edit/{id}', [App\Http\Controllers\Admin\UserController::class, 'edit'])->name('admin-user-edit');
    Route::get('/admin-user-delete/{id}', [App\Http\Controllers\Admin\UserController::class, 'delete'])->name('admin-user-delete');
    Route::post('/admin-user-update', [App\Http\Controllers\Admin\UserController::class, 'update'])->name('admin-user-update');
});

// ******************************** END ADMIN SECTION ********************************************
// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/my-post', [App\Http\Controllers\PostController::class, 'index'])->name('my-post');
Route::get('/create-post', [App\Http\Controllers\PostController::class, 'create'])->name('create-post');
Route::get('/edit-post/{id}', [App\Http\Controllers\PostController::class, 'edit'])->name('my-post-edit');
Route::get('/delete-post/{id}', [App\Http\Controllers\PostController::class, 'delete'])->name('my-post-delete');
Route::get('/post-like/{id}', [App\Http\Controllers\PostController::class, 'like'])->name('post-like');
Route::get('/post-unlike/{id}', [App\Http\Controllers\PostController::class, 'unlike'])->name('post-unlike');
Route::get('/post-details/{id}', [App\Http\Controllers\HomeController::class, 'details'])->name('post-details');

Route::get('/create-post', [App\Http\Controllers\PostController::class, 'create'])->name('create-post');
Route::post('/save-post', [App\Http\Controllers\PostController::class, 'save'])->name('save-post');

Route::post('/review-save', [App\Http\Controllers\HomeController::class, 'reviewSave'])->name('review-save');
