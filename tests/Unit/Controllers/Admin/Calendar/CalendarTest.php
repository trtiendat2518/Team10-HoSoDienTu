<?php

namespace Tests\Unit\Controllers\Admin\Calendar;

use App\Models\Calendar;
use App\Models\CalendarPlan;
use App\Models\Payment;
use Tests\TestCase;
use Carbon\Carbon;

class CalendarTest extends TestCase
{
    /** @test */
    public function storeCalendarStudyPlanRegisterSucess()
    {
        $response = $this->json('POST', 'api/admin/calendar-schedule/lich-bieu', [
            'title' => 'Đăng ký kế hoạch học tập Khoá 29 HK1 KTPM', //title
            'body' => '2', //major
            'raw' => '6', // course
            'start' => Carbon::now('Asia/Ho_Chi_Minh'),
            'end' => Carbon::tomorrow('Asia/Ho_Chi_Minh'),
            'calendarId' => '0', //type
            'location' => '1',  //semester
            'recurrenceRule' => '14', //credit
            'bgColor' => '#f4cc60',
            'subject' => ['15']
        ]);
        $check = $response->assertStatus(200);
        if ($check == true) {
            $findToDel = Calendar::orderBy('id', 'DESC')->first();
            $findSubjectCalendarPlan = CalendarPlan::where('calendar_id', $findToDel->id)->get();
            foreach ($findSubjectCalendarPlan as $key => $value) {
                $value->delete();
            }
            $findToDel->delete();
        }
    }

    /** @test */
    public function storeCalendarSubjectRegisterSucess()
    {
        $response = $this->json('POST', 'api/admin/calendar-schedule/lich-bieu', [
            'title' => 'Đăng ký môn học Khoá 29 HK1 KTPM', //title
            'body' => '2', //major
            'raw' => '6', // course
            'start' => Carbon::now('Asia/Ho_Chi_Minh'),
            'end' => Carbon::tomorrow('Asia/Ho_Chi_Minh'),
            'calendarId' => '1', //type
            'location' => '1',  //semester
            'recurrenceRule' => '14', //credit
            'bgColor' => '#fd7a86',
        ]);
        $check = $response->assertStatus(200);
        if ($check == true) {
            $findToDel = Calendar::orderBy('id', 'DESC')->first();
            $findToDel->delete();
        }
    }

    /** @test */
    public function storeCalendarExamRegisterSucess()
    {
        $response = $this->json('POST', 'api/admin/calendar-schedule/lich-bieu', [
            'title' => 'Lịch thi học kỳ 1 làn 1 Khoá 29 KTPM', //title
            'body' => '2', //major
            'raw' => '6', // course
            'start' => Carbon::now('Asia/Ho_Chi_Minh'),
            'end' => Carbon::tomorrow('Asia/Ho_Chi_Minh'),
            'calendarId' => '2', //type
            'location' => '1',  //semester
            'bgColor' => '#85a2f2',
        ]);
        $check = $response->assertStatus(200);
        if ($check == true) {
            $findToDel = Calendar::orderBy('id', 'DESC')->first();
            $findToDel->delete();
        }
    }

    /** @test */
    public function storeCalendarExamSecondRegisterSucess()
    {
        $response = $this->json('POST', 'api/admin/calendar-schedule/lich-bieu', [
            'title' => 'Lịch thi lần 2 học kỳ 1 Khoá 29 KTPM', //title
            'body' => '2', //major
            'raw' => '6', // course
            'start' => Carbon::now('Asia/Ho_Chi_Minh'),
            'end' => Carbon::tomorrow('Asia/Ho_Chi_Minh'),
            'calendarId' => '3', //type
            'location' => '1',  //semester
            'bgColor' => '#78d9f1',
        ]);
        $check = $response->assertStatus(200);
        if ($check == true) {
            $findToDel = Calendar::orderBy('id', 'DESC')->first();
            $findToDel->delete();
        }
    }

    /** @test */
    public function storeCalendarTrainingPointSucess()
    {
        $response = $this->json('POST', 'api/admin/calendar-schedule/lich-bieu', [
            'title' => 'Đánh giá điểm rèn luyện HK1 K29 KTPM', //title
            'body' => '2', //major
            'raw' => '6', // course
            'start' => Carbon::now('Asia/Ho_Chi_Minh'),
            'end' => Carbon::tomorrow('Asia/Ho_Chi_Minh'),
            'calendarId' => '4', //type
            'location' => '1',  //semester
            'recurrenceRule' => '0', //object
            'bgColor' => '#86dc9a',
        ]);
        $check = $response->assertStatus(200);
        if ($check == true) {
            $findToDel = Calendar::orderBy('id', 'DESC')->first();
            $findToDel->delete();
        }
    }

