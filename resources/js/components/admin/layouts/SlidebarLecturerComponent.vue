<template>
    <div>
        <div class="tab-menu-heading siderbar-tabs border-0  p-0">
            <div class="tabs-menu ">
                <!-- Tabs -->
                <ul class="nav panel-tabs">
                    <li class="slide">
                        <router-link
                            tag="a"
                            class="side-menu__item"
                            to="/thong-tin-ca-nhan-cua-ban-chu-nhiem-khoa"
                            active-class="active"
                            exact
                        >
                            <i class="fa fa-user fs-17 styling"></i>
                        </router-link>
                    </li>
                </ul>
            </div>
        </div>

        <div class="panel-body tabs-menu-body side-tab-body p-0 border-0" id="style-1">
            <div class="tab-content">
                <div class="tab-pane active ">
                    <ul class="side-menu toggle-menu">
                        <li class="mb-2 ml-4">
                            <span class="side-menu__label"><strong class="color-text">TRANG CHỦ</strong></span>
                        </li>
                        <li class="slide">
                            <router-link tag="a" class="side-menu__item" to="/" active-class="active" exact>
                                <i class="side-menu__icon typcn typcn-device-desktop"></i>
                                <span class="side-menu__label">Dashboard</span>
                            </router-link>
                        </li>

                        <li class="mt-5 mb-2 ml-4">
                            <span class="side-menu__label"><strong class="color-text">QUẢN LÝ</strong></span>
                        </li>
                        <li class="slide">
                            <router-link tag="a" class="side-menu__item" to="/mon-hoc" active-class="active">
                                <i class="side-menu__icon fa fa-wpforms"></i>
                                <span class="side-menu__label">Môn học</span>
                            </router-link>
                        </li>

                        <li class="slide">
                            <router-link tag="a" class="side-menu__item" to="/chuong-trinh-dao-tao" active-class="active">
                                <i class="side-menu__icon fa fa-tasks"></i>
                                <span class="side-menu__label">Chương trình đào tạo</span>
                            </router-link>
                        </li>

                        <li class="slide">
                            <router-link tag="a" class="side-menu__item" to="/lop-hoc" active-class="active">
                                <i class="side-menu__icon fa fa-sitemap"></i>
                                <span class="side-menu__label">Lớp học</span>
                            </router-link>
                        </li>

                        <li class="slide">
                            <router-link tag="a" class="side-menu__item" to="/chu-nhiem-sinh-vien" active-class="active">
                                <i class="side-menu__icon fa fa-black-tie"></i>
                                <span class="side-menu__label">Chủ nhiệm sinh viên</span>
                            </router-link>
                        </li>

                        <!-- <li class="slide">
                            <router-link tag="a" class="side-menu__item" to="/lich-bieu" active-class="active">
                                <i class="side-menu__icon fa fa-calendar"></i>
                                <span class="side-menu__label">Lịch biểu</span>
                            </router-link>
                        </li> -->

                        <li class="slide">
                            <router-link tag="a" class="side-menu__item" to="/quan-ly-thi-lan-2" active-class="active">
                                <i class="side-menu__icon fa fa-calendar-times-o"></i>
                                <span class="side-menu__label">Thi lần 2</span>
                            </router-link>
                        </li>

                        <!-- <li class="slide">
                            <router-link tag="a" class="side-menu__item" to="/quan-ly-thi-lan-2" active-class="active">
                                <i class="side-menu__icon fa fa-calendar-times-o"></i>
                                <span class="side-menu__label">Thi lần 2</span>
                            </router-link>
                        </li> -->

                        <li class="mt-5 mb-2 ml-4">
                            <span class="side-menu__label"><strong class="color-text">THỐNG KÊ</strong></span>
                        </li>
                        <li class="slide">
                            <router-link tag="a" class="side-menu__item" to="/thong-ke-so-luong-dang-ky-ke-hoach" active-class="active">
                                <i class="side-menu__icon fa fa-line-chart"></i>
                                <span class="side-menu__label">Số lượng đăng ký kế hoạch</span>
                            </router-link>
                        </li>
                        <li class="slide">
                            <router-link tag="a" class="side-menu__item" to="/thong-ke-so-luong-dang-ky-mon-hoc" active-class="active">
                                <i class="side-menu__icon fa fa-area-chart"></i>
                                <span class="side-menu__label">Số lượng đăng ký môn học</span>
                            </router-link>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {}
</script>

<style scoped>
.color-text {
    color: darkblue;
}
.styling {
    color: darkblue;
}
.styling:hover {
    color: black;
}
</style>
