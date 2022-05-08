<?php

namespace Tests\Unit\Controllers\Admin\Calendar;

use App\Models\ExamSecond;
use App\Models\Notification;
use Tests\TestCase;

class ExamSecondTest extends TestCase
{
    /** @test */
    public function storeExamSecondExistSucess()
    {
        $response = $this->json('POST', 'api/admin/exam-second/dang-ky-thi-lan-2', [
            'subject' => ['19'],
            'student_id' => '11',
        ]);
        $check = $response->assertStatus(200);
        if ($check == true) {
            $findToDel = ExamSecond::where('exam_second_subject', 19)->first();
            $findToDel->exam_second_quantity = $findToDel->exam_second_quantity - 1;
            $findToDel->save();
        }
    }

    /** @test */
    public function storeExamSecondNewSucess()
    {
        $response = $this->json('POST', 'api/admin/exam-second/dang-ky-thi-lan-2', [
            'subject' => ['17'],
            'student_id' => '11',
        ]);
        $check = $response->assertStatus(200);
        if ($check == true) {
            $delNoti = Notification::where('notification_object', 1)->where('notification_type', 'subject')
                ->where('notification_status', 0)->orderby('notification_id', 'DESC')->first();
            $delNoti->delete();
            $findToDel = ExamSecond::where('exam_second_subject', 17)->first();
            $findToDel->delete();
        }
    }

    /** @test */
    public function storeExamSecondSubjectEmptyError()
    {
        $response = $this->json('POST', 'api/admin/exam-second/dang-ky-thi-lan-2', [
            'subject' => '',
            'student_id' => '11',
        ]);
        $check = $response->assertStatus(422);
    }

    /** @test */
    public function cancelExamSecondExistSucess()
    {
        $this->json('POST', 'api/admin/exam-second/dang-ky-thi-lan-2', [
            'subject' => ['19'],
            'student_id' => '11',
        ]);

        $findToDel = ExamSecond::where('exam_second_subject', 19)->first();

        $response = $this->json('POST', 'api/admin/exam-second/dang-ky-thi-lan-2/huy-bo/11/' . $findToDel->exam_second_subject);
        $response->assertStatus(200);
    }

    /** @test */
    public function cancelExamSecondSucess()
    {
        $this->json('POST', 'api/admin/exam-second/dang-ky-thi-lan-2', [
            'subject' => ['17'],
            'student_id' => '11',
        ]);

        $findToDel = ExamSecond::where('exam_second_subject', 17)->first();

        $response = $this->json('POST', 'api/admin/exam-second/dang-ky-thi-lan-2/huy-bo/11/' . $findToDel->exam_second_subject);
        $response->assertStatus(200);
    }
}
