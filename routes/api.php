<?php

use App\Http\Controllers\CompanyController;
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
    Route::get('sing-up', function () {
        return "hello";
    });

    Route::get('sing-in', function () {
        return "hello";
    });

    Route::get('logout', function () {
        return "hello";
    });

    //2#### Shop ####
    Route::get('products', [ProductController::class, 'index']);

    Route::get('search/{key}', [ProductController::class, 'search']);

    Route::get('checkout', [ProductController::class, 'checkout']);

    //3#### Settings #####
    Route::get('user/{id}',[UserController::class,'show']);

    Route::put('user/{id}',[UserController::class, 'update']);

    //4#### Points ####
    Route::get('points', [UserController::class, 'get_points']);

    Route::get('prize', [UserController::class, 'prize']);

    Route::get('claim', function () {
        return "hello";
    });

    //5#### Problem ####
    Route::post('submit-problem', [ProblemController::class, 'store']);

    //6#### Feedback ####
    Route::post('submit-feedback', [WorkerController::class, 'set_rate']);

// --------------------------Worker--------------------------------------

    //1#### Authentication ####
    Route::get('sing-in-worker', function () {
        return "hello";
    });

    Route::get('logout-worker', function () {
        return "hello";
    });

    //2#### Problem ####
    Route::post('submit-problem-from-worker',function () {
        return "hello";
    } );

    //3#### weight ####
    Route::post('submit-weight/{id}', [WorkerController::class, 'set_weight']);

// --------------------------Company--------------------------------------

    //1#### Authentication ####
    Route::get('sing-in-company', function () {
        return "hello";
    });

    Route::get('logout-company', function () {
        return "hello";
    });

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

