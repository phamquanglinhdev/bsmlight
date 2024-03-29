<!DOCTYPE html>

<html lang="en" class="dark-style layout-compact layout-navbar-fixed layout-menu-fixed"
      dir="ltr" data-theme="theme-default" data-assets-path="{{url('/demo/assets/')}}"
      data-base-url="https://demos.themeselection.com/materio-bootstrap-html-laravel-admin-template/demo-1"
      data-framework="laravel" data-template="vertical-menu-theme-default-dark">
<meta http-equiv="content-type" content="text/html;charset=UTF-8"/>
@include("layouts.inc.header")

<body>
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        @include("components.menu")
        <!-- Layout page -->
        <div class="layout-page">

            @include("components.navbar")

            <!-- Content wrapper -->
            <div class="content-wrapper">
                @yield('content')
                <div class="content-backdrop fade"></div>
            </div>
        </div>
    </div>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>
    <!-- Drag Target Area To SlideIn Menu On Small Screens -->
    <div class="drag-target"></div>
</div>
<!-- / Layout wrapper -->
<!--/ Layout Content -->

@include('layouts.inc.fb-chat')
@include("layouts.inc.footer")
@stack("after_scripts")
@if(session('success'))
    <script>
        toastr.options = {
            closeButton: true,
            progressBar: true,
            positionClass: 'toast-top-right',
            timeOut: 2000
        };
        toastr.success('{{session('success')}}', 'Thành công');
    </script>
@endif

@include("layouts.inc.notification")

</body>
</html>