    /** @test */
    public function storeCalendarTuitionPaySucess()
    {
        $response = $this->json('POST', 'api/admin/calendar-schedule/lich-bieu', [
            'title' => 'Đóng học phí Khoá 29 HK1 KTPM', //title
            'body' => '2', //major
            'raw' => '6', // course
            'start' => Carbon::now('Asia/Ho_Chi_Minh'),
            'end' => Carbon::tomorrow('Asia/Ho_Chi_Minh'),
            'calendarId' => '5', //type
            'location' => '1',  //semester
            'bgColor' => '#d50fd9'
        ]);
        $check = $response->assertStatus(200);
        if ($check == true) {
            $findToDel = Calendar::orderBy('id', 'DESC')->first();
            $findStudent = Payment::join('tbl_student', 'tbl_student.student_id', '=', 'tbl_payment.payment_student')
                ->where('tbl_student.student_course', $findToDel->raw)
                ->where('tbl_student.student_major', $findToDel->body)
                ->where('tbl_payment.payment_semester', $findToDel->location)->get();
            foreach ($findStudent as $key => $value) {
                $value->delete();
            }
            $findToDel->delete();
        }
    }

    /** @test */
    public function storeCalendarTitleEmptyError()
    {
        $response = $this->json('POST', 'api/admin/calendar-schedule/lich-bieu', [
            'title' => '', //title
            'body' => '2', //major
            'raw' => '6', // course
            'start' => Carbon::now('Asia/Ho_Chi_Minh'),
            'end' => Carbon::tomorrow('Asia/Ho_Chi_Minh'),
            'calendarId' => '0', //type
            'location' => '1',  //semester
            'recurrenceRule' => '14', //credit
            'bgColor' => '#f4cc60',
            'subject' => ['15']
        ]);
        $check = $response->assertStatus(422);
    }

    /** @test */
    public function storeCalendarTitleMaxLengthError()
    {
        $response = $this->json('POST', 'api/admin/calendar-schedule/lich-bieu', [
            'title' => '6c38b8bd623b61ssdfsfsdfsdfsdfsdfsadfsadfjhsdakfhjskadfhjksadhfjksahfkjashdfhsadfhasjkdfhsadjklfhsdajkfhjksadfhjksahfkjsafjksadhfjkasdhfjkshfjksdnkvjnkjfnejkurhfjksnfkjsdhnfjkhwjkfsdfjss1d24eeb555ad4aba81', //title
            'body' => '2', //major
            'raw' => '6', // course
            'start' => Carbon::now('Asia/Ho_Chi_Minh'),
            'end' => Carbon::tomorrow('Asia/Ho_Chi_Minh'),
            'calendarId' => '0', //type
            'location' => '1',  //semester
            'recurrenceRule' => '14', //credit
            'bgColor' => '#f4cc60',
            'subject' => ['15']
        ]);
        $check = $response->assertStatus(422);
    }

    /** @test */
    public function storeCalendarTitleMinLengthError()
    {
        $response = $this->json('POST', 'api/admin/calendar-schedule/lich-bieu', [
            'title' => 'Hello', //title
            'body' => '2', //major
            'raw' => '6', // course
            'start' => Carbon::now('Asia/Ho_Chi_Minh'),
            'end' => Carbon::tomorrow('Asia/Ho_Chi_Minh'),
            'calendarId' => '0', //type
            'location' => '1',  //semester
            'recurrenceRule' => '14', //credit
            'bgColor' => '#f4cc60',
            'subject' => ['15']
        ]);
        $check = $response->assertStatus(422);
    }

    /** @test */
    public function storeCalendarTitleExistError()
    {
        $response = $this->json('POST', 'api/admin/calendar-schedule/lich-bieu', [
            'title' => 'Đăng ký kế hoạch học tập K24 KTPM HK1', //title
            'body' => '2', //major
            'raw' => '6', // course
            'start' => Carbon::now('Asia/Ho_Chi_Minh'),
            'end' => Carbon::tomorrow('Asia/Ho_Chi_Minh'),
            'calendarId' => '0', //type
            'location' => '1',  //semester
            'recurrenceRule' => '14', //credit
            'bgColor' => '#f4cc60',
            'subject' => ['15']
        ]);
        $check = $response->assertStatus(422);
    }

    /** @test */
    public function storeCalendarTitleSpecialCharacterError()
    {
        $response = $this->json('POST', 'api/admin/calendar-schedule/lich-bieu', [
            'title' => 'Test Ký tự đặc biệt @#@#$', //title
            'body' => '2', //major
            'raw' => '6', // course
            'start' => Carbon::now('Asia/Ho_Chi_Minh'),
            'end' => Carbon::tomorrow('Asia/Ho_Chi_Minh'),
            'calendarId' => '0', //type
            'location' => '1',  //semester
            'recurrenceRule' => '14', //credit
            'bgColor' => '#f4cc60',
            'subject' => ['15']
        ]);
        $check = $response->assertStatus(422);
    }

    /** @test */
    public function storeCalendarCourseEmptyError()
    {
        $response = $this->json('POST', 'api/admin/calendar-schedule/lich-bieu', [
            'title' => 'Đăng ký kế hoạch học tập Khoá 29 HK1 KTPM', //title
            'body' => '2', //major
            'raw' => '', // course
            'start' => Carbon::now('Asia/Ho_Chi_Minh'),
            'end' => Carbon::tomorrow('Asia/Ho_Chi_Minh'),
            'calendarId' => '0', //type
            'location' => '1',  //semester
            'recurrenceRule' => '14', //credit
            'bgColor' => '#f4cc60',
            'subject' => ['15']
        ]);
        $check = $response->assertStatus(422);
    }

