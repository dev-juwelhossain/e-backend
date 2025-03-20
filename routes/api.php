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
Route::get('/products/categories', [ProductController::class, 'getCategory']);

// add product
Route::post('/product/add', [ProductController::class, 'addProduct']);

