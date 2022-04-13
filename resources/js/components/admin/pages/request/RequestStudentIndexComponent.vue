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
                    Danh sách yêu cầu
                </li>
            </ol>
            <!-- End breadcrumb -->
        </div>
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="col-md-11">
                            <h3 class="card-title">
                                Danh sách yêu cầu của sinh viên
                            </h3>
                        </div>
                        <div class="col-md-1">
                            <button class="btn btn-lg btn-primary fa fa-refresh btn-3d" @click="reload()">
                                Tải lại
                            </button>
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
                        <div class="col-md-6">
                            <input type="text" class="form-control mt-2" v-model="query" placeholder="Tìm kiếm..." />
                        </div>
                        <div class="col-md-3">
                            <select class="form-control mt-2" v-model="value_status">
                                <option value="" disabled selected>
                                    Lọc theo trạng thái
                                </option>
                                <option disabled>
                                    ----------------------------------------
                                </option>
                                <option :value="0">
                                    Chờ xác nhận
                                </option>
                                <option :value="1">
                                    Đã chấp nhận
                                </option>
                                <option :value="2">
                                    Đã bị hủy
                                </option>
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
                                    <th class="w-5">
                                        <input
                                            type="checkbox"
                                            class="form-control"
                                            :disabled="empty()"
                                            @click="select()"
                                            v-model="selectAll"
                                        />
                                    </th>
                                    <th class="text-center text-white w-30">
                                        Tiêu đề
                                    </th>
                                    <th class="text-center text-white w-25">
                                        Sinh viên
                                    </th>
                                    <th class="text-center text-white w-15">
                                        Ngày đăng
                                    </th>
                                    <th class="text-center text-white w-15">
                                        Trạng thái
                                    </th>
                                    <th class="w-5"></th>
                                    <th class="w-5"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-show="requests.length" v-for="req in requests" :key="req.request_id">
                                    <td>
                                        <center>
                                            <input type="checkbox" :value="req.request_id" v-model="selected" />
                                        </center>
                                    </td>
                                    <td>
                                        <a href="javascript:void(0)" @click="detail(req)">
                                            <div v-if="req.request_title < 40">
                                                {{ req.request_title }}
                                            </div>
                                            <div v-else>
                                                {{ req.request_title.substring(0, 40) + '...' }}
                                            </div>
                                        </a>
                                    </td>
                                    <td>
                                        {{ req.student_code }} -
                                        {{ req.student_fullname }}
                                    </td>
                                    <td>{{ req.created_at | formatDate }}</td>
                                    <td class="td-styling text-center">
                                        <select
                                            class="form-control"
                                            v-model="req.request_status"
                                            :class="[
                                                {
                                                    'btn-outline-success': req.request_status == 1
                                                },
                                                {
                                                    'btn-outline-danger': req.request_status == 2
                                                }
                                            ]"
                                            @change="change($event, req)"
                                            name="procedure_require_status"
                                        >
                                            <option value="0" :hidden="req.request_status != 0">
                                                Chờ xác nhận
                                            </option>
                                            <option value="1" :hidden="req.request_status == 2">
                                                Đã chấp nhận
                                            </option>
                                            <option value="2" :hidden="req.request_status == 1">
                                                Đã bị hủy
                                            </option>
                                        </select>
                                    </td>
                                    <td style="text-align: center">
                                        <a
                                            href="javascript:void(0)"
                                            class="btn-3d btn btn-success btn-lg fa fa-reply"
                                            @click="show(req)"
                                        ></a>
                                    </td>
                                    <td>
                                        <button class="btn-3d btn btn-danger btn-lg fa fa-trash" @click="destroy(req.request_id)"></button>
                                    </td>
                                </tr>
                                <tr v-show="!requests.length">
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
                            @paginate="query === '' ? fetchRequests() : search()"
                        ></pagination>
                    </div>
                    <!-- table-responsive -->
                </div>
            </div>
            <!-- col end -->
        </div>

        <!-- Modal -->
        <div class="modal fade" id="ReasonModal" tabindex="-1" role="dialog" aria-labelledby="ReasonModalTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form @submit.prevent="reject()" @keydown="form.onKeydown($event)">
                    <div class="modal-content">
                        <div class="modal-header styling-modal-header-update">
                            <h5 class="modal-title" id="ReasonModalTitle">
                                Lý do từ chối
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <label>
                                Câu trả lời
                            </label>
                            <!-- <textarea
                                rows="5"
                                class="form-control resizenone"
                                name="request_reply"
                                v-model="form.request_reply"
                            ></textarea> -->
                            <vue-editor v-model="form.request_reply" :editorToolbar="customToolbar"></vue-editor>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn-3d btn btn-secondary" data-dismiss="modal">
                                Đóng
                            </button>
                            <button :disabled="form.busy" type="submit" class="btn btn-primary btn-3d">
                                Gửi
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- Modal end-->

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
                            Chi tiết yêu cầu sinh viên
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table row table-borderless w-100 m-0 border">
                            <tbody class="col-lg-12 p-0">
                                <tr class="row ml-1">
                                    <td class="col-md-6">
                                        Ngày gửi:
                                        <strong>
                                            {{ form.created_at | formatFullTime }}
                                        </strong>
                                    </td>
                                    <td class="col-md-6">
                                        Lớp học:
                                        <strong>
                                            {{ form.course_code }}
                                            -
                                            {{ form.class_name }}
                                        </strong>
                                    </td>
                                </tr>
                                <tr class="row ml-1">
                                    <td class="col-md-6">
                                        Mã số sinh viên:
                                        <strong>
                                            {{ form.student_code }}
                                        </strong>
                                    </td>
                                    <td class="col-md-6">
                                        Họ và tên sinh viên:
                                        <strong>
                                            {{ form.student_fullname }}
                                        </strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Tiêu đề:
                                        <strong>
                                            {{ form.request_title }}
                                        </strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="content-wrap">
                                        Nội dung:
                                        <strong>
                                            {{ form.request_content }}
                                        </strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Tệp đính kèm:
                                        <strong>
                                            <a
                                                :href="`../public/attachments/requests/${form.request_file}`"
                                                v-text="form.request_file"
                                                @click.prevent="downloadItem(form.request_file)"
                                            ></a>
                                        </strong>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-3d btn btn-secondary" data-dismiss="modal">
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
            id="RequestModal"
            tabindex="-1"
            role="dialog"
            aria-labelledby="RequestModalTitle"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-lg" role="document">
                <form @submit.prevent="reply()" @keydown="form.onKeydown($event)">
                    <span class="alert-danger" :form="form"></span>
                    <div class="modal-content">
                        <div class="modal-header styling-modal-header-update">
                            <h5 class="modal-title" id="RequestModalTitle">
                                Trả lời yêu cầu sinh viên
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <table class="table row table-borderless w-100 m-0 border">
                                <tbody class="col-lg-12 p-0">
                                    <tr class="row ml-1">
                                        <td class="col-md-6">
                                            Ngày gửi:
                                            <strong>
                                                {{ form.created_at | formatFullTime }}
                                            </strong>
                                        </td>
                                        <td class="col-md-6">
                                            Lớp học:
                                            <strong>
                                                {{ form.course_code }}
                                                -
                                                {{ form.class_name }}
                                            </strong>
                                        </td>
                                    </tr>
                                    <tr class="row ml-1">
                                        <td class="col-md-6">
                                            Mã số sinh viên:
                                            <strong>
                                                {{ form.student_code }}
                                            </strong>
                                        </td>
                                        <td class="col-md-6">
                                            Họ và tên sinh viên:
                                            <strong>
                                                {{ form.student_fullname }}
                                            </strong>
                                        </td>
                                    </tr>
                                    <br />
                                    <tr>
                                        <td>
                                            Tiêu đề:
                                            <strong>
                                                {{ form.request_title }}
                                            </strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="content-wrap">
                                            Nội dung:
                                            <strong>
                                                {{ form.request_content }}
                                            </strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Tệp đính kèm:
                                            <strong>
                                                <a
                                                    :href="`../public/attachments/requests/${form.request_file}`"
                                                    v-text="form.request_file"
                                                    @click.prevent="downloadItem(form.request_file)"
                                                ></a>
                                            </strong>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <label class="mt-3">
                                Trả lời
                            </label>
                            <!-- <textarea
                                rows="5"
                                v-model="form.request_reply"
                                type="text"
                                name="request_reply"
                                class="form-control"
                                placeholder="Nhập nội dung...."
                            ></textarea> -->
                            <vue-editor v-model="form.request_reply" :editorToolbar="customToolbar"></vue-editor>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn-3d btn btn-secondary" data-dismiss="modal">
                                Đóng
                            </button>
                            <button :disabled="form.busy" type="submit" class="btn-3d btn btn-primary background-update">
                                Gửi
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
import { VueEditor } from 'vue2-editor'
import 'vue-snotify/styles/material.css'
export default {
    data() {
        return {
            lecturer_id: this.$teacherId,
            requests: [],
            request_id: '',
            pagination: {
                current_page: 1
            },
            currentEntries: 5,
            showEntries: [5, 10, 25, 50],
            query: '',
            editMode: false,
            form: new Form({
                request_id: '',
                request_student: '',
                request_title: '',
                request_content: '',
                request_status: '',
                request_reply: '',
                request_file: '',
                student_fullname: '',
                student_code: '',
                created_at: '',
                updated_at: '',
                course_code: '',
                class_name: ''
            }),
            selected: [],
            selectAll: false,
            error: {},
            value_status: '',
            customToolbar: [
                [{ header: [false, 1, 2, 3, 4, 5, 6] }],
                [{ size: ['small', false, 'large', 'huge'] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ align: '' }, { align: 'center' }, { align: 'right' }, { align: 'justify' }],
                [{ header: 1 }, { header: 2 }],
                ['blockquote', 'code-block'],
                [{ list: 'ordered' }, { list: 'bullet' }, { list: 'check' }],
                [{ script: 'sub' }, { script: 'super' }],
                [{ indent: '-1' }, { indent: '+1' }],
                [{ color: [] }, { background: [] }],
                ['link', 'image', 'video', 'formula'],
                [{ direction: 'rtl' }]
            ]
        }
    },
    components: {
        VueEditor
    },
    watch: {
        currentEntries(number) {
            if (number === 5) {
                this.pagination = 1
                this.fetchRequests()
            } else {
                this.pagination = 1
                this.fetchRequests()
            }
        },
        query(keyword) {
            if (keyword === '') {
                this.fetchRequests()
            } else {
                this.pagination.current_page = 1
                this.search()
            }
        },
        value_status(value) {
            if (value === '') {
                this.fetchRequests()
            } else {
                this.query = ''
                this.pagination.current_page = 1
                this.filter()
            }
        }
    },
    mounted() {
        this.fetchRequests()
    },
    methods: {
        empty() {
            return this.requests.length < 1
        },
        fetchRequests(page_url) {
            let vm = this
            page_url = `../../api/admin/request-sv/yeu-cau-sinh-vien/showdata/${this.lecturer_id}/${this.currentEntries}?page=${this.pagination.current_page}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.requests = res.data
                    this.pagination = res.meta
                })
                .catch(err => console.log(err))
        },
        search(page_url) {
            let vm = this
            page_url = `../../api/admin/request-sv/yeu-cau-sinh-vien/search/${this.lecturer_id}/${this.query}/${this.currentEntries}?page=${this.pagination.current_page}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.requests = res.data
                    this.pagination = res.meta
                })
                .catch(err => console.log(err))
        },
        change(event, req) {
            if (event.target.value == 1) {
                this.form.request_status = event.target.value
                this.form
                    .patch(`../../api/admin/request-sv/yeu-cau-sinh-vien/accept/${req.request_id}`)
                    .then(res => {
                        this.fetchRequests()
                        this.$snotify.success('Đã thay đổi trạng thái')
                    })
                    .catch(err => console.log(err))
            } else if (event.target.value == 2) {
                this.form.request_status = event.target.value
                this.form.reset()
                this.form.clear()
                this.form.fill(req)
                $('#ReasonModal').modal('show')
            }
        },
        reject() {
            console.log(this.form.request_id)
            this.form
                .put(`../../api/admin/request-sv/yeu-cau-sinh-vien/reject/${this.form.request_id}`)
                .then(res => {
                    $('#ReasonModal').modal('hide')
                    this.fetchRequests()
                    this.$snotify.success('Đã thay đổi trạng thái')
                })
                .catch(err => console.log(err))
        },
        destroy(request_id) {
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
                                .delete(`../../api/admin/request-sv/yeu-cau-sinh-vien/${request_id}`)
                                .then(res => {
                                    this.$snotify.success('Đã xóa!')
                                    this.fetchRequests()
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
                                .post('../../api/admin/request-sv/yeu-cau-sinh-vien/destroyall', { req: this.selected })
                                .then(res => {
                                    this.$snotify.success('Đã xóa!')
                                    this.fetchRequests()
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
                for (let i in this.requests) {
                    this.selected.push(this.requests[i].request_id)
                }
            }
        },
        reload() {
            this.fetchRequests()
            this.query = ''
            this.value_status = ''
            this.form.request_status = ''
        },
        filter(page_url) {
            let vm = this
            page_url = `../../api/admin/request-sv/yeu-cau-sinh-vien/filter/${this.lecturer_id}/${this.value_status}/${this.currentEntries}?page=${this.pagination.current_page}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.requests = res.data
                    this.pagination = res.meta
                })
                .catch(err => console.log(err))
        },
        detail(reql, page_url) {
            let vm = this
            page_url = `../../api/admin/request-sv/yeu-cau-sinh-vien/detail/${reql.request_id}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.form.fill(res.data[0])
                    $('#DetailModal').modal('show')
                    console.log(res.data)
                })
                .catch(err => console.log(err))
        },
        show(req) {
            this.form.reset()
            this.form.clear()
            this.form.fill(req)
            $('#RequestModal').modal('show')
        },
        reply() {
            if (this.form.request_reply == null) {
                $('#RequestModal').modal('hide')
            } else {
                this.form
                    .put(`../../api/admin/request-sv/yeu-cau-sinh-vien/${this.form.request_id}`)
                    .then(res => {
                        this.fetchRequests()
                        $('#RequestModal').modal('hide')
                        if (this.form.successful) {
                            this.$snotify.success('Đã gửi câu trả lời!')
                        } else {
                            this.$snotify.error('Không thể gửi')
                        }
                    })
                    .catch(err => console.log(err))
            }
        },
        downloadItem(request_file) {
            axios
                .get(`../public/attachments/requests/${request_file}`, { responseType: 'blob' })
                .then(response => {
                    const blob = new Blob([response.data], { type: 'application/pdf' })
                    const link = document.createElement('a')
                    link.href = URL.createObjectURL(blob)
                    link.download = request_file
                    link.click()
                    URL.revokeObjectURL(link.href)
                })
                .catch(console.error)
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
.styling-strong {
    word-wrap: break-word;
    white-space: pre-line;
}
.btn-3d {
    border-bottom: 3px solid #6c757db0;
    border-right: 3px solid #6c757db0;
}
.resizenone {
    resize: none;
}
.content-wrap {
    overflow-wrap: anywhere;
}
</style>
