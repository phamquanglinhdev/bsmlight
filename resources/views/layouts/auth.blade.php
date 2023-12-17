<!DOCTYPE html>

<html lang="en" class="light-style layout-compact layout-navbar-fixed layout-menu-fixed     " dir="ltr"
      data-theme="theme-default"
      data-assets-path="https://demos.themeselection.com/materio-bootstrap-html-laravel-admin-template/demo/assets/"
      data-base-url="https://demos.themeselection.com/materio-bootstrap-html-laravel-admin-template/demo-1"
      data-framework="laravel" data-template="vertical-menu-theme-default-light">
<meta http-equiv="content-type" content="text/html;charset=UTF-8"/>
@include("layouts.inc.header")
<link rel="stylesheet" href="{{asset("demo/assets/vendor/css/pages/page-auth.css")}}">
<body>
@yield('content')
<!-- / Layout wrapper -->
<!--/ Layout Content -->


@include("layouts.inc.footer")
@stack("after_scripts")
@if(session('success'))
    <script>
        toastr.options = {
            closeButton: true,
            progressBar: true,
            positionClass: 'toast-top-right',
            timeOut: 2000 // Thời gian hiển thị thông báo (5 giây)
        };
        toastr.success('{{session('success')}}', 'Thành công');
    </script>
@endif
@error('uuid')
<script>
    toastr.options = {
        closeButton: true,
        progressBar: true,
        positionClass: 'toast-top-right',
        timeOut: 2000 // Thời gian hiển thị thông báo (5 giây)
    };
    toastr.error('{{$message}}', 'Không thành công');
</script>
@enderror
@error('password')
<script>
    toastr.options = {
        closeButton: true,
        progressBar: true,
        positionClass: 'toast-top-right',
        timeOut: 2000 // Thời gian hiển thị thông báo (5 giây)
    };
    toastr.error('{{$message}}', 'Không thành công');
</script>
@enderror
@error('email')
<script>
    toastr.options = {
        closeButton: true,
        progressBar: true,
        positionClass: 'toast-top-right',
        timeOut: 2000 // Thời gian hiển thị thông báo (5 giây)
    };
    toastr.error('{{$message}}', 'Không thành công');
</script>
@enderror
@error('verified_code')
<script>
    toastr.options = {
        closeButton: true,
        progressBar: true,
        positionClass: 'toast-top-right',
        timeOut: 2000 // Thời gian hiển thị thông báo (5 giây)
    };
    toastr.error('{{$message}}', 'Không thành công');
</script>
@enderror

@if ($errors->any())
    @foreach ($errors->all() as $error)
        <script>
            toastr.options = {
                closeButton: true,
                progressBar: true,
                positionClass: 'toast-top-right',
                timeOut: 2000
            };
            toastr.error('{{$error}}', 'Không thành công');
        </script>
    @endforeach
@endif
@if(session('success'))
    <script>
        toastr.options = {
            closeButton: true,
            progressBar: true,
            positionClass: 'toast-top-right',
            timeOut: 2000 // Thời gian hiển thị thông báo (5 giây)
        };
        toastr.success('{{session('success')}}', 'Thành công');
    </script>
@endif
</body>
</html>
