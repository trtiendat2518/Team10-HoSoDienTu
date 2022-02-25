<?php

namespace App\Http\Controllers\Student\Registration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Calendar;
use App\Models\Student;
use App\Models\CalendarSubject;
use App\Models\ProgramDetail;
use App\Http\Resources\CalendarResource;
use Illuminate\Support\Facades\Mail;

class SubjectController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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

    public function calendar_time_register($student_id)
    {
        $find = Student::find($student_id);
        $joins = Calendar::join('tbl_course', 'tbl_course.course_id', '=', 'tbl_calendar.raw')
            ->join('tbl_major', 'tbl_major.major_id', '=', 'tbl_calendar.body')
            ->where('tbl_course.course_id', $find->student_course)
            ->where('tbl_major.major_id', $find->student_major)
            ->where('tbl_calendar.calendarId', 1)->get();

        return CalendarResource::collection($joins);
    }

    public function show_subject_program($student_id, $semester)
    {
        $find = Student::find($student_id);
        $joins = Calendar::join('tbl_program_detail', 'tbl_program_detail.program_detail_semester', '=', 'tbl_calendar.location')
            ->join('tbl_education_program', 'tbl_education_program.education_program_code', '=', 'tbl_program_detail.program_detail_code')
            ->join('tbl_subject', 'tbl_subject.subject_code', '=', 'tbl_program_detail.program_detail_subject')
            ->join('tbl_student', 'tbl_student.student_course', '=', 'tbl_education_program.education_program_course')
            ->where('tbl_calendar.raw', $find->student_course)
            ->where('tbl_calendar.body', $find->student_major)
            ->where('tbl_calendar.location', $semester)
            ->where('tbl_student.student_id', $student_id)
            ->where('tbl_calendar.calendarId', 1)->get();

        return CalendarResource::collection($joins);
    }

    public function show_subject_inplan($student_id, $semester)
    {
        $joins = Calendar::join('tbl_register_plan', 'tbl_register_plan.register_plan_semester', '=', 'tbl_calendar.location')
            ->join('tbl_subject', 'tbl_subject.subject_id', '=', 'tbl_register_plan.register_plan_program')
            ->join('tbl_student', 'tbl_student.student_id', '=', 'tbl_register_plan.register_plan_student')
            ->where('tbl_calendar.location', $semester)
            ->where('tbl_student.student_id', $student_id)
            ->where('tbl_calendar.calendarId', 1)->get();

        return CalendarResource::collection($joins);
    }

    public function show_subject_outplan($student_id, $semester)
    {
        $find = Student::find($student_id);

        // find subjects in registered plan
        $inplan = Calendar::join('tbl_register_plan', 'tbl_register_plan.register_plan_semester', '=', 'tbl_calendar.location')
            ->join('tbl_subject', 'tbl_subject.subject_id', '=', 'tbl_register_plan.register_plan_program')
            ->join('tbl_student', 'tbl_student.student_id', '=', 'tbl_register_plan.register_plan_student')
            ->where('tbl_calendar.location', $semester)
            ->where('tbl_student.student_id', $student_id)
            ->where('tbl_calendar.calendarId', 1)->get();

        // get all subjecs in education program
        $joins = ProgramDetail::join('tbl_subject', 'tbl_subject.subject_code', '=', 'tbl_program_detail.program_detail_subject')
            ->join('tbl_education_program', 'tbl_education_program.education_program_code', '=', 'tbl_program_detail.program_detail_code')
            ->join('tbl_faculty', 'tbl_faculty.faculty_id', '=', 'tbl_education_program.education_program_faculty')
            ->join('tbl_course', 'tbl_course.course_id', '=', 'tbl_education_program.education_program_course')
            ->where('tbl_faculty.faculty_id', $find->student_faculty)
            ->where('tbl_course.course_id', $find->student_course);

        // except subjects registered plan in education program
        foreach ($inplan as $key => $value) {
            $value->subject_code;
            $joins->where('tbl_program_detail.program_detail_subject', '!=', $value->subject_code);
        }
        $results = $joins->get();

        return CalendarResource::collection($results);
    }

    public function quantity($student_id, $semester)
    {
        $find = Student::find($student_id);
        $joins = CalendarSubject::join('tbl_calendar', 'tbl_calendar.id', '=', 'tbl_calendar_subject.calendar_id')
            ->join('tbl_subject', 'tbl_subject.subject_id', '=', 'tbl_calendar_subject.subject_id')
            ->where('tbl_calendar.location', $semester)
            ->where('tbl_calendar.body', $find->student_major)
            ->where('tbl_calendar.raw', $find->student_course)
            ->where('tbl_calendar.calendarId', 1)->get();
        return CalendarResource::collection($joins);
    }

    public function register_subject($student_id, $semester, $subject_id)
    {
        $find = Student::find($student_id);
        $joins = CalendarSubject::join('tbl_calendar', 'tbl_calendar.id', '=', 'tbl_calendar_subject.calendar_id')
            ->join('tbl_subject', 'tbl_subject.subject_id', '=', 'tbl_calendar_subject.subject_id')
            ->where('tbl_calendar_subject.subject_id', $subject_id)
            ->where('tbl_calendar.location', $semester)
            ->where('tbl_calendar.body', $find->student_major)
            ->where('tbl_calendar.raw', $find->student_course)
            ->where('tbl_calendar.calendarId', 1)->get();
        return CalendarResource::collection($joins);
    }
}
