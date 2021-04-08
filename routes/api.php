<?php

use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\Auth\WorkerAuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkerController;
use App\Http\Controllers\ProblemController;

/*
|--------------------------------------------------------------------------
| Types Of API Routes
|--------------------------------------------------------------------------
| Customer
| Worker
| Company
*/

// --------------------------Customer--------------------------------------

    //1#### Authentication #####
    Route::post('user/sing-up', [UserAuthController::class, 'register']);

    Route::post('user/sing-in', [UserAuthController::class, 'login']);

    Route::middleware(['auth:user-api'])->group(function () {
        Route::post('user/logout', [UserAuthController::class, 'logout']);

        //2#### Shop ####
        Route::get('products', [ProductController::class, 'index']);

        Route::get('search/{key}', [ProductController::class, 'search']);

        Route::get('checkout', [ProductController::class, 'checkout']);

        //3#### Settings #####
        Route::put('user',[UserController::class, 'update']); // if you sent the same email not accept

        //4#### Points ####
        Route::get('prize', [UserController::class, 'prize']);

        Route::get('claim', function () {
            return "hello";
        });

        //5#### Problem ####
        Route::post('submit-problem', [ProblemController::class, 'store']);

        //6#### Feedback ####
        Route::post('submit-feedback', [WorkerController::class, 'set_rate']);

    });

// --------------------------Worker--------------------------------------

    //1#### Authentication ####
    Route::get('worker/sing-in', [WorkerAuthController::class, 'login']);

    Route::get('worker/logout', [WorkerAuthController::class, 'logout']);

    //2#### Problem ####
    Route::post('submit-problem-from-worker',function () {
        return "hello";
    } );

    //3#### weight ####
    Route::post('submit-weight/{id}', [WorkerController::class, 'set_weight']);

// --------------------------Company--------------------------------------

    //1#### Authentication ####
    Route::get('admin/sing-in', [AdminAuthController::class, 'login']);

    Route::get('admin/logout', [AdminAuthController::class, 'logout']);

    //2#### Worker ####
    Route::get('workers',[WorkerController::class, 'index']);


    Route::get('worker/{id}',[WorkerController::class, 'show']);


    Route::get('worker-search/{keyword}', [WorkerController::class, 'search']);


    Route::post('worker',[WorkerController::class, 'store']);


    Route::put('worker/{id}',[WorkerController::class, 'update']);


    Route::delete('worker/{id}', [WorkerController::class, 'destroy']);


    //3#### Targets ####
    Route::get('my-weekly-target/{id}', [CompanyController::class, 'get_my_weekly_target']);

    Route::get('salary/{id}', [CompanyController::class, 'get_salary']);

