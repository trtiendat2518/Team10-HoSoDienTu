<template>
    <div>
        <div class="page-header">
            <ol class="breadcrumb">
                <!-- breadcrumb -->
                <li class="breadcrumb-item">
                    <router-link tag="a" :to="{ name: 'dashboard' }">Dashboard</router-link>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Yêu cầu thi lần 2</li>
            </ol>
            <!-- End breadcrumb -->
        </div>

        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="col-md-11">
                            <h3 class="card-title">Danh sách yêu cầu</h3>
                        </div>
                        <div class="col-md-1">
                            <button class="btn btn-lg btn-primary fa fa-refresh btn-3d" @click="reload()">Tải lại</button>
                        </div>
                    </div>

                    <div class="row ml-2 mr-2">
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
                                    <th class="text-white w-15">Mã môn học</th>
                                    <th class="text-white w-40">Tên môn học</th>
                                    <th class="text-white w-15">Khoá học</th>
                                    <th class="text-white w-15">Chuyên ngành</th>
                                    <th class="text-white w-15">Số lượng</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-show="requests.length" v-for="request in requests" :key="request.exam_second_id">
                                    <td>
                                        {{ request.subject_code }}
                                    </td>
                                    <td>{{ request.subject_name }}</td>
                                    <td>{{ request.course_name }}</td>
                                    <td>{{ request.major_name }}</td>
                                    <td>{{ request.exam_second_quantity }}</td>
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
    </div>
</template>

<script>
export default {
    data() {
        return {
            lecturer_id: this.$facultyId,
            requests: [],
            showEntries: [5, 10, 25, 50],
            pagination: {
                current_page: 1
            },
            currentEntries: 5,
            query: ''
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
        }
    },
    methods: {
        fetchRequests(page_url) {
            page_url = `../../api/admin/exam-second/dang-ky-thi-lan-2/show-data/${this.lecturer_id}/${this.currentEntries}?page=${this.pagination.current_page}`
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
            page_url = `../../api/admin/exam-second/dang-ky-thi-lan-2/search-data/${this.lecturer_id}/${this.query}/${this.currentEntries}?page=${this.pagination.current_page}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.requests = res.data
                    this.pagination = res.meta
                })
                .catch(err => console.log(err))
        },
        reload() {
            this.fetchRequests()
        }
    }
}
</script>

<style></style>
