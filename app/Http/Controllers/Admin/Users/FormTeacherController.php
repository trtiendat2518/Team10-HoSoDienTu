<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Models\FormTeacher;
use App\Models\ClassStudent;
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
    public function update(Request $request, $formTeacher)
    {
        $frt = FormTeacher::find($formTeacher);
        if ($frt->form_teacher_class==null) {
            $frt->form_teacher_class = $request->form_teacher_class;
            $done = $frt->save();
            if ($done) {
                $cls = ClassStudent::where('class_id', $request->form_teacher_class)->get();
                foreach ($cls as $key => $value) {
                    $value->class_state = 1;
                    $value->save();
                }
            }
        }else {
            $check = ClassStudent::where('class_id', $frt->form_teacher_class)->get();
            foreach ($check as $key => $value) {
                $value->class_state = 0;
                $value->save();
            }
            $frt->form_teacher_class = $request->form_teacher_class;
            $done = $frt->save();
            if ($done) {
                $cls = ClassStudent::where('class_id', $request->form_teacher_class)->get();
                foreach ($cls as $key => $value) {
                    $value->class_state = 1;
                    $value->save();
                }
            }
        }

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
        ->join('tbl_faculty', 'tbl_faculty.faculty_id', '=', 'tbl_lecturer.lecturer_faculty')
        ->where('tbl_faculty.faculty_id', $find->lecturer_faculty)->paginate($currentEntries);
        return FormTeacherResource::collection($joins);
    }

    public function search($lecturer_id, $query, $currentEntries)
    {
        $find = Lecturer::find($lecturer_id);
        $joins = FormTeacher::join('tbl_lecturer', 'tbl_lecturer.lecturer_id', '=', 'tbl_form_teacher.form_teacher_lecturer')
        ->join('tbl_faculty', 'tbl_faculty.faculty_id', '=', 'tbl_lecturer.lecturer_faculty')
        ->where('tbl_lecturer.lecturer_fullname', 'LIKE','%'.$query.'%')
        ->where('tbl_faculty.faculty_id', $find->lecturer_faculty)
        ->orwhere('tbl_lecturer.lecturer_email', 'LIKE','%'.$query.'%')
        ->where('tbl_faculty.faculty_id', $find->lecturer_faculty)->paginate($currentEntries);
        return FormTeacherResource::collection($joins);
    }

    public function detail($form_teacher_id)
    {
        $joins = FormTeacher::join('tbl_lecturer', 'tbl_lecturer.lecturer_id', '=', 'tbl_form_teacher.form_teacher_lecturer')
        ->join('tbl_lecturer_info', 'tbl_lecturer_info.lecturer_id_ref', '=', 'tbl_form_teacher.form_teacher_lecturer')
        ->join('tbl_faculty', 'tbl_faculty.faculty_id', '=', 'tbl_lecturer.lecturer_faculty')
        ->where('tbl_form_teacher.form_teacher_id', $form_teacher_id)->get();
        return FormTeacherResource::collection($joins);
    }
}
