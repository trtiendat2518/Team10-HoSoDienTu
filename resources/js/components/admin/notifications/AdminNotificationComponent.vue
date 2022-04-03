<template>
    <div>
        <div class="header-notify" :class="{ 'click-noti': noti == true }">
            <div class="row">
                <div class="col-md-3" :class="{ 'col-md-12': noti == false }">
                    <span class="nav-link icon" aria-expanded="false" @click="noti = !noti">
                        <i class="fe fe-bell "></i>
                        <span class="pulse bg-success" v-show="none_read.length > 0"></span>
                    </span>
                </div>
                <div class="col-md-9 " v-show="noti == true">
                    <h5 class="nav-link name float-right" @click="readAll()">
                        <strong>Đọc tất cả </strong>
                        <span v-show="none_read.length > 0"> ({{ none_read.length }})</span>
                    </h5>
                </div>
            </div>

            <div class="" v-show="noti == true">
                <div v-show="notifications.length < 0" class="text-center alert alert-warning">Chưa có thông báo</div>
                <a
                    href="javascript:void(0)"
                    class="dropdown-item d-flex pb-3"
                    v-for="notification in notifications"
                    :key="notification.notification_id"
                    :class="{ 'none-read': notification.notification_status == 0 }"
                    @click="detail(notification.notification_id)"
                >
                    <div class="notifyimg bg-blue">
                        <i class="fa fa-file-text fa-styling"></i>
                    </div>
                    <div>
                        {{ notification.student_fullname }} đã gửi yêu cầu thủ tục:
                        <strong>{{ notification.procedure_title.substring(0, 30) + '...' }}</strong>
                        <div class="small text-muted">{{ timeFormat(notification.notification_date) }}</div>
                    </div>
                </a>
                <div class="dropdown-divider"></div>
                <a v-show="notifications.length > 0" href="/admin#/thong-bao/" class="dropdown-item text-center" @click="viewAll()">
                    Xem tất cả thông báo
                </a>
            </div>
        </div>
        <!-- notifications -->
    </div>
</template>

<script>
export default {
    data() {
        return {
            noti: false,
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
            page_url = `../../api/admin/notification/thong-bao/quan-tri-vien`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.notifications = res.data
                })
                .catch(err => console.log(err))
        },
        fetchNoneRead(page_url) {
            page_url = `../../api/admin/notification/thong-bao/quan-tri-vien/chua-doc`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.none_read = res.data
                })
                .catch(err => console.log(err))
        },
        timeFormat(time) {
            switch (typeof time) {
                case 'number':
                    break
                case 'string':
                    time = +new Date(time)
                    break
                case 'object':
                    if (time.constructor === Date) time = time.getTime()
                    break
                default:
                    time = +new Date()
            }
            var time_formats = [
                [60, 'Mới đây', 1], // 60
                [120, '1 phút trước', '1 phút trước'], // 60*2
                [3600, 'phút', 60], // 60*60, 60
                [7200, '1 tiếng trước', '1 tiếng trước'], // 60*60*2
                [86400, 'tiếng', 3600], // 60*60*24, 60*60
                [172800, 'Hôm qua', 'Tomorrow'], // 60*60*24*2
                [604800, 'ngày', 86400], // 60*60*24*7, 60*60*24
                [1209600, 'Tuần trước', 'Next week'], // 60*60*24*7*4*2
                [2419200, 'tuần', 604800], // 60*60*24*7*4, 60*60*24*7
                [4838400, 'Tháng trước', 'Next month'], // 60*60*24*7*4*2
                [29030400, 'tháng', 2419200], // 60*60*24*7*4*12, 60*60*24*7*4
                [58060800, 'Năm trước', 'Next year'], // 60*60*24*7*4*12*2
                [2903040000, 'năm,', 29030400], // 60*60*24*7*4*12*100, 60*60*24*7*4*12
                [5806080000, 'Thế kỉ trước', 'Next century'], // 60*60*24*7*4*12*100*2
                [58060800000, 'thế kỉ', 2903040000] // 60*60*24*7*4*12*100*20, 60*60*24*7*4*12*100
            ]
            var seconds = (+new Date() - time) / 1000,
                token = 'trước',
                list_choice = 1

            if (seconds == 0) {
                return 'Mới đây'
            }
            if (seconds < 0) {
                seconds = Math.abs(seconds)
                token = 'Từ giờ'
                list_choice = 2
            }
            var i = 0,
                format
            while ((format = time_formats[i++]))
                if (seconds < format[0]) {
                    if (typeof format[2] == 'string') return format[list_choice]
                    else return Math.floor(seconds / format[2]) + ' ' + format[1] + ' ' + token
                }
        },
        readAll() {
            axios
                .post(`../../api/admin/notification/thong-bao/quan-tri-vien/doc-tat-ca`)
                .then(res => {
                    this.fetchNotification()
                    this.fetchNoneRead()
                })
                .catch(err => console.log(err))
        },
        viewAll() {
            this.noti = false
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
        detail(notification_id) {
            fetch(`../../api/admin/notification/thong-bao/${notification_id}`)
                .then(res => res.json())
                .then(res => {
                    this.noti = false
                    this.read(notification_id)
                    this.$router.push({
                        name: 'procedurerequiredetail',
                        params: { idRProcedure: res.data[0].procedure_require_id }
                    })
                })
                .catch(err => console.log(err))
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
.none-read {
    background-color: #c9d0e5;
}
.none-read:hover {
    background-color: #e6e8ee;
}
</style>
