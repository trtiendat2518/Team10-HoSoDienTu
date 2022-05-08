<?php

namespace Tests\Unit\Controllers\Admin\Calendar;

use App\Models\CalendarSubject;
use Tests\TestCase;
use Carbon\Carbon;

class CalendarSubjectTest extends TestCase
{
    /** @test */
    public function storeCalendarSubjectSucess()
    {
        $calendar_subject_daytime = [
            [
                "calendar_subject_day" => "2,3",
                "calendar_subject_time" => "123,456"
            ],
            [
                "calendar_subject_day" => "4,5",
                "calendar_subject_time" => "789,101112"
            ]
        ];
        $response = $this->json('POST', 'api/admin/calendar-subject/lich-mo-lop-hoc', [
            'calendar_id' => '29',
            'subject_id' => '19',
            'calendar_subject_type' => '1',
            'calendar_subject_slot' => '100',
            'calendar_subject_lecturer' => '69',
            'calendar_subject_start' => Carbon::now('Asia/Ho_Chi_Minh'),
            'calendar_subject_end' => Carbon::tomorrow('Asia/Ho_Chi_Minh'),
            'calendar_subject_daytime' => $calendar_subject_daytime,
        ]);
        $check = $response->assertStatus(200);
        if ($check == true) {
            $findToDel = CalendarSubject::orderBy('calendar_subject_id', 'DESC')->limit(2)->get();
            foreach ($findToDel as $key => $value) {
                $value->delete();
            }
        }
    }

    /** @test */
    public function storeCalendarSubjectCalendarIdEmptyError()
    {
        $calendar_subject_daytime = [
            [
                "calendar_subject_day" => "2,3",
                "calendar_subject_time" => "123,456"
            ],
            [
                "calendar_subject_day" => "4,5",
                "calendar_subject_time" => "789,101112"
            ]
        ];
        $response = $this->json('POST', 'api/admin/calendar-subject/lich-mo-lop-hoc', [
            'calendar_id' => '',
            'subject_id' => '19',
            'calendar_subject_type' => '1',
            'calendar_subject_slot' => '100',
            'calendar_subject_lecturer' => '69',
            'calendar_subject_start' => Carbon::now('Asia/Ho_Chi_Minh'),
            'calendar_subject_end' => Carbon::tomorrow('Asia/Ho_Chi_Minh'),
            'calendar_subject_daytime' => $calendar_subject_daytime,
        ]);
        $check = $response->assertStatus(422);
    }

    /** @test */
    public function storeCalendarSubjectEmptyError()
    {
        $calendar_subject_daytime = [
            [
                "calendar_subject_day" => "2,3",
                "calendar_subject_time" => "123,456"
            ],
            [
                "calendar_subject_day" => "4,5",
                "calendar_subject_time" => "789,101112"
            ]
        ];
        $response = $this->json('POST', 'api/admin/calendar-subject/lich-mo-lop-hoc', [
            'calendar_id' => '29',
            'subject_id' => '',
            'calendar_subject_type' => '1',
            'calendar_subject_slot' => '100',
            'calendar_subject_lecturer' => '69',
            'calendar_subject_start' => Carbon::now('Asia/Ho_Chi_Minh'),
            'calendar_subject_end' => Carbon::tomorrow('Asia/Ho_Chi_Minh'),
            'calendar_subject_daytime' => $calendar_subject_daytime,
        ]);
        $check = $response->assertStatus(422);
    }

    /** @test */
    public function storeCalendarSubjectTypeEmptyError()
    {
        $calendar_subject_daytime = [
            [
                "calendar_subject_day" => "2,3",
                "calendar_subject_time" => "123,456"
            ],
            [
                "calendar_subject_day" => "4,5",
                "calendar_subject_time" => "789,101112"
            ]
        ];
        $response = $this->json('POST', 'api/admin/calendar-subject/lich-mo-lop-hoc', [
            'calendar_id' => '29',
            'subject_id' => '19',
            'calendar_subject_type' => '',
            'calendar_subject_slot' => '100',
            'calendar_subject_lecturer' => '69',
            'calendar_subject_start' => Carbon::now('Asia/Ho_Chi_Minh'),
            'calendar_subject_end' => Carbon::tomorrow('Asia/Ho_Chi_Minh'),
            'calendar_subject_daytime' => $calendar_subject_daytime,
        ]);
        $check = $response->assertStatus(422);
    }

    /** @test */
    public function storeCalendarSubjectSlotEmptyError()
    {
        $calendar_subject_daytime = [
            [
                "calendar_subject_day" => "2,3",
                "calendar_subject_time" => "123,456"
            ],
            [
                "calendar_subject_day" => "4,5",
                "calendar_subject_time" => "789,101112"
            ]
        ];
        $response = $this->json('POST', 'api/admin/calendar-subject/lich-mo-lop-hoc', [
            'calendar_id' => '29',
            'subject_id' => '19',
            'calendar_subject_type' => '1',
            'calendar_subject_slot' => '',
            'calendar_subject_lecturer' => '69',
            'calendar_subject_start' => Carbon::now('Asia/Ho_Chi_Minh'),
            'calendar_subject_end' => Carbon::tomorrow('Asia/Ho_Chi_Minh'),
            'calendar_subject_daytime' => $calendar_subject_daytime,
        ]);
        $check = $response->assertStatus(422);
    }

    /** @test */
    public function storeCalendarSubjectSlotMaxLengthError()
    {
        $calendar_subject_daytime = [
            [
                "calendar_subject_day" => "2,3",
                "calendar_subject_time" => "123,456"
            ],
            [
                "calendar_subject_day" => "4,5",
                "calendar_subject_time" => "789,101112"
            ]
        ];
        $response = $this->json('POST', 'api/admin/calendar-subject/lich-mo-lop-hoc', [
            'calendar_id' => '29',
            'subject_id' => '19',
            'calendar_subject_type' => '1',
            'calendar_subject_slot' => '100000000000000000000000000000000000000',
            'calendar_subject_lecturer' => '69',
            'calendar_subject_start' => Carbon::now('Asia/Ho_Chi_Minh'),
            'calendar_subject_end' => Carbon::tomorrow('Asia/Ho_Chi_Minh'),
            'calendar_subject_daytime' => $calendar_subject_daytime,
        ]);
        $check = $response->assertStatus(422);
    }

    /** @test */
    public function storeCalendarSubjectSlotGreater1Error()
    {
        $calendar_subject_daytime = [
            [
                "calendar_subject_day" => "2,3",
                "calendar_subject_time" => "123,456"
            ],
            [
                "calendar_subject_day" => "4,5",
                "calendar_subject_time" => "789,101112"
            ]
        ];
        $response = $this->json('POST', 'api/admin/calendar-subject/lich-mo-lop-hoc', [
            'calendar_id' => '29',
            'subject_id' => '19',
            'calendar_subject_type' => '1',
            'calendar_subject_slot' => '0',
            'calendar_subject_lecturer' => '69',
            'calendar_subject_start' => Carbon::now('Asia/Ho_Chi_Minh'),
            'calendar_subject_end' => Carbon::tomorrow('Asia/Ho_Chi_Minh'),
            'calendar_subject_daytime' => $calendar_subject_daytime,
        ]);
        $check = $response->assertStatus(422);
    }

    /** @test */
    public function storeCalendarSubjectStartEmptyError()
    {
        $calendar_subject_daytime = [
            [
                "calendar_subject_day" => "2,3",
                "calendar_subject_time" => "123,456"
            ],
            [
                "calendar_subject_day" => "4,5",
                "calendar_subject_time" => "789,101112"
            ]
        ];
        $response = $this->json('POST', 'api/admin/calendar-subject/lich-mo-lop-hoc', [
            'calendar_id' => '29',
            'subject_id' => '19',
            'calendar_subject_type' => '1',
            'calendar_subject_slot' => '100',
            'calendar_subject_lecturer' => '69',
            'calendar_subject_start' => '',
            'calendar_subject_end' => Carbon::tomorrow('Asia/Ho_Chi_Minh'),
            'calendar_subject_daytime' => $calendar_subject_daytime,
        ]);
        $check = $response->assertStatus(422);
    }

    /** @test */
    public function storeCalendarSubjectEndEmptyError()
    {
        $calendar_subject_daytime = [
            [
                "calendar_subject_day" => "2,3",
                "calendar_subject_time" => "123,456"
            ],
            [
                "calendar_subject_day" => "4,5",
                "calendar_subject_time" => "789,101112"
            ]
        ];
        $response = $this->json('POST', 'api/admin/calendar-subject/lich-mo-lop-hoc', [
            'calendar_id' => '29',
            'subject_id' => '19',
            'calendar_subject_type' => '1',
            'calendar_subject_slot' => '0',
            'calendar_subject_lecturer' => '69',
            'calendar_subject_start' => Carbon::now('Asia/Ho_Chi_Minh'),
            'calendar_subject_end' => '',
            'calendar_subject_daytime' => $calendar_subject_daytime,
        ]);
        $check = $response->assertStatus(422);
    }

    /** @test */
    public function storeCalendarSubjectDaytimeEmptyError()
    {
        $response = $this->json('POST', 'api/admin/calendar-subject/lich-mo-lop-hoc', [
            'calendar_id' => '29',
            'subject_id' => '19',
            'calendar_subject_type' => '1',
            'calendar_subject_slot' => '0',
            'calendar_subject_lecturer' => '69',
            'calendar_subject_start' => Carbon::now('Asia/Ho_Chi_Minh'),
            'calendar_subject_end' => Carbon::tomorrow('Asia/Ho_Chi_Minh'),
            'calendar_subject_daytime' => '',
        ]);
        $check = $response->assertStatus(422);
    }

    /** @test */
    public function storeCalendarSubjectLecturerEmptyError()
    {
        $calendar_subject_daytime = [
            [
                "calendar_subject_day" => "2,3",
                "calendar_subject_time" => "123,456"
            ],
            [
                "calendar_subject_day" => "4,5",
                "calendar_subject_time" => "789,101112"
            ]
        ];
        $response = $this->json('POST', 'api/admin/calendar-subject/lich-mo-lop-hoc', [
            'calendar_id' => '29',
            'subject_id' => '19',
            'calendar_subject_type' => '1',
            'calendar_subject_slot' => '100',
            'calendar_subject_lecturer' => '',
            'calendar_subject_start' => Carbon::now('Asia/Ho_Chi_Minh'),
            'calendar_subject_end' => Carbon::tomorrow('Asia/Ho_Chi_Minh'),
            'calendar_subject_daytime' => $calendar_subject_daytime,
        ]);
        $check = $response->assertStatus(422);
    }

    /** @test */
    public function updateCalendarSubjectSucess()
    {
        $calendar_subject_daytime = [
            [
                "calendar_subject_day" => "2,3",
                "calendar_subject_time" => "123,456"
            ]
        ];

        $this->json('POST', 'api/admin/calendar-subject/lich-mo-lop-hoc', [
            'calendar_id' => '29',
            'subject_id' => '19',
            'calendar_subject_type' => '1',
            'calendar_subject_slot' => '100',
            'calendar_subject_lecturer' => '69',
            'calendar_subject_start' => Carbon::now('Asia/Ho_Chi_Minh'),
            'calendar_subject_end' => Carbon::tomorrow('Asia/Ho_Chi_Minh'),
            'calendar_subject_daytime' => $calendar_subject_daytime,
        ]);

        $findToDel = CalendarSubject::orderBy('calendar_subject_id', 'DESC')->first();

        $response = $this->json('PUT', 'api/admin/calendar-subject/lich-mo-lop-hoc/' . $findToDel->calendar_subject_id, [
            'calendar_id' => '29',
            'subject_id' => '19',
            'calendar_subject_type' => '1',
            'calendar_subject_slot' => '100',
            'calendar_subject_lecturer' => '69',
            'calendar_subject_start' => Carbon::now('Asia/Ho_Chi_Minh'),
            'calendar_subject_end' => Carbon::tomorrow('Asia/Ho_Chi_Minh'),
            'calendar_subject_day' => '4,5',
            'calendar_subject_time' => '789,101112',
        ]);
        $check = $response->assertStatus(200);
        if ($check == true) {
            $findToDel->delete();
        }
    }

    /** @test */
    public function updateCalendarSubjectCalendarIdEmptyError()
    {
        $calendar_subject_daytime = [
            [
                "calendar_subject_day" => "2,3",
                "calendar_subject_time" => "123,456"
            ]
        ];

        $this->json('POST', 'api/admin/calendar-subject/lich-mo-lop-hoc', [
            'calendar_id' => '29',
            'subject_id' => '19',
            'calendar_subject_type' => '1',
            'calendar_subject_slot' => '100',
            'calendar_subject_lecturer' => '69',
            'calendar_subject_start' => Carbon::now('Asia/Ho_Chi_Minh'),
            'calendar_subject_end' => Carbon::tomorrow('Asia/Ho_Chi_Minh'),
            'calendar_subject_daytime' => $calendar_subject_daytime,
        ]);

        $findToDel = CalendarSubject::orderBy('calendar_subject_id', 'DESC')->first();

        $response = $this->json('PUT', 'api/admin/calendar-subject/lich-mo-lop-hoc/' . $findToDel->calendar_subject_id, [
            'calendar_id' => '',
            'subject_id' => '19',
            'calendar_subject_type' => '1',
            'calendar_subject_slot' => '100',
            'calendar_subject_lecturer' => '69',
            'calendar_subject_start' => Carbon::now('Asia/Ho_Chi_Minh'),
            'calendar_subject_end' => Carbon::tomorrow('Asia/Ho_Chi_Minh'),
            'calendar_subject_day' => '4,5',
            'calendar_subject_time' => '789,101112',
        ]);
        $check = $response->assertStatus(422);
        if ($check == true) {
            $findToDel->delete();
        }
    }

    /** @test */
    public function updateCalendarSubjectEmptyError()
    {
        $calendar_subject_daytime = [
            [
                "calendar_subject_day" => "2,3",
                "calendar_subject_time" => "123,456"
            ]
        ];

        $this->json('POST', 'api/admin/calendar-subject/lich-mo-lop-hoc', [
            'calendar_id' => '29',
            'subject_id' => '19',
            'calendar_subject_type' => '1',
            'calendar_subject_slot' => '100',
            'calendar_subject_lecturer' => '69',
            'calendar_subject_start' => Carbon::now('Asia/Ho_Chi_Minh'),
            'calendar_subject_end' => Carbon::tomorrow('Asia/Ho_Chi_Minh'),
            'calendar_subject_daytime' => $calendar_subject_daytime,
        ]);

        $findToDel = CalendarSubject::orderBy('calendar_subject_id', 'DESC')->first();

        $response = $this->json('PUT', 'api/admin/calendar-subject/lich-mo-lop-hoc/' . $findToDel->calendar_subject_id, [
            'calendar_id' => '29',
            'subject_id' => '',
            'calendar_subject_type' => '1',
            'calendar_subject_slot' => '100',
            'calendar_subject_lecturer' => '69',
            'calendar_subject_start' => Carbon::now('Asia/Ho_Chi_Minh'),
            'calendar_subject_end' => Carbon::tomorrow('Asia/Ho_Chi_Minh'),
            'calendar_subject_day' => '4,5',
            'calendar_subject_time' => '789,101112',
        ]);
        $check = $response->assertStatus(422);
        if ($check == true) {
            $findToDel->delete();
        }
    }

    /** @test */
    public function updateCalendarSubjectTypeEmptyError()
    {
        $calendar_subject_daytime = [
            [
                "calendar_subject_day" => "2,3",
                "calendar_subject_time" => "123,456"
            ]
        ];

        $this->json('POST', 'api/admin/calendar-subject/lich-mo-lop-hoc', [
            'calendar_id' => '29',
            'subject_id' => '19',
            'calendar_subject_type' => '1',
            'calendar_subject_slot' => '100',
            'calendar_subject_lecturer' => '69',
            'calendar_subject_start' => Carbon::now('Asia/Ho_Chi_Minh'),
            'calendar_subject_end' => Carbon::tomorrow('Asia/Ho_Chi_Minh'),
            'calendar_subject_daytime' => $calendar_subject_daytime,
        ]);

        $findToDel = CalendarSubject::orderBy('calendar_subject_id', 'DESC')->first();

        $response = $this->json('PUT', 'api/admin/calendar-subject/lich-mo-lop-hoc/' . $findToDel->calendar_subject_id, [
            'calendar_id' => '29',
            'subject_id' => '19',
            'calendar_subject_type' => '',
            'calendar_subject_slot' => '100',
            'calendar_subject_lecturer' => '69',
            'calendar_subject_start' => Carbon::now('Asia/Ho_Chi_Minh'),
            'calendar_subject_end' => Carbon::tomorrow('Asia/Ho_Chi_Minh'),
            'calendar_subject_day' => '4,5',
            'calendar_subject_time' => '789,101112',
        ]);
        $check = $response->assertStatus(422);
        if ($check == true) {
            $findToDel->delete();
        }
    }

    /** @test */
    public function updateCalendarSubjectSlotEmptyError()
    {
        $calendar_subject_daytime = [
            [
                "calendar_subject_day" => "2,3",
                "calendar_subject_time" => "123,456"
            ]
        ];

        $this->json('POST', 'api/admin/calendar-subject/lich-mo-lop-hoc', [
            'calendar_id' => '29',
            'subject_id' => '19',
            'calendar_subject_type' => '1',
            'calendar_subject_slot' => '100',
            'calendar_subject_lecturer' => '69',
            'calendar_subject_start' => Carbon::now('Asia/Ho_Chi_Minh'),
            'calendar_subject_end' => Carbon::tomorrow('Asia/Ho_Chi_Minh'),
            'calendar_subject_daytime' => $calendar_subject_daytime,
        ]);

        $findToDel = CalendarSubject::orderBy('calendar_subject_id', 'DESC')->first();

        $response = $this->json('PUT', 'api/admin/calendar-subject/lich-mo-lop-hoc/' . $findToDel->calendar_subject_id, [
            'calendar_id' => '29',
            'subject_id' => '19',
            'calendar_subject_type' => '1',
            'calendar_subject_slot' => '',
            'calendar_subject_lecturer' => '69',
            'calendar_subject_start' => Carbon::now('Asia/Ho_Chi_Minh'),
            'calendar_subject_end' => Carbon::tomorrow('Asia/Ho_Chi_Minh'),
            'calendar_subject_day' => '4,5',
            'calendar_subject_time' => '789,101112',
        ]);
        $check = $response->assertStatus(422);
        if ($check == true) {
            $findToDel->delete();
        }
    }

    /** @test */
    public function updateCalendarSubjectSlotMaxLengthError()
    {
        $calendar_subject_daytime = [
            [
                "calendar_subject_day" => "2,3",
                "calendar_subject_time" => "123,456"
            ]
        ];

        $this->json('POST', 'api/admin/calendar-subject/lich-mo-lop-hoc', [
            'calendar_id' => '29',
            'subject_id' => '19',
            'calendar_subject_type' => '1',
            'calendar_subject_slot' => '100',
            'calendar_subject_lecturer' => '69',
            'calendar_subject_start' => Carbon::now('Asia/Ho_Chi_Minh'),
            'calendar_subject_end' => Carbon::tomorrow('Asia/Ho_Chi_Minh'),
            'calendar_subject_daytime' => $calendar_subject_daytime,
        ]);

        $findToDel = CalendarSubject::orderBy('calendar_subject_id', 'DESC')->first();

        $response = $this->json('PUT', 'api/admin/calendar-subject/lich-mo-lop-hoc/' . $findToDel->calendar_subject_id, [
            'calendar_id' => '29',
            'subject_id' => '19',
            'calendar_subject_type' => '1',
            'calendar_subject_slot' => '100000000000000000000000000000000000000000',
            'calendar_subject_lecturer' => '69',
            'calendar_subject_start' => Carbon::now('Asia/Ho_Chi_Minh'),
            'calendar_subject_end' => Carbon::tomorrow('Asia/Ho_Chi_Minh'),
            'calendar_subject_day' => '4,5',
            'calendar_subject_time' => '789,101112',
        ]);
        $check = $response->assertStatus(422);
        if ($check == true) {
            $findToDel->delete();
        }
    }

    /** @test */
    public function updateCalendarSubjectSlotGreater1Error()
    {
        $calendar_subject_daytime = [
            [
                "calendar_subject_day" => "2,3",
                "calendar_subject_time" => "123,456"
            ]
        ];

        $this->json('POST', 'api/admin/calendar-subject/lich-mo-lop-hoc', [
            'calendar_id' => '29',
            'subject_id' => '19',
            'calendar_subject_type' => '1',
            'calendar_subject_slot' => '100',
            'calendar_subject_lecturer' => '69',
            'calendar_subject_start' => Carbon::now('Asia/Ho_Chi_Minh'),
            'calendar_subject_end' => Carbon::tomorrow('Asia/Ho_Chi_Minh'),
            'calendar_subject_daytime' => $calendar_subject_daytime,
        ]);

        $findToDel = CalendarSubject::orderBy('calendar_subject_id', 'DESC')->first();

        $response = $this->json('PUT', 'api/admin/calendar-subject/lich-mo-lop-hoc/' . $findToDel->calendar_subject_id, [
            'calendar_id' => '29',
            'subject_id' => '19',
            'calendar_subject_type' => '1',
            'calendar_subject_slot' => '0',
            'calendar_subject_lecturer' => '69',
            'calendar_subject_start' => Carbon::now('Asia/Ho_Chi_Minh'),
            'calendar_subject_end' => Carbon::tomorrow('Asia/Ho_Chi_Minh'),
            'calendar_subject_day' => '4,5',
            'calendar_subject_time' => '789,101112',
        ]);
        $check = $response->assertStatus(422);
        if ($check == true) {
            $findToDel->delete();
        }
    }

    /** @test */
    public function updateCalendarSubjectLecturerEmptyError()
    {
        $calendar_subject_daytime = [
            [
                "calendar_subject_day" => "2,3",
                "calendar_subject_time" => "123,456"
            ]
        ];

        $this->json('POST', 'api/admin/calendar-subject/lich-mo-lop-hoc', [
            'calendar_id' => '29',
            'subject_id' => '19',
            'calendar_subject_type' => '1',
            'calendar_subject_slot' => '100',
            'calendar_subject_lecturer' => '69',
            'calendar_subject_start' => Carbon::now('Asia/Ho_Chi_Minh'),
            'calendar_subject_end' => Carbon::tomorrow('Asia/Ho_Chi_Minh'),
            'calendar_subject_daytime' => $calendar_subject_daytime,
        ]);

        $findToDel = CalendarSubject::orderBy('calendar_subject_id', 'DESC')->first();

        $response = $this->json('PUT', 'api/admin/calendar-subject/lich-mo-lop-hoc/' . $findToDel->calendar_subject_id, [
            'calendar_id' => '29',
            'subject_id' => '19',
            'calendar_subject_type' => '1',
            'calendar_subject_slot' => '100',
            'calendar_subject_lecturer' => '',
            'calendar_subject_start' => Carbon::now('Asia/Ho_Chi_Minh'),
            'calendar_subject_end' => Carbon::tomorrow('Asia/Ho_Chi_Minh'),
            'calendar_subject_day' => '4,5',
            'calendar_subject_time' => '789,101112',
        ]);
        $check = $response->assertStatus(422);
        if ($check == true) {
            $findToDel->delete();
        }
    }

