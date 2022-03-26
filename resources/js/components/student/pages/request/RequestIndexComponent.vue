<template>
    <div class="container">
        <div class="section-banner">
            <img class="section-banner-icon" :src="`../public/student/img/banner/newsfeed-icon.png`" alt="newsfeed-icon" />
            <p class="section-banner-title">Danh sách yêu cầu đã gửi</p>
        </div>

        <div class="grid">
            <div class="row">
                <div class="col-md-2">
                    <router-link tag="button" class="btn btn-primary" :to="{ name: 'requestsend' }">
                        <i class="fa fa-arrow-left" aria-hidden="true"></i>
                        Quay lại
                    </router-link>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="col-md-12">
                                <h3 class="card-title">
                                    Danh sách đã yêu cầu
                                </h3>
                            </div>
                        </div>

                        <div class="row ml-2 mr-2">
                            <div class="col-md-6">
                                <input type="text" class="form-control style-input mt-2" v-model="query" placeholder="Tìm kiếm..." />
                            </div>
                            <div class="col-md-3">
                                <select class="select form-control form-select mt-2" v-model="value_status">
                                    <option value="">
                                        Tất cả trạng thái
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
                            <div class="col-md-3">
                                <div class="between:flex bottom:margin-3 mt-2">
                                    <div class="center:flex-items">
                                        <select class="select form-control form-select" v-model="currentEntries">
                                            <option v-for="entry in showEntries" :key="entry" :value="entry"
                                                >Hiển thị {{ entry }} trên 1 trang
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table card-table table-vcenter text-nowrap table-nowrap">
                                <thead class="blue-background text-white">
                                    <tr>
                                        <th class="text-center text-white" width="55%">
                                            Tiêu đề
                                        </th>
                                        <th class="text-center text-white w-15" width="15%">
                                            Ngày yêu cầu
                                        </th>
                                        <th class="text-center text-white w-15" width="15%">
                                            Trạng thái
                                        </th>
                                        <th class="w-5" width="5%"></th>
                                        <th class="w-5" width="5%"></th>
                                        <th class="w-5"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-show="requests.length" v-for="req in requests" :key="req.request_id">
                                        <td>
                                            <div v-if="req.request_title < 100">
                                                {{ req.request_title }}
                                            </div>
                                            <div v-else>
                                                {{ req.request_title.substring(0, 100) + '...' }}
                                            </div>
                                        </td>
                                        <td class="text-center">{{ req.created_at | formatFullTime }}</td>
                                        <td class="td-styling text-center">
                                            <div v-if="req.request_status == 0">Chờ xác nhận</div>
                                            <div v-else-if="req.request_status == 1">Đã chấp nhận</div>
                                            <div v-else-if="req.request_status == 2">Đã bị hủy</div>
                                        </td>
                                        <td style="text-align: center">
                                            <router-link
                                                :disabled="req.request_status != 0"
                                                class="btn-3d btn btn-success btn-lg fa fa-pencil-square-o"
                                                tag="button"
                                                :to="{ name: 'requestupdate', params: { idReq: req.request_id } }"
                                            ></router-link>
                                        </td>
                                        <td>
                                            <button
                                                class="btn-3d btn btn-danger btn-lg fa fa-trash"
                                                :disabled="req.request_status != 0"
                                                @click="destroy(req.request_id)"
                                            ></button>
                                        </td>
                                        <td>
                                            <router-link
                                                tag="button"
                                                class="btn-3d btn btn-info btn-lg fa fa-eye"
                                                :to="{ name: 'requestdetail', params: { idReq: req.request_id } }"
                                            >
                                            </router-link>
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
                        </div>
                        <!-- table-responsive -->
                    </div>
                    <pagination
                        class="mt-2"
                        v-if="pagination.last_page > 1"
                        :pagination="pagination"
                        :offset="5"
                        @paginate="query === '' ? fetchRequests() : search()"
                    ></pagination>
                </div>
                <!-- col end -->
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios'
export default {
    data() {
        return {
            student_id: this.$studentId,
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
    mounted() {
        this.fetchRequests()
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
    methods: {
        fetchRequests(page_url) {
            let vm = this
            page_url = `../../api/student/request-to-ft/gui-yeu-cau/showdata/${this.student_id}/${this.currentEntries}?page=${this.pagination.current_page}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.requests = res.data
                    this.pagination = res.meta
                })
                .catch(err => console.log(err))
        },
        filter(page_url) {
            let vm = this
            page_url = `../../api/student/request-to-ft/gui-yeu-cau/filter/${this.student_id}/${this.value_status}/${this.currentEntries}?page=${this.pagination.current_page}`
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
            page_url = `../../api/student/request-to-ft/gui-yeu-cau/search/${this.student_id}/${this.query}/${this.currentEntries}?page=${this.pagination.current_page}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.requests = res.data
                    this.pagination = res.meta
                })
                .catch(err => console.log(err))
        },
        destroy(request_id) {
            this.$swal({
                title: 'Bạn có chắc chắn xoá?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Xoá !',
                cancelButtonText: 'Quay lại !'
            }).then(result => {
                if (result.isConfirmed) {
                    axios
                        .delete(`../../api/student/request-to-ft/gui-yeu-cau/${request_id}`)
                        .then(res => {
                            this.fetchRequests()
                            this.$swal({
                                title: 'Xoá thành công!',
                                icon: 'success',
                                confirmButtonText: 'OK!',
                                timer: 3500
                            })
                        })
                        .catch(err => console.log(err))
                }
            })
        }
    }
}
</script>

<style scoped>
.style-input {
    border-radius: 0.25rem;
    height: 48px;
}
</style>
