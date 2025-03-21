<?php

use App\Http\Controllers\ProductController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// add category
Route::post('/category/add', [ProductController::class, 'addCategory']);
Route::put('/category/update/{id}', [ProductController::class, 'updateCategory']); // Update
Route::delete('/category/delete/{id}', [ProductController::class, 'deleteCategory']); // Delete
Route::get('/products/categories', [ProductController::class, 'getCategory']);

// add product
Route::post('/product/add', [ProductController::class, 'addProduct']);
Route::get('/products', [ProductController::class, 'getProduct']);
Route::put('/product/update/{id}', [ProductController::class, 'updateProduct']); // Update product
Route::delete('/product/delete/{id}', [ProductController::class, 'deleteProduct']); // Delete product
// get api from category
Route::get('/products/category/{category}', [ProductController::class, 'getCategoryProduct']);
Route::get('/products/{id}', [ProductController::class, 'getProductById']);
