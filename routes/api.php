<?php

use App\Http\Controllers\API\CartController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\CheckoutController;
use App\Http\Controllers\API\ImageController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\User\Auth\EmailVerificationController;
use App\Http\Controllers\API\User\Auth\ForgetPasswordController;
use App\Http\Controllers\API\User\Auth\LoginController;
use App\Http\Controllers\API\User\Auth\RegisterController;
use App\Http\Controllers\API\User\Auth\ResetPasswordController;
use App\Http\Controllers\API\User\ProfileController;
use App\Http\Controllers\API\User\UserImgController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::resource('categories', CategoryController::class)->except('create','edit');
Route::resource('products', ProductController::class);
Route::post('products/colors/{id}',[ProductController::class,'add_color']);

//Route::resource('images',\App\Http\Controllers\API\ImageController::class);
Route::post('images/{product}',[ImageController::class,'store']);
Route::delete('images/{image}',[ImageController::class,'destroy']);
Route::put('images/{product}/{image}',[ImageController::class,'update']);

Route::post('login',[LoginController::class,'login']);
Route::post('register',[RegisterController::class,'register']);
Route::post('password/forget-password',[ForgetPasswordController::class,'forgetPassword']);
Route::post('password/reset',[ResetPasswordController::class,'passwordReset']);

Route::middleware('auth:api')->group(function(){
    Route::get('profile/show',[ProfileController::class,'show']);
    Route::post('logout',[ProfileController::class,'logout']);
    Route::post('profile/update',[ProfileController::class,'update']);
    Route::post('profile/style',[ProfileController::class,'create_style']);
    Route::post('imgs/upload',[UserImgController::class,'upload']);
    Route::delete('imgs/delete/{id}',[UserImgController::class,'destroy']);
    Route::post('email_verification',[EmailVerificationController::class,'email_verification']);
    Route::get('email_verification',[EmailVerificationController::class,'sendEmailVerification']);

});
Route::get('checkout',[CheckoutController::class,'create'])->name('checkout');
Route::post('checkout',[CheckoutController::class,'store']);
Route::resource('cart', CartController::class);
