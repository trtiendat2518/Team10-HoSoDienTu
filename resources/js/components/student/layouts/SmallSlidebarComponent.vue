<template>
    <div>
        <nav id="navigation-widget-small" class="navigation-widget navigation-widget-desktop closed sidebar left delayed ">
            <!-- USER AVATAR -->
            <a class="user-avatar small no-outline" href="profile-timeline.html">
                <!-- USER AVATAR CONTENT -->
                <div class="user-avatar-content">
                    <!-- HEXAGON -->
                    <div class="hexagon-image-30-32" data-src="">avatar</div>
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

            <!-- MENU -->
            <ul class="menu small">
                <!-- MENU ITEM -->
                <li class="menu-item">
                    <!-- MENU ITEM LINK -->
                    <router-link tag="a" class="menu-item-link text-tooltip-tfr" to="/chuong-trinh-dao-tao" active-class="active" exact>
                        <svg class="menu-item-link-icon icon-newsfeed">
                            <use xlink:href="#svg-newsfeed"></use>
                        </svg>
                    </router-link>
                    <!-- /MENU ITEM LINK -->
                </li>
                <!-- /MENU ITEM -->

                <!-- MENU ITEM -->
                <li class="menu-item">
                    <!-- MENU ITEM LINK -->
                    <router-link tag="a" class="menu-item-link text-tooltip-tfr" to="/lich-hoc" active-class="active">
                        <svg class="menu-item-link-icon icon-events-monthly">
                            <use xlink:href="#svg-events-monthly"></use>
                        </svg>
                    </router-link>
                    <!-- /MENU ITEM LINK -->
                </li>
                <!-- /MENU ITEM -->

                <!-- MENU ITEM -->
                <li class="menu-item">
                    <!-- MENU ITEM LINK -->
                    <router-link tag="a" class="menu-item-link text-tooltip-tfr" to="/lich-thi" active-class="active">
                        <svg class="menu-item-link-icon icon-events-weekly">
                            <use xlink:href="#svg-events-weekly"></use>
                        </svg>
                    </router-link>
                    <!-- /MENU ITEM LINK -->
                </li>
                <!-- /MENU ITEM -->

                <!-- MENU ITEM -->
                <li class="menu-item">
                    <!-- MENU ITEM LINK -->
                    <router-link tag="a" class="menu-item-link text-tooltip-tfr" to="/ket-qua-hoc-tap" active-class="active">
                        <svg class="menu-item-link-icon icon-badges">
                            <use xlink:href="#svg-badges"></use>
                        </svg>
                    </router-link>
                    <!-- /MENU ITEM LINK -->
                </li>
                <!-- /MENU ITEM -->

                <!-- MENU ITEM -->
                <li class="menu-item">
                    <!-- MENU ITEM LINK -->
                    <router-link tag="a" class="menu-item-link text-tooltip-tfr" to="/tong-hop-hoc-phi" active-class="active">
                        <svg class="menu-item-link-icon icon-wallet">
                            <use xlink:href="#svg-wallet"></use>
                        </svg>
                    </router-link>
                    <!-- /MENU ITEM LINK -->
                </li>
                <!-- /MENU ITEM -->

                <!-- MENU ITEM -->
                <li class="menu-item">
                    <!-- MENU ITEM LINK -->
                    <router-link tag="a" class="menu-item-link text-tooltip-tfr" to="/ke-hoach-hoc-tap" active-class="active">
                        <svg class="menu-item-link-icon icon-clock">
                            <use xlink:href="#svg-clock"></use>
                        </svg>
                    </router-link>
                    <!-- /MENU ITEM LINK -->
                </li>
                <!-- /MENU ITEM -->

                <!-- MENU ITEM -->
                <li class="menu-item">
                    <!-- MENU ITEM LINK -->
                    <router-link tag="a" class="menu-item-link text-tooltip-tfr" to="/dang-ky-mon-hoc" active-class="active">
                        <svg class="menu-item-link-icon icon-list-grid-view">
                            <use xlink:href="#svg-list-grid-view"></use>
                        </svg>
                    </router-link>
                    <!-- /MENU ITEM LINK -->
                </li>
                <!-- /MENU ITEM -->

                <!-- MENU ITEM -->
                <li class="menu-item">
                    <!-- MENU ITEM LINK -->
                    <router-link tag="a" class="menu-item-link text-tooltip-tfr" to="/dang-ky-thi-lan-2" active-class="active">
                        <svg class="menu-item-link-icon icon-forums">
                            <use xlink:href="#svg-forums"></use>
                        </svg>
                    </router-link>
                    <!-- /MENU ITEM LINK -->
                </li>
                <!-- /MENU ITEM -->

                <!-- MENU ITEM -->
                <li class="menu-item">
                    <!-- MENU ITEM LINK -->
                    <router-link tag="a" class="menu-item-link text-tooltip-tfr" to="/danh-gia-diem-ren-luyen" active-class="active">
                        <svg class="menu-item-link-icon icon-trophy">
                            <use xlink:href="#svg-trophy"></use>
                        </svg>
                    </router-link>
                    <!-- /MENU ITEM LINK -->
                </li>
                <!-- /MENU ITEM -->

                <!-- MENU ITEM -->
                <li class="menu-item">
                    <!-- MENU ITEM LINK -->
                    <router-link tag="a" class="menu-item-link text-tooltip-tfr" to="/gui-yeu-cau" active-class="active">
                        <svg class="menu-item-link-icon icon-send-message">
                            <use xlink:href="#svg-send-message"></use>
                        </svg>
                    </router-link>
                    <!-- /MENU ITEM LINK -->
                </li>
                <!-- /MENU ITEM -->

                <!-- MENU ITEM -->
                <li class="menu-item">
                    <!-- MENU ITEM LINK -->
                    <router-link tag="a" class="menu-item-link text-tooltip-tfr" to="/yeu-cau-thu-tuc-sinh-vien" active-class="active">
                        <svg class="menu-item-link-icon icon-forum">
                            <use xlink:href="#svg-forum"></use>
                        </svg>
                    </router-link>
                    <!-- /MENU ITEM LINK -->
                </li>
                <!-- /MENU ITEM -->

                <!-- MENU ITEM -->
                <li class="menu-item">
                    <!-- MENU ITEM LINK -->
                    <router-link tag="a" class="menu-item-link text-tooltip-tfr" to="/thanh-toan-hoc-phi" active-class="active">
                        <svg class="menu-item-link-icon icon-revenue">
                            <use xlink:href="#svg-revenue"></use>
                        </svg>
                    </router-link>
                    <!-- /MENU ITEM LINK -->
                </li>
                <!-- /MENU ITEM -->
            </ul>
            <!-- /MENU -->
            <br /><br />
        </nav>
    </div>
</template>

<script>
export default {}
</script>

<style scope></style>
