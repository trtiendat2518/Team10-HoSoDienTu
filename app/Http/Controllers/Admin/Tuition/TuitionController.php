<?php

namespace App\Http\Controllers\Admin\Tuition;

use App\Http\Controllers\Controller;
use App\Models\Tuition;
use App\Http\Resources\TuitionResource;
use Illuminate\Http\Request;

class TuitionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            'tuition_course' => ['required'],
            'tuition_faculty' => ['required'],
            'tuition_major' => ['required'],
            'tuition_fee' => ['required', 'max: 11'],
            'tuition_discount' => ['required', 'integer', 'between:0,100'],
        ], [
            'tuition_course.required' => 'Vui lòng chọn khoá học!',
            'tuition_faculty.required' => 'Vui lòng chọn khoa!',
            'tuition_major.required' => 'Vui lòng chọn chuyên ngành!',

            'tuition_fee.required' => 'Vui lòng nhập học phí!',
            'tuition_fee.max' => 'Học phí không nhập quá 11 số!',

            'tuition_discount.required' => 'Giảm học phí không được để trống. Nếu không giảm vui lòng nhập số 0!',
            'tuition_discount.integer' => 'Giảm học phí phải là số nguyên!',
            'tuition_discount.between' => 'Giảm học phí chỉ nhập từ 0 dến 100!',
        ]);

        $tuition = new Tuition();
        $tuition->tuition_course = $data['tuition_course'];
        $tuition->tuition_faculty = $data['tuition_faculty'];
        $tuition->tuition_major = $data['tuition_major'];
        $tuition->tuition_fee = $data['tuition_fee'];
        $tuition->tuition_discount = $data['tuition_discount'];
        $tuition->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tuition  $tuition
     * @return \Illuminate\Http\Response
     */
    public function show($currentEntries)
    {
        $joins = Tuition::join('tbl_course', 'tbl_course.course_id', '=', 'tbl_tuition.tuition_course')
            ->join('tbl_faculty', 'tbl_faculty.faculty_id', '=', 'tbl_tuition.tuition_faculty')
            ->join('tbl_major', 'tbl_major.major_id', '=', 'tbl_tuition.tuition_major')
            ->orderby('tbl_tuition.tuition_id', 'DESC')
            ->paginate($currentEntries);
        return TuitionResource::collection($joins);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tuition  $tuition
     * @return \Illuminate\Http\Response
     */
    public function edit(Tuition $tuition)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tuition  $tuition
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $tuition)
    {
        $data = $request->validate([
            'tuition_course' => ['required'],
            'tuition_faculty' => ['required'],
            'tuition_major' => ['required'],
            'tuition_fee' => ['required', 'max: 11'],
            'tuition_discount' => ['required', 'integer', 'between:0,100'],
        ], [
            'tuition_course.required' => 'Vui lòng chọn khoá học!',
            'tuition_faculty.required' => 'Vui lòng chọn khoa!',
            'tuition_major.required' => 'Vui lòng chọn chuyên ngành!',

            'tuition_fee.required' => 'Vui lòng nhập học phí!',
            'tuition_fee.max' => 'Học phí không nhập quá 11 số!',

            'tuition_discount.required' => 'Giảm học phí không được để trống. Nếu không giảm vui lòng nhập số 0!',
            'tuition_discount.integer' => 'Giảm học phí phải là số nguyên!',
            'tuition_discount.between' => 'Giảm học phí chỉ nhập từ 0 dến 100!',
        ]);

        $tuition = Tuition::find($tuition);
        $tuition->tuition_course = $data['tuition_course'];
        $tuition->tuition_faculty = $data['tuition_faculty'];
        $tuition->tuition_major = $data['tuition_major'];
        $tuition->tuition_fee = $data['tuition_fee'];
        $tuition->tuition_discount = $data['tuition_discount'];
        $tuition->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tuition  $tuition
     * @return \Illuminate\Http\Response
     */
    public function destroy($tuition)
    {
        $tuition = Tuition::find($tuition);
        $tuition->delete();
    }

    public function not_in($tuition_id)
    {
        $joins = Tuition::whereNotIn('tuition_id', [$tuition_id])->get();
        return TuitionResource::collection($joins);
    }

    public function destroyall(Request $request, $tuition = null)
    {
        if ($request->tuition) {
            foreach ($request->tuition as $id) {
                Tuition::where('tuition_id', $id)->delete();
            }
        }
    }

    public function filter_course($course_id, $currentEntries)
    {
        $joins = Tuition::join('tbl_course', 'tbl_course.course_id', '=', 'tbl_tuition.tuition_course')
            ->join('tbl_faculty', 'tbl_faculty.faculty_id', '=', 'tbl_tuition.tuition_faculty')
            ->join('tbl_major', 'tbl_major.major_id', '=', 'tbl_tuition.tuition_major')
            ->where('tbl_tuition.tuition_course', $course_id)
            ->orderby('tbl_tuition.tuition_id', 'DESC')
            ->paginate($currentEntries);
        return TuitionResource::collection($joins);
    }

    public function filter_course_faculty($course_id, $faculty_id, $currentEntries)
    {
        $joins = Tuition::join('tbl_course', 'tbl_course.course_id', '=', 'tbl_tuition.tuition_course')
            ->join('tbl_faculty', 'tbl_faculty.faculty_id', '=', 'tbl_tuition.tuition_faculty')
            ->join('tbl_major', 'tbl_major.major_id', '=', 'tbl_tuition.tuition_major')
            ->where('tbl_tuition.tuition_course', $course_id)
            ->where('tbl_tuition.tuition_faculty', $faculty_id)
            ->orderby('tbl_tuition.tuition_id', 'DESC')
            ->paginate($currentEntries);
        return TuitionResource::collection($joins);
    }

    public function filter_course_faculty_major($course_id, $faculty_id, $major_id, $currentEntries)
    {
        $joins = Tuition::join('tbl_course', 'tbl_course.course_id', '=', 'tbl_tuition.tuition_course')
            ->join('tbl_faculty', 'tbl_faculty.faculty_id', '=', 'tbl_tuition.tuition_faculty')
            ->join('tbl_major', 'tbl_major.major_id', '=', 'tbl_tuition.tuition_major')
            ->where('tbl_tuition.tuition_course', $course_id)
            ->where('tbl_tuition.tuition_faculty', $faculty_id)
            ->where('tbl_tuition.tuition_major', $major_id)
            ->orderby('tbl_tuition.tuition_id', 'DESC')
            ->paginate($currentEntries);
        return TuitionResource::collection($joins);
    }
}
