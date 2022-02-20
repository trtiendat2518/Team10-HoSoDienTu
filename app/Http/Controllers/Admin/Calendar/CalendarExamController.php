<?php

namespace App\Http\Controllers\Admin\Calendar;

use App\Http\Controllers\Controller;
use App\Models\CalendarExam;
use App\Http\Resources\CalendarExamResource;
use Illuminate\Http\Request;
use Validator;

class CalendarExamController extends Controller
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
            'calendar_exam_schedule' => ['required'],
            'calendar_exam_subject' => ['required'],
            'calendar_exam_room' => ['required', 'max:20', 'notspecial_spaces'],
            'calendar_exam_method' => ['required', 'max:50', 'notspecial_spaces'],
            'calendar_exam_place' => ['required', 'max:100'],
            'calendar_exam_semester' => ['required', 'max:11'],
            'calendar_exam_note' => ['max:250']
        ], [
            'calendar_exam_schedule.required' => 'Lịch biểu không được để trống!',
            'calendar_exam_subject.required' => 'Môn Học không được để trống!',

            'calendar_exam_room.required' => 'Phòng thi không được để trống!',
            'calendar_exam_room.max' => 'Phòng thi không nhập quá 20 ký tự chữ!',
            'calendar_exam_room.notspecial_spaces' => 'Phòng thi không được chứa ký tự đặc biệt!',

            'calendar_exam_method.required' => 'Hình thức không được để trống!',
            'calendar_exam_method.max' => 'Hình thức không nhập quá 50 ký tự chữ!',
            'calendar_exam_method.notspecial_spaces' => 'Hình thức không được chứa ký tự đặc biệt!',

            'calendar_exam_place.required' => 'Địa điểm thi không được để trống!',
            'calendar_exam_place.max' => 'Địa điểm thi không nhập quá 100 ký tự chữ!',

            'calendar_exam_semester.required' => 'Số học kỳ không được để trống!',
            'calendar_exam_semester.max' => 'Số học kỳ không nhập quá 11 ký tự!',

            'calendar_exam_note.max' => 'Ghi chú không nhập quá 250 ký tự chữ!',
        ]);

        $calendar = new CalendarExam();
        $calendar->calendar_exam_schedule = $data['calendar_exam_schedule'];
        $calendar->calendar_exam_subject = $data['calendar_exam_subject'];
        $calendar->calendar_exam_room = $data['calendar_exam_room'];
        $calendar->calendar_exam_method = $data['calendar_exam_method'];
        $calendar->calendar_exam_place = $data['calendar_exam_place'];
        $calendar->calendar_exam_semester = $data['calendar_exam_semester'];
        $calendar->calendar_exam_note = $data['calendar_exam_note'];
        $calendar->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CalendarExam  $calendarExam
     * @return \Illuminate\Http\Response
     */
    public function show($currentEntries)
    {
        $joins = CalendarExam::join('tbl_calendar', 'tbl_calendar.id', '=', 'tbl_calendar_exam.calendar_exam_schedule')
            ->join('tbl_subject', 'tbl_subject.subject_id', '=', 'tbl_calendar_exam.calendar_exam_subject')
            ->join('tbl_faculty', 'tbl_faculty.faculty_id', '=', 'tbl_subject.subject_faculty')
            ->join('tbl_course', 'tbl_course.course_id', '=', 'tbl_calendar.raw')
            ->join('tbl_major', 'tbl_major.major_id', '=', 'tbl_calendar.body')
            ->orderby('calendar_exam_id', 'DESC')->paginate($currentEntries);
        return CalendarExamResource::collection($joins);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CalendarExam  $calendarExam
     * @return \Illuminate\Http\Response
     */
    public function edit(CalendarExam $calendarExam)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CalendarExam  $calendarExam
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $calendarExam)
    {
        $data = $request->validate([
            'calendar_exam_schedule' => ['required'],
            'calendar_exam_subject' => ['required'],
            'calendar_exam_room' => ['required', 'max:20', 'notspecial_spaces'],
            'calendar_exam_method' => ['required', 'max:50', 'notspecial_spaces'],
            'calendar_exam_place' => ['required', 'max:100'],
            'calendar_exam_semester' => ['required', 'max:11'],
            'calendar_exam_note' => ['max:250']
        ], [
            'calendar_exam_schedule.required' => 'Lịch biểu không được để trống!',
            'calendar_exam_subject.required' => 'Môn Học không được để trống!',

            'calendar_exam_room.required' => 'Phòng thi không được để trống!',
            'calendar_exam_room.max' => 'Phòng thi không nhập quá 20 ký tự chữ!',
            'calendar_exam_room.notspecial_spaces' => 'Phòng thi không được chứa ký tự đặc biệt!',

            'calendar_exam_method.required' => 'Hình thức không được để trống!',
            'calendar_exam_method.max' => 'Hình thức không nhập quá 50 ký tự chữ!',
            'calendar_exam_method.notspecial_spaces' => 'Hình thức không được chứa ký tự đặc biệt!',

            'calendar_exam_place.required' => 'Địa điểm thi không được để trống!',
            'calendar_exam_place.max' => 'Địa điểm thi không nhập quá 100 ký tự chữ!',

            'calendar_exam_semester.required' => 'Số học kỳ không được để trống!',
            'calendar_exam_semester.max' => 'Số học kỳ không nhập quá 11 ký tự!',

            'calendar_exam_note.max' => 'Ghi chú không nhập quá 250 ký tự chữ!',
        ]);

        $calendar = CalendarExam::find($calendarExam);
        $calendar->calendar_exam_schedule = $data['calendar_exam_schedule'];
        $calendar->calendar_exam_subject = $data['calendar_exam_subject'];
        $calendar->calendar_exam_room = $data['calendar_exam_room'];
        $calendar->calendar_exam_method = $data['calendar_exam_method'];
        $calendar->calendar_exam_place = $data['calendar_exam_place'];
        $calendar->calendar_exam_semester = $data['calendar_exam_semester'];
        $calendar->calendar_exam_note = $data['calendar_exam_note'];
        $calendar->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CalendarExam  $calendarExam
     * @return \Illuminate\Http\Response
     */
    public function destroy($calendarExam)
    {
        $del = CalendarExam::find($calendarExam);
        $del->delete();
    }

    public function search($query, $currentEntries)
    {
        $joins = CalendarExam::join('tbl_calendar', 'tbl_calendar.id', '=', 'tbl_calendar_exam.calendar_exam_schedule')
            ->join('tbl_subject', 'tbl_subject.subject_id', '=', 'tbl_calendar_exam.calendar_exam_subject')
            ->join('tbl_faculty', 'tbl_faculty.faculty_id', '=', 'tbl_subject.subject_faculty')
            ->join('tbl_course', 'tbl_course.course_id', '=', 'tbl_calendar.raw')
            ->join('tbl_major', 'tbl_major.major_id', '=', 'tbl_calendar.body')
            ->where('tbl_subject.subject_name', 'LIKE', '%' . $query . '%')
            ->orwhere('tbl_calendar.title', 'LIKE', '%' . $query . '%')
            ->orderby('calendar_exam_id', 'DESC')->paginate($currentEntries);
        return CalendarExamResource::collection($joins);
    }

    public function detail($calendar_exam_id)
    {
        $joins = CalendarExam::join('tbl_calendar', 'tbl_calendar.id', '=', 'tbl_calendar_exam.calendar_exam_schedule')
            ->join('tbl_subject', 'tbl_subject.subject_id', '=', 'tbl_calendar_exam.calendar_exam_subject')
            ->join('tbl_faculty', 'tbl_faculty.faculty_id', '=', 'tbl_subject.subject_faculty')
            ->join('tbl_course', 'tbl_course.course_id', '=', 'tbl_calendar.raw')
            ->join('tbl_major', 'tbl_major.major_id', '=', 'tbl_calendar.body')
            ->where('tbl_calendar_exam.calendar_exam_id', $calendar_exam_id)
            ->orderby('calendar_exam_id', 'DESC')->get();
        return CalendarExamResource::collection($joins);
    }
}
