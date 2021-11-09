<?php

namespace App\Http\Controllers\Admin\Education;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Resources\CourseResource;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'course_code' => ['required', 'max:3', 'min:2', 'unique:tbl_course', 'notspecial_spaces'],
            'course_name' => ['required', 'max:50', 'min:5', 'unique:tbl_course', 'notspecial_spaces'],
            'course_status' => ['required'],
        ],[
            'course_code.required' => 'Mã Khóa Học không dược để trống!',
            'course_code.max' => 'Mã Khóa Học không nhập quá 3 ký tự chữ!',
            'course_code.min' => 'Mã Khóa Học phải có 2 ký tự chữ trở lên!',
            'course_code.unique' => 'Mã Khóa Học đã tồn tại!',
            'course_code.notspecial_spaces' => 'Mã Khóa Học không được chứa ký tự đặc biệt!',

            'course_name.required' => 'Tên Khóa Học không dược để trống!',
            'course_name.max' => 'Tên Khóa Học không nhập quá 50 ký tự chữ!',
            'course_name.min' => 'Tên Khóa Học phải có 5 ký tự chữ trở lên!',
            'course_name.unique' => 'Tên Khóa Học đã tồn tại!',
            'course_name.notspecial_spaces' => 'Tên Khóa Học không được chứa ký tự đặc biệt!',

            'course_status.required' => 'Vui lòng chọn trạng thái cho Khóa học này!'
        ]);

        $course = new Course();
        $course->course_code = $data['course_code'];
        $course->course_name = $data['course_name'];
        $course->course_status = $data['course_status'];
        $course->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show($currentEntries)
    {
        return CourseResource::collection(Course::orderby('course_id', 'DESC')->paginate($currentEntries));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        //
    }

    public function search($query, $currentEntries)
    {
        return CourseResource::collection(Course::where('course_code','LIKE','%'.$query.'%')->orwhere('course_name','LIKE','%'.$query.'%')->orderby('course_id','DESC')->paginate($currentEntries));
    }
}