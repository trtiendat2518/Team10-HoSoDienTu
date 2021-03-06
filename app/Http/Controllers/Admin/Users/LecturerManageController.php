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
            'admin_avatar.required' => '???nh ?????i di???n kh??ng ???????c ????? tr???ng!',
            'admin_avatar.mimes' => 'T???p nh???p v??o ph???i c?? ??u??i jpeg,jpg,png,gif!',

            'admin_birthday.required' => 'Ng??y sinh kh??ng ???????c ????? tr???ng!',
            'admin_gender.required' => 'Gi???i t??nh kh??ng ???????c ????? tr???ng!',

            'admin_ethnic.max' => 'D??n t???c kh??ng nh???p qu?? 50 k?? t???!',
            'admin_religion.max' => 'T??n gi??o kh??ng nh???p qu?? 50 k?? t???!',

            'admin_phone.required' => 'S??? ??i???n tho???i kh??ng ???????c ????? tr???ng!',
            'admin_phone.max' => 'S??? ??i???n tho???i kh??ng nh???p qu?? 11 k?? t??? s???!',
            'admin_phone.min' => 'S??? ??i???n tho???i c???n nh???p 10 ho???c 11 s???!',

            'admin_address.required' => '?????a ch??? kh??ng ???????c ????? tr???ng!',
            'admin_address.max' => '?????a ch??? kh??ng nh???p qu?? 255 k?? t??? ch???!',

            'admin_country.required' => 'Qu???c gia kh??ng ???????c ????? tr???ng!',
            'admin_country.max' => 'Qu???c gia kh??ng nh???p qu?? 50 k?? t??? ch???!',

            'admin_identify_card.required' => 'CMND/CCCD kh??ng ???????c ????? tr???ng!',
            'admin_identify_card.max' => 'CMND/CCCD kh??ng nh???p qu?? 12 k?? t???!',
            'admin_identify_card.min' => 'CMND/CCCD ph???i c?? 9 k?? t??? tr??? l??n!',

            'admin_birth_place.required' => 'N??i sinh kh??ng ???????c ????? tr???ng!',
            'admin_birth_place.max' => 'N??i sinh kh??ng nh???p qu?? 100 k?? t??? ch???!',

            'admin_other_email.max' => 'Email kh??ng nh???p qu?? 250 k?? t???!',
            'admin_other_email.email' => 'Sai ?????nh d???ng email!',
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
            'admin_avatar.mimes' => 'T???p nh???p v??o ph???i c?? ??u??i jpeg,jpg,png,gif!',

            'admin_birthday.required' => 'Ng??y sinh kh??ng ???????c ????? tr???ng!',
            'admin_gender.required' => 'Gi???i t??nh kh??ng ???????c ????? tr???ng!',

            'admin_ethnic.max' => 'D??n t???c kh??ng nh???p qu?? 50 k?? t???!',
            'admin_religion.max' => 'T??n gi??o kh??ng nh???p qu?? 50 k?? t???!',

            'admin_phone.required' => 'S??? ??i???n tho???i kh??ng ???????c ????? tr???ng!',
            'admin_phone.max' => 'S??? ??i???n tho???i kh??ng nh???p qu?? 11 k?? t??? s???!',
            'admin_phone.min' => 'S??? ??i???n tho???i c???n nh???p 10 ho???c 11 s???!',

            'admin_address.required' => '?????a ch??? kh??ng ???????c ????? tr???ng!',
            'admin_address.max' => '?????a ch??? kh??ng nh???p qu?? 255 k?? t??? ch???!',

            'admin_country.required' => 'Qu???c gia kh??ng ???????c ????? tr???ng!',
            'admin_country.max' => 'Qu???c gia kh??ng nh???p qu?? 50 k?? t??? ch???!',

            'admin_identify_card.required' => 'CMND/CCCD kh??ng ???????c ????? tr???ng!',
            'admin_identify_card.max' => 'CMND/CCCD kh??ng nh???p qu?? 12 k?? t???!',
            'admin_identify_card.min' => 'CMND/CCCD ph???i c?? 9 k?? t??? tr??? l??n!',

            'admin_birth_place.required' => 'N??i sinh kh??ng ???????c ????? tr???ng!',
            'admin_birth_place.max' => 'N??i sinh kh??ng nh???p qu?? 100 k?? t??? ch???!',

            'admin_other_email.max' => 'Email kh??ng nh???p qu?? 250 k?? t???!',
            'admin_other_email.email' => 'Sai ?????nh d???ng email!',
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
        $name = $info->admin_id_ref . '_avatar_' . time() . '.png';
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
            'admin_birthday.required' => 'Ng??y sinh kh??ng ???????c ????? tr???ng!',
            'admin_gender.required' => 'Gi???i t??nh kh??ng ???????c ????? tr???ng!',

            'admin_ethnic.max' => 'D??n t???c kh??ng nh???p qu?? 50 k?? t???!',
            'admin_religion.max' => 'T??n gi??o kh??ng nh???p qu?? 50 k?? t???!',

            'admin_phone.required' => 'S??? ??i???n tho???i kh??ng ???????c ????? tr???ng!',
            'admin_phone.max' => 'S??? ??i???n tho???i kh??ng nh???p qu?? 11 k?? t??? s???!',
            'admin_phone.min' => 'S??? ??i???n tho???i c???n nh???p 10 ho???c 11 s???!',

            'admin_address.required' => '?????a ch??? kh??ng ???????c ????? tr???ng!',
            'admin_address.max' => '?????a ch??? kh??ng nh???p qu?? 255 k?? t??? ch???!',

            'admin_country.required' => 'Qu???c gia kh??ng ???????c ????? tr???ng!',
            'admin_country.max' => 'Qu???c gia kh??ng nh???p qu?? 50 k?? t??? ch???!',

            'admin_identify_card.required' => 'CMND/CCCD kh??ng ???????c ????? tr???ng!',
            'admin_identify_card.max' => 'CMND/CCCD kh??ng nh???p qu?? 12 k?? t???!',
            'admin_identify_card.min' => 'CMND/CCCD ph???i c?? 9 k?? t??? tr??? l??n!',

            'admin_birth_place.required' => 'N??i sinh kh??ng ???????c ????? tr???ng!',
            'admin_birth_place.max' => 'N??i sinh kh??ng nh???p qu?? 100 k?? t??? ch???!',

            'admin_other_email.max' => 'Email kh??ng nh???p qu?? 250 k?? t???!',
            'admin_other_email.email' => 'Sai ?????nh d???ng email!',
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

    public function deanfaculty($lecturer_id)
    {
        return LecturerManageResource::collection(Lecturer::where('lecturer_id', $lecturer_id)->get());
    }

    public function info_deanfaculty($lecturer_id)
    {
        $joins = Lecturer::join('tbl_lecturer_info', 'tbl_lecturer_info.lecturer_id_ref', '=', 'tbl_lecturer.lecturer_id')
            ->where('tbl_lecturer.lecturer_id', $lecturer_id)->get();
        return LecturerManageResource::collection($joins);
    }

    public function create_info_deanfaculty(Request $request)
    {
        $data = $request->validate([
            'lecturer_avatar' => ['required', 'mimes:jpeg,jpg,png,gif'],
            'lecturer_birthday' => ['required'],
            'lecturer_gender' => ['required'],
            'lecturer_ethnic' => ['max:50'],
            'lecturer_religion' => ['max:50'],
            'lecturer_phone' => ['required', 'max:11', 'min:10'],
            'lecturer_address' => ['required', 'max:255'],
            'lecturer_country' => ['required', 'max:50'],
            'lecturer_identify_card' => ['required', 'max:12', 'min:9'],
            'lecturer_birth_place' => ['required', 'max:100'],
            'lecturer_other_email' => ['email', 'max:250'],
        ], [
            'lecturer_avatar.required' => '???nh ?????i di???n kh??ng ???????c ????? tr???ng!',
            'lecturer_avatar.mimes' => 'T???p nh???p v??o ph???i c?? ??u??i jpeg,jpg,png,gif!',

            'lecturer_birthday.required' => 'Ng??y sinh kh??ng ???????c ????? tr???ng!',
            'lecturer_gender.required' => 'Gi???i t??nh kh??ng ???????c ????? tr???ng!',

            'lecturer_ethnic.max' => 'D??n t???c kh??ng nh???p qu?? 50 k?? t???!',
            'lecturer_religion.max' => 'T??n gi??o kh??ng nh???p qu?? 50 k?? t???!',

            'lecturer_phone.required' => 'S??? ??i???n tho???i kh??ng ???????c ????? tr???ng!',
            'lecturer_phone.max' => 'S??? ??i???n tho???i kh??ng nh???p qu?? 11 k?? t??? s???!',
            'lecturer_phone.min' => 'S??? ??i???n tho???i c???n nh???p 10 ho???c 11 s???!',

            'lecturer_address.required' => '?????a ch??? kh??ng ???????c ????? tr???ng!',
            'lecturer_address.max' => '?????a ch??? kh??ng nh???p qu?? 255 k?? t??? ch???!',

            'lecturer_country.required' => 'Qu???c gia kh??ng ???????c ????? tr???ng!',
            'lecturer_country.max' => 'Qu???c gia kh??ng nh???p qu?? 50 k?? t??? ch???!',

            'lecturer_identify_card.required' => 'CMND/CCCD kh??ng ???????c ????? tr???ng!',
            'lecturer_identify_card.max' => 'CMND/CCCD kh??ng nh???p qu?? 12 k?? t???!',
            'lecturer_identify_card.min' => 'CMND/CCCD ph???i c?? 9 k?? t??? tr??? l??n!',

            'lecturer_birth_place.required' => 'N??i sinh kh??ng ???????c ????? tr???ng!',
            'lecturer_birth_place.max' => 'N??i sinh kh??ng nh???p qu?? 100 k?? t??? ch???!',

            'lecturer_other_email.max' => 'Email kh??ng nh???p qu?? 250 k?? t???!',
            'lecturer_other_email.email' => 'Sai ?????nh d???ng email!',
        ]);

        $info = new LecturerInfo();
        $info->lecturer_id_ref = $request->lecturer_id_ref;
        $info->lecturer_birthday = $data['lecturer_birthday'];
        $info->lecturer_gender = $data['lecturer_gender'];
        $info->lecturer_ethnic = $data['lecturer_ethnic'];
        $info->lecturer_religion = $data['lecturer_religion'];
        $info->lecturer_phone = $data['lecturer_phone'];
        $info->lecturer_address = $data['lecturer_address'];
        $info->lecturer_country = $data['lecturer_country'];
        $info->lecturer_identify_card = $data['lecturer_identify_card'];
        $info->lecturer_birth_place = $data['lecturer_birth_place'];
        $info->lecturer_other_email = $data['lecturer_other_email'];
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $info->created_at = now();

        $image = $data['lecturer_avatar'];
        $name = $request->lecturer_id_ref . '_avatar.png';
        Storage::disk('publiclecturer')->put($name, File::get($image));
        $info->lecturer_avatar = $name;

        $info->save();
    }

    public function update_info_deanfaculty(Request $request, $info_id)
    {
        $data = $request->validate([
            'lecturer_avatar' => ['mimes:jpeg,jpg,png,gif'],
            'lecturer_birthday' => ['required'],
            'lecturer_gender' => ['required'],
            'lecturer_ethnic' => ['max:50'],
            'lecturer_religion' => ['max:50'],
            'lecturer_phone' => ['required', 'max:11', 'min:10'],
            'lecturer_address' => ['required', 'max:255'],
            'lecturer_country' => ['required', 'max:50'],
            'lecturer_identify_card' => ['required', 'max:12', 'min:9'],
            'lecturer_birth_place' => ['required', 'max:100'],
            'lecturer_other_email' => ['email', 'max:250'],
        ], [
            'lecturer_avatar.mimes' => 'T???p nh???p v??o ph???i c?? ??u??i jpeg,jpg,png,gif!',

            'lecturer_birthday.required' => 'Ng??y sinh kh??ng ???????c ????? tr???ng!',
            'lecturer_gender.required' => 'Gi???i t??nh kh??ng ???????c ????? tr???ng!',

            'lecturer_ethnic.max' => 'D??n t???c kh??ng nh???p qu?? 50 k?? t???!',
            'lecturer_religion.max' => 'T??n gi??o kh??ng nh???p qu?? 50 k?? t???!',

            'lecturer_phone.required' => 'S??? ??i???n tho???i kh??ng ???????c ????? tr???ng!',
            'lecturer_phone.max' => 'S??? ??i???n tho???i kh??ng nh???p qu?? 11 k?? t??? s???!',
            'lecturer_phone.min' => 'S??? ??i???n tho???i c???n nh???p 10 ho???c 11 s???!',

            'lecturer_address.required' => '?????a ch??? kh??ng ???????c ????? tr???ng!',
            'lecturer_address.max' => '?????a ch??? kh??ng nh???p qu?? 255 k?? t??? ch???!',

            'lecturer_country.required' => 'Qu???c gia kh??ng ???????c ????? tr???ng!',
            'lecturer_country.max' => 'Qu???c gia kh??ng nh???p qu?? 50 k?? t??? ch???!',

            'lecturer_identify_card.required' => 'CMND/CCCD kh??ng ???????c ????? tr???ng!',
            'lecturer_identify_card.max' => 'CMND/CCCD kh??ng nh???p qu?? 12 k?? t???!',
            'lecturer_identify_card.min' => 'CMND/CCCD ph???i c?? 9 k?? t??? tr??? l??n!',

            'lecturer_birth_place.required' => 'N??i sinh kh??ng ???????c ????? tr???ng!',
            'lecturer_birth_place.max' => 'N??i sinh kh??ng nh???p qu?? 100 k?? t??? ch???!',

            'lecturer_other_email.max' => 'Email kh??ng nh???p qu?? 250 k?? t???!',
            'lecturer_other_email.email' => 'Sai ?????nh d???ng email!',
        ]);

        $info = LecturerInfo::find($info_id);
        $info->lecturer_birthday = $data['lecturer_birthday'];
        $info->lecturer_gender = $data['lecturer_gender'];
        $info->lecturer_ethnic = $data['lecturer_ethnic'];
        $info->lecturer_religion = $data['lecturer_religion'];
        $info->lecturer_phone = $data['lecturer_phone'];
        $info->lecturer_address = $data['lecturer_address'];
        $info->lecturer_country = $data['lecturer_country'];
        $info->lecturer_identify_card = $data['lecturer_identify_card'];
        $info->lecturer_birth_place = $data['lecturer_birth_place'];
        $info->lecturer_other_email = $data['lecturer_other_email'];
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $info->updated_at = now();

        $image = $data['lecturer_avatar'];
        $name = $info->lecturer_id_ref . '_avatar_' . time() . '.png';
        Storage::disk('publiclecturer')->delete($info->lecturer_avatar);
        Storage::disk('publiclecturer')->put($name, File::get($image));
        $info->lecturer_avatar = $name;

        $info->save();
    }

    public function update_info_deanfaculty_noimg(Request $request, $info_id)
    {
        $data = $request->validate([
            'lecturer_birthday' => ['required'],
            'lecturer_gender' => ['required'],
            'lecturer_ethnic' => ['max:50'],
            'lecturer_religion' => ['max:50'],
            'lecturer_phone' => ['required', 'max:11', 'min:10'],
            'lecturer_address' => ['required', 'max:255'],
            'lecturer_country' => ['required', 'max:50'],
            'lecturer_identify_card' => ['required', 'max:12', 'min:9'],
            'lecturer_birth_place' => ['required', 'max:100'],
            'lecturer_other_email' => ['email', 'max:250'],
        ], [
            'lecturer_birthday.required' => 'Ng??y sinh kh??ng ???????c ????? tr???ng!',
            'lecturer_gender.required' => 'Gi???i t??nh kh??ng ???????c ????? tr???ng!',

            'lecturer_ethnic.max' => 'D??n t???c kh??ng nh???p qu?? 50 k?? t???!',
            'lecturer_religion.max' => 'T??n gi??o kh??ng nh???p qu?? 50 k?? t???!',

            'lecturer_phone.required' => 'S??? ??i???n tho???i kh??ng ???????c ????? tr???ng!',
            'lecturer_phone.max' => 'S??? ??i???n tho???i kh??ng nh???p qu?? 11 k?? t??? s???!',
            'lecturer_phone.min' => 'S??? ??i???n tho???i c???n nh???p 10 ho???c 11 s???!',

            'lecturer_address.required' => '?????a ch??? kh??ng ???????c ????? tr???ng!',
            'lecturer_address.max' => '?????a ch??? kh??ng nh???p qu?? 255 k?? t??? ch???!',

            'lecturer_country.required' => 'Qu???c gia kh??ng ???????c ????? tr???ng!',
            'lecturer_country.max' => 'Qu???c gia kh??ng nh???p qu?? 50 k?? t??? ch???!',

            'lecturer_identify_card.required' => 'CMND/CCCD kh??ng ???????c ????? tr???ng!',
            'lecturer_identify_card.max' => 'CMND/CCCD kh??ng nh???p qu?? 12 k?? t???!',
            'lecturer_identify_card.min' => 'CMND/CCCD ph???i c?? 9 k?? t??? tr??? l??n!',

            'lecturer_birth_place.required' => 'N??i sinh kh??ng ???????c ????? tr???ng!',
            'lecturer_birth_place.max' => 'N??i sinh kh??ng nh???p qu?? 100 k?? t??? ch???!',

            'lecturer_other_email.max' => 'Email kh??ng nh???p qu?? 250 k?? t???!',
            'lecturer_other_email.email' => 'Sai ?????nh d???ng email!',
        ]);

        $info = LecturerInfo::find($info_id);
        $info->lecturer_birthday = $data['lecturer_birthday'];
        $info->lecturer_gender = $data['lecturer_gender'];
        $info->lecturer_ethnic = $data['lecturer_ethnic'];
        $info->lecturer_religion = $data['lecturer_religion'];
        $info->lecturer_phone = $data['lecturer_phone'];
        $info->lecturer_address = $data['lecturer_address'];
        $info->lecturer_country = $data['lecturer_country'];
        $info->lecturer_identify_card = $data['lecturer_identify_card'];
        $info->lecturer_birth_place = $data['lecturer_birth_place'];
        $info->lecturer_other_email = $data['lecturer_other_email'];
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $info->updated_at = now();

        $info->save();
    }

    public function alllecturer()
    {
        return LecturerManageResource::collection(Lecturer::orderby('lecturer_id', 'DESC')->get());
    }
}
