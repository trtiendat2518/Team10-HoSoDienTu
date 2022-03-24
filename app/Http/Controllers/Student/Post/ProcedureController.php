<?php

namespace App\Http\Controllers\Student\Post;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProcedureRequireResource;
use App\Http\Resources\ProcedureResource;
use App\Models\Procedure;
use App\Models\ProcedureRequire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ProcedureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $join = Procedure::where('procedure_status', 0)->get();
        return ProcedureResource::collection($join);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $procedures = new ProcedureRequire();

        $count = ProcedureRequire::orderby('procedure_require_id', 'DESC')->first();
        if (!$count) {
            $count->procedure_require_id = 1;
        } else {
            $count->procedure_require_id = $count->procedure_require_id + 1;
        }

        if ($count->procedure_require_id > 99999 && $count->procedure_require_id < 1000000) {
            $procedures->procedure_require_code = 'CTTT0' . $count->procedure_require_id;
        } else if ($count->procedure_require_id > 9999 && $count->procedure_require_id < 100000) {
            $procedures->procedure_require_code = 'CTTT00' . $count->procedure_require_idt;
        } else if ($count->procedure_require_id > 999 && $count->procedure_require_id < 10000) {
            $procedures->procedure_require_code = 'CTTT000' . $count->procedure_require_id;
        } else if ($count->procedure_require_id > 99 && $count->procedure_require_id < 1000) {
            $procedures->procedure_require_code = 'CTTT0000' . $count->procedure_require_id;
        } else if ($count->procedure_require_id > 9 && $count->procedure_require_id < 100) {
            $procedures->procedure_require_code = 'CTTT00000' . $count->procedure_require_id;
        } else {
            $procedures->procedure_require_code = 'CTTT000000' . $count->procedure_require_id;
        }

        $procedures->procedure_require_detail = $request->procedure_id;
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $procedures->procedure_require_datesend = now();
        $procedures->procedure_require_student = $request->student_id;
        $procedures->procedure_require_name = $request->procedure_require_name;
        $procedures->procedure_require_phone = $request->procedure_require_phone;
        $procedures->procedure_require_address = $request->procedure_require_address;
        $procedures->procedure_require_note = $request->procedure_require_note;
        $procedures->procedure_require_quantity = $request->procedure_require_quantity;
        $procedures->procedure_require_input = $request->procedure_require_input;
        $procedures->procedure_require_area = $request->procedure_require_area;
        $procedures->procedure_require_select = $request->procedure_require_select;

        $arrayFile = array();

        if ($request->file('procedure_require_file') != '' || $request->file('procedure_require_file') != null) {
            foreach ($request->file('procedure_require_file') as $key => $file) {
                $attachment = $file;
                $get_name_file = $attachment->getClientOriginalName();
                $new_name_file = time() . '.' . $get_name_file;
                Storage::disk('fileprocedure')->put($new_name_file, File::get($attachment));
                array_push($arrayFile, $new_name_file);
            }
            $stringFile = implode('; ', $arrayFile);
            $procedures->procedure_require_file = $stringFile;
        }
        $procedures->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $show = Procedure::where('procedure_id', $id)->where('procedure_status', 0)->get();
        return ProcedureResource::collection($show);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $del = ProcedureRequire::find($id);
        if ($del->procedure_require_file != '' || $del->procedure_require_file != null) {
            $splitFile = explode("; ", $del->procedure_require_file);
            foreach ($splitFile as $key => $value) {
                Storage::disk('fileprocedure')->delete($value);
            }
        }
        $del->delete();
    }

    public function my_procedures($student_id)
    {
        $joins = ProcedureRequire::join('tbl_student', 'tbl_student.student_id', '=', 'tbl_procedure_require.procedure_require_student')
            ->join('tbl_procedure', 'tbl_procedure.procedure_id', '=', 'tbl_procedure_require.procedure_require_detail')
            ->where('tbl_student.student_id', $student_id)->orderby('procedure_require_id', 'DESC')->get();
        return ProcedureRequireResource::collection($joins);
    }
}
