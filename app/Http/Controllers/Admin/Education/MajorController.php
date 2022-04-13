<?php

namespace App\Http\Controllers\Admin\Education;

use App\Http\Controllers\Controller;
use App\Models\Major;
use Illuminate\Http\Request;
use App\Http\Resources\MajorResource;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MajorExport;
use App\Imports\MajorImport;
use Validator;

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
        ], [
            'major_code.required' => 'Mã Chuyên Ngành không được để trống!',
            'major_code.max' => 'Mã Chuyên Ngành không nhập quá 10 ký tự chữ!',
            'major_code.min' => 'Mã Chuyên Ngành phải có 2 ký tự chữ trở lên!',
            'major_code.unique' => 'Mã Chuyên Ngành đã tồn tại!',
            'major_code.notspecial_spaces' => 'Mã Chuyên Ngành không được chứa ký tự đặc biệt!',

            'major_name.required' => 'Tên Chuyên Ngành không được để trống!',
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
        $joins = Major::join('tbl_faculty', 'tbl_faculty.faculty_id', '=', 'tbl_major.major_faculty')->orderby('major_id', 'DESC')->paginate($currentEntries);
        return MajorResource::collection($joins);
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
            'major_name' => [
                'required',
                'max:50',
                'min:5',
                'notspecial_spaces',
                "unique:tbl_major,major_name,$major,major_id"
            ],
            'major_faculty' => ['required'],
        ], [
            'major_name.required' => 'Tên Chuyên Ngành không được để trống!',
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
        return MajorResource::collection(Major::where('major_code', 'LIKE', '%' . $query . '%')->orwhere('major_name', 'LIKE', '%' . $query . '%')->orderby('major_id', 'DESC')->paginate($currentEntries));
    }

    public function major()
    {
        return MajorResource::collection(Major::orderby('major_name', 'DESC')->get());
    }

    public function destroyall(Request $request, $major = null)
    {
        if ($request->major) {
            foreach ($request->major as $id) {
                Major::where('major_id', $id)->delete();
            }
        }
    }

    public function change(Request $request, $major)
    {
        $mj = Major::find($major);
        if ($mj->major_status == 0) {
            $mj->major_status = 1;
            $mj->save();
        } else {
            $mj->major_status = 0;
            $mj->save();
        }
    }

    public function filter($faculty, $currentEntries)
    {
        return MajorResource::collection(Major::where('major_faculty', '=', $faculty)->orderby('major_name', 'DESC')->paginate($currentEntries));
    }

    public function detail($major)
    {
        $joins = Major::join('tbl_faculty', 'tbl_faculty.faculty_id', '=', 'tbl_major.major_faculty')->where('tbl_major.major_id', $major)->orderby('major_id', 'DESC')->get();
        return MajorResource::collection($joins);
    }

    public function export(Request $request)
    {
        return Excel::download(new MajorExport, 'list_of_major.xlsx');
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
        $path1 = $request->file('fileImport')->store('temp');
        $path = storage_path('app') . '/' . $path1;
        $data = Excel::import(new MajorImport, $path);
        return response()->json(200);
    }

    public function lecturer_major($lecturer_id)
    {
        $joins = Major::join('tbl_lecturer', 'tbl_lecturer.lecturer_faculty', '=', 'tbl_major.major_faculty')
            ->where('tbl_lecturer.lecturer_id', $lecturer_id)->get();
        return MajorResource::collection($joins);
    }

    public function major_faculty($faculty_id)
    {
        $joins = Major::where('major_faculty', $faculty_id)->orderby('major_id', 'DESC')->get();
        return MajorResource::collection($joins);
    }
}
