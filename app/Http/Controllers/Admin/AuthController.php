<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Redirect;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lecturer;
use App\Models\Admin;
use App\Models\Student;
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
        $data = $request->validate(
            [
                'admin_username' => ['required', 'min:5', 'max:30', 'alpha_dash'],
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
            ]
        );

        $username = $data['admin_username'];
        $password = md5($data['admin_password']);

        $check = Admin::where('admin_username', $username)->where('admin_password', $password)->first();

        if ($check) {
            $request->session()->put('admin_id', $check->admin_id);
            $request->session()->put('admin_fullname', $check->admin_fullname);
            $request->session()->put('admin_email', $check->admin_email);
            return redirect()->intended('admin');
        } else {
            return back()->with('fail', 'Tên đăng nhập hoặc mật khẩu không đúng');
        }
    }

    public function get_logout(Request $request)
    {
        $request->session()->flush();
        $request->session()->put('admin_id', null);
        $request->session()->put('admin_fullname', null);
        $request->session()->put('admin_email', null);
        $request->session()->put('lecturer_code', null);
        return redirect()->intended('admin/login');
    }

    public function login_ms()
    {
        return Socialite::driver('graph')->redirect();
    }

    public function callback_ms(Request $request)
    {
        $users = Socialite::driver('graph')->user();

        $authUser = $this->findOrCreateUser($users);

        if ($authUser->lecturer_status == 0) {
            if ($authUser) {
                $request->session()->put('lecturer_fullname', $authUser->lecturer_fullname);
                $request->session()->put('lecturer_email', $authUser->lecturer_email);
                $request->session()->put('lecturer_id', $authUser->lecturer_code);
                $request->session()->put('lecturer_code', $authUser->lecturer_id);
            } else {
                $request->session()->put('lecturer_fullname', $authUser->lecturer_fullname);
                $request->session()->put('lecturer_email', $authUser->lecturer_email);
                $request->session()->put('lecturer_id', $authUser->lecturer_code);
                $request->session()->put('lecturer_code', $authUser->lecturer_id);
            }
            //dd($users);
            return redirect()->intended('admin');
        } else {
            return redirect()->intended('admin/login')->with('fail', 'Tài khoản đã bị vô hiệu hóa');
        }
    }

    public function findOrCreateUser($users)
    {
        $authUser = Lecturer::where('tbl_lecturer.lecturer_email', $users->email)->first();

        if ($authUser) {
            return $authUser;
        } else {
            $first_name = $users->givenName;
            $splitFirstName = explode(' - ', $first_name);

            $last_name = $users->surname;
            $splitLastName = explode(' - ', $last_name);

            $first = $splitFirstName[1];
            $last = !empty($splitLastName[1]) ? $splitLastName[0] : $splitLastName[1];

            $social_gg = new Lecturer([
                'lecturer_email' => $users->email,
                'lecturer_fullname' => $first . ' ' . $last,
                'lecturer_code' => $users->id
            ]);
            $social_gg->save();
            return $social_gg;
        }
    }

    public function login_ms_stu()
    {
        return Socialite::driver('microsoft')->redirect();
    }

    public function callback_ms_stu(Request $request)
    {
        $users = Socialite::driver('microsoft')->user();

        $authUser = Student::where('tbl_student.student_email', $users->email)->first();

        if ($authUser) {
            if ($authUser->student_status == 0) {
                if ($authUser) {
                    $request->session()->put('student_fullname', $authUser->student_fullname);
                    $request->session()->put('student_email', $authUser->student_email);
                    $request->session()->put('student_id', $authUser->student_id);
                    $request->session()->put('student_code', $authUser->student_code);
                } else {
                    $request->session()->put('student_fullname', $authUser->student_fullname);
                    $request->session()->put('student_email', $authUser->student_email);
                    $request->session()->put('student_id', $authUser->student_id);
                    $request->session()->put('student_code', $authUser->student_code);
                }
                return redirect()->intended('/home');
            } else {
                return redirect()->intended('/dang-nhap')->with('fail', 'Tài khoản đã bị vô hiệu hóa');
            }
        } else {
            return redirect()->intended('/dang-nhap')->with('fail', 'Tài khoản không tồn tại');
        }
    }

    public function get_logout_student(Request $request)
    {
        $request->session()->flush();
        $request->session()->put('student_id', null);
        $request->session()->put('student_fullname', null);
        $request->session()->put('student_email', null);
        $request->session()->put('student_code', null);
        return redirect()->intended('/');
    }
}
