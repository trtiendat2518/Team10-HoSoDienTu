<template>
    <div>
        <vue-snotify></vue-snotify>
        <div class="page-header">
            <ol class="breadcrumb">
                <!-- breadcrumb -->
                <li class="breadcrumb-item">
                    <router-link tag="a" :to="{ name: 'dashboard' }">Dashboard</router-link>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <router-link tag="a" :to="{ name: 'procedureindex' }">Danh sách thủ tục</router-link>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Danh sách yêu cầu</li>
            </ol>
            <!-- End breadcrumb -->
        </div>
        <div class="col-md-6">
            <router-link tag="button" class="btn btn-primary mb-3 btn-3d" :to="{ name: 'procedureindex' }">
                <li class="fa fa-arrow-left"></li>
                Quay lại
            </router-link>
        </div>
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="col-md-11">
                            <h3 class="card-title">Danh sách yêu cầu của sinh viên</h3>
                        </div>
                        <div class="col-md-1">
                            <button class="btn btn-lg btn-primary fa fa-refresh btn-3d" @click="reload()">Tải lại</button>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 ml-2">
                            <input type="text" class="form-control mt-2" v-model="query" placeholder="Tìm kiếm..." />
                        </div>
                        <div class="col-md-3">
                            <select class="form-control mt-2" v-model="value_status">
                                <option value="" disabled selected>Lọc theo trạng thái</option>
                                <option disabled>----------------------------------------</option>
                                <option value="0">Chờ xác nhận</option>
                                <option value="1">Đang xử lý</option>
                                <option value="2">Hoàn tất</option>
                                <option value="3">Đã bị hủy</option>
                            </select>
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
                                    <th class="text-white w-15 text-center">Mã thủ tục</th>
                                    <th class="text-white w-35 text-center">Tiêu đề</th>
                                    <th class="text-white w-15 text-center">Mã số SV</th>
                                    <th class="text-white w-15 text-center">Ngày gửi</th>
                                    <th class="text-white w-20 text-center">Trạng thái</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-show="requires.length" v-for="prequire in requires" :key="prequire.procedure_require_id">
                                    <td>
                                        <router-link
                                            tag="a"
                                            :to="{
                                                name: 'procedurerequiredetail',
                                                params: { idRProcedure: prequire.procedure_require_id }
                                            }"
                                        >
                                            {{ prequire.procedure_require_code }}
                                        </router-link>
                                    </td>
                                    <td>
                                        <div v-if="prequire.procedure_title < 20">
                                            {{ prequire.procedure_title }}
                                        </div>
                                        <div v-else>
                                            {{ prequire.procedure_title.substring(0, 50) + '...' }}
                                        </div>
                                    </td>
                                    <td class="text-center">{{ prequire.student_code }}</td>
                                    <td class="text-center">{{ prequire.procedure_require_datesend | formatDate }}</td>
                                    <td class="text-center">
                                        <select
                                            class="form-control"
                                            v-model="prequire.procedure_require_status"
                                            :class="[
                                                { 'btn-outline-success': prequire.procedure_require_status == 2 },
                                                { 'btn-outline-danger': prequire.procedure_require_status == 3 },
                                                { 'btn-outline-dark': prequire.procedure_require_status == 1 }
                                            ]"
                                            @change="change($event, prequire.procedure_require_id)"
                                            name="procedure_require_status"
                                        >
                                            <option value="0" :hidden="prequire.procedure_require_status != 0">Chờ xác nhận</option>
                                            <option value="1" :hidden="prequire.procedure_require_status > 1">Đang xử lý</option>
                                            <option value="2" :hidden="prequire.procedure_require_status == 3">Hoàn tất</option>
                                            <option value="3" :hidden="prequire.procedure_require_status == 2">Đã bị hủy</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr v-show="!requires.length">
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
                            @paginate="query === '' ? fetchRequires() : search()"
                        ></pagination>
                    </div>
                    <!-- table-responsive -->
                </div>
            </div>
            <!-- col end -->
        </div>
    </div>
</template>

<script>
import 'vue-snotify/styles/material.css'
export default {
    data() {
        return {
            admin_id: this.$adminCode,
            requires: [],
            procedure_require_status: '',
            pagination: {
                current_page: 1
            },
            currentEntries: 5,
            showEntries: [5, 10, 25, 50],
            query: '',
            editMode: false,
            form: new Form({
                procedure_require_id: '',
                procedure_require_code: '',
                procedure_require_detail: '',
                procedure_require_datesend: '',
                procedure_require_dateget: '',
                procedure_require_status: '',
                procedure_require_student: ''
            }),
            value_status: ''
        }
    },
    mounted() {
        this.fetchRequires()
    },
    watch: {
        currentEntries(number) {
            if (number === 5) {
                this.pagination = 1
                this.fetchRequires()
            } else {
                this.pagination = 1
                this.fetchRequires()
            }
        },
        query(keyword) {
            if (keyword === '') {
                this.fetchRequires()
            } else {
                this.value_status = ''
                this.pagination.current_page = 1
                this.search()
            }
        },
        value_status(value) {
            if (value === '') {
                this.fetchRequires()
            } else {
                this.query = ''
                this.pagination.current_page = 1
                this.filter()
            }
        }
    },
    methods: {
        empty() {
            return this.requires.length < 1
        },
        fetchRequires(page_url) {
            let vm = this
            page_url = `../../api/admin/procedure-require/yeu-cau-thu-tuc/${this.currentEntries}?page=${this.pagination.current_page}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.requires = res.data
                    this.pagination = res.meta
                })
                .catch(err => console.log(err))
        },
        search(page_url) {
            let vm = this
            page_url = `../../api/admin/procedure-require/yeu-cau-thu-tuc/search/${this.query}/${this.currentEntries}?page=${this.pagination.current_page}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.requires = res.data
                    this.pagination = res.meta
                })
                .catch(err => console.log(err))
        },
        change(event, procedure_require_id) {
            this.form.procedure_require_status = event.target.value
            this.form
                .patch(`../../api/admin/procedure-require/yeu-cau-thu-tuc/change/${procedure_require_id}/${this.admin_id}`)
                .then(res => {
                    this.fetchRequires()
                    this.$snotify.warning('Đã thay đổi trạng thái')
                })
                .catch(err => console.log(err))
        },
        reload() {
            this.fetchRequires()
            this.query = ''
            this.value_status = ''
        },
        filter(page_url) {
            let vm = this
            page_url =
                '../../api/admin/procedure-require/yeu-cau-thu-tuc/filter/' +
                this.value_status +
                '/' +
                this.currentEntries +
                '?page=' +
                this.pagination.current_page
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.requires = res.data
                    this.pagination = res.meta
                })
                .catch(err => console.log(err))
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
    background-color: #1753fc;
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
.styling-strong {
    word-wrap: break-word;
    white-space: pre-line;
}
.btn-3d {
    border-bottom: 3px solid #6c757db0;
    border-right: 3px solid #6c757db0;
}
</style>