    /** @test */
    public function storeCalendarMajorEmptyError()
    {
        $response = $this->json('POST', 'api/admin/calendar-schedule/lich-bieu', [
            'title' => 'Đăng ký kế hoạch học tập Khoá 29 HK1 KTPM', //title
            'body' => '', //major
            'raw' => '6', // course
            'start' => Carbon::now('Asia/Ho_Chi_Minh'),
            'end' => Carbon::tomorrow('Asia/Ho_Chi_Minh'),
            'calendarId' => '0', //type
            'location' => '1',  //semester
            'recurrenceRule' => '14', //credit
            'bgColor' => '#f4cc60',
            'subject' => ['15']
        ]);
        $check = $response->assertStatus(422);
    }

    /** @test */
    public function storeCalendarStartEmptyError()
    {
        $response = $this->json('POST', 'api/admin/calendar-schedule/lich-bieu', [
            'title' => 'Đăng ký kế hoạch học tập Khoá 29 HK1 KTPM', //title
            'body' => '2', //major
            'raw' => '6', // course
            'start' => '',
            'end' => Carbon::tomorrow('Asia/Ho_Chi_Minh'),
            'calendarId' => '0', //type
            'location' => '1',  //semester
            'recurrenceRule' => '14', //credit
            'bgColor' => '#f4cc60',
            'subject' => ['15']
        ]);
        $check = $response->assertStatus(422);
    }

    /** @test */
    public function storeCalendarEndEmptyError()
    {
        $response = $this->json('POST', 'api/admin/calendar-schedule/lich-bieu', [
            'title' => 'Đăng ký kế hoạch học tập Khoá 29 HK1 KTPM', //title
            'body' => '2', //major
            'raw' => '6', // course
            'start' => Carbon::now('Asia/Ho_Chi_Minh'),
            'end' => '',
            'calendarId' => '0', //type
            'location' => '1',  //semester
            'recurrenceRule' => '14', //credit
            'bgColor' => '#f4cc60',
            'subject' => ['15']
        ]);
        $check = $response->assertStatus(422);
    }

    /** @test */
    public function storeCalendarTypeEmptyError()
    {
        $response = $this->json('POST', 'api/admin/calendar-schedule/lich-bieu', [
            'title' => 'Đăng ký kế hoạch học tập Khoá 29 HK1 KTPM', //title
            'body' => '2', //major
            'raw' => '6', // course
            'start' => Carbon::now('Asia/Ho_Chi_Minh'),
            'end' => Carbon::tomorrow('Asia/Ho_Chi_Minh'),
            'calendarId' => '', //type
            'location' => '1',  //semester
            'recurrenceRule' => '14', //credit
            'bgColor' => '#f4cc60',
            'subject' => ['15']
        ]);
        $check = $response->assertStatus(422);
    }

    /** @test */
    public function storeCalendarMaxLengthSemesterError()
    {
        $response = $this->json('POST', 'api/admin/calendar-schedule/lich-bieu', [
            'title' => 'Đăng ký kế hoạch học tập Khoá 29 HK1 KTPM', //title
            'body' => '2', //major
            'raw' => '6', // course
            'start' => Carbon::now('Asia/Ho_Chi_Minh'),
            'end' => Carbon::tomorrow('Asia/Ho_Chi_Minh'),
            'calendarId' => '0', //type
            'location' => '1111111111111111111111111111111111111111111111',  //semester
            'recurrenceRule' => '14', //credit
            'bgColor' => '#f4cc60',
            'subject' => ['15']
        ]);
        $check = $response->assertStatus(422);
    }

    /** @test */
    public function storeCalendarMaxLengthCreditError()
    {
        $response = $this->json('POST', 'api/admin/calendar-schedule/lich-bieu', [
            'title' => 'Đăng ký kế hoạch học tập Khoá 29 HK1 KTPM', //title
            'body' => '2', //major
            'raw' => '6', // course
            'start' => Carbon::now('Asia/Ho_Chi_Minh'),
            'end' => Carbon::tomorrow('Asia/Ho_Chi_Minh'),
            'calendarId' => '0', //type
            'location' => '1',  //semester
            'recurrenceRule' => '141414141414141414141414141414', //credit
            'bgColor' => '#f4cc60',
            'subject' => ['15']
        ]);
        $check = $response->assertStatus(422);
    }

