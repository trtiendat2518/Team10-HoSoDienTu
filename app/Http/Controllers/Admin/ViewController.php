<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lecturer;
use Session;

class ViewController extends Controller
{
    public function lecturer_manage(Request $request)
    {
        //---SEO
        $meta_title = "Quản lý tài khoản";
        $meta_desc = "Quản lý tài khoản giảng viên";
        $url_canonical = $request->url();
        //------
        
        $check_role = Lecturer::where('lecturer_code', Session::get('lecturer_id'))->limit(1)->get();

        return view('admin.pages.users.lecturer_manage')->with(compact('meta_title', 'meta_desc', 'url_canonical', 'check_role'));
    }

    public function student_manage(Request $request)
    {
        //---SEO
        $meta_title = "Quản lý sinh viên";
        $meta_desc = "Quản lý tài khoản sinh viên";
        $url_canonical = $request->url();
        //------
        
        $check_role = Lecturer::where('lecturer_code', Session::get('lecturer_id'))->limit(1)->get();

        return view('admin.pages.users.student_manage')->with(compact('meta_title', 'meta_desc', 'url_canonical', 'check_role'));
    }

    public function faculty_manage(Request $request)
    {
        //---SEO
        $meta_title = "Quản lý chung";
        $meta_desc = "Quản lý khoa";
        $url_canonical = $request->url();
        //------
        
        $check_role = Lecturer::where('lecturer_code', Session::get('lecturer_id'))->limit(1)->get();

        return view('admin.pages.education.faculty_manage')->with(compact('meta_title', 'meta_desc', 'url_canonical', 'check_role'));
    }

    public function major_manage(Request $request)
    {
        //---SEO
        $meta_title = "Quản lý chung";
        $meta_desc = "Quản lý chuyên ngành";
        $url_canonical = $request->url();
        //------
        
        $check_role = Lecturer::where('lecturer_code', Session::get('lecturer_id'))->limit(1)->get();

        return view('admin.pages.education.major_manage')->with(compact('meta_title', 'meta_desc', 'url_canonical', 'check_role'));
    }

    public function course_manage(Request $request)
    {
        //---SEO
        $meta_title = "Quản lý chung";
        $meta_desc = "Quản lý khóa học";
        $url_canonical = $request->url();
        //------
        
        $check_role = Lecturer::where('lecturer_code', Session::get('lecturer_id'))->limit(1)->get();

        return view('admin.pages.education.course_manage')->with(compact('meta_title', 'meta_desc', 'url_canonical', 'check_role'));
    }
}
