<?php

namespace App\Http\Controllers\Admin\Calendar;

use App\Http\Controllers\Controller;
use App\Http\Resources\CalendarResource;
use App\Models\CalendarSubject;
use App\Http\Resources\CalendarSubjectResource;
use App\Models\Calendar;
use App\Models\CalendarPlan;
use Illuminate\Http\Request;

class CalendarSubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // show in calendar
        $joins = CalendarSubject::join('tbl_calendar', 'tbl_calendar.id', '=', 'tbl_calendar_subject.calendar_id')
            ->join('tbl_subject', 'tbl_subject.subject_id', '=', 'tbl_calendar_subject.subject_id')
            ->join('tbl_lecturer', 'tbl_lecturer.lecturer_id', '=', 'tbl_calendar_subject.calendar_subject_lecturer')
            ->get();
        return CalendarSubjectResource::collection($joins);
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
            'calendar_id' => ['required'],
            'subject_id' => ['required'],
            'calendar_subject_type' => ['required'],
            'calendar_subject_slot' => ['required', 'max:11', 'gte:1'],
            'calendar_subject_lecturer' => ['required'],
            'calendar_subject_start' => ['required', 'after_or_equal:today'],
            'calendar_subject_end' => ['required', 'after:calendar_subject_start'],
            'calendar_subject_daytime' => ['required'],
        ], [
            'calendar_id.required' => 'Vui lòng chọn lịch đăng ký môn học!',
            'subject_id.required' => 'Vui lòng chọn môn học!',
            'calendar_subject_type.required' => 'Vui lòng chọn loại lớp học!',
            'calendar_subject_lecturer.required' => 'Vui lòng chọn giảng viên!',

            'calendar_subject_slot.required' => 'Vui lòng nhập số lượng của lớp học!',
            'calendar_subject_slot.max' => 'Số lượng lớp học không nhập quá 11 số!',
            'calendar_subject_slot.notspecial_spaces' => 'Số lượng lớp học không được chứa ký tự đặc biệt!',
            'calendar_subject_slot.gte' => 'Số lượng lớp học lớn hơn hoặc bằng 1!',

            'calendar_subject_start.required' => 'Vui lòng chọn ngày bắt đầu môn học!',
            'calendar_subject_start.after_or_equal' => 'Ngày bắt đầu môn học phải chọn từ ngày hôm nay trở đi!',

            'calendar_subject_end.required' => 'Vui lòng chọn ngày kết thúc môn học!',
            'calendar_subject_end.after' => 'Ngày kết thúc môn học phải chọn sau ngày bắt đầu!',
        ]);
        foreach ($data['calendar_subject_daytime'] as $key => $calendar_subject) {
            $changetoObject = (object)$calendar_subject;
            $calendar = new CalendarSubject();
            $calendar->calendar_id = $data['calendar_id'];
            $calendar->subject_id = $data['subject_id'];
            $calendar->calendar_subject_type = $data['calendar_subject_type'];
            $calendar->calendar_subject_slot = $data['calendar_subject_slot'];
            $calendar->calendar_subject_lecturer = $data['calendar_subject_lecturer'];
            $calendar->calendar_subject_day =  $changetoObject->calendar_subject_day;
            $calendar->calendar_subject_time = $changetoObject->calendar_subject_time;
            $calendar->calendar_subject_start = $data['calendar_subject_start'];
            $calendar->calendar_subject_end = $data['calendar_subject_end'];
            $calendar->save();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CalendarSubject  $calendarSubject
     * @return \Illuminate\Http\Response
     */
    public function show($currentEntries)
    {
        $joins = CalendarSubject::join('tbl_calendar', 'tbl_calendar.id', '=', 'tbl_calendar_subject.calendar_id')
            ->join('tbl_subject', 'tbl_subject.subject_id', '=', 'tbl_calendar_subject.subject_id')
            ->join('tbl_lecturer', 'tbl_lecturer.lecturer_id', '=', 'tbl_calendar_subject.calendar_subject_lecturer')
            ->orderby('tbl_calendar_subject.calendar_subject_id', 'DESC')->paginate($currentEntries);
        return CalendarSubjectResource::collection($joins);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CalendarSubject  $calendarSubject
     * @return \Illuminate\Http\Response
     */
    public function edit(CalendarSubject $calendarSubject)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CalendarSubject  $calendarSubject
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $calendarSubject)
    {
        $data = $request->validate([
            'calendar_id' => ['required'],
            'subject_id' => ['required'],
            'calendar_subject_type' => ['required'],
            'calendar_subject_slot' => ['required', 'max:11', 'gte:1'],
            'calendar_subject_lecturer' => ['required'],
            'calendar_subject_day' => ['required'],
            'calendar_subject_time' => ['required'],
            'calendar_subject_start' => ['required'],
            'calendar_subject_end' => ['required', 'after:calendar_subject_start'],
        ], [
            'calendar_id.required' => 'Vui lòng chọn lịch đăng ký môn học!',
            'subject_id.required' => 'Vui lòng chọn môn học!',
            'calendar_subject_type.required' => 'Vui lòng chọn loại lớp học!',
            'calendar_subject_lecturer.required' => 'Vui lòng chọn giảng viên!',

            'calendar_subject_slot.required' => 'Vui lòng nhập số lượng của lớp học!',
            'calendar_subject_slot.max' => 'Số lượng lớp học không nhập quá 11 số!',
            'calendar_subject_slot.notspecial_spaces' => 'Số lượng lớp học không được chứa ký tự đặc biệt!',
            'calendar_subject_slot.gte' => 'Số lượng lớp học lớn hơn hoặc bằng 1!',

            'calendar_subject_day.required' => 'Ngày học không được để trống!',
            'calendar_subject_time.required' => 'Thời gian học không được để trống!',

            'calendar_subject_start.required' => 'Vui lòng chọn ngày bắt đầu môn học!',

            'calendar_subject_end.required' => 'Vui lòng chọn ngày kết thúc môn học!',
            'calendar_subject_end.after' => 'Ngày kết thúc môn học phải chọn sau ngày bắt đầu!',
        ]);

        $calendar = CalendarSubject::find($calendarSubject);
        $calendar->calendar_id = $data['calendar_id'];
        $calendar->subject_id = $data['subject_id'];
        $calendar->calendar_subject_type = $data['calendar_subject_type'];
        $calendar->calendar_subject_slot = $data['calendar_subject_slot'];
        $calendar->calendar_subject_lecturer = $data['calendar_subject_lecturer'];
        $calendar->calendar_subject_day = $data['calendar_subject_day'];
        $calendar->calendar_subject_time = $data['calendar_subject_time'];
        $calendar->calendar_subject_start = $data['calendar_subject_start'];
        $calendar->calendar_subject_end = $data['calendar_subject_end'];
        $calendar->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CalendarSubject  $calendarSubject
     * @return \Illuminate\Http\Response
     */
    public function destroy($calendarSubject)
    {
        $del = CalendarSubject::find($calendarSubject);
        $del->delete();
    }

    public function search($query, $currentEntries)
    {
        $joins = CalendarSubject::join('tbl_calendar', 'tbl_calendar.id', '=', 'tbl_calendar_subject.calendar_id')
            ->join('tbl_subject', 'tbl_subject.subject_id', '=', 'tbl_calendar_subject.subject_id')
            ->join('tbl_lecturer', 'tbl_lecturer.lecturer_id', '=', 'tbl_calendar_subject.calendar_subject_lecturer')
            ->where('tbl_subject.subject_name', 'LIKE', '%' . $query . '%')
            ->orderby('tbl_calendar_subject.calendar_subject_id', 'DESC')->paginate($currentEntries);
        return CalendarSubjectResource::collection($joins);
    }

    public function detail($calendar_subject_id)
    {
        $joins = CalendarSubject::join('tbl_calendar', 'tbl_calendar.id', '=', 'tbl_calendar_subject.calendar_id')
            ->join('tbl_subject', 'tbl_subject.subject_id', '=', 'tbl_calendar_subject.subject_id')
            ->join('tbl_lecturer', 'tbl_lecturer.lecturer_id', '=', 'tbl_calendar_subject.calendar_subject_lecturer')
            ->where('tbl_calendar_subject.calendar_subject_id', $calendar_subject_id)->get();
        return CalendarSubjectResource::collection($joins);
    }

    public function show_subject($id)
    {
        $calendar = Calendar::find($id);
        $calendarPlan = Calendar::join('tbl_calendar_plan', 'tbl_calendar_plan.calendar_id', '=', 'tbl_calendar.id')
            ->join('tbl_subject', 'tbl_subject.subject_id', '=', 'tbl_calendar_plan.calendar_plan_subject')
            ->where('tbl_calendar.raw', $calendar->raw)
            ->where('tbl_calendar.body', $calendar->body)->get();
        return CalendarResource::collection($calendarPlan);
    }

    public function change($calendar_subject_id)
    {
        $find = CalendarSubject::find($calendar_subject_id);
        if ($find->calendar_subject_status == 0) {
            $find->calendar_subject_status = 1;
            $find->save();
        } else {
            $find->calendar_subject_status = 0;
            $find->save();
        }
    }

    public function filter($course_id, $major_id, $semester, $currentEntries)
    {
        $item = CalendarSubject::join('tbl_calendar', 'tbl_calendar.id', '=', 'tbl_calendar_subject.calendar_id')
            ->join('tbl_subject', 'tbl_subject.subject_id', '=', 'tbl_calendar_subject.subject_id')
            ->join('tbl_lecturer', 'tbl_lecturer.lecturer_id', '=', 'tbl_calendar_subject.calendar_subject_lecturer')
            ->where('tbl_calendar.raw', $course_id)->where('tbl_calendar.body', $major_id)->where('tbl_calendar.location', $semester)
            ->orderby('tbl_calendar_subject.calendar_subject_id', 'DESC')
            ->paginate($currentEntries);
        return CalendarSubjectResource::collection($item);
    }

    public function filter_incalendar($course_id, $major_id, $semester)
    {
        $item = CalendarSubject::join('tbl_calendar', 'tbl_calendar.id', '=', 'tbl_calendar_subject.calendar_id')
            ->join('tbl_subject', 'tbl_subject.subject_id', '=', 'tbl_calendar_subject.subject_id')
            ->join('tbl_lecturer', 'tbl_lecturer.lecturer_id', '=', 'tbl_calendar_subject.calendar_subject_lecturer')
            ->where('tbl_calendar.raw', $course_id)->where('tbl_calendar.body', $major_id)->where('tbl_calendar.location', $semester)
            ->orderby('tbl_calendar_subject.calendar_subject_id', 'DESC')->get();
        return CalendarSubjectResource::collection($item);
    }
}
