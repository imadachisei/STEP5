<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;

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


//ユーザーログイン画面表示
Route::get('/login',[App\Http\Controllers\UserController::class, 'showLoginForm'])->name('LoginForm');
//ユーザーログイン画面からボタンを押した場合
Route::post('/login',[App\Http\Controllers\UserController::class, 'loginFormSubmitRequest'])->name('LoginFormSubmit');

//ユーザー新規登録画面表示
Route::get('/register',[App\Http\Controllers\UserController::class, 'showNewAccountForm'])->name('NewAccountForm');
//ユーザー新規登録画面からボタンを押した場合
Route::post('/register',[App\Http\Controllers\UserController::class, 'newAccountFormSubmitRequest'])->name('NewAccountFormSubmit');


//商品一覧画面を表示(認証ユーザーのみ)
Route::get('/productlist',[App\Http\Controllers\UserController::class, 'showProductlistForm'])->name('ProductlistForm')
->middleware('auth');
//商品一覧画面から検索ボタンを押した場合
Route::post('/productlistSearch',[App\Http\Controllers\UserController::class, 'productlistFormSearchSubmitRequest'])->name('ProductSearchSubmit');
//商品一覧画面から新規登録ボタンを押した場合
Route::post('/productlistregist',[App\Http\Controllers\UserController::class, 'productlistFormRegistSubmitRequest'])->name('ProductlistFormRegistSubmit');
//商品一覧画面から詳細ボタンを押した場合
Route::post('/productlistDetail{id}',[App\Http\Controllers\UserController::class, 'productlistFormDetailSubmitRequest'])->name('ProductlistFormDetailSubmit');
//商品一覧画面から削除ボタンを押した場合
Route::post('/productlistDelete{id}',[App\Http\Controllers\UserController::class, 'productlistFormDeleteSubmitRequest'])->name('ProductlistFormDeleteSubmit');


//商品新規登録画面を表示(認証ユーザーのみ)
Route::get('/newProduct',[App\Http\Controllers\UserController::class, 'showNewProductForm'])->name('NewProductForm')
->middleware('auth');
//商品新規登録画面からボタンを押した場合
Route::post('/newProduct',[App\Http\Controllers\UserController::class, 'productRegistSubmitRequest'])->name('ProductRegistSubmit');


//商品情報詳細画面を表示(認証ユーザーのみ)
Route::get('/productDetail{id}',[App\Http\Controllers\UserController::class, 'showProductDetailForm'])->name('ProductDetailForm')
->middleware('auth');
//商品情報詳細画面からボタンを押した場合
Route::post('/productDetailSubmit{id}',[App\Http\Controllers\UserController::class, 'productDetailSubmitRequest'])->name('ProductDetailSubmit');


//商品情報編集画面を表示(認証ユーザーのみ)
Route::get('/productEdit{id}',[App\Http\Controllers\UserController::class, 'showProductEditForm'])->name('ProductEditForm')
->middleware('auth');
//商品情報編集画面からボタンを押した場合
Route::post('/productEditSubmit{id}',[App\Http\Controllers\UserController::class, 'productEditSubmitRequest'])->name('ProductEditSubmit');
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

