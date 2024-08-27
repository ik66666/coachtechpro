<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SellController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\BuyController;
use App\Http\Controllers\Auth\AuthController;
//use App\Http\Controllers\RegisterController;

//Route::post('register',[RegisterController::class,'store']);

//Route::middleware('auth')->group(function ()

Route::get('/',[ItemController::class,'index'])->name('home.index');
Route::post('/',[ItemController::class,'search']);
Route::get('/detail/{item}', [ItemController::class,'itemDetail'])->name('item.detail');

Route::middleware('auth')->group(function (){
Route::get('/my-favorite',[ItemController::class,'myFavorite']);
Route::post('/favorite/{item}',[ItemController::class,'favorite']);
Route::delete('/favorite/{item}',[ItemController::class,'destroy']);
});

Route::middleware('auth')->group(function (){
Route::prefix('mypage')->group(function() {
Route::get('/',[ProfileController::class,'mypage'])->name('mypage.home');
Route::get('/buy',[ProfileController::class,'myBuyItem']);
Route::get('/profile',[ProfileController::class,'profile']);
Route::post('/edit-profile',[ProfileController::class,'editProfile']);
});
});

Route::middleware('auth')->group(function (){
Route::prefix('sell')->group(function() {
    Route::get('/',[SellController::class,'showSell'])->name('sell');
    Route::post('/',[SellController::class,'sellItem']);
});
});

Route::get('/comment/{item}',[CommentController::class,'showComment'])->name('item.comment');
Route::middleware('auth')->group(function (){
Route::post('/comment/{item}',[CommentController::class,'postComment']);
});

Route::middleware('auth')->group(function (){
Route::prefix('perchase')->group(function() {
Route::get('/{item}',[BuyController::class,'showBuy'])->name('buy.item');
Route::get('/buy/{item}',[BuyController::class,'buyItem'])->name('bought.item');
});
Route::get('/address',[BuyController::class,'editAddress']);
Route::post('/address',[BuyController::class,'addAddress']);
Route::get('/change/{item}',[BuyController::class,'showPaymethod']);
Route::post('/change/method/{item}',[BuyController::class,'changePaymethod']);
Route::post('/charge',[Buycontroller::class, 'charge'])->name('cart.checkout');
});




Route::group(['middleware' => ['guest:admin']], function () {
Route::get('admin/login_form', [AuthController::class, 'showLogin'])->name('admin.showLogin');
Route::post('admin/login_form', [AuthController::class, 'login'])->name('admin.login');
});
Route::group(['middleware' => ['auth:admin']], function () {
    Route::get('admin', [AuthController::class, 'index'])->name('admin.index');
    Route::get('admin/logout', [AuthController::class, 'logout'])->name('admin.logout');
    Route::get('admin/{user}',[AuthController::class, 'showComment']);
    Route::delete('admin/delete/{user}',[AuthController::class, 'deleteUser']);
    Route::delete('comment/delete/{comment}',[AuthController::class, 'deleteComment']);
    Route::post('email/{user}',[AuthController::class,'sendEmail']);
});