<?php

namespace App\Http\Controllers\Admin\Education;

use App\Http\Controllers\Controller;
use App\Models\Faculty;
use Illuminate\Http\Request;
use App\Http\Resources\FacultyResource;
use Excel;
use App\Exports\FacultyExport;
use App\Imports\FacultyImport;
use Validator;

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
        return FacultyResource::collection(Faculty::where('faculty_code', 'LIKE', '%' . $query . '%')->orwhere('faculty_name', 'LIKE', '%' . $query . '%')->orderby('faculty_id', 'DESC')->paginate($currentEntries));
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
        ], [
            'faculty_code.required' => 'Mã Khoa không được để trống!',
            'faculty_code.max' => 'Mã Khoa không nhập quá 3 ký tự chữ!',
            'faculty_code.min' => 'Mã Khoa phải có 2 ký tự chữ trở lên!',
            'faculty_code.unique' => 'Mã Khoa đã tồn tại!',
            'faculty_code.notspecial_spaces' => 'Mã Khoa không được chứa ký tự đặc biệt!',

            'faculty_name.required' => 'Tên Khoa không được để trống!',
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
        return FacultyResource::collection(Faculty::orderby('faculty_id', 'DESC')->paginate($currentEntries));
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
            'faculty_name' => [
                'required',
                'max:50',
                'min:7',
                'notspecial_spaces',
                "unique:tbl_faculty,faculty_name,$faculty,faculty_id"
            ],
        ], [
            'faculty_name.required' => 'Tên Khoa không được để trống!',
            'faculty_name.max' => 'Tên Khoa không nhập quá 50 ký tự chữ!',
            'faculty_name.min' => 'Tên Khoa phải có 7 ký tự chữ trở lên!',
            'faculty_name.notspecial_spaces' => 'Tên Khoa không được chứa ký tự đặc biệt!',
            'faculty_name.unique' => 'Tên Khoa đã tồn tại!',
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
    public function destroy($faculty)
    {
        $fac = Faculty::find($faculty);
        $fac->delete();
    }

    /**
     * Remove all the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyall(Request $request, $faculty = null)
    {
        if ($request->faculty) {
            foreach ($request->faculty as $id) {
                Faculty::where('faculty_id', $id)->delete();
            }
        }
    }

    public function change(Request $request, $faculty)
    {
        $fac = Faculty::find($faculty);
        if ($fac->faculty_status == 0) {
            $fac->faculty_status = 1;
            $fac->save();
        } else {
            $fac->faculty_status = 0;
            $fac->save();
        }
    }

    public function detail($faculty)
    {
        return FacultyResource::collection(Faculty::where('faculty_id', $faculty)->get());
    }

    public function export(Request $request)
    {
        return Excel::download(new FacultyExport, 'list_of_faculty.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'fileImport' => 'required|file|mimes:xls,xlsx'
        ], [
            'fileImport.required' => 'Vui lòng không để trống!',
            'fileImport.file' => 'Vui lòng nhập tệp Excel để import!',
            'fileImport.mimes' => 'Vui lòng nhập tệp Excel để import!',
        ]);
        $path = $request->file('fileImport')->getRealPath();
        $data = Excel::import(new FacultyImport, $path);
        return response()->json(200);
    }

    public function faculty()
    {
        return FacultyResource::collection(Faculty::orderby('faculty_name', 'DESC')->get());
    }
}