    /** @test */
    public function updateCalendarStudyPlanRegisterSucess()
    {
        $this->json('POST', 'api/admin/calendar-schedule/lich-bieu', [
            'title' => 'Đăng ký kế hoạch học tập Khoá 29 HK1 KTPM', //title
            'body' => '2', //major
            'raw' => '6', // course
            'start' => Carbon::now('Asia/Ho_Chi_Minh'),
            'end' => Carbon::tomorrow('Asia/Ho_Chi_Minh'),
            'calendarId' => '0', //type
            'location' => '1',  //semester
            'recurrenceRule' => '14', //credit
            'bgColor' => '#f4cc60',
            'subject' => ['15']
        ]);

        $findToDel = Calendar::orderBy('id', 'DESC')->first();

        $response = $this->json('POST', 'api/admin/calendar-schedule/lich-bieu/update-plan/' . $findToDel->id, [
            'title' => 'Đăng ký kế hoạch học tập Khoá 29 HK1 KTPM update', //title
            'body' => '2', //major
            'raw' => '6', // course
            'start' => Carbon::now('Asia/Ho_Chi_Minh'),
            'end' => Carbon::tomorrow('Asia/Ho_Chi_Minh'),
            'calendarId' => '0', //type
            'location' => '1',  //semester
            'recurrenceRule' => '14', //credit
            'bgColor' => '#f4cc60',
            'subject' => ['15']
        ]);

        $check = $response->assertStatus(200);
        if ($check == true) {
            $findSubjectCalendarPlan = CalendarPlan::where('calendar_id', $findToDel->id)->get();
            foreach ($findSubjectCalendarPlan as $key => $value) {
                $value->delete();
            }
            $findToDel->delete();
        }
    }

    /** @test */
    public function updateCalendarSubjectRegisterSucess()
    {
        $this->json('POST', 'api/admin/calendar-schedule/lich-bieu', [
            'title' => 'Đăng ký môn học Khoá 29 HK1 KTPM', //title
            'body' => '2', //major
            'raw' => '6', // course
            'start' => Carbon::now('Asia/Ho_Chi_Minh'),
            'end' => Carbon::tomorrow('Asia/Ho_Chi_Minh'),
            'calendarId' => '1', //type
            'location' => '1',  //semester
            'recurrenceRule' => '14', //credit
            'bgColor' => '#fd7a86',
        ]);

        $findToDel = Calendar::orderBy('id', 'DESC')->first();

        $response = $this->json('PUT', 'api/admin/calendar-schedule/lich-bieu/' . $findToDel->id, [
            'title' => 'Đăng ký môn học Khoá 29 HK1 KTPM update', //title
            'body' => '2', //major
            'raw' => '6', // course
            'start' => Carbon::now('Asia/Ho_Chi_Minh'),
            'end' => Carbon::tomorrow('Asia/Ho_Chi_Minh'),
            'calendarId' => '1', //type
            'location' => '1',  //semester
            'recurrenceRule' => '14', //credit
            'bgColor' => '#fd7a86',
        ]);

        $check = $response->assertStatus(200);

        if ($check == true) {
            $findToDel->delete();
        }
    }

    /** @test */
    public function updateCalendarExamRegisterSucess()
    {
        $this->json('POST', 'api/admin/calendar-schedule/lich-bieu', [
            'title' => 'Lịch thi học kỳ 1 làn 1 Khoá 29 KTPM', //title
            'body' => '2', //major
            'raw' => '6', // course
            'start' => Carbon::now('Asia/Ho_Chi_Minh'),
            'end' => Carbon::tomorrow('Asia/Ho_Chi_Minh'),
            'calendarId' => '2', //type
            'location' => '1',  //semester
            'bgColor' => '#85a2f2',
        ]);

        $findToDel = Calendar::orderBy('id', 'DESC')->first();

        $response = $this->json('PUT', 'api/admin/calendar-schedule/lich-bieu/' . $findToDel->id, [
            'title' => 'Lịch thi học kỳ 1 làn 1 Khoá 29 KTPM update', //title
            'body' => '2', //major
            'raw' => '6', // course
            'start' => Carbon::now('Asia/Ho_Chi_Minh'),
            'end' => Carbon::tomorrow('Asia/Ho_Chi_Minh'),
            'calendarId' => '2', //type
            'location' => '1',  //semester
            'bgColor' => '#85a2f2',
        ]);

        $check = $response->assertStatus(200);

        if ($check == true) {
            $findToDel->delete();
        }
    }

    /** @test */
    public function updateCalendarExamSecondRegisterSucess()
    {
        $this->json('POST', 'api/admin/calendar-schedule/lich-bieu', [
            'title' => 'Lịch thi lần 2 học kỳ 1 Khoá 29 KTPM', //title
            'body' => '2', //major
            'raw' => '6', // course
            'start' => Carbon::now('Asia/Ho_Chi_Minh'),
            'end' => Carbon::tomorrow('Asia/Ho_Chi_Minh'),
            'calendarId' => '3', //type
            'location' => '1',  //semester
            'bgColor' => '#78d9f1',
        ]);

        $findToDel = Calendar::orderBy('id', 'DESC')->first();

        $response = $this->json('PUT', 'api/admin/calendar-schedule/lich-bieu/' . $findToDel->id, [
            'title' => 'Lịch thi lần 2 học kỳ 1 Khoá 29 KTPM update', //title
            'body' => '2', //major
            'raw' => '6', // course
            'start' => Carbon::now('Asia/Ho_Chi_Minh'),
            'end' => Carbon::tomorrow('Asia/Ho_Chi_Minh'),
            'calendarId' => '3', //type
            'location' => '1',  //semester
            'bgColor' => '#78d9f1',
        ]);

        $check = $response->assertStatus(200);

        if ($check == true) {
            $findToDel->delete();
        }
    }

