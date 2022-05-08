<?php

namespace Tests\Unit\Controllers\Admin\Calendar;

use App\Models\CalendarExam;
use Tests\TestCase;

class CalendarExamTest extends TestCase
{
    /** @test */
    public function storeCalendarExamSucess()
    {
        $response = $this->json('POST', 'api/admin/calendar-exam/lich-thi', [
            'calendar_exam_schedule' => '304',
            'calendar_exam_subject' => '5',
            'calendar_exam_room' => 'C02',
            'calendar_exam_method' => '0',
            'calendar_exam_place' => 'Phòng 12.6',
            'calendar_exam_semester' => '1',
            'calendar_exam_note' => '',
        ]);
        $check = $response->assertStatus(200);
        if ($check == true) {
            $findToDel = CalendarExam::orderBy('calendar_exam_id', 'DESC')->first();
            $findToDel->delete();
        }
    }

    /** @test */
    public function storeCalendarExamScheduleEmptyError()
    {
        $response = $this->json('POST', 'api/admin/calendar-exam/lich-thi', [
            'calendar_exam_schedule' => '',
            'calendar_exam_subject' => '5',
            'calendar_exam_room' => 'C02',
            'calendar_exam_method' => '0',
            'calendar_exam_place' => 'Phòng 12.6',
            'calendar_exam_semester' => '1',
            'calendar_exam_note' => '',
        ]);
        $check = $response->assertStatus(422);
    }

    /** @test */
    public function storeCalendarExamSubjectEmptyError()
    {
        $response = $this->json('POST', 'api/admin/calendar-exam/lich-thi', [
            'calendar_exam_schedule' => '304',
            'calendar_exam_subject' => '',
            'calendar_exam_room' => 'C02',
            'calendar_exam_method' => '0',
            'calendar_exam_place' => 'Phòng 12.6',
            'calendar_exam_semester' => '1',
            'calendar_exam_note' => '',
        ]);
        $check = $response->assertStatus(422);
    }

    /** @test */
    public function storeCalendarExamRoomEmptyError()
    {
        $response = $this->json('POST', 'api/admin/calendar-exam/lich-thi', [
            'calendar_exam_schedule' => '304',
            'calendar_exam_subject' => '5',
            'calendar_exam_room' => '',
            'calendar_exam_method' => '0',
            'calendar_exam_place' => 'Phòng 12.6',
            'calendar_exam_semester' => '1',
            'calendar_exam_note' => '',
        ]);
        $check = $response->assertStatus(422);
    }

    /** @test */
    public function storeCalendarExamRoomMaxLengthError()
    {
        $response = $this->json('POST', 'api/admin/calendar-exam/lich-thi', [
            'calendar_exam_schedule' => '304',
            'calendar_exam_subject' => '5',
            'calendar_exam_room' => 'C20C20C20C20C20C20C20C20C20C20C20C20C20C20',
            'calendar_exam_method' => '0',
            'calendar_exam_place' => 'Phòng 12.6',
            'calendar_exam_semester' => '1',
            'calendar_exam_note' => '',
        ]);
        $check = $response->assertStatus(422);
    }

    /** @test */
    public function storeCalendarExamRoomSpecialCharacterError()
    {
        $response = $this->json('POST', 'api/admin/calendar-exam/lich-thi', [
            'calendar_exam_schedule' => '304',
            'calendar_exam_subject' => '5',
            'calendar_exam_room' => 'C20C@#$@#$',
            'calendar_exam_method' => '0',
            'calendar_exam_place' => 'Phòng 12.6',
            'calendar_exam_semester' => '1',
            'calendar_exam_note' => '',
        ]);
        $check = $response->assertStatus(422);
    }

