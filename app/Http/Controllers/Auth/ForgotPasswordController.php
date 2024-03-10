<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
    /*
    
Password Reset Controller
    
controller này chịu trách nhiệm xử lý các email đặt lại mật khẩu và hỗ trợ gửi các thông báo này tới người dùng. 
    
    */

    use SendsPasswordResetEmails;
}
