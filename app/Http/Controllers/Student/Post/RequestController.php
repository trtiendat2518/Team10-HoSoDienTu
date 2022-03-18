<?php

namespace App\Http\Controllers\Student\Post;

use App\Http\Controllers\Controller;
use App\Http\Resources\RequestResource;
use App\Models\RequestSudent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class RequestController extends Controller
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
            'request_title' => ['required', 'max:200', 'min:10', 'unique:tbl_request'],
            'request_content' => ['required', 'max:1000', 'min:50'],
        ], [
            'request_title.required' => 'Tiêu đề không được để trống!',
            'request_title.max' => 'Tiêu đề không nhập quá 200 ký tự chữ!',
            'request_title.min' => 'Tiêu đề phải có 10 ký tự chữ trở lên!',
            'request_title.unique' => 'Tiêu đề đã tồn tại!',

            'request_content.required' => 'Nội dung không được để trống!',
            'request_content.max' => 'Nội dung không nhập quá 1000 ký tự chữ!',
            'request_content.min' => 'Nội dung phải có 50 ký tự chữ trở lên!',
        ]);

        $request_student = new RequestSudent();
        $request_student->request_student = $request->student_id;
        $request_student->request_title = $data['request_title'];
        $request_student->request_content = $data['request_content'];
        date_default_timezone_set('Asia/Ho_Chi_Minh');

        $request_student->created_at = now();
        $request_student->save();
    }

    public function store_file(Request $request)
    {
        $data = $request->validate([
            'request_title' => ['required', 'max:200', 'min:10', 'unique:tbl_request'],
            'request_content' => ['required', 'max:1000', 'min:50'],
            'file' => ['max:5120', 'mimes:doc,docx,xlsx,xls,png,jpeg,jpg,pptx,ppt,pdf'],
        ], [
            'request_title.required' => 'Tiêu đề không được để trống!',
            'request_title.max' => 'Tiêu đề không nhập quá 200 ký tự chữ!',
            'request_title.min' => 'Tiêu đề phải có 10 ký tự chữ trở lên!',
            'request_title.unique' => 'Tiêu đề đã tồn tại!',

            'request_content.required' => 'Nội dung không được để trống!',
            'request_content.max' => 'Nội dung không nhập quá 1000 ký tự chữ!',
            'request_content.min' => 'Nội dung phải có 50 ký tự chữ trở lên!',

            'file.max' => 'Tệp đính kèm nhỏ hơn hoặc bằng 5MB!',
            'file.mimes' => 'Tệp đính kèm là file word, excel, powerpoint, pdf hoặc hình ảnh!',
        ]);

        $request_student = new RequestSudent();
        $request_student->request_student = $request->student_id;
        $request_student->request_title = $data['request_title'];
        $request_student->request_content = $data['request_content'];
        date_default_timezone_set('Asia/Ho_Chi_Minh');

        $attachment = $request->file('file');
        $get_name_file = $attachment->getClientOriginalName();
        $new_name_file = time() . '.' . $get_name_file;
        Storage::disk('attachment')->put($new_name_file, File::get($attachment));
        $request_student->request_file = $new_name_file;

        $request_student->created_at = now();
        $request_student->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($request_id)
    {
        $request_info = RequestSudent::join('tbl_student', 'tbl_student.student_id', '=', 'tbl_request.request_student')
            ->where('tbl_request.request_id', $request_id)->get();
        return RequestResource::collection($request_info);
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
        // $data = $request->validate([
        //     'request_title' => ['required', 'max:200', 'min:10'],
        //     'request_content' => ['required', 'max:1000', 'min:50']
        // ], [
        //     'request_title.required' => 'Tiêu đề không được để trống!',
        //     'request_title.max' => 'Tiêu đề không nhập quá 200 ký tự chữ!',
        //     'request_title.min' => 'Tiêu đề phải có 10 ký tự chữ trở lên!',
        //     'request_title.unique' => 'Tiêu đề đã tồn tại!',

        //     'request_content.required' => 'Nội dung không được để trống!',
        //     'request_content.max' => 'Nội dung không nhập quá 1000 ký tự chữ!',
        //     'request_content.min' => 'Nội dung phải có 50 ký tự chữ trở lên!'
        // ]);

        // $request_student = RequestSudent::find($id);
        // $request_student->request_student = $request->student_id;
        // $request_student->request_title = $data['request_title'];
        // $request_student->request_content = $data['request_content'];
        // date_default_timezone_set('Asia/Ho_Chi_Minh');

        // $request_student->created_at = now();
        // $request_student->save();
    }

    public function update_data(Request $request, $request_id)
    {
        $data = $request->validate([
            'request_title' => ['required', 'max:200', 'min:10'],
            'request_content' => ['required', 'max:1000', 'min:50']
        ], [
            'request_title.required' => 'Tiêu đề không được để trống!',
            'request_title.max' => 'Tiêu đề không nhập quá 200 ký tự chữ!',
            'request_title.min' => 'Tiêu đề phải có 10 ký tự chữ trở lên!',
            'request_title.unique' => 'Tiêu đề đã tồn tại!',

            'request_content.required' => 'Nội dung không được để trống!',
            'request_content.max' => 'Nội dung không nhập quá 1000 ký tự chữ!',
            'request_content.min' => 'Nội dung phải có 50 ký tự chữ trở lên!'
        ]);

        $request_student = RequestSudent::find($request_id);
        $request_student->request_student = $request->student_id;
        $request_student->request_title = $data['request_title'];
        $request_student->request_content = $data['request_content'];
        date_default_timezone_set('Asia/Ho_Chi_Minh');

        $request_student->updated_at = now();
        $request_student->save();
    }

    public function update_file(Request $request, $request_id)
    {
        $data = $request->validate([
            'request_title' => ['required', 'max:200', 'min:10'],
            'request_content' => ['required', 'max:1000', 'min:50'],
            'file' => ['max:5120', 'mimes:doc,docx,xlsx,xls,png,jpeg,jpg,pptx,ppt,pdf'],
        ], [
            'request_title.required' => 'Tiêu đề không được để trống!',
            'request_title.max' => 'Tiêu đề không nhập quá 200 ký tự chữ!',
            'request_title.min' => 'Tiêu đề phải có 10 ký tự chữ trở lên!',
            'request_title.unique' => 'Tiêu đề đã tồn tại!',

            'request_content.required' => 'Nội dung không được để trống!',
            'request_content.max' => 'Nội dung không nhập quá 1000 ký tự chữ!',
            'request_content.min' => 'Nội dung phải có 50 ký tự chữ trở lên!',

            'file.max' => 'Tệp đính kèm nhỏ hơn hoặc bằng 5MB!',
            'file.mimes' => 'Tệp đính kèm là file word, excel, powerpoint, pdf hoặc hình ảnh!',
        ]);

        $request_student = RequestSudent::find($request_id);
        $request_student->request_student = $request->student_id;
        $request_student->request_title = $data['request_title'];
        $request_student->request_content = $data['request_content'];
        date_default_timezone_set('Asia/Ho_Chi_Minh');

        $attachment = $request->file('file');
        $get_name_file = $attachment->getClientOriginalName();
        $new_name_file = time() . '.' . $get_name_file;
        Storage::disk('attachment')->delete($request_student->request_file);
        Storage::disk('attachment')->put($new_name_file, File::get($attachment));
        $request_student->request_file = $new_name_file;

        $request_student->updated_at = now();
        $request_student->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $del = RequestSudent::find($id);
        Storage::disk('attachment')->delete($del->request_file);
        $del->delete();
    }

    public function showdata($student_id, $currentEntries)
    {
        $joins = RequestSudent::join('tbl_student', 'tbl_student.student_id', '=', 'tbl_request.request_student')
            ->where('tbl_student.student_id', $student_id)
            ->orderby('tbl_request.request_id', 'DESC')
            ->paginate($currentEntries);
        return RequestResource::collection($joins);
    }

    public function filter($student_id, $value, $currentEntries)
    {
        $joins = RequestSudent::join('tbl_student', 'tbl_student.student_id', '=', 'tbl_request.request_student')
            ->where('tbl_request.request_status', $value)
            ->where('tbl_student.student_id', $student_id)
            ->orderby('tbl_request.request_id', 'DESC')
            ->paginate($currentEntries);
        return RequestResource::collection($joins);
    }

    public function search($student_id, $query, $currentEntries)
    {
        $joins = RequestSudent::join('tbl_student', 'tbl_student.student_id', '=', 'tbl_request.request_student')
            ->where('tbl_request.request_title', 'LIKE', '%' . $query . '%')
            ->where('tbl_student.student_id', $student_id)
            ->orderby('tbl_request.request_id', 'DESC')
            ->paginate($currentEntries);
        return RequestResource::collection($joins);
    }
}