    /** @test */
    public function storeCalendarExamMethodEmptyError()
    {
        $response = $this->json('POST', 'api/admin/calendar-exam/lich-thi', [
            'calendar_exam_schedule' => '304',
            'calendar_exam_subject' => '5',
            'calendar_exam_room' => 'C20',
            'calendar_exam_method' => '',
            'calendar_exam_place' => 'Phòng 12.6',
            'calendar_exam_semester' => '1',
            'calendar_exam_note' => '',
        ]);
        $check = $response->assertStatus(422);
    }

    /** @test */
    public function storeCalendarExamPlaceEmptyError()
    {
        $response = $this->json('POST', 'api/admin/calendar-exam/lich-thi', [
            'calendar_exam_schedule' => '304',
            'calendar_exam_subject' => '5',
            'calendar_exam_room' => 'C20',
            'calendar_exam_method' => '0',
            'calendar_exam_place' => '',
            'calendar_exam_semester' => '1',
            'calendar_exam_note' => '',
        ]);
        $check = $response->assertStatus(422);
    }

    /** @test */
    public function storeCalendarExamPlaceMaxLengthError()
    {
        $response = $this->json('POST', 'api/admin/calendar-exam/lich-thi', [
            'calendar_exam_schedule' => '304',
            'calendar_exam_subject' => '5',
            'calendar_exam_room' => 'C20',
            'calendar_exam_method' => '0',
            'calendar_exam_place' => 'Phòng 12.6Phòng 12.6Phòng 12.6Phòng 12.6Phòng 12.6Phòng 12.6Phòng 12.6Phòng 12.6Phòng 12.6Phòng 12.6Phòng 12.6Phòng 12.6Phòng 12.6Phòng 12.6Phòng 12.6Phòng 12.6Phòng 12.6Phòng 12.6Phòng 12.6Phòng 12.6Phòng 12.6Phòng 12.6Phòng 12.6Phòng 12.6Phòng 12.6Phòng 12.6Phòng 12.6Phòng 12.6Phòng 12.6Phòng 12.6Phòng 12.6Phòng 12.6Phòng 12.6Phòng 12.6Phòng 12.6',
            'calendar_exam_semester' => '1',
            'calendar_exam_note' => '',
        ]);
        $check = $response->assertStatus(422);
    }

    /** @test */
    public function storeCalendarExamSemesterEmptyError()
    {
        $response = $this->json('POST', 'api/admin/calendar-exam/lich-thi', [
            'calendar_exam_schedule' => '304',
            'calendar_exam_subject' => '5',
            'calendar_exam_room' => 'C20',
            'calendar_exam_method' => '0',
            'calendar_exam_place' => 'Phòng 12.6',
            'calendar_exam_semester' => '',
            'calendar_exam_note' => '',
        ]);
        $check = $response->assertStatus(422);
    }

    /** @test */
    public function storeCalendarExamSemesterMaxLengthError()
    {
        $response = $this->json('POST', 'api/admin/calendar-exam/lich-thi', [
            'calendar_exam_schedule' => '304',
            'calendar_exam_subject' => '5',
            'calendar_exam_room' => 'C20',
            'calendar_exam_method' => '0',
            'calendar_exam_place' => 'Phòng 12.6',
            'calendar_exam_semester' => '11111111111111111111111111111111111111111111111111111111111111111111111',
            'calendar_exam_note' => '',
        ]);
        $check = $response->assertStatus(422);
    }

    /** @test */
    public function storeCalendarExamNoteMaxLengthError()
    {
        $response = $this->json('POST', 'api/admin/calendar-exam/lich-thi', [
            'calendar_exam_schedule' => '304',
            'calendar_exam_subject' => '5',
            'calendar_exam_room' => 'C20',
            'calendar_exam_method' => '0',
            'calendar_exam_place' => 'Phòng 12.6',
            'calendar_exam_semester' => '1',
            'calendar_exam_note' => 'NoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteN',
        ]);
        $check = $response->assertStatus(422);
    }

