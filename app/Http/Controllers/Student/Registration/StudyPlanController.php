<?php

namespace App\Http\Controllers\Student\Registration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EducationProgram;
use App\Models\RegisterSubject;
use App\Models\PlanSuggest;
use App\Models\RegisterPlan;
use App\Models\Calendar;
use App\Models\Student;
use App\Http\Resources\EducationProgramResource;
use App\Http\Resources\PlanSuggestResource;
use App\Http\Resources\CalendarResource;
use App\Http\Resources\RegisterPlanResource;
use Illuminate\Support\Facades\Mail;

class StudyPlanController extends Controller
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'subject' => ['required'],
        ], [
            'subject.required' => 'Vui lòng chọn môn học!'
        ]);

        $quey = RegisterPlan::join('tbl_subject', 'tbl_subject.subject_id', '=', 'tbl_register_plan.register_plan_program')
            ->where('tbl_register_plan.register_plan_student', $request->student_id)
            ->where('tbl_register_plan.register_plan_semester', $request->semester)->get();

        if ($quey) {
            foreach ($quey as $value) {
                $value->delete();
            }
            foreach ($request->subject as $subject_id) {
                $study_plan = new RegisterPlan();
                $study_plan->register_plan_student = $request->student_id;
                $study_plan->register_plan_program = $subject_id;
                $study_plan->register_plan_semester = $request->semester;
                $study_plan->register_plan_yearstart = $request->yearstart;
                $study_plan->register_plan_yearend = $request->yearstart + 1;
                date_default_timezone_set('Asia/Ho_Chi_Minh');
                $study_plan->register_plan_date = now();
                $study_plan->save();
            }
        } else {
            foreach ($request->subject as $subject_id) {
                $study_plan = new RegisterPlan();
                $study_plan->register_plan_student = $request->student_id;
                $study_plan->register_plan_program = $subject_id;
                $study_plan->register_plan_semester = $request->semester;
                $study_plan->register_plan_yearstart = $request->yearstart;
                $study_plan->register_plan_yearend = $request->yearstart + 1;
                date_default_timezone_set('Asia/Ho_Chi_Minh');
                $study_plan->register_plan_date = now();
                $study_plan->save();
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($student_id)
    {
        $joins = EducationProgram::join('tbl_program_type', 'tbl_program_type.program_type_id', '=', 'tbl_education_program.education_program_type')
            ->join('tbl_program_detail', 'tbl_program_detail.program_detail_code', '=', 'tbl_education_program.education_program_code')
            ->join('tbl_subject', 'tbl_subject.subject_code', '=', 'tbl_program_detail.program_detail_subject')
            ->join('tbl_course', 'tbl_course.course_id', '=', 'tbl_education_program.education_program_course')
            ->join('tbl_faculty', 'tbl_faculty.faculty_id', '=', 'tbl_education_program.education_program_faculty')
            ->join('tbl_student', 'tbl_student.student_course', '=', 'tbl_education_program.education_program_course')
            ->where('tbl_student.student_id', $student_id)
            ->orderBy('tbl_program_detail.program_detail_semester', 'ASC')
            ->get();
        return EducationProgramResource::collection($joins);
    }

    public function showdata($student_id)
    {
        $joins = RegisterSubject::join('tbl_subject', 'tbl_subject.subject_id', '=', 'tbl_register_subject.register_subject_program')
            ->where('tbl_register_subject.register_subject_student', $student_id)
            ->get();
        return EducationProgramResource::collection($joins);
    }

    public function show_suggest_all($student_id)
    {
        $joins = PlanSuggest::join('tbl_plansuggest_detail', 'tbl_plansuggest_detail.plansuggest_detail_ref', '=', 'tbl_plan_suggest.plan_suggest_id')
            ->join('tbl_student', 'tbl_student.student_class', '=', 'tbl_plan_suggest.plan_suggest_class')
            ->where('tbl_student.student_id', $student_id)
            ->where('tbl_plan_suggest.plan_suggest_student', 0)->get();
        return PlanSuggestResource::collection($joins);
    }

    public function show_suggest_only($student_id)
    {
        $joins = PlanSuggest::join('tbl_plansuggest_detail', 'tbl_plansuggest_detail.plansuggest_detail_ref', '=', 'tbl_plan_suggest.plan_suggest_id')
            ->join('tbl_student', 'tbl_student.student_id', '=', 'tbl_plan_suggest.plan_suggest_student')
            ->where('tbl_student.student_id', $student_id)->get();
        return PlanSuggestResource::collection($joins);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function calendar_plan($student_id)
    {
        $find = Student::find($student_id);
        $joins = Calendar::join('tbl_course', 'tbl_course.course_id', '=', 'tbl_calendar.raw')
            ->join('tbl_major', 'tbl_major.major_id', '=', 'tbl_calendar.body')
            ->join('tbl_register_plan', 'tbl_register_plan.register_plan_semester', '=', 'tbl_calendar.location')
            ->join('tbl_student', 'tbl_student.student_id', '=', 'tbl_register_plan.register_plan_student')
            ->join('tbl_class', 'tbl_class.class_id', '=', 'tbl_student.student_class')
            ->join('tbl_faculty', 'tbl_faculty.faculty_id', '=', 'tbl_student.student_faculty')
            ->join('tbl_subject', 'tbl_subject.subject_id', '=', 'tbl_register_plan.register_plan_program')
            ->where('tbl_course.course_id', $find->student_course)
            ->where('tbl_major.major_id', $find->student_major)
            ->where('tbl_register_plan.register_plan_student', $student_id)
            ->where('tbl_calendar.calendarId', 0)->get();

        return CalendarResource::collection($joins);
    }

    public function calendar_timeplan($student_id)
    {
        $find = Student::find($student_id);
        $joins = Calendar::join('tbl_course', 'tbl_course.course_id', '=', 'tbl_calendar.raw')
            ->join('tbl_major', 'tbl_major.major_id', '=', 'tbl_calendar.body')
            ->where('tbl_course.course_id', $find->student_course)
            ->where('tbl_major.major_id', $find->student_major)
            ->where('tbl_calendar.calendarId', 0)->get();

        return CalendarResource::collection($joins);
    }

    public function my_plan($student_id, $semester)
    {
        $query = RegisterPlan::join('tbl_subject', 'tbl_subject.subject_id', '=', 'tbl_register_plan.register_plan_program')
            ->where('register_plan_student', $student_id)->where('register_plan_semester', $semester)->get();
        return RegisterPlanResource::collection($query);
    }

    public function my_all_plan($student_id)
    {
        $query = RegisterPlan::join('tbl_subject', 'tbl_subject.subject_id', '=', 'tbl_register_plan.register_plan_program')
            ->where('register_plan_student', $student_id)->get();
        return RegisterPlanResource::collection($query);
    }

    public function filter($student_id, $value)
    {
        $query = RegisterPlan::join('tbl_subject', 'tbl_subject.subject_id', '=', 'tbl_register_plan.register_plan_program')
            ->where('register_plan_student', $student_id)
            ->where('register_plan_semester', $value)->get();
        return RegisterPlanResource::collection($query);
    }

    public function send_mail($student_id, $semester)
    {
        $student = Student::find($student_id);
        $query = RegisterPlan::join('tbl_subject', 'tbl_subject.subject_id', '=', 'tbl_register_plan.register_plan_program')
            ->where('tbl_register_plan.register_plan_student', $student_id)
            ->where('tbl_register_plan.register_plan_semester', $semester)->get();

        $to_name = "BCN Khoa CNTT";
        $to_email = $student->student_email;
        $student_fullname = $student->student_fullname;
        $student_code = $student->student_code;

        Mail::send(
            'student.pages.mail.study_plan_mail',
            ['quey' => $query],
            function ($message) use ($to_name, $to_email, $student_fullname, $student_code) {
                $message->to($to_email)->subject('Kết quả đăng ký kế hoạch học tập của ' . $student_fullname . '-' . $student_code);
                $message->from($to_email, $to_name);
            }
        );
    }
}