    /** @test */
    public function updateCalendarTrainingPointSucess()
    {
        $this->json('POST', 'api/admin/calendar-schedule/lich-bieu', [
            'title' => 'Đánh giá điểm rèn luyện HK1 K29 KTPM', //title
            'body' => '2', //major
            'raw' => '6', // course
            'start' => Carbon::now('Asia/Ho_Chi_Minh'),
            'end' => Carbon::tomorrow('Asia/Ho_Chi_Minh'),
            'calendarId' => '4', //type
            'location' => '1',  //semester
            'recurrenceRule' => '0', //object
            'bgColor' => '#86dc9a',
        ]);

        $findToDel = Calendar::orderBy('id', 'DESC')->first();

        $response = $this->json('PUT', 'api/admin/calendar-schedule/lich-bieu/' . $findToDel->id, [
            'title' => 'Đánh giá điểm rèn luyện HK1 K29 KTPM update', //title
            'body' => '2', //major
            'raw' => '6', // course
            'start' => Carbon::now('Asia/Ho_Chi_Minh'),
            'end' => Carbon::tomorrow('Asia/Ho_Chi_Minh'),
            'calendarId' => '4', //type
            'location' => '1',  //semester
            'recurrenceRule' => '0', //object
            'bgColor' => '#86dc9a',
        ]);

        $check = $response->assertStatus(200);

        if ($check == true) {
            $findToDel->delete();
        }
    }

    /** @test */
    public function updateCalendarTuitionPaySucess()
    {
        $this->json('POST', 'api/admin/calendar-schedule/lich-bieu', [
            'title' => 'Đóng học phí Khoá 29 HK1 KTPM', //title
            'body' => '2', //major
            'raw' => '6', // course
            'start' => Carbon::now('Asia/Ho_Chi_Minh'),
            'end' => Carbon::tomorrow('Asia/Ho_Chi_Minh'),
            'calendarId' => '5', //type
            'location' => '1',  //semester
            'bgColor' => '#d50fd9'
        ]);

        $findToDel = Calendar::orderBy('id', 'DESC')->first();

        $response = $this->json('PUT', 'api/admin/calendar-schedule/lich-bieu/' . $findToDel->id, [
            'title' => 'Đóng học phí Khoá 29 HK1 KTPM update', //title
            'body' => '2', //major
            'raw' => '6', // course
            'start' => Carbon::now('Asia/Ho_Chi_Minh'),
            'end' => Carbon::tomorrow('Asia/Ho_Chi_Minh'),
            'calendarId' => '5', //type
            'location' => '1',  //semester
            'bgColor' => '#d50fd9'
        ]);

        $check = $response->assertStatus(200);

        if ($check == true) {
            $findStudent = Payment::join('tbl_student', 'tbl_student.student_id', '=', 'tbl_payment.payment_student')
                ->where('tbl_student.student_course', $findToDel->raw)
                ->where('tbl_student.student_major', $findToDel->body)
                ->where('tbl_payment.payment_semester', $findToDel->location)->get();
            foreach ($findStudent as $key => $value) {
                $value->delete();
            }
            $findToDel->delete();
        }
    }

    /** @test */
    public function updateCalendarTitleEmptyError()
    {
        $this->json('POST', 'api/admin/calendar-schedule/lich-bieu', [
            'title' => 'Đăng ký môn học Khoá 29 HK1 KTPM', //title
            'body' => '2', //major
            'raw' => '6', // course
            'start' => Carbon::now('Asia/Ho_Chi_Minh'),
            'end' => Carbon::tomorrow('Asia/Ho_Chi_Minh'),
            'calendarId' => '1', //type
            'location' => '1',  //semester
            'recurrenceRule' => '14', //credit
            'bgColor' => '#fd7a86',
        ]);

        $findToDel = Calendar::orderBy('id', 'DESC')->first();

        $response = $this->json('PUT', 'api/admin/calendar-schedule/lich-bieu/' . $findToDel->id, [
            'title' => '', //title
            'body' => '2', //major
            'raw' => '6', // course
            'start' => Carbon::now('Asia/Ho_Chi_Minh'),
            'end' => Carbon::tomorrow('Asia/Ho_Chi_Minh'),
            'calendarId' => '1', //type
            'location' => '1',  //semester
            'recurrenceRule' => '14', //credit
            'bgColor' => '#fd7a86',
        ]);

        $check = $response->assertStatus(422);

        if ($check == true) {
            $findToDel->delete();
        }
    }

    /** @test */
    public function updateCalendarTitleMaxLengthError()
    {
        $this->json('POST', 'api/admin/calendar-schedule/lich-bieu', [
            'title' => 'Đăng ký môn học Khoá 29 HK1 KTPM', //title
            'body' => '2', //major
            'raw' => '6', // course
            'start' => Carbon::now('Asia/Ho_Chi_Minh'),
            'end' => Carbon::tomorrow('Asia/Ho_Chi_Minh'),
            'calendarId' => '1', //type
            'location' => '1',  //semester
            'recurrenceRule' => '14', //credit
            'bgColor' => '#fd7a86',
        ]);

        $findToDel = Calendar::orderBy('id', 'DESC')->first();

        $response = $this->json('PUT', 'api/admin/calendar-schedule/lich-bieu/' . $findToDel->id, [
            'title' => '6c38b8bd623b61ssdfsfsdfsdfsdfsdfsadfsadfjhsdakfhjskadfhjksadhfjksahfkjashdfhsadfhasjkdfhsadjklfhsdajkfhjksadfhjksahfkjsafjksadhfjkasdhfjkshfjksdnkvjnkjfnejkurhfjksnfkjsdhnfjkhwjkfsdfjss1d24eeb555ad4aba81', //title
            'body' => '2', //major
            'raw' => '6', // course
            'start' => Carbon::now('Asia/Ho_Chi_Minh'),
            'end' => Carbon::tomorrow('Asia/Ho_Chi_Minh'),
            'calendarId' => '1', //type
            'location' => '1',  //semester
            'recurrenceRule' => '14', //credit
            'bgColor' => '#fd7a86',
        ]);

        $check = $response->assertStatus(422);

        if ($check == true) {
            $findToDel->delete();
        }
    }

