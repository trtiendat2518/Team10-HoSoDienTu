<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Http\Resources\StudentResource;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Imports\StudentImport;
use Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;

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
        return StudentResource::collection(Student::where('student_fullname', 'LIKE', '%' . $query . '%')->orwhere('student_email', 'LIKE', '%' . $query . '%')->orderby('student_id', 'DESC')->paginate($currentEntries));
    }

    public function filter($value, $currentEntries)
    {
        return StudentResource::collection(Student::where('student_role', 'LIKE', '%' . $value . '%')->paginate($currentEntries));
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
        return StudentResource::collection(Student::orderby('student_id', 'DESC')->paginate($currentEntries));
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

        $data = $request->validate([
            'student_course' => ['required'],
            'student_faculty' => ['required'],
            'student_major' => ['required'],
            'student_class' => ['required'],
            'student_birthday' => ['required'],
            'student_gender' => ['required'],
            'student_ethnic' => ['max:50'],
            'student_religion' => ['max:50'],
            'student_phone' => ['required', 'max:11', 'min:10', 'notspecial_spaces'],
            'student_address' => ['required', 'max:200', 'min:10'],
            'student_country' => ['required', 'max:100', 'notspecial_spaces'],
            'student_identify_card' => ['required', 'max:12', 'min:9', 'notspecial_spaces'],
            'student_birth_place' => ['required', 'max:100', 'notspecial_spaces'],
            'student_other_email' => ['max:250', 'email'],

        ], [
            'student_course.required' => 'Kh??a h???c kh??ng ???????c ????? tr???ng!',
            'student_faculty.required' => 'Khoa kh??ng ???????c ????? tr???ng!',
            'student_major.required' => 'Chuy??n ng??nh kh??ng ???????c ????? tr???ng!',
            'student_class.required' => 'L???p h???c kh??ng ???????c ????? tr???ng!',

            'student_birthday.required' => 'Ng??y sinh kh??ng ???????c ????? tr???ng!',
            'student_gender.required' => 'Gi???i t??nh kh??ng ???????c ????? tr???ng!',

            'student_ethnic.max' => 'D??n t???c kh??ng nh???p qu?? 50 k?? t???!',
            'student_religion.max' => 'T??n gi??o kh??ng nh???p qu?? 50 k?? t???!',

            'student_phone.required' => 'S??? ??i???n tho???i kh??ng ???????c ????? tr???ng!',
            'student_phone.max' => 'S??? ??i???n tho???i kh??ng nh???p qu?? 11 k?? t??? s???!',
            'student_phone.min' => 'S??? ??i???n tho???i c???n nh???p 10 ho???c 11 s???!',
            'student_phone.notspecial_spaces' => 'S??? ??i???n tho???i kh??ng ch???a k?? t??? ?????c bi???t!',

            'student_address.required' => '?????a ch??? kh??ng ???????c ????? tr???ng!',
            'student_address.max' => '?????a ch??? kh??ng nh???p qu?? 200 k?? t??? ch???!',
            'student_address.min' => '?????a ch??? ph???i c?? 10 k?? t??? tr??? l??n!',

            'student_country.required' => 'Qu???c gia kh??ng ???????c ????? tr???ng!',
            'student_country.max' => 'Qu???c gia kh??ng nh???p qu?? 100 k?? t??? ch???!',
            'student_country.notspecial_spaces' => 'Qu???c gia kh??ng ch???a k?? t??? ?????c bi???t!',

            'student_identify_card.required' => 'CMND/CCCD kh??ng ???????c ????? tr???ng!',
            'student_identify_card.max' => 'CMND/CCCD kh??ng nh???p qu?? 12 k?? t???!',
            'student_identify_card.min' => 'CMND/CCCD ph???i c?? 10 k?? t??? tr??? l??n!',
            'student_identify_card.notspecial_spaces' => 'CMND/CCCD kh??ng ch???a k?? t??? ?????c bi???t!',

            'student_birth_place.required' => 'N??i sinh kh??ng ???????c ????? tr???ng!',
            'student_birth_place.max' => 'N??i sinh kh??ng nh???p qu?? 100 k?? t??? ch???!',
            'student_birth_place.notspecial_spaces' => 'N??i sinh kh??ng ch???a k?? t??? ?????c bi???t!',

            'student_other_email.max' => 'Email kh??ng nh???p qu?? 250 k?? t???!',
            'student_other_email.email' => 'Thi???u @ cho Email!',
        ]);

        $stu->student_course = $request->student_course;
        $stu->student_faculty = $request->student_faculty;
        $stu->student_major = $request->student_major;
        $stu->student_birthday = $request->student_birthday;
        $stu->student_gender = $request->student_gender;
        $stu->student_ethnic = $request->student_ethnic;
        $stu->student_religion = $request->student_religion;
        $stu->student_phone = $request->student_phone;
        $stu->student_address = $request->student_address;
        $stu->student_country = $request->student_country;
        $stu->student_identify_card = $request->student_identify_card;
        $stu->student_birth_place = $request->student_birth_place;
        $stu->student_other_email = $request->student_other_email;
        $stu->student_class = $request->student_class;

        $stu->save();
    }

    public function upgrade(Request $request, $student)
    {
        $stu = Student::find($student);

        $data = $request->validate([
            'student_course' => ['required'],
            'student_faculty' => ['required'],
            'student_major' => ['required'],
            'student_class' => ['required'],
            'student_avatar' => ['required', 'mimes:jpeg,jpg,png,gif'],
            'student_birthday' => ['required'],
            'student_gender' => ['required'],
            'student_ethnic' => ['max:50'],
            'student_religion' => ['max:50'],
            'student_phone' => ['required', 'max:11', 'min:10', 'notspecial_spaces'],
            'student_address' => ['required', 'max:200', 'min:10'],
            'student_country' => ['required', 'max:100', 'notspecial_spaces'],
            'student_identify_card' => ['required', 'max:12', 'min:9', 'notspecial_spaces'],
            'student_birth_place' => ['required', 'max:100', 'notspecial_spaces'],
            'student_other_email' => ['max:250', 'email'],

        ], [
            'student_course.required' => 'Kh??a h???c kh??ng ???????c ????? tr???ng!',
            'student_faculty.required' => 'Khoa kh??ng ???????c ????? tr???ng!',
            'student_major.required' => 'Chuy??n ng??nh kh??ng ???????c ????? tr???ng!',
            'student_class.required' => 'L???p h???c kh??ng ???????c ????? tr???ng!',

            'student_avatar.required' => '???nh ?????i di???n kh??ng ???????c ????? tr???ng!',
            'student_avatar.mimes' => 'T???p nh???p v??o ph???i c?? ??u??i jpeg,jpg,png,gif!',
            'student_birthday.required' => 'Ng??y sinh kh??ng ???????c ????? tr???ng!',
            'student_gender.required' => 'Gi???i t??nh kh??ng ???????c ????? tr???ng!',

            'student_ethnic.max' => 'D??n t???c kh??ng nh???p qu?? 50 k?? t???!',
            'student_religion.max' => 'T??n gi??o kh??ng nh???p qu?? 50 k?? t???!',

            'student_phone.required' => 'S??? ??i???n tho???i kh??ng ???????c ????? tr???ng!',
            'student_phone.max' => 'S??? ??i???n tho???i kh??ng nh???p qu?? 11 k?? t??? s???!',
            'student_phone.min' => 'S??? ??i???n tho???i c???n nh???p 10 ho???c 11 s???!',
            'student_phone.notspecial_spaces' => 'S??? ??i???n tho???i kh??ng ch???a k?? t??? ?????c bi???t!',

            'student_address.required' => '?????a ch??? kh??ng ???????c ????? tr???ng!',
            'student_address.max' => '?????a ch??? kh??ng nh???p qu?? 200 k?? t??? ch???!',
            'student_address.min' => '?????a ch??? ph???i c?? 10 k?? t??? tr??? l??n!',

            'student_country.required' => 'Qu???c gia kh??ng ???????c ????? tr???ng!',
            'student_country.max' => 'Qu???c gia kh??ng nh???p qu?? 100 k?? t??? ch???!',
            'student_country.notspecial_spaces' => 'Qu???c gia kh??ng ch???a k?? t??? ?????c bi???t!',

            'student_identify_card.required' => 'CMND/CCCD kh??ng ???????c ????? tr???ng!',
            'student_identify_card.max' => 'CMND/CCCD kh??ng nh???p qu?? 12 k?? t???!',
            'student_identify_card.min' => 'CMND/CCCD ph???i c?? 10 k?? t??? tr??? l??n!',
            'student_identify_card.notspecial_spaces' => 'CMND/CCCD kh??ng ch???a k?? t??? ?????c bi???t!',

            'student_birth_place.required' => 'N??i sinh kh??ng ???????c ????? tr???ng!',
            'student_birth_place.max' => 'N??i sinh kh??ng nh???p qu?? 100 k?? t??? ch???!',
            'student_birth_place.notspecial_spaces' => 'N??i sinh kh??ng ch???a k?? t??? ?????c bi???t!',

            'student_other_email.max' => 'Email kh??ng nh???p qu?? 250 k?? t???!',
            'student_other_email.email' => 'Thi???u @ cho Email!',
        ]);

        $stu->student_course = $request->student_course;
        $stu->student_faculty = $request->student_faculty;
        $stu->student_major = $request->student_major;
        $stu->student_birthday = $request->student_birthday;
        $stu->student_gender = $request->student_gender;
        $stu->student_ethnic = $request->student_ethnic;
        $stu->student_religion = $request->student_religion;
        $stu->student_phone = $request->student_phone;
        $stu->student_address = $request->student_address;
        $stu->student_country = $request->student_country;
        $stu->student_identify_card = $request->student_identify_card;
        $stu->student_birth_place = $request->student_birth_place;
        $stu->student_other_email = $request->student_other_email;
        $stu->student_class = $request->student_class;

        $image = $request->student_avatar;
        $name = $stu->student_code . '_avatar_' . time() . '.png';
        Storage::disk('publicstudent')->delete($stu->student_avatar);
        Storage::disk('publicstudent')->put($name, File::get($image));
        $stu->student_avatar = $name;

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
        if ($stu->student_status == 0) {
            $stu->student_status = 1;
            $stu->save();
        } else {
            $stu->student_status = 0;
            $stu->save();
        }
    }

    public function patch(Request $request, $student)
    {
        $stu = Student::find($student);
        $stu->student_role = $request->student_role;
        $stu->save();
    }

    public function detail($student)
    {
        $joins = Student::join('tbl_course', 'tbl_course.course_id', '=', 'tbl_student.student_course')
            ->join('tbl_faculty', 'tbl_faculty.faculty_id', '=', 'tbl_student.student_faculty')
            ->join('tbl_major', 'tbl_major.major_id', '=', 'tbl_student.student_major')
            ->join('tbl_class', 'tbl_class.class_id', '=', 'tbl_student.student_class')
            ->where('tbl_student.student_id', $student)->get();
        return StudentResource::collection($joins);
    }

    public function nonedetail($student)
    {
        $joins = Student::where('tbl_student.student_id', $student)->get();
        return StudentResource::collection($joins);
    }

    public function import(Request $request)
    {
        $request->validate([
            'fileImport' => 'required|file|mimes:xls,xlsx'
        ], [
            'fileImport.required' => 'Vui l??ng kh??ng ????? tr???ng!',
            'fileImport.file' => 'Vui l??ng nh???p t???p Excel ????? import!',
            'fileImport.mimes' => 'Vui l??ng nh???p t???p Excel ????? import!',
        ]);
        // $path = $request->file('fileImport')->getRealPath();
        // $data = Excel::import(new StudentImport, $path);

        $path1 = $request->file('fileImport')->store('temp');
        $path = storage_path('app') . '/' . $path1;
        $data = Excel::import(new StudentImport, $path);
        return response()->json(200);
    }

    public function allstudent()
    {
        return StudentResource::collection(Student::orderby('student_id', 'DESC')->get());
    }

    public function student_form_teacher($lecturer_id)
    {
        $joins = Student::join('tbl_class', 'tbl_class.class_id', '=', 'tbl_student.student_class')
            ->join('tbl_lecturer', 'tbl_lecturer.lecturer_id', '=', 'tbl_class.class_form_teacher')
            ->where('tbl_lecturer.lecturer_id', $lecturer_id)
            ->get();

        return StudentResource::collection($joins);
    }

    public function student_course_major($course, $major)
    {
        $joins = Student::where('student_course', $course)->where('student_major', $major)->get();
        return StudentResource::collection($joins);
    }

    public function update_info_personal($student_id, Request $request)
    {
        $stu = Student::find($student_id);

        $data = $request->validate([
            'student_phone' => ['required', 'digits:10', 'notspecial_spaces'],
            'student_other_email' => ['required', 'max:250', 'email'],

        ], [
            'student_phone.required' => 'S??? ??i???n tho???i kh??ng ???????c ????? tr???ng!',
            'student_phone.digits' => 'S??? ??i???n tho???i kh??ng nh???p qu?? 10 k?? t??? s???!',
            'student_phone.min' => 'S??? ??i???n tho???i c???n nh???p 10 s???!',
            'student_phone.notspecial_spaces' => 'S??? ??i???n tho???i kh??ng ch???a k?? t??? ?????c bi???t!',

            'student_other_email.required' => 'Email kh??ng ???????c ????? tr???ng!',
            'student_other_email.max' => 'Email kh??ng nh???p qu?? 250 k?? t???!',
            'student_other_email.email' => 'Thi???u @ cho Email!',
        ]);

        $stu->student_phone = $request->student_phone;
        $stu->student_other_email = $request->student_other_email;

        $stu->save();
    }
}
