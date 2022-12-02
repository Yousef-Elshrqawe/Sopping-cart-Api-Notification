<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;


Route::group(['prefix' => 'auth'], function () {
    Route::post('register',           [AuthController::class, 'register']);
    Route::post('login',              [AuthController::class, 'login'])->name('login');
    Route::get('logout',              [AuthController::class, 'logout'])->middleware('AssignGuard:api-auth');
});

Route::apiResource('products',         ProductController::class)->except(['update', 'store', 'destroy']);
Route::apiResource('orders',           OrderController::class)->except(['update', 'destroy','store'])->middleware('auth:api-auth');
Route::apiResource('carts',            CartController::class)->except(['update', 'index']);
Route::post('/carts/{cart}',          [CartController::class , 'addProducts']);
Route::post('/carts/{cart}/checkout', [CartController::class , 'checkout']);

Route::post('send/all/mail',                                   [AuthController::class, 'sendmailAll']); // send mail to all users
Route::post('send/mail/{id}',                                  [AuthController::class, 'sendmail']); // send mail to specific user
Route::post('getNotifications',                                [AuthController::class, 'getNotifications']); // get notifications user
Route::get('count-notifications',                              [AuthController::class, 'countUnreadNotifications']); // get count notifications user


Route::delete('delete-notification/{notification_id}',         [AuthController::class, 'deleteNotification']); // delete notification user
Route::delete('delete-notifications',                          [AuthController::class, 'deleteNotifications']); // delete all notifications user


Route::get('send-sms-notifications',                           [AuthController::class, 'SendSmsNotifications']); // send sms notifications user