    /** @test */
    public function updateCalendarExamSucess()
    {
        $this->json('POST', 'api/admin/calendar-exam/lich-thi', [
            'calendar_exam_schedule' => '304',
            'calendar_exam_subject' => '5',
            'calendar_exam_room' => 'C02',
            'calendar_exam_method' => '0',
            'calendar_exam_place' => 'Phòng 12.6',
            'calendar_exam_semester' => '1',
            'calendar_exam_note' => '',
        ]);

        $findToDel = CalendarExam::orderBy('calendar_exam_id', 'DESC')->first();

        $response = $this->json('PUT', 'api/admin/calendar-exam/lich-thi/' . $findToDel->calendar_exam_id, [
            'calendar_exam_schedule' => '304',
            'calendar_exam_subject' => '5',
            'calendar_exam_room' => 'C023',
            'calendar_exam_method' => '0',
            'calendar_exam_place' => 'Phòng 12.8',
            'calendar_exam_semester' => '1',
            'calendar_exam_note' => '',
        ]);

        $check = $response->assertStatus(200);
        if ($check == true) {
            $findToDel->delete();
        }
    }

    /** @test */
    public function updateCalendarExamScheduleEmptyError()
    {
        $this->json('POST', 'api/admin/calendar-exam/lich-thi', [
            'calendar_exam_schedule' => '304',
            'calendar_exam_subject' => '5',
            'calendar_exam_room' => 'C02',
            'calendar_exam_method' => '0',
            'calendar_exam_place' => 'Phòng 12.6',
            'calendar_exam_semester' => '1',
            'calendar_exam_note' => '',
        ]);

        $findToDel = CalendarExam::orderBy('calendar_exam_id', 'DESC')->first();

        $response = $this->json('PUT', 'api/admin/calendar-exam/lich-thi/' . $findToDel->calendar_exam_id, [
            'calendar_exam_schedule' => '',
            'calendar_exam_subject' => '5',
            'calendar_exam_room' => 'C023',
            'calendar_exam_method' => '0',
            'calendar_exam_place' => 'Phòng 12.8',
            'calendar_exam_semester' => '1',
            'calendar_exam_note' => '',
        ]);

        $check = $response->assertStatus(422);
        if ($check == true) {
            $findToDel->delete();
        }
    }

    /** @test */
    public function updateCalendarExamSubjectEmptyError()
    {
        $this->json('POST', 'api/admin/calendar-exam/lich-thi', [
            'calendar_exam_schedule' => '304',
            'calendar_exam_subject' => '5',
            'calendar_exam_room' => 'C02',
            'calendar_exam_method' => '0',
            'calendar_exam_place' => 'Phòng 12.6',
            'calendar_exam_semester' => '1',
            'calendar_exam_note' => '',
        ]);

        $findToDel = CalendarExam::orderBy('calendar_exam_id', 'DESC')->first();

        $response = $this->json('PUT', 'api/admin/calendar-exam/lich-thi/' . $findToDel->calendar_exam_id, [
            'calendar_exam_schedule' => '304',
            'calendar_exam_subject' => '',
            'calendar_exam_room' => 'C023',
            'calendar_exam_method' => '0',
            'calendar_exam_place' => 'Phòng 12.8',
            'calendar_exam_semester' => '1',
            'calendar_exam_note' => '',
        ]);

        $check = $response->assertStatus(422);
        if ($check == true) {
            $findToDel->delete();
        }
    }

    /** @test */
    public function updateCalendarExamRoomEmptyError()
    {
        $this->json('POST', 'api/admin/calendar-exam/lich-thi', [
            'calendar_exam_schedule' => '304',
            'calendar_exam_subject' => '5',
            'calendar_exam_room' => 'C02',
            'calendar_exam_method' => '0',
            'calendar_exam_place' => 'Phòng 12.6',
            'calendar_exam_semester' => '1',
            'calendar_exam_note' => '',
        ]);

        $findToDel = CalendarExam::orderBy('calendar_exam_id', 'DESC')->first();

        $response = $this->json('PUT', 'api/admin/calendar-exam/lich-thi/' . $findToDel->calendar_exam_id, [
            'calendar_exam_schedule' => '304',
            'calendar_exam_subject' => '5',
            'calendar_exam_room' => '',
            'calendar_exam_method' => '0',
            'calendar_exam_place' => 'Phòng 12.8',
            'calendar_exam_semester' => '1',
            'calendar_exam_note' => '',
        ]);

        $check = $response->assertStatus(422);
        if ($check == true) {
            $findToDel->delete();
        }
    }

