<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Redirect;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lecturer;
use App\Models\Admin;
use Validator;
use Session;
session_start();

class AuthController extends Controller
{
    public function get_login(Request $request)
    {
        return view('admin.auth.login');
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

    public function get_logout(Request $request)
    {
        $request->session()->flush();
        $request->session()->put('admin_id', null);
        $request->session()->put('admin_fullname', null);
        $request->session()->put('admin_email', null);
        return redirect()->intended('admin/login');
    }

    public function login_ms()
    {
        return Socialite::driver('graph')->redirect();
    }

    public function callback_ms(Request $request)
    {
        $users = Socialite::driver('graph')->stateless()->user();

        $authUser = $this->findOrCreateUser($users);

        if($authUser->lecturer_status==0){
            if($authUser){
                //$account = Customer::where('customer_id',$authUser->user)->first();
                $request->session()->put('lecturer_fullname',$authUser->lecturer_fullname);
                $request->session()->put('lecturer_email',$authUser->lecturer_email);
                $request->session()->put('lecturer_id',$authUser->lecturer_code);
            }else {
                $request->session()->put('lecturer_fullname',$authUser->lecturer_fullname);
                $request->session()->put('lecturer_email',$authUser->lecturer_email);
                $request->session()->put('lecturer_id',$authUser->lecturer_code);
            }
            //dd($users);
            return redirect()->intended('admin/dashboard');
        }else{
            return redirect()->intended('admin/login')->with('fail', 'Tài khoản đã bị vô hiệu hóa');
        }
    }

    public function findOrCreateUser($users)
    {
        $authUser = Lecturer::where('tbl_lecturer.lecturer_email', $users->email)->first();

        if($authUser){
            return $authUser;
        }else{
            $social_gg = new Lecturer([
                'lecturer_email' => $users->email,
                'lecturer_fullname' => $users->givenName . ' ' . $users->surname,
                'lecturer_code' => $users->id 
            ]);
            $social_gg->save();
            return $social_gg;
        }
    }
}
