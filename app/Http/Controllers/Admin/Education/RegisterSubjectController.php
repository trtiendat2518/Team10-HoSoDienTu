<?php

namespace App\Http\Controllers\Admin\Education;

use App\Http\Controllers\Controller;
use App\Models\RegisterSubject;
use App\Models\CalendarSubject;
use Illuminate\Http\Request;
use App\Http\Resources\RegisterSubjectResource;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ScoreImport;
use App\Models\RegisterPlan;
use App\Exports\StatisticSubjectExport;

class RegisterSubjectController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RegisterSubject  $registerSubject
     * @return \Illuminate\Http\Response
     */
    public function show(RegisterSubject $registerSubject)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RegisterSubject  $registerSubject
     * @return \Illuminate\Http\Response
     */
    public function edit(RegisterSubject $registerSubject)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RegisterSubject  $registerSubject
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $registerSubject)
    {
        //$reg = RegisterSubject::find($registerSubject);

        $data = $request->validate([
            'register_subject_exercise' => ['required', 'numeric', 'max:11', 'gte:0', 'lte:10'],
            'register_subject_exam' => ['required', 'numeric', 'max:11', 'gte:0', 'lte:10'],
            'register_subject_final' => ['required', 'numeric', 'max:11', 'gte:0', 'lte:10'],
            'register_subject_second' => ['required', 'numeric', 'max:11', 'gte:0', 'lte:10'],
        ], [
            'register_subject_exercise.required' => '??i???m b??i t???p kh??ng ???????c ????? tr???ng!',
            'register_subject_exercise.max' => '??i???m b??i t???p ch??? ???????c nh???p t??? 0 ?????n 10!',
            'register_subject_exercise.numeric' => '??i???m b??i t???p ph???i l?? k?? t??? s???!',
            'register_subject_exercise.gte' => '??i???m b??i t???p ch??? ???????c nh???p t??? 0 ?????n 10!',
            'register_subject_exercise.lte' => '??i???m b??i t???p ch??? ???????c nh???p t??? 0 ?????n 10!',

            'register_subject_exam.required' => '??i???m ki???m tra kh??ng ???????c ????? tr???ng!',
            'register_subject_exam.max' => '??i???m ki???m tra ch??? ???????c nh???p t??? 0 ?????n 10!',
            'register_subject_exam.numeric' => '??i???m ki???m tra ph???i l?? k?? t??? s???!',
            'register_subject_exam.gte' => '??i???m ki???m tra ch??? ???????c nh???p t??? 0 ?????n 10!',
            'register_subject_exam.lte' => '??i???m ki???m tra ch??? ???????c nh???p t??? 0 ?????n 10!',

            'register_subject_final.required' => '??i???m thi l???n 1 kh??ng ???????c ????? tr???ng!',
            'register_subject_final.max' => '??i???m thi l???n 1 ch??? ???????c nh???p t??? 0 ?????n 10!',
            'register_subject_final.numeric' => '??i???m thi l???n 1 ph???i l?? k?? t??? s???!',
            'register_subject_final.gte' => '??i???m thi l???n 1 ch??? ???????c nh???p t??? 0 ?????n 10!',
            'register_subject_final.lte' => '??i???m thi l???n 1 ch??? ???????c nh???p t??? 0 ?????n 10!',

            'register_subject_second.required' => '??i???m thi l???n 2 kh??ng ???????c ????? tr???ng!',
            'register_subject_second.max' => '??i???m thi l???n 2 ch??? ???????c nh???p t??? 0 ?????n 10!',
            'register_subject_second.numeric' => '??i???m thi l???n 2 ph???i l?? k?? t??? s???!',
            'register_subject_second.gte' => '??i???m thi l???n 2 ch??? ???????c nh???p t??? 0 ?????n 10!',
            'register_subject_second.lte' => '??i???m thi l???n 2 ch??? ???????c nh???p t??? 0 ?????n 10!',
        ]);

        $query = RegisterSubject::join('tbl_calendar_subject', 'tbl_calendar_subject.calendar_subject_id', '=', 'tbl_register_subject.register_subject_program')
            ->join('tbl_subject', 'tbl_subject.subject_id', '=', 'tbl_calendar_subject.subject_id')
            ->join('tbl_student', 'tbl_student.student_id', '=', 'tbl_register_subject.register_subject_student')
            ->where('tbl_register_subject.register_subject_id', $registerSubject)->get();

        foreach ($query as $key => $reg) {
            $reg->register_subject_exercise = $data['register_subject_exercise'];
            $reg->register_subject_exam = $data['register_subject_exam'];
            $reg->register_subject_final = $data['register_subject_final'];
            $reg->register_subject_second = $data['register_subject_second'];

            $scoreExercise = ($reg->register_subject_exercise * $reg->subject_score_exercise) / 100;
            $scoreExam = ($reg->register_subject_exam * $reg->subject_score_exam) / 100;
            if ($reg->register_subject_final >= $reg->register_subject_second) {
                $scoreFinal = ($reg->register_subject_final * $reg->subject_score_final) / 100;
            } else {
                $scoreFinal = ($reg->register_subject_second * $reg->subject_score_final) / 100;
            }
            $sum = $scoreExercise + $scoreExam + $scoreFinal;
            if ($sum > 4) {
                $plan = RegisterPlan::where('register_plan_student', $reg->student_id)
                    ->where('register_plan_program', $reg->subject_id)
                    ->where('register_plan_again', 1)->get();
                foreach ($plan as $key => $value) {
                    $value->register_plan_again = 0;
                    $value->save();
                }

                $change = RegisterSubject::join('tbl_calendar_subject', 'tbl_calendar_subject.calendar_subject_id', '=', 'tbl_register_subject.register_subject_program')
                    ->join('tbl_subject', 'tbl_subject.subject_id', '=', 'tbl_calendar_subject.subject_id')
                    ->where('tbl_subject.subject_id', $reg->subject_id)->count();
                if ($change > 1) {
                    $again = RegisterSubject::join('tbl_calendar_subject', 'tbl_calendar_subject.calendar_subject_id', '=', 'tbl_register_subject.register_subject_program')
                        ->join('tbl_subject', 'tbl_subject.subject_id', '=', 'tbl_calendar_subject.subject_id')
                        ->where('tbl_subject.subject_id', $reg->subject_id)
                        ->orderby('tbl_register_subject.register_subject_id', 'ASC')->first();
                    $again->register_subject_again = 1;
                    $again->save();
                }
            }
        }
        $reg->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RegisterSubject  $registerSubject
     * @return \Illuminate\Http\Response
     */
    public function destroy(RegisterSubject $registerSubject)
    {
        //
    }

    public function score($student_id)
    {
        $joins = RegisterSubject::join('tbl_calendar_subject', 'tbl_calendar_subject.calendar_subject_id', '=', 'tbl_register_subject.register_subject_program')
            ->join('tbl_student', 'tbl_student.student_id', '=', 'tbl_register_subject.register_subject_student')
            ->join('tbl_subject', 'tbl_subject.subject_id', '=', 'tbl_calendar_subject.subject_id')
            ->where('tbl_register_subject.register_subject_student', $student_id)
            ->get();

        return RegisterSubjectResource::collection($joins);
    }

    public function exam_second($student_id)
    {
        $joins = RegisterSubject::join('tbl_calendar_subject', 'tbl_calendar_subject.calendar_subject_id', '=', 'tbl_register_subject.register_subject_program')
            ->join('tbl_student', 'tbl_student.student_id', '=', 'tbl_register_subject.register_subject_student')
            ->join('tbl_subject', 'tbl_subject.subject_id', '=', 'tbl_calendar_subject.subject_id')
            ->where('tbl_register_subject.register_subject_second', 0)
            ->where('tbl_register_subject.register_subject_student', $student_id)
            ->get();

        return RegisterSubjectResource::collection($joins);
    }

    public function import(Request $request, $student_id)
    {
        $request->validate([
            'fileImport' => 'required|file|mimes:xls,xlsx'
        ], [
            'fileImport.required' => 'Vui l??ng kh??ng ????? tr???ng!',
            'fileImport.file' => 'Vui l??ng nh???p t???p Excel ????? import!',
            'fileImport.mimes' => 'Vui l??ng nh???p t???p Excel ????? import!',
        ]);

        $path1 = $request->file('fileImport')->store('temp');
        $path = storage_path('app') . '/' . $path1;
        $data = Excel::import(new ScoreImport($student_id), $path);
        return response()->json(200);
    }

    public function statistic_student_registered($course, $major, $semester)
    {
        $joins = RegisterSubject::join('tbl_student', 'tbl_student.student_id', '=', 'tbl_register_subject.register_subject_student')
            ->join('tbl_calendar_subject', 'tbl_calendar_subject.calendar_subject_id', '=', 'tbl_register_subject.register_subject_program')
            ->join('tbl_subject', 'tbl_subject.subject_id', '=', 'tbl_calendar_subject.subject_id')
            ->where('student_course', $course)->where('student_major', $major)
            ->where('tbl_register_subject.register_subject_semester', $semester)->get();
        return RegisterSubjectResource::collection($joins);
    }

    public function statistic_subject_slot($course, $major, $semester)
    {
        $get = CalendarSubject::join('tbl_calendar', 'tbl_calendar.id', '=', 'tbl_calendar_subject.calendar_id')
            ->where('tbl_calendar.raw', $course)->where('tbl_calendar.body', $major)->where('tbl_calendar.location', $semester)
            ->where('tbl_calendar_subject.calendar_subject_registered', '>', 0)
            ->get();

        $joins = CalendarSubject::join('tbl_calendar', 'tbl_calendar.id', '=', 'tbl_calendar_subject.calendar_id')
            ->join('tbl_subject', 'tbl_subject.subject_id', '=', 'tbl_calendar_subject.subject_id')
            ->where('tbl_calendar.raw', $course)->where('tbl_calendar.body', $major)->where('tbl_calendar.location', $semester)
            ->where('tbl_calendar_subject.calendar_subject_registered', '>', 0);

        foreach ($get as $key => $value) {
            $slot = $value->calendar_subject_slot - ($value->calendar_subject_slot * 0.3);
            $joins->where('tbl_calendar_subject.calendar_subject_registered', '<', $slot);
        }
        $results = $joins->get();
        return RegisterSubjectResource::collection($results);
    }

    public function statistic_export($course, $major, $semester)
    {
        return Excel::download(new StatisticSubjectExport($course, $major, $semester), 'statistic_register_subject.xlsx');
    }
}
