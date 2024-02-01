@php use Illuminate\Support\Facades\Auth; @endphp
@php
    $user = Auth::user()
@endphp
<nav class="layout-navbar container-fluid pe-5 navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
     id="layout-navbar">

    <!--  Brand demo (display only for navbar-full and hide on below xl) -->

    <!-- ! Not required for layout-without-menu -->
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0  d-xl-none ">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
            <i class="mdi mdi-menu mdi-24px"></i>
        </a>
    </div>

    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">

        <!-- Search -->
        <div class="navbar-nav align-items-center">
            <div class="nav-item navbar-search-wrapper mb-0">
                <a class="nav-item nav-link search-togglers fw-normal px-0 d-flex align-items-center"
                   href="javascript:void(0);">
                    <i class="mdi mdi-magnify mdi-24px scaleX-n1-rtl me-2"></i>
                    <input class="border-none d-none form-control d-md-inline-block text-muted"
                           placeholder="Tìm kiếm trên BSM (Ctrl+/)">
                </a>
            </div>
        </div>
        <!-- /Search -->
        <ul class="navbar-nav flex-row align-items-center ms-auto">

            <!-- Language -->
            <li class="nav-item dropdown-language dropdown me-1 me-xl-0">
                <a class="nav-link btn btn-text-secondary rounded-pill btn-icon dropdown-toggle hide-arrow"
                   href="javascript:void(0);" data-bs-toggle="dropdown">
                    <i class='mdi mdi-translate mdi-24px'></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end py-2">
                    <li>
                        <a class="dropdown-item active" href="index.html" data-language="en">
                            <span class="align-middle">English</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item " href="index.html" data-language="fr">
                            <span class="align-middle">French</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item " href="index.html" data-language="de">
                            <span class="align-middle">German</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item " href="index.html" data-language="pt">
                            <span class="align-middle">Portuguese</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!--/ Language -->

            <!-- Style Switcher -->
            <li class="nav-item dropdown-style-switcher dropdown me-2 me-xl-0">
                <a class="nav-link btn btn-text-secondary rounded-pill btn-icon dropdown-toggle hide-arrow"
                   href="javascript:void(0);" data-bs-toggle="dropdown">
                    <i class='mdi mdi-24px'></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-styles">
                    <li>
                        <a class="dropdown-item" href="javascript:void(0);" data-theme="light">
                            <span class="align-middle"><i class='mdi mdi-weather-sunny me-2'></i>Light</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="javascript:void(0);" data-theme="dark">
                            <span class="align-middle"><i class="mdi mdi-weather-night me-2"></i>Dark</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="javascript:void(0);" data-theme="system">
                            <span class="align-middle"><i class="mdi mdi-monitor me-2"></i>System</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!-- / Style Switcher-->

            <!-- Quick links  -->
            <li class="nav-item dropdown-shortcuts navbar-dropdown dropdown me-1 me-xl-0">
                <a class="nav-link btn btn-text-secondary rounded-pill btn-icon dropdown-toggle hide-arrow"
                   href="javascript:void(0);" data-bs-toggle="dropdown" data-bs-auto-close="outside"
                   aria-expanded="false">
                    <i class='mdi mdi-view-grid-outline mdi-24px'></i>
                </a>
                <div class="dropdown-menu dropdown-menu-end py-0">
                    <div class="dropdown-menu-header border-bottom">
                        <div class="dropdown-header d-flex align-items-center py-3">
                            <h6 class="mb-0 me-auto">Shortcuts</h6>
                            <a href="javascript:void(0)" class="dropdown-shortcuts-add text-heading"
                               data-bs-toggle="tooltip" data-bs-placement="top" title="Add shortcuts"><i
                                    class="mdi mdi-plus mdi-24px"></i></a>
                        </div>
                    </div>
                    <div class="dropdown-shortcuts-list scrollable-container">
                        <div class="row row-bordered overflow-visible g-0">
                            <div class="dropdown-shortcuts-item col">
                    <span class="dropdown-shortcuts-icon bg-label-secondary text-heading rounded-circle mb-3">
                      <i class="mdi mdi-calendar-blank mdi-24px"></i>
                    </span>
                                <a href="app/calendar.html" class="stretched-link">Calendar</a>
                                <small>Appointments</small>
                            </div>
                            <div class="dropdown-shortcuts-item col">
                    <span class="dropdown-shortcuts-icon bg-label-secondary text-heading rounded-circle mb-3">
                      <i class="mdi mdi mdi-content-paste mdi-24px"></i>
                    </span>
                                <a href="app/invoice/list.html" class="stretched-link">Invoice App</a>
                                <small>Manage Accounts</small>
                            </div>
                        </div>
                        <div class="row row-bordered overflow-visible g-0">
                            <div class="dropdown-shortcuts-item col">
                    <span class="dropdown-shortcuts-icon bg-label-secondary text-heading rounded-circle mb-3">
                      <i class="mdi mdi-account-outline mdi-24px"></i>
                    </span>
                                <a href="app/user/list.html" class="stretched-link">User App</a>
                                <small>Manage Users</small>
                            </div>
                            <div class="dropdown-shortcuts-item col">
                    <span class="dropdown-shortcuts-icon bg-label-secondary text-heading rounded-circle mb-3">
                      <i class="mdi mdi-shield-check-outline mdi-24px"></i>
                    </span>
                                <a href="app/access-roles.html" class="stretched-link">Role Management</a>
                                <small>Permission</small>
                            </div>
                        </div>
                        <div class="row row-bordered overflow-visible g-0">
                            <div class="dropdown-shortcuts-item col">
                    <span class="dropdown-shortcuts-icon bg-label-secondary text-heading rounded-circle mb-3">
                      <i class="mdi mdi-monitor mdi-24px"></i>
                    </span>
                                <a href="https://demos.themeselection.com/materio-bootstrap-html-laravel-admin-template/demo-1"
                                   class="stretched-link">Dashboard</a>
                                <small>Analytics</small>
                            </div>
                            <div class="dropdown-shortcuts-item col">
                    <span class="dropdown-shortcuts-icon bg-label-secondary text-heading rounded-circle mb-3">
                      <i class="mdi mdi-cog-outline mdi-24px"></i>
                    </span>
                                <a href="pages/account-settings-account.html" class="stretched-link">Setting</a>
                                <small>Account Settings</small>
                            </div>
                        </div>
                        <div class="row row-bordered overflow-visible g-0">
                            <div class="dropdown-shortcuts-item col">
                    <span class="dropdown-shortcuts-icon bg-label-secondary text-heading rounded-circle mb-3">
                      <i class="mdi mdi-help-circle-outline mdi-24px"></i>
                    </span>
                                <a href="pages/faq.html" class="stretched-link">FAQs</a>
                                <small class="text-muted mb-0">FAQs & Articles</small>
                            </div>
                            <div class="dropdown-shortcuts-item col">
                    <span class="dropdown-shortcuts-icon bg-label-secondary text-heading rounded-circle mb-3">
                      <i class="mdi mdi-dock-window mdi-24px"></i>
                    </span>
                                <a href="modal-examples.html" class="stretched-link">Modals</a>
                                <small>Useful Popups</small>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            <!-- Quick links -->

            <!-- Notification -->
            <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-2 me-xl-1">
                <a class="nav-link btn btn-text-secondary rounded-pill btn-icon dropdown-toggle hide-arrow"
                   href="javascript:void(0);" data-bs-toggle="dropdown" data-bs-auto-close="outside"
                   aria-expanded="false">
                    <i class="mdi mdi-bell-outline mdi-24px"></i>
                    <span
                        class="position-absolute top-0 start-50 translate-middle-y badge badge-dot bg-danger mt-2 border"></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end py-0">
                    <li class="dropdown-menu-header border-bottom">
                        <div class="dropdown-header d-flex align-items-center py-3">
                            <h6 class="fw-normal mb-0 me-auto">Thông báo</h6>
{{--                            <span class="badge rounded-pill bg-label-primary">8 New</span>--}}
                        </div>
                    </li>
                    <li class="dropdown-notifications-list scrollable-container">
                        <ul class="list-group list-group-flush">
                           @include("notification-list")
                        </ul>
                    </li>
{{--                    <li class="dropdown-menu-footer border-top p-3">--}}
{{--                        <a href="" class="btn btn-primary d-flex justify-content-center">Đánh d</a>--}}
{{--                    </li>--}}
                </ul>
            </li>
            <!--/ Notification -->

            <!-- User -->
            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow p-0" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                        <img src="{{$user->avatar}}" alt class="w-px-40 h-auto rounded-circle">
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end mt-3 py-2">
                    <li>
                        <a class="dropdown-item pb-2 mb-1" href="#">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-2 pe-1">
                                    <div class="avatar avatar-online">
                                        <img src="{{$user->avatar}}" alt
                                             class="w-px-40 h-auto rounded-circle">
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0">
                                        {{$user->name}}
                                    </h6>
                                    <small class="text-muted">{{$user->uuid}}</small>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <div class="dropdown-divider my-0"></div>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{url("/profile")}}">
                            <i class="mdi mdi-account-outline me-1 mdi-20px"></i>
                            <span class="align-middle">Thông tin cá nhân</span>
                        </a>
                    </li>
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{url('logout')}}">
                            <i class="mdi mdi-logout me-1 mdi-20px"></i>
                            <span class="align-middle">Đăng xuất</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!--/ User -->
        </ul>
    </div>

    <!-- Search Small Screens -->
    <div class="navbar-search-wrapper search-input-wrapper  d-none">
        <input type="text" class="form-control search-input container-xxl border-0" placeholder="Search..."
               aria-label="Search...">
        <i class="mdi mdi-close search-toggler cursor-pointer"></i>
    </div>
    <!--/ Search Small Screens -->
</nav>
