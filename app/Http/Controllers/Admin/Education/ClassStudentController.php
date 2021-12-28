<?php

namespace App\Http\Controllers\Admin\Education;

use App\Http\Resources\ClassResource;
use App\Http\Controllers\Controller;
use App\Models\ClassStudent;
use App\Models\Lecturer;
use Illuminate\Http\Request;
use Validator;

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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'class_name' => ['required', 'max:50', 'unique:tbl_class', 'notspecial_spaces'],
            'class_course' => ['required'],
            'class_major' => ['required'],
        ], [
            'class_name.required' => 'Tên lớp học không được để trống!',
            'class_name.max' => 'Tên lớp học không nhập quá 50 ký tự chữ!',
            'class_name.unique' => 'Tên lớp học đã tồn tại!',
            'class_name.notspecial_spaces' => 'Tên lớp học không được chứa ký tự đặc biệt!',

            'class_course.required' => 'Khóa học không được để trống!',
            'class_major.required' => 'Chuyên ngành không được để trống!'
        ]);

        $cls = new ClassStudent();
        $cls->class_name = $data['class_name'];
        $cls->class_course = $data['class_course'];
        $cls->class_faculty = $request->class_faculty;
        $cls->class_major = $data['class_major'];
        $cls->save();
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Class $class
     * @return \Illuminate\Http\Response
     */
    public function show($currentEntries)
    {
        //
    }

    public function showdata($lecturer_id, $currentEntries)
    {
        $find = Lecturer::find($lecturer_id);
        $joins = ClassStudent::join('tbl_lecturer', 'tbl_lecturer.lecturer_faculty', '=', 'tbl_class.class_faculty')
            ->join('tbl_course', 'tbl_course.course_id', '=', 'tbl_class.class_course')
            ->join('tbl_major', 'tbl_major.major_id', '=', 'tbl_class.class_major')
            ->join('tbl_faculty', 'tbl_faculty.faculty_id', '=', 'tbl_class.class_faculty')
            ->where('tbl_lecturer.lecturer_id', $lecturer_id)
            ->orderby('tbl_class.class_id', 'DESC')->paginate($currentEntries);
        return ClassResource::collection($joins);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Class $class
     * @return \Illuminate\Http\Response
     */
    public function edit(ClassStudent $class)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Class $class
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $class)
    {
        $data = $request->validate([
            'class_name' => ['required', 'max:50', 'notspecial_spaces'],
            'class_course' => ['required'],
            'class_major' => ['required'],
        ], [
            'class_name.required' => 'Tên lớp học không được để trống!',
            'class_name.max' => 'Tên lớp học không nhập quá 50 ký tự chữ!',
            'class_name.notspecial_spaces' => 'Tên lớp học không được chứa ký tự đặc biệt!',

            'class_course.required' => 'Khóa học không được để trống!',
            'class_major.required' => 'Chuyên ngành không được để trống!'
        ]);

        $cls = ClassStudent::find($class);
        $cls->class_name = $data['class_name'];
        $cls->class_course = $data['class_course'];
        $cls->class_major = $data['class_major'];
        $cls->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Class $class
     * @return \Illuminate\Http\Response
     */
    public function destroy($class)
    {
        $del = ClassStudent::find($class);
        $del->delete();
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

    public function search($faculty, $query, $currentEntries)
    {
        $joins = ClassStudent::join('tbl_faculty', 'tbl_faculty.faculty_id', '=', 'tbl_class.class_faculty')
            ->join('tbl_course', 'tbl_course.course_id', '=', 'tbl_class.class_course')
            ->join('tbl_major', 'tbl_major.major_id', '=', 'tbl_class.class_major')
            ->where('tbl_class.class_name', 'LIKE', '%' . $query . '%')->where('tbl_class.class_faculty', $faculty)
            ->orderby('tbl_faculty.faculty_id', 'DESC')->paginate($currentEntries);
        return ClassResource::collection($joins);
    }

    public function filter($faculty, $value, $currentEntries)
    {
        $joins = ClassStudent::join('tbl_faculty', 'tbl_faculty.faculty_id', '=', 'tbl_class.class_faculty')
            ->join('tbl_course', 'tbl_course.course_id', '=', 'tbl_class.class_course')
            ->join('tbl_major', 'tbl_major.major_id', '=', 'tbl_class.class_major')
            ->where('tbl_class.class_state', $value)->where('tbl_class.class_faculty', $faculty)
            ->orderby('tbl_faculty.faculty_id', 'DESC')->paginate($currentEntries);
        return ClassResource::collection($joins);
    }

    public function change(Request $request, $class)
    {
        $cls = ClassStudent::find($class);
        if ($cls->class_status == 0) {
            $cls->class_status = 1;
            $cls->save();
        } else {
            $cls->class_status = 0;
            $cls->save();
        }
    }

    public function destroyall(Request $request, $class = null)
    {
        if ($request->class) {
            foreach ($request->class as $id) {
                ClassStudent::where('class_id', $id)->delete();
            }
        }
    }

    public function allclass()
    {
        return ClassResource::collection(ClassStudent::orderby('class_id', 'DESC')->get());
    }

    public function student_class($class)
    {
        $joins = ClassStudent::join('tbl_student', 'tbl_student.student_class', '=', 'tbl_class.class_id')
        ->join('tbl_course', 'tbl_course.course_id', '=', 'tbl_class.class_course')
        ->where('tbl_class.class_id', $class)
        ->orderby('tbl_student.student_fullname', 'ASC')->get();
        return ClassResource::collection($joins);
    }

    public function search_student_class($class, $query)
    {
        $joins = ClassStudent::join('tbl_student', 'tbl_student.student_class', '=', 'tbl_class.class_id')
        ->join('tbl_course', 'tbl_course.course_id', '=', 'tbl_class.class_course')
        ->where('tbl_student.student_fullname', 'LIKE', '%' . $query . '%')
        ->where('tbl_class.class_id', $class)
        ->orwhere('tbl_student.student_code', 'LIKE', '%' . $query . '%')
        ->where('tbl_class.class_id', $class)
        ->orderby('tbl_student.student_fullname', 'ASC')->get();
        return ClassResource::collection($joins);
    }

    public function teacher_student_class($class)
    {
        $joins = ClassStudent::join('tbl_form_teacher', 'tbl_form_teacher.form_teacher_class', '=', 'tbl_class.class_id')
        ->join('tbl_lecturer', 'tbl_lecturer.lecturer_id', '=', 'tbl_form_teacher.form_teacher_lecturer')
        ->where('tbl_class.class_id', $class)->get();
        return ClassResource::collection($joins);
    }
}
