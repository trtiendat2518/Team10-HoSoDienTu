<?php

namespace App\Http\Controllers\Admin\Education;

use App\Http\Controllers\Controller;
use App\Models\ProgramType;
use Illuminate\Http\Request;
use App\Http\Resources\ProgramTypeResource;

class ProgramTypeController extends Controller
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
            'program_type_code' => ['required', 'max:10', 'min:2', 'unique:tbl_program_type'],
            'program_type_name' => ['required', 'max:100', 'min:10', 'unique:tbl_program_type'],
            'program_type_status' => ['required'],
        ],[
            'program_type_code.required' => 'Mã hệ thống đào tạo không dược để trống!',
            'program_type_code.max' => 'Mã hệ thống đào tạo không nhập quá 10 ký tự!',
            'program_type_code.min' => 'Mã hệ thống đào tạo phải có 2 ký tự trở lên!',
            'program_type_code.unique' => 'Mã hệ thống đào tạo đã tồn tại!',

            'program_type_name.required' => 'Tên hệ thống đào tạo không dược để trống!',
            'program_type_name.max' => 'Tên hệ thống đào tạo không nhập quá 100 ký tự!',
            'program_type_name.min' => 'Tên hệ thống đào tạo phải có 10 ký tự trở lên!',
            'program_type_name.unique' => 'Tên hệ thống đào tạo đã tồn tại!',            

            'program_type_status.required' => 'Vui lòng chọn trạng thái cho hệ thống đào tạo này!'
        ]);

        $proType = new ProgramType();
        $proType->program_type_code = $data['program_type_code'];
        $proType->program_type_name = $data['program_type_name'];
        $proType->program_type_status = $data['program_type_status'];
        $proType->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProgramType  $programType
     * @return \Illuminate\Http\Response
     */
    public function show($currentEntries)
    {
        return ProgramTypeResource::collection(ProgramType::orderby('program_type_id','DESC')->paginate($currentEntries));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProgramType  $programType
     * @return \Illuminate\Http\Response
     */
    public function edit(ProgramType $programType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProgramType  $programType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $programType)
    {
        $data = $request->validate([
            'program_type_code' => ['required', 'max:10', 'min:2'],
            'program_type_name' => ['required', 'max:100', 'min:10'],
        ],[
            'program_type_code.required' => 'Mã hệ thống đào tạo không dược để trống!',
            'program_type_code.max' => 'Mã hệ thống đào tạo không nhập quá 10 ký tự!',
            'program_type_code.min' => 'Mã hệ thống đào tạo phải có 2 ký tự trở lên!',

            'program_type_name.required' => 'Tên hệ thống đào tạo không dược để trống!',
            'program_type_name.max' => 'Tên hệ thống đào tạo không nhập quá 100 ký tự!',
            'program_type_name.min' => 'Tên hệ thống đào tạo phải có 10 ký tự trở lên!',
        ]);

        $proType = ProgramType::find($programType);
        $proType->program_type_code = $data['program_type_code'];
        $proType->program_type_name = $data['program_type_name'];
        $proType->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProgramType  $programType
     * @return \Illuminate\Http\Response
     */
    public function destroy($programType)
    {
        $proType = ProgramType::find($programType);
        $proType->delete();
    }

    public function change(Request $request, $programType)
    {
        $proType = ProgramType::find($programType);
        if($proType->program_type_status==0){
            $proType->program_type_status=1;
            $proType->save();
        }else{
            $proType->program_type_status=0;
            $proType->save();
        }
    }

    public function search($query, $currentEntries)
    {
        return ProgramTypeResource::collection(ProgramType::where('program_type_name','LIKE','%'.$query.'%')->orderby('program_type_name','ASC')->paginate($currentEntries));
    }

    public function destroyall(Request $request, $programType = null)
    {
        if ($request->programType) {
            foreach ($request->programType as $id) {
                ProgramType::where('program_type_id', $id)->delete();
            }
        }
    }

    public function program_type(Request $request)
    {
        return ProgramTypeResource::collection(ProgramType::orderby('program_type_name','ASC')->get());
    }
}
