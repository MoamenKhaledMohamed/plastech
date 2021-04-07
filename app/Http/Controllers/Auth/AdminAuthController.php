<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminAuthController extends Controller
{
    public function login()
    {
        // validate the request
        // check from email and password by auth() helper method with guard
        // if email and password are correct return user and his token
        // else return error message
    }

    public function logout()
    {

    }
}
