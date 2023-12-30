@extends("layouts.app")
@section('content')
    <div class="container-fluid ms-5 mt-4 p-2 me-5">
        <div class="mb-2 d-flex justify-content-end mb-2 p-2 py-3 bg-label-github rounded">
            <button class="btn btn-success small me-1">
                <span class="mdi mdi-check-circle me-1"></span>
                <span class="small">Xác nhận buổi học chính xác</span>
            </button>
            <button class="btn btn-success small me-1">
                <span class="mdi mdi-check-circle me-1"></span>
                <span class="small">Duyệt buổi học</span>
            </button>
            <button class="btn btn-danger small me-1">
                <span class="mdi mdi-cancel me-1"></span>
                <span class="small">Hủy buổi học</span>
            </button>
            <button class="btn btn-primary small">
                <span class="mdi mdi-check-circle me-1"></span>
                <span class="small">Gửi lên</span>
            </button>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="rounded p-2">
                    <div class="fw-bold">Buổi học ngày 12/11/2023</div>
                    <div class="fw-bold">Buổi học ngày 12/11/2023</div>
                </div>
            </div>
{{--            <div class="col-md-3">--}}
{{--               <div class="bg-label-github rounded small">--}}
{{--                   @include('studylog.component.timeline')--}}
{{--               </div>--}}
{{--            </div>--}}
            <div class="col-md-6">
                <div class="rounded small">
                    @include("studylog.component.comments")
                </div>
            </div>
        </div>
    </div>
@endsection
@p