    /** @test */
    public function updateCalendarTitleMinLengthError()
    {
        $this->json('POST', 'api/admin/calendar-schedule/lich-bieu', [
            'title' => 'Đăng ký môn học Khoá 29 HK1 KTPM', //title
            'body' => '2', //major
            'raw' => '6', // course
            'start' => Carbon::now('Asia/Ho_Chi_Minh'),
            'end' => Carbon::tomorrow('Asia/Ho_Chi_Minh'),
            'calendarId' => '1', //type
            'location' => '1',  //semester
            'recurrenceRule' => '14', //credit
            'bgColor' => '#fd7a86',
        ]);

        $findToDel = Calendar::orderBy('id', 'DESC')->first();

        $response = $this->json('PUT', 'api/admin/calendar-schedule/lich-bieu/' . $findToDel->id, [
            'title' => 'Hello', //title
            'body' => '2', //major
            'raw' => '6', // course
            'start' => Carbon::now('Asia/Ho_Chi_Minh'),
            'end' => Carbon::tomorrow('Asia/Ho_Chi_Minh'),
            'calendarId' => '1', //type
            'location' => '1',  //semester
            'recurrenceRule' => '14', //credit
            'bgColor' => '#fd7a86',
        ]);

        $check = $response->assertStatus(422);

        if ($check == true) {
            $findToDel->delete();
        }
    }

    /** @test */
    public function updateCalendarTitleExistError()
    {
        $this->json('POST', 'api/admin/calendar-schedule/lich-bieu', [
            'title' => 'Đăng ký môn học Khoá 29 HK1 KTPM', //title
            'body' => '2', //major
            'raw' => '6', // course
            'start' => Carbon::now('Asia/Ho_Chi_Minh'),
            'end' => Carbon::tomorrow('Asia/Ho_Chi_Minh'),
            'calendarId' => '1', //type
            'location' => '1',  //semester
            'recurrenceRule' => '14', //credit
            'bgColor' => '#fd7a86',
        ]);

        $findToDel = Calendar::orderBy('id', 'DESC')->first();

        $response = $this->json('PUT', 'api/admin/calendar-schedule/lich-bieu/' . $findToDel->id, [
            'title' => 'Đăng ký kế hoạch học tập K24 KTPM HK1', //title
            'body' => '2', //major
            'raw' => '6', // course
            'start' => Carbon::now('Asia/Ho_Chi_Minh'),
            'end' => Carbon::tomorrow('Asia/Ho_Chi_Minh'),
            'calendarId' => '1', //type
            'location' => '1',  //semester
            'recurrenceRule' => '14', //credit
            'bgColor' => '#fd7a86',
        ]);

        $check = $response->assertStatus(422);

        if ($check == true) {
            $findToDel->delete();
        }
    }

    /** @test */
    public function updateCalendarTitleSpecialCharacterError()
    {
        $this->json('POST', 'api/admin/calendar-schedule/lich-bieu', [
            'title' => 'Đăng ký môn học Khoá 29 HK1 KTPM', //title
            'body' => '2', //major
            'raw' => '6', // course
            'start' => Carbon::now('Asia/Ho_Chi_Minh'),
            'end' => Carbon::tomorrow('Asia/Ho_Chi_Minh'),
            'calendarId' => '1', //type
            'location' => '1',  //semester
            'recurrenceRule' => '14', //credit
            'bgColor' => '#fd7a86',
        ]);

        $findToDel = Calendar::orderBy('id', 'DESC')->first();

        $response = $this->json('PUT', 'api/admin/calendar-schedule/lich-bieu/' . $findToDel->id, [
            'title' => 'Helllo #$%#$%#$%', //title
            'body' => '2', //major
            'raw' => '6', // course
            'start' => Carbon::now('Asia/Ho_Chi_Minh'),
            'end' => Carbon::tomorrow('Asia/Ho_Chi_Minh'),
            'calendarId' => '1', //type
            'location' => '1',  //semester
            'recurrenceRule' => '14', //credit
            'bgColor' => '#fd7a86',
        ]);

        $check = $response->assertStatus(422);

        if ($check == true) {
            $findToDel->delete();
        }
    }

