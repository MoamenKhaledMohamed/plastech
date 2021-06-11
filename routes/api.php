<?php

use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\Auth\WorkerAuthController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;
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
// Note: MUST user_id, worker_id and admin_id be Different Otherwise Auth will be wrong (logout problem)
// --------------------------Customer--------------------------------------

    //1#### Authentication #####
    Route::post('user/sing-up', [UserAuthController::class, 'register']);

    Route::post('user/sing-in', [UserAuthController::class, 'login']);

    Route::middleware(['auth:user-api'])->group(function ()
    {
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
        Route::post('submit-feedback', [WorkerController::class, 'set_rate']); // no relation between user and worker(user rates a worker)

        //7#### MyLocation####
        Route::post('get-order', [MapController::class, 'get_order']);
    });

// --------------------------Worker--------------------------------------

    //1#### Authentication ####
    Route::post('worker/sing-in', [WorkerAuthController::class, 'login']);

    Route::middleware(['auth:worker-api'])->group(function ()
    {
        Route::post('worker/logout', [WorkerAuthController::class, 'logout']);

        //2#### Problem ####
        Route::post('worker/problem', function () {
            return "hello";
        });

        //3#### weight ####
        Route::post('worker/submit-weight', [WorkerController::class, 'set_weight']);

        //4#### MyOrder####
        Route::post('my-order', [OrderController::class, 'search_for_my_order']);

        Route::post('my-location', [MapController::class, 'change_my_location']);
    });
// --------------------------Company--------------------------------------

    //1#### Authentication ####
    Route::post('admin/sing-in', [AdminAuthController::class, 'login']);

    Route::middleware(['auth:admin-api'])->group(function ()
    {
        Route::post('admin/logout', [AdminAuthController::class, 'logout']);

        //2#### Worker ####
        Route::get('workers', [WorkerController::class, 'index']);


        Route::get('worker/{id}', [WorkerController::class, 'show']);


        Route::get('worker-search/{keyword}', [WorkerController::class, 'search']);


        Route::post('worker', [WorkerController::class, 'store']);


        Route::put('worker/{id}', [WorkerController::class, 'update']);


        Route::delete('worker/{id}', [WorkerController::class, 'destroy']);


        //3#### Targets ####
        Route::get('my-weekly-target/{id}', [CompanyController::class, 'get_my_weekly_target']);

        Route::get('salary/{id}', [CompanyController::class, 'get_salary']);
    });

