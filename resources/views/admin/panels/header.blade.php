<!--app-header-->
<div class="app-header header d-flex">
    <div class="container-fluid">
        <div class="d-flex">
            <a class="header-brand" href="{{ url('admin/') }}">
                <img src="{{asset('public/lecturer/images/brand/vlu.png')}}" class="header-brand-img main-logo"
                    alt="VLU">
                <img src="{{asset('public/lecturer/images/vlu.ico')}}" class="header-brand-img icon-logo" alt="VLU">
            </a><!-- logo-->
            <p class="title-head">Student E-Profile</p>
            <div class="d-flex order-lg-2 ml-auto header-rightmenu" style="color: #fff;">
                <div class="dropdown">
                    <a class="nav-link icon full-screen-link" id="fullscreen-button">
                        <i class="fe fe-maximize-2"></i>
                    </a>
                </div><!-- full-screen -->
                <div class="dropdown header-notify">
                    <a class="nav-link icon" data-toggle="dropdown" aria-expanded="false">
                        <i class="fe fe-bell "></i>
                        <span class="pulse bg-success"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow ">
                        <a href="#" class="dropdown-item text-center">4 New Notifications</a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item d-flex pb-3">
                            <div class="notifyimg bg-green">
                                <i class="fe fe-mail"></i>
                            </div>
                            <div>
                                <strong>Message Sent.</strong>
                                <div class="small text-muted">12 mins ago</div>
                            </div>
                        </a>
                        <a href="#" class="dropdown-item d-flex pb-3">
                            <div class="notifyimg bg-pink">
                                <i class="fe fe-shopping-cart"></i>
                            </div>
                            <div>
                                <strong>Order Placed</strong>
                                <div class="small text-muted">2 hour ago</div>
                            </div>
                        </a>
                        <a href="#" class="dropdown-item d-flex pb-3">
                            <div class="notifyimg bg-blue">
                                <i class="fe fe-calendar"></i>
                            </div>
                            <div>
                                <strong> Event Started</strong>
                                <div class="small text-muted">1 hour ago</div>
                            </div>
                        </a>
                        <a href="#" class="dropdown-item d-flex pb-3">
                            <div class="notifyimg bg-orange">
                                <i class="fe fe-monitor"></i>
                            </div>
                            <div>
                                <strong>Your Admin Lanuch</strong>
                                <div class="small text-muted">2 days ago</div>
                            </div>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item text-center">View all Notifications</a>
                    </div>
                </div><!-- notifications -->

                <a href="javascript:void(0)" class="nav-link siderbar-link" style="color: #fff;">
                    <span style="color: #000;">
                        <strong>
                            @php
                            if(Session::get('admin_id')){
                            echo Session::get('admin_fullname');
                            }
                            else if(Session::get('lecturer_id')){
                            echo Session::get('lecturer_fullname');
                            }
                            @endphp
                        </strong>
                    </span>
                </a>

                <div class="dropdown">
                    <a href="{{ url('admin/logout') }}" class="nav-link icon siderbar-link" data-toggle="sidebar-right"
                        data-target=".sidebar-right" style="color: #fff;">
                        <i class="fa fa-sign-out"></i>
                    </a>
                </div><!-- Right-siebar-->
            </div>
        </div>
    </div>
</div>
<!--app-header end-->
