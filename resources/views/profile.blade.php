@php use App\Helper\ProfileBag; @endphp
@php
    /**
     * @var ProfileBag $profileBag
     */
    $userProfile= $profileBag->getUserProfileObject();
@endphp
@extends('layouts.app')
@section('content')
    <div class="content-wrapper">

        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">

            <h4 class="py-3 mb-4">
                <span class="text-muted fw-light">User / View /</span> Account
            </h4>
            <div class="row">
                <!-- User Sidebar -->
                <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
                    <!-- User Card -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="user-avatar-section">
                                <div class=" d-flex align-items-center flex-column">
                                    <img class="img-fluid rounded mb-3 mt-4"
                                         src="{{$userProfile->getAvatar()}}" height="120" width="120"
                                         alt="User avatar"/>
                                    <div class="user-info text-center">
                                        <h4>{{$userProfile->getName()}}</h4>
                                        <span class="badge bg-label-danger rounded-pill">{{$userProfile->getRoleLabel()}}</span>
                                    </div>
                                </div>
                            </div>
{{--                            <div class="d-flex justify-content-between flex-wrap my-2 py-3">--}}
{{--                                <div class="d-flex align-items-center me-4 mt-3 gap-3">--}}
{{--                                    <div class="avatar">--}}
{{--                                        <div class="avatar-initial bg-label-primary rounded">--}}
{{--                                            <i class='mdi mdi-check mdi-24px'></i>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div>--}}
{{--                                        <h4 class="mb-0">1.23k</h4>--}}
{{--                                        <span>Tasks Done</span>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="d-flex align-items-center mt-3 gap-3">--}}
{{--                                    <div class="avatar">--}}
{{--                                        <div class="avatar-initial bg-label-primary rounded">--}}
{{--                                            <i class='mdi mdi-star-outline mdi-24px'></i>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div>--}}
{{--                                        <h4 class="mb-0">568</h4>--}}
{{--                                        <span>Projects Done</span>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                            <h5 class="pb-3 border-bottom mb-3">Thong tin</h5>
                            <div class="info-container">
                                <ul class="list-unstyled mb-4">
                                    <li class="mb-3">
                                        <span class="h6">Username:</span>
                                        <span>{{$userProfile->getUuid()}}</span>
                                    </li>
                                    <li class="mb-3">
                                        <span class="h6">Email:</span>
                                        <span>{{$userProfile->getEmail()}}</span>
                                    </li>
{{--                                    <li class="mb-3">--}}
{{--                                        <span class="h6">Status:</span>--}}
{{--                                        <span class="badge bg-label-success rounded-pill">Active</span>--}}
{{--                                    </li>--}}
{{--                                    <li class="mb-3">--}}
{{--                                        <span class="h6">Role:</span>--}}
{{--                                        <span>Author</span>--}}
{{--                                    </li>--}}
                                    <li class="mb-3">
                                        <span class="h6">SDT:</span>
                                        <span>{{$userProfile->getPhone()}}</span>
                                    </li>
                                    <li class="mb-3">
                                        <span class="h6">Chi nhanh:</span>
                                        <span>{{$userProfile->getBranch()}}</span>
                                    </li>
                                </ul>
                                <div class="d-flex justify-content-center">
                                    <a href="{{url($profileBag->getEntity()."/edit/".$userProfile->getId())}}" class="btn btn-primary me-3" >Sua</a>
{{--                                    <a href="javascript:;" class="btn btn-outline-danger suspend-user">Xoa</a>--}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="pb-3 border-bottom mb-3">Thong tin bo sung</h5>
                            <div class="info-container">
                                <ul class="list-unstyled mb-4">
                                    @foreach($profileBag->getCustomFields() as $customField)
                                        <li class="mb-3">
                                            <span class="h6">{{$customField->getLabel()}}:</span>
                                            <span>{{$customField->getValue()}}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- /User Card -->
                    <!-- Plan Card -->
{{--                    <div class="card mb-4 border-2 border-primary">--}}
{{--                        <div class="card-body">--}}
{{--                            <div class="d-flex justify-content-between align-items-start">--}}
{{--                                <span class="badge bg-label-primary rounded-pill">Standard</span>--}}
{{--                                <div class="d-flex justify-content-center">--}}
{{--                                    <sub class="h5 pricing-currency mt-auto mb-2  text-primary">$</sub>--}}
{{--                                    <h1 class="display-3 mb-0 text-primary">99</h1>--}}
{{--                                    <sub class="h6 pricing-duration mt-auto mb-2 fw-normal">month</sub>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <ul class="list-unstyled g-2 my-4 ms-n2">--}}
{{--                                <li class="mb-2 d-flex align-items-center "><i--}}
{{--                                        class="mdi mdi-circle-medium text-lighter mdi-24px"></i><span>10 Users</span>--}}
{{--                                </li>--}}
{{--                                <li class="mb-2 d-flex align-items-center "><i--}}
{{--                                        class="mdi mdi-circle-medium text-lighter mdi-24px"></i><span>Up to 10 GB storage</span>--}}
{{--                                </li>--}}
{{--                                <li class="mb-2 d-flex align-items-center "><i--}}
{{--                                        class="mdi mdi-circle-medium text-lighter mdi-24px"></i><span>Basic Support</span>--}}
{{--                                </li>--}}
{{--                            </ul>--}}
{{--                            <div class="d-flex justify-content-between align-items-center mb-1">--}}
{{--                                <span class="h6 mb-0">Days</span>--}}
{{--                                <span class="h6 mb-0">65%</span>--}}
{{--                            </div>--}}
{{--                            <div class="progress mb-1 rounded" style="height: 6px;">--}}
{{--                                <div class="progress-bar rounded" role="progressbar" style="width: 65%;"--}}
{{--                                     aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>--}}
{{--                            </div>--}}
{{--                            <span>4 days remaining</span>--}}
{{--                            <div class="d-grid w-100 mt-4">--}}
{{--                                <button class="btn btn-primary" data-bs-target="#upgradePlanModal"--}}
{{--                                        data-bs-toggle="modal">Upgrade Plan--}}
{{--                                </button>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                    <!-- /Plan Card -->
                </div>
                <!--/ User Sidebar -->


                <!-- User Content -->
{{--                <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">--}}
{{--                    <!-- User Tabs -->--}}
{{--                    <ul class="nav nav-pills flex-column flex-md-row flex-wrap mb-4">--}}
{{--                        <li class="nav-item"><a class="nav-link active" href="javascript:void(0);"><i--}}
{{--                                    class="mdi mdi-account-outline mdi-20px me-1"></i>Account</a></li>--}}
{{--                        <li class="nav-item"><a class="nav-link" href="security.html"><i--}}
{{--                                    class="mdi mdi-lock-open-outline mdi-20px me-1"></i>Security</a></li>--}}
{{--                        <li class="nav-item"><a class="nav-link" href="billing.html"><i--}}
{{--                                    class="mdi mdi-bookmark-outline mdi-20px me-1"></i>Billing & Plans</a></li>--}}
{{--                        <li class="nav-item"><a class="nav-link" href="notifications.html"><i--}}
{{--                                    class="mdi mdi-bell-outline mdi-20px me-1"></i>Notifications</a></li>--}}
{{--                        <li class="nav-item"><a class="nav-link" href="connections.html"><i--}}
{{--                                    class="mdi mdi-link mdi-20px me-1"></i>Connections</a></li>--}}
{{--                    </ul>--}}
{{--                    <!--/ User Tabs -->--}}

{{--                    <!-- Project table -->--}}
{{--                    <div class="card mb-4">--}}
{{--                        <h5 class="card-header">User's Projects List</h5>--}}
{{--                        <div class="card-datatable table-responsive">--}}
{{--                            <table class="table datatable-project">--}}
{{--                                <thead class="table-light">--}}
{{--                                <tr>--}}
{{--                                    <th></th>--}}
{{--                                    <th></th>--}}
{{--                                    <th>Project</th>--}}
{{--                                    <th class="text-nowrap">Total Task</th>--}}
{{--                                    <th>Progress</th>--}}
{{--                                    <th>Hours</th>--}}
{{--                                </tr>--}}
{{--                                </thead>--}}
{{--                            </table>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <!-- /Project table -->--}}

{{--                    <!-- Activity Timeline -->--}}
{{--                    <div class="card mb-4">--}}
{{--                        <h5 class="card-header">User Activity Timeline</h5>--}}
{{--                        <div class="card-body pb-0 pt-3">--}}
{{--                            <ul class="timeline mb-0">--}}
{{--                                <li class="timeline-item timeline-item-transparent">--}}
{{--                                    <span class="timeline-point timeline-point-danger"></span>--}}
{{--                                    <div class="timeline-event">--}}
{{--                                        <div class="timeline-header mb-1">--}}
{{--                                            <h6 class="mb-0">12 Invoices have been paid</h6>--}}
{{--                                            <span class="text-muted">12 min ago</span>--}}
{{--                                        </div>--}}
{{--                                        <p class="text-muted mb-2">Invoices have been paid to the company</p>--}}
{{--                                        <div class="d-flex">--}}
{{--                                            <a href="javascript:void(0)" class="me-3">--}}
{{--                                                <img src="../../../../demo/assets/img/icons/misc/pdf.png"--}}
{{--                                                     alt="PDF image" width="15" class="me-2">--}}
{{--                                                <span class="fw-medium text-heading">invoices.pdf</span>--}}
{{--                                            </a>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </li>--}}
{{--                                <li class="timeline-item timeline-item-transparent">--}}
{{--                                    <span class="timeline-point timeline-point-primary"></span>--}}
{{--                                    <div class="timeline-event">--}}
{{--                                        <div class="timeline-header mb-1">--}}
{{--                                            <h6 class="mb-0">Client Meeting</h6>--}}
{{--                                            <span class="text-muted">45 min ago</span>--}}
{{--                                        </div>--}}
{{--                                        <p class="text-muted mb-2">Project meeting with john @10:15am</p>--}}
{{--                                        <div class="d-flex flex-wrap">--}}
{{--                                            <div class="avatar me-3">--}}
{{--                                                <img src="../../../../demo/assets/img/avatars/3.png" alt="Avatar"--}}
{{--                                                     class="rounded-circle"/>--}}
{{--                                            </div>--}}
{{--                                            <div>--}}
{{--                                                <h6 class="mb-0">Lester McCarthy (Client)</h6>--}}
{{--                                                <span class="text-muted">CEO of ThemeSelection</span>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </li>--}}
{{--                                <li class="timeline-item timeline-item-transparent">--}}
{{--                                    <span class="timeline-point timeline-point-warning"></span>--}}
{{--                                    <div class="timeline-event">--}}
{{--                                        <div class="timeline-header mb-1">--}}
{{--                                            <h6 class="mb-0">Create a new project for client</h6>--}}
{{--                                            <span class="text-muted">2 Day Ago</span>--}}
{{--                                        </div>--}}
{{--                                        <p class="text-muted mb-2">5 team members in a project</p>--}}
{{--                                        <div class="d-flex align-items-center avatar-group">--}}
{{--                                            <div class="avatar pull-up" data-bs-toggle="tooltip"--}}
{{--                                                 data-popup="tooltip-custom" data-bs-placement="top"--}}
{{--                                                 title="Vinnie Mostowy">--}}
{{--                                                <img src="../../../../demo/assets/img/avatars/5.png" alt="Avatar"--}}
{{--                                                     class="rounded-circle">--}}
{{--                                            </div>--}}
{{--                                            <div class="avatar pull-up" data-bs-toggle="tooltip"--}}
{{--                                                 data-popup="tooltip-custom" data-bs-placement="top"--}}
{{--                                                 title="Marrie Patty">--}}
{{--                                                <img src="../../../../demo/assets/img/avatars/12.png" alt="Avatar"--}}
{{--                                                     class="rounded-circle">--}}
{{--                                            </div>--}}
{{--                                            <div class="avatar pull-up" data-bs-toggle="tooltip"--}}
{{--                                                 data-popup="tooltip-custom" data-bs-placement="top"--}}
{{--                                                 title="Jimmy Jackson">--}}
{{--                                                <img src="../../../../demo/assets/img/avatars/9.png" alt="Avatar"--}}
{{--                                                     class="rounded-circle">--}}
{{--                                            </div>--}}
{{--                                            <div class="avatar">--}}
{{--                                                <span class="avatar-initial rounded-circle pull-up bg-lighter text-body"--}}
{{--                                                      data-bs-toggle="tooltip" data-bs-placement="bottom"--}}
{{--                                                      title="3 more">+3</span>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </li>--}}
{{--                                <li class="timeline-item timeline-item-transparent border-transparent">--}}
{{--                                    <span class="timeline-point timeline-point-info"></span>--}}
{{--                                    <div class="timeline-event">--}}
{{--                                        <div class="timeline-header mb-1">--}}
{{--                                            <h6 class="mb-0">Design Review</h6>--}}
{{--                                            <span class="text-muted">5 days Ago</span>--}}
{{--                                        </div>--}}
{{--                                        <p class="text-muted mb-0">Weekly review of freshly prepared design for our new--}}
{{--                                            app.</p>--}}
{{--                                    </div>--}}
{{--                                </li>--}}
{{--                            </ul>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <!-- /Activity Timeline -->--}}

{{--                    <!-- Invoice table -->--}}
{{--                    <div class="card mb-4">--}}
{{--                        <div class="card-datatable table-responsive">--}}
{{--                            <table class="table datatable-invoice">--}}
{{--                                <thead class="table-light">--}}
{{--                                <tr>--}}
{{--                                    <th></th>--}}
{{--                                    <th>ID</th>--}}
{{--                                    <th><i class='mdi mdi-trending-up'></i></th>--}}
{{--                                    <th>Total</th>--}}
{{--                                    <th>Issued Date</th>--}}
{{--                                    <th>Actions</th>--}}
{{--                                </tr>--}}
{{--                                </thead>--}}
{{--                            </table>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <!-- /Invoice table -->--}}
{{--                </div>--}}
                <!--/ User Content -->
            </div>
        </div>
        <div class="content-backdrop fade"></div>
    </div>
@endsection