    /** @test */
    public function updateCalendarExamRoomMaxLengthError()
    {
        $this->json('POST', 'api/admin/calendar-exam/lich-thi', [
            'calendar_exam_schedule' => '304',
            'calendar_exam_subject' => '5',
            'calendar_exam_room' => 'C02',
            'calendar_exam_method' => '0',
            'calendar_exam_place' => 'Phòng 12.6',
            'calendar_exam_semester' => '1',
            'calendar_exam_note' => '',
        ]);

        $findToDel = CalendarExam::orderBy('calendar_exam_id', 'DESC')->first();

        $response = $this->json('PUT', 'api/admin/calendar-exam/lich-thi/' . $findToDel->calendar_exam_id, [
            'calendar_exam_schedule' => '304',
            'calendar_exam_subject' => '5',
            'calendar_exam_room' => 'C20C20C20C20C20C20C20C20C20C20C20C20C20C20',
            'calendar_exam_method' => '0',
            'calendar_exam_place' => 'Phòng 12.8',
            'calendar_exam_semester' => '1',
            'calendar_exam_note' => '',
        ]);

        $check = $response->assertStatus(422);
        if ($check == true) {
            $findToDel->delete();
        }
    }

    /** @test */
    public function updateCalendarExamRoomSpecialCharacterError()
    {
        $this->json('POST', 'api/admin/calendar-exam/lich-thi', [
            'calendar_exam_schedule' => '304',
            'calendar_exam_subject' => '5',
            'calendar_exam_room' => 'C02',
            'calendar_exam_method' => '0',
            'calendar_exam_place' => 'Phòng 12.6',
            'calendar_exam_semester' => '1',
            'calendar_exam_note' => '',
        ]);

        $findToDel = CalendarExam::orderBy('calendar_exam_id', 'DESC')->first();

        $response = $this->json('PUT', 'api/admin/calendar-exam/lich-thi/' . $findToDel->calendar_exam_id, [
            'calendar_exam_schedule' => '',
            'calendar_exam_subject' => '5',
            'calendar_exam_room' => 'C023@#$@#$#',
            'calendar_exam_method' => '0',
            'calendar_exam_place' => 'Phòng 12.8',
            'calendar_exam_semester' => '1',
            'calendar_exam_note' => '',
        ]);

        $check = $response->assertStatus(422);
        if ($check == true) {
            $findToDel->delete();
        }
    }

    /** @test */
    public function updateCalendarExamMethodEmptyError()
    {
        $this->json('POST', 'api/admin/calendar-exam/lich-thi', [
            'calendar_exam_schedule' => '304',
            'calendar_exam_subject' => '5',
            'calendar_exam_room' => 'C02',
            'calendar_exam_method' => '0',
            'calendar_exam_place' => 'Phòng 12.6',
            'calendar_exam_semester' => '1',
            'calendar_exam_note' => '',
        ]);

        $findToDel = CalendarExam::orderBy('calendar_exam_id', 'DESC')->first();

        $response = $this->json('PUT', 'api/admin/calendar-exam/lich-thi/' . $findToDel->calendar_exam_id, [
            'calendar_exam_schedule' => '',
            'calendar_exam_subject' => '5',
            'calendar_exam_room' => 'C023',
            'calendar_exam_method' => '',
            'calendar_exam_place' => 'Phòng 12.8',
            'calendar_exam_semester' => '1',
            'calendar_exam_note' => '',
        ]);

        $check = $response->assertStatus(422);
        if ($check == true) {
            $findToDel->delete();
        }
    }

