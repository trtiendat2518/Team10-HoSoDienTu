<template>
    <div class="container">
        <!-- SECTION BANNER -->
        <div class="section-banner">
            <img class="section-banner-icon" :src="`../public/student/img/banner/newsfeed-icon.png`" alt="newsfeed-icon" />
            <p class="section-banner-title">Thông báo</p>
        </div>
        <!-- /SECTION BANNER -->

        <!-- GRID -->
        <div class="grid">
            <div class="notification-box-list">
                <div class="notification-box" v-for="notification in notiprocedures" :key="notification.notification_id">
                    <div class="user-status notification">
                        <p class="user-status-title">
                            <i class="fa fa-hand-o-right"></i>
                            Yêu cầu thủ tục <strong>{{ notification.procedure_title }}</strong> của bạn
                            <strong v-if="notification.procedure_require_status == 1">đang được xử lý</strong>
                            <strong v-else-if="notification.procedure_require_status == 2">đã hoàn tất</strong>
                            <strong v-else-if="notification.procedure_require_status == 3">đã bị huỷ</strong>
                        </p>
                        <p class="user-status-timestamp">{{ notification.notification_date | formatFullTime }}</p>

                        <div class="user-status-icon">
                            <svg class="icon-minus-small">
                                <use xlink:href="#svg-minus-small"></use>
                            </svg>
                        </div>
                    </div>
                </div>

                <div
                    class="notification-box"
                    v-for="notification in notirequests"
                    :key="notification.notification_id"
                    :class="{ 'none-read': notification.notification_status == 0 }"
                    @click="detail(notification.notification_title, notification.notification_id)"
                >
                    <div class="user-status notification">
                        <p class="user-status-title">
                            <i class="fa fa-hand-o-right"></i>
                            Yêu cầu <strong>{{ notification.request_title }}</strong> của bạn
                            <strong v-if="notification.request_status == 1">đã được chấp nhận</strong>
                            <strong v-else-if="notification.request_status == 2">đã bị từ chối</strong>
                            <span v-show="notification.request_reply != null">và đã trả lời yêu cầu</span>
                        </p>
                        <p class="user-status-timestamp">{{ notification.notification_date | formatFullTime }}</p>

                        <div class="user-status-icon">
                            <svg class="icon-minus-small">
                                <use xlink:href="#svg-minus-small"></use>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /GRID -->
    </div>
</template>

<script>
export default {
    data() {
        return {
            student_id: this.$studentId,
            notiprocedures: [],
            notirequests: []
        }
    },
    mounted() {
        this.fetchNotiProcedure()
        this.fetchNotiRequest()
    },
    methods: {
        fetchNotiProcedure(page_url) {
            page_url = `../../api/student/notification/thong-bao/thu-tuc/${this.student_id}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.notiprocedures = res.data
                })
                .catch(err => console.log(err))
        },
        fetchNotiRequest(page_url) {
            page_url = `../../api/student/notification/thong-bao/yeu-cau/${this.student_id}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.notirequests = res.data
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
        read(notification_id) {
            axios
                .put(`../../api/admin/notification/thong-bao/${notification_id}`)
                .then(res => {
                    this.fetchNotification()
                    this.fetchNoneRead()
                })
                .catch(err => console.log(err))
        },
        detail(request_id, notification_id) {
            this.read(notification_id)
            this.$router.push({ name: 'requestdetail', params: { idReq: request_id } })
        }
    }
}
</script>

<style scoped>
.user-status-title {
    font-size: 16px !important;
}
.user-status {
    padding: 0px !important;
}
.notification-box {
    border-bottom: 3px solid #6c757d;
    border-right: 3px solid #6c757d;
    cursor: pointer;
    background: linear-gradient(360deg, #faa8af63 0%, #fcfcfd 40%);
}
.none-read {
    border-bottom: 3px solid #6c757d;
    border-right: 3px solid #6c757d;
    cursor: pointer;
    background: linear-gradient(360deg, #faa8af63 0%, #dadaf5 40%);
}
</style>
