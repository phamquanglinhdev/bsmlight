@php
    if(\Illuminate\Support\Facades\Auth::check()){
        $layout = "layouts.app";

    }else{
        $layout = "layouts.auth";
    }
 @endphp
@extends($layout)

@section('content')
    <div class="misc-wrapper">
        <div class="d-flex justify-content-center mt-5">
            <div class="d-flex flex-column align-items-center">
                <h1 class="mb-2 mx-2" style="font-size: 6rem;">500</h1>
                <h4 class="mb-2">Đã xảy ra lỗi</h4>
                <p class="mb-2 mx-2">Vui lòng liên hệ admin để báo lỗi</p>
                <img src="{{asset("demo/assets/img/illustrations/404.png")}}" alt="misc-error"
                     class="misc-model img-fluid zindex-1" width="780">
                <div>
                    <a href="{{url('/')}}"
                       class="btn btn-primary text-center my-4">Về trang chủ</a>
                </div>
            </div>
        </div>
    </div>
@endsection
