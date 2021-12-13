<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Resources\AdminResource;
use App\Http\Resources\LecturerManageResource;
use App\Http\Resources\LectureInfoResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Lecturer;
use App\Models\LecturerInfo;
use App\Models\FormTeacher;
use Validator;
use Session;

class LecturerManageController extends Controller
{
    /**
     * Display a view of the list.
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
        return LecturerManageResource::collection(Lecturer::where('lecturer_fullname','LIKE','%'.$query.'%')->orwhere('lecturer_email','LIKE','%'.$query.'%')->orderby('lecturer_id','DESC')->paginate($currentEntries));
    }

    public function filter($value, $currentEntries)
    {
        return LecturerManageResource::collection(Lecturer::where('lecturer_role','LIKE','%'.$value.'%')->paginate($currentEntries));
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($currentEntries)
    {
        return LecturerManageResource::collection(Lecturer::orderby('lecturer_id','DESC')->paginate($currentEntries));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $lecturer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($lecturer)
    {
        $lec = Lecturer::find($lecturer);
        $lec->delete();
    }

    /**
     * Remove all the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyall(Request $request, $lecturer = null)
    {
        if ($request->lecturer) {
            foreach ($request->lecturer as $id) {
                Lecturer::where('lecturer_id', $id)->delete();
            }
        }
    }

    /**
     * Change status of resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function change(Request $request, $lecturer)
    {
        $lec = Lecturer::find($lecturer);
        $formteacher = FormTeacher::where('form_teacher_code', $lec->lecturer_code)->get();
        if($lec->lecturer_status==0){
            $lec->lecturer_status=1;
            foreach ($formteacher as $key => $value) {
                $value->form_teacher_status = 1;
                $value->save();
            }
            $lec->save();
        }else{
            $lec->lecturer_status=0;
            foreach ($formteacher as $key => $value) {
                $value->form_teacher_status = 0;
                $value->save();
            }
            $lec->save();
        }
    }

    public function detail($lecturer)
    {
        return LectureInfoResource::collection(LecturerInfo::where('lecturer_code',$lecturer)->paginate(1));
    }

    public function lecturer()
    {
        return LecturerManageResource::collection(Lecturer::orderby('lecturer_id','DESC')->get());
    }

    public function admin()
    {
        return AdminResource::collection(Admin::orderby('admin_fullname','ASC')->get());
    }

    public function role(Request $request, $lecturer)
    {
        $lec = Lecturer::find($lecturer);
        
        if ($request->lecturer_role == 0) {
            $lec->lecturer_role = $request->lecturer_role;
            $lec->lecturer_level = 0;
        } else if ($request->lecturer_role == 1) {
            $lec->lecturer_role = $request->lecturer_role;
            $lec->lecturer_level = $request->lecturer_level;
        } else if ($request->lecturer_role == 2) {
            $lec->lecturer_role = $request->lecturer_role;
            $lec->lecturer_level = 0;
            $find = FormTeacher::where('form_teacher_code', $lec->lecturer_code)->first();
            if ($find === null) {
                $new = new FormTeacher();
                $new->form_teacher_code = $lec->lecturer_code;
                $new->form_teacher_status = $lec->lecturer_status;
                $new->save();
            }
        }
        $lec->save();
    }
}
