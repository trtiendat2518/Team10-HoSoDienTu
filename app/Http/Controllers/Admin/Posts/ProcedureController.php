<?php

namespace App\Http\Controllers\Admin\Posts;

use App\Http\Resources\ProcedureResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Procedure;

class ProcedureController extends Controller
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'procedure_code' => ['required', 'max:10', 'unique:tbl_procedure'],
            'procedure_title' => ['required', 'max:200', 'min:10', 'unique:tbl_procedure'],
            'procedure_content' => ['required', 'min:20'],
            'procedure_time' => ['required', 'max:10'],
            'procedure_method' => ['required'],
            'procedure_fee' => ['required', 'max:10'],
            'procedure_category' => ['required'],
            'procedure_status' => ['required'],
        ], [
            'procedure_code.required' => 'Mã thủ tục không được để trống!',
            'procedure_code.max' => 'Mã thủ tục không nhập quá 10 ký tự!',
            'procedure_code.unique' => 'Mã thủ tục đã tồn tại!',

            'procedure_title.required' => 'Tiêu đề thủ tục không được để trống!',
            'procedure_title.max' => 'Tiêu đề thủ tục không nhập quá 200 ký tự!',
            'procedure_title.min' => 'Tiêu đề thủ tục phải có 10 ký tự trở lên!',
            'procedure_title.unique' => 'Tiêu đề thủ tục đã tồn tại!',

            'procedure_content.required' => 'Nội dung thủ tục không được để trống!',
            'procedure_content.min' => 'Nội dung thủ tục phải có 20 ký tự trở lên!',

            'procedure_time.required' => 'Thời gian chuẩn bị thủ tục không được để trống!',
            'procedure_time.max' => 'Thời gian chuẩn bị thủ tục tối đa có 10 ký tự!',

            'procedure_fee.required' => 'Phí của thủ tục không được để trống!',
            'procedure_fee.max' => 'Phí của thủ tục tối đa có 10 ký tự!',

            'procedure_method.required' => 'Vui lòng chọn phương thức cho thủ tục này!',
            'procedure_category.required' => 'Vui lòng chọn danh mục cho thủ tục này!',
            'procedure_status.required' => 'Vui lòng chọn trạng thái cho thủ tục này!'
        ]);

        $procedure = new Procedure();
        $procedure->procedure_code = $data['procedure_code'];
        $procedure->procedure_title = $data['procedure_title'];
        $procedure->procedure_content = $data['procedure_content'];
        $procedure->procedure_time = $data['procedure_time'];
        $procedure->procedure_method = $data['procedure_method'];
        $procedure->procedure_fee = $data['procedure_fee'];
        $procedure->procedure_category = $data['procedure_category'];
        $procedure->procedure_status = $data['procedure_status'];
        $procedure->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($currentEntries)
    {
        return ProcedureResource::collection(Procedure::orderby('procedure_id', 'DESC')->paginate($currentEntries));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $procedure_id)
    {
        $data = $request->validate([
            'procedure_title' => ['required', 'max:200', 'min:10', "unique:tbl_procedure,procedure_title,$procedure_id,procedure_id"],
            'procedure_content' => ['required', 'min:20'],
            'procedure_time' => ['required', 'max:10'],
            'procedure_method' => ['required'],
            'procedure_fee' => ['required', 'max:10'],
            'procedure_category' => ['required'],
        ], [
            'procedure_title.required' => 'Tiêu đề thủ tục không được để trống!',
            'procedure_title.max' => 'Tiêu đề thủ tục không nhập quá 200 ký tự!',
            'procedure_title.min' => 'Tiêu đề thủ tục phải có 10 ký tự trở lên!',
            'procedure_title.unique' => 'Tiêu đề thủ tục đã tồn tại!',

            'procedure_content.required' => 'Nội dung thủ tục không được để trống!',
            'procedure_content.min' => 'Nội dung thủ tục phải có 20 ký tự trở lên!',

            'procedure_time.required' => 'Thời gian chuẩn bị thủ tục không được để trống!',
            'procedure_time.max' => 'Thời gian chuẩn bị thủ tục tối đa có 10 ký tự!',

            'procedure_fee.required' => 'Phí của thủ tục không được để trống!',
            'procedure_fee.max' => 'Phí của thủ tục tối đa có 10 ký tự!',

            'procedure_method.required' => 'Vui lòng chọn phương thức cho thủ tục này!',
            'procedure_category.required' => 'Vui lòng chọn danh mục cho thủ tục này!',
        ]);

        $procedure = Procedure::find($procedure_id);
        $procedure->procedure_title = $data['procedure_title'];
        $procedure->procedure_content = $data['procedure_content'];
        $procedure->procedure_time = $data['procedure_time'];
        $procedure->procedure_method = $data['procedure_method'];
        $procedure->procedure_fee = $data['procedure_fee'];
        $procedure->procedure_category = $data['procedure_category'];
        $procedure->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($procedure_id)
    {
        $pst = Procedure::find($procedure_id);
        $pst->delete();
    }

    public function procedure(Request $request, $procedure_id)
    {
        return ProcedureResource::collection(Procedure::where('procedure_id', $procedure_id)->orderby('procedure_id', 'DESC')->get());
    }

    public function change(Request $request, $procedure_id)
    {
        $pst = Procedure::find($procedure_id);
        if ($pst->procedure_status == 0) {
            $pst->procedure_status = 1;
            $pst->save();
        } else {
            $pst->procedure_status = 0;
            $pst->save();
        }
    }

    public function destroyall(Request $request, $procedure_id = null)
    {
        if ($request->procedure_id) {
            foreach ($request->procedure_id as $id) {
                Procedure::where('procedure_id', $id)->delete();
            }
        }
    }

    public function search($query, $currentEntries)
    {
        return ProcedureResource::collection(Procedure::where('procedure_title', 'LIKE', '%' . $query . '%')->orderby('procedure_id', 'DESC')->paginate($currentEntries));
    }

    public function filter($value, $currentEntries)
    {
        return ProcedureResource::collection(Procedure::where('procedure_category', 'LIKE', '%' . $value . '%')->orderby('procedure_id', 'DESC')->paginate($currentEntries));
    }

    public function procedure_all()
    {
        return ProcedureResource::collection(Procedure::orderby('procedure_id', 'DESC')->get());
    }
}
