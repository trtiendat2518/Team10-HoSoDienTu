<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Resources\AdminResource;
use App\Http\Resources\LecturerManageResource;
use App\Http\Resources\LectureInfoResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Lecturer;
use App\Models\AdminInfo;
use App\Models\LecturerInfo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
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
        return LecturerManageResource::collection(Lecturer::where('lecturer_fullname', 'LIKE', '%' . $query . '%')->orwhere('lecturer_email', 'LIKE', '%' . $query . '%')->orderby('lecturer_id', 'DESC')->paginate($currentEntries));
    }

    public function filter($value, $currentEntries)
    {
        return LecturerManageResource::collection(Lecturer::where('lecturer_role', 'LIKE', '%' . $value . '%')->paginate($currentEntries));
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
        return LecturerManageResource::collection(Lecturer::orderby('lecturer_id', 'DESC')->paginate($currentEntries));
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
        if ($lec->lecturer_status == 0) {
            $lec->lecturer_status = 1;
            $lec->save();
        } else {
            $lec->lecturer_status = 0;
            $lec->save();
        }
    }

    public function detail($lecturer)
    {
        $joins = Lecturer::join('tbl_lecturer_info', 'tbl_lecturer_info.lecturer_id_ref', '=', 'tbl_lecturer.lecturer_id')->join('tbl_faculty', 'tbl_faculty.faculty_id', '=', 'tbl_lecturer.lecturer_faculty')->where('tbl_lecturer.lecturer_id', $lecturer)->orderby('tbl_lecturer.lecturer_id', 'DESC')->get();
        return LecturerManageResource::collection($joins);
    }

    public function lecturer()
    {
        return LecturerManageResource::collection(Lecturer::orderby('lecturer_id', 'DESC')->get());
    }

    public function admin()
    {
        return AdminResource::collection(Admin::orderby('admin_fullname', 'ASC')->get());
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
            ->where('tbl_lecturer.lecturer_fullname', 'LIKE', '%' . $query . '%')
            ->where('tbl_lecturer.lecturer_role', 2)
            ->where('tbl_faculty.faculty_id', $find->lecturer_faculty)
            ->orwhere('tbl_lecturer.lecturer_email', 'LIKE', '%' . $query . '%')
            ->where('tbl_lecturer.lecturer_role', 2)
            ->where('tbl_faculty.faculty_id', $find->lecturer_faculty)
            ->orderby('tbl_lecturer.lecturer_id', 'DESC')->paginate($currentEntries);
        return LecturerManageResource::collection($joins);
    }

    public function info_admin($admin_id)
    {
        $joins = Admin::join('tbl_admin_info', 'tbl_admin_info.admin_id_ref', '=', 'tbl_admin.admin_id')
            ->where('tbl_admin.admin_id', $admin_id)->get();
        return AdminResource::collection($joins);
    }

    public function create_info_admin(Request $request)
    {
        $data = $request->validate([
            'admin_avatar' => ['required', 'mimes:jpeg,jpg,png,gif'],
            'admin_birthday' => ['required'],
            'admin_gender' => ['required'],
            'admin_ethnic' => ['max:50'],
            'admin_religion' => ['max:50'],
            'admin_phone' => ['required', 'max:11', 'min:10'],
            'admin_address' => ['required', 'max:255'],
            'admin_country' => ['required', 'max:50'],
            'admin_identify_card' => ['required', 'max:12', 'min:9'],
            'admin_birth_place' => ['required', 'max:100'],
            'admin_other_email' => ['email', 'max:250'],
        ], [
            'admin_avatar.required' => 'Ảnh đại diện không được để trống!',
            'admin_avatar.mimes' => 'Tệp nhập vào phải có đuôi jpeg,jpg,png,gif!',

            'admin_birthday.required' => 'Ngày sinh không được để trống!',
            'admin_gender.required' => 'Giới tính không được để trống!',

            'admin_ethnic.max' => 'Dân tộc không nhập quá 50 ký tự!',
            'admin_religion.max' => 'Tôn giáo không nhập quá 50 ký tự!',

            'admin_phone.required' => 'Số điện thoại không được để trống!',
            'admin_phone.max' => 'Số điện thoại không nhập quá 11 ký tự số!',
            'admin_phone.min' => 'Số điện thoại cần nhập 10 hoặc 11 số!',

            'admin_address.required' => 'Địa chỉ không được để trống!',
            'admin_address.max' => 'Địa chỉ không nhập quá 255 ký tự chữ!',

            'admin_country.required' => 'Quốc gia không được để trống!',
            'admin_country.max' => 'Quốc gia không nhập quá 50 ký tự chữ!',

            'admin_identify_card.required' => 'CMND/CCCD không được để trống!',
            'admin_identify_card.max' => 'CMND/CCCD không nhập quá 12 ký tự!',
            'admin_identify_card.min' => 'CMND/CCCD phải có 9 ký tự trở lên!',

            'admin_birth_place.required' => 'Nơi sinh không được để trống!',
            'admin_birth_place.max' => 'Nơi sinh không nhập quá 100 ký tự chữ!',

            'admin_other_email.max' => 'Email không nhập quá 250 ký tự!',
            'admin_other_email.email' => 'Sai định dạng email!',
        ]);

        $info = new AdminInfo();
        $info->admin_id_ref = $request->admin_id_ref;
        $info->admin_birthday = $data['admin_birthday'];
        $info->admin_gender = $data['admin_gender'];
        $info->admin_ethnic = $data['admin_ethnic'];
        $info->admin_religion = $data['admin_religion'];
        $info->admin_phone = $data['admin_phone'];
        $info->admin_address = $data['admin_address'];
        $info->admin_country = $data['admin_country'];
        $info->admin_identify_card = $data['admin_identify_card'];
        $info->admin_birth_place = $data['admin_birth_place'];
        $info->admin_other_email = $data['admin_other_email'];
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $info->created_at = now();

        $image = $data['admin_avatar'];
        $name = $request->admin_id_ref . '_avatar.png';
        Storage::disk('publicadmin')->put($name, File::get($image));
        $info->admin_avatar = $name;

        $info->save();
    }

    public function update_info_admin(Request $request, $info_id)
    {
        $data = $request->validate([
            'admin_avatar' => ['mimes:jpeg,jpg,png,gif'],
            'admin_birthday' => ['required'],
            'admin_gender' => ['required'],
            'admin_ethnic' => ['max:50'],
            'admin_religion' => ['max:50'],
            'admin_phone' => ['required', 'max:11', 'min:10'],
            'admin_address' => ['required', 'max:255'],
            'admin_country' => ['required', 'max:50'],
            'admin_identify_card' => ['required', 'max:12', 'min:9'],
            'admin_birth_place' => ['required', 'max:100'],
            'admin_other_email' => ['email', 'max:250'],
        ], [
            'admin_avatar.mimes' => 'Tệp nhập vào phải có đuôi jpeg,jpg,png,gif!',

            'admin_birthday.required' => 'Ngày sinh không được để trống!',
            'admin_gender.required' => 'Giới tính không được để trống!',

            'admin_ethnic.max' => 'Dân tộc không nhập quá 50 ký tự!',
            'admin_religion.max' => 'Tôn giáo không nhập quá 50 ký tự!',

            'admin_phone.required' => 'Số điện thoại không được để trống!',
            'admin_phone.max' => 'Số điện thoại không nhập quá 11 ký tự số!',
            'admin_phone.min' => 'Số điện thoại cần nhập 10 hoặc 11 số!',

            'admin_address.required' => 'Địa chỉ không được để trống!',
            'admin_address.max' => 'Địa chỉ không nhập quá 255 ký tự chữ!',

            'admin_country.required' => 'Quốc gia không được để trống!',
            'admin_country.max' => 'Quốc gia không nhập quá 50 ký tự chữ!',

            'admin_identify_card.required' => 'CMND/CCCD không được để trống!',
            'admin_identify_card.max' => 'CMND/CCCD không nhập quá 12 ký tự!',
            'admin_identify_card.min' => 'CMND/CCCD phải có 9 ký tự trở lên!',

            'admin_birth_place.required' => 'Nơi sinh không được để trống!',
            'admin_birth_place.max' => 'Nơi sinh không nhập quá 100 ký tự chữ!',

            'admin_other_email.max' => 'Email không nhập quá 250 ký tự!',
            'admin_other_email.email' => 'Sai định dạng email!',
        ]);

        $info = AdminInfo::find($info_id);
        $info->admin_birthday = $data['admin_birthday'];
        $info->admin_gender = $data['admin_gender'];
        $info->admin_ethnic = $data['admin_ethnic'];
        $info->admin_religion = $data['admin_religion'];
        $info->admin_phone = $data['admin_phone'];
        $info->admin_address = $data['admin_address'];
        $info->admin_country = $data['admin_country'];
        $info->admin_identify_card = $data['admin_identify_card'];
        $info->admin_birth_place = $data['admin_birth_place'];
        $info->admin_other_email = $data['admin_other_email'];
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $info->updated_at = now();

        $image = $data['admin_avatar'];
        $name = $request->admin_id_ref . '_avatar_' . time() . '.png';
        Storage::disk('publicadmin')->delete($info->admin_avatar);
        Storage::disk('publicadmin')->put($name, File::get($image));
        $info->admin_avatar = $name;

        $info->save();
    }

    public function update_info_admin_noimg(Request $request, $info_id)
    {
        $data = $request->validate([
            'admin_birthday' => ['required'],
            'admin_gender' => ['required'],
            'admin_ethnic' => ['max:50'],
            'admin_religion' => ['max:50'],
            'admin_phone' => ['required', 'max:11', 'min:10'],
            'admin_address' => ['required', 'max:255'],
            'admin_country' => ['required', 'max:50'],
            'admin_identify_card' => ['required', 'max:12', 'min:9'],
            'admin_birth_place' => ['required', 'max:100'],
            'admin_other_email' => ['email', 'max:250'],
        ], [
            'admin_birthday.required' => 'Ngày sinh không được để trống!',
            'admin_gender.required' => 'Giới tính không được để trống!',

            'admin_ethnic.max' => 'Dân tộc không nhập quá 50 ký tự!',
            'admin_religion.max' => 'Tôn giáo không nhập quá 50 ký tự!',

            'admin_phone.required' => 'Số điện thoại không được để trống!',
            'admin_phone.max' => 'Số điện thoại không nhập quá 11 ký tự số!',
            'admin_phone.min' => 'Số điện thoại cần nhập 10 hoặc 11 số!',

            'admin_address.required' => 'Địa chỉ không được để trống!',
            'admin_address.max' => 'Địa chỉ không nhập quá 255 ký tự chữ!',

            'admin_country.required' => 'Quốc gia không được để trống!',
            'admin_country.max' => 'Quốc gia không nhập quá 50 ký tự chữ!',

            'admin_identify_card.required' => 'CMND/CCCD không được để trống!',
            'admin_identify_card.max' => 'CMND/CCCD không nhập quá 12 ký tự!',
            'admin_identify_card.min' => 'CMND/CCCD phải có 9 ký tự trở lên!',

            'admin_birth_place.required' => 'Nơi sinh không được để trống!',
            'admin_birth_place.max' => 'Nơi sinh không nhập quá 100 ký tự chữ!',

            'admin_other_email.max' => 'Email không nhập quá 250 ký tự!',
            'admin_other_email.email' => 'Sai định dạng email!',
        ]);

        $info = AdminInfo::find($info_id);
        $info->admin_birthday = $data['admin_birthday'];
        $info->admin_gender = $data['admin_gender'];
        $info->admin_ethnic = $data['admin_ethnic'];
        $info->admin_religion = $data['admin_religion'];
        $info->admin_phone = $data['admin_phone'];
        $info->admin_address = $data['admin_address'];
        $info->admin_country = $data['admin_country'];
        $info->admin_identify_card = $data['admin_identify_card'];
        $info->admin_birth_place = $data['admin_birth_place'];
        $info->admin_other_email = $data['admin_other_email'];
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $info->updated_at = now();

        $info->save();
    }
}
