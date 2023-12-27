<?php

use Illuminate\Http\Request;
//use App\Http\Controllers\API\V1\CourseController;


use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

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


Route::prefix('v1')
    ->namespace('API\\V1')
    ->group(
        function ($route) {
           // Route::post('subscribe/{id}', 'CourseController@subscribe')->middleware('auth:api');
           
			Route::middleware(['throttle:60,1'])->group(function () {
				Route::apiResource('courses', CourseController::class);
			});
			
			Route::middleware(['throttle:60,1'])->group(function () {
				Route::apiResource('enrolments', EnrolmentController::class);
				Route::get('enrolments/list', [EnrolmentController::class, 'listEnrolments']);
			});
         
        }
    );

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('subscribe/{id}', 'CourseController@subscribe')->middleware('auth:api');

Route::apiResource('message','MessageController')->middleware('auth:api');
