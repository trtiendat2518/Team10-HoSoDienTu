<?php

namespace App\Http\Controllers\Admin\Education;

use App\Http\Controllers\Controller;
use App\Models\Faculty;
use Illuminate\Http\Request;
use App\Http\Resources\FacultyResource;
use Validator;
use Session;

class FacultyController extends Controller
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
     * Search the resource in the list.
     *
     * @return \Illuminate\Http\Response
     */
    public function search($query, $currentEntries)
    {
        return FacultyResource::collection(Faculty::where('faculty_code','LIKE','%'.$query.'%')->orwhere('faculty_name','LIKE','%'.$query.'%')->orderby('faculty_id','DESC')->paginate($currentEntries));
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
            'faculty_code' => ['required', 'max:3', 'min:2', 'unique:tbl_faculty', 'notspecial_spaces'],
            'faculty_name' => ['required', 'max:50', 'min:7', 'unique:tbl_faculty', 'notspecial_spaces'],
            'faculty_status' => ['required'],
        ],[
            'faculty_code.required' => 'Mã Khoa không dược để trống!',
            'faculty_code.max' => 'Mã Khoa không nhập quá 3 ký tự chữ!',
            'faculty_code.min' => 'Mã Khoa phải có 2 ký tự chữ trở lên!',
            'faculty_code.unique' => 'Mã Khoa đã tồn tại!',
            'faculty_code.notspecial_spaces' => 'Mã Khoa không được chứa ký tự đặc biệt!',

            'faculty_name.required' => 'Tên Khoa không dược để trống!',
            'faculty_name.max' => 'Tên Khoa không nhập quá 50 ký tự chữ!',
            'faculty_name.min' => 'Tên Khoa phải có 7 ký tự chữ trở lên!',
            'faculty_name.unique' => 'Tên Khoa đã tồn tại!',
            'faculty_name.notspecial_spaces' => 'Tên Khoa không được chứa ký tự đặc biệt!',

            'faculty_status.required' => 'Vui lòng chọn trạng thái cho Khoa này!'
        ]);

        $faculty = new Faculty();
        $faculty->faculty_code = $data['faculty_code'];
        $faculty->faculty_name = $data['faculty_name'];
        $faculty->faculty_status = $data['faculty_status'];
        $faculty->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Faculty  $faculty
     * @return \Illuminate\Http\Response
     */
    public function show($currentEntries)
    {
        return FacultyResource::collection(Faculty::orderby('faculty_id','DESC')->paginate($currentEntries));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Faculty  $faculty
     * @return \Illuminate\Http\Response
     */
    public function edit(Faculty $faculty)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Faculty  $faculty
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $faculty)
    {
        $fac = Faculty::find($faculty);

        $data = $request->validate([
            'faculty_name' => ['required', 'max:50', 'min:7', 'notspecial_spaces'],
        ],[
            'faculty_name.required' => 'Tên Khoa không dược để trống!',
            'faculty_name.max' => 'Tên Khoa không nhập quá 50 ký tự chữ!',
            'faculty_name.min' => 'Tên Khoa phải có 7 ký tự chữ trở lên!',
            'faculty_name.notspecial_spaces' => 'Tên Khoa không được chứa ký tự đặc biệt!',
        ]);

        $fac->faculty_name = $data['faculty_name'];
        $fac->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Faculty  $faculty
     * @return \Illuminate\Http\Response
     */
    public function destroy(Faculty $faculty)
    {
        //
    }
}
