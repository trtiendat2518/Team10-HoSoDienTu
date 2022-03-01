<?php

namespace App\Http\Controllers\Admin\Calendar;

use App\Http\Controllers\Controller;
use App\Models\Calendar;
use App\Http\Resources\CalendarResource;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $joins = Calendar::join('tbl_course', 'tbl_course.course_id', '=', 'tbl_calendar.raw')
            ->join('tbl_major', 'tbl_major.major_id', '=', 'tbl_calendar.body')
            ->get();
        return CalendarResource::collection($joins);
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
            'title' => ['required', 'max:200', 'min:10', 'unique:tbl_calendar', 'notspecial_spaces'], //title
            'raw' => ['required'], // course
            'body' => ['required'], //major
            'start' => ['required', 'after:today'],
            'end' => ['required', 'after:start'],
            'calendarId' => ['required'], //type
            'location' => ['max:11'], //semester
            'recurrenceRule' => ['max:11'] //credit
        ], [
            'title.required' => 'Tiêu đề không được để trống!',
            'title.max' => 'Tiêu đề không nhập quá 200 ký tự chữ!',
            'title.min' => 'Tiêu đề phải có 10 ký tự chữ trở lên!',
            'title.unique' => 'Tiêu đề đã tồn tại!',
            'title.notspecial_spaces' => 'Tiêu đề không được chứa ký tự đặc biệt!',

            'body.required' => 'Chuyên ngành không được để trống!',
            'raw.required' => 'Khoá học phải có 10 ký tự chữ trở lên!',

            'start.required' => 'Vui lòng chọn thời gian bắt đầu!',
            'start.after' => 'Khổng thể chọn ngày đã qua, có thể chọn từ ngày hôm nay trở đi!',

            'end.required' => 'Vui lòng chọn thời gian kết thúc!',
            'end.after' => 'Thời gian kết thúc buộc phải sau ngày bắt đầu!',

            'calendarId.required' => 'Vui lòng chọn sự kiện!',
            'location.max' => 'Học kỳ tối đa 11 ký tự số!',
            'recurrenceRule.max' => 'Số TC tối đa 11 ký tự số!',
        ]);

        $calendar = new Calendar();
        $calendar->title = $data['title'];
        $calendar->body = $data['body'];
        $calendar->raw = $data['raw'];
        $calendar->start = $data['start'];
        $calendar->end = $data['end'];
        $calendar->calendarId = $data['calendarId'];
        $calendar->location = $data['location'];
        $calendar->recurrenceRule = $data['recurrenceRule'];
        $calendar->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Calendar  $calendar
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $joins = Calendar::join('tbl_course', 'tbl_course.course_id', '=', 'tbl_calendar.raw')
            ->join('tbl_major', 'tbl_major.major_id', '=', 'tbl_calendar.body')
            ->where('id', $id)->get();
        return CalendarResource::collection($joins);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Calendar  $calendar
     * @return \Illuminate\Http\Response
     */
    public function edit(Calendar $calendar)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Calendar  $calendar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'title' => ['required', 'max:200', 'min:10', "unique:tbl_calendar,title,$id,id", 'notspecial_spaces'],
            'raw' => ['required'],
            'body' => ['required'],
            'start' => ['required'],
            'end' => ['required', 'after_or_equal:start'],
            'calendarId' => ['required'],
            'location' => ['max:11'],
            'recurrenceRule' => ['max:11']
        ], [
            'title.required' => 'Tiêu đề không được để trống!',
            'title.max' => 'Tiêu đề không nhập quá 200 ký tự chữ!',
            'title.min' => 'Tiêu đề phải có 10 ký tự chữ trở lên!',
            'title.notspecial_spaces' => 'Tiêu đề không được chứa ký tự đặc biệt!',
            'title.unique' => 'Tiêu đề đã tồn tại!',

            'body.required' => 'Chuyên ngành không được để trống!',
            'raw.required' => 'Khoá học không được để trống!',

            'start.required' => 'Vui lòng chọn thời gian bắt đầu!',

            'end.required' => 'Vui lòng chọn thời gian kết thúc!',
            'end.after_or_equal' => 'Thời gian kết thúc buộc phải bằng ngày bắt đầu hoặc sau ngày bắt đầu!',

            'calendarId.required' => 'Vui lòng chọn sự kiện!',
            'location.max' => 'Học kỳ tối đa 11 ký tự số!',
            'recurrenceRule.max' => 'Số TC tối đa 11 ký tự số!',
        ]);

        $calendar = Calendar::find($id);
        $calendar->title = $data['title'];
        $calendar->body = $data['body'];
        $calendar->raw = $data['raw'];
        $calendar->start = $data['start'];
        $calendar->end = $data['end'];
        $calendar->calendarId = $data['calendarId'];
        if ($data['calendarId'] <= 1) {
            $calendar->location = $data['location'];
            $calendar->recurrenceRule = $data['recurrenceRule'];
        } else {
            $calendar->location = 0;
            $calendar->recurrenceRule = 0;
        }
        $calendar->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Calendar  $calendar
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $del = Calendar::find($id);
        $del->delete();
    }

    public function schedule()
    {
        return CalendarResource::collection(Calendar::orderby('start', 'ASC')->get());
    }

    public function schedule_exam()
    {
        $query = Calendar::where('calendarId', 2)->orwhere('calendarId', 3)->orderby('start', 'ASC')->get();
        return CalendarResource::collection($query);
    }

    public function schedule_subject()
    {
        $query = Calendar::where('calendarId', 1)->orderby('start', 'ASC')->get();
        return CalendarResource::collection($query);
    }
}
