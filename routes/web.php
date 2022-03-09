<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ListController;

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/list', [ListController::class, 'index'])->name('show.expenses');
Route::post('/add-product', [ListController::class, 'store'])->name('add.expense');
Route::post('/delete-product', [ListController::class, 'delete'])->name('delete.expense');
Route::post('/fill-form', [ListController::class, 'fillForm'])->name('fill.form');
Route::post('/edit-expense', [ListController::class, 'edit'])->name('edit.expense');

