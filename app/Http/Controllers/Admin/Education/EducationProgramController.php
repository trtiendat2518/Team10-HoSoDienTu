<?php

namespace App\Http\Controllers\Admin\Education;

use App\Http\Controllers\Controller;
use App\Models\EducationProgram;
use App\Models\ProgramDetail;
use App\Models\Subject;
use App\Models\Lecturer;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
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
        $edu_program = EducationProgram::join('tbl_lecturer', 'tbl_lecturer.lecturer_faculty', '=', 'tbl_education_program.education_program_faculty')
            ->join('tbl_course', 'tbl_course.course_id', '=', 'tbl_education_program.education_program_course')
            ->join('tbl_faculty', 'tbl_faculty.faculty_id', '=', 'tbl_education_program.education_program_faculty')
            ->where('tbl_lecturer.lecturer_id', $lecturer_id)->orderby('education_program_id', 'DESC')->paginate($currentEntries);
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
        ], [
            'education_program_code.required' => 'M?? CT??T kh??ng ???????c ????? tr???ng!',
            'education_program_code.max' => 'M?? CT??T kh??ng nh???p qu?? 10 k?? t???!',
            'education_program_code.unique' => 'M?? CT??T ???? t???n t???i!',
            'education_program_code.notspecial_spaces' => 'M?? CT??T kh??ng ???????c ch???a k?? t??? ?????c bi???t!',

            'education_program_year.required' => 'N??m ????o t???o kh??ng ???????c ????? tr???ng!',
            'education_program_year.max' => 'N??m ????o t???o kh??ng nh???p qu?? 100 k?? t???!',

            'education_program_type.required' => 'Vui l??ng ch???n h??? ????o t???o!',
            'education_program_course.required' => 'Vui l??ng ch???n kh??a h???c!',
            'education_program_status.required' => 'Vui l??ng ch???n tr???ng th??i!',

            'file_data.required' => 'Vui l??ng kh??ng ????? tr???ng file!',
            'file_data.file' => 'Vui l??ng nh???p t???p Excel ????? import!',
            'file_data.mimes' => 'Vui l??ng nh???p t???p Excel ????? import!',
        ]);

        $program = new EducationProgram();
        $program->education_program_code = $data['education_program_code'];
        $program->education_program_type = $data['education_program_type'];
        $program->education_program_course = $data['education_program_course'];
        $program->education_program_year = $data['education_program_year'];
        $program->education_program_faculty = $request->education_program_faculty;
        $program->education_program_status = $data['education_program_status'];
        $program_code = $data['education_program_code'];

        $path1 = $request->file('file_data')->store('temp');
        $path = storage_path('app') . '/' . $path1;
        $import = Excel::import(new ProgramDetailImport($program_code), $path);
        $sum = 0;

        if ($import) {
            $program->save();
            $find = ProgramDetail::where('program_detail_code', $program_code)->get();
            foreach ($find as $key => $value) {
                $subject = Subject::where('subject_code', $value->program_detail_subject)->get();
                foreach ($subject as $key => $value2) {
                    $sum += $value2->subject_credit;
                    $education = EducationProgram::where('education_program_code', $program_code)->get();
                    foreach ($education as $key => $value3) {
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
        ], [
            'education_program_year.required' => 'N??m ????o t???o kh??ng ???????c ????? tr???ng!',
            'education_program_year.max' => 'N??m ????o t???o kh??ng nh???p qu?? 100 k?? t???!',
            'education_program_type.required' => 'Vui l??ng ch???n h??? ????o t???o!',
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

    public function destroyall(Request $request)
    {
        $data = $request->validate([
            'educationProgram' => ['required']
        ], [
            'educationProgram.required' => 'Vui l??ng ch???n CT??T mu???n xo??!'
        ]);

        foreach ($data['educationProgram'] as $id) {
            $eduPro = EducationProgram::find($id);
            $eduDetail = ProgramDetail::where('program_detail_code', $eduPro->education_program_code)->get();
            foreach ($eduDetail as $key => $value) {
                $value->delete();
            }
            EducationProgram::where('education_program_id', $id)->delete();
        }
    }

    public function change(Request $request, $educationProgram)
    {
        $pro = EducationProgram::find($educationProgram);
        if ($pro->education_program_status == 0) {
            $pro->education_program_status = 1;
            $pro->save();
        } else {
            $pro->education_program_status = 0;
            $pro->save();
        }
    }

    public function program_one(Request $request, $education_program_id)
    {
        $join = EducationProgram::join('tbl_program_type', 'tbl_program_type.program_type_id', '=', 'tbl_education_program.education_program_type')
            ->join('tbl_faculty', 'tbl_faculty.faculty_id', '=', 'tbl_education_program.education_program_faculty')
            ->join('tbl_course', 'tbl_course.course_id', '=', 'tbl_education_program.education_program_course')
            ->where('education_program_id', $education_program_id)->orderby('education_program_id', 'DESC')->get();
        return EducationProgramResource::collection($join);
    }

    public function show_subject_program($education_program_id)
    {
        $program = ProgramDetail::join('tbl_education_program', 'tbl_education_program.education_program_code', '=', 'tbl_program_detail.program_detail_code')
            ->join('tbl_subject', 'tbl_subject.subject_code', '=', 'tbl_program_detail.program_detail_subject')
            ->join('tbl_faculty', 'tbl_faculty.faculty_id', '=', 'subject_faculty')
            ->where('tbl_education_program.education_program_id', $education_program_id)
            ->orderby('tbl_program_detail.program_detail_semester', 'ASC')->get();
        return ProgramDetailResource::collection($program);
    }

    public function detail_subject_program($program_detail_id)
    {
        return ProgramDetailResource::collection(ProgramDetail::where('program_detail_id', $program_detail_id)->get());
    }

    public function destroy_subject_program($program_detail_id)
    {
        $del = ProgramDetail::find($program_detail_id);
        $program_code = $del->program_detail_code;
        $sum = 0;
        $delete = $del->delete();
        if ($delete) {
            $find = ProgramDetail::where('program_detail_code', $program_code)->get();
            $count = $find->count();
            if ($count > 0) {
                foreach ($find as $key => $value) {
                    $subject = Subject::where('subject_code', $value->program_detail_subject)->get();
                    foreach ($subject as $key => $value2) {
                        $sum += $value2->subject_credit;
                        $education = EducationProgram::where('education_program_code', $program_code)->get();
                        foreach ($education as $key => $value3) {
                            $value3->education_program_credit = $sum;
                            $value3->save();
                        }
                    }
                }
            } else {
                $education = EducationProgram::where('education_program_code', $program_code)->get();
                foreach ($education as $key => $value3) {
                    $value3->education_program_credit = $sum;
                    $value3->save();
                }
            }
        }
    }

    public function import(Request $request, $education_program_id)
    {
        $sum = 0;
        $find = EducationProgram::find($education_program_id);
        $program_code = $find->education_program_code;
        $request->validate([
            'fileImport' => 'required|file|mimes:xls,xlsx'
        ], [
            'fileImport.required' => 'Vui l??ng kh??ng ????? tr???ng!',
            'fileImport.file' => 'Vui l??ng nh???p t???p Excel ????? import!',
            'fileImport.mimes' => 'Vui l??ng nh???p t???p Excel ????? import!',
        ]);

        $path1 = $request->file('fileImport')->store('temp');
        $path = storage_path('app') . '/' . $path1;
        $data = Excel::import(new ProgramDetailUpdateImport($program_code), $path);

        if ($data) {
            $find = ProgramDetail::where('program_detail_code', $program_code)->get();
            foreach ($find as $key => $value) {
                $subject = Subject::where('subject_code', $value->program_detail_subject)->get();
                foreach ($subject as $key => $value2) {
                    $sum += $value2->subject_credit;
                    $education = EducationProgram::where('education_program_code', $program_code)->get();
                    foreach ($education as $key => $value3) {
                        $value3->education_program_credit = $sum;
                        $value3->save();
                    }
                }
            }
        }
        return response()->json(200);
    }

    public function update_subject_program(Request $request, $program_detail_id)
    {
        $data = $request->validate([
            'subject_semester' => ['required', 'max:10'],
            // 'program_detail_lecturer' => 'required|max:100',
            // 'program_detail_calendar' => 'required|max:255',
            // 'program_detail_start' => 'required',
            // 'program_detail_end' => 'required',
        ], [
            'subject_semester.required' => 'H???c k??? kh??ng d?????c ????? tr???ng!',
            'subject_semester.max' => 'H???c k??? kh??ng nh???p qu?? 10 k?? t???!',

            // 'program_detail_lecturer.required' => 'T??n gi???ng vi??n kh??ng d?????c ????? tr???ng!',
            // 'program_detail_lecturer.max' => 'T??n gi???ng vi??n kh??ng nh???p qu?? 100 k?? t???!',

            // 'program_detail_calendar.required' => 'L???ch h???c kh??ng d?????c ????? tr???ng!',
            // 'program_detail_calendar.max' => 'L???ch h???c kh??ng nh???p qu?? 255 k?? t???!',

            // 'program_detail_start.required' => 'Ng??y b???t ?????u kh??ng d?????c ????? tr???ng!',
            // 'program_detail_end.required' => 'Ng??y k???t th??c kh??ng d?????c ????? tr???ng!',
        ]);

        $program = ProgramDetail::find($program_detail_id);
        $program->program_detail_semester = $data['subject_semester'];
        $program->program_detail_note = $request->subject_major;
        // $program->program_detail_calendar = $data['program_detail_calendar'];
        // $program->program_detail_lecturer = $data['program_detail_lecturer'];
        // $program->program_detail_start = $data['program_detail_start'];
        // $program->program_detail_end = $data['program_detail_end'];
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

    public function education_program_lecturer($course, $lecturer_id)
    {
        $find = Lecturer::find($lecturer_id);
        $joins = ProgramDetail::join('tbl_education_program', 'tbl_education_program.education_program_code', '=', 'tbl_program_detail.program_detail_code')
            ->join('tbl_course', 'tbl_course.course_id', '=', 'tbl_education_program.education_program_course')
            ->join('tbl_lecturer', 'tbl_lecturer.lecturer_faculty', '=', 'tbl_education_program.education_program_faculty')
            ->where('tbl_course.course_id', $course)
            ->where('tbl_lecturer.lecturer_id', $lecturer_id)->get();

        return ProgramDetailResource::collection($joins);
    }

    public function education_program_calendar($course, $lecturer_id, $semester)
    {
        $find = Lecturer::find($lecturer_id);
        $joins = ProgramDetail::join('tbl_education_program', 'tbl_education_program.education_program_code', '=', 'tbl_program_detail.program_detail_code')
            ->join('tbl_course', 'tbl_course.course_id', '=', 'tbl_education_program.education_program_course')
            ->join('tbl_lecturer', 'tbl_lecturer.lecturer_faculty', '=', 'tbl_education_program.education_program_faculty')
            ->join('tbl_subject', 'tbl_subject.subject_code', '=', 'tbl_program_detail.program_detail_subject')
            ->where('tbl_course.course_id', $course)
            ->where('tbl_program_detail.program_detail_semester', $semester)
            ->where('tbl_lecturer.lecturer_id', $lecturer_id)->get();

        return ProgramDetailResource::collection($joins);
    }
}