    /** @test */
    public function updateCalendarExamPlaceEmptyError()
    {
        $this->json('POST', 'api/admin/calendar-exam/lich-thi', [
            'calendar_exam_schedule' => '304',
            'calendar_exam_subject' => '5',
            'calendar_exam_room' => 'C02',
            'calendar_exam_method' => '0',
            'calendar_exam_place' => 'Phòng 12.6',
            'calendar_exam_semester' => '1',
            'calendar_exam_note' => '',
        ]);

        $findToDel = CalendarExam::orderBy('calendar_exam_id', 'DESC')->first();

        $response = $this->json('PUT', 'api/admin/calendar-exam/lich-thi/' . $findToDel->calendar_exam_id, [
            'calendar_exam_schedule' => '',
            'calendar_exam_subject' => '5',
            'calendar_exam_room' => 'C023',
            'calendar_exam_method' => '0',
            'calendar_exam_place' => '',
            'calendar_exam_semester' => '1',
            'calendar_exam_note' => '',
        ]);

        $check = $response->assertStatus(422);
        if ($check == true) {
            $findToDel->delete();
        }
    }

    /** @test */
    public function updateCalendarExamPlaceMaxLengthError()
    {
        $this->json('POST', 'api/admin/calendar-exam/lich-thi', [
            'calendar_exam_schedule' => '304',
            'calendar_exam_subject' => '5',
            'calendar_exam_room' => 'C02',
            'calendar_exam_method' => '0',
            'calendar_exam_place' => 'Phòng 12.6',
            'calendar_exam_semester' => '1',
            'calendar_exam_note' => '',
        ]);

        $findToDel = CalendarExam::orderBy('calendar_exam_id', 'DESC')->first();

        $response = $this->json('PUT', 'api/admin/calendar-exam/lich-thi/' . $findToDel->calendar_exam_id, [
            'calendar_exam_schedule' => '',
            'calendar_exam_subject' => '5',
            'calendar_exam_room' => 'C023',
            'calendar_exam_method' => '0',
            'calendar_exam_place' => 'Phòng 12.8Phòng 12.8Phòng 12.8Phòng 12.8Phòng 12.8Phòng 12.8Phòng 12.8Phòng 12.8Phòng 12.8Phòng 12.8Phòng 12.8Phòng 12.8Phòng 12.8Phòng 12.8Phòng 12.8Phòng 12.8Phòng 12.8Phòng 12.8Phòng 12.8Phòng 12.8Phòng 12.8Phòng 12.8Phòng 12.8Phòng 12.8Phòng 12.8Phòng 12.8Phòng 12.8Phòng 12.8Phòng 12.8Phòng 12.8Phòng 12.8Phòng 12.8Phòng 12.8Phòng 12.8Phòng 12.8Phòng 12.8Phòng 12.8Phòng 12.8Phòng 12.8Phòng 12.8Phòng 12.8Phòng 12.8Phòng 12.8Phòng 12.8Phòng 12.8Phòng 12.8Phòng 12.8Phòng 12.8Phòng 12.8Phòng 12.8Phòng 12.8Phòng 12.8',
            'calendar_exam_semester' => '1',
            'calendar_exam_note' => '',
        ]);

        $check = $response->assertStatus(422);
        if ($check == true) {
            $findToDel->delete();
        }
    }

