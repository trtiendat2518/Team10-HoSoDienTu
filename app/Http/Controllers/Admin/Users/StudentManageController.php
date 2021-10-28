<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Http\Resources\StudentResource;
use App\Http\Resources\StudentInfoResource;
use App\Models\Student;
use App\Models\StudentInfo;
use Illuminate\Http\Request;
use Session;

class StudentManageController extends Controller
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
     * Search the resource in the list.
     *
     * @return \Illuminate\Http\Response
     */
    public function search($query, $currentEntries)
    {
        return StudentResource::collection(Student::where('student_fullname','LIKE','%'.$query.'%')->orwhere('student_email','LIKE','%'.$query.'%')->orderby('student_id','DESC')->paginate($currentEntries));
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
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show($currentEntries)
    {
        return StudentResource::collection(Student::orderby('student_id','DESC')->paginate($currentEntries));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $student)
    {
        $stu = Student::find($student);
        $stu->student_role = $request->student_role;
        $stu->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy($student)
    {
        $stu = Student::find($student);
        $stu->delete();
    }

    /**
     * Remove all the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyall(Request $request, $student = null)
    {
        if ($request->student) {
            foreach ($request->student as $id) {
                Student::where('student_id', $id)->delete();
            }
        }
    }

    /**
     * Change status of resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function change(Request $request, $student)
    {
        $stu = Student::find($student);
        if($stu->student_status==0){
            $stu->student_status=1;
            $stu->save();
        }else{
            $stu->student_status=0;
            $stu->save();
        }
    }

    public function detail($student)
    {
        return StudentInfoResource::collection(StudentInfo::where('student_code',$student)->paginate(1));
    }
}
