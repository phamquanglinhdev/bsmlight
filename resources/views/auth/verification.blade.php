@php use Illuminate\Support\Facades\Auth; @endphp
@php
    $user = Auth::user()
@endphp
@extends("layouts.auth")
@section("content")
    <div class="positive-relative">
        <div class="authentication-wrapper authentication-basic">
            <div class="authentication-inner py-4">

                <!--  Two Steps Verification -->
                <div class="card p-2">
                    <!-- Logo -->
                    <div class="app-brand justify-content-center mt-5">
                        <a href=""
                           class="app-brand-link gap-2">
                            <span class="app-brand-text demo text-heading fw-semibold">BSM</span>
                        </a>
                    </div>
                    <!-- /Logo -->
                    <div class="card-body">
                        <h4 class="mb-2 text-center">Xác minh tài khoản của bản</h4>
                        @if($user->email)
                            <p class="text-start mb-4 text-center">
                                Chúng tôi đã gửi mã xác nhận đến <b>{{$user->email}}</b><br> vui lòng nhập mã xác nhận

                            </p>
                            <form id="twoStepsForm"
                                  action="{{url('/verify')}}"
                                  method="POST">
                                @csrf
                                <div class="mb-3">
                                    <div
                                        class="auth-input-wrapper d-flex align-items-center justify-content-sm-between numeral-mask-wrapper">
                                        <div class="d-flex justify-content-center align-items-center w-100">
                                            <input maxlength="6" minlength="6" name="verified_code" placeholder="Nhập mã xác minh"
                                                   type="text" class="w-50 text-center form-control p-2 mx-1 my-2"
                                                   autofocus required>
                                        </div>
                                    </div>
                                    <!-- Create a hidden field which is combined by 3 fields above -->
                                    <input type="hidden" name="otp"/>
                                </div>
                                <button class="btn btn-primary d-grid w-100 mb-3">
                                    Xác minh tài khoản
                                </button>
                                <div class="text-center">Bạn không nhận được mã ?
                                    <a href="javascript:void(0);">
                                        Gửi lại
                                    </a>
                                </div>
                            </form>
                        @else
                            <form id="twoStepsForm"
                                  action="{{url('/update_email')}}"
                                  method="POST">
                                @csrf
                                <div class="mb-3">
                                    <div class="d-flex align-items-center justify-content-sm-between">
                                        <input name="email" placeholder="Nhập email để xác minh tài khoản" type="email"
                                               class="form-control mx-1 my-2"
                                               autofocus>
                                    </div>
                                </div>
                                <button class="btn btn-primary d-grid w-100 mb-3">
                                    Gửi mã xác nhận
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
                <!-- / Two Steps Verification -->
                <img src="{{asset("demo/assets/img/illustrations/tree-3.png")}}" alt="auth-tree"
                     class="authentication-image-object-left d-none d-lg-block">
                <img src="{{asset('demo/assets/img/illustrations/tree.png')}}" alt="auth-tree"
                     class="authentication-image-object-right d-none d-lg-block">
            </div>
        </div>
    </div>
@endsection
