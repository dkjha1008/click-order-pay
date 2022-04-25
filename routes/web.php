<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrdersController;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PromocodeController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\AttributeController;

use App\Http\Controllers\Store\StoreProductController;
use App\Http\Controllers\Store\StoreOrdersController;
use App\Http\Controllers\Store\StoreDashboardController;

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

Route::get('/cron', [FrontController::class, 'cron']);
Route::get('/insta', [FrontController::class, 'insta']);
Route::get('/move',[FrontController::class,'move'])->name('move');

//home page

Route::get('/', [FrontController::class, 'home'])->name('home');
Route::get('/about-us', [FrontController::class, 'about'])->name('about');
Route::get('/contact-us', [FrontController::class, 'contact'])->name('contact');
Route::post('/contact-us/request', [FrontController::class, 'contactUsForm'])->name('contact.request');
Route::get('/privacy-policy', [FrontController::class, 'privacy'])->name('privacy');
Route::get('/terms-conditions', [FrontController::class, 'terms'])->name('terms');
Route::get('/join-us', [FrontController::class, 'joinus'])->name('joinus');
Route::get('/apply-now', [FrontController::class, 'applyNow'])->name('applyNow');
Route::get('/favourite', [FrontController::class, 'favourite'])->name('favourite');
Route::get('/favourite/data', [FrontController::class, 'favouriteData'])->name('favourite.data');
Route::post('/favourite/action', [FrontController::class, 'favouriteAction'])->name('favourite.action');
Route::get('/store-hours', [FrontController::class, 'storeHours'])->name('storeHours');
Route::get('/current-locations', [FrontController::class, 'currentLocation'])->name('currentLocation');

//ucla page
Route::get('/shop', [FrontController::class, 'ucla'])->name('ucla');


// Auth
Route::get('/signin', [AuthController::class, 'loginForm'])->name('signin')->middleware('guest');
Route::post('/signin/verify', [AuthController::class, 'loginVerify'])->name('signin.verify')->middleware('guest');
Route::post('/signin', [AuthController::class, 'login'])->name('signin.attempt')->middleware('guest');

//Signup
Route::get('/signup', [AuthController::class, 'signupForm'])->name('signup')->middleware('guest');
Route::post('/signup', [AuthController::class, 'signup'])->name('signup.attempt')->middleware('guest');
Route::post('/signup/otp', [AuthController::class, 'signupOtp'])->name('signup.otp')->middleware('guest');
Route::post('/resend/otp', [AuthController::class, 'resendOtp'])->name('resend.otp')->middleware('guest');

//Signup
Route::get('/forgot-password', [AuthController::class, 'forgotForm'])->name('forgot')->middleware('guest');
Route::post('/password', [AuthController::class, 'password'])->name('password')->middleware('guest');
Route::post('/password/change', [AuthController::class, 'passwordInertia'])->name('password.inertia')->middleware('guest');

//flush cache
Route::get('/cache-clear', function() {
	Artisan::call('config:cache');
	Artisan::call('cache:clear');
	return "Cache is cleared";
});

Route::get('/migrate', function() {
	Artisan::call('migrate');
	return "Migrate";
});

Route::get('/storage-link', function() {
	Artisan::call('storage:link');
	return "storage:link";
});

//cart
Route::group(['prefix' => 'cart'], function(){
	Route::get('/', [CartController::class, 'index'])->name('cart.index');
	Route::get('/data', [CartController::class, 'data'])->name('cart.data');
	Route::post('/store', [CartController::class, 'store'])->name('cart.store');
	Route::post('/action', [CartController::class, 'action'])->name('cart.action');
	Route::post('/reorder', [CartController::class, 'reorder'])->name('cart.reorder');
	Route::post('/attr', [CartController::class, 'CartAttr'])->name('cart.attr');
});

//checkout
Route::group(['prefix' => 'checkout'], function(){
	Route::post('/user', [CheckoutController::class, 'user'])->name('checkout.user');
	Route::post('/store', [CheckoutController::class, 'store'])->name('checkout.store');
	Route::post('/venmo', [CheckoutController::class, 'venmo'])->name('checkout.venmo');
});

