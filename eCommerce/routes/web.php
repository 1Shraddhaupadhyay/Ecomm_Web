<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\StripePaymentController;
use App\Http\Controllers\AdminController;

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

// Admin Route
Route::get('/admin',[AdminController::class,'index']);
Route::get('/adminProducts',[AdminController::class,'products']);
Route::get('/deleteProduct/{id}',[AdminController::class,'deleteProduct']);
Route::post('/AddNewProduct',[AdminController::class,'AddNewProduct']);
Route::post('/UpdateProduct',[AdminController::class,'UpdateProduct']);
Route::get('/adminProfile',[AdminController::class,'profile']);
Route::get('/ourCustomers',[AdminController::class,'customers']);
Route::get('/changeUserStatus/{status}/{id}',[AdminController::class,'changeUserStatus']);
Route::get('/ourOrders',[AdminController::class,'orders']);
Route::get('/changeOrderStatus/{status}/{id}',[AdminController::class,'changeOrderStatus']);




// Customer Route
Route::get('/',[MainController::class,'index']);
Route::get('/cart',[MainController::class,'cart']);
Route::get('/shop',[MainController::class,'shop']);
Route::get('/checkout',[MainController::class,'checkout']);
Route::get('/single/{id}',[MainController::class,'singleProduct']);
Route::get('/login',[MainController::class,'login']);
Route::get('/register',[MainController::class,'register']);
Route::post('/registerUser',[MainController::class,'registerUser']);
Route::post('/loginUser',[MainController::class,'loginUser']);
Route::get('/logout',[MainController::class,'logout']);
Route::get('/contect',[MainController::class,'contect']);
Route::get('/about',[MainController::class,'about']);
Route::get('/blogdetails',[MainController::class,'blogdetails']);
Route::get('/deleteCartItem/{id}',[MainController::class,'deleteCartItem']);
Route::get('/check',[MainController::class,'check']);
Route::get('/checkout',[MainController::class,'checkout']);
Route::get('/profile',[MainController::class,'profile']);
Route::get('/myOrders',[MainController::class,'myOrders']);
Route::post('/addToCart',[MainController::class,'addToCart']);
Route::post('/updateCart',[MainController::class,'updateCart']);
Route::post('/updateUser',[MainController::class,'updateUser']);
Route::get('/testMail',[MainController::class,'testMail']);
//socialite login Urls
Route::get('/googleLogin',[MainController::class,'googleLogin']);
Route::get('/auth/google/callback',[MainController::class,'googleHandle']);



Route::controller(StripePaymentController::class)->group(function(){
    Route::get('stripe', 'stripe');
    Route::post('stripe', 'stripePost')->name('stripe.post');
});
