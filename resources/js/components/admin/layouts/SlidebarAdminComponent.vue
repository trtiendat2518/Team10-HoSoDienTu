<template>
    <div>
        <div class="tab-menu-heading siderbar-tabs border-0  p-0">
            <div class="tabs-menu ">
                <!-- Tabs -->
                <ul class="nav panel-tabs">
                    <li class="slide">
                        <router-link tag="a" class="side-menu__item" to="/thong-tin-ca-nhan/" active-class="active" exact>
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
                            <span class="side-menu__label">
                                <strong class="color-text">TRANG CHỦ </strong>
                            </span>
                        </li>
                        <li class="slide">
                            <router-link tag="a" class="side-menu__item" to="/" active-class="active" exact>
                                <i class="side-menu__icon typcn typcn-device-desktop"></i>
                                <span class="side-menu__label">Dashboard</span>
                            </router-link>
                        </li>

                        <li class="mt-5 mb-2 ml-4">
                            <span class="side-menu__label">
                                <strong class="color-text">
                                    QUẢN LÝ TÀI KHOẢN
                                </strong>
                            </span>
                        </li>
                        <li class="slide">
                            <router-link tag="a" class="side-menu__item" to="/giang-vien" active-class="active">
                                <i class="side-menu__icon fa fa-users"></i>
                                <span class="side-menu__label">Giảng viên</span>
                            </router-link>
                        </li>

                        <li class="slide">
                            <router-link tag="a" class="side-menu__item" to="/sinh-vien" active-class="active">
                                <i class="side-menu__icon fa fa-graduation-cap"></i>
                                <span class="side-menu__label">Sinh viên</span>
                            </router-link>
                        </li>

                        <li class="mt-5 mb-2 ml-4">
                            <span class="side-menu__label">
                                <strong class="color-text">
                                    QUẢN LÝ CHUNG
                                </strong>
                            </span>
                        </li>
                        <li class="slide">
                            <router-link tag="a" class="side-menu__item" to="/khoa" active-class="active">
                                <i class="side-menu__icon fa fa-th-large"></i>
                                <span class="side-menu__label">Khoa</span>
                            </router-link>
                        </li>

                        <li class="slide">
                            <router-link tag="a" class="side-menu__item" to="/chuyen-nganh" active-class="active">
                                <i class="side-menu__icon fa fa-th-list"></i>
                                <span class="side-menu__label">
                                    Chuyên ngành
                                </span>
                            </router-link>
                        </li>

                        <li class="slide">
                            <router-link tag="a" class="side-menu__item" to="/khoa-hoc" active-class="active">
                                <i class="side-menu__icon fa fa-book"></i>
                                <span class="side-menu__label">Khóa học</span>
                            </router-link>
                        </li>

                        <li class="slide">
                            <router-link tag="a" class="side-menu__item" to="/he-dao-tao" active-class="active">
                                <i class="side-menu__icon fa fa-leanpub"></i>
                                <span class="side-menu__label">
                                    Hệ thống đào tạo
                                </span>
                            </router-link>
                        </li>

                        <li class="slide">
                            <router-link tag="a" class="side-menu__item" to="/thu-tuc" active-class="active">
                                <i class="side-menu__icon fa fa-file-text"></i>
                                <span class="side-menu__label">
                                    Thủ tục sinh viên
                                </span>
                            </router-link>
                        </li>
                        <li class="slide">
                            <router-link tag="a" class="side-menu__item" to="/hoc-phi" active-class="active">
                                <i class="side-menu__icon fa fa-money"></i>
                                <span class="side-menu__label">
                                    Học phí sinh viên
                                </span>
                            </router-link>
                        </li>
                        <li class="slide">
                            <router-link tag="a" class="side-menu__item" to="/bai-viet" active-class="active">
                                <i class="side-menu__icon fa fa-newspaper-o"></i>
                                <span class="side-menu__label">
                                    Bài viết - Tin tức
                                </span>
                            </router-link>
                        </li>
                    </ul>
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
            infos: []
        }
    }
}
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