    /** @test */
    public function updateCalendarCourseEmptyError()
    {
        $this->json('POST', 'api/admin/calendar-schedule/lich-bieu', [
            'title' => 'Đăng ký môn học Khoá 29 HK1 KTPM', //title
            'body' => '2', //major
            'raw' => '6', // course
            'start' => Carbon::now('Asia/Ho_Chi_Minh'),
            'end' => Carbon::tomorrow('Asia/Ho_Chi_Minh'),
            'calendarId' => '1', //type
            'location' => '1',  //semester
            'recurrenceRule' => '14', //credit
            'bgColor' => '#fd7a86',
        ]);

        $findToDel = Calendar::orderBy('id', 'DESC')->first();

        $response = $this->json('PUT', 'api/admin/calendar-schedule/lich-bieu/' . $findToDel->id, [
            'title' => 'Đăng ký môn học Khoá 29 HK1 KTPM', //title
            'body' => '2', //major
            'raw' => '', // course
            'start' => Carbon::now('Asia/Ho_Chi_Minh'),
            'end' => Carbon::tomorrow('Asia/Ho_Chi_Minh'),
            'calendarId' => '1', //type
            'location' => '1',  //semester
            'recurrenceRule' => '14', //credit
            'bgColor' => '#fd7a86',
        ]);

        $check = $response->assertStatus(422);

        if ($check == true) {
            $findToDel->delete();
        }
    }

    /** @test */
    public function updateCalendarMajorEmptyError()
    {
        $this->json('POST', 'api/admin/calendar-schedule/lich-bieu', [
            'title' => 'Đăng ký môn học Khoá 29 HK1 KTPM', //title
            'body' => '2', //major
            'raw' => '6', // course
            'start' => Carbon::now('Asia/Ho_Chi_Minh'),
            'end' => Carbon::tomorrow('Asia/Ho_Chi_Minh'),
            'calendarId' => '1', //type
            'location' => '1',  //semester
            'recurrenceRule' => '14', //credit
            'bgColor' => '#fd7a86',
        ]);

        $findToDel = Calendar::orderBy('id', 'DESC')->first();

        $response = $this->json('PUT', 'api/admin/calendar-schedule/lich-bieu/' . $findToDel->id, [
            'title' => 'Đăng ký môn học Khoá 29 HK1 KTPM', //title
            'body' => '', //major
            'raw' => '6', // course
            'start' => Carbon::now('Asia/Ho_Chi_Minh'),
            'end' => Carbon::tomorrow('Asia/Ho_Chi_Minh'),
            'calendarId' => '1', //type
            'location' => '1',  //semester
            'recurrenceRule' => '14', //credit
            'bgColor' => '#fd7a86',
        ]);

        $check = $response->assertStatus(422);

        if ($check == true) {
            $findToDel->delete();
        }
    }

    /** @test */
    public function updateCalendarStartEmptyError()
    {
        $this->json('POST', 'api/admin/calendar-schedule/lich-bieu', [
            'title' => 'Đăng ký môn học Khoá 29 HK1 KTPM', //title
            'body' => '2', //major
            'raw' => '6', // course
            'start' => Carbon::now('Asia/Ho_Chi_Minh'),
            'end' => Carbon::tomorrow('Asia/Ho_Chi_Minh'),
            'calendarId' => '1', //type
            'location' => '1',  //semester
            'recurrenceRule' => '14', //credit
            'bgColor' => '#fd7a86',
        ]);

        $findToDel = Calendar::orderBy('id', 'DESC')->first();

        $response = $this->json('PUT', 'api/admin/calendar-schedule/lich-bieu/' . $findToDel->id, [
            'title' => 'Đăng ký môn học Khoá 29 HK1 KTPM', //title
            'body' => '2', //major
            'raw' => '6', // course
            'start' => '',
            'end' => Carbon::tomorrow('Asia/Ho_Chi_Minh'),
            'calendarId' => '1', //type
            'location' => '1',  //semester
            'recurrenceRule' => '14', //credit
            'bgColor' => '#fd7a86',
        ]);

        $check = $response->assertStatus(422);

        if ($check == true) {
            $findToDel->delete();
        }
    }

    /** @test */
    public function updateCalendarEndEmptyError()
    {
        $this->json('POST', 'api/admin/calendar-schedule/lich-bieu', [
            'title' => 'Đăng ký môn học Khoá 29 HK1 KTPM', //title
            'body' => '2', //major
            'raw' => '6', // course
            'start' => Carbon::now('Asia/Ho_Chi_Minh'),
            'end' => Carbon::tomorrow('Asia/Ho_Chi_Minh'),
            'calendarId' => '1', //type
            'location' => '1',  //semester
            'recurrenceRule' => '14', //credit
            'bgColor' => '#fd7a86',
        ]);

        $findToDel = Calendar::orderBy('id', 'DESC')->first();

        $response = $this->json('PUT', 'api/admin/calendar-schedule/lich-bieu/' . $findToDel->id, [
            'title' => 'Đăng ký môn học Khoá 29 HK1 KTPM', //title
            'body' => '2', //major
            'raw' => '6', // course
            'start' => Carbon::now('Asia/Ho_Chi_Minh'),
            'end' => '',
            'calendarId' => '1', //type
            'location' => '1',  //semester
            'recurrenceRule' => '14', //credit
            'bgColor' => '#fd7a86',
        ]);

        $check = $response->assertStatus(422);

        if ($check == true) {
            $findToDel->delete();
        }
    }

