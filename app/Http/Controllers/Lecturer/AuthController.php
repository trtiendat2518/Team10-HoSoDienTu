<?php

namespace App\Http\Controllers\Lecturer;

use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Validator;
use Session;
session_start();

class AuthController extends Controller
{
    public function index()
    {
       return view('lecturer.pages.dashboard');
    }

    public function get_login()
    {
       return view('lecturer.auth.login');
    }

    public function post_login(Request $request)
    {
        $data = $request->validate([
            'admin_username' => ['required','min:5','max:30','alpha_dash'],
            'admin_password' => ['required', 'min:6', 'max: 32'],
        ],
        [
            'admin_username.required' => 'Tên đăng nhập không được để trống!',
            'admin_username.min' => 'Tên đăng nhập ít nhất 5 ký tự chữ!',
            'admin_username.max' => 'Tên đăng nhập không quá 30 ký tự chữ!',
            'admin_username.alpha_dash' => 'Tên đăng nhập không chứa khoản trắng!',

            'admin_password.required' => 'Mật khẩu không được để trống!',
            'admin_password.min' => 'Mật khẩu ít nhất 6 ký tự chữ!',
            'admin_password.max' => 'Mật khẩu không quá 32 ký tự chữ!',
        ]);

        $username = $data['admin_username'];
        $password = md5($data['admin_password']);

        $check = Admin::where('admin_username', $username)->where('admin_password', $password)->first();

        if($check){
            $request->session()->put('admin_id', $check->admin_id);
            $request->session()->put('admin_fullname', $check->admin_fullname);
            $request->session()->put('admin_email', $check->admin_email);
            return redirect()->intended('admin/dashboard');
            
        }else{
            return back()->with('fail', 'Tên đăng nhập hoặc mật khẩu không đúng');
        }
    }

    public function get_logout(Request $request){
        $request->session()->put('admin_id', null);
        $request->session()->put('admin_fullname', null);
        $request->session()->put('admin_email', null);
        return redirect()->intended('admin/login');
    }
}
