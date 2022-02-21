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
                <li class="breadcrumb-item">
                    <router-link tag="a" :to="{ name: 'studyplansuggestindex' }">
                        Danh sách gợi ý kế hoạch học tập
                    </router-link>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Tạo mới gợi ý kế hoạch học tập
                </li>
            </ol>
            <!-- End breadcrumb -->
        </div>
        <router-link tag="button" class="btn btn-lg btn-primary mb-3 btn-3d" :to="{ name: 'studyplansuggestindex' }">
            <i class="fa fa-arrow-left" aria-hidden="true"></i> Quay lại
        </router-link>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Gợi ý kế hoạch học tập sinh viên</h3>
            </div>
            <div class="card-body">
                <form @submit.prevent="store()" enctype="multipart/form-data" @keydown="form.onKeydown($event)">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label class="form-label">Lớp học <span class="text-danger">(*)</span></label>
                                <select
                                    class="form-control"
                                    name="plan_suggest_class"
                                    v-model="plan_suggest_class"
                                    :class="{ 'is-invalid': form.errors.has('plan_suggest_class') }"
                                >
                                    <option value="" disabled selected="">Chọn lớp học</option>
                                    <option value="" disabled>-------</option>
                                    <option v-for="clas in classes" :key="clas.class_id" :value="clas.class_id">
                                        {{ clas.course_code }} - {{ clas.class_name }}
                                    </option>
                                </select>
                                <div
                                    class="text-danger"
                                    v-if="form.errors.has('plan_suggest_class')"
                                    v-html="form.errors.get('plan_suggest_class')"
                                ></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">Sinh viên <span class="text-danger">(*)</span></label>
                                <select
                                    class="form-control"
                                    name="plan_suggest_student"
                                    v-model="form.plan_suggest_student"
                                    :class="{ 'is-invalid': form.errors.has('plan_suggest_student') }"
                                >
                                    <option value="" disabled selected="">
                                        Chọn sinh viên
                                    </option>
                                    <option value="" disabled>-------</option>
                                    <option value="0">Tất cả sinh viên</option>
                                    <option v-for="stu in students" :key="stu.student_id" :value="stu.student_id">
                                        {{ stu.student_code }} - {{ stu.student_fullname }}
                                    </option>
                                </select>
                                <div
                                    class="text-danger"
                                    v-if="form.errors.has('plan_suggest_student')"
                                    v-html="form.errors.get('plan_suggest_student')"
                                ></div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-nowrap">
                            <thead class="blue-background text-white">
                                <tr>
                                    <th class="w-5" scope="col" rowspan="2">
                                        STT
                                    </th>
                                    <th class="text-center w-20" scope="col" rowspan="2">
                                        Mã môn học
                                    </th>
                                    <th class="text-center w-55" scope="col" rowspan="2">
                                        Tên môn học
                                    </th>
                                    <th class="text-center w-10" scope="col" rowspan="2">
                                        Số TC
                                    </th>
                                    <th class="w-10 text-center"></th>
                                </tr>
                            </thead>
                            <tbody v-show="programs.length" v-for="i in semesters" :key="i">
                                <tr>
                                    <td colspan="9">
                                        <b> Học kỳ {{ i }} </b>
                                    </td>
                                </tr>
                                <tr v-for="(value, index) in value_programs[i]" :key="value.subject_id">
                                    <td class="td-table">
                                        {{ (index += 1) }}
                                    </td>
                                    <td class="text-center td-table">
                                        <a href="javscript:void(0)" @click="detail(value.subject_id)">
                                            {{ value.subject_code }}
                                        </a>
                                    </td>
                                    <td class="td-table">
                                        {{ value.subject_name }}
                                    </td>
                                    <td class="text-center td-table">
                                        {{ value.subject_credit }}
                                    </td>
                                    <td class="text-center">
                                        <input
                                            type="checkbox"
                                            name="plansuggest_detail_program"
                                            :value="value.subject_id"
                                            v-model="selected"
                                        />
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr v-show="!programs.length">
                                    <td colspan="9">
                                        <div class="alert alert-danger">
                                            Không tìm thấy kết quả phù hợp!
                                        </div>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="card-footer text-right">
                        <button :disabled="form.busy" class="btn btn-success btn-lg mt-1 btn-3d" type="submit">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            lecturer_id: this.$teacherId,
            classes: [],
            students: [],
            programs: [],
            semesters: [],
            value_programs: [],
            form: new Form({
                plan_suggest_class: '',
                plan_suggest_student: '',
                plan_suggest_id: '',
                plan_suggest_lecturer: '',
                plansuggest_detail_id: '',
                plansuggest_detail_ref: '',
                plansuggest_detail_program: '',
                selected_subejct: []
            }),
            plan_suggest_class: '',
            plan_suggest_student: '',
            selected: []
        }
    },
    mounted() {
        this.fetchClasses()
    },
    watch: {
        plan_suggest_class(value) {
            this.form.plan_suggest_class = value
            this.fetchPrograms()
            this.fetchStudentClass()
        }
    },
    methods: {
        fetchClasses(page_url) {
            page_url = `../../api/admin/class-sv/lop/class-formteacher/${this.lecturer_id}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.classes = res.data
                })
                .catch(err => console.log(err))
        },
        fetchStudentClass(page_url) {
            page_url = `../../api/admin/class-sv/lop/student-class/${this.form.plan_suggest_class}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.students = res.data
                })
                .catch(err => console.log(err))
        },
        fetchPrograms(page_url) {
            page_url = `../../api/admin/edu-program-sv/chuong-trinh-dao-tao-sinh-vien/${this.form.plan_suggest_class}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.programs = res.data
                    if (res.data.length > 0) {
                        const semesters = this.programs.reduce((semesters, item) => {
                            const semester = semesters[item.program_detail_semester] || []
                            semester.push(item)
                            semesters[item.program_detail_semester] = semester
                            return semesters
                        }, {})

                        let key = Object.keys(semesters)
                        this.value_programs = semesters
                        this.semesters = key
                    }
                })
                .catch(err => console.log(err))
        },
        store() {
            let formData = new FormData()
            formData.append('plan_suggest_class', this.form.plan_suggest_class)
            formData.append('plan_suggest_student', this.form.plan_suggest_student)
            formData.append('plan_suggest_lecturer', this.lecturer_id)
            for (let i = 0; i < this.selected.length; i++) {
                formData.append('subject[]', this.selected[i])
            }
            axios
                .post('../../api/admin/suggest-plan/goi-y-ke-hoach-hoc-tap-sv', formData)
                .then(res => {
                    this.$snotify.confirm('Bạn có muốn đi đến danh sách không?', 'Đã tạo mới', {
                        timeout: 5000,
                        showProgressBar: true,
                        closeOnClick: false,
                        pauseOnHover: true,
                        buttons: [
                            {
                                text: 'Có',
                                action: toast => {
                                    this.$snotify.remove(toast.id)
                                    this.$router.push({ name: 'studyplansuggestindex' })
                                },
                                bold: false
                            },
                            {
                                text: 'Không',
                                action: toast => {
                                    this.$snotify.remove(toast.id)
                                },
                                bold: true
                            }
                        ]
                    })
                })
                .catch(err => {
                    const null_class = err.response.data.errors?.plan_suggest_class?.length
                    const null_student = err.response.data.errors?.plan_suggest_student?.length
                    const null_subject = err.response.data.errors?.subject?.length

                    if (null_class > 0 && null_student > 0 && null_subject > 0) {
                        this.$snotify.error('Vui lòng không để trống!')
                    } else if (null_class > 0) {
                        this.$snotify.error(err.response.data.errors.plan_suggest_class[0])
                    } else if (null_student > 0) {
                        this.$snotify.error(err.response.data.errors.plan_suggest_student[0])
                    } else if (null_subject > 0) {
                        this.$snotify.error(err.response.data.errors.subject[0])
                    } else {
                        this.$snotify.error('Lỗi định dạng!')
                    }
                })
        }
    }
}
</script>

<style lang="css" scoped>
.thead-styling {
    background-color: darkblue;
    color: white;
    font-weight: bold;
}
.text-center {
    vertical-align: middle;
    border: 0.5px solid white;
}
td {
    vertical-align: middle;
    border: 0.5px solid black !important;
}
.btn-3d {
    border-bottom: 3px solid #6c757d;
    border-right: 3px solid #6c757d;
}
</style>
