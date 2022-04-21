<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Redirect;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lecturer;
use App\Models\Admin;
use App\Models\Student;
use App\Models\Visitor;
use App\Http\Resources\VisitorResource;
use Carbon\Carbon;
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

            $user_ip_address = $request->ip();
            $visitor_current = Visitor::where('visitor_ipaddress', $user_ip_address)->get();
            $visitor_count = $visitor_current->count();
            if ($visitor_count < 1) {
                $visitor = new Visitor();
                $visitor->visitor_ipaddress = $user_ip_address;
                $visitor->visitor_date = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
                $visitor->save();
            }
            return redirect()->intended('admin');
        } else {
            return back()->with('fail', 'Tên đăng nhập hoặc mật khẩu không đúng');
        }
    }

    public function get_logout(Request $request)
    {
        $request->session()->flush();
        $request->session()->put('admin_id', null);
        $request->session()->put('lecturer_id', null);
        $request->session()->put('admin_fullname', null);
        $request->session()->put('admin_email', null);
        $request->session()->put('lecturer_code', null);
        return redirect()->intended('dang-nhap');
    }

    public function login_ms()
    {
        return Socialite::driver('graph')->redirect();
    }

    public function callback_ms(Request $request)
    {
        if (isset($_GET['code']) != null) {
            $users = Socialite::driver('graph')->user();

            $email = $users->email;
            $splitEmail = explode('@', $email);

            //cheat account student
            if ($users->email == 'dat.187pm06566@vanlanguni.vn' || $users->email == 'tin.187pm14021@vanlanguni.vn') {
                $splitEmail[1] = 'vlu.edu.vn';
            }

            if ($splitEmail[1] == 'vlu.edu.vn') {
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

                    $user_ip_address = $request->ip();
                    $visitor_current = Visitor::where('visitor_ipaddress', $user_ip_address)->get();
                    $visitor_count = $visitor_current->count();
                    if ($visitor_count < 1) {
                        $visitor = new Visitor();
                        $visitor->visitor_ipaddress = $user_ip_address;
                        $visitor->visitor_date = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
                        $visitor->save();
                    }
                    return redirect()->intended('admin');
                } else {
                    return redirect()->intended('dang-nhap')->with('fail', 'Tài khoản đã bị vô hiệu hóa');
                }
            } else if ($splitEmail[1] == 'vanlanguni.vn') {
                // return redirect()->intended('admin/login')->with('fail', 'Tài khoản sinh viên không thể đăng nhập vào trang này!');
                $authUser = $this->findOrCreateStudent($users);
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
                return redirect()->intended('dang-nhap')->with('fail', 'Vui lòng đăng nhập bằng tài khoản giảng viên VLU!');
            }
        } else if (isset($_GET['error']) == 'access_denied') {
            return redirect()->intended('dang-nhap')->with('fail', 'Bạn cần cho phép ứng dụng để tiếp tục truy cập');
        }
    }

    public function findOrCreateUser($users)
    {
        //cheat account student
        $email = $users->email;
        $splitEmail = explode('@', $email);
        if ($splitEmail[0] == 'dat.187pm06566' || $splitEmail[0] == 'tin.187pm14021') {
            $splitEmail[1] = 'vlu.edu.vn';
            $users->email = $splitEmail[0] . '@' . $splitEmail[1];
        }

        $authUser = Lecturer::where('tbl_lecturer.lecturer_email', $users->email)->first();
        if ($authUser) {
            return $authUser;
        } else {
            $last_name = $users->surname;
            $splitLastName = explode(' - ', $last_name);

            $social_gg = new Lecturer([
                'lecturer_email' => $users->email,
                'lecturer_fullname' => $users->givenName . ' ' . $splitLastName[0],
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
        if (isset($_GET['code']) != null) {
            $users = Socialite::driver('microsoft')->user();

            $email = $users->email;
            $splitEmail = explode('@', $email);

            if ($splitEmail[1] == 'vanlanguni.vn') {
                $authUser = $this->findOrCreateStudent($users);
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
            } else if ($splitEmail[1] == 'vlu.edu.vn') {
                return redirect()->intended('/dang-nhap')->with('fail', 'Tài khoản giảng viên không thể đăng nhập vào trang sinh viên');
            } else {
                return redirect()->intended('/dang-nhap')->with('fail', 'Vui lòng đăng nhập bằng tài khoản sinh viên VLU');
            }
        } else if (isset($_GET['error']) == 'access_denied') {
            return redirect()->intended('/dang-nhap')->with('fail', 'Bạn cần cho phép ứng dụng để tiếp tục truy cập');
        }
    }

    public function findOrCreateStudent($users)
    {
        $authUser = Student::where('tbl_student.student_email', $users->email)->first();
        if ($authUser) {
            return $authUser;
        } else {
            $first_name = $users->givenName;
            $splitFirstName = explode(' - ', $first_name);

            $last_name = $users->surname;
            $splitLastName = explode(' - ', $last_name);

            $code = $splitFirstName[0];
            $first = $splitFirstName[1];
            $last = $splitLastName[0];

            $social_gg = new Student([
                'student_email' => $users->email,
                'student_fullname' => $first . ' ' . $last,
                'student_code' => $code
            ]);
            $social_gg->save();
            return $social_gg;
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

    public function sum_lastmonth()
    {
        $headmonthlast = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->startOfMonth()->toDateString();
        $backmonthlast = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->endOfMonth()->toDateString();
        $visitor_lastmonth = Visitor::whereBetween('visitor_date', [$headmonthlast, $backmonthlast])->get();
        return VisitorResource::collection($visitor_lastmonth);
    }

    public function sum_thismonth()
    {
        $headmonthnow = Carbon::now('Asia/Ho_Chi_Minh')->startOfMonth()->toDateString();
        $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
        $visitor_thismonth = Visitor::whereBetween('visitor_date', [$headmonthnow, $now])->get();
        return VisitorResource::collection($visitor_thismonth);
    }

    public function sum_year()
    {
        $sub365days = Carbon::now('Asia/Ho_Chi_Minh')->subdays(365)->toDateString();
        $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
        $visitor_oneyear = Visitor::whereBetween('visitor_date', [$sub365days, $now])->get();
        return VisitorResource::collection($visitor_oneyear);
    }

    public function sum_visitor()
    {
        $visitors = Visitor::all();
        return VisitorResource::collection($visitors);
    }
}
