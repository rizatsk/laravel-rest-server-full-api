<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\FormController;
use App\Http\Controllers\API\ScoreController;

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
Route::group(['middleware' => 'auth:sanctum'],function(){
    Route::get('/students',[FormController::class,'students']);
    Route::get('/students/{id}',[FormController::class,'student']);
    Route::post('/create',[FormController::class,'create']);
    Route::get('/update/{id}',[FormController::class,'getUpdate']);
    Route::post('/update/{id}',[FormController::class,'Update']);
    Route::get('/delete/{id}',[FormController::class,'delete']);
    Route::get('/logout',[AuthController::class,'logout']);

    // CRUD MultiTable
    Route::post('/create_score_data',[ScoreController::class,'create']);
    Route::get('/update_score_dataStudent/{id}',[ScoreController::class,'getUpdate']);
    Route::post('/update_score_dataStudent/{id}',[ScoreController::class,'update']);
});  

Route::post('/login',[AuthController::class,'login']);
// Route::post('/tokens/create', function (Request $request) {
//     $token = $request->user()->createToken($request->token_name);

//     return ['token' => $token->plainTextToken];
// });  