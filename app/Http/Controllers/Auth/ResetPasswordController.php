<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
    /*
    Password Reset Controller
    */

    use ResetsPasswords;

    /**
     *
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;
}
