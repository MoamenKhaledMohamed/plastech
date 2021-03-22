<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
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
    Route::get('products', [\App\Http\Controllers\ProductController::class, 'index']);

    Route::get('search/{key}', [\App\Http\Controllers\ProductController::class, 'search']);

    //3#### Settings #####
    Route::get('users/{id}', function () {
        return "hello";
    });

    Route::get('save', function () {
        return "hello";
    });

    //4#### Points ####
    Route::get('points', function () {
        return "hello";
    });

    Route::get('prize', function () {
        return "hello";
    });

    Route::get('claim', function () {
        return "hello";
    });

    //5#### Problem ####
    Route::get('submit-problem', function () {
        return "hello";
    });

    //6#### Feedback ####
    Route::get('submit-feedback', function () {
        return "hello";
    });

// --------------------------Worker--------------------------------------

    //1#### Authentication ####
    Route::get('sing-in-worker', function () {
        return "hello";
    });

    Route::get('logout-worker', function () {
        return "hello";
    });

    //2#### Problem ####
    Route::post('submit-problem-from-worker', [ProblemController::class, 'store']);

    //3#### weight ####
    Route::post('submit-weight',[WorkerController::class, 'set_rate'] );

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
    Route::get('daily-target', function () {
        return "hello";
    });

    Route::get('weekly-target', function () {
        return "hello";
    });

    Route::get('total-weight', function () {
        return "hello";
    });