    /** @test */
    public function updateCalendarExamSemesterEmptyError()
    {
        $this->json('POST', 'api/admin/calendar-exam/lich-thi', [
            'calendar_exam_schedule' => '304',
            'calendar_exam_subject' => '5',
            'calendar_exam_room' => 'C02',
            'calendar_exam_method' => '0',
            'calendar_exam_place' => 'Phòng 12.6',
            'calendar_exam_semester' => '1',
            'calendar_exam_note' => '',
        ]);

        $findToDel = CalendarExam::orderBy('calendar_exam_id', 'DESC')->first();

        $response = $this->json('PUT', 'api/admin/calendar-exam/lich-thi/' . $findToDel->calendar_exam_id, [
            'calendar_exam_schedule' => '304',
            'calendar_exam_subject' => '5',
            'calendar_exam_room' => 'C023',
            'calendar_exam_method' => '0',
            'calendar_exam_place' => 'Phòng 12.8',
            'calendar_exam_semester' => '',
            'calendar_exam_note' => '',
        ]);

        $check = $response->assertStatus(422);
        if ($check == true) {
            $findToDel->delete();
        }
    }

    /** @test */
    public function updateCalendarExamSemesterMaxLengthError()
    {
        $this->json('POST', 'api/admin/calendar-exam/lich-thi', [
            'calendar_exam_schedule' => '304',
            'calendar_exam_subject' => '5',
            'calendar_exam_room' => 'C02',
            'calendar_exam_method' => '0',
            'calendar_exam_place' => 'Phòng 12.6',
            'calendar_exam_semester' => '1',
            'calendar_exam_note' => '',
        ]);

        $findToDel = CalendarExam::orderBy('calendar_exam_id', 'DESC')->first();

        $response = $this->json('PUT', 'api/admin/calendar-exam/lich-thi/' . $findToDel->calendar_exam_id, [
            'calendar_exam_schedule' => '304',
            'calendar_exam_subject' => '5',
            'calendar_exam_room' => 'C023',
            'calendar_exam_method' => '0',
            'calendar_exam_place' => 'Phòng 12.8',
            'calendar_exam_semester' => '1111111111111111111111111111111111111111111111111111111111111',
            'calendar_exam_note' => '',
        ]);

        $check = $response->assertStatus(422);
        if ($check == true) {
            $findToDel->delete();
        }
    }

    /** @test */
    public function updateCalendarExamNoteMaxLengthError()
    {
        $this->json('POST', 'api/admin/calendar-exam/lich-thi', [
            'calendar_exam_schedule' => '304',
            'calendar_exam_subject' => '5',
            'calendar_exam_room' => 'C02',
            'calendar_exam_method' => '0',
            'calendar_exam_place' => 'Phòng 12.6',
            'calendar_exam_semester' => '1',
            'calendar_exam_note' => '',
        ]);

        $findToDel = CalendarExam::orderBy('calendar_exam_id', 'DESC')->first();

        $response = $this->json('PUT', 'api/admin/calendar-exam/lich-thi/' . $findToDel->calendar_exam_id, [
            'calendar_exam_schedule' => '304',
            'calendar_exam_subject' => '5',
            'calendar_exam_room' => 'C023',
            'calendar_exam_method' => '0',
            'calendar_exam_place' => 'Phòng 12.8',
            'calendar_exam_semester' => '1',
            'calendar_exam_note' => 'NoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteNoteN',
        ]);

        $check = $response->assertStatus(422);
        if ($check == true) {
            $findToDel->delete();
        }
    }

    /** @test */
    public function deleteCalendarExamSucess()
    {
        $this->json('POST', 'api/admin/calendar-exam/lich-thi', [
            'calendar_exam_schedule' => '304',
            'calendar_exam_subject' => '5',
            'calendar_exam_room' => 'C02',
            'calendar_exam_method' => '0',
            'calendar_exam_place' => 'Phòng 12.6',
            'calendar_exam_semester' => '1',
            'calendar_exam_note' => '',
        ]);

        $findToDel = CalendarExam::orderBy('calendar_exam_id', 'DESC')->first();

        $response = $this->json('DELETE', 'api/admin/calendar-exam/lich-thi/' . $findToDel->calendar_exam_id);
        $response->assertStatus(200);
    }
}
