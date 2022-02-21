<!-- NAVIGATION WIDGET -->
<div>
    <nav class="navigation-widget navigation-widget-desktop sidebar left" data-simplebar>
        <!-- NAVIGATION WIDGET COVER -->
        <figure class="navigation-widget-cover liquid">
            <img src="" alt="cover-01" />
        </figure>
        <!-- /NAVIGATION WIDGET COVER -->

        <!-- USER SHORT DESCRIPTION -->
        <div class="user-short-description">
            <!-- USER SHORT DESCRIPTION AVATAR -->
            <a class="user-short-description-avatar user-avatar medium" href="#">
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
            <p class="user-short-description-title">
                <a href="#">
                    @php
                    echo Session::get('student_fullname')
                    @endphp
                </a>
            </p>
            <!-- /USER SHORT DESCRIPTION TITLE -->

            <!-- USER SHORT DESCRIPTION TEXT -->
            <p class="user-short-description-text">
                <a href="#">
                    @php
                    echo Session::get('student_email')
                    @endphp
                </a>
            </p>
            <!-- /USER SHORT DESCRIPTION TEXT -->
        </div>
        <!-- /USER SHORT DESCRIPTION -->

        <!-- MENU -->
        <small-slidebar-component></small-slidebar-component>
        <!-- /MENU -->
    </nav>
</div>
<!-- /NAVIGATION WIDGET -->
