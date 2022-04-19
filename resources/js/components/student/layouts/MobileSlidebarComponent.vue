<template>
    <!-- MOBILEMENU TRIGGER -->
    <div>
        <!-- BURGER ICON -->
        <div id="buttonSlidebar" class="burger-icon inverted" @click="toggle = !toggle">
            <!-- BURGER ICON BAR -->
            <div class="burger-icon-bar"></div>
            <!-- /BURGER ICON BAR -->

            <!-- BURGER ICON BAR -->
            <div class="burger-icon-bar"></div>
            <!-- /BURGER ICON BAR -->

            <!-- BURGER ICON BAR -->
            <div class="burger-icon-bar"></div>
            <!-- /BURGER ICON BAR -->
        </div>
        <!-- /BURGER ICON -->

        <!-- /MOBILEMENU TRIGGER -->
        <nav id="navigation-widget-mobile" class="navigation-widget navigation-widget-mobile sidebar right" v-show="toggle == true">
            <!-- NAVIGATION WIDGET CLOSE BUTTON -->
            <div class="navigation-widget-close-button mb-3" @click="toggle = false">
                <!-- NAVIGATION WIDGET CLOSE BUTTON ICON -->
                <svg class="navigation-widget-close-button-icon icon-back-arrow">
                    <use xlink:href="#svg-back-arrow"></use>
                </svg>
                <!-- NAVIGATION WIDGET CLOSE BUTTON ICON -->
            </div>
            <!-- /NAVIGATION WIDGET CLOSE BUTTON -->

            <div class="styling">
                <router-link tag="a" to="/thong-tin-ca-nhan-sinh-vien">
                    <div class="user-short-description">
                        <div class="user-avatar-content">
                            <img :src="`../public/avatar/student/${student_avatar}`" class="avatar-styling" alt="profile" />
                        </div>

                        <p class="user-short-description-title mt-3">
                            {{ student_fullname }}
                        </p>

                        <p class="user-short-description-text">
                            {{ student_email }}
                        </p>
                    </div>
                </router-link>
            </div>

            <!-- MENU -->
            <ul class="menu">
                <!-- MENU ITEM -->
                <li class="menu-item">
                    <!-- MENU ITEM LINK -->
                    <a class="menu-item-link" href="/">
                        <!-- MENU ITEM LINK ICON -->
                        <svg class="menu-item-link-icon icon-grid">
                            <use xlink:href="#svg-grid"></use>
                        </svg>
                        <!-- /MENU ITEM LINK ICON -->
                        Trang chủ
                    </a>
                    <!-- /MENU ITEM LINK -->
                </li>
                <!-- /MENU ITEM -->

                <!-- MENU ITEM -->
                <li class="menu-item">
                    <!-- MENU ITEM LINK -->
                    <a class="menu-item-link" href="/home#/thong-bao-chung">
                        <!-- MENU ITEM LINK ICON -->
                        <svg class="menu-item-link-icon icon-public">
                            <use xlink:href="#svg-public"></use>
                        </svg>
                        <!-- /MENU ITEM LINK ICON -->
                        Thông báo chung
                    </a>
                    <!-- /MENU ITEM LINK -->
                </li>
                <!-- /MENU ITEM -->

                <p class="navigation-widget-section-title mb-3">Thông tin cá nhân</p>

                <!-- MENU ITEM -->
                <li class="menu-item">
                    <!-- MENU ITEM LINK -->
                    <router-link tag="a" class="menu-item-link" to="/thong-tin-ca-nhan-sinh-vien" active-class="active">
                        <svg class="menu-item-link-icon icon-members">
                            <use xlink:href="#svg-members"></use>
                        </svg>
                        Hồ sơ cá nhân
                    </router-link>
                    <!-- /MENU ITEM LINK -->
                </li>
                <!-- /MENU ITEM -->

                <!-- MENU ITEM -->
                <li class="menu-item">
                    <!-- MENU ITEM LINK -->
                    <router-link tag="a" class="menu-item-link" to="/" active-class="active" exact>
                        <svg class="menu-item-link-icon icon-notification">
                            <use xlink:href="#svg-notification"></use>
                        </svg>
                        Thông báo
                    </router-link>
                    <!-- /MENU ITEM LINK -->
                </li>
                <!-- /MENU ITEM -->

                <!-- NAVIGATION WIDGET SECTION TITLE -->
                <p class="navigation-widget-section-title mb-3 mt-5">Tra cứu thông tin</p>
                <!-- /NAVIGATION WIDGET SECTION TITLE -->

                <!-- MENU ITEM -->
                <li class="menu-item">
                    <!-- MENU ITEM LINK -->
                    <router-link tag="a" class="menu-item-link" to="/chuong-trinh-dao-tao-sv" active-class="active">
                        <svg class="menu-item-link-icon icon-newsfeed">
                            <use xlink:href="#svg-newsfeed"></use>
                        </svg>
                        Chương trình đào tạo
                    </router-link>
                    <!-- /MENU ITEM LINK -->
                </li>
                <!-- /MENU ITEM -->

                <!-- MENU ITEM -->
                <li class="menu-item">
                    <!-- MENU ITEM LINK -->
                    <router-link tag="a" class="menu-item-link" to="/lich-hoc" active-class="active">
                        <svg class="menu-item-link-icon icon-events-monthly">
                            <use xlink:href="#svg-events-monthly"></use>
                        </svg>
                        Lịch học
                    </router-link>
                    <!-- /MENU ITEM LINK -->
                </li>
                <!-- /MENU ITEM -->

                <!-- MENU ITEM -->
                <li class="menu-item">
                    <!-- MENU ITEM LINK -->
                    <router-link tag="a" class="menu-item-link" to="/lich-thi" active-class="active">
                        <svg class="menu-item-link-icon icon-events-weekly">
                            <use xlink:href="#svg-events-weekly"></use>
                        </svg>
                        Lịch thi
                    </router-link>
                    <!-- /MENU ITEM LINK -->
                </li>
                <!-- /MENU ITEM -->

                <!-- MENU ITEM -->
                <li class="menu-item">
                    <!-- MENU ITEM LINK -->
                    <router-link tag="a" class="menu-item-link" to="/ket-qua-hoc-tap" active-class="active">
                        <svg class="menu-item-link-icon icon-badges">
                            <use xlink:href="#svg-badges"></use>
                        </svg>
                        Kết quả học tập
                    </router-link>
                    <!-- /MENU ITEM LINK -->
                </li>
                <!-- /MENU ITEM -->

                <!-- MENU ITEM -->
                <li class="menu-item">
                    <!-- MENU ITEM LINK -->
                    <router-link tag="a" class="menu-item-link" to="/tong-hop-hoc-phi" active-class="active">
                        <svg class="menu-item-link-icon icon-wallet">
                            <use xlink:href="#svg-wallet"></use>
                        </svg>
                        Tổng hợp học phí
                    </router-link>
                    <!-- /MENU ITEM LINK -->
                </li>
                <!-- /MENU ITEM -->

                <!-- NAVIGATION WIDGET SECTION TITLE -->
                <p class="navigation-widget-section-title mb-3 mt-5">Chức năng trực tuyến</p>
                <!-- /NAVIGATION WIDGET SECTION TITLE -->

                <!-- MENU ITEM -->
                <li class="menu-item">
                    <!-- MENU ITEM LINK -->
                    <router-link tag="a" class="menu-item-link" to="/ke-hoach-hoc-tap" active-class="active">
                        <svg class="menu-item-link-icon icon-clock">
                            <use xlink:href="#svg-clock"></use>
                        </svg>
                        Đăng ký kế hoạch học tập
                    </router-link>
                    <!-- /MENU ITEM LINK -->
                </li>
                <!-- /MENU ITEM -->

                <!-- MENU ITEM -->
                <li class="menu-item">
                    <!-- MENU ITEM LINK -->
                    <router-link tag="a" class="menu-item-link" to="/dang-ky-mon-hoc" active-class="active">
                        <svg class="menu-item-link-icon icon-list-grid-view">
                            <use xlink:href="#svg-list-grid-view"></use>
                        </svg>
                        Đăng ký môn học
                    </router-link>
                    <!-- /MENU ITEM LINK -->
                </li>
                <!-- /MENU ITEM -->

                <!-- MENU ITEM -->
                <li class="menu-item">
                    <!-- MENU ITEM LINK -->
                    <router-link tag="a" class="menu-item-link" to="/dang-ky-thi-lan-2" active-class="active">
                        <svg class="menu-item-link-icon icon-forums">
                            <use xlink:href="#svg-forums"></use>
                        </svg>
                        Đăng ký thi lần 2
                    </router-link>
                    <!-- /MENU ITEM LINK -->
                </li>
                <!-- /MENU ITEM -->

                <!-- MENU ITEM -->
                <li class="menu-item">
                    <!-- MENU ITEM LINK -->
                    <router-link tag="a" class="menu-item-link" to="/danh-gia-diem-ren-luyen" active-class="active">
                        <svg class="menu-item-link-icon icon-trophy">
                            <use xlink:href="#svg-trophy"></use>
                        </svg>
                        Đánh giá điểm rèn luyện
                    </router-link>
                    <!-- /MENU ITEM LINK -->
                </li>
                <!-- /MENU ITEM -->

                <!-- MENU ITEM -->
                <li class="menu-item">
                    <!-- MENU ITEM LINK -->
                    <router-link tag="a" class="menu-item-link" to="/gui-yeu-cau" active-class="active">
                        <svg class="menu-item-link-icon icon-send-message">
                            <use xlink:href="#svg-send-message"></use>
                        </svg>
                        Gửi yêu cầu
                    </router-link>
                    <!-- /MENU ITEM LINK -->
                </li>
                <!-- /MENU ITEM -->

                <!-- MENU ITEM -->
                <li class="menu-item">
                    <!-- MENU ITEM LINK -->
                    <router-link tag="a" class="menu-item-link" to="/yeu-cau-thu-tuc-sinh-vien" active-class="active">
                        <svg class="menu-item-link-icon icon-forum">
                            <use xlink:href="#svg-forum"></use>
                        </svg>
                        Xin giấy xác nhận
                    </router-link>
                    <!-- /MENU ITEM LINK -->
                </li>
                <!-- /MENU ITEM -->

                <!-- MENU ITEM -->
                <li class="menu-item">
                    <!-- MENU ITEM LINK -->
                    <router-link tag="a" class="menu-item-link" to="/thanh-toan-hoc-phi" active-class="active">
                        <svg class="menu-item-link-icon icon-revenue">
                            <use xlink:href="#svg-revenue"></use>
                        </svg>
                        Thanh toán học phí
                    </router-link>
                    <!-- /MENU ITEM LINK -->
                </li>
                <!-- /MENU ITEM -->
            </ul>
            <!-- /MENU -->
        </nav>
        <!-- /NAVIGATION WIDGET -->
    </div>
    <!-- /MOBILEMENU TRIGGER -->
</template>

<script>
export default {
    data() {
        return {
            toggle: false,
            student_id: this.$studentId,
            student_avatar: '',
            student_fullname: '',
            student_email: ''
        }
    },
    methods: {
        toggleSlide() {
            this.toggle = true
        }
    },
    mounted() {
        this.fetchInfo()
    },
    methods: {
        fetchInfo(page_url) {
            page_url = `../../api/admin/user-sv/sinh-vien/detail/${this.student_id}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.student_avatar = res.data[0].student_avatar
                    this.student_fullname = res.data[0].student_fullname
                    this.student_email = res.data[0].student_email
                })
                .catch(err => console.log(err))
        }
    }
}
</script>

<style scoped>
.avatar-styling {
    width: 40%;
}
.styling {
    text-align: center;
    margin-top: 40px;
}
</style>
