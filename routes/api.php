<?php
use  App\Http\Controllers\BookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use  App\Http\Controllers\AuthController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//for generating all default route for crud 
//  Route::resource('books',BookController::class);

//publice routes
Route::get('/books',[BookController::class,'index']);

Route::get('/books/{id}',[BookController::class,'show']);

Route::get('/books/kerko/{name}',[BookController::class,'kerko']);

Route::get('/books/exists/{id}',[BookController::class,'check_existence']);

Route::post('/user/register',[AuthController::class,'register']);

Route::post('/user/login',[AuthController::class,'login']);


//protected Routes
Route::group(['middleware'=>['auth:sanctum']], function (){

    Route::post('/books',[BookController::class,'store']);

    Route::put('/books/{id}',[BookController::class,'update']);

    Route::delete('/books/{id}',[BookController::class,'destroy']);

    Route::post('/user/logout',[AuthController::class,'logout']);
});