//middleware with verified email-----------------------------------------------------------------------------------
Route::middleware(['auth', 'verified'])->group(function () {
	
	Route::post('/user-logout', [AuthController::class, 'logout'])->name('userLogout');

	//update order status
	Route::post('/order/status/{order}', [OrdersController::class, 'orderStatus'])->name('orders.status');
	
	
	Route::group(['middleware' => ['role:user']], function(){
		//profile page
		Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
		Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
		Route::post('/profile/address', [ProfileController::class, 'addressUpdate'])->name('profile.address');
		
		//promocode
		Route::post('/promocode', [CartController::class, 'promocode'])->name('promocode');
		
		//change-password
		Route::get('/change-password', [ProfileController::class, 'password'])->name('change.password');
		Route::post('/change-password', [ProfileController::class, 'passwordUpdate'])->name('change.password');
		
		//orders
		Route::get('/orders', [OrdersController::class, 'index'])->name('orders');
		Route::get('/orders/{order}', [OrdersController::class, 'show'])->name('orders.show');
		Route::post('/orders/action', [OrdersController::class, 'action'])->name('orders.action');
		
		
		
	});
	
	
	
	
	//added url prefix for admin
	Route::prefix('admin')->group(function () {
	
		Route::get('/', [DashboardController::class, 'index'])->name('admin');
		
		//daily sales
		Route::get('/daily-sales', [OrdersController::class, 'dailysales'])->name('admin.dailysales');
		
		//category
		Route::group(['prefix' => 'category', 'middleware' => ['role:admin']], function(){
			Route::get('/', [CategoryController::class, 'index'])->name('admin.category');
			Route::get('/create', [CategoryController::class, 'create'])->name('admin.category.create');
			Route::post('/store', [CategoryController::class, 'store'])->name('admin.category.store');
			Route::post('/store', [CategoryController::class, 'store'])->name('admin.category.store');
			Route::get('/{category}/edit', [CategoryController::class, 'edit'])->name('admin.category.edit');
			Route::patch('/{category}/update', [CategoryController::class, 'update'])->name('admin.category.update');
			Route::delete('/{category}/destroy', [CategoryController::class, 'destroy'])->name('admin.category.destroy');
			Route::get('/position/{category}/{action}', [CategoryController::class, 'categoryPosition'])->name('admin.category.position');
		});
		
		//products
		Route::group(['prefix' => 'products', 'middleware' => ['role:admin']], function(){
			Route::get('/', [ProductsController::class, 'index'])->name('admin.products');
			Route::get('/csv-export', [ProductsController::class, 'csvExport'])->name('admin.products.csvExport');
			Route::get('/create', [ProductsController::class, 'create'])->name('admin.products.create');
			Route::post('/store', [ProductsController::class, 'store'])->name('admin.products.store');
			Route::post('/store', [ProductsController::class, 'store'])->name('admin.products.store');
			Route::get('/{product}/edit', [ProductsController::class, 'edit'])->name('admin.products.edit');
			Route::patch('/{product}/update', [ProductsController::class, 'update'])->name('admin.products.update');
			Route::delete('/{product}/destroy', [ProductsController::class, 'destroy'])->name('admin.products.destroy');
			Route::post('/csv', [ProductsController::class, 'uploadCSV'])->name('admin.products.csv');
			Route::get('/position/{product}/{action}', [ProductsController::class, 'productsPosition'])->name('admin.products.position');
			
		});

		Route::group(['middleware' => ['role:admin']], function(){
			Route::resource('attributes',AttributeController::class);
			Route::get('attribute/{id}',[AttributeController::class,'atrributeById'])->name('admin.attributeById');

		});
		
		//promocode
		Route::group(['prefix' => 'promocode', 'middleware' => ['role:admin']], function(){
			Route::get('/', [PromocodeController::class, 'index'])->name('admin.promocode');
			Route::get('/create', [PromocodeController::class, 'create'])->name('admin.promocode.create');
			Route::post('/store', [PromocodeController::class, 'store'])->name('admin.promocode.store');
			Route::post('/store', [PromocodeController::class, 'store'])->name('admin.promocode.store');
			Route::get('/{code}/edit', [PromocodeController::class, 'edit'])->name('admin.promocode.edit');
			Route::patch('/{code}/update', [PromocodeController::class, 'update'])->name('admin.promocode.update');
			Route::delete('/{code}/destroy', [PromocodeController::class, 'destroy'])->name('admin.promocode.destroy');
		});
		
		
		//ordersStoreOrdersController
		Route::group(['prefix' => 'orders', 'middleware' => ['role:admin']], function(){
			Route::get('/', [OrdersController::class, 'adminOrders'])->name('admin.orders');
			Route::get('/csv', [OrdersController::class, 'adminOrdersCsv'])->name('admin.orders.csv');
			Route::get('/{order}', [OrdersController::class, 'adminOrderShow'])->name('admin.orders.show');
			Route::get('/refund/{order}', [OrdersController::class, 'adminRefund'])->name('admin.orders.refund');
			Route::get('/payment/{order}', [OrdersController::class, 'orderPayment'])->name('admin.orders.payment');
			Route::get('/cancle/{order}', [OrdersController::class, 'action'])->name('admin.orders.cancle');
		});
		
		//users
		Route::group(['prefix' => 'users', 'middleware' => ['role:admin']], function(){
			Route::get('/', [UsersController::class, 'index'])->name('admin.users');
			Route::get('/create', [UsersController::class, 'create'])->name('admin.users.create');
			Route::post('/create', [UsersController::class, 'store'])->name('admin.users.store');
			Route::get('/csv-export', [UsersController::class, 'csvExport'])->name('admin.user.csvExport');
			Route::get('/{user}', [UsersController::class, 'show'])->name('admin.user.show');
			Route::get('/{user}/edit', [UsersController::class, 'edit'])->name('admin.user.edit');
			Route::patch('/{user}/update', [UsersController::class, 'update'])->name('admin.user.update');
		});

		//stores
		Route::group(['prefix'=>'stores', 'middleware' => ['role:admin']], function(){
			Route::get('/', [UsersController::class, 'stores'])->name('admin.stores');
			Route::get('/login/{id}', [UsersController::class, 'login'])->name('admin.stores.login');
		});
		
		
		//settings
		Route::group(['prefix' => 'settings', 'middleware' => ['role:admin']], function(){
			Route::get('/', [SettingsController::class, 'index'])->name('admin.settings');
			Route::post('/store', [SettingsController::class, 'store'])->name('admin.settings.store');
		});	

		Route::group(['prefix' => 'profile', 'middleware' => ['role:admin']], function(){
			//profile page
			Route::get('/', [ProfileController::class, 'indexAdmin'])->name('admin.profile');
			Route::post('/', [ProfileController::class, 'updateAdmin'])->name('admin.profile.update');

			//change-password
			Route::get('/change-password', [ProfileController::class, 'passwordAdmin'])->name('admin.change.password');
			Route::post('/change-password', [ProfileController::class, 'passwordUpdateAdmin'])->name('admin.change.password');
		});
		


		
		
	});


	Route::prefix('store')->group(function() {

		    Route::get('/daily-sales', [StoreOrdersController::class, 'dailysales'])->name('store.dailysales');
		    Route::get('/', [StoreDashboardController::class, 'index'])->name('store');
		    Route::get('attribute/{id}',[AttributeController::class,'atrributeById']);
		    Route::group(['prefix' => 'products', 'middleware' => ['role:store']], function(){
			Route::get('/', [StoreProductController::class, 'index'])->name('store.products');
			Route::get('/csv-export', [StoreProductController::class, 'csvExport'])->name('store.products.csvExport');
			Route::get('/create', [StoreProductController::class, 'create'])->name('store.products.create');
			Route::post('/store', [StoreProductController::class, 'store'])->name('store.products.store');
			Route::post('/store', [StoreProductController::class, 'store'])->name('store.products.store');
			Route::get('/{product}/edit', [StoreProductController::class, 'edit'])->name('store.products.edit');
			Route::patch('/{product}/update', [StoreProductController::class, 'update'])->name('store.products.update');
			Route::delete('/{product}/destroy', [StoreProductController::class, 'destroy'])->name('store.products.destroy');
			Route::post('/csv', [StoreProductController::class, 'uploadCSV'])->name('store.products.csv');
			Route::get('/position/{product}/{action}', [StoreProductController::class, 'productsPosition'])->name('admin.products.position');
		});

		Route::group(['prefix' => 'profile', 'middleware' => ['role:store']], function(){
			//profile page
			Route::get('/', [ProfileController::class, 'indexStore'])->name('store.profile');
			Route::post('/', [ProfileController::class, 'updateStore'])->name('store.profile.update');

			//change-password
			Route::get('/change-password', [ProfileController::class, 'passwordStore'])->name('store.change.password');
			Route::post('/change-password', [ProfileController::class, 'passwordUpdateStore'])->name('store.change.password');
		});

			//orders
			Route::group(['prefix' => 'orders', 'middleware' => ['role:store']], function(){
				Route::get('/', [StoreOrdersController::class, 'adminOrders'])->name('store.orders');
				Route::get('/csv', [StoreOrdersController::class, 'adminOrdersCsv'])->name('store.orders.csv');
				Route::get('/{order}', [StoreOrdersController::class, 'adminOrderShow'])->name('store.orders.show');
				Route::get('/refund/{order}', [StoreOrdersController::class, 'adminRefund'])->name('store.orders.refund');
				Route::get('/payment/{order}', [StoreOrdersController::class, 'orderPayment'])->name('store.orders.payment');
				Route::get('/cancle/{order}', [StoreOrdersController::class, 'action'])->name('store.orders.cancle');
			});

	});
	
	
});
