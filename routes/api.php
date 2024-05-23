<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ProductController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::group(['middleware' => ['api']], function(){
//     Route::resource('products', ProductController::class);    
// });


// Route::get('products', [App\Http\Controllers\API\ProductController::class]);
// Route::post('products', [App\Http\Controllers\API\ProductController::class]);

// Route::get('/products', [App\Http\Controllers\API\ProductController::class, 'index'])->name('products.index');
// Route::get('/products/search', [App\Http\Controllers\API\ProductController::class, 'search'])->name('products.search');
// Route::get('/products/create', [App\Http\Controllers\API\ProductController::class,'create'])->name('products.create');
// Route::post('/products', [App\Http\Controllers\API\ProductController::class, 'store'])->name('products.store');
// Route::get('/products/{product}', [App\Http\Controllers\API\ProductController::class, 'show'])->name('products.show');
// Route::get('/products/{product}/edit', [App\Http\Controllers\API\ProductController::class, 'edit'])->name('products.edit');
// Route::put('/products/{product}', [App\Http\Controllers\API\ProductController::class, 'update'])->name('products.update');
// Route::delete('/products/{product}', [App\Http\Controllers\API\ProductController::class, 'destroy'])->name('products.destroy');