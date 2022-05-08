<?php

namespace Tests\Unit\Controllers\Student\Registration;

use App\Models\TrainPoint;
use Tests\TestCase;

class TrainPointTest extends TestCase
{
    /** @test */
    public function storeTrainPointrSucess()
    {
        $response = $this->json('POST', 'api/student/train-point/danh-gia-diem-ren-luyen', [
            'student_id' => '11',
            'semester' => '1',
            'type' => '0',
            'sum_item' => '89',

            'itemOne_oneParent_inputOne' => '10',
            'itemOne_oneParent_inputTwo' => '0',
            'itemOne_oneParent_inputThree' => '0',
            'itemOne_oneParent_inputFour' => '0',
            'itemOne_oneParent_inputFive' => '0',
            'itemOne_twoParent_inputOne' => '3',
            'itemOne_twoParent_inputTwo' => '3',
            'itemOne_threeParent_inputOne' => '2',
            'itemOne_fourParent_inputOne' => '0',
            'itemOne_fiveParent_inputOne' => '3',
            'itemOne_sixParent_inputOne' => '0',

            'itemTwo_oneParent_inputOne' => '0',
            'itemTwo_twoParent_inputOne' => '8',
            'itemTwo_threeParent_inputOne' => '0',
            'itemTwo_fourParent_inputOne' => '0',
            'itemTwo_fiveParent_inputOne' => '0',
            'itemTwo_sixParent_inputOne' => '5',
            'itemTwo_sevenParent_inputOne' => '2',
            'itemTwo_eightParent_inputOne' => '4',

            'itemThree_oneParent_inputOne' => '0',
            'itemThree_oneParent_inputTwo' => '0',
            'itemThree_twoParent_inputOne' => '0',
            'itemThree_threeParent_inputOne' => '0',
            'itemThree_fourParent_inputOne' => '0',
            'itemThree_fourParent_inputTwo' => '0',
            'itemThree_fourParent_inputThree' => '0',
            'itemThree_fiveParent_inputOne' => '3',
            'itemThree_fiveParent_inputTwo' => '0',
            'itemThree_sixParent_inputOne' => '2',
            'itemThree_sevenParent_inputOne' => '0',
            'itemThree_eightParent_inputOne' => '10',
            'itemThree_eightParent_inputTwo' => '0',

            'itemFour_oneParent_inputOne' => '6',
            'itemFour_twoParent_inputOne' => '5',
            'itemFour_threeParent_inputOne' => '7',
            'itemFour_fourParent_inputOne' => '0',
            'itemFour_fiveParent_inputOne' => '5',
            'itemFour_sixParent_inputOne' => '5',
            'itemFour_sevenParent_inputOne' => '0',
            'itemFour_eightParent_inputOne' => '3',
            'itemFour_nineParent_inputOne' => '0',

            'itemFive_oneParent_inputOne' => '0',
            'itemFive_twoParent_inputOne' => '5',
            'itemFive_threeParent_inputOne' => '0',
            'itemFive_threeParent_inputTwo' => '0',
            'itemFive_fourParent_inputOne' => '2',
            'itemFive_fourParent_inputTwo' => '0',
            'itemFive_fiveParent_inputOne' => '5',
            'itemFive_fiveParent_inputTwo' => '0',
            'itemSix_sixParent_inputOne' => '0',
            'itemSix_sixParent_inputTwo' => '0',
            'itemSix_sixParent_inputThree' => '0',
        ]);
        $check = $response->assertStatus(200);
        if ($check == true) {
            $findToDel = TrainPoint::orderBy('train_point_id', 'DESC')->first();
            $findToDel->delete();
        }
    }
}
