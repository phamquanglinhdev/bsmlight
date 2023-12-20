<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

    <!-- ! Hide app brand if navbar-full -->
    <div class="app-brand demo">
        <a href="{{url('/')}}" class="app-brand-link">
            <span class="app-brand-text demo menu-text fw-semibold ms-2">BSM</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="mdi menu-toggle-icon d-xl-block align-middle mdi-20px"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <li class="menu-item">
            <a href="{{url("/")}}" class="menu-link" >
                <i class="menu-icon tf-icons mdi mdi-home-outline"></i>
                <div>Bảng điều khiển</div>
            </a>
        </li>
        @if(check_permission('list student'))
            <li class="menu-item">
                <a href="{{url("/student/list")}}" class="menu-link" >
                    <i class="menu-icon tf-icons mdi mdi-account-group"></i>
                    <div>Học sinh</div>
                </a>
            </li>
        @endif
        @if(check_permission('list teacher'))
            <li class="menu-item">
                <a href="{{url("/teacher/list")}}" class="menu-link" >
                    <i class="menu-icon tf-icons mdi mdi-human-male-board"></i>
                    <div>Giáo viên</div>
                </a>
            </li>
        @endif
        @if(check_permission('list supporter'))
            <li class="menu-item">
                <a href="{{url("/supporter/list")}}" class="menu-link" >
                    <i class="menu-icon tf-icons mdi mdi-account-multiple"></i>
                    <div>Trợ giảng</div>
                </a>
            </li>
        @endif
        @if(force_permission('list staff'))
            <li class="menu-item">
                <a href="{{url("/staff/list")}}" class="menu-link" >
                    <i class="menu-icon tf-icons mdi mdi-shield-account"></i>
                    <div>Nhân viên</div>
                </a>
            </li>
        @endif
        @if(force_permission('list card'))
            <li class="menu-item">
                <a href="{{url("/card/list")}}" class="menu-link" >
                    <i class="menu-icon tf-icons mdi mdi-shield-account"></i>
                    <div>Thẻ học</div>
                </a>
            </li>
        @endif
        @if(force_permission('list branch'))
            <li class="menu-item">
                <a href="{{url("/branch/list")}}" class="menu-link" >
                    <i class="menu-icon tf-icons mdi mdi-office-building-plus"></i>
                    <div>Chi nhánh</div>
                </a>
            </li>
        @endif


{{--        <li class="menu-item ">--}}
{{--            <a data-dir="https://demos.themeselection.com/materio-bootstrap-html-laravel-admin-template/demo-1/aewsome" href="javascript:void(0);" class="menu-link menu-toggle" >--}}
{{--                <i class="menu-icon tf-icons mdi mdi-window-maximize"></i>--}}
{{--                <div>Layouts</div>--}}
{{--            </a>--}}


{{--            <ul class="menu-sub">--}}



{{--                <li class="menu-item ">--}}
{{--                    <a href="layouts/collapsed-menu.html" class="menu-link" >--}}
{{--                        <div>Collapsed menu</div>--}}
{{--                    </a>--}}


{{--                </li>--}}



{{--                <li class="menu-item ">--}}
{{--                    <a href="layouts/content-navbar.html" class="menu-link" >--}}
{{--                        <div>Content navbar</div>--}}
{{--                    </a>--}}


{{--                </li>--}}



{{--                <li class="menu-item ">--}}
{{--                    <a href="layouts/content-nav-sidebar.html" class="menu-link" >--}}
{{--                        <div>Content nav + Sidebar</div>--}}
{{--                    </a>--}}


{{--                </li>--}}



{{--                <li class="menu-item ">--}}
{{--                    <a href="layouts/horizontal.html" class="menu-link"  target="_blank" >--}}
{{--                        <div>Horizontal</div>--}}
{{--                    </a>--}}


{{--                </li>--}}



{{--                <li class="menu-item ">--}}
{{--                    <a href="layouts/without-menu.html" class="menu-link" >--}}
{{--                        <div>Without menu</div>--}}
{{--                    </a>--}}


{{--                </li>--}}



{{--                <li class="menu-item ">--}}
{{--                    <a href="layouts/without-navbar.html" class="menu-link" >--}}
{{--                        <div>Without navbar</div>--}}
{{--                    </a>--}}


{{--                </li>--}}



{{--                <li class="menu-item ">--}}
{{--                    <a href="layouts/fluid.html" class="menu-link" >--}}
{{--                        <div>Fluid</div>--}}
{{--                    </a>--}}


{{--                </li>--}}



{{--                <li class="menu-item ">--}}
{{--                    <a href="layouts/container.html" class="menu-link" >--}}
{{--                        <div>Container</div>--}}
{{--                    </a>--}}


{{--                </li>--}}



{{--                <li class="menu-item ">--}}
{{--                    <a href="layouts/blank.html" class="menu-link"  target="_blank" >--}}
{{--                        <div>Blank</div>--}}
{{--                    </a>--}}


{{--                </li>--}}
{{--            </ul>--}}
{{--        </li>--}}
    </ul>
</aside>
