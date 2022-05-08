<?php

namespace Tests\Unit\Controllers\Student\Registration;

use App\Models\CalendarSubject;
use App\Models\RegisterSubject;
use Tests\TestCase;

class SubjectRegisterTest extends TestCase
{
    /** @test */
    public function registerSubjectSucess()
    {
        $subjects = ['32', '34', '43', '45'];
        $response = $this->json('POST', 'api/student/subject-register/dang-ky-mon-hoc', [
            'student_id' => '11',
            'subject' => $subjects,
            'semester' => '1',
            'yearstart' => '2022',
            'yearend' => '2023',
        ]);
        $check = $response->assertStatus(200);
        if ($check == true) {
            foreach ($subjects as $key => $value) {
                $desQuantity = CalendarSubject::where('calendar_subject_id', $value)->get();
                foreach ($desQuantity as $key => $quantity) {
                    $quantity->calendar_subject_registered = $quantity->calendar_subject_registered - 1;
                    $quantity->save();
                }
            }
            $findToDel = RegisterSubject::orderBy('register_subject_id', 'DESC')->limit(4)->get();
            foreach ($findToDel as $key => $del) {
                $del->delete();
            }
        }
    }

    /** @test */
    public function registerSubjectEmptyError()
    {
        $response = $this->json('POST', 'api/student/subject-register/dang-ky-mon-hoc', [
            'student_id' => '11',
            'subject' => '',
            'semester' => '1',
            'yearstart' => '2022',
            'yearend' => '2023',
        ]);
        $check = $response->assertStatus(422);
    }

    /** @test */
    public function deleteRegisterSubjectSucess()
    {
        $subjects = ['32'];
        $this->json('POST', 'api/student/subject-register/dang-ky-mon-hoc', [
            'student_id' => '11',
            'subject' => $subjects,
            'semester' => '1',
            'yearstart' => '2022',
            'yearend' => '2023',
        ]);

        $findToDel = RegisterSubject::orderBy('register_subject_id', 'DESC')->first();

        $response = $this->json('DELETE', 'api/student/subject-register/dang-ky-mon-hoc/' . $findToDel->register_subject_id);
        $check = $response->assertStatus(200);
        if ($check == true) {
            foreach ($subjects as $key => $value) {
                $desQuantity = CalendarSubject::where('calendar_subject_id', $value)->get();
                foreach ($desQuantity as $key => $quantity) {
                    $quantity->calendar_subject_registered = $quantity->calendar_subject_registered - 1;
                    $quantity->save();
                }
            }
        }
    }

    /** @test */
    public function cancelRegisterSubjectSucess()
    {
        $subjects = ['32'];
        $this->json('POST', 'api/student/subject-register/dang-ky-mon-hoc', [
            'student_id' => '11',
            'subject' => $subjects,
            'semester' => '1',
            'yearstart' => '2022',
            'yearend' => '2023',
        ]);

        $findToDel = RegisterSubject::orderBy('register_subject_id', 'DESC')->first();
        $desQuantity = CalendarSubject::where('calendar_subject_id', $findToDel->register_subject_program)->first();

        $response = $this->json('POST', 'api/student/subject-register/dang-ky-mon-hoc/huy-mon-hoc/' . $desQuantity->calendar_subject_id . '/' . $findToDel->register_subject_id);
        $check = $response->assertStatus(200);
        if ($check == true) {
            $desQuantity->calendar_subject_registered = $desQuantity->calendar_subject_registered - 1;
            $desQuantity->save();
        }
    }

    /** @test */
    public function changeRegisterSubjectSucess()
    {;
        $this->json('POST', 'api/student/subject-register/dang-ky-mon-hoc', [
            'student_id' => '11',
            'subject' => ['32'],
            'semester' => '1',
            'yearstart' => '2022',
            'yearend' => '2023',
        ]);

        $findToDel = RegisterSubject::orderBy('register_subject_id', 'DESC')->first();
        $desQuantity = CalendarSubject::where('calendar_subject_id', $findToDel->register_subject_program)->first();
        $desQuantity->calendar_subject_registered = $desQuantity->calendar_subject_registered - 1;
        $desQuantity->save();

        $response = $this->json('POST', 'api/student/subject-register/dang-ky-mon-hoc/thay-doi-mon-hoc/' . $desQuantity->calendar_subject_id . '/' . $findToDel->register_subject_id, [
            'student_id' => '11',
            'subject' => ['45'],
            'semester' => '1',
            'yearstart' => '2022',
            'yearend' => '2023',
        ]);
        $check = $response->assertStatus(200);
        if ($check == true) {
            $quantity = CalendarSubject::where('calendar_subject_id', 45)->first();
            $quantity->calendar_subject_registered = $quantity->calendar_subject_registered - 1;
            $quantity->save();
        }
    }
}
