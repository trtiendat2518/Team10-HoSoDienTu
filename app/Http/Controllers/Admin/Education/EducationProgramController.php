<?php

namespace App\Http\Controllers\Admin\Education;

use App\Http\Controllers\Controller;
use App\Models\EducationProgram;
use App\Models\ProgramDetail;
use Illuminate\Http\Request;
use Excel;
use App\Imports\ProgramDetailImport;
use App\Http\Resources\EducationProgramResource;

class EducationProgramController extends Controller
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

    public function showdata($lecturer_id, $currentEntries)
    {
        $edu_program = EducationProgram::join('tbl_lecturer','tbl_lecturer.lecturer_faculty','=','tbl_education_program.education_program_faculty')->where('tbl_lecturer.lecturer_code',$lecturer_id)->orderby('education_program_course', 'ASC')->paginate($currentEntries);
        return EducationProgramResource::collection($edu_program);
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
            'education_program_code' => ['required', 'max:10', 'unique:tbl_education_program', 'notspecial_spaces'],
            'education_program_type' => ['required'],
            'education_program_course' => ['required'],
            'education_program_year' => ['required', 'max:10'],
            'education_program_status' => ['required'],
            'file_data' => ['required', 'file', 'mimes:xls,xlsx'],
        ],[
            'education_program_code.required' => 'Mã CTĐT không dược để trống!',
            'education_program_code.max' => 'Mã CTĐT không nhập quá 10 ký tự!',
            'education_program_code.unique' => 'Mã CTĐT đã tồn tại!',
            'education_program_code.notspecial_spaces' => 'Mã CTĐT không được chứa ký tự đặc biệt!',

            'education_program_year.required' => 'Năm đào tạo không dược để trống!',
            'education_program_year.max' => 'Năm đào tạo không nhập quá 100 ký tự!',

            'education_program_type.required' => 'Vui lòng chọn hệ đào tạo!',
            'education_program_course.required' => 'Vui lòng chọn khóa học!',
            'education_program_status.required' => 'Vui lòng chọn trạng thái!',

            'file_data.required' => 'Vui lòng không để trống file!',
            'file_data.file' => 'Vui lòng nhập tệp Excel để import!',
            'file_data.mimes' => 'Vui lòng nhập tệp Excel để import!',
        ]);

        $program = new EducationProgram();
        $program->education_program_code = $data['education_program_code'];
        $program->education_program_type = $data['education_program_type'];
        $program->education_program_course = $data['education_program_course'];
        $program->education_program_year = $data['education_program_year'];
        $program->education_program_faculty = $request->education_program_faculty;
        $program->education_program_status = $data['education_program_status'];
        $save = $program->save();
        $program_code = $data['education_program_code'];
        $path = $request->file('file_data')->getRealPath();
        $import = Excel::import(new ProgramDetailImport($program_code), $path);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EducationProgram  $educationProgram
     * @return \Illuminate\Http\Response
     */
    public function show(EducationProgram $educationProgram)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EducationProgram  $educationProgram
     * @return \Illuminate\Http\Response
     */
    public function edit(EducationProgram $educationProgram)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EducationProgram  $educationProgram
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EducationProgram $educationProgram)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EducationProgram  $educationProgram
     * @return \Illuminate\Http\Response
     */
    public function destroy($educationProgram)
    {
        $pro = EducationProgram::find($educationProgram);
        $pro->delete();
    }

    public function filter_course($course, $currentEntries)
    {
        return EducationProgramResource::collection(EducationProgram::where('education_program_course','LIKE','%'.$course.'%')->orderby('education_program_id','DESC')->paginate($currentEntries));
    }

    public function filter_major($major, $currentEntries)
    {
        return EducationProgramResource::collection(EducationProgram::where('education_program_major','LIKE','%'.$major.'%')->orderby('education_program_id','DESC')->paginate($currentEntries));
    }

    public function destroyall(Request $request, $educationProgram = null)
    {
        if ($request->educationProgram) {
            foreach ($request->educationProgram as $id) {
                EducationProgram::where('education_program_id', $id)->delete();
            }
        }
    }

    public function change(Request $request, $educationProgram)
    {
        $pro = EducationProgram::find($educationProgram);
        if($pro->education_program_status==0){
            $pro->education_program_status=1;
            $pro->save();
        }else{
            $pro->education_program_status=0;
            $pro->save();
        }
    }
}
