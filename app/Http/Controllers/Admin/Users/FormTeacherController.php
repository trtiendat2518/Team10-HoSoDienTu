<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Models\FormTeacher;
use App\Models\Lecturer;
use Illuminate\Http\Request;
use App\Http\Resources\FormTeacherResource;

class FormTeacherController extends Controller
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
     * @param  \App\Models\FormTeacher  $formTeacher
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FormTeacher  $formTeacher
     * @return \Illuminate\Http\Response
     */
    public function edit(FormTeacher $formTeacher)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FormTeacher  $formTeacher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FormTeacher $formTeacher)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FormTeacher  $formTeacher
     * @return \Illuminate\Http\Response
     */
    public function destroy(FormTeacher $formTeacher)
    {
        //
    }

    public function showdata($lecturer_id, $currentEntries)
    {
        $find = Lecturer::find($lecturer_id);
        $joins = FormTeacher::join('tbl_lecturer', 'tbl_lecturer.lecturer_id', '=', 'tbl_form_teacher.form_teacher_lecturer')
        ->join('tbl_faculty', '.faculty_id', '=', 'tbl_lecturer.lecturer_faculty')
        ->where('tbl_faculty.faculty_id', $find->lecturer_faculty)->paginate($currentEntries);
        return FormTeacherResource::collection($joins);
    }
}
