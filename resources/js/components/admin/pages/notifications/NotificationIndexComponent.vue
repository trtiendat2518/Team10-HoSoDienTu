<template>
    <div>
        <vue-snotify></vue-snotify>
        <div class="page-header">
            <ol class="breadcrumb">
                <!-- breadcrumb -->
                <li class="breadcrumb-item">
                    <router-link tag="a" :to="{ name: 'dashboard' }">Dashboard</router-link>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Tất cả thông báo</li>
            </ol>
            <!-- End breadcrumb -->
        </div>

        <div class="row">
            <div class="card overflow-hidden">
                <div class="card-header custom-header">
                    <div>
                        <h3 class="card-title">Tất cả thông báo</h3>
                    </div>
                    <div class="card-options">
                        <a href="javascript:void(0)" class="mr-4 text-default" @click="readAll()">
                            <span>Đọc tất cả</span>
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <div
                            class="list-group-item d-flex  align-items-center"
                            v-for="notification in notifications"
                            :key="notification.notification_id"
                            :class="{ 'none-read': notification.notification_status == 0 }"
                        >
                            <div class="mr-2">
                                <div v-show="admin_id != null" class="notifyimg bg-blue">
                                    <i class="fa fa-file-text fa-styling"></i>
                                </div>
                                <div v-show="lecturer_id != null" class="notifyimg bg-red">
                                    <i class="fa fa-calendar-times-o fa-calendar-times-o"></i>
                                </div>
                                <div v-show="formteacher_id != null" class="notifyimg bg-green">
                                    <i class="fa fa-sitemap fa-sitemap"></i>
                                </div>
                            </div>
                            <div @click="detail(notification.notification_id)">
                                <div class="font-styling">
                                    <span v-show="admin_id != null">
                                        <strong>{{ notification.student_fullname }}</strong> đã gửi yêu cầu thủ tục:
                                        <strong>{{ notification.procedure_title }}</strong>
                                    </span>
                                    <span v-show="lecturer_id != null">
                                        <strong>Có {{ notification.exam_second_quantity }} sinh viên</strong> đã đăng ký thi lần 2 môn:
                                        <strong>{{ notification.subject_name }}</strong>
                                    </span>
                                    <span v-show="formteacher_id != null">
                                        <strong>{{ notification.student_fullname }}</strong> đã gửi yêu cầu:
                                        <strong>{{ notification.request_title }}</strong>
                                    </span>
                                </div>
                            </div>
                            <div class="ml-auto">
                                <a
                                    href="javascript:void(0)"
                                    class="btn btn-sm btn-light"
                                    title="Đánh đấu đã đọc"
                                    @click="read(notification.notification_id)"
                                >
                                    <i class="fa fa-circle-o"></i>
                                </a>
                                <a
                                    href="javascript:void(0)"
                                    class="btn btn-sm btn-light"
                                    title="Xoá thông báo"
                                    @click="destroy(notification.notification_id)"
                                >
                                    <i class="fa fa-times"></i>
                                </a>
                            </div>
                        </div>
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
            admin_id: this.$adminCode,
            lecturer_id: this.$facultyId,
            formteacher_id: this.$teacherId,
            notifications: [],
            none_read: []
        }
    },
    mounted() {
        this.fetchNotification()
        this.fetchNoneRead()
    },
    methods: {
        fetchNotification(page_url) {
            if (this.admin_id != null) {
                page_url = `../../api/admin/notification/thong-bao/quan-tri-vien/tat-ca`
                fetch(page_url)
                    .then(res => res.json())
                    .then(res => {
                        this.notifications = res.data
                    })
                    .catch(err => console.log(err))
            } else if (this.lecturer_id != null) {
                page_url = `../../api/admin/notification/thong-bao/bcn-khoa/tat-ca`
                fetch(page_url)
                    .then(res => res.json())
                    .then(res => {
                        this.notifications = res.data
                    })
                    .catch(err => console.log(err))
            } else if (this.formteacher_id != null) {
                page_url = `../../api/admin/notification/thong-bao/gvcn/tat-ca/${this.formteacher_id}`
                fetch(page_url)
                    .then(res => res.json())
                    .then(res => {
                        this.notifications = res.data
                    })
                    .catch(err => console.log(err))
            }
        },
        fetchNoneRead(page_url) {
            if (this.admin_id != null) {
                page_url = `../../api/admin/notification/thong-bao/quan-tri-vien/chua-doc`
                fetch(page_url)
                    .then(res => res.json())
                    .then(res => {
                        this.none_read = res.data
                    })
                    .catch(err => console.log(err))
            } else if (this.lecturer_id != null) {
                page_url = `../../api/admin/notification/thong-bao/bcn-khoa/chua-doc/${this.lecturer_id}`
                fetch(page_url)
                    .then(res => res.json())
                    .then(res => {
                        this.none_read = res.data
                    })
                    .catch(err => console.log(err))
            } else if (this.formteacher_id != null) {
                page_url = `../../api/admin/notification/thong-bao/gvcn/chua-doc/${this.formteacher_id}`
                fetch(page_url)
                    .then(res => res.json())
                    .then(res => {
                        this.none_read = res.data
                    })
                    .catch(err => console.log(err))
            }
        },
        readAll() {
            if (this.admin_id != null) {
                axios
                    .post(`../../api/admin/notification/thong-bao/quan-tri-vien/doc-tat-ca`)
                    .then(res => {
                        this.fetchNotification()
                        this.fetchNoneRead()
                    })
                    .catch(err => console.log(err))
            } else if (this.lecturer_id != null) {
                axios
                    .post(`../../api/admin/notification/thong-bao/bcn-khoa/doc-tat-ca/${this.lecturer_id}`)
                    .then(res => {
                        this.fetchNotification()
                        this.fetchNoneRead()
                    })
                    .catch(err => console.log(err))
            } else if (this.formteacher_id != null) {
                axios
                    .post(`../../api/admin/notification/thong-bao/gvcn/doc-tat-ca/${this.formteacher_id}`)
                    .then(res => {
                        this.fetchNotification()
                        this.fetchNoneRead()
                    })
                    .catch(err => console.log(err))
            }
        },
        read(notification_id) {
            axios
                .put(`../../api/admin/notification/thong-bao/${notification_id}`)
                .then(res => {
                    this.fetchNotification()
                    this.fetchNoneRead()
                })
                .catch(err => console.log(err))
        },
        destroy(notification_id) {
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
                                .delete(`../../api/admin/notification/thong-bao/${notification_id}`)
                                .then(res => {
                                    this.$snotify.success('Đã xóa!')
                                    this.fetchNotification()
                                    this.fetchNoneRead()
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
        detail(notification_id) {
            this.read(notification_id)
            if (this.admin_id != null) {
            } else if (this.lecturer_id != null) {
                this.$router.push({
                    name: 'examndmanageindex'
                })
            } else if (this.formteacher_id != null) {
                this.$router.push({
                    name: 'requeststudentindex'
                })
            }
        }
    }
}
</script>

<style scoped>
.click-noti {
    background-color: #dee2e6;
    color: #e66c2c;
    border-bottom-left-radius: 10px;
    border-bottom-right-radius: 10px;
}
.text-muted {
    color: #495057 !important;
}
.fa-styling {
    margin-top: 13;
}
.fa-sitemap {
    margin-top: 13;
}
.fa-calendar-times-o {
    margin-top: 13;
}
.none-read {
    background-color: #c9d0e5;
}
.list-group-item:hover {
    background-color: #e6e8ee;
    cursor: pointer;
}
.font-styling {
    color: black;
}
</style>
