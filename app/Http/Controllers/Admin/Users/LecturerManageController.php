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
        $lec = Lecturer::find($lecturer);
        if ($request->lecturer_role === 1) {
            $lec->lecturer_level = $request->lecturer_level;
            $lec->lecturer_role = $request->lecturer_role;
            $lec->save();
        } else {
            $lec->lecturer_role = $request->lecturer_role;
            $lec->save();
        }
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
        if($lec->lecturer_status==0){
            $lec->lecturer_status=1;
            $lec->save();
        }else{
            $lec->lecturer_status=0;
            $lec->save();
        }
    }

    public function detail($lecturer)
    {
        $joins = Lecturer::join('tbl_lecturer_info', 'tbl_lecturer_info.lecturer_id_ref', '=', 'tbl_lecturer.lecturer_id')->join('tbl_faculty', 'tbl_faculty.faculty_id', '=', 'tbl_lecturer.lecturer_faculty')->where('tbl_lecturer.lecturer_id', $lecturer)->orderby('tbl_lecturer.lecturer_id','DESC')->get();
        return LecturerManageResource::collection($joins);
    }

    public function lecturer()
    {
        return LecturerManageResource::collection(Lecturer::orderby('lecturer_id','DESC')->get());
    }

    public function admin()
    {
        return AdminResource::collection(Admin::orderby('admin_fullname','ASC')->get());
    }

    public function formteacher($lecturer_id)
    {
        $find = Lecturer::find($lecturer_id);
        $joins = Lecturer::join('tbl_faculty', 'tbl_faculty.faculty_id', '=', 'tbl_lecturer.lecturer_faculty')
        ->where('tbl_lecturer.lecturer_role', 2)
        ->where('tbl_faculty.faculty_id', $find->lecturer_faculty)
        ->orderby('tbl_lecturer.lecturer_id', 'DESC')->get();
        return LecturerManageResource::collection($joins);
    }

    public function show_formteacher($lecturer_id, $currentEntries)
    {
        $find = Lecturer::find($lecturer_id);
        $joins = Lecturer::join('tbl_faculty', 'tbl_faculty.faculty_id', '=', 'tbl_lecturer.lecturer_faculty')
        ->where('tbl_lecturer.lecturer_role', 2)
        ->where('tbl_faculty.faculty_id', $find->lecturer_faculty)
        ->orderby('tbl_lecturer.lecturer_id', 'DESC')->paginate($currentEntries);
        return LecturerManageResource::collection($joins);
    }

    public function search_formteacher($lecturer_id, $query, $currentEntries)
    {
        $find = Lecturer::find($lecturer_id);
        $joins = Lecturer::join('tbl_faculty', 'tbl_faculty.faculty_id', '=', 'tbl_lecturer.lecturer_faculty')
        ->where('tbl_lecturer.lecturer_fullname','LIKE','%'.$query.'%')
        ->where('tbl_lecturer.lecturer_role', 2)
        ->where('tbl_faculty.faculty_id', $find->lecturer_faculty)
        ->orwhere('tbl_lecturer.lecturer_email','LIKE','%'.$query.'%')
        ->where('tbl_lecturer.lecturer_role', 2)
        ->where('tbl_faculty.faculty_id', $find->lecturer_faculty)
        ->orderby('tbl_lecturer.lecturer_id', 'DESC')->paginate($currentEntries);
        return LecturerManageResource::collection($joins);
    }
}