    /** @test */
    public function updateCalendarTypeEmptyError()
    {
        $this->json('POST', 'api/admin/calendar-schedule/lich-bieu', [
            'title' => 'Đăng ký môn học Khoá 29 HK1 KTPM', //title
            'body' => '2', //major
            'raw' => '6', // course
            'start' => Carbon::now('Asia/Ho_Chi_Minh'),
            'end' => Carbon::tomorrow('Asia/Ho_Chi_Minh'),
            'calendarId' => '1', //type
            'location' => '1',  //semester
            'recurrenceRule' => '14', //credit
            'bgColor' => '#fd7a86',
        ]);

        $findToDel = Calendar::orderBy('id', 'DESC')->first();

        $response = $this->json('PUT', 'api/admin/calendar-schedule/lich-bieu/' . $findToDel->id, [
            'title' => 'Đăng ký môn học Khoá 29 HK1 KTPM', //title
            'body' => '2', //major
            'raw' => '6', // course
            'start' => Carbon::now('Asia/Ho_Chi_Minh'),
            'end' => Carbon::tomorrow('Asia/Ho_Chi_Minh'),
            'calendarId' => '', //type
            'location' => '1',  //semester
            'recurrenceRule' => '14', //credit
            'bgColor' => '#fd7a86',
        ]);

        $check = $response->assertStatus(422);

        if ($check == true) {
            $findToDel->delete();
        }
    }

    /** @test */
    public function updateCalendarMaxLengthSemesterError()
    {
        $this->json('POST', 'api/admin/calendar-schedule/lich-bieu', [
            'title' => 'Đăng ký môn học Khoá 29 HK1 KTPM', //title
            'body' => '2', //major
            'raw' => '6', // course
            'start' => Carbon::now('Asia/Ho_Chi_Minh'),
            'end' => Carbon::tomorrow('Asia/Ho_Chi_Minh'),
            'calendarId' => '1', //type
            'location' => '1',  //semester
            'recurrenceRule' => '14', //credit
            'bgColor' => '#fd7a86',
        ]);

        $findToDel = Calendar::orderBy('id', 'DESC')->first();

        $response = $this->json('PUT', 'api/admin/calendar-schedule/lich-bieu/' . $findToDel->id, [
            'title' => 'Đăng ký môn học Khoá 29 HK1 KTPM', //title
            'body' => '2', //major
            'raw' => '6', // course
            'start' => Carbon::now('Asia/Ho_Chi_Minh'),
            'end' => Carbon::tomorrow('Asia/Ho_Chi_Minh'),
            'calendarId' => '1', //type
            'location' => '111111111111111111111111111111111111111111111',  //semester
            'recurrenceRule' => '14', //credit
            'bgColor' => '#fd7a86',
        ]);

        $check = $response->assertStatus(422);

        if ($check == true) {
            $findToDel->delete();
        }
    }

    /** @test */
    public function updateCalendarMaxLengthCreditError()
    {
        $this->json('POST', 'api/admin/calendar-schedule/lich-bieu', [
            'title' => 'Đăng ký môn học Khoá 29 HK1 KTPM', //title
            'body' => '2', //major
            'raw' => '6', // course
            'start' => Carbon::now('Asia/Ho_Chi_Minh'),
            'end' => Carbon::tomorrow('Asia/Ho_Chi_Minh'),
            'calendarId' => '1', //type
            'location' => '1',  //semester
            'recurrenceRule' => '14', //credit
            'bgColor' => '#fd7a86',
        ]);

        $findToDel = Calendar::orderBy('id', 'DESC')->first();

        $response = $this->json('PUT', 'api/admin/calendar-schedule/lich-bieu/' . $findToDel->id, [
            'title' => 'Đăng ký môn học Khoá 29 HK1 KTPM', //title
            'body' => '2', //major
            'raw' => '6', // course
            'start' => Carbon::now('Asia/Ho_Chi_Minh'),
            'end' => Carbon::tomorrow('Asia/Ho_Chi_Minh'),
            'calendarId' => '1', //type
            'location' => '1',  //semester
            'recurrenceRule' => '141212121313131313131313', //credit
            'bgColor' => '#fd7a86',
        ]);

        $check = $response->assertStatus(422);

        if ($check == true) {
            $findToDel->delete();
        }
    }

    /** @test */
    public function deleteCalendarSucess()
    {
        $this->json('POST', 'api/admin/calendar-schedule/lich-bieu', [
            'title' => 'Đăng ký môn học Khoá 29 HK1 KTPM', //title
            'body' => '2', //major
            'raw' => '6', // course
            'start' => Carbon::now('Asia/Ho_Chi_Minh'),
            'end' => Carbon::tomorrow('Asia/Ho_Chi_Minh'),
            'calendarId' => '1', //type
            'location' => '1',  //semester
            'recurrenceRule' => '14', //credit
            'bgColor' => '#fd7a86',
        ]);

        $findToDel = Calendar::orderBy('id', 'DESC')->first();

        $response = $this->json('DELETE', 'api/admin/calendar-schedule/lich-bieu/' . $findToDel->id);
        $response->assertStatus(200);
    }
}
