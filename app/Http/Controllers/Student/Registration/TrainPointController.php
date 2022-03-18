<?php

namespace App\Http\Controllers\Student\Registration;

use App\Http\Controllers\Controller;
use App\Http\Resources\CalendarResource;
use App\Models\TrainPoint;
use App\Http\Resources\TrainPointResource;
use App\Models\Calendar;
use App\Models\Student;
use Illuminate\Http\Request;

class TrainPointController extends Controller
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
        $delete = TrainPoint::where('train_point_student', $request->student_id)
            ->where('train_point_semester', $request->semester)
            ->where('train_point_type', $request->type)->get();

        if ($delete) {
            foreach ($delete as $key => $value) {
                $value->delete();
            }
        }
        $trainPoint = new TrainPoint();
        $trainPoint->train_point_student = $request->student_id;
        $trainPoint->train_point_semester = $request->semester;
        $trainPoint->train_point_type = $request->type;
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $trainPoint->train_point_date = now();
        $trainPoint->train_point_one = $request->itemOne_oneParent_inputOne . ',' .
            $request->itemOne_oneParent_inputTwo . ',' .
            $request->itemOne_oneParent_inputThree . ',' .
            $request->itemOne_oneParent_inputFour . ',' .
            $request->itemOne_oneParent_inputFive . ',' .
            $request->itemOne_twoParent_inputOne . ',' .
            $request->itemOne_twoParent_inputTwo . ',' .
            $request->itemOne_threeParent_inputOne . ',' .
            $request->itemOne_fourParent_inputOne . ',' .
            $request->itemOne_fiveParent_inputOne . ',' .
            $request->itemOne_sixParent_inputOne;
        $trainPoint->train_point_two = $request->itemTwo_oneParent_inputOne . ',' .
            $request->itemTwo_twoParent_inputOne . ',' .
            $request->itemTwo_threeParent_inputOne . ',' .
            $request->itemTwo_fourParent_inputOne . ',' .
            $request->itemTwo_fiveParent_inputOne . ',' .
            $request->itemTwo_sixParent_inputOne . ',' .
            $request->itemTwo_sevenParent_inputOne . ',' .
            $request->itemTwo_eightParent_inputOne;
        $trainPoint->train_point_three = $request->itemThree_oneParent_inputOne . ',' .
            $request->itemThree_oneParent_inputTwo . ',' .
            $request->itemThree_twoParent_inputOne . ',' .
            $request->itemThree_threeParent_inputOne . ',' .
            $request->itemThree_fourParent_inputOne . ',' .
            $request->itemThree_fourParent_inputTwo . ',' .
            $request->itemThree_fourParent_inputThree . ',' .
            $request->itemThree_fiveParent_inputOne . ',' .
            $request->itemThree_fiveParent_inputTwo . ',' .
            $request->itemThree_sixParent_inputOne . ',' .
            $request->itemThree_sevenParent_inputOne . ',' .
            $request->itemThree_eightParent_inputOne . ',' .
            $request->itemThree_eightParent_inputTwo;
        $trainPoint->train_point_four = $request->itemFour_oneParent_inputOne . ',' .
            $request->itemFour_twoParent_inputOne . ',' .
            $request->itemFour_threeParent_inputOne . ',' .
            $request->itemFour_fourParent_inputOne . ',' .
            $request->itemFour_fiveParent_inputOne . ',' .
            $request->itemFour_sixParent_inputOne . ',' .
            $request->itemFour_sevenParent_inputOne . ',' .
            $request->itemFour_eightParent_inputOne . ',' .
            $request->itemFour_nineParent_inputOne;
        $trainPoint->train_point_five = $request->itemFive_oneParent_inputOne . ',' .
            $request->itemFive_twoParent_inputOne . ',' .
            $request->itemFive_threeParent_inputOne . ',' .
            $request->itemFive_threeParent_inputTwo . ',' .
            $request->itemFive_fourParent_inputOne . ',' .
            $request->itemFive_fourParent_inputTwo . ',' .
            $request->itemFive_fiveParent_inputOne . ',' .
            $request->itemFive_fiveParent_inputTwo . ',' .
            $request->itemSix_sixParent_inputOne . ',' .
            $request->itemSix_sixParent_inputTwo . ',' .
            $request->itemSix_sixParent_inputThree;
        $trainPoint->train_point_sum = $request->sum_item;
        $trainPoint->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TrainPoint  $trainPoint
     * @return \Illuminate\Http\Response
     */
    public function show(TrainPoint $trainPoint)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TrainPoint  $trainPoint
     * @return \Illuminate\Http\Response
     */
    public function edit(TrainPoint $trainPoint)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TrainPoint  $trainPoint
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TrainPoint $trainPoint)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TrainPoint  $trainPoint
     * @return \Illuminate\Http\Response
     */
    public function destroy(TrainPoint $trainPoint)
    {
        //
    }

    public function calendar_timestudent_trainpoint($student_id)
    {
        $find = Student::find($student_id);
        $joins = Calendar::join('tbl_course', 'tbl_course.course_id', '=', 'tbl_calendar.raw')
            ->join('tbl_major', 'tbl_major.major_id', '=', 'tbl_calendar.body')
            ->where('tbl_course.course_id', $find->student_course)
            ->where('tbl_major.major_id', $find->student_major)
            ->where('tbl_calendar.calendarId', 4)
            ->where('tbl_calendar.recurrenceRule', 0)->get();

        return CalendarResource::collection($joins);
    }

    public function calendar_timeformteacher_trainpoint($student_id)
    {
        $find = Student::find($student_id);
        $joins = Calendar::join('tbl_course', 'tbl_course.course_id', '=', 'tbl_calendar.raw')
            ->join('tbl_major', 'tbl_major.major_id', '=', 'tbl_calendar.body')
            ->where('tbl_course.course_id', $find->student_course)
            ->where('tbl_major.major_id', $find->student_major)
            ->where('tbl_calendar.calendarId', 4)
            ->where('tbl_calendar.recurrenceRule', 1)->get();

        return CalendarResource::collection($joins);
    }

    public function calendar_timefaculty_trainpoint($student_id)
    {
        $find = Student::find($student_id);
        $joins = Calendar::join('tbl_course', 'tbl_course.course_id', '=', 'tbl_calendar.raw')
            ->join('tbl_major', 'tbl_major.major_id', '=', 'tbl_calendar.body')
            ->where('tbl_course.course_id', $find->student_course)
            ->where('tbl_major.major_id', $find->student_major)
            ->where('tbl_calendar.calendarId', 4)
            ->where('tbl_calendar.recurrenceRule', 2)->get();

        return CalendarResource::collection($joins);
    }

    public function get_point_ttudent($student_id, $semester)
    {
        $joins = TrainPoint::where('train_point_student', $student_id)->where('train_point_semester', $semester)
            ->where('train_point_type', 0)->get();
        return TrainPointResource::collection($joins);
    }

    public function get_point_formteacher($student_id, $semester)
    {
        $joins = TrainPoint::where('train_point_student', $student_id)->where('train_point_semester', $semester)
            ->where('train_point_type', 1)->get();
        return TrainPointResource::collection($joins);
    }

    public function get_point_deanfaculty($student_id, $semester)
    {
        $joins = TrainPoint::where('train_point_student', $student_id)->where('train_point_semester', $semester)
            ->where('train_point_type', 2)->get();
        return TrainPointResource::collection($joins);
    }
}
