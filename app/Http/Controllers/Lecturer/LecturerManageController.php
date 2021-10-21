<?php

namespace App\Http\Controllers\Lecturer;

use App\Http\Resources\LecturerManageResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lecturer;
use Session;
session_start();

class LecturerManageController extends Controller
{
    /**
     * Display a view of the list.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //---SEO
        $meta_title = "Quản lý tài khoản";
        $meta_desc = "Quản lý tài khoản giảng viên";
        $url_canonical = $request->url();
        //------
        
        $check_role = Lecturer::where('lecturer_code', Session::get('lecturer_id'))->limit(1)->get();

        return view('lecturer.pages.lecturer_manage')->with(compact('meta_title', 'meta_desc', 'url_canonical', 'check_role'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list($currentEntries)
    {
        return LecturerManageResource::collection(Lecturer::orderby('lecturer_id','DESC')->paginate($currentEntries));
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
    public function show($id)
    {
        //
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
        $lec->lecturer_role = $request->lecturer_role;
        $lec->save();
    }

    /**
     * Change the status for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
