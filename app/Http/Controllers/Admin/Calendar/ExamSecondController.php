<?php

namespace App\Http\Controllers\Admin\Calendar;

use App\Http\Controllers\Controller;
use App\Models\ExamSecond;
use App\Http\Resources\ExamSecondResource;
use App\Models\Student;
use Illuminate\Http\Request;

class ExamSecondController extends Controller
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
            'subject' => ['required'],
        ], [
            'subject.required' => 'Vui lòng chọn môn học!'
        ]);

        $find = Student::find($request->student_id);

        foreach ($request->subject as $subject_id) {
            $exam_second = ExamSecond::where('exam_second_course', $find->student_course)
                ->where('exam_second_major', $find->student_major)
                ->where('exam_second_subject', $subject_id)->get();
            if ($exam_second->count() > 0) {
                foreach ($exam_second as $key => $value) {
                    $value->exam_second_quantity = 1 + $value->exam_second_quantity;
                    $value->save();
                }
            } else {
                $exam = new ExamSecond();
                $exam->exam_second_course = $find->student_course;
                $exam->exam_second_major = $find->student_major;
                $exam->exam_second_subject = $subject_id;
                $exam->exam_second_quantity = 1;
                $exam->save();
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ExamSecond  $examSecond
     * @return \Illuminate\Http\Response
     */
    public function show(ExamSecond $examSecond)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ExamSecond  $examSecond
     * @return \Illuminate\Http\Response
     */
    public function edit(ExamSecond $examSecond)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ExamSecond  $examSecond
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ExamSecond $examSecond)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ExamSecond  $examSecond
     * @return \Illuminate\Http\Response
     */
    public function destroy(ExamSecond $examSecond)
    {
        //
    }

    public function show_subject_student($student_id)
    {
        $find = Student::find($student_id);
        $exam = ExamSecond::where('exam_second_course', $find->student_course)
            ->where('exam_second_major', $find->student_major)->get();
        return ExamSecondResource::collection($exam);
    }

    public function cancel_subject_student($student_id, $subject_id)
    {
        $find = Student::find($student_id);
        $exam = ExamSecond::where('exam_second_course', $find->student_course)
            ->where('exam_second_major', $find->student_major)
            ->where('exam_second_subject', $subject_id)
            ->get();

        foreach ($exam as $key => $value) {
            if ($value->exam_second_quantity > 1) {
                $value->exam_second_quantity = $value->exam_second_quantity - 1;
                $value->save();
            } else {
                $value->delete();
            }
        }
    }
}
