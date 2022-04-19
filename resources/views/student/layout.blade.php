<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- bootstrap 4.3.1 -->
    <link rel="stylesheet" href="{{ asset('public/student/css/vendor/bootstrap.min.css') }}">
    <!-- styles -->
    <link rel="stylesheet" href="{{ asset('public/student/css/styles.min.css') }}">
    <!-- simplebar styles -->
    <link rel="stylesheet" href="{{ asset('public/student/css/vendor/simplebar.css') }}">
    <!-- tiny-slider styles -->
    <link rel="stylesheet" href="{{ asset('public/student/css/vendor/tiny-slider.css') }}">
    <!-- favicon -->
    <link href="{{ asset('public/lecturer/fonts/fonts/font-awesome.min.css') }}" rel="stylesheet">
    <link rel="icon" href="{{ asset('public/student/img/vlu.ico') }}">
    <title>Home</title>
    @if (Session::get('student_id'))
    <meta name="student-id" content="{{ Session::get('student_id') }}">
    @endif
</head>

<body>
    @include('student.panels.loader')
    <div id="app">
        @include('student.panels.slidebar')

        @include('student.panels.header')

        @yield('student-content')
    </div>
    @include('student.panels.footer')
    <!-- app -->
    <script src="{{ asset('public/student/js/utils/app.js') }}"></script>
    <!-- page loader -->
    <script src="{{ asset('public/student/js/utils/page-loader.js') }}"></script>
    <!-- simplebar -->
    <script src="{{ asset('public/student/js/vendor/simplebar.min.js') }}"></script>
    <!-- liquidify -->
    <script src="{{ asset('public/student/js/utils/liquidify.js') }}"></script>
    <!-- XM_Plugins -->
    <script src="{{ asset('public/student/js/vendor/xm_plugins.min.js') }}"></script>
    <!-- tiny-slider -->
    <script src="{{ asset('public/student/js/vendor/tiny-slider.min.js') }}"></script>
    <!-- chartJS -->
    <script src="{{ asset('public/student/js/vendor/Chart.bundle.min.js') }}"></script>
    <!-- global.hexagons -->
    <script src="{{ asset('public/student/js/global/global.hexagons.js') }}"></script>
    <!-- global.tooltips -->
    <script src="{{ asset('public/student/js/global/global.tooltips.js') }}"></script>
    <!-- global.popups -->
    <script src="{{ asset('public/student/js/global/global.popups.js') }}"></script>
    <!-- global.charts -->
    <script src="{{ asset('public/student/js/global/global.charts.js') }}"></script>
    <!-- header -->
    <script src="{{ asset('public/student/js/header/header.js') }}"></script>
    <!-- sidebar -->
    <script src="{{ asset('public/student/js/sidebar/sidebar.js') }}"></script>
    <!-- content -->
    <script src="{{ asset('public/student/js/content/content.js') }}"></script>
    <!-- form.utils -->
    <script src="{{ asset('public/student/js/form/form.utils.js') }}"></script>
    <!-- SVG icons -->
    <script src="{{ asset('public/student/js/utils/svg-loader.js') }}"></script>
    <script src="{{ asset('public/lecturer/js/vendors/jquery-3.2.1.min.js') }}"></script>

    <script src="{{ asset('public/js/app.js') }}"></script>
</body>

</html>
