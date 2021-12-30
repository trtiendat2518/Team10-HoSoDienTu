<template>
    <div>
        <vue-snotify></vue-snotify>
        <div class="page-header">
            <ol class="breadcrumb">
                <!-- breadcrumb -->
                <li class="breadcrumb-item">
                    <router-link tag="a" :to="{ name: 'dashboard' }">
                        Dashboard
                    </router-link>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Chương trình đào tạo
                </li>
            </ol>
            <!-- End breadcrumb -->
        </div>

        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="col-md-6">
                            <h3 class="card-title">Chương trình đào tạo</h3>
                        </div>
                        <div class="col-md-6">
                            <select>
                                <option value=""> </option>
                            </select>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table
                            class="table card-table table-vcenter text-nowrap table-nowrap"
                        >
                            <thead class="blue-background text-white">
                                <tr>
                                    <th class="w-5" scope="col" rowspan="2">
                                        STT
                                    </th>
                                    <th
                                        class="text-center w-10"
                                        scope="col"
                                        rowspan="2"
                                    >
                                        Mã môn học
                                    </th>
                                    <th
                                        class="text-center w-15"
                                        scope="col"
                                        rowspan="2"
                                    >
                                        Tên môn học
                                    </th>
                                    <th
                                        class="text-center w-5"
                                        scope="col"
                                        rowspan="2"
                                    >
                                        Số tín chỉ
                                    </th>
                                    <th
                                        class="text-center"
                                        scope="col"
                                        colspan="2"
                                    >
                                        Số tiết (giờ)
                                    </th>
                                    <th
                                        class="text-center"
                                        scope="col"
                                        colspan="3"
                                    >
                                        Trọng số (%)
                                    </th>
                                    <th
                                        class="text-center w-5"
                                        scope="col"
                                        rowspan="2"
                                    >
                                        Bắt buộc
                                    </th>
                                    <th
                                        class="text-center w-10"
                                        scope="col"
                                        rowspan="2"
                                    >
                                        Khoa/Bộ môn
                                    </th>
                                    <th
                                        class="text-center w-5"
                                        scope="col"
                                        rowspan="2"
                                    >
                                        Học kỳ
                                    </th>
                                    <th
                                        class="text-center w-10"
                                        scope="col"
                                        rowspan="2"
                                    >
                                        Ghi chú
                                    </th>
                                </tr>
                                <tr>
                                    <th class="text-center w-5" scope="col">
                                        Lý thuyết
                                    </th>
                                    <th class="text-center w-5" scope="col">
                                        Thực hành
                                    </th>
                                    <th class="text-center w-5" scope="col">
                                        Bài tập
                                    </th>
                                    <th class="text-center w-5" scope="col">
                                        Kiểm tra
                                    </th>
                                    <th class="text-center w-5" scope="col">
                                        Cuối kỳ
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-show="programs.length"
                                    v-for="(edu, index) in programs"
                                    :key="edu.subject_id"
                                >
                                    <td class="td-table">{{ (index += 1) }}</td>
                                    <td class="text-center td-table">
                                        {{ edu.subject_code }}
                                    </td>
                                    <td class="text-center td-table">
                                        {{ edu.subject_name }}
                                    </td>
                                    <td class="text-center td-table">
                                        {{ edu.subject_credit }}
                                    </td>
                                    <td class="text-center td-table">
                                        {{ edu.subject_theory_period }}
                                    </td>
                                    <td class="text-center td-table">
                                        {{ edu.subject_practice_period }}
                                    </td>
                                    <td class="text-center td-table">
                                        {{ edu.subject_score_exercise }}
                                    </td>
                                    <td class="text-center td-table">
                                        {{ edu.subject_score_exam }}
                                    </td>
                                    <td class="text-center td-table">
                                        {{ edu.subject_score_final }}
                                    </td>
                                    <td class="text-center td-table">
                                        <p v-if="edu.subject_type == 0">x</p>
                                        <p v-else></p>
                                    </td>
                                    <td class="text-center td-table">
                                        {{ edu.faculty_name }}
                                    </td>
                                    <td class="text-center td-table">
                                        {{ edu.program_detail_semester }}
                                    </td>
                                    <td class="text-center td-table">
                                        {{ nameMajor(edu) }}
                                    </td>
                                </tr>
                                <tr v-show="!programs.length">
                                    <td colspan="8">
                                        <div class="alert alert-danger">
                                            Không tìm thấy kết quả phù hợp!
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- table-responsive -->
                </div>
            </div>
            <!-- col end -->
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            programs: [],
            majors: [],
            lecturer_id: this.$teacherId
        };
    },
    mounted() {
        this.fetchPrograms();
        this.fetchMajors();
    },
    watch: {},
    methods: {
        fetchPrograms(teacher, page_url) {
            teacher = this.lecturer_id;
            let vm = this;
            page_url = `../../api/admin/edu-program-sv/chuong-trinh-dao-tao-sinh-vien/${teacher}`;
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.programs = res.data;
                    //let a = res.data.find(e => e.subject_type == 0);
                    let rqr = res.data.map(dt => {
                        res.data.find(e => e.subject_type == 0);
                    });
                    console.log(rqr);
                })
                .catch(err => console.log(err));
        },
        fetchMajors(page_url) {
            let vm = this;
            page_url = "../../api/admin/edu-major/chuyen-nganh/major";
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.majors = res.data;
                })
                .catch(err => console.log(err));
        },
        nameMajor(edu) {
            if (edu.program_detail_note != null) {
                const major = this.majors.find(
                    mjr => mjr.major_code === edu.program_detail_note
                );
                return major.major_name;
            } else {
                return "";
            }
        }
    }
};
</script>

<style></style>
