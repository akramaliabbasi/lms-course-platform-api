<?php

use Illuminate\Http\Request;
use App\Http\Controllers\API\V1\EnrolmentController;
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


Route::prefix('v1')
    ->namespace('API\\V1')
    ->group(
        function ($route) {
           
            // Just added the unsecure API with that you are allowing 60 requests per minute.
            Route::middleware(['throttle:60,1'])->group(function () {
				Route::apiResource('courses', CourseController::class);
			});
			
			Route::middleware(['throttle:60,1'])->group(function () {
          	    Route::post('enrolment/add', [EnrolmentController::class, 'create']);
                Route::put('enrolment/edit', [EnrolmentController::class, 'update']);
                Route::get('enrolment/details', [EnrolmentController::class, 'show']);
				Route::get('enrolment/list', [EnrolmentController::class, 'listEnrolments']);
                Route::get('enrolments', [EnrolmentController::class, 'index']);
			});
         
        }
    );


    // Just added the secure API with authentication .    
    Route::middleware('auth:api')->get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('subscribe/{id}', 'CourseController@subscribe')->middleware('auth:api');

    Route::apiResource('message','MessageController')->middleware('auth:api');
