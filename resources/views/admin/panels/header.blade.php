<!--app-header-->
<div class="app-header header d-flex">
    <div class="container-fluid">
        <div class="d-flex">
            <a class="header-brand" href="{{ url('admin/') }}">
                <img src="{{asset('public/lecturer/images/brand/vlu.png')}}" class="header-brand-img main-logo" alt="VLU">
                <img src="{{asset('public/lecturer/images/vlu.ico')}}" class="header-brand-img icon-logo" alt="VLU">
            </a><!-- logo-->
            <p class="title-head">Student E-Profile</p>
            <div class="d-flex order-lg-2 ml-auto header-rightmenu" style="color: #fff;">
                <div>
                    <p class="nav-link icon full-screen-link" id="fullscreen-button">
                        <i class="fe fe-maximize-2"></i>
                    </p>
                </div><!-- full-screen -->

                @if (Session::get('admin_id'))
                <admin-notification></admin-notification>
                @elseif (Session::get('lecturer_id'))
                @foreach ($check_role as $check)
                @if ($check->lecturer_role==1)
                <lecturer-notification></lecturer-notification>
                @elseif ($check->lecturer_role==2)
                <formteacher-notification></formteacher-notification>
                @endif
                @endforeach
                @endif

                <div>
                    <a href="javascript:void(0)" class="siderbar-link nav-link name" style="color: #fff;">
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
                </div>


                <a href="{{ url('admin/logout') }}" class="nav-link name siderbar-link" data-toggle="sidebar-right" data-target=".sidebar-right"
                    style="color: #fff; font-size: 20px">
                    <i class="fa fa-sign-out"></i>
                </a>
            </div>
        </div>
    </div>
</div>
<!--app-header end-->
