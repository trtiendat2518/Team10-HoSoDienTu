<template>
    <div>
        <!-- NAVIGATION WIDGET -->
        <nav v-show="showfull_slidebar == true" class="navigation-widget navigation-widget-desktop sidebar left" data-simplebar>
            <!-- NAVIGATION WIDGET COVER -->
            <figure class="navigation-widget-cover liquid">
                <img src="" alt="cover-01" />
            </figure>
            <!-- /NAVIGATION WIDGET COVER -->

            <!-- USER SHORT DESCRIPTION -->
            <div class="user-short-description">
                <!-- USER SHORT DESCRIPTION AVATAR -->
                <a class="user-short-description-avatar user-avatar medium" href="profile-timeline.html">
                    <!-- USER AVATAR BORDER -->
                    <div class="user-avatar-border">
                        <!-- HEXAGON -->
                        <div class="hexagon-120-132"></div>
                        <!-- /HEXAGON -->
                    </div>
                    <!-- /USER AVATAR BORDER -->

                    <!-- USER AVATAR CONTENT -->
                    <div class="user-avatar-content">
                        <!-- HEXAGON -->
                        <div class="hexagon-image-82-90" data-src=""></div>
                        <!-- /HEXAGON -->
                    </div>
                    <!-- /USER AVATAR CONTENT -->

                    <!-- USER AVATAR PROGRESS -->
                    <div class="user-avatar-progress">
                        <!-- HEXAGON -->
                        <div class="hexagon-progress-100-110"></div>
                        <!-- /HEXAGON -->
                    </div>
                    <!-- /USER AVATAR PROGRESS -->

                    <!-- USER AVATAR PROGRESS BORDER -->
                    <div class="user-avatar-progress-border">
                        <!-- HEXAGON -->
                        <div class="hexagon-border-100-110"></div>
                        <!-- /HEXAGON -->
                    </div>
                    <!-- /USER AVATAR PROGRESS BORDER -->
                </a>
                <!-- /USER SHORT DESCRIPTION AVATAR -->

                <!-- USER SHORT DESCRIPTION TITLE -->
                <p class="user-short-description-title"><a href="profile-timeline.html">Marina Valentine</a></p>
                <!-- /USER SHORT DESCRIPTION TITLE -->

                <!-- USER SHORT DESCRIPTION TEXT -->
                <p class="user-short-description-text"><a href="#">www.gamehuntress.com</a></p>
                <!-- /USER SHORT DESCRIPTION TEXT -->
            </div>
            <!-- /USER SHORT DESCRIPTION -->

            <!-- MENU -->
            <ul class="menu">
                <!-- NAVIGATION WIDGET SECTION TITLE -->
                <p class="navigation-widget-section-title mb-3">Tra cứu thông tin</p>
                <!-- /NAVIGATION WIDGET SECTION TITLE -->

                <!-- MENU ITEM -->
                <li class="menu-item active">
                    <!-- MENU ITEM LINK -->
                    <router-link tag="a" class="menu-item-link" to="/chuong-trinh-dao-tao" active-class="active" exact>
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
                        Thủ tục sinh viên
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
            <br /><br />
            <!-- /MENU -->
        </nav>
        <!-- /NAVIGATION WIDGET -->

        <!-- NAVIGATION WIDGET MOBILE -->
        <nav v-show="showmobile_slidebar == true" class="navigation-widget navigation-widget-mobile sidebar left hidden" data-simplebar>
            <!-- NAVIGATION WIDGET CLOSE BUTTON -->
            <div class="navigation-widget-close-button">
                <!-- NAVIGATION WIDGET CLOSE BUTTON ICON -->
                <svg class="navigation-widget-close-button-icon icon-back-arrow">
                    <use xlink:href="#svg-back-arrow"></use>
                </svg>
                <!-- NAVIGATION WIDGET CLOSE BUTTON ICON -->
            </div>
            <!-- /NAVIGATION WIDGET CLOSE BUTTON -->

            <!-- NAVIGATION WIDGET INFO WRAP -->
            <div class="navigation-widget-info-wrap">
                <!-- NAVIGATION WIDGET INFO -->
                <div class="navigation-widget-info">
                    <!-- USER AVATAR -->
                    <a class="user-avatar small no-outline" href="profile-timeline.html">
                        <!-- USER AVATAR CONTENT -->
                        <div class="user-avatar-content">
                            <!-- HEXAGON -->
                            <div class="hexagon-image-30-32" data-src=""></div>
                            <!-- /HEXAGON -->
                        </div>
                        <!-- /USER AVATAR CONTENT -->

                        <!-- USER AVATAR PROGRESS -->
                        <div class="user-avatar-progress">
                            <!-- HEXAGON -->
                            <div class="hexagon-progress-40-44"></div>
                            <!-- /HEXAGON -->
                        </div>
                        <!-- /USER AVATAR PROGRESS -->

                        <!-- USER AVATAR PROGRESS BORDER -->
                        <div class="user-avatar-progress-border">
                            <!-- HEXAGON -->
                            <div class="hexagon-border-40-44"></div>
                            <!-- /HEXAGON -->
                        </div>
                        <!-- /USER AVATAR PROGRESS BORDER -->
                    </a>
                    <!-- /USER AVATAR -->

                    <!-- NAVIGATION WIDGET INFO TITLE -->
                    <p class="navigation-widget-info-title"><a href="profile-timeline.html">Marina Valentine</a></p>
                    <!-- /NAVIGATION WIDGET INFO TITLE -->

                    <!-- NAVIGATION WIDGET INFO TEXT -->
                    <p class="navigation-widget-info-text">Welcome Back!</p>
                    <!-- /NAVIGATION WIDGET INFO TEXT -->
                </div>
                <!-- /NAVIGATION WIDGET INFO -->

                <!-- NAVIGATION WIDGET BUTTON -->
                <p class="navigation-widget-info-button button small secondary">Logout</p>
                <!-- /NAVIGATION WIDGET BUTTON -->
            </div>
            <!-- /NAVIGATION WIDGET INFO WRAP -->

            <!-- NAVIGATION WIDGET SECTION TITLE -->
            <p class="navigation-widget-section-title">Sections</p>
            <!-- /NAVIGATION WIDGET SECTION TITLE -->

            <!-- MENU -->
            <ul class="menu">
                <!-- MENU ITEM -->
                <li class="menu-item active">
                    <!-- MENU ITEM LINK -->
                    <a class="menu-item-link" href="newsfeed.html">
                        <!-- MENU ITEM LINK ICON -->
                        <svg class="menu-item-link-icon icon-newsfeed">
                            <use xlink:href="#svg-newsfeed"></use>
                        </svg>
                        <!-- /MENU ITEM LINK ICON -->
                        Chương trình đào tạo
                    </a>
                    <!-- /MENU ITEM LINK -->
                </li>
                <!-- /MENU ITEM -->

                <!-- MENU ITEM -->
                <li class="menu-item">
                    <!-- MENU ITEM LINK -->
                    <a class="menu-item-link" href="overview.html">
                        <!-- MENU ITEM LINK ICON -->
                        <svg class="menu-item-link-icon icon-events-monthly">
                            <use xlink:href="#svg-events-monthly"></use>
                        </svg>
                        <!-- /MENU ITEM LINK ICON -->
                        Lịch học
                    </a>
                    <!-- /MENU ITEM LINK -->
                </li>
                <!-- /MENU ITEM -->

                <!-- MENU ITEM -->
                <li class="menu-item">
                    <!-- MENU ITEM LINK -->
                    <a class="menu-item-link" href="groups.html">
                        <!-- MENU ITEM LINK ICON -->
                        <svg class="menu-item-link-icon icon-events-weekly">
                            <use xlink:href="#svg-events-weekly"></use>
                        </svg>
                        <!-- /MENU ITEM LINK ICON -->
                        Lịch thi
                    </a>
                    <!-- /MENU ITEM LINK -->
                </li>
                <!-- /MENU ITEM -->

                <!-- MENU ITEM -->
                <li class="menu-item">
                    <!-- MENU ITEM LINK -->
                    <a class="menu-item-link" href="members.html">
                        <!-- MENU ITEM LINK ICON -->
                        <svg class="menu-item-link-icon icon-badges">
                            <use xlink:href="#svg-badges"></use>
                        </svg>
                        <!-- /MENU ITEM LINK ICON -->
                        Kết quả học tập
                    </a>
                    <!-- /MENU ITEM LINK -->
                </li>
                <!-- /MENU ITEM -->

                <!-- MENU ITEM -->
                <li class="menu-item">
                    <!-- MENU ITEM LINK -->
                    <a class="menu-item-link" href="badges.html">
                        <!-- MENU ITEM LINK ICON -->
                        <svg class="menu-item-link-icon icon-wallet">
                            <use xlink:href="#svg-wallet"></use>
                        </svg>
                        <!-- /MENU ITEM LINK ICON -->
                        Tổng hợp học phí
                    </a>
                    <!-- /MENU ITEM LINK -->
                </li>
                <!-- /MENU ITEM -->

                <!-- MENU ITEM -->
                <li class="menu-item">
                    <!-- MENU ITEM LINK -->
                    <a class="menu-item-link" href="quests.html">
                        <!-- MENU ITEM LINK ICON -->
                        <svg class="menu-item-link-icon icon-clock">
                            <use xlink:href="#svg-clock"></use>
                        </svg>
                        <!-- /MENU ITEM LINK ICON -->
                        Đăng ký kế hoạch học tập
                    </a>
                    <!-- /MENU ITEM LINK -->
                </li>
                <!-- /MENU ITEM -->

                <!-- MENU ITEM -->
                <li class="menu-item">
                    <!-- MENU ITEM LINK -->
                    <a class="menu-item-link" href="streams.html">
                        <!-- MENU ITEM LINK ICON -->
                        <svg class="menu-item-link-icon icon-list-grid-view">
                            <use xlink:href="#svg-list-grid-view"></use>
                        </svg>
                        <!-- /MENU ITEM LINK ICON -->
                        Đăng ký môn học
                    </a>
                    <!-- /MENU ITEM LINK -->
                </li>
                <!-- /MENU ITEM -->

                <!-- MENU ITEM -->
                <li class="menu-item">
                    <!-- MENU ITEM LINK -->
                    <a class="menu-item-link" href="events.html">
                        <!-- MENU ITEM LINK ICON -->
                        <svg class="menu-item-link-icon icon-forums">
                            <use xlink:href="#svg-forums"></use>
                        </svg>
                        <!-- /MENU ITEM LINK ICON -->
                        Đăng ký thi lần 2
                    </a>
                    <!-- /MENU ITEM LINK -->
                </li>
                <!-- /MENU ITEM -->

                <!-- MENU ITEM -->
                <li class="menu-item">
                    <!-- MENU ITEM LINK -->
                    <a class="menu-item-link" href="forums.html">
                        <!-- MENU ITEM LINK ICON -->
                        <svg class="menu-item-link-icon icon-trophy">
                            <use xlink:href="#svg-trophy"></use>
                        </svg>
                        <!-- /MENU ITEM LINK ICON -->
                        Đánh giá điểm rèn luyện
                    </a>
                    <!-- /MENU ITEM LINK -->
                </li>
                <!-- /MENU ITEM -->

                <!-- MENU ITEM -->
                <li class="menu-item">
                    <!-- MENU ITEM LINK -->
                    <a class="menu-item-link" href="marketplace.html">
                        <!-- MENU ITEM LINK ICON -->
                        <svg class="menu-item-link-icon icon-send-message">
                            <use xlink:href="#svg-send-message"></use>
                        </svg>
                        <!-- /MENU ITEM LINK ICON -->
                        Gửi yêu cầu
                    </a>
                    <!-- /MENU ITEM LINK -->
                </li>
                <!-- /MENU ITEM -->

                <!-- MENU ITEM -->
                <li class="menu-item">
                    <!-- MENU ITEM LINK -->
                    <a class="menu-item-link" href="marketplace.html">
                        <!-- MENU ITEM LINK ICON -->
                        <svg class="menu-item-link-icon icon-forum">
                            <use xlink:href="#svg-forum"></use>
                        </svg>
                        <!-- /MENU ITEM LINK ICON -->
                        Thủ tục sinh viên
                    </a>
                    <!-- /MENU ITEM LINK -->
                </li>
                <!-- /MENU ITEM -->

                <!-- MENU ITEM -->
                <li class="menu-item">
                    <!-- MENU ITEM LINK -->
                    <a class="menu-item-link" href="marketplace.html">
                        <!-- MENU ITEM LINK ICON -->
                        <svg class="menu-item-link-icon icon-revenue">
                            <use xlink:href="#svg-revenue"></use>
                        </svg>
                        <!-- /MENU ITEM LINK ICON -->
                        Thanh toán học phí
                    </a>
                    <!-- /MENU ITEM LINK -->
                </li>
                <!-- /MENU ITEM -->
            </ul>
            <!-- /MENU -->

            <!-- NAVIGATION WIDGET SECTION TITLE -->
            <p class="navigation-widget-section-title">My Profile</p>
            <!-- /NAVIGATION WIDGET SECTION TITLE -->

            <!-- NAVIGATION WIDGET SECTION LINK -->
            <a class="navigation-widget-section-link" href="hub-profile-info.html">Profile Info</a>
            <!-- /NAVIGATION WIDGET SECTION LINK -->

            <!-- NAVIGATION WIDGET SECTION LINK -->
            <a class="navigation-widget-section-link" href="hub-profile-social.html">Social &amp; Stream</a>
            <!-- /NAVIGATION WIDGET SECTION LINK -->

            <!-- NAVIGATION WIDGET SECTION LINK -->
            <a class="navigation-widget-section-link" href="hub-profile-notifications.html">Notifications</a>
            <!-- /NAVIGATION WIDGET SECTION LINK -->

            <!-- NAVIGATION WIDGET SECTION LINK -->
            <a class="navigation-widget-section-link" href="hub-profile-messages.html">Messages</a>
            <!-- /NAVIGATION WIDGET SECTION LINK -->

            <!-- NAVIGATION WIDGET SECTION LINK -->
            <a class="navigation-widget-section-link" href="hub-profile-requests.html">Friend Requests</a>
            <!-- /NAVIGATION WIDGET SECTION LINK -->

            <!-- NAVIGATION WIDGET SECTION TITLE -->
            <p class="navigation-widget-section-title">Account</p>
            <!-- /NAVIGATION WIDGET SECTION TITLE -->

            <!-- NAVIGATION WIDGET SECTION LINK -->
            <a class="navigation-widget-section-link" href="hub-account-info.html">Account Info</a>
            <!-- /NAVIGATION WIDGET SECTION LINK -->

            <!-- NAVIGATION WIDGET SECTION LINK -->
            <a class="navigation-widget-section-link" href="hub-account-password.html">Change Password</a>
            <!-- /NAVIGATION WIDGET SECTION LINK -->

            <!-- NAVIGATION WIDGET SECTION LINK -->
            <a class="navigation-widget-section-link" href="hub-account-settings.html">General Settings</a>
            <!-- /NAVIGATION WIDGET SECTION LINK -->

            <!-- NAVIGATION WIDGET SECTION TITLE -->
            <p class="navigation-widget-section-title">Groups</p>
            <!-- /NAVIGATION WIDGET SECTION TITLE -->

            <!-- NAVIGATION WIDGET SECTION LINK -->
            <a class="navigation-widget-section-link" href="hub-group-management.html">Manage Groups</a>
            <!-- /NAVIGATION WIDGET SECTION LINK -->

            <!-- NAVIGATION WIDGET SECTION LINK -->
            <a class="navigation-widget-section-link" href="hub-group-invitations.html">Invitations</a>
            <!-- /NAVIGATION WIDGET SECTION LINK -->

            <!-- NAVIGATION WIDGET SECTION TITLE -->
            <p class="navigation-widget-section-title">My Store</p>
            <!-- /NAVIGATION WIDGET SECTION TITLE -->

            <!-- NAVIGATION WIDGET SECTION LINK -->
            <a class="navigation-widget-section-link" href="hub-store-account.html">My Account <span class="highlighted">$250,32</span></a>
            <!-- /NAVIGATION WIDGET SECTION LINK -->

            <!-- NAVIGATION WIDGET SECTION LINK -->
            <a class="navigation-widget-section-link" href="hub-store-statement.html">Sales Statement</a>
            <!-- /NAVIGATION WIDGET SECTION LINK -->

            <!-- NAVIGATION WIDGET SECTION LINK -->
            <a class="navigation-widget-section-link" href="hub-store-items.html">Manage Items</a>
            <!-- /NAVIGATION WIDGET SECTION LINK -->

            <!-- NAVIGATION WIDGET SECTION LINK -->
            <a class="navigation-widget-section-link" href="hub-store-downloads.html">Downloads</a>
            <!-- /NAVIGATION WIDGET SECTION LINK -->

            <!-- NAVIGATION WIDGET SECTION TITLE -->
            <p class="navigation-widget-section-title">Main Links</p>
            <!-- /NAVIGATION WIDGET SECTION TITLE -->

            <!-- NAVIGATION WIDGET SECTION LINK -->
            <a class="navigation-widget-section-link" href="#">Home</a>
            <!-- /NAVIGATION WIDGET SECTION LINK -->

            <!-- NAVIGATION WIDGET SECTION LINK -->
            <a class="navigation-widget-section-link" href="#">Careers</a>
            <!-- /NAVIGATION WIDGET SECTION LINK -->

            <!-- NAVIGATION WIDGET SECTION LINK -->
            <a class="navigation-widget-section-link" href="#">Faqs</a>
            <!-- /NAVIGATION WIDGET SECTION LINK -->

            <!-- NAVIGATION WIDGET SECTION LINK -->
            <a class="navigation-widget-section-link" href="#">About Us</a>
            <!-- /NAVIGATION WIDGET SECTION LINK -->

            <!-- NAVIGATION WIDGET SECTION LINK -->
            <a class="navigation-widget-section-link" href="#">Our Blog</a>
            <!-- /NAVIGATION WIDGET SECTION LINK -->

            <!-- NAVIGATION WIDGET SECTION LINK -->
            <a class="navigation-widget-section-link" href="#">Contact Us</a>
            <!-- /NAVIGATION WIDGET SECTION LINK -->

            <!-- NAVIGATION WIDGET SECTION LINK -->
            <a class="navigation-widget-section-link" href="#">Privacy Policy</a>
            <!-- /NAVIGATION WIDGET SECTION LINK -->
        </nav>
        <!-- /NAVIGATION WIDGET MOBILE -->

        <!-- HEADER ACTIONS -->
        <div class="header-actions">
            <!-- SIDEMENU TRIGGER -->
            <div class="sidemenu-trigger navigation-widget-trigger" @click="openFull()">
                <!-- ICON GRID -->
                <svg class="icon-grid">
                    <use xlink:href="#svg-grid"></use>
                </svg>
                <!-- /ICON GRID -->
            </div>
            <!-- /SIDEMENU TRIGGER -->

            <!-- MOBILEMENU TRIGGER -->
            <div class="mobilemenu-trigger navigation-widget-mobile-trigger" @click="openMobile()">
                <!-- BURGER ICON -->
                <div class="burger-icon inverted">
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
            </div>
            <!-- /MOBILEMENU TRIGGER -->
        </div>
        <!-- /HEADER ACTIONS -->
    </div>
</template>

<script>
export default {
    data() {
        return {
            showfull_slidebar: false,
            showmobile_slidebar: false
        }
    },
    methods: {
        openFull() {
            if (this.showfull_slidebar == false) {
                this.showfull_slidebar = true
            } else {
                this.showfull_slidebar = false
            }
        },
        openMobile() {
            if (this.showmobile_slidebar == false) {
                this.showmobile_slidebar = true
            } else {
                this.showmobile_slidebar = false
            }
        }
    }
}
</script>

<style></style>
