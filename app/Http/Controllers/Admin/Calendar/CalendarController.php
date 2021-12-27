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
        return CalendarResource::collection(Calendar::get());
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
            'title' => ['required', 'max:200', 'min:10', 'unique:tbl_calendar', 'notspecial_spaces'],
            'body' => ['required', 'min:10', 'unique:tbl_calendar'],
            'start' => ['required', 'after:today'],
            'end' => ['required', 'after_or_equal:start'],
            'calendarId' => ['required'],
        ],[
            'title.required' => 'Tiêu đề không được để trống!',
            'title.max' => 'Tiêu đề không nhập quá 200 ký tự chữ!',
            'title.min' => 'Tiêu đề phải có 10 ký tự chữ trở lên!',
            'title.unique' => 'Tiêu đề đã tồn tại!',
            'title.notspecial_spaces' => 'Tiêu đề không được chứa ký tự đặc biệt!',

            'body.required' => 'Nội dung không được để trống!',
            'body.min' => 'Nội dung phải có 10 ký tự chữ trở lên!',
            'body.unique' => 'Nội dung đã tồn tại!',

            'start.required' => 'Vui lòng chọn thời gian bắt đầu!',
            'start.after' => 'Khổng thể chọn ngày đã qua, có thể chọn từ ngày hôm nay trở đi!',

            'end.required' => 'Vui lòng chọn thời gian kết thúc!',
            'end.after_or_equal' => 'Thời gian kết thúc buộc phải bằng ngày bắt đầu hoặc sau ngày bắt đầu!',

            'calendarId.required' => 'Vui lòng chọn sự kiện!',
        ]);

        $calendar = new Calendar();
        $calendar->title = $data['title'];
        $calendar->body = $data['body'];
        $calendar->start = $data['start'];
        $calendar->end = $data['end'];
        $calendar->calendarId = $data['calendarId'];
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
        return CalendarResource::collection(Calendar::where('id', $id)->get());
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
            'title' => ['required', 'max:200', 'min:10', 'notspecial_spaces'],
            'body' => ['required', 'min:10'],
            'start' => ['required'],
            'end' => ['required', 'after_or_equal:start'],
            'calendarId' => ['required'],
        ],[
            'title.required' => 'Tiêu đề không được để trống!',
            'title.max' => 'Tiêu đề không nhập quá 200 ký tự chữ!',
            'title.min' => 'Tiêu đề phải có 10 ký tự chữ trở lên!',
            'title.notspecial_spaces' => 'Tiêu đề không được chứa ký tự đặc biệt!',

            'body.required' => 'Nội dung không được để trống!',
            'body.min' => 'Nội dung phải có 10 ký tự chữ trở lên!',

            'start.required' => 'Vui lòng chọn thời gian bắt đầu!',

            'end.required' => 'Vui lòng chọn thời gian kết thúc!',
            'end.after_or_equal' => 'Thời gian kết thúc buộc phải bằng ngày bắt đầu hoặc sau ngày bắt đầu!',

            'calendarId.required' => 'Vui lòng chọn sự kiện!',
        ]);

        $calendar = Calendar::find($id);
        $calendar->title = $data['title'];
        $calendar->body = $data['body'];
        $calendar->start = $data['start'];
        $calendar->end = $data['end'];
        $calendar->calendarId = $data['calendarId'];
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
}
