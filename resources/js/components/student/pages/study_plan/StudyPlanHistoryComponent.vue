<template>
    <div class="container">
        <div class="section-banner">
            <img class="section-banner-icon" :src="`../public/student/img/banner/newsfeed-icon.png`" alt="newsfeed-icon" />
            <p class="section-banner-title">Kế hoạch học tập</p>
        </div>

        <div class="grid">
            <div class="widget-box">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group form-select">
                            <select class="form-control" v-model="filter">
                                <option value="">Xem tất cả</option>
                                <option v-for="i in semesters" :key="i" :value="i">Học kỳ {{ i }}</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div v-show="filter == ''" class="table-responsive" ref="content">
                    <div v-if="plans.length > 0">
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
                                </tr>
                            </thead>
                            <tbody v-for="i in semesters" :key="i">
                                <tr>
                                    <td colspan="4">
                                        <b> Học kỳ {{ i }} </b>
                                    </td>
                                </tr>
                                <tr v-for="(value, index) in value_plans[i]" :key="value.subject_id">
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
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr v-show="!semesters.length">
                                    <td colspan="4">
                                        <div class="alert alert-danger">
                                            Không tìm thấy kết quả phù hợp!
                                        </div>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <div v-show="filter != ''" class="table-responsive" ref="content">
                    <div v-if="plans.length > 0">
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
                                </tr>
                            </thead>
                            <tbody v-for="i in filter_semesters" :key="i">
                                <tr>
                                    <td colspan="4">
                                        <b> Học kỳ {{ i }} </b>
                                    </td>
                                </tr>
                                <tr v-for="(value, index) in filter_plans[i]" :key="value.subject_id">
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
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr v-show="!semesters.length">
                                    <td colspan="4">
                                        <div class="alert alert-danger">
                                            Không tìm thấy kết quả phù hợp!
                                        </div>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
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
            plans: [],
            value_plans: [],
            filter_plans: [],
            semesters: [],
            filter_semesters: [],
            filter: ''
        }
    },
    mounted() {
        this.fetchAllPlans()
    },
    watch: {
        filter(value) {
            if (value === '') {
                this.fetchAllPlans()
            } else {
                this.filterPlan()
            }
        }
    },
    methods: {
        fetchAllPlans(page_url) {
            page_url = `../../api/student/study-plan/dang-ky-ke-hoach-hoc-tap/my-all-plan/${this.student_id}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.plans = res.data
                    const semesters = this.plans.reduce((semesters, item) => {
                        const semester = semesters[item.register_plan_semester] || []
                        semester.push(item)
                        semesters[item.register_plan_semester] = semester
                        return semesters
                    }, {})

                    let key = Object.keys(semesters)
                    this.value_plans = semesters
                    this.semesters = key
                })
                .catch(err => console.log(err))
        },
        filterPlan(page_url) {
            page_url = `../../api/student/study-plan/dang-ky-ke-hoach-hoc-tap/filter/${this.student_id}/${this.filter}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.plans = res.data
                    const semesters = this.plans.reduce((semesters, item) => {
                        const semester = semesters[item.register_plan_semester] || []
                        semester.push(item)
                        semesters[item.register_plan_semester] = semester
                        return semesters
                    }, {})

                    let key = Object.keys(semesters)
                    this.filter_plans = semesters
                    this.filter_semesters = key
                })
                .catch(err => console.log(err))
        }
    }
}
</script>

<style></style>
