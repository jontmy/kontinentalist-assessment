<?php

use App\Http\Controllers\ApiController;
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

Route::get("posts", [ApiController::class, "retrieveAllPosts"]);
Route::get("posts/{id}", [ApiController::class, "retrievePost"]);
Route::post("posts", [ApiController::class, "createPost"]);
Route::patch("posts/{id}", [ApiController::class, "updatePost"]);
Route::delete("posts/{id}", [ApiController::class, "deletePost"]);
