<?php
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\CategoryProduct;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BrandProduct;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;

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
Route::get('/clear-cache',function(){
    $exitCode=Artisan::call('cache:clear');
});
//front end
Route::get('/',[HomeController::class,'index']);
Route::get('/trang-chu',[HomeController::class,'index']);
Route::post('/timkiem',[HomeController::class,'search']);
//show-product
Route::get('/danh-sach-san-pham/{slug_category_product}',[CategoryProduct::class,'showCategoryhome']);
Route::get('/thuong-hieu-san-pham/{brand_id}',[BrandProduct::class,'showBrandhome']);
Route::get('/chi-tet-san-pham/{product_id}',[ProductController::class,'detals_Product']);
//backend
Route::get('/admin',[AdminController::class, 'index']);
Route::get('/dashboard',[AdminController::class,'show_dashboard']);
Route::post('/admin-dashboard',[AdminController::class,'dashboard']);
Route::get('/logout',[AdminController::class, 'logout']);
//send mail
Route::get('/send-mail',[HomeController::class,'send_mail']);
//Category
Route::get('/add-category-product',[CategoryProduct::class,'add_category_product']);
Route::get('/edit-category-product/{category_id}',[CategoryProduct::class,'edit_category_product']);
Route::get('/delete-category-product/{category_id}',[CategoryProduct::class,'delete_category_product']);
Route::get('/all-category-product',[CategoryProduct::class,'all_category_product']);
Route::get('/unactive-category-product/{category_id}',[CategoryProduct::class,'unactive_category_product']);
Route::get('/active-category-product/{category_id}',[CategoryProduct::class,'active_category_product']);
Route::post('/save-category-product',[CategoryProduct::class,'save_category_product']);
Route::post('/update-category-product/{category_id}',[CategoryProduct::class,'update_category_product']);
//Brand
Route::get('/add-brand-product',[BrandProduct::class,'add_brand_product']);
Route::get('/edit-brand-product/{brand_id}',[BrandProduct::class,'edit_brand_product']);
Route::get('/delete-brand-product/{brand_id}',[BrandProduct::class,'delete_brand_product']);
Route::get('/all-brand-product',[BrandProduct::class,'all_brand_product']);
Route::get('/unactive-brand-product/{brand_id}',[BrandProduct::class,'unactive_brand_product']);
Route::get('/active-brand-product/{brand_id}',[BrandProduct::class,'active_brand_product']);
Route::post('/save-brand-product',[BrandProduct::class,'save_brand_product']);
Route::post('/update-brand-product/{brand_id}',[BrandProduct::class,'update_brand_product']);
//Product
Route::get('/add-product',[ProductController::class,'add_product']);
Route::get('/edit-product/{product_id}',[ProductController::class,'edit_product']);
Route::get('/delete-product/{product_id}',[ProductController::class,'delete_product']);
Route::get('/all-product',[ProductController::class,'all_product']);
Route::get('/unactive-product/{product_id}',[ProductController::class,'unactive_product']);
Route::get('/active-product/{product_id}',[ProductController::class,'active_product']);
Route::post('/save-product',[ProductController::class,'save_product']);
Route::post('/update-product/{product_id}',[ProductController::class,'update_product']);
//Cart
Route::post('/add-cart-ajax',[CartController::class,'add_cart_ajax']);
Route::get('/giohang',[CartController::class,'show_cart_ajax']);
Route::get('/delete-cart/{session_id}',[CartController::class,'delete_cart']);
Route::post('/update-cart',[CartController::class,'update_cart']);
//Checkout
Route::get('/login-checkout',[CheckoutController::class,'login_checkout']);
Route::get('/logout-checkout',[CheckoutController::class,'logout_checkout']);
Route::get('/checkout',[CheckoutController::class,'checkout']);
Route::post('/save-checkout-customer',[CheckoutController::class,'save_checkout']);
Route::post('/add-customer',[CheckoutController::class,'add_customer']);
Route::post('/login-customer',[CheckoutController::class,'login_customer']);
Route::post('/order',[CheckoutController::class,'order']);
//order
Route::get('view-order/{order_code}',[OrderController::class,'view_order']);
Route::get('/delete-order/{order_id}',[OrderController::class,'delete_order']);
Route::get('/manager-order',[OrderController::class,'manager_order']);
Route::post('/update-order',[OrderController::class,'update_order']);
Route::post('/update-qty',[OrderController::class,'update_qty']);




// Customer orders (lịch sử & chi tiết)
Route::get('/orders',              [OrderController::class, 'order_history'])->name('orders.index');
Route::get('/orders/{order_code}', [OrderController::class, 'order_detail'])->name('orders.show');
Route::get('/admin-dashboard', fn () => redirect('/admin'));


// ...
Route::post('/admin/orders/update-shipping', [OrderController::class, 'updateShipping'])
     ->name('admin.orders.update_shipping');


