<!-- HEADER -->
<header class="header mr-2">
    <!-- HEADER ACTIONS -->
    <div class="header-actions">
        <!-- HEADER BRAND -->
        <div class="header-brand">
            <!-- LOGO -->
            <div class="logo">
                <!-- ICON LOGO VIKINGER -->
                <img src="{{ asset('public/student/img/vlu.ico') }}" alt="vlu">
                <!-- /ICON LOGO VIKINGER -->
            </div>
            <!-- /LOGO -->

            <!-- HEADER BRAND TEXT -->
            <h1 class="header-brand-text">VLU</h1>
            <!-- /HEADER BRAND TEXT -->
        </div>
        <!-- /HEADER BRAND -->

        <!-- NAVIGATION -->
        {{-- <nav class="navigation">
            <!-- MENU MAIN -->
            <ul class="menu-main">
                <!-- MENU MAIN ITEM -->
                <li class="menu-main-item">
                    <!-- MENU MAIN ITEM LINK -->
                    <a class="menu-main-item-link" href="{{ url('/') }}">Trang chủ</a>
                    <!-- /MENU MAIN ITEM LINK -->
                </li>
                <!-- /MENU MAIN ITEM -->

                <!-- MENU MAIN ITEM -->
                <li class="menu-main-item">
                    <!-- MENU MAIN ITEM LINK -->
                    <a class="menu-main-item-link" href="#">Thanh toán học phí</a>
                    <!-- /MENU MAIN ITEM LINK -->
                </li>
                <!-- /MENU MAIN ITEM -->

                <!-- MENU MAIN ITEM -->
                <li class="menu-main-item">
                    <!-- MENU MAIN ITEM LINK -->
                    <a class="menu-main-item-link" href="{{ url('/home#/thong-bao-chung') }}">Thông báo chung</a>
                    <!-- /MENU MAIN ITEM LINK -->
                </li>
                <!-- /MENU MAIN ITEM -->

                <!-- MENU MAIN ITEM -->
                <li class="menu-main-item">
                    <!-- MENU MAIN ITEM LINK -->
                    <a class="menu-main-item-link" href="{{ url('/home#/ban-tin-van-lang') }}">Bản tin VLU</a>
                    <!-- /MENU MAIN ITEM LINK -->
                </li>
                <!-- /MENU MAIN ITEM -->

                <!-- MENU MAIN ITEM -->
                <li class="menu-main-item">
                    <!-- MENU MAIN ITEM LINK -->
                    <a class="menu-main-item-link" href="{{ url('/home#/tat-ca-thong-bao') }}">Tất cả thông báo</a>
                    <!-- /MENU MAIN ITEM LINK -->
                </li>
                <!-- /MENU MAIN ITEM -->

                <!-- MENU MAIN ITEM -->
                <li class="menu-main-item">
                    <!-- MENU MAIN ITEM LINK -->
                    <a class="menu-main-item-link" href="#">Faqs</a>
                    <!-- /MENU MAIN ITEM LINK -->
                </li>
                <!-- /MENU MAIN ITEM -->

            </ul>
            <!-- /MENU MAIN -->
        </nav> --}}
        <!-- /NAVIGATION -->
    </div>
    <!-- /HEADER ACTIONS -->

    <!-- HEADER ACTIONS -->
    <div class="header-actions">
    </div>
    <!-- /HEADER ACTIONS -->

    <!-- HEADER ACTIONS -->
    <div class="header-actions">
        <mobile-slidebar-component></mobile-slidebar-component>

        <nav id="slidermain" class="navigation">
            <!-- MENU MAIN -->
            <ul class="menu-main">
                <!-- MENU MAIN ITEM -->
                <li class="menu-main-item">
                    <!-- MENU MAIN ITEM LINK -->
                    <a class="menu-main-item-link" href="{{ url('/') }}">Trang chủ</a>
                    <!-- /MENU MAIN ITEM LINK -->
                </li>
                <!-- /MENU MAIN ITEM -->

                <!-- MENU MAIN ITEM -->
                <li class="menu-main-item">
                    <!-- MENU MAIN ITEM LINK -->
                    <a class="menu-main-item-link" href="{{ url('/home#/thong-bao-chung') }}">Thông báo chung</a>
                    <!-- /MENU MAIN ITEM LINK -->
                </li>
                <!-- /MENU MAIN ITEM -->

                <!-- MENU MAIN ITEM -->
                <li class="menu-main-item">
                    <!-- MENU MAIN ITEM LINK -->
                    <a class="menu-main-item-link" href="{{ url('/home#/ban-tin-van-lang') }}">Bản tin VLU</a>
                    <!-- /MENU MAIN ITEM LINK -->
                </li>
                <!-- /MENU MAIN ITEM -->

                <!-- MENU MAIN ITEM -->
                <li class="menu-main-item">
                    <!-- MENU MAIN ITEM LINK -->
                    <a class="menu-main-item-link" href="#">Faqs</a>
                    <!-- /MENU MAIN ITEM LINK -->
                </li>
                <!-- /MENU MAIN ITEM -->
            </ul>
            <!-- /MENU MAIN -->
        </nav>

        <!-- ACTION ITEM WRAP -->
        <div id="loginout" class="action-item-wrap">
            <!-- ACTION ITEM -->
            <div class="action-item dark header-settings-dropdown-trigger">
                <!-- ACTION ITEM ICON -->
                <a href="{{ url('student/logout-student') }}" class="nav-link icon siderbar-link" data-toggle="sidebar-right"
                    data-target=".sidebar-right" style="color: #fff;">
                    <i class="fa fa-sign-out"></i>
                </a>
                <!-- /ACTION ITEM ICON -->
            </div>
            <!-- /ACTION ITEM -->
        </div>
        <!-- /ACTION ITEM WRAP -->
    </div>
    <!-- /HEADER ACTIONS -->
</header>
<!-- /HEADER -->
