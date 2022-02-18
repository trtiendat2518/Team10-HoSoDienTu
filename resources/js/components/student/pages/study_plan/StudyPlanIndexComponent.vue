<template>
    <div class="container">
        <div class="section-banner">
            <img class="section-banner-icon" :src="`../public/student/img/banner/newsfeed-icon.png`" alt="newsfeed-icon" />
            <p class="section-banner-title">Kế hoạch học tập</p>
        </div>

        <div class="grid">
            <div class="alert alert-info">
                <div class="mb-2">
                    <p>
                        <i><u>Kết quả đăng ký:</u></i>
                    </p>
                    <div>Tổng số tín chỉ theo kế hoạch đăng ký: <b class="text-red">x/20</b> (tín chỉ)</div>
                </div>
                <div>
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
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group form-select">
                        <select class="form-control" v-model="select_type">
                            <option value="1">Đăng ký kế hoạch theo cá nhân</option>
                            <option value="2">Đăng ký kế hoạch theo gợi ý của chủ nhiệm (cả lớp)</option>
                            <option value="3">Đăng ký kế hoạch theo gợi ý của chủ nhiệm (cá nhân)</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <button class="btn btn-block btn-lg btn-primary">Đăng ký</button>
                </div>
                <div class="col-md-3">
                    <button class="btn btn-block btn-lg btn-info">In PDF</button>
                </div>
            </div>

            <div v-show="show_type == 1" class="table-responsive">
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
                                Đã học
                            </th>
                            <th class="w-10 text-center">Kế hoạch</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(value, index) in programs" :key="value.subject_id">
                            <td class="td-table text-center">
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
                                <div v-if="scoreSum(value) == false"></div>
                                <div v-else-if="scoreSum(value) == true">
                                    <div v-if="checkSum(value) < 4">
                                        <i class="fa fa-times" aria-hidden="true"></i>
                                    </div>
                                    <div v-else-if="checkSum(value) >= 4">
                                        <i class="fa fa-check" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                <input type="checkbox" name="plansuggest_detail_program" :value="value.subject_id" v-model="selected" />
                            </td>
                        </tr>
                        <tr v-show="!programs.length">
                            <td colspan="9">
                                <div class="alert alert-danger">
                                    Không tìm thấy kết quả phù hợp!
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div v-show="show_type == 2" class="table-responsive">
                <div v-if="suggest_all.length > 0">
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
                                    Đã học
                                </th>
                                <th class="w-10 text-center">Kế hoạch</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(value, index) in programs" :key="value.subject_id">
                                <td class="td-table text-center">
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
                                    <div v-if="scoreSum(value) == false"></div>
                                    <div v-else-if="scoreSum(value) == true">
                                        <div v-if="checkSum(value) < 4">
                                            <i class="fa fa-times" aria-hidden="true"></i>
                                        </div>
                                        <div v-else-if="checkSum(value) >= 4">
                                            <i class="fa fa-check" aria-hidden="true"></i>
                                        </div>
                                    </div>
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
                            <tr v-show="!programs.length">
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

            <div v-show="show_type == 3" class="table-responsive">
                <div v-if="suggest_only.length > 0">
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
                                    Đã học
                                </th>
                                <th class="w-10 text-center">Kế hoạch</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(value, index) in programs" :key="value.subject_id">
                                <td class="td-table text-center">
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
                                    <div v-if="scoreSum(value) == false"></div>
                                    <div v-else-if="scoreSum(value) == true">
                                        <div v-if="checkSum(value) < 4">
                                            <i class="fa fa-times" aria-hidden="true"></i>
                                        </div>
                                        <div v-else-if="checkSum(value) >= 4">
                                            <i class="fa fa-check" aria-hidden="true"></i>
                                        </div>
                                    </div>
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
                            <tr v-show="!programs.length">
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
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            student_id: this.$studentId,
            scores: [],
            programs: [],
            suggest_all: [],
            suggest_only: [],
            select_type: 1,
            show_type: 1,
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
        this.fetchPrograms()
        this.fetchScore()
    },
    watch: {
        select_type(value) {
            if (value == 1) {
                this.show_type = 1
            } else if (value == 2) {
                this.show_type = 2
                this.fetchSuggestAll()
            } else if (value == 3) {
                this.show_type = 3
                this.fetchSuggestOnly()
            }
        }
    },
    methods: {
        fetchPrograms(page_url) {
            page_url = `../../api/student/study-plan/dang-ky-ke-hoach-hoc-tap/${this.student_id}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.programs = res.data
                })
                .catch(err => console.log(err))
        },
        fetchSuggestAll(page_url) {
            page_url = `../../api/student/study-plan/dang-ky-ke-hoach-hoc-tap/goi-y-ca-lop/${this.student_id}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.suggest_all = res.data
                })
                .catch(err => console.log(err))
        },
        fetchSuggestOnly(page_url) {
            page_url = `../../api/student/study-plan/dang-ky-ke-hoach-hoc-tap/goi-y-ca-nhan/${this.student_id}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.suggest_only = res.data
                })
                .catch(err => console.log(err))
        },
        fetchScore(page_url) {
            page_url = `../../api/student/study-plan/dang-ky-ke-hoach-hoc-tap/score/${this.student_id}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.scores = res.data
                })
                .catch(err => console.log(err))
        },
        scoreSum(value) {
            let check = false
            this.scores.filter(el => {
                if (el.subject_id == value.subject_id) {
                    check = true
                }
            })
            return check
        },
        checkSum(value) {
            let scoreExercise = 0
            let scoreExam = 0
            let scoreFinal = 0

            this.scores.filter(el => {
                if (el.subject_id == value.subject_id) {
                    scoreExercise = (el.register_subject_exercise * el.subject_score_exercise) / 100
                    scoreExam = (el.register_subject_exam * el.subject_score_exam) / 100

                    if (el.register_subject_final >= el.register_subject_second) {
                        scoreFinal = (el.register_subject_final * el.subject_score_final) / 100
                    } else {
                        scoreFinal = (el.register_subject_second * el.subject_score_final) / 100
                    }
                }
            })
            return scoreExercise + scoreExam + scoreFinal
        },
        checkValue(value) {
            if (this.show_type == 2) {
                const check = this.suggest_all.find(sub => sub.plansuggest_detail_program == value.subject_id)
                if (check) {
                    return true
                } else {
                    return false
                }
            } else if (this.show_type == 3) {
                const check = this.suggest_only.find(sub => sub.plansuggest_detail_program == value.subject_id)
                if (check) {
                    return true
                } else {
                    return false
                }
            }
        },
        select(e, value) {
            if (e === true) {
                this.selected.push(value)
            } else {
                let index = this.selected.indexOf(value)
                this.selected.splice(index, 1)
            }
        }
    }
}
</script>

<style scope>
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
.blue-background {
    background-color: darkblue;
}
.fa-check {
    color: rgb(15, 233, 15);
}
.fa-times {
    color: red;
}
.text-red {
    color: red;
}
</style>
