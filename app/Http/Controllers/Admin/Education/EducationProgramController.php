<?php

namespace App\Http\Controllers\Admin\Education;

use App\Http\Controllers\Controller;
use App\Models\EducationProgram;
use App\Models\ProgramDetail;
use App\Models\Subject;
use Illuminate\Http\Request;
use Excel;
use App\Imports\ProgramDetailImport;
use App\Imports\ProgramDetailUpdateImport;
use App\Http\Resources\EducationProgramResource;
use App\Http\Resources\ProgramDetailResource;

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
        $edu_program = EducationProgram::join('tbl_lecturer','tbl_lecturer.lecturer_faculty','=','tbl_education_program.education_program_faculty')->where('tbl_lecturer.lecturer_code',$lecturer_id)->orderby('education_program_id', 'DESC')->paginate($currentEntries);
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
            'education_program_code.required' => 'Mã CTĐT không được để trống!',
            'education_program_code.max' => 'Mã CTĐT không nhập quá 10 ký tự!',
            'education_program_code.unique' => 'Mã CTĐT đã tồn tại!',
            'education_program_code.notspecial_spaces' => 'Mã CTĐT không được chứa ký tự đặc biệt!',

            'education_program_year.required' => 'Năm đào tạo không được để trống!',
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
        $sum = 0;
        
        if ($import) {
            $find = ProgramDetail::where('program_detail_code', $program_code)->get();
            foreach($find as $key => $value) {
                $subject = Subject::where('subject_code', $value->program_detail_subject)->get();
                foreach($subject as $key => $value2) {
                    $sum += $value2->subject_credit;
                    $education = EducationProgram::where('education_program_code', $program_code)->get();
                    foreach($education as $key => $value3) {
                        $value3->education_program_credit = $sum;
                        $value3->save();
                    }
                }
            }
        }
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
    public function update(Request $request, $educationProgram)
    {
        $data = $request->validate([
            'education_program_type' => ['required'],
            'education_program_year' => ['required', 'max:10'],
        ],[
            'education_program_year.required' => 'Năm đào tạo không được để trống!',
            'education_program_year.max' => 'Năm đào tạo không nhập quá 100 ký tự!',
            'education_program_type.required' => 'Vui lòng chọn hệ đào tạo!',
        ]);

        $program = EducationProgram::find($educationProgram);
        $program->education_program_type = $data['education_program_type'];
        $program->education_program_year = $data['education_program_year'];
        $save = $program->save();
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
        $program_code = $pro->education_program_code;
        $find = ProgramDetail::where('program_detail_code', $program_code)->delete();
        $pro->delete();
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

    public function program_one(Request $request, $education_program_id)
    {
        $join = EducationProgram::join('tbl_program_type', 'tbl_program_type.program_type_code','=','tbl_education_program.education_program_type')->join('tbl_faculty', 'tbl_faculty.faculty_code','=','tbl_education_program.education_program_faculty')->where('education_program_id', $education_program_id)->orderby('education_program_id','DESC')->get();
        return EducationProgramResource::collection($join);
    }

    public function show_subject_program($education_program_id)
    {
        $program = ProgramDetail::join('tbl_education_program','tbl_education_program.education_program_code','=','tbl_program_detail.program_detail_code')->join('tbl_subject','tbl_subject.subject_code','=','tbl_program_detail.program_detail_subject')->join('tbl_faculty', 'tbl_faculty.faculty_code','=','subject_faculty')->where('tbl_education_program.education_program_id',$education_program_id)->orderby('tbl_program_detail.program_detail_semester', 'ASC')->get();
        return ProgramDetailResource::collection($program);
    }

    public function detail_subject_program($program_detail_id)
    {
        return ProgramDetailResource::collection(ProgramDetail::where('program_detail_id', $program_detail_id)->get());
    }

    public function destroy_subject_program($program_detail_id)
    {
        $del = ProgramDetail::find($program_detail_id);
        $delete = $del->delete();
        $program_code = $del->program_detail_code;
        $sum = 0;
        if ($delete) {
            $find = ProgramDetail::where('program_detail_code', $program_code)->get();
            $count = $find->count();
            if ($count > 0) {
                foreach($find as $key => $value) {
                    $subject = Subject::where('subject_code', $value->program_detail_subject)->get();
                    foreach($subject as $key => $value2) {
                        $sum += $value2->subject_credit;
                        $education = EducationProgram::where('education_program_code', $program_code)->get();
                        foreach($education as $key => $value3) {
                            $value3->education_program_credit = $sum;
                            $value3->save();
                        }
                    }
                }
            }else {
                $education = EducationProgram::where('education_program_code', $program_code)->get();
                foreach($education as $key => $value3) {
                    $value3->education_program_credit = $sum;
                    $value3->save();
                }
            }
        }
    }

    public function import(Request $request, $education_program_id)
    {
        $find = EducationProgram::find($education_program_id);
        $program_code = $find->education_program_code;
        $request->validate([
            'fileImport' => 'required|file|mimes:xls,xlsx'
        ],[
            'fileImport.required' => 'Vui lòng không để trống!',
            'fileImport.file' => 'Vui lòng nhập tệp Excel để import!',
            'fileImport.mimes' => 'Vui lòng nhập tệp Excel để import!',
        ]);
        $path = $request->file('fileImport')->getRealPath();
        $data = Excel::import(new ProgramDetailUpdateImport($program_code), $path);
        return response()->json(200);
    }

    public function update_subject_program(Request $request, $program_detail_id)
    {
        $data = $request->validate([
            'subject_semester' => ['required', 'max:10'],
        ],[
            'subject_semester.required' => 'Học kỳ không dược để trống!',
            'subject_semester.max' => 'Học kỳ không nhập quá 10 ký tự!',
        ]);

        $program = ProgramDetail::find($program_detail_id);
        $program->program_detail_semester = $data['subject_semester'];
        $program->program_detail_note = $request->subject_major;
        $program->save();
    }

    public function create_subject_program(Request $request, $program_detail_id = null)
    {
        if ($request->program_detail_id) {
            foreach ($request->program_detail_id as $id) {
                ProgramDetail::where('program_detail_id', $id)->delete();
            }
        }
    }
}
