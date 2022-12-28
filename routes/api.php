<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\RatingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Sanctum;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// ---------{Sanctum}-------
Route::post("/login", [AuthController::class, "login"]);
Route::get("/me", [AuthController::class, "getUser"])->middleware("auth:sanctum");
// --------{ buku }-------
Route::get("/buku", [BukuController::class, "index"]);
Route::get("/buku/{id}", [BukuController::class, "show"]);
Route::post("/buku", [BukuController::class, "store"])->middleware("auth:sanctum");
Route::post("/buku/{id}/edit", [BukuController::class, "update"])->middleware("auth:sanctum");
Route::post("/buku/{id}/delete", [BukuController::class, "destroy"])->middleware("auth:sanctum");

// --------{ Rating }-------
Route::get("/rating", [RatingController::class, "index"]);
Route::get("/rating/{id}", [RatingController::class, "show"]);

// --------{ kategori }-------
Route::get("/kategori", [KategoriController::class, "index"]);
Route::get("/kategori/{id}", [KategoriController::class, "show"]);
Route::post("/kategori", [KategoriController::class, "store"])->middleware("auth:sanctum");
Route::post("/kategori/{id}/edit", [KategoriController::class, "update"])->middleware("auth:sanctum");
Route::post("/kategori/{id}/delete", [KategoriController::class, "destroy"])->middleware("auth:sanctum");

// --------{ author }-------
Route::get("/author", [AuthorController::class, "index"]);
Route::get("/author/{id}", [AuthorController::class, "show"]);
Route::post("/author", [AuthorController::class, "store"])->middleware("auth:sanctum");
Route::post("/author/{id}/edit", [AuthorController::class, "update"])->middleware("auth:sanctum");
Route::post("/author/{id}/delete", [AuthorController::class, "destroy"])->middleware("auth:sanctum");
