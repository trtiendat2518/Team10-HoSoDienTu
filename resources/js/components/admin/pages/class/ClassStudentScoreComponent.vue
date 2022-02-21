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
                    <router-link tag="a" :to="{ name: 'classstudentindex' }">
                        Danh sách lớp học
                    </router-link>
                </li>
                <li class="breadcrumb-item">
                    <router-link
                        tag="a"
                        :to="{
                            name: 'classstudentdetail',
                            params: { idClass: class_id }
                        }"
                    >
                        Danh sách sinh viên
                    </router-link>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Xem điểm
                </li>
            </ol>
            <!-- End breadcrumb -->
        </div>

        <router-link
            class="btn btn-primary btn-lg mb-3 btn-3d"
            tag="button"
            :to="{
                name: 'classstudentdetail',
                params: { idClass: class_id }
            }"
        >
            <li class="fa fa-arrow-left"></li>
            Quay lại
        </router-link>

        <div class="alert alert-info">
            <p>
                <i><u>Chú ý:</u></i>
            </p>
            <div>
                <p class="fa fa-check"></p>
                : Môn học đã đậu
            </div>
            <div>
                <p class="fa fa-times"></p>
                : Môn học đã rớt
            </div>
            <div>
                <p class="fa fa-minus"></p>
                : Chưa có điểm
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="col-md-6">
                            <h2 class="card-title">
                                <div>
                                    <b>
                                        Bảng điểm sinh viên:
                                        {{ student_code }}
                                    </b>
                                </div>
                            </h2>
                        </div>
                        <div class="col-md-6 text-right">
                            <button class="btn btn-import btn-lg mb-3 btn-3d" @click="openImport()">
                                <li class="fa fa-upload"></li>
                                Import
                            </button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-nowrap">
                            <thead class="blue-background text-white">
                                <tr>
                                    <th class="text-center text-white w-5">
                                        STT
                                    </th>
                                    <th class="text-center text-white w-15">
                                        Mã môn học
                                    </th>
                                    <th class="text-center text-white w-35">
                                        Tên môn học
                                    </th>
                                    <th class="text-center w-5">
                                        Số TC
                                    </th>
                                    <th class="text-center w-10">
                                        Điểm
                                    </th>
                                    <th class="text-center w-10">
                                        Điểm chữ
                                    </th>
                                    <th class="text-center w-10">
                                        kết quả
                                    </th>
                                    <th class="text-center w-5">
                                        Chi tiết
                                    </th>
                                    <th class="text-center w-5">
                                        Cập nhật
                                    </th>
                                </tr>
                            </thead>
                            <tbody v-for="i in semesters" :key="i">
                                <tr>
                                    <td colspan="9">
                                        <b> Học kỳ {{ i }} </b>
                                    </td>
                                </tr>

                                <tr v-show="subjects[i].length" v-for="(subject, index) in subjects[i]" :key="subject.subject_id">
                                    <td class="text-center">
                                        {{ (index += 1) }}
                                    </td>
                                    <td class="text-center">
                                        {{ subject.subject_code }}
                                    </td>
                                    <td>
                                        {{ subject.subject_name }}
                                    </td>
                                    <td class="text-center">
                                        {{ subject.subject_credit }}
                                    </td>
                                    <td class="text-center">
                                        <div
                                            v-if="
                                                subject.register_subject_exercise == null &&
                                                    subject.register_subject_exam == null &&
                                                    subject.register_subject_final == null
                                            "
                                        >
                                            <i class="fa fa-minus" aria-hidden="true"></i>
                                        </div>
                                        <div v-else>
                                            {{ scoreSum(subject) }}
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div
                                            v-if="
                                                subject.register_subject_exercise == null &&
                                                    subject.register_subject_exam == null &&
                                                    subject.register_subject_final == null
                                            "
                                        >
                                            <i class="fa fa-minus" aria-hidden="true"></i>
                                        </div>
                                        <div v-else>
                                            <div v-if="scoreSum(subject) < 4">
                                                F
                                            </div>
                                            <div v-else-if="scoreSum(subject) < 5">
                                                D
                                            </div>
                                            <div v-else-if="scoreSum(subject) < 5.5">
                                                D+
                                            </div>
                                            <div v-else-if="scoreSum(subject) < 6.5">
                                                C
                                            </div>
                                            <div v-else-if="scoreSum(subject) < 7">
                                                C+
                                            </div>
                                            <div v-else-if="scoreSum(subject) < 8">
                                                B
                                            </div>
                                            <div v-else-if="scoreSum(subject) < 8.5">
                                                B+
                                            </div>
                                            <div v-else-if="scoreSum(subject) < 9">
                                                A
                                            </div>
                                            <div v-else-if="scoreSum(subject) <= 10">
                                                A+
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div
                                            v-if="
                                                subject.register_subject_exercise == null &&
                                                    subject.register_subject_exam == null &&
                                                    subject.register_subject_final == null
                                            "
                                        >
                                            <i class="fa fa-minus" aria-hidden="true"></i>
                                        </div>
                                        <div v-else>
                                            <div v-if="scoreSum(subject) < 4">
                                                <i class="fa fa-times" aria-hidden="true"></i>
                                            </div>
                                            <div v-else-if="scoreSum(subject) >= 4">
                                                <i class="fa fa-check" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <button class="btn-3d btn btn-success btn-lg fa fa-info" @click="show(subject)"></button>
                                    </td>
                                    <td class="text-center">
                                        <button
                                            class="btn-3d btn btn-indigo btn-lg fa fa-pencil-square-o"
                                            @click="change(subject)"
                                        ></button>
                                    </td>
                                </tr>
                                <tr class="background-result">
                                    <td colspan="4">
                                        <div>
                                            Số TC đạt được trong học kỳ:
                                            <b>
                                                {{ resultCreditSemester(i) }}
                                            </b>
                                        </div>
                                        <div>
                                            Điểm TB học kỳ:
                                            <b>
                                                {{ resultScoreSemester(i) }}
                                            </b>
                                        </div>
                                    </td>
                                    <td colspan="5">
                                        <div>
                                            Số TC tích lũy:
                                            <b>
                                                {{ resultCreditAll(i) }}
                                            </b>
                                        </div>
                                        <div>
                                            Điểm TB tích lũy:
                                            <b>
                                                {{ resultScoreAll(i) }}
                                            </b>
                                        </div>
                                    </td>
                                    <td></td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr v-show="!semesters.length">
                                    <td colspan="9">
                                        <div class="alert alert-danger">
                                            Không tìm thấy kết quả phù hợp!
                                        </div>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- table-responsive -->
                </div>
            </div>
            <!-- col end -->
        </div>

        <!-- Modal -->
        <div
            class="modal fade bd-example-modal-lg"
            id="DetailModal"
            tabindex="-1"
            role="dialog"
            aria-labelledby="DetailModalTitle"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header styling-modal-header-info">
                        <h5 class="modal-title styling-font-modal-header" id="DetailModalTitle">
                            {{ form.subject_name }}
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table card-table table-vcenter text-nowrap table-nowrap">
                            <thead class="detail-background text-white">
                                <tr>
                                    <th class="text-center">Tên thành phần</th>
                                    <th class="text-center">Trọng số</th>
                                    <th class="text-center">Điểm lần 1</th>
                                    <th class="text-center">Điểm lần 2</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center">
                                        Điểm bài tập
                                    </td>
                                    <td class="text-center">{{ form.subject_score_exercise }}%</td>
                                    <td class="text-center">
                                        {{ form.register_subject_exercise }}
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        Điểm kiểm tra
                                    </td>
                                    <td class="text-center">{{ form.subject_score_exam }}%</td>
                                    <td class="text-center">
                                        {{ form.register_subject_exam }}
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        Điểm thi
                                    </td>
                                    <td class="text-center">{{ form.subject_score_final }}%</td>
                                    <td class="text-center">
                                        {{ form.register_subject_final }}
                                    </td>
                                    <td class="text-center">
                                        {{ form.register_subject_second }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-3d" data-dismiss="modal">
                            Đóng
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal end-->

        <!-- Modal -->
        <div
            class="modal fade bd-example-modal-lg"
            id="UpdateModal"
            tabindex="-1"
            role="dialog"
            aria-labelledby="UpdateModalTitle"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-lg">
                <form @submit.prevent="update()" @keydown="form.onKeydown($event)">
                    <div class="modal-content">
                        <div class="modal-header styling-modal-header-info">
                            <h5 class="modal-title styling-font-modal-header" id="UpdateModalTitle">
                                {{ form.subject_name }}
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <table class="table card-table table-vcenter text-nowrap table-nowrap">
                                <thead class="detail-background text-white">
                                    <tr>
                                        <th class="text-center">
                                            Tên thành phần
                                        </th>
                                        <th class="text-center">Trọng số</th>
                                        <th class="text-center">Điểm lần 1</th>
                                        <th class="text-center">Điểm lần 2</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-center">
                                            Điểm bài tập
                                        </td>
                                        <td class="text-center">{{ form.subject_score_exercise }}%</td>
                                        <td class="text-center">
                                            <input
                                                class="form-control text-center"
                                                type="number"
                                                step="0.01"
                                                name="register_subject_exercise"
                                                v-model="form.register_subject_exercise"
                                            />
                                            <div
                                                class="text-danger"
                                                v-if="form.errors.has('register_subject_exercise')"
                                                v-html="form.errors.get('register_subject_exercise')"
                                            ></div>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            Điểm kiểm tra
                                        </td>
                                        <td class="text-center">{{ form.subject_score_exam }}%</td>
                                        <td class="text-center">
                                            <input
                                                class="form-control text-center"
                                                type="number"
                                                step="0.01"
                                                name="register_subject_exam"
                                                v-model="form.register_subject_exam"
                                            />
                                            <div
                                                class="text-danger"
                                                v-if="form.errors.has('register_subject_exam')"
                                                v-html="form.errors.get('register_subject_exam')"
                                            ></div>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            Điểm thi
                                        </td>
                                        <td class="text-center">{{ form.subject_score_final }}%</td>
                                        <td class="text-center">
                                            <input
                                                class="form-control text-center"
                                                type="number"
                                                step="0.01"
                                                name="register_subject_final"
                                                v-model="form.register_subject_final"
                                            />
                                            <div
                                                class="text-danger"
                                                v-if="form.errors.has('register_subject_final')"
                                                v-html="form.errors.get('register_subject_final')"
                                            ></div>
                                        </td>
                                        <td class="text-center">
                                            <div v-if="form.register_subject_final != null">
                                                <input
                                                    class="form-control text-center"
                                                    type="number"
                                                    step="0.01"
                                                    name="register_subject_second"
                                                    v-model="form.register_subject_second"
                                                />
                                                <div
                                                    class="text-danger"
                                                    v-if="form.errors.has('register_subject_second')"
                                                    v-html="form.errors.get('register_subject_second')"
                                                ></div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-3d" data-dismiss="modal">
                                Đóng
                            </button>
                            <button :disabled="form.busy" type="submit" class="btn-3d btn btn-primary background-update">
                                Cập nhật
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- Modal end-->

        <!-- Modal -->
        <div class="modal fade" id="ImportModal" tabindex="-1" role="dialog" aria-labelledby="ImportModalTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form @submit.prevent="importFile()" @keydown="form.onKeydown($event)">
                    <div class="modal-content">
                        <div class="modal-header styling-modal-header-update">
                            <h5 class="modal-title" id="ImportModalTitle">
                                Import điểm
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <label>Tệp Excel <span class="text-danger">(*)</span></label>
                            <input
                                type="file"
                                class="form-control"
                                id="fileImport"
                                name="fileImport"
                                ref="fileupload"
                                @change="onFileChange"
                            />
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-3d" @click="reloadFile()">
                                Tải lại
                            </button>
                            <button :disabled="form.busy" type="submit" class="btn btn-primary btn-3d">
                                Import
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- Modal end-->
    </div>
</template>

<script>
export default {
    data() {
        return {
            subjects: [],
            semesters: [],
            student_code: '',
            class_id: this.$route.params.idClass,
            student_id: this.$route.params.idStudent,
            form: new Form({
                subject_id: '',
                subject_name: '',
                subject_score_exercise: '',
                subject_score_exam: '',
                subject_score_final: '',
                register_subject_id: '',
                register_subject_exercise: '',
                register_subject_exam: '',
                register_subject_final: '',
                register_subject_second: ''
            }),
            fileImport: '',
            error: {}
        }
    },
    mounted() {
        this.fetchStudentClass()
    },
    watch: {
        $route(to, from) {
            this.class_id = to.params.idClass
            this.student_id = to.params.idStudent
        }
    },
    methods: {
        fetchStudentClass(page_url) {
            let vm = this
            page_url = `../../api/admin/register-subject/dang-ky-mon-hoc-sv/xem-diem/${this.student_id}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.student_code = res.data[0].student_code

                    const semesters = res.data.reduce((semesters, item) => {
                        const semester = semesters[item.register_subject_semester] || []
                        semester.push(item)
                        semesters[item.register_subject_semester] = semester
                        return semesters
                    }, {})

                    let key = Object.keys(semesters)
                    this.subjects = semesters
                    this.semesters = key
                })
                .catch(err => console.log(err))
        },
        show(subject) {
            this.form.reset()
            this.form.clear()
            this.form.fill(subject)
            $('#DetailModal').modal('show')
        },
        scoreSum(subject) {
            let scoreExercise = 0
            let scoreExam = 0
            let scoreFinal = 0

            scoreExercise = (subject.register_subject_exercise * subject.subject_score_exercise) / 100
            scoreExam = (subject.register_subject_exam * subject.subject_score_exam) / 100

            if (subject.register_subject_final >= subject.register_subject_second) {
                scoreFinal = (subject.register_subject_final * subject.subject_score_final) / 100
            } else {
                scoreFinal = (subject.register_subject_second * subject.subject_score_final) / 100
            }

            return scoreExercise + scoreExam + scoreFinal
        },
        resultCreditSemester(i) {
            let sum = 0
            let scoreExercise = 0
            let scoreExam = 0
            let scoreFinal = 0
            let scoreSum = 0
            for (let j = 0; j < this.subjects[i].length; j++) {
                scoreExercise = (this.subjects[i][j].register_subject_exercise * this.subjects[i][j].subject_score_exercise) / 100
                scoreExam = (this.subjects[i][j].register_subject_exam * this.subjects[i][j].subject_score_exam) / 100
                if (this.subjects[i][j].register_subject_final >= this.subjects[i][j].register_subject_second) {
                    scoreFinal = (this.subjects[i][j].register_subject_final * this.subjects[i][j].subject_score_final) / 100
                } else {
                    scoreFinal = (this.subjects[i][j].register_subject_second * this.subjects[i][j].subject_score_final) / 100
                }

                scoreSum = scoreExercise + scoreExam + scoreFinal
                if (scoreSum >= 4) {
                    sum += parseFloat(this.subjects[i][j].subject_credit)
                }
            }
            return sum
        },
        resultScoreSemester(i) {
            let sum = 0
            let sumCredit = 0
            let scoreExercise = 0
            let scoreExam = 0
            let scoreFinal = 0
            let scoreSum = 0
            for (let j = 0; j < this.subjects[i].length; j++) {
                scoreExercise = (this.subjects[i][j].register_subject_exercise * this.subjects[i][j].subject_score_exercise) / 100
                scoreExam = (this.subjects[i][j].register_subject_exam * this.subjects[i][j].subject_score_exam) / 100
                if (this.subjects[i][j].register_subject_final >= this.subjects[i][j].register_subject_second) {
                    scoreFinal = (this.subjects[i][j].register_subject_final * this.subjects[i][j].subject_score_final) / 100
                } else {
                    scoreFinal = (this.subjects[i][j].register_subject_second * this.subjects[i][j].subject_score_final) / 100
                }
                scoreSum += (scoreExercise + scoreExam + scoreFinal) * this.subjects[i][j].subject_credit
                sumCredit += this.subjects[i][j].subject_credit
                sum = parseFloat(scoreSum / sumCredit)
            }
            return sum.toFixed(2)
        },
        resultCreditAll(i) {
            let sum = 0
            let scoreExercise = 0
            let scoreExam = 0
            let scoreFinal = 0
            let scoreSum = 0
            for (let l = 1; l <= i; l++) {
                for (let j = 0; j < this.subjects[l].length; j++) {
                    scoreExercise = (this.subjects[l][j].register_subject_exercise * this.subjects[l][j].subject_score_exercise) / 100
                    scoreExam = (this.subjects[l][j].register_subject_exam * this.subjects[l][j].subject_score_exam) / 100
                    if (this.subjects[l][j].register_subject_final >= this.subjects[l][j].register_subject_second) {
                        scoreFinal = (this.subjects[l][j].register_subject_final * this.subjects[l][j].subject_score_final) / 100
                    } else {
                        scoreFinal = (this.subjects[l][j].register_subject_second * this.subjects[l][j].subject_score_final) / 100
                    }

                    scoreSum = scoreExercise + scoreExam + scoreFinal

                    if (scoreSum >= 4) {
                        sum += parseFloat(this.subjects[l][j].subject_credit)
                    }
                }
            }
            return sum
        },
        resultScoreAll(i) {
            let sum = 0
            let sumCredit = 0
            let scoreExercise = 0
            let scoreExam = 0
            let scoreFinal = 0
            let scoreSum = 0
            for (let l = 1; l <= i; l++) {
                for (let j = 0; j < this.subjects[l].length; j++) {
                    scoreExercise = (this.subjects[l][j].register_subject_exercise * this.subjects[l][j].subject_score_exercise) / 100
                    scoreExam = (this.subjects[l][j].register_subject_exam * this.subjects[l][j].subject_score_exam) / 100
                    if (this.subjects[l][j].register_subject_final >= this.subjects[l][j].register_subject_second) {
                        scoreFinal = (this.subjects[l][j].register_subject_final * this.subjects[l][j].subject_score_final) / 100
                    } else {
                        scoreFinal = (this.subjects[l][j].register_subject_second * this.subjects[l][j].subject_score_final) / 100
                    }
                    scoreSum += (scoreExercise + scoreExam + scoreFinal) * this.subjects[l][j].subject_credit
                    sumCredit += parseFloat(this.subjects[l][j].subject_credit)

                    sum = parseFloat(scoreSum / sumCredit)
                }
            }
            return sum.toFixed(2)
        },
        change(subject) {
            this.form.reset()
            this.form.clear()
            this.form.fill(subject)
            $('#UpdateModal').modal('show')
        },
        update() {
            this.form
                .put(`../../api/admin/register-subject/dang-ky-mon-hoc-sv/${this.form.register_subject_id}`)
                .then(res => {
                    this.fetchStudentClass()
                    $('#UpdateModal').modal('hide')
                    if (this.form.successful) {
                        this.$snotify.success('Cập nhật điểm thành công!')
                    } else {
                        this.$snotify.error('Không thể chỉnh sửa')
                    }
                })
                .catch(err => console.log(err))
        },

        openImport() {
            this.$refs.fileupload.value = ''
            $('#ImportModal').modal('show')
        },
        onFileChange(e) {
            if (e.target.files[0].name != 'score_student.xlsx') {
                this.$refs.fileupload.value = ''
                this.$snotify.error('Tên tệp Excel không đúng!')
            } else {
                this.fileImport = e.target.files[0]
            }
        },
        reloadFile() {
            this.$refs.fileupload.value = ''
            this.fileImport = ''
        },
        importFile() {
            let formData = new FormData()
            formData.append('fileImport', this.fileImport)
            axios
                .post(`../../api/admin/register-subject/dang-ky-mon-hoc-sv/import/${this.student_id}`, formData, {
                    headers: { 'content-type': 'multipart/form-data' }
                })
                .then(res => {
                    if (res.status === 200) {
                        $('#ImportModal').modal('hide')
                        this.fetchStudentClass()
                        this.$snotify.success('Import thành công')
                    }
                })
                .catch(err => {
                    if (err.response.data.errors?.fileImport?.length > 0) {
                        this.error = err.response.data.errors.fileImport[0]
                    } else if (err.response.data.errors[0].length > 0) {
                        const stringError = err.response.data.errors[0][0]
                        const stringSplit = stringError.split('.')
                        this.error = stringSplit[1]
                    }

                    this.fetchStudentClass()
                    this.$snotify.error(this.error)
                })
        }
    }
}
</script>

<style scoped>
.td-styling {
    text-align: center;
}
.not-allowed {
    cursor: not-allowed;
}
.select-option {
    cursor: pointer;
}
.h3-strong {
    color: #1753fc;
}
.styling-modal-header-info {
    background-color: darkblue;
    color: white;
}
.styling-font-modal-header {
    font-size: 20px;
    font-weight: bold;
}
.styling-modal-header-update {
    background-color: darkblue;
    color: white;
}
.td-borderight {
    border-right: 2px solid black;
}
.td-borderbottom {
    border-bottom: 2px solid black;
}
.background-update {
    background-color: darkblue;
    border-color: darkblue;
}
.btn-3d {
    border-bottom: 3px solid #6c757db0;
    border-right: 3px solid #6c757db0;
}
.btn-import {
    background-color: green;
    color: white;
}
.btn-import:hover {
    background-color: forestgreen;
    color: white;
}
.avatar-xxl {
    height: 100%;
    width: 8rem;
}
.fa-times {
    color: red;
    font-size: 20px;
}
.fa-check {
    color: green;
    font-size: 20px;
}
.background-result {
    background-color: lightgoldenrodyellow;
}
strong {
    word-break: break-word;
}
</style>
