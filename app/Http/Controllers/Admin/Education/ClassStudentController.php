<?php

namespace App\Http\Controllers\Admin\Education;

use App\Http\Resources\ClassResource;
use App\Http\Controllers\Controller;
use App\Models\ClassStudent;
use App\Models\Lecturer;
use Illuminate\Http\Request;

class ClassStudentController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Class  $class
     * @return \Illuminate\Http\Response
     */
    public function show($currentEntries)
    {
        //
    }

    public function showdata($lecturer_id, $currentEntries)
    {
        $find = Lecturer::find($lecturer_id);
        $joins = ClassStudent::join('tbl_lecturer','tbl_lecturer.lecturer_faculty','=','tbl_class.class_faculty')
        ->join('tbl_course', 'tbl_course.course_id', '=', 'tbl_class.class_course')
        ->join('tbl_major', 'tbl_major.major_id', '=', 'tbl_class.class_major')
        ->join('tbl_faculty', 'tbl_faculty.faculty_id', '=', 'tbl_class.class_faculty')
        ->where('tbl_lecturer.lecturer_id',$lecturer_id)
        ->orderby('tbl_class.class_id','DESC')->paginate($currentEntries);
        return ClassResource::collection($joins);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Class  $class
     * @return \Illuminate\Http\Response
     */
    public function edit(ClassStudent $class)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Class  $class
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ClassStudent $class)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Class  $class
     * @return \Illuminate\Http\Response
     */
    public function destroy(ClassStudent $class)
    {
        //
    }

    public function classstudent($lecturer_id)
    {
        $find = Lecturer::find($lecturer_id);
        $joins = ClassStudent::join('tbl_faculty', 'tbl_faculty.faculty_id', '=', 'tbl_class.class_faculty')
        ->join('tbl_course', 'tbl_course.course_id', '=', 'tbl_class.class_course')
        ->join('tbl_major', 'tbl_major.major_id', '=', 'tbl_class.class_major')
        ->where('tbl_faculty.faculty_id', $find->lecturer_faculty)->orderBy('class_name', 'ASC')->get();
        return ClassResource::collection($joins);
    }

    public function allclass()
    {
        return ClassResource::collection(ClassStudent::orderby('class_id', 'DESC')->get());
    }
}
