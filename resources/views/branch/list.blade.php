@php
    /**
     * @var \App\Models\User $user
 * @var \App\Helper\CrudBag $crudBag
 * @var \App\Helper\ListViewModel $listViewModel
     */
    $user = \Illuminate\Support\Facades\Auth::user();
@endphp
@extends('layouts.auth')
@section('content')
    <div class="container-xxl p-5">
        <div>Xin chào {{$user->name}}, vui lòng chọn chi nhánh bạn đang quản lý</div>
        <div class="my-5">
            <div class="row g-4 h-100">
                @foreach($listViewModel->getCollectionItem() as $branch)
                    <div class="col-xl-4 col-lg-6 col-md-6 ">
                        <div data-href="{{url('/branch/access/'.$branch['id'])}}" class="card h-100 cursor-pointer">
                            <div class="card-header pb-2">
                                <div class="d-flex align-items-start">
                                    <div class="d-flex align-items-start">
                                        <div class="avatar me-3">
                                            <img src="{{asset($branch['logo'])}}" alt="Avatar"
                                                 class="rounded-circle">
                                        </div>
                                        <div class="me-2">
                                            <h5 class="mb-1"><a
                                                    class="stretched-link text-heading">{{$branch['name']}}</a>
                                            </h5>
                                            <div class="client-info text-body"><span
                                                    class="fw-medium">Mã chi nhánh:</span><span>  {{$branch['uuid']}}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ms-auto">
                                        <div class="dropdown zindex-2">
                                            <button type="button" class="btn dropdown-toggle hide-arrow p-0"
                                                    data-bs-toggle="dropdown" aria-expanded="false"><i
                                                    class="mdi mdi-dots-vertical mdi-24px text-muted"></i></button>
                                            <ul class="dropdown-menu dropdown-menu-end" style="">
                                                <li><a class="dropdown-item waves-effect" href="">Sửa chi nhánh</a>
                                                </li>
                                                <li>
                                                    <hr class="dropdown-divider">
                                                </li>
                                                <li><a class="dropdown-item text-danger waves-effect"
                                                       href="">Xoá chi nhánh</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="d-flex align-items-center flex-wrap">
                                    <div class="bg-lighter px-2 py-1 rounded-2 me-auto mb-3">
                                        <span class="text-body">Doanh thu</span>
                                        <p class="mb-1"><span class="fw-medium text-heading">{{number_format($branch['earned'])}} đ </span>
                                        </p>
                                    </div>
                                    <div class="text-end mb-3">
                                        <p class="mb-1"><span class="text-heading fw-medium">Ngày tạo: </span>
                                            <span> {{$branch['created']}} </span>
                                        </p>
                                        <p class="mb-1"><span class="text-heading fw-medium">Truy cập: </span>
                                            <span>{{$branch['last_active_time']}}</span></p>
                                    </div>
                                </div>
                                <p class="mb-0">{{$branch['description']}}</p>
                            </div>
                            <div class="card-body border-top">
                                <div class="d-flex align-items-center mb-3">
                                    <p class="mb-1"><span class="text-heading fw-medium">Số phút học: </span>
                                        <span>{{$branch['total_minutes']}}</span></p>
                                    <span class="badge bg-label-success ms-auto rounded-pill">{{$branch['total_studylog']}} buổi học</span>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 d-flex align-items-center mb-3">
                                        <ul class="list-unstyled d-flex align-items-center avatar-group mb-0 zindex-2">
                                            <li data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                                data-bs-placement="top"
                                                class="avatar avatar-sm pull-up me-2" aria-label="Julee Rossignol"
                                                data-bs-original-title="Julee Rossignol">
                                                <img class="rounded-circle"
                                                     src="../../demo/assets/img/avatars/6.png"
                                                     alt="Avatar">
                                            </li>
                                            <li><small class="text-muted">{{$branch['total_student']}} Học
                                                    sinh</small></li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6 d-flex align-items-center mb-3">
                                        <ul class="list-unstyled d-flex align-items-center avatar-group mb-0 zindex-2">
                                            <li data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                                data-bs-placement="top"
                                                class="avatar avatar-sm pull-up me-2" aria-label="Julee Rossignol"
                                                data-bs-original-title="Julee Rossignol">
                                                <img class="rounded-circle"
                                                     src="../../demo/assets/img/avatars/6.png"
                                                     alt="Avatar">
                                            </li>
                                            <li><small class="text-muted">{{$branch['total_teacher']}} Giáo
                                                    viên</small></li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6 d-flex align-items-center mb-3">
                                        <ul class="list-unstyled d-flex align-items-center avatar-group mb-0 zindex-2">
                                            <li data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                                data-bs-placement="top"
                                                class="avatar avatar-sm pull-up me-2" aria-label="Julee Rossignol"
                                                data-bs-original-title="Julee Rossignol">
                                                <img class="rounded-circle"
                                                     src="../../demo/assets/img/avatars/6.png"
                                                     alt="Avatar">
                                            </li>
                                            <li><small class="text-muted">{{$branch['total_supporter']}} Trợ
                                                    giảng</small></li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6 d-flex align-items-center mb-3">
                                        <ul class="list-unstyled d-flex align-items-center avatar-group mb-0 zindex-2">
                                            <li data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                                data-bs-placement="top"
                                                class="avatar avatar-sm pull-up me-2" aria-label="Julee Rossignol"
                                                data-bs-original-title="Julee Rossignol">
                                                <img class="rounded-circle"
                                                     src="../../demo/assets/img/avatars/6.png"
                                                     alt="Avatar">
                                            </li>
                                            <li><small class="text-muted">{{$branch['total_staff']}} Nhân
                                                    viên</small></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="col-xl-4 col-lg-6 col-md-6">
                    <div class="card h-100 d-flex justify-content-center align-items-center">
                        <a type="button" data-bs-toggle="modal" data-bs-target="#modalCenter" class="cursor-pointer">
                            <span class="mdi-48px mdi mdi-office-building-plus"></span>
                        </a>
                        <div>Thêm chi nhánh mới</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include("modal.create_branch",['crudBag' => $crudBag])
    <div class="content-backdrop fade"></div>
@endsection
@push('after_scripts')
    <script>
        $(".card").click((e) => {
            window.location.href = e.currentTarget.attributes['data-href'].value
        })
    </script>
@endpush
