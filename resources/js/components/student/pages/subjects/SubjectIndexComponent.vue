<template>
    <div class="container">
        <div class="section-banner">
            <img class="section-banner-icon" :src="`../public/student/img/banner/newsfeed-icon.png`" alt="newsfeed-icon" />
            <p class="section-banner-title">Đăng ký môn học HK{{ semester }}</p>
        </div>

        <div class="grid" v-show="register_main == true">
            <div class="widget-box">
                <div class="form-group">
                    <input type="radio" value="1" v-model="select_radio" /> Đúng kế hoạch
                    <input type="radio" value="2" class="ml-2" v-model="select_radio" /> Theo CTĐT
                    <input type="radio" value="3" class="ml-2" v-model="select_radio" /> Ngoài kế hoạch
                </div>

                <div v-show="select_radio == 1" class="table-responsive">
                    <div v-if="subject_inplan.length > 0">
                        <table class="table table-nowrap">
                            <thead class="blue-background text-white">
                                <tr>
                                    <th class="text-center w-5" scope="col" rowspan="2">
                                        STT
                                    </th>
                                    <th class="text-center w-15" scope="col" rowspan="2">
                                        Mã môn học
                                    </th>
                                    <th class="text-center w-50" scope="col" rowspan="2">
                                        Tên môn học
                                    </th>
                                    <th class="text-center w-10" scope="col" rowspan="2">
                                        Số TC
                                    </th>
                                    <th class="text-center w-10" scope="col" rowspan="2">
                                        SL lớp
                                    </th>
                                    <th class="w-10 text-center"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(value, index) in subject_inplan" :key="value.subject_id">
                                    <td class="td-table text-center">
                                        {{ (index += 1) }}
                                    </td>
                                    <td class="text-center td-table">
                                        {{ value.subject_code }}
                                    </td>
                                    <td class="td-table">
                                        {{ value.subject_name }}
                                    </td>
                                    <td class="text-center td-table">
                                        {{ value.subject_credit }}
                                    </td>
                                    <td class="text-center">
                                        {{ countSubject(value) }}
                                    </td>
                                    <td class="text-center">
                                        <router-link
                                            class="btn btn-block btn-primary"
                                            tag="button"
                                            :to="{ name: 'subjectregistering', params: { idRSubject: value.subject_id } }"
                                        >
                                            Đăng ký
                                        </router-link>
                                    </td>
                                </tr>
                                <tr v-show="!subject_inplan.length">
                                    <td colspan="9">
                                        <div class="alert alert-danger">
                                            Không tìm thấy kết quả phù hợp!
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div v-else>
                        <div class="alert alert-danger">
                            Không tìm thấy kết quả phù hợp!
                        </div>
                    </div>
                </div>

                <div v-show="select_radio == 2" class="table-responsive">
                    <div v-if="subject_program.length > 0">
                        <table class="table table-nowrap">
                            <thead class="blue-background text-white">
                                <tr>
                                    <th class="text-center w-5" scope="col" rowspan="2">
                                        STT
                                    </th>
                                    <th class="text-center w-15" scope="col" rowspan="2">
                                        Mã môn học
                                    </th>
                                    <th class="text-center w-50" scope="col" rowspan="2">
                                        Tên môn học
                                    </th>
                                    <th class="text-center w-10" scope="col" rowspan="2">
                                        Số TC
                                    </th>
                                    <th class="text-center w-10" scope="col" rowspan="2">
                                        SL lớp
                                    </th>
                                    <th class="w-10 text-center"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(value, index) in subject_program" :key="value.subject_id">
                                    <td class="td-table text-center">
                                        {{ (index += 1) }}
                                    </td>
                                    <td class="text-center td-table">
                                        {{ value.subject_code }}
                                    </td>
                                    <td class="td-table">
                                        {{ value.subject_name }}
                                    </td>
                                    <td class="text-center td-table">
                                        {{ value.subject_credit }}
                                    </td>
                                    <td class="text-center">
                                        {{ countSubject(value) }}
                                    </td>
                                    <td class="text-center">
                                        <router-link
                                            class="btn btn-block btn-primary"
                                            tag="button"
                                            :to="{ name: 'subjectregistering', params: { idRSubject: value.subject_id } }"
                                        >
                                            Đăng ký
                                        </router-link>
                                    </td>
                                </tr>
                                <tr v-show="!subject_program.length">
                                    <td colspan="9">
                                        <div class="alert alert-danger">
                                            Không tìm thấy kết quả phù hợp!
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div v-else>
                        <div class="alert alert-danger">
                            Không tìm thấy kết quả phù hợp!
                        </div>
                    </div>
                </div>

                <div v-show="select_radio == 3" class="table-responsive">
                    <div v-if="subject_outplan.length > 0">
                        <table class="table table-nowrap">
                            <thead class="blue-background text-white">
                                <tr>
                                    <th class="text-center w-5" scope="col" rowspan="2">
                                        STT
                                    </th>
                                    <th class="text-center w-15" scope="col" rowspan="2">
                                        Mã môn học
                                    </th>
                                    <th class="text-center w-50" scope="col" rowspan="2">
                                        Tên môn học
                                    </th>
                                    <th class="text-center w-10" scope="col" rowspan="2">
                                        Số TC
                                    </th>
                                    <th class="text-center w-10" scope="col" rowspan="2">
                                        SL lớp
                                    </th>
                                    <th class="w-10 text-center"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(value, index) in subject_outplan" :key="value.subject_id">
                                    <td class="td-table text-center">
                                        {{ (index += 1) }}
                                    </td>
                                    <td class="text-center td-table">
                                        {{ value.subject_code }}
                                    </td>
                                    <td class="td-table">
                                        {{ value.subject_name }}
                                    </td>
                                    <td class="text-center td-table">
                                        {{ value.subject_credit }}
                                    </td>
                                    <td class="text-center">
                                        {{ countSubject(value) }}
                                    </td>
                                    <td class="text-center">
                                        <router-link
                                            class="btn btn-block btn-primary"
                                            tag="button"
                                            :to="{ name: 'subjectregistering', params: { idRSubject: value.subject_id } }"
                                        >
                                            Đăng ký
                                        </router-link>
                                    </td>
                                </tr>
                                <tr v-show="!subject_outplan.length">
                                    <td colspan="9">
                                        <div class="alert alert-danger">
                                            Không tìm thấy kết quả phù hợp!
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div v-else>
                        <div class="alert alert-danger">
                            Không tìm thấy kết quả phù hợp!
                        </div>
                    </div>
                </div>

                <div class="card mt-5">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-7">
                                <h4 class="text-center">
                                    Kết quả đăng ký: <i>{{ result_subject }} môn học</i>, <i>{{ result_credit }} tín chỉ</i>
                                </h4>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-lg btn-primary float-right" @click="print()">In PDF</button>
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-lg btn-info float-right" @click="sendMail()">Nhận Email</button>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-1"><input type="color" class="mt-2 float-right" value="#a52a2a" disabled /></div>
                        <div class="col-md-11 mt-2">: Môn học bị huỷ (Không còn mở)</div>
                    </div>

                    <div class="row">
                        <div class="col-md-1"><input type="color" class="mt-2 float-right" value="#e4b117" disabled /></div>
                        <div class="col-md-11 mt-2">: Môn học bị trùng thời gian học</div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <div v-if="result_all.length > 0">
                                <table class="table table-nowrap">
                                    <thead class="result-background text-white">
                                        <tr>
                                            <th class="text-center w10">
                                                Loại
                                            </th>
                                            <th class="text-center w10">
                                                Mã môn học
                                            </th>
                                            <th class="text-center w25">
                                                Tên môn học
                                            </th>
                                            <th class="text-center w5">
                                                TC
                                            </th>
                                            <th class="text-center w10">
                                                Lịch học
                                            </th>
                                            <th class="text-center w10">
                                                Ngày BĐ
                                            </th>
                                            <th class="text-center w10">
                                                Ngày KT
                                            </th>
                                            <th class="w10"></th>
                                            <th class="w10"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr
                                            v-for="value in result_all"
                                            :key="value.calendar_subject_id"
                                            :class="[
                                                { 'background-cancel': value.calendar_subject_status == 1 },
                                                { 'background-warning': checkTime(value) > 1 }
                                            ]"
                                        >
                                            <td class="text-center td-table">
                                                <div v-if="value.calendar_subject_type == 0">Lý thuyết</div>
                                                <div v-else-if="value.calendar_subject_type == 1">Thực hành</div>
                                            </td>
                                            <td class="td-table">
                                                {{ value.subject_code }}
                                            </td>
                                            <td class="text-center td-table">
                                                {{ value.subject_name }}
                                            </td>
                                            <td class="text-center">
                                                {{ value.subject_credit }}
                                            </td>
                                            <td class="text-center">
                                                {{ valueCurrent(value.calendar_subject_day, value.calendar_subject_time) }}
                                            </td>
                                            <td class="text-center">
                                                {{ value.calendar_subject_start | formatDate }}
                                            </td>
                                            <td class="text-center">
                                                {{ value.calendar_subject_end | formatDate }}
                                            </td>
                                            <td>
                                                <button class="btn btn-block btn-primary" @click="changeMode(value)">
                                                    Xem thêm
                                                </button>
                                            </td>
                                            <td class="text-center">
                                                <button class="btn btn-block btn-danger" @click="cancel(value)">
                                                    Huỷ bỏ
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div v-else>
                                <div class="alert alert-danger">
                                    Không tìm thấy kết quả phù hợp!
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <VueHtml2pdf
                :manual-pagination="true"
                :enable-download="true"
                ref="DownloadComp"
                :filename="'ket-qua-dang-ky-mon-hoc-' + student_info.student_code"
                pdf-format="a3"
                pdf-content-width="100%"
                hidden
            >
                <section slot="pdf-content">
                    <div class="center-style">
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <h6 class="text-center text-black">BỘ GIÁO DỤC VÀ ĐÀO TẠO</h6>
                                <h6 class="text-center text-black">TRƯỜNG ĐẠI HỌC VĂN LANG</h6>
                                <img :src="`../public/student/img/vlu.png`" alt="vlu" class="img-style" />
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-center text-black">CỘNG HOÀ XÃ HỘI CHỦ NGHĨA VIỆT NAM</h6>
                                <h6 class="text-center text-black">Độc lập - Tự do - Hạnh phúc</h6>
                            </div>
                        </div>
                        <h3 class="text-center mt-3">KẾT QUẢ ĐĂNG KÝ KẾ HOẠCH HỌC TẬP</h3>
                        <h6 class="text-center mt-3">Năm học: HK{{ semester }}</h6>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                Họ tên: <b>{{ student_info.student_fullname }}</b>
                            </div>
                            <div class="col-md-6">MSSV: {{ student_info.student_code }}</div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">Khoa: {{ student_info.student_faculty }}</div>
                            <div class="col-md-6">Khoá học: {{ student_info.student_course }}</div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">Chuyên ngành: {{ student_info.student_major }}</div>
                            <div class="col-md-6">Lớp: {{ student_info.student_course_code }}-{{ student_info.student_class }}</div>
                        </div>

                        <div class="card mt-5">
                            <div class="card-header">
                                <h4 class="text-center">
                                    Kết quả đăng ký: <i>{{ result_subject }} môn học</i>, <i>{{ result_credit }} tín chỉ</i>
                                </h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <div v-if="result_all.length > 0">
                                        <table class="table table-nowrap">
                                            <thead class="result-background text-white">
                                                <tr>
                                                    <th class="text-center w10">
                                                        Loại
                                                    </th>
                                                    <th class="text-center w10">
                                                        Mã môn học
                                                    </th>
                                                    <th class="text-center w40">
                                                        Tên môn học
                                                    </th>
                                                    <th class="text-center w5">
                                                        TC
                                                    </th>
                                                    <th class="text-center w15">
                                                        Lịch học
                                                    </th>
                                                    <th class="text-center w10">
                                                        Ngày BĐ
                                                    </th>
                                                    <th class="text-center w10">
                                                        Ngày KT
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="value in result_all" :key="value.calendar_subject_id">
                                                    <td class="text-center td-table">
                                                        <div v-if="value.calendar_subject_type == 0">Lý thuyết</div>
                                                        <div v-else-if="value.calendar_subject_type == 1">Thực hành</div>
                                                    </td>
                                                    <td class="td-table">
                                                        {{ value.subject_code }}
                                                    </td>
                                                    <td class="text-center td-table">
                                                        {{ value.subject_name }}
                                                    </td>
                                                    <td class="text-center">
                                                        {{ value.subject_credit }}
                                                    </td>
                                                    <td class="text-center">
                                                        {{ valueCurrent(value.calendar_subject_day, value.calendar_subject_time) }}
                                                    </td>
                                                    <td class="text-center">
                                                        {{ value.calendar_subject_start | formatDate }}
                                                    </td>
                                                    <td class="text-center">
                                                        {{ value.calendar_subject_end | formatDate }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div v-else>
                                        <div class="alert alert-danger">
                                            Không tìm thấy kết quả phù hợp!
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6">
                                Ngày in: <i>{{ print_date }}</i>
                            </div>
                            <div class="col-md-6 text-right">
                                Tổng số TC đăng ký: <i>{{ result_credit }}</i>
                            </div>
                        </div>
                    </div>
                </section>
            </VueHtml2pdf>
        </div>

        <div class="grid" v-show="register_again == true">
            <div class="widget-box">
                <div class="table-responsive">
                    <div v-if="subject_inplan.length > 0">
                        <table class="table table-nowrap">
                            <thead class="blue-background text-white">
                                <tr>
                                    <th class="text-center w-5" scope="col" rowspan="2">
                                        STT
                                    </th>
                                    <th class="text-center w-15" scope="col" rowspan="2">
                                        Mã môn học
                                    </th>
                                    <th class="text-center w-50" scope="col" rowspan="2">
                                        Tên môn học
                                    </th>
                                    <th class="text-center w-10" scope="col" rowspan="2">
                                        Số TC
                                    </th>
                                    <th class="text-center w-10" scope="col" rowspan="2">
                                        SL lớp
                                    </th>
                                    <th class="w-10 text-center"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(value, index) in subject_inplan" :key="value.subject_id">
                                    <td class="td-table text-center">
                                        {{ (index += 1) }}
                                    </td>
                                    <td class="text-center td-table">
                                        {{ value.subject_code }}
                                    </td>
                                    <td class="td-table">
                                        {{ value.subject_name }}
                                    </td>
                                    <td class="text-center td-table">
                                        {{ value.subject_credit }}
                                    </td>
                                    <td class="text-center">
                                        {{ countSubject(value) }}
                                    </td>
                                    <td class="text-center">
                                        <router-link
                                            class="btn btn-block btn-primary"
                                            tag="button"
                                            :to="{ name: 'subjectregistering', params: { idRSubject: value.subject_id } }"
                                        >
                                            Đăng ký
                                        </router-link>
                                    </td>
                                </tr>
                                <tr v-show="!subject_inplan.length">
                                    <td colspan="9">
                                        <div class="alert alert-danger">
                                            Không tìm thấy kết quả phù hợp!
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div v-else>
                        <div class="alert alert-danger">
                            Không tìm thấy kết quả phù hợp!
                        </div>
                    </div>
                </div>

                <div class="card mt-5">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-7">
                                <h4 class="text-center">
                                    Kết quả đăng ký: <i>{{ result_subject }} môn học</i>, <i>{{ result_credit }} tín chỉ</i>
                                </h4>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-lg btn-primary float-right" @click="print()">In PDF</button>
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-lg btn-info float-right" @click="sendMail()">Nhận Email</button>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-1"><input type="color" class="mt-2 float-right" value="#a52a2a" disabled /></div>
                        <div class="col-md-11 mt-2">: Môn học bị huỷ (Không còn mở)</div>
                    </div>

                    <div class="row">
                        <div class="col-md-1"><input type="color" class="mt-2 float-right" value="#e4b117" disabled /></div>
                        <div class="col-md-11 mt-2">: Môn học bị trùng thời gian học</div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <div v-if="result_all.length > 0">
                                <table class="table table-nowrap">
                                    <thead class="result-background text-white">
                                        <tr>
                                            <th class="text-center w10">
                                                Loại
                                            </th>
                                            <th class="text-center w10">
                                                Mã môn học
                                            </th>
                                            <th class="text-center w25">
                                                Tên môn học
                                            </th>
                                            <th class="text-center w5">
                                                TC
                                            </th>
                                            <th class="text-center w10">
                                                Lịch học
                                            </th>
                                            <th class="text-center w10">
                                                Ngày BĐ
                                            </th>
                                            <th class="text-center w10">
                                                Ngày KT
                                            </th>
                                            <th class="w10"></th>
                                            <th class="w10"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr
                                            v-for="value in result_all"
                                            :key="value.calendar_subject_id"
                                            :class="[
                                                { 'background-cancel': value.calendar_subject_status == 1 },
                                                { 'background-warning': checkTime(value) > 1 }
                                            ]"
                                        >
                                            <td class="text-center td-table">
                                                <div v-if="value.calendar_subject_type == 0">Lý thuyết</div>
                                                <div v-else-if="value.calendar_subject_type == 1">Thực hành</div>
                                            </td>
                                            <td class="td-table">
                                                {{ value.subject_code }}
                                            </td>
                                            <td class="text-center td-table">
                                                {{ value.subject_name }}
                                            </td>
                                            <td class="text-center">
                                                {{ value.subject_credit }}
                                            </td>
                                            <td class="text-center">
                                                {{ valueCurrent(value.calendar_subject_day, value.calendar_subject_time) }}
                                            </td>
                                            <td class="text-center">
                                                {{ value.calendar_subject_start | formatDate }}
                                            </td>
                                            <td class="text-center">
                                                {{ value.calendar_subject_end | formatDate }}
                                            </td>
                                            <td>
                                                <button class="btn btn-block btn-primary" @click="changeMode(value)">
                                                    Xem thêm
                                                </button>
                                            </td>
                                            <td class="text-center">
                                                <button class="btn btn-block btn-danger" @click="cancel(value)">
                                                    Huỷ bỏ
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div v-else>
                                <div class="alert alert-danger">
                                    Không tìm thấy kết quả phù hợp!
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <VueHtml2pdf
                :manual-pagination="true"
                :enable-download="true"
                ref="DownloadComp"
                :filename="'ket-qua-dang-ky-mon-hoc-' + student_info.student_code"
                pdf-format="a3"
                pdf-content-width="100%"
                hidden
            >
                <section slot="pdf-content">
                    <div class="center-style">
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <h6 class="text-center text-black">BỘ GIÁO DỤC VÀ ĐÀO TẠO</h6>
                                <h6 class="text-center text-black">TRƯỜNG ĐẠI HỌC VĂN LANG</h6>
                                <img :src="`../public/student/img/vlu.png`" alt="vlu" class="img-style" />
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-center text-black">CỘNG HOÀ XÃ HỘI CHỦ NGHĨA VIỆT NAM</h6>
                                <h6 class="text-center text-black">Độc lập - Tự do - Hạnh phúc</h6>
                            </div>
                        </div>
                        <h3 class="text-center mt-3">KẾT QUẢ ĐĂNG KÝ KẾ HOẠCH HỌC TẬP</h3>
                        <h6 class="text-center mt-3">Năm học: HK{{ semester }}</h6>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                Họ tên: <b>{{ student_info.student_fullname }}</b>
                            </div>
                            <div class="col-md-6">MSSV: {{ student_info.student_code }}</div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">Khoa: {{ student_info.student_faculty }}</div>
                            <div class="col-md-6">Khoá học: {{ student_info.student_course }}</div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">Chuyên ngành: {{ student_info.student_major }}</div>
                            <div class="col-md-6">Lớp: {{ student_info.student_course_code }}-{{ student_info.student_class }}</div>
                        </div>

                        <div class="card mt-5">
                            <div class="card-header">
                                <h4 class="text-center">
                                    Kết quả đăng ký: <i>{{ result_subject }} môn học</i>, <i>{{ result_credit }} tín chỉ</i>
                                </h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <div v-if="result_all.length > 0">
                                        <table class="table table-nowrap">
                                            <thead class="result-background text-white">
                                                <tr>
                                                    <th class="text-center w10">
                                                        Loại
                                                    </th>
                                                    <th class="text-center w10">
                                                        Mã môn học
                                                    </th>
                                                    <th class="text-center w40">
                                                        Tên môn học
                                                    </th>
                                                    <th class="text-center w5">
                                                        TC
                                                    </th>
                                                    <th class="text-center w15">
                                                        Lịch học
                                                    </th>
                                                    <th class="text-center w10">
                                                        Ngày BĐ
                                                    </th>
                                                    <th class="text-center w10">
                                                        Ngày KT
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="value in result_all" :key="value.calendar_subject_id">
                                                    <td class="text-center td-table">
                                                        <div v-if="value.calendar_subject_type == 0">Lý thuyết</div>
                                                        <div v-else-if="value.calendar_subject_type == 1">Thực hành</div>
                                                    </td>
                                                    <td class="td-table">
                                                        {{ value.subject_code }}
                                                    </td>
                                                    <td class="text-center td-table">
                                                        {{ value.subject_name }}
                                                    </td>
                                                    <td class="text-center">
                                                        {{ value.subject_credit }}
                                                    </td>
                                                    <td class="text-center">
                                                        {{ valueCurrent(value.calendar_subject_day, value.calendar_subject_time) }}
                                                    </td>
                                                    <td class="text-center">
                                                        {{ value.calendar_subject_start | formatDate }}
                                                    </td>
                                                    <td class="text-center">
                                                        {{ value.calendar_subject_end | formatDate }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div v-else>
                                        <div class="alert alert-danger">
                                            Không tìm thấy kết quả phù hợp!
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6">
                                Ngày in: <i>{{ print_date }}</i>
                            </div>
                            <div class="col-md-6 text-right">
                                Tổng số TC đăng ký: <i>{{ result_credit }}</i>
                            </div>
                        </div>
                    </div>
                </section>
            </VueHtml2pdf>
        </div>
    </div>
</template>

<script>
import VueHtml2pdf from 'vue-html2pdf'
export default {
    components: {
        VueHtml2pdf
    },
    data() {
        return {
            student_id: this.$studentId,
            select_radio: 1,
            subjects: [],
            registers: [],
            subject_program: [],
            subject_inplan: [],
            subject_outplan: [],
            quantities: [],
            result_all: [],
            result_credit: 0,
            result_subject: 0,
            semester: '',
            print_date: '',
            student_info: {
                student_fullname: '',
                student_code: '',
                student_class: '',
                student_course: '',
                student_course_code: '',
                student_major: '',
                student_faculty: ''
            },
            register_main: false,
            register_again: false,
            calendar_id: ''
        }
    },
    mounted() {
        this.fetchCalendarRegister()
        this.fetchRegisterAgain()
    },
    watch: {
        select_radio(value) {
            if (value == 2) {
                this.fetchSubjectProgram()
            } else if (value == 3) {
                this.fetchSubjectOutplan()
            }
        },
        semester(value) {
            if (value != '') {
                this.fetchSubjectInplan()
                this.subjectQuantity()
                this.fetchResultAll()
            }
        }
    },
    methods: {
        fetchCalendarRegister(page_url) {
            page_url = `../../api/student/subject-register/dang-ky-mon-hoc/thoi-gian-dang-ky/${this.student_id}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    const today = new Date()
                    let register = res.data.filter(el => {
                        const start = new Date(el.start)
                        const end = new Date(el.end)
                        if (today >= start && today <= end) {
                            this.register_main = true
                            return el
                        }
                    })
                    this.registers = register
                    this.semester = register[0].location
                })
                .catch(err => console.log(err))
        },
        fetchRegisterAgain(page_url) {
            page_url = `../../api/student/subject-register/dang-ky-mon-hoc/learn-again/${this.student_id}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    const today = new Date()
                    let register = res.data.filter(el => {
                        const start = new Date(el.start)
                        const end = new Date(el.end)
                        if (today >= start && today <= end) {
                            this.register_again = true
                            return el
                        }
                    })
                    this.registers = register
                    this.calendar_id = register[0].id
                    this.fetchSemesterAgain()
                })
                .catch(err => console.log(err))
        },
        fetchSemesterAgain(page_url) {
            page_url = `../../api/student/study-plan/dang-ky-ke-hoach-hoc-tap/subject-again-1/${this.student_id}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.semester = res.data[0].register_plan_semester
                })
                .catch(err => console.log(err))
        },
        fetchSubjectProgram(page_url) {
            page_url = `../../api/student/subject-register/dang-ky-mon-hoc/theo-ctdt/${this.student_id}/${this.semester}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.subject_program = res.data
                })
                .catch(err => console.log(err))
        },
        fetchSubjectInplan(page_url) {
            if (this.register_main == true) {
                page_url = `../../api/student/subject-register/dang-ky-mon-hoc/theo-ke-hoach/${this.student_id}/${this.semester}`
                fetch(page_url)
                    .then(res => res.json())
                    .then(res => {
                        this.subject_inplan = res.data
                        this.student_info.student_fullname = res.data[0].student_fullname
                        this.student_info.student_code = res.data[0].student_code
                        this.student_info.student_course = res.data[0].course_name
                        this.student_info.student_course_code = res.data[0].course_code
                        this.student_info.student_faculty = res.data[0].faculty_name
                        this.student_info.student_major = res.data[0].major_name
                        this.student_info.student_class = res.data[0].class_name
                    })
                    .catch(err => console.log(err))
            } else if (this.register_again == true) {
                page_url = `../../api/student/subject-register/dang-ky-mon-hoc/theo-ke-hoach-hoc-lai/${this.student_id}/${this.semester}`
                fetch(page_url)
                    .then(res => res.json())
                    .then(res => {
                        this.subject_inplan = res.data
                        this.student_info.student_fullname = res.data[0].student_fullname
                        this.student_info.student_code = res.data[0].student_code
                        this.student_info.student_course = res.data[0].course_name
                        this.student_info.student_course_code = res.data[0].course_code
                        this.student_info.student_faculty = res.data[0].faculty_name
                        this.student_info.student_major = res.data[0].major_name
                        this.student_info.student_class = res.data[0].class_name
                    })
                    .catch(err => console.log(err))
            }
        },
        fetchSubjectOutplan(page_url) {
            page_url = `../../api/student/subject-register/dang-ky-mon-hoc/ngoai-ke-hoach/${this.student_id}/${this.semester}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.subject_outplan = res.data
                })
                .catch(err => console.log(err))
        },
        fetchResultAll(page_url) {
            if (this.register_main == true) {
                page_url = `../../api/student/subject-register/dang-ky-mon-hoc/ket-qua-dk-tat-ca/${this.student_id}/${this.semester}`
                fetch(page_url)
                    .then(res => res.json())
                    .then(res => {
                        this.result_all = res.data
                        this.result_subject = res.data.length
                        this.result_credit = 0
                        for (let i = 0; i < res.data.length; i++) {
                            this.result_credit = res.data[i].subject_credit + this.result_credit
                        }
                    })
                    .catch(err => console.log(err))
            } else if (this.register_again == true) {
            }
        },
        subjectQuantity(page_url) {
            if (this.register_main == true) {
                page_url = `../../api/student/subject-register/dang-ky-mon-hoc/so-luong-lop-mon-hoc/${this.student_id}/${this.semester}`
                fetch(page_url)
                    .then(res => res.json())
                    .then(res => {
                        this.quantities = res.data
                    })
                    .catch(err => console.log(err))
            } else if (this.register_again == true) {
                page_url = `../../api/student/subject-register/dang-ky-mon-hoc/so-luong-lop-mon-hoc-hoc-lai/${this.student_id}/${this.calendar_id}`
                fetch(page_url)
                    .then(res => res.json())
                    .then(res => {
                        this.quantities = res.data
                    })
                    .catch(err => console.log(err))
            }
        },
        countSubject(value) {
            let number = this.quantities.filter(qtt => qtt.subject_id == value.subject_id)
            return number.length
        },
        cancel(value) {
            this.$swal({
                title: 'Bạn có chắc chắn huỷ môn ' + value.subject_name + '?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Huỷ !',
                cancelButtonText: 'Quay lại !'
            }).then(result => {
                if (result.isConfirmed) {
                    axios
                        .post(
                            `../../api/student/subject-register/dang-ky-mon-hoc/huy-mon-hoc/${value.calendar_subject_id}/${value.register_subject_id}`
                        )
                        .then(res => {
                            this.fetchSubjectProgram()
                            this.fetchSubjectInplan()
                            this.fetchSubjectOutplan()
                            this.fetchResultAll()
                            this.$swal('Đã huỷ!', 'Huỷ môn học thành công', 'success')
                        })
                        .catch(err => console.log(err))
                }
            })
        },
        changeMode(value) {
            this.$router.push({ name: 'subjectregistering', params: { idRSubject: value.subject_id } })
        },
        print() {
            const date = new Date()
            const day = date.getDate()
            const month = date.getMonth() + 1
            const year = date.getFullYear()
            this.print_date = 'Ngày ' + day + ' tháng ' + month + ' năm ' + year
            this.$refs.DownloadComp.generatePdf()
        },
        sendMail() {
            this.$swal({
                icon: 'info',
                title: 'Thông báo!',
                text: 'Email sẽ được gửi ngay hoặc vài phút sau cho bạn.',
                timer: 2000
            })
            axios.get(`../../api/student/subject-register/dang-ky-mon-hoc/send-mail/${this.student_id}/${this.semester}`).catch(err => {
                console.log(err)
            })
        },
        checkTime(value) {
            let lengthSubject = this.result_all.filter(el => {
                if (el.calendar_subject_time == value.calendar_subject_time && el.calendar_subject_day == value.calendar_subject_day) {
                    return el
                }
            })
            return lengthSubject.length
        },
        valueCurrent(calendar_subject_day, calendar_subject_time) {
            const day = calendar_subject_day.split(', ')
            const time = calendar_subject_time.split(', ')
            let arrayDay = []
            let arrayTime = []
            let stringDay = ''
            let stringTime = ''
            let allStringDay = ''
            let allStringTime = ''

            if (day.length > 0) {
                for (let i = 0; i < day.length; i++) {
                    if (day[i] == 0) {
                        stringDay = 'Chủ nhật'
                    } else {
                        let key = Number(day[i]) + 1
                        stringDay = 'Thứ ' + key
                    }
                    arrayDay.push(stringDay)
                }
                allStringDay = arrayDay.join(', ')
            }

            if (time.length > 0) {
                for (let i = 0; i < time.length; i++) {
                    if (time[i] == 123) {
                        stringTime = 'Tiết 1-2-3'
                    } else if (time[i] == 456) {
                        stringTime = 'Tiết 4-5-6'
                    } else if (time[i] == 789) {
                        stringTime = 'Tiết 7-8-9'
                    } else if (time[i] == 101112) {
                        stringTime = 'Tiết 10-11-12'
                    } else if (time[i] == 131415) {
                        stringTime = 'Tiết 13-14-15'
                    }
                    arrayTime.push(stringTime)
                }
                allStringTime = arrayTime.join(', ')
            }
            return allStringDay + ' (' + allStringTime + ')'
        }
    }
}
</script>

<style scoped>
.text-center {
    border: none;
}
.background-cancel {
    background-color: #a52a2a;
    color: white;
}
.background-warning {
    background-color: #e4b117;
    color: white;
}
</style>
