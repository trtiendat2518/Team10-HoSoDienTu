<?php

namespace App\Http\Controllers\Admin\Education;

use App\Http\Controllers\Controller;
use App\Models\EducationProgram;
use Illuminate\Http\Request;
use App\Http\Resources\EducationProgramResource;

class EducationProgramController extends Controller
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

    public function showdata($lecturer_id, $currentEntries)
    {
        $edu_program = EducationProgram::join('tbl_lecturer','tbl_lecturer.lecturer_faculty','=','tbl_education_program.education_program_faculty')->where('tbl_lecturer.lecturer_code',$lecturer_id)->orderby('education_program_course', 'ASC')->paginate($currentEntries);
        return EducationProgramResource::collection($edu_program);
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
     * @param  \App\Models\EducationProgram  $educationProgram
     * @return \Illuminate\Http\Response
     */
    public function show(EducationProgram $educationProgram)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EducationProgram  $educationProgram
     * @return \Illuminate\Http\Response
     */
    public function edit(EducationProgram $educationProgram)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EducationProgram  $educationProgram
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EducationProgram $educationProgram)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EducationProgram  $educationProgram
     * @return \Illuminate\Http\Response
     */
    public function destroy($educationProgram)
    {
        $pro = EducationProgram::find($educationProgram);
        $pro->delete();
    }

    public function filter_course($course, $currentEntries)
    {
        return EducationProgramResource::collection(EducationProgram::where('education_program_course','LIKE','%'.$course.'%')->orderby('education_program_id','DESC')->paginate($currentEntries));
    }

    public function filter_major($major, $currentEntries)
    {
        return EducationProgramResource::collection(EducationProgram::where('education_program_major','LIKE','%'.$major.'%')->orderby('education_program_id','DESC')->paginate($currentEntries));
    }

    public function destroyall(Request $request, $educationProgram = null)
    {
        if ($request->educationProgram) {
            foreach ($request->educationProgram as $id) {
                EducationProgram::where('education_program_id', $id)->delete();
            }
        }
    }

    public function change(Request $request, $educationProgram)
    {
        $pro = EducationProgram::find($educationProgram);
        if($pro->education_program_status==0){
            $pro->education_program_status=1;
            $pro->save();
        }else{
            $pro->education_program_status=0;
            $pro->save();
        }
    }
}