    /** @test */
    public function updateCalendarSubjectDayEmptyError()
    {
        $calendar_subject_daytime = [
            [
                "calendar_subject_day" => "2,3",
                "calendar_subject_time" => "123,456"
            ]
        ];

        $this->json('POST', 'api/admin/calendar-subject/lich-mo-lop-hoc', [
            'calendar_id' => '29',
            'subject_id' => '19',
            'calendar_subject_type' => '1',
            'calendar_subject_slot' => '100',
            'calendar_subject_lecturer' => '69',
            'calendar_subject_start' => Carbon::now('Asia/Ho_Chi_Minh'),
            'calendar_subject_end' => Carbon::tomorrow('Asia/Ho_Chi_Minh'),
            'calendar_subject_daytime' => $calendar_subject_daytime,
        ]);

        $findToDel = CalendarSubject::orderBy('calendar_subject_id', 'DESC')->first();

        $response = $this->json('PUT', 'api/admin/calendar-subject/lich-mo-lop-hoc/' . $findToDel->calendar_subject_id, [
            'calendar_id' => '29',
            'subject_id' => '19',
            'calendar_subject_type' => '1',
            'calendar_subject_slot' => '100',
            'calendar_subject_lecturer' => '69',
            'calendar_subject_start' => Carbon::now('Asia/Ho_Chi_Minh'),
            'calendar_subject_end' => Carbon::tomorrow('Asia/Ho_Chi_Minh'),
            'calendar_subject_day' => '',
            'calendar_subject_time' => '789,101112',
        ]);
        $check = $response->assertStatus(422);
        if ($check == true) {
            $findToDel->delete();
        }
    }

    /** @test */
    public function updateCalendarSubjectTimeEmptyError()
    {
        $calendar_subject_daytime = [
            [
                "calendar_subject_day" => "2,3",
                "calendar_subject_time" => "123,456"
            ]
        ];

        $this->json('POST', 'api/admin/calendar-subject/lich-mo-lop-hoc', [
            'calendar_id' => '29',
            'subject_id' => '19',
            'calendar_subject_type' => '1',
            'calendar_subject_slot' => '100',
            'calendar_subject_lecturer' => '69',
            'calendar_subject_start' => Carbon::now('Asia/Ho_Chi_Minh'),
            'calendar_subject_end' => Carbon::tomorrow('Asia/Ho_Chi_Minh'),
            'calendar_subject_daytime' => $calendar_subject_daytime,
        ]);

        $findToDel = CalendarSubject::orderBy('calendar_subject_id', 'DESC')->first();

        $response = $this->json('PUT', 'api/admin/calendar-subject/lich-mo-lop-hoc/' . $findToDel->calendar_subject_id, [
            'calendar_id' => '29',
            'subject_id' => '19',
            'calendar_subject_type' => '1',
            'calendar_subject_slot' => '100',
            'calendar_subject_lecturer' => '69',
            'calendar_subject_start' => Carbon::now('Asia/Ho_Chi_Minh'),
            'calendar_subject_end' => Carbon::tomorrow('Asia/Ho_Chi_Minh'),
            'calendar_subject_day' => '4,5',
            'calendar_subject_time' => '',
        ]);
        $check = $response->assertStatus(422);
        if ($check == true) {
            $findToDel->delete();
        }
    }

