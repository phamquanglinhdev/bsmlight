@extends("layouts.auth")
@section('content')

    <div class="position-relative">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner py-4">
                <div class="card p-2">
                    <div class="h3 fw-bold app-brand justify-content-center mt-5">
                        BSM
                    </div>
                    <div class="card-body mt-2">
                        <form id="formAuthentication" class="mb-3"
                              action="{{route('authentication')}}"
                              method="POST">
                            @csrf
                            <div class="form-floating form-floating-outline mb-3">
                                <input type="text" class="form-control" id="email" name="uuid"
                                       placeholder="BSM-CN.XXXX-AA.000X" autofocus>
                                <label for="email">Tên người dùng</label>
                            </div>
                            <div class="mb-3">
                                <div class="form-password-toggle">
                                    <div class="input-group input-group-merge">
                                        <div class="form-floating form-floating-outline">
                                            <input type="password" id="password" class="form-control" name="password"
                                                   placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                                   aria-describedby="password"/>
                                            <label for="password">Mật khẩu</label>
                                        </div>
                                        <span class="input-group-text cursor-pointer"><i
                                                class="mdi mdi-eye-off-outline"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 d-flex justify-content-between">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="remember-me">
                                    <label class="form-check-label" for="remember-me">
                                        Ghi nhớ đăng nhập
                                    </label>
                                </div>
                                <a href="{{url("/forgot_password")}}" class="float-end mb-1">
                                    <span>Quên mật khẩu?</span>
                                </a>
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-primary d-grid w-100" type="submit">Đăng nhập</button>
                            </div>
                        </form>

                        <div class="text-center">
                            <div>
                                <span>Bạn là người mới sử dụng nền tảng?</span>
                            </div>
                            <div><a href="{{url("/register")}}">
                                    <span>Tạo tài khoản</span>
                                </a></div>
                        </div>

                        {{--                        <div class="divider my-4">--}}
                        {{--                            <div class="divider-text">Hoặc đăng nhập với</div>--}}
                        {{--                        </div>--}}

                        {{--                        <div class="d-flex justify-content-center gap-2">--}}
                        {{--                            <a href="javascript:;" class="btn btn-icon btn-lg rounded-pill btn-text-facebook">--}}
                        {{--                                <i class="tf-icons mdi mdi-24px mdi-facebook"></i>--}}
                        {{--                            </a>--}}
                        {{--                            <a href="javascript:;" class="btn btn-icon btn-lg rounded-pill btn-text-google-plus">--}}
                        {{--                                <i class="tf-icons mdi mdi-24px mdi-google"></i>--}}
                        {{--                            </a>--}}
                        {{--                        </div>--}}
                    </div>
                </div>
                <!-- /Login -->
                <img src="{{asset("demo/assets/img/illustrations/tree-3.png")}}" alt="auth-tree"
                     class="authentication-image-object-left d-none d-lg-block">
                <img src="{{asset("demo/assets/img/illustrations/tree.png")}}" alt="auth-tree"
                     class="authentication-image-object-right d-none d-lg-block">
            </div>
        </div>
    </div>
@endsection
@push("after_scripts")
    @if(session('failed'))

    @endif
@endpush
