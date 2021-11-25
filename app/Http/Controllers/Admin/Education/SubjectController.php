<?php

namespace App\Http\Controllers\Admin\Education;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Http\Request;
use App\Http\Resources\SubjectResource;
use Validator;

class SubjectController extends Controller
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
            'subject_code' => ['required', 'max:10', 'min:2', 'unique:tbl_subject', 'notspecial_spaces'],
            'subject_name' => ['required', 'max:100', 'min:6', 'unique:tbl_subject'],
            'subject_credit' => ['required', 'max:11'],
            'subject_practice_period' => ['required', 'max:11'],
            'subject_theory_period' => ['required', 'max:11'],
            'subject_type' => ['required'],
            'subject_status' => ['required'],
        ],[
            'subject_code.required' => 'Mã Môn học không dược để trống!',
            'subject_code.max' => 'Mã Môn học không nhập quá 10 ký tự chữ!',
            'subject_code.min' => 'Mã Môn học phải có 2 ký tự chữ trở lên!',
            'subject_code.unique' => 'Mã Môn học đã tồn tại!',
            'subject_code.notspecial_spaces' => 'Mã Môn học không được chứa ký tự đặc biệt!',

            'subject_name.required' => 'Tên Môn học không dược để trống!',
            'subject_name.max' => 'Tên Môn học không nhập quá 100 ký tự chữ!',
            'subject_name.min' => 'Tên Môn học phải có 6 ký tự chữ trở lên!',
            'subject_name.unique' => 'Tên Môn học đã tồn tại!',

            'subject_credit.required' => 'Số tín chỉ không dược để trống!',
            'subject_credit.max' => 'Số tín chỉ không nhập quá 11 ký tự số!',

            'subject_practice_period.required' => 'Số giờ thực hành không dược để trống!',
            'subject_practice_period.max' => 'Số giờ thực hành không nhập quá 11 ký tự số!',

            'subject_theory_period.required' => 'Số giờ lý thuyết không dược để trống!',
            'subject_theory_period.max' => 'Số giờ lý thuyết không nhập quá 11 ký tự số!',

            'subject_type.required' => 'Loại Môn học không dược để trống!',
            'subject_status.required' => 'Trạng thái Môn học không dược để trống!',
        ]);

        $subject = new Subject();
        $subject->subject_code = $data['subject_code'];
        $subject->subject_name = $data['subject_name'];
        $subject->subject_faculty = $request->subject_faculty;
        $subject->subject_credit = $data['subject_credit'];
        $subject->subject_theory_period = $data['subject_theory_period'];
        $subject->subject_practice_period = $data['subject_practice_period'];
        $subject->subject_type = $data['subject_type'];
        $subject->subject_status = $data['subject_status'];
        $subject->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function show(Subject $subject)
    {
        //
    }

    public function showdata($lecturer_id, $currentEntries)
    {
        $subject_faculty = Subject::join('tbl_lecturer','tbl_lecturer.lecturer_faculty','=','tbl_subject.subject_faculty')->where('tbl_lecturer.lecturer_code',$lecturer_id)->orderby('subject_id', 'DESC')->paginate($currentEntries);
        return SubjectResource::collection($subject_faculty);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function edit(Subject $subject)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $subject)
    {
        $data = $request->validate([
            'subject_code' => ['required', 'max:10', 'min:2', 'notspecial_spaces'],
            'subject_name' => ['required', 'max:100', 'min:6'],
            'subject_credit' => ['required', 'max:11'],
            'subject_practice_period' => ['required', 'max:11'],
            'subject_theory_period' => ['required', 'max:11'],
            'subject_type' => ['required'],
            'subject_status' => ['required'],
        ],[
            'subject_code.required' => 'Mã Môn học không dược để trống!',
            'subject_code.max' => 'Mã Môn học không nhập quá 10 ký tự chữ!',
            'subject_code.min' => 'Mã Môn học phải có 2 ký tự chữ trở lên!',
            'subject_code.notspecial_spaces' => 'Mã Môn học không được chứa ký tự đặc biệt!',

            'subject_name.required' => 'Tên Môn học không dược để trống!',
            'subject_name.max' => 'Tên Môn học không nhập quá 100 ký tự chữ!',
            'subject_name.min' => 'Tên Môn học phải có 6 ký tự chữ trở lên!',

            'subject_credit.required' => 'Số tín chỉ không dược để trống!',
            'subject_credit.max' => 'Số tín chỉ không nhập quá 11 ký tự số!',

            'subject_practice_period.required' => 'Số giờ thực hành không dược để trống!',
            'subject_practice_period.max' => 'Số giờ thực hành không nhập quá 11 ký tự số!',

            'subject_theory_period.required' => 'Số giờ lý thuyết không dược để trống!',
            'subject_theory_period.max' => 'Số giờ lý thuyết không nhập quá 11 ký tự số!',

            'subject_type.required' => 'Loại Môn học không dược để trống!',
            'subject_status.required' => 'Trạng thái Môn học không dược để trống!',
        ]);

        $sj = Subject::find($subject);
        $sj->subject_code = $data['subject_code'];
        $sj->subject_name = $data['subject_name'];
        $sj->subject_credit = $data['subject_credit'];
        $sj->subject_theory_period = $data['subject_theory_period'];
        $sj->subject_practice_period = $data['subject_practice_period'];
        $sj->subject_type = $data['subject_type'];
        $sj->subject_status = $data['subject_status'];
        $sj->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function destroy($subject)
    {
        $sj = Subject::find($subject);
        $sj->delete();
    }

    public function search($query, $currentEntries)
    {
        return SubjectResource::collection(Subject::where('subject_code','LIKE','%'.$query.'%')->orwhere('subject_name','LIKE','%'.$query.'%')->orderby('subject_id','DESC')->paginate($currentEntries));
    }

    public function destroyall(Request $request, $subject = null)
    {
        if ($request->subject) {
            foreach ($request->subject as $id) {
                Subject::where('subject_id', $id)->delete();
            }
        }
    }

    public function change(Request $request, $subject)
    {
        $sj = Subject::find($subject);
        if($sj->subject_status==0){
            $sj->subject_status=1;
            $sj->save();
        }else{
            $sj->subject_status=0;
            $sj->save();
        }
    }

    public function detail($subject)
    {
        return SubjectResource::collection(Subject::where('subject_id',$subject)->get());
    }
}
