<template>
    <div>
        <div
            class="panel-body tabs-menu-body side-tab-body p-0 border-0"
            id="style-1"
        >
            <div class="tab-content">
                <div class="tab-pane active ">
                    <ul class="side-menu toggle-menu">
                        <li class="mb-2 ml-4">
                            <span class="side-menu__label">
                                <strong class="color-text">
                                    TRANG CHỦ
                                </strong>
                            </span>
                        </li>
                        <li class="slide">
                            <router-link
                                tag="a"
                                class="side-menu__item"
                                to="/"
                                active-class="active"
                                exact
                            >
                                <i
                                    class="side-menu__icon typcn typcn-device-desktop"
                                ></i>
                                <span class="side-menu__label">Dashboard</span>
                            </router-link>
                        </li>

                        <li class="mt-5 mb-2 ml-4">
                            <span class="side-menu__label">
                                <strong class="color-text">QUẢN LÝ </strong>
                            </span>
                        </li>
                        <li class="slide">
                            <router-link
                                tag="a"
                                class="side-menu__item"
                                to="/chuong-trinh-dao-tao-sinh-vien"
                                active-class="active"
                            >
                                <i class="side-menu__icon fa fa-wpforms"></i>
                                <span class="side-menu__label">
                                    Chương trình đào tạo
                                </span>
                            </router-link>
                        </li>

                        <li class="slide">
                            <router-link
                                tag="a"
                                class="side-menu__item"
                                to="/lop-sinh-vien"
                                active-class="active"
                            >
                                <i class="side-menu__icon fa fa-tasks"></i>
                                <span class="side-menu__label">
                                    Lớp sinh viên
                                </span>
                            </router-link>
                        </li>

                        <li class="slide">
                            <router-link
                                tag="a"
                                class="side-menu__item"
                                to="/lop-hoc"
                                active-class="active"
                            >
                                <i class="side-menu__icon fa fa-sitemap"></i>
                                <span class="side-menu__label">
                                    Yêu cầu sinh viên
                                </span>
                            </router-link>
                        </li>

                        <li class="slide">
                            <router-link
                                tag="a"
                                class="side-menu__item"
                                to="/chu-nhiem-sinh-vien"
                                active-class="active"
                            >
                                <i class="side-menu__icon fa fa-black-tie"></i>
                                <span class="side-menu__label">
                                    Gợi ý kế hoạch học tập
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
export default {};
</script>

<style scoped>
.color-text {
    color: darkblue;
}
</style>
