<?php

use App\Http\Controllers\AnswearController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\Profile;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ResponseController;
use App\Models\Answear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::middleware('auth:sanctum')->post('/send', [AnswearController::class, 'store']);

Route::middleware('auth:sanctum')->get('/all', [AnswearController::class, 'index']);

// Route::middleware('auth:sanctum')->get('/send', [AnswearController::class, 'store']);


// Route::middleware('auth:sanctum')->post('/question', [QuestionController::class, 'store']);

//Form CRUD

Route::middleware('auth:sanctum')->get('/form/{form:slug}', [FormController::class, 'show']);

Route::middleware('auth:sanctum')->delete('/form/{form}', [FormController::class, 'destroy']);

Route::middleware('auth:sanctum')->post('/form', [FormController::class, 'store']);

Route::middleware('auth:sanctum')->post('/form/draft', [FormController::class, 'storeDraft']);

Route::middleware('auth:sanctum')->get('/form', [FormController::class, 'index']);

Route::middleware('auth:sanctum')->post('/form/point', [FormController::class, 'changePoint']);

//Response

Route::middleware('auth:sanctum')->get('/response/{slug}', [ResponseController::class, 'show']);

//Profile CRUD
Route::middleware('auth:sanctum')->put('/profile/{profile}', [Profile::class, 'update']);

Route::middleware('auth:sanctum')->get('/profile', [Profile::class, 'index']);


Route::get('/ujicoba', function(){
    return response()->json(['pesan' => 'Hello Salsa']);
});



// Route::post('/form', [FormController::class, 'store']);