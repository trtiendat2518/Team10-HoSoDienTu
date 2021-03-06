<?php

namespace App\Http\Controllers\Admin\Calendar;

use App\Http\Controllers\Controller;
use App\Models\Calendar;
use App\Http\Resources\CalendarResource;
use App\Http\Resources\ProgramDetailResource;
use App\Models\CalendarPlan;
use App\Models\Payment;
use App\Models\ProgramDetail;
use App\Models\RegisterSubject;
use App\Models\Student;
use App\Models\Tuition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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
        if ($calendar->calendarId == 0) {
            $calendar->location = $data['location'];
            $calendar->recurrenceRule = $data['recurrenceRule'];
            $calendar->bgColor = '#f4cc60';
            $calendar->save();

            foreach ($request->subject as $subject) {
                $plan = new CalendarPlan();
                $plan->calendar_id = $calendar->id;
                $plan->calendar_plan_subject = $subject;
                $plan->save();
            }
        } else if ($calendar->calendarId == 1) {
            $calendar->location = $data['location'];
            $calendar->recurrenceRule = $data['recurrenceRule'];
            $calendar->bgColor = '#fd7a86';
            $calendar->save();
        } else if ($calendar->calendarId == 2) {
            $calendar->bgColor = '#85a2f2';
            $calendar->save();
        } else if ($calendar->calendarId == 3) {
            $calendar->bgColor = '#78d9f1';
            $calendar->save();
        } else if ($calendar->calendarId == 4) {
            $calendar->location = $data['location'];
            $calendar->recurrenceRule = $data['recurrenceRule'];
            $calendar->bgColor = '#86dc9a';
            $calendar->save();
        } else if ($calendar->calendarId == 5) {
            $calendar->location = $data['location'];
            $calendar->bgColor = '#d50fd9';
            $save = $calendar->save();

            if ($save) {
                $student =  Student::where('student_role', 0)->where('student_status', 0)
                    ->where('student_course', $data['raw'])->where('student_major', $data['body'])->get();
                foreach ($student as $key => $value) {
                    $payment_fee = 0;
                    $sum_credit = 0;

                    $subjects = RegisterSubject::join('tbl_student', 'tbl_student.student_id', '=', 'tbl_register_subject.register_subject_student')
                        ->join('tbl_calendar_subject', 'tbl_calendar_subject.calendar_subject_id', '=', 'tbl_register_subject.register_subject_program')
                        ->join('tbl_subject', 'tbl_subject.subject_id', '=', 'tbl_calendar_subject.subject_id')
                        ->groupBy('tbl_subject.subject_id')
                        ->selectRaw('tbl_subject.subject_credit, tbl_subject.subject_id')
                        ->where('tbl_register_subject.register_subject_student', $value->student_id)
                        ->where('tbl_register_subject.register_subject_semester', $data['location'])
                        ->get();
                    foreach ($subjects as $key => $value_subject) {
                        $sum_credit = $value_subject->subject_credit + $sum_credit;
                    }

                    $tuition = Tuition::where('tuition_course', $value->student_course)
                        ->where('tuition_major', $value->student_major)
                        ->where('tuition_faculty', $value->student_faculty)->first();
                    $payment_fee = $sum_credit * $tuition->tuition_fee;

                    $payment = new Payment();
                    $payment->payment_student = $value->student_id;
                    $payment->payment_fee =  $payment_fee;
                    $payment->payment_discount =  $tuition->tuition_discount;
                    $payment->payment_semester = $data['location'];
                    $payment->save();
                }
            }
        }
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
        if ($data['calendarId'] == 1 || $data['calendarId'] == 4) {
            $calendar->location = $data['location'];
            $calendar->recurrenceRule = $data['recurrenceRule'];
        } else if ($data['calendarId'] == 5) {
            $calendar->location = $data['location'];
        } else {
            $calendar->location = 0;
            $calendar->recurrenceRule = 0;
        }
        $calendar->save();
    }

    public function update_plan(Request $request, $id)
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
        $calendar->location = $data['location'];
        $calendar->recurrenceRule = $data['recurrenceRule'];

        $subject_plan = CalendarPlan::where('calendar_id', $id)->get();
        foreach ($subject_plan as $key => $value) {
            $value->delete();
        }
        foreach ($request->subject as $subject) {
            $plan = new CalendarPlan();
            $plan->calendar_id = $id;
            $plan->calendar_plan_subject = $subject;
            $plan->save();
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

    public function schedule_paytuition()
    {
        $query = Calendar::where('calendarId', 5)->orderby('start', 'ASC')->get();
        return CalendarResource::collection($query);
    }

    public function subject_for_plan($calendar_id)
    {
        $joins = Calendar::join('tbl_calendar_plan', 'tbl_calendar_plan.calendar_id', '=', 'tbl_calendar.id')
            ->where('tbl_calendar.id', $calendar_id)->get();
        return CalendarResource::collection($joins);
    }

    public function get_semester($course, $major)
    {
        $joins = ProgramDetail::join('tbl_education_program', 'tbl_education_program.education_program_code', '=', 'tbl_program_detail.program_detail_code')
            ->join('tbl_course', 'tbl_course.course_id', '=', 'tbl_education_program.education_program_course')
            ->join('tbl_faculty', 'tbl_faculty.faculty_id', '=', 'tbl_education_program.education_program_faculty')
            ->join('tbl_major', 'tbl_major.major_faculty', '=', 'tbl_faculty.faculty_id')
            ->where('tbl_course.course_id', $course)
            ->where('tbl_major.major_id', $major)->get();

        return ProgramDetailResource::collection($joins);
    }
    public function get_programs($course, $major, $semester)
    {
        $joins = ProgramDetail::join('tbl_education_program', 'tbl_education_program.education_program_code', '=', 'tbl_program_detail.program_detail_code')
            ->join('tbl_course', 'tbl_course.course_id', '=', 'tbl_education_program.education_program_course')
            ->join('tbl_faculty', 'tbl_faculty.faculty_id', '=', 'tbl_education_program.education_program_faculty')
            ->join('tbl_major', 'tbl_major.major_faculty', '=', 'tbl_faculty.faculty_id')
            ->join('tbl_subject', 'tbl_subject.subject_code', '=', 'tbl_program_detail.program_detail_subject')
            ->where('tbl_course.course_id', $course)
            ->where('tbl_program_detail.program_detail_semester', $semester)
            ->where('tbl_major.major_id', $major)->get();

        return ProgramDetailResource::collection($joins);
    }

    public function except_calendar($calendar_id)
    {
        $joins = Calendar::join('tbl_course', 'tbl_course.course_id', '=', 'tbl_calendar.raw')
            ->join('tbl_major', 'tbl_major.major_id', '=', 'tbl_calendar.body')
            ->whereNotIn('id', [$calendar_id])
            ->get();
        return CalendarResource::collection($joins);
    }

    public function send_mail($course, $major, $semester, $category)
    {
        $student = Student::where('student_role', 0)->where('student_status', 0)
            ->where('student_course', $course)->where('student_major', $major)->get();
        $calendar = Calendar::where('raw', $course)->where('body', $major)
            ->where('location', $semester)->where('calendarId', $category)->first();

        $subject_mail = $calendar->title;
        $to_email = array();
        foreach ($student as $key => $valueStudent) {
            array_push($to_email, $valueStudent->student_email);
        }

        Mail::send(
            'admin.pages.mail.calendar_mail',
            ['calendar' => $calendar],
            function ($message) use ($to_email, $subject_mail) {
                $message->to($to_email)->subject($subject_mail);
            }
        );
    }
}
