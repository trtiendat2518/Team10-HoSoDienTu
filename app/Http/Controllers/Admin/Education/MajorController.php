<?php

namespace App\Http\Controllers\Admin\Education;

use App\Http\Controllers\Controller;
use App\Models\Major;
use App\Models\Faculty;
use Illuminate\Http\Request;
use App\Http\Resources\MajorResource;
use App\Http\Resources\FacultyResource;
use Excel;
use App\Exports\MajorExport;
use App\Imports\MajorImport;
use Validator;
use Session;

class MajorController extends Controller
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
            'major_code' => ['required', 'max:10', 'min:2', 'unique:tbl_major', 'notspecial_spaces'],
            'major_name' => ['required', 'max:50', 'min:5', 'unique:tbl_major', 'notspecial_spaces'],
            'major_faculty' => ['required'],
            'major_status' => ['required'],
        ],[
            'major_code.required' => 'Mã Chuyên Ngành không dược để trống!',
            'major_code.max' => 'Mã Chuyên Ngành không nhập quá 10 ký tự chữ!',
            'major_code.min' => 'Mã Chuyên Ngành phải có 2 ký tự chữ trở lên!',
            'major_code.unique' => 'Mã Chuyên Ngành đã tồn tại!',
            'major_code.notspecial_spaces' => 'Mã Chuyên Ngành không được chứa ký tự đặc biệt!',

            'major_name.required' => 'Tên Chuyên Ngành không dược để trống!',
            'major_name.max' => 'Tên Chuyên Ngành không nhập quá 50 ký tự chữ!',
            'major_name.min' => 'Tên Chuyên Ngành phải có 5 ký tự chữ trở lên!',
            'major_name.unique' => 'Tên Chuyên Ngành đã tồn tại!',
            'major_name.notspecial_spaces' => 'Tên Chuyên Ngành không được chứa ký tự đặc biệt!',

            'major_faculty.required' => 'Vui lòng chọn Khoa cho Chuyên Ngành!',
            'major_status.required' => 'Vui lòng chọn trạng thái cho Chuyên Ngành này!'
        ]);

        $major = new Major();
        $major->major_code = $data['major_code'];
        $major->major_name = $data['major_name'];
        $major->major_faculty = $data['major_faculty'];
        $major->major_status = $data['major_status'];
        $major->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Major  $major
     * @return \Illuminate\Http\Response
     */
    public function show($currentEntries)
    {
        return MajorResource::collection(Major::orderby('major_id','DESC')->paginate($currentEntries));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Major  $major
     * @return \Illuminate\Http\Response
     */
    public function edit(Major $major)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Major  $major
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $major)
    {
        $mj = Major::find($major);

        $data = $request->validate([
            'major_name' => ['required', 'max:50', 'min:5', 'notspecial_spaces'],
            'major_faculty' => ['required'],
        ],[
            'major_name.required' => 'Tên Chuyên Ngành không dược để trống!',
            'major_name.max' => 'Tên Chuyên Ngành không nhập quá 50 ký tự chữ!',
            'major_name.min' => 'Tên Chuyên Ngành phải có 5 ký tự chữ trở lên!',
            'major_name.unique' => 'Tên Chuyên Ngành đã tồn tại!',
            'major_name.notspecial_spaces' => 'Tên Chuyên Ngành không được chứa ký tự đặc biệt!',

            'major_faculty.required' => 'Vui lòng chọn Khoa cho Chuyên Ngành!',
        ]);

        $mj->major_name = $data['major_name'];
        $mj->major_faculty = $data['major_faculty'];
        $mj->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Major  $major
     * @return \Illuminate\Http\Response
     */
    public function destroy($major)
    {
        $mj = Major::find($major);
        $mj->delete();
    }

    public function search($query, $currentEntries)
    {
        return MajorResource::collection(Major::where('major_code','LIKE','%'.$query.'%')->orwhere('major_name','LIKE','%'.$query.'%')->orderby('major_id','DESC')->paginate($currentEntries));
    }

    public function faculty()
    {
        return FacultyResource::collection(Faculty::where('faculty_status',0)->orderby('faculty_name','DESC')->get());
    }

    public function destroyall(Request $request, $major = null)
    {
        if ($request->major) {
            foreach ($request->major as $id) {
                Major::where('major_id', $id)->delete();
            }
        }
    }
}
