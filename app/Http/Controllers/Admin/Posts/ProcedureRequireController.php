<?php

namespace App\Http\Controllers\Admin\Posts;

use App\Http\Controllers\Controller;
use App\Models\ProcedureRequire;
use Illuminate\Http\Request;
use App\Http\Resources\ProcedureRequireResource;

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
        $join = ProcedureRequire::join('tbl_procedure', 'tbl_procedure.procedure_id','=','tbl_procedure_require.procedure_require_detail')->orderby('procedure_require_id','DESC')->paginate($currentEntries);
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
        $join = ProcedureRequire::join('tbl_procedure', 'tbl_procedure.procedure_id','=','tbl_procedure_require.procedure_require_detail')->orderby('procedure_id','DESC')->where('procedure_title','LIKE','%'.$query.'%')->paginate($currentEntries);
        return ProcedureRequireResource::collection($join);
    }

    public function filter($value, $currentEntries)
    {
        $join = ProcedureRequire::join('tbl_procedure', 'tbl_procedure.procedure_id','=','tbl_procedure_require.procedure_require_detail')->where('procedure_require_status','LIKE','%'.$value.'%')->orderby('procedure_require_id','DESC')->paginate($currentEntries);
        return ProcedureRequireResource::collection($join);
    }

    public function change(Request $request, $procedure_require_id)
    {
        $pst = ProcedureRequire::find($procedure_require_id);
        $pst->procedure_require_status = $request->procedure_require_status;
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $pst->procedure_require_dateget = now();
        $pst->save();
    }
}
