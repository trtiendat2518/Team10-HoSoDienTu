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
                    Cập nhật gợi ý kế hoạch học tập
                </li>
            </ol>
            <!-- End breadcrumb -->
        </div>
        <router-link tag="button" class="btn btn-lg btn-primary mb-3 btn-3d" :to="{ name: 'studyplansuggestindex' }">
            <i class="fa fa-arrow-left" aria-hidden="true"></i> Quay lại
        </router-link>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Cập nhật gợi ý kế hoạch học tập sinh viên</h3>
            </div>
            <div class="card-body">
                <form @submit.prevent="update()" enctype="multipart/form-data" @keydown="form.onKeydown($event)">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Lớp học</label>
                                <input
                                    class="form-control"
                                    name="plan_suggest_class"
                                    :value="form.course_code + '-' + form.class_name"
                                    disabled
                                />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Sinh viên</label>
                                <div v-if="form.plan_suggest_student == 0">
                                    <input class="form-control" name="plan_suggest_student" value="Cả lớp" disabled />
                                </div>
                                <div v-else>
                                    <input :value="nameStudent(form.plan_suggest_student)" hidden />
                                    <input
                                        class="form-control"
                                        name="plan_suggest_student"
                                        :value="student_code + ' - ' + student_fullname"
                                        disabled
                                    />
                                </div>
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
                                            :checked="checkValue(value)"
                                            @change="select($event.target.checked, value.subject_id)"
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
            class_id: this.$route.params.idSPClass,
            plan_suggest_id: this.$route.params.idSPSuggest,
            classes: [],
            programs: [],
            semesters: [],
            value_programs: [],
            selected: [],
            form: new Form({
                plan_suggest_class: '',
                plan_suggest_student: '',
                plan_suggest_id: '',
                plan_suggest_lecturer: '',
                plansuggest_detail_id: '',
                plansuggest_detail_ref: '',
                plansuggest_detail_program: '',
                course_code: '',
                class_name: ''
            }),
            student_code: '',
            student_fullname: ''
        }
    },
    mounted() {
        this.fetchClasses()
        this.fetchPrograms()
    },
    watch: {
        $route(to, from) {
            this.plan_suggest_id = to.params.idSPSuggest
            this.class_id = to.params.idSPClass
        }
    },
    methods: {
        fetchClasses(page_url) {
            page_url = `../../api/admin/suggest-plan/goi-y-ke-hoach-hoc-tap-sv/onlyone/${this.plan_suggest_id}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.classes = res.data
                    this.form.fill(res.data[0])
                    for (let i = 0; i <= res.data.length; i++) {
                        this.selected.push(res.data[i].plansuggest_detail_program)
                    }
                })
                .catch(err => console.log(err))
        },
        nameStudent(plan_suggest_student) {
            fetch(`../../api/admin/user-sv/sinh-vien/detail/${plan_suggest_student}`)
                .then(res => res.json())
                .then(res => {
                    this.student_code = res.data[0].student_code
                    this.student_fullname = res.data[0].student_fullname
                })
                .catch(err => console.log(err))
        },
        fetchPrograms(page_url) {
            page_url = `../../api/admin/edu-program-sv/chuong-trinh-dao-tao-sinh-vien/${this.class_id}`
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
        checkValue(value) {
            const check = this.classes.find(clas => clas.plansuggest_detail_program == value.subject_id)
            if (check) {
                return true
            } else {
                return false
            }
        },
        select(e, value) {
            if (e === true) {
                this.selected.push(value)
            } else {
                let index = this.selected.indexOf(value)
                this.selected.splice(index, 1)
            }
        },
        update() {
            let formData = new FormData()
            for (let i = 0; i < this.selected.length; i++) {
                formData.append('subject[]', this.selected[i])
            }
            axios
                .post(`../../api/admin/suggest-plan/goi-y-ke-hoach-hoc-tap-sv/upgrade/${this.form.plan_suggest_id}`, formData)
                .then(res => {
                    this.$snotify.confirm('Bạn có muốn đi đến danh sách không?', 'Đã cập nhật', {
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
                    const null_subject = err.response.data.errors?.subject?.length
                    if (null_subject > 0) {
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
