<?php

namespace App\Http\Controllers\Admin\Posts;

use App\Http\Controllers\Controller;
use App\Models\ProcedureRequire;
use Illuminate\Http\Request;
use App\Http\Resources\ProcedureRequireResource;
use App\Models\Admin;
use App\Models\Notification;

class ProcedureRequireController extends Controller
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
     * @param  \App\Models\ProcedureRequire  $procedureRequire
     * @return \Illuminate\Http\Response
     */
    public function show($currentEntries)
    {
        $join = ProcedureRequire::join('tbl_procedure', 'tbl_procedure.procedure_id', '=', 'tbl_procedure_require.procedure_require_detail')
            ->join('tbl_student', 'tbl_student.student_id', '=', 'tbl_procedure_require.procedure_require_student')
            ->orderby('procedure_require_id', 'DESC')->paginate($currentEntries);
        return ProcedureRequireResource::collection($join);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProcedureRequire  $procedureRequire
     * @return \Illuminate\Http\Response
     */
    public function edit(ProcedureRequire $procedureRequire)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProcedureRequire  $procedureRequire
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProcedureRequire $procedureRequire)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProcedureRequire  $procedureRequire
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProcedureRequire $procedureRequire)
    {
        //
    }

    public function search($query, $currentEntries)
    {
        $join = ProcedureRequire::join('tbl_procedure', 'tbl_procedure.procedure_id', '=', 'tbl_procedure_require.procedure_require_detail')
            ->join('tbl_student', 'tbl_student.student_id', '=', 'tbl_procedure_require.procedure_require_student')
            ->orderby('procedure_id', 'DESC')->where('procedure_title', 'LIKE', '%' . $query . '%')->paginate($currentEntries);
        return ProcedureRequireResource::collection($join);
    }

    public function filter($value, $currentEntries)
    {
        $join = ProcedureRequire::join('tbl_procedure', 'tbl_procedure.procedure_id', '=', 'tbl_procedure_require.procedure_require_detail')
            ->join('tbl_student', 'tbl_student.student_id', '=', 'tbl_procedure_require.procedure_require_student')
            ->where('procedure_require_status', 'LIKE', '%' . $value . '%')->orderby('procedure_require_id', 'DESC')
            ->paginate($currentEntries);
        return ProcedureRequireResource::collection($join);
    }

    public function change(Request $request, $procedure_require_id, $admin_id)
    {
        $admin = Admin::find($admin_id);
        $pst = ProcedureRequire::find($procedure_require_id);
        $pst->procedure_require_status = $request->procedure_require_status;
        $pst->procedure_require_admin = $admin->admin_fullname;
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $pst->procedure_require_dateget = now();
        $save = $pst->save();

        if ($save) {
            $noti = new Notification();
            $noti->notification_title = $procedure_require_id;
            $noti->notification_student = $pst->procedure_require_student;
            $noti->notification_object = 3;
            $noti->notification_type = 'procedure';
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $noti->notification_date = now();
            $noti->save();
        }
    }

    public function detail($procedure_require_id)
    {
        $join = ProcedureRequire::join('tbl_procedure', 'tbl_procedure.procedure_id', '=', 'tbl_procedure_require.procedure_require_detail')
            ->join('tbl_student', 'tbl_student.student_id', '=', 'tbl_procedure_require.procedure_require_student')
            ->where('tbl_procedure_require.procedure_require_id', $procedure_require_id)
            ->orderby('procedure_require_id', 'DESC')->get();
        return ProcedureRequireResource::collection($join);
    }
}