    /** @test */
    public function updateCalendarSubjectStartEmptyError()
    {
        $calendar_subject_daytime = [
            [
                "calendar_subject_day" => "2,3",
                "calendar_subject_time" => "123,456"
            ]
        ];

        $this->json('POST', 'api/admin/calendar-subject/lich-mo-lop-hoc', [
            'calendar_id' => '29',
            'subject_id' => '19',
            'calendar_subject_type' => '1',
            'calendar_subject_slot' => '100',
            'calendar_subject_lecturer' => '69',
            'calendar_subject_start' => Carbon::now('Asia/Ho_Chi_Minh'),
            'calendar_subject_end' => Carbon::tomorrow('Asia/Ho_Chi_Minh'),
            'calendar_subject_daytime' => $calendar_subject_daytime,
        ]);

        $findToDel = CalendarSubject::orderBy('calendar_subject_id', 'DESC')->first();

        $response = $this->json('PUT', 'api/admin/calendar-subject/lich-mo-lop-hoc/' . $findToDel->calendar_subject_id, [
            'calendar_id' => '29',
            'subject_id' => '19',
            'calendar_subject_type' => '1',
            'calendar_subject_slot' => '100',
            'calendar_subject_lecturer' => '69',
            'calendar_subject_start' => '',
            'calendar_subject_end' => Carbon::tomorrow('Asia/Ho_Chi_Minh'),
            'calendar_subject_day' => '4,5',
            'calendar_subject_time' => '789,101112',
        ]);
        $check = $response->assertStatus(422);
        if ($check == true) {
            $findToDel->delete();
        }
    }

    /** @test */
    public function updateCalendarSubjectEndEmptyError()
    {
        $calendar_subject_daytime = [
            [
                "calendar_subject_day" => "2,3",
                "calendar_subject_time" => "123,456"
            ]
        ];

        $this->json('POST', 'api/admin/calendar-subject/lich-mo-lop-hoc', [
            'calendar_id' => '29',
            'subject_id' => '19',
            'calendar_subject_type' => '1',
            'calendar_subject_slot' => '100',
            'calendar_subject_lecturer' => '69',
            'calendar_subject_start' => Carbon::now('Asia/Ho_Chi_Minh'),
            'calendar_subject_end' => Carbon::tomorrow('Asia/Ho_Chi_Minh'),
            'calendar_subject_daytime' => $calendar_subject_daytime,
        ]);

        $findToDel = CalendarSubject::orderBy('calendar_subject_id', 'DESC')->first();

        $response = $this->json('PUT', 'api/admin/calendar-subject/lich-mo-lop-hoc/' . $findToDel->calendar_subject_id, [
            'calendar_id' => '29',
            'subject_id' => '19',
            'calendar_subject_type' => '1',
            'calendar_subject_slot' => '100',
            'calendar_subject_lecturer' => '69',
            'calendar_subject_start' => Carbon::now('Asia/Ho_Chi_Minh'),
            'calendar_subject_end' => '',
            'calendar_subject_day' => '4,5',
            'calendar_subject_time' => '789,101112',
        ]);
        $check = $response->assertStatus(422);
        if ($check == true) {
            $findToDel->delete();
        }
    }

    /** @test */
    public function deleteCalendarSubjectSuccess()
    {
        $calendar_subject_daytime = [
            [
                "calendar_subject_day" => "2,3",
                "calendar_subject_time" => "123,456"
            ]
        ];

        $this->json('POST', 'api/admin/calendar-subject/lich-mo-lop-hoc', [
            'calendar_id' => '29',
            'subject_id' => '19',
            'calendar_subject_type' => '1',
            'calendar_subject_slot' => '100',
            'calendar_subject_lecturer' => '69',
            'calendar_subject_start' => Carbon::now('Asia/Ho_Chi_Minh'),
            'calendar_subject_end' => Carbon::tomorrow('Asia/Ho_Chi_Minh'),
            'calendar_subject_daytime' => $calendar_subject_daytime,
        ]);

        $findToDel = CalendarSubject::orderBy('calendar_subject_id', 'DESC')->first();
        $response = $this->json('DELETE', 'api/admin/calendar-subject/lich-mo-lop-hoc/' . $findToDel->calendar_subject_id);
        $response->assertStatus(200);
    }
}
