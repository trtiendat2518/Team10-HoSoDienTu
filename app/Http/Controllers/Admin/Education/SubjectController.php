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
        //
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
        $subject_faculty = Subject::join('tbl_lecturer','tbl_lecturer.lecturer_faculty','=','tbl_subject.subject_faculty')->where('tbl_lecturer.lecturer_code',$lecturer_id)->paginate($currentEntries);
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
    public function update(Request $request, Subject $subject)
    {
        //
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
