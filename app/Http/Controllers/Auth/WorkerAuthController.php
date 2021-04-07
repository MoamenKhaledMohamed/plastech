<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WorkerAuthController extends Controller
{
    public function login()
    {
        // validate the request
        // check from email and password by auth() helper method with guard
        // if email and password are correct return user and his token
        // else return error message
        return 'any';
    }

    public function logout()
    {

    }
}
