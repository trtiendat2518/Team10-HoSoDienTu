<template>
    <div>
        <vue-snotify></vue-snotify>
        <div class="page-header">
            <ol class="breadcrumb">
                <!-- breadcrumb -->
                <li class="breadcrumb-item">
                    <router-link tag="a" :to="{ name: 'dashboard' }">Dashboard</router-link>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Danh sách các gợi ý</li>
            </ol>
            <!-- End breadcrumb -->
        </div>
        <router-link class="btn btn-info btn-lg mb-3 btn-3d" tag="button" :to="{ name: 'studyplansuggestcreate' }">
            <li class="fa fa-plus"></li>
            Tạo mới
        </router-link>
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="col-md-10">
                            <h3 class="card-title">Danh sách các gợi ý kế hoạch học tập</h3>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-lg btn-primary fa fa-refresh btn-3d" @click="reload()">Tải lại</button>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-1">
                            <button
                                class="btn-3d btn btn-danger mt-3 ml-3 btn-lg fa fa-trash"
                                @click="destroyall()"
                                :disabled="!selected.length"
                            ></button>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control mt-2" v-model="query" placeholder="Tìm kiếm..." />
                        </div>
                        <div class="col-md-2">
                            <div class="between:flex bottom:margin-3 ml-2">
                                <div class="center:flex-items">
                                    <span class="right:marign-1">Hiển thị</span>
                                    <select class="select form-control-styling" v-model="currentEntries">
                                        <option v-for="entry in showEntries" :key="entry" :value="entry">{{ entry }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table card-table table-vcenter text-nowrap table-nowrap">
                            <thead class="blue-background text-white">
                                <tr>
                                    <th class="w-5">
                                        <input
                                            type="checkbox"
                                            class="form-control"
                                            :disabled="empty()"
                                            @click="select()"
                                            v-model="selectAll"
                                        />
                                    </th>
                                    <th class="text-white w-40">Lớp học</th>
                                    <th class="text-white w-45">Sinh viên</th>
                                    <th class="text-white w-45">Trạng thái</th>
                                    <th class="w-5"></th>
                                    <th class="w-5"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-show="suggestions.length" v-for="suggest in suggestions" :key="suggest.plan_suggest_id">
                                    <td>
                                        <center><input type="checkbox" :value="suggest.plan_suggest_id" v-model="selected" /></center>
                                    </td>
                                    <td @click="detail(suggest)">
                                        <a href="javascript:void(0)">{{ suggest.course_code }}-{{ suggest.class_name }}</a>
                                    </td>
                                    <td>
                                        <div v-if="suggest.plan_suggest_student == 0">Cả lớp</div>
                                        <div v-else>{{ nameStudent(suggest) }}</div>
                                    </td>
                                    <td class="td-styling">
                                        <div v-if="suggest.plan_suggest_status == 0">
                                            <button class="fa fa-eye btn-eye" @click="change(suggest.plan_suggest_id)"></button>
                                        </div>
                                        <div v-else>
                                            <button class="fa fa-eye-slash btn-eye-slash" @click="change(suggest.plan_suggest_id)"></button>
                                        </div>
                                    </td>
                                    <td style="text-align: center">
                                        <router-link
                                            class="btn-3d btn btn-success btn-lg fa fa-pencil-square-o"
                                            tag="button"
                                            :to="{
                                                name: 'studyplansuggestupdate',
                                                params: {
                                                    idSPClass: suggest.plan_suggest_class,
                                                    idSPSuggest: suggest.plan_suggest_id
                                                }
                                            }"
                                        ></router-link>
                                    </td>
                                    <td>
                                        <button
                                            class="btn-3d btn btn-danger btn-lg fa fa-trash"
                                            @click="destroy(suggest.plan_suggest_id)"
                                        ></button>
                                    </td>
                                </tr>
                                <tr v-show="!suggestions.length">
                                    <td colspan="8">
                                        <div class="alert alert-danger">
                                            Không tìm thấy kết quả phù hợp!
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <pagination
                            v-if="pagination.last_page > 1"
                            :pagination="pagination"
                            :offset="5"
                            @paginate="query === '' ? fetchSuggestions() : search()"
                        ></pagination>
                    </div>
                    <!-- table-responsive -->
                </div>
            </div>
            <!-- col end -->
        </div>

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
                        <h5 class="modal-title styling-font-modal-header" id="DetailModalTitle">Chi tiết gợi ý kế hoạch</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-nowrap">
                            <thead class="detail-background text-white">
                                <tr>
                                    <th class="text-center w-30">Mã môn học</th>
                                    <th class="w-60">Tên môn học</th>
                                    <th class="text-center w-10">Số tín chỉ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="detail in details" :key="detail.subject_id">
                                    <td class="text-center">
                                        {{ detail.subject_code }}
                                    </td>
                                    <td>
                                        {{ detail.subject_name }}
                                    </td>
                                    <td class="text-center">
                                        {{ detail.subject_credit }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-3d btn btn-secondary" data-dismiss="modal">Đóng</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import 'vue-snotify/styles/material.css'
export default {
    data() {
        return {
            suggestions: [],
            students: [],
            lecturer_id: this.$teacherId,
            pagination: {
                current_page: 1
            },
            currentEntries: 5,
            showEntries: [5, 10, 25, 50],
            query: '',
            editMode: false,
            form: new Form({
                plan_suggest_id: '',
                plan_suggest_lecturer: '',
                plan_suggest_class: '',
                plan_suggest_student: '',
                plan_suggest_program: '',
                plan_suggest_status: '',
                lecturer_fullname: '',
                class_name: '',
                course_code: '',
                plansuggest_detail_program: '',
                subject_code: '',
                subject_name: '',
                subject_credit: ''
            }),
            selected: [],
            selectAll: false,
            details: []
        }
    },
    watch: {
        currentEntries(number) {
            if (number === 5) {
                this.pagination = 1
                this.fetchSuggestions()
            } else {
                this.pagination = 1
                this.fetchSuggestions()
            }
        },
        query(keyword) {
            if (keyword === '') {
                this.fetchSuggestions()
            } else {
                this.pagination.current_page = 1
                this.search()
            }
        }
    },
    mounted() {
        this.fetchSuggestions()
        this.fetchStudents()
    },
    methods: {
        empty() {
            return this.suggestions.length < 1
        },
        fetchSuggestions(page_url) {
            let vm = this
            page_url = `../../api/admin/suggest-plan/goi-y-ke-hoach-hoc-tap-sv/${this.lecturer_id}/${this.currentEntries}?page=${this.pagination.current_page}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.suggestions = res.data
                    this.pagination = res.meta
                })
                .catch(err => console.log(err))
        },
        fetchStudents(page_url) {
            page_url = `../../api/admin/user-sv/sinh-vien/student-form-teacher/${this.lecturer_id}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.students = res.data
                })
                .catch(err => console.log(err))
        },
        nameStudent(suggest) {
            if (suggest?.plan_suggest_student != 0) {
                const student = this.students.find(el => el.student_id == suggest.plan_suggest_student)
                return student.student_code + ' - ' + student.student_fullname
            } else {
                return ''
            }
        },
        search(page_url) {
            let vm = this
            page_url = `../../api/admin/suggest-plan/goi-y-ke-hoach-hoc-tap-sv/search/${this.lecturer_id}/${this.query}/${this.currentEntries}?page=${this.pagination.current_page}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.suggestions = res.data
                    this.pagination = res.meta
                })
                .catch(err => console.log(err))
        },
        change(plan_suggest_id) {
            axios
                .patch(`../../api/admin/suggest-plan/goi-y-ke-hoach-hoc-tap-sv/change/${plan_suggest_id}`)
                .then(res => {
                    this.fetchSuggestions()
                    this.$snotify.warning('Đã thay đổi trạng thái')
                })
                .catch(err => console.log(err))
        },
        destroy(plan_suggest_id) {
            this.$snotify.clear()
            this.$snotify.confirm('Xác nhận xóa', {
                timeout: 5000,
                showProgressBar: true,
                closeOnClick: false,
                pauseOnHover: true,
                buttons: [
                    {
                        text: 'Xóa',
                        action: toast => {
                            this.$snotify.remove(toast.id)
                            axios
                                .delete(`../../api/admin/suggest-plan/goi-y-ke-hoach-hoc-tap-sv/${plan_suggest_id}`)
                                .then(res => {
                                    this.$snotify.success('Đã xóa!')
                                    this.fetchSuggestions()
                                })
                                .catch(err => console.log(err))
                        },
                        bold: false
                    },
                    {
                        text: 'Đóng',
                        action: toast => {
                            this.$snotify.remove(toast.id)
                        },
                        bold: true
                    }
                ]
            })
        },
        destroyall() {
            this.$snotify.clear()
            this.$snotify.confirm('Xác nhận xóa', {
                timeout: 5000,
                showProgressBar: true,
                closeOnClick: false,
                pauseOnHover: true,
                buttons: [
                    {
                        text: 'Xóa',
                        action: toast => {
                            this.$snotify.remove(toast.id)
                            axios
                                .post('../../api/admin/suggest-plan/goi-y-ke-hoach-hoc-tap-sv/destroyall', {
                                    plan_suggest_id: this.selected
                                })
                                .then(res => {
                                    this.$snotify.success('Đã xóa!')
                                    this.fetchSuggestions()
                                })
                                .catch(err => console.log(err))
                        },
                        bold: false
                    },
                    {
                        text: 'Đóng',
                        action: toast => {
                            this.$snotify.remove(toast.id)
                        },
                        bold: true
                    }
                ]
            })
        },
        select() {
            this.selected = []
            if (!this.selectAll) {
                for (let i in this.suggestions) {
                    this.selected.push(this.suggestions[i].plan_suggest_id)
                }
            }
        },
        detail(suggest, page_url) {
            let vm = this
            page_url = `../../api/admin/suggest-plan/goi-y-ke-hoach-hoc-tap-sv/detail/${suggest.plan_suggest_id}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.details = res.data
                    this.form.fill(suggest)

                    $('#DetailModal').modal('show')
                })
                .catch(err => console.log(err))
        },
        reload() {
            this.fetchSuggestions()
            this.query = ''
        }
    }
}
</script>

<style lang="css" scoped>
.btn-eye {
    font-size: 18px;
    cursor: pointer;
    background: none;
    border: none;
}
.btn-eye-slash {
    font-size: 18px;
    cursor: pointer;
    background: none;
    border: none;
    color: #868e96de;
}
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
.btn-import {
    background-color: green;
    color: white;
}
.btn-import:hover {
    background-color: forestgreen;
    color: white;
}
.btn-export {
    background-color: darkgreen;
    color: white;
}
.btn-export:hover {
    background-color: seagreen;
    color: white;
}
.btn-import {
    background-color: green;
    color: white;
}
.btn-import:hover {
    background-color: forestgreen;
    color: white;
}
.btn-export {
    background-color: darkgreen;
    color: white;
}
.btn-export:hover {
    background-color: seagreen;
    color: white;
}
.btn-3d {
    border-bottom: 3px solid #6c757db0;
    border-right: 3px solid #6c757db0;
}
.modal-lg {
    width: 600px;
}
</style>
