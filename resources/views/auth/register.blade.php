@extends("layouts.auth")
@section("content")
    <div class="position-relative">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner py-4">
                <!-- Register Card -->
                <div class="card p-2">
                    <!-- Logo -->
                    <div class="app-brand justify-content-center mt-5">

                    </div>
                    <!-- /Logo -->
                    <div class="card-body mt-2">
                        <h4 class="mb-5">
                            Cuộc phiêu lưu bắt đầu từ đây 🚀</h4>
                        <form id="formAuthentication" class="mb-3" action="{{route('register')}}" method="POST">
                            @csrf
                            <div class="form-floating form-floating-outline mb-3">
                                <input type="text" class="form-control" id="name" name="name"
                                       placeholder="Nguyễn Văn A" autofocus>
                                <label for="username">Tên của bạn</label>
                            </div>
                            <div class="form-floating form-floating-outline mb-3">
                                <input type="text" class="form-control" id="username" name="uuid" placeholder="Username"
                                       autofocus>
                                <label for="username">Tên người dùng</label>
                            </div>
                            <div class="form-floating form-floating-outline mb-3">
                                <input type="text" class="form-control" id="email" name="email"
                                       placeholder="example@bsm.com">
                                <label for="email">Email</label>
                            </div>
                            <div class="mb-3 form-password-toggle">
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
                            <div class="mb-3 form-password-toggle">
                                <div class="input-group input-group-merge">
                                    <div class="form-floating form-floating-outline">
                                        <input type="password" id="password_confirmation" class="form-control"
                                               name="password_confirmation"
                                               placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                               aria-describedby="password"/>
                                        <label for="password">Xác nhận lại mật khẩu</label>
                                    </div>
                                    <span class="input-group-text cursor-pointer"><i
                                            class="mdi mdi-eye-off-outline"></i></span>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="terms-conditions" name="terms">
                                    <label class="form-check-label" for="terms-conditions">
                                        Tôi đồng ý với
                                        <a href="javascript:void(0);">điều khoản và dịch vụ của BSM</a>
                                    </label>
                                </div>
                            </div>
                            <button class="btn btn-primary d-grid w-100">
                               Đăng ký
                            </button>
                        </form>

                        <p class="text-center">
                            <span>Bạn đã có tài khoản</span>
                            <a href="{{url("/login")}}">
                                <span>Đăng nhập</span>
                            </a>
                        </p>

                        {{--                        <div class="divider my-4">--}}
                        {{--                            <div class="divider-text">or</div>--}}
                        {{--                        </div>--}}

                        {{--                        <div class="d-flex justify-content-center gap-2">--}}
                        {{--                            <a href="javascript:;" class="btn btn-icon btn-lg rounded-pill btn-text-facebook">--}}
                        {{--                                <i class="tf-icons mdi mdi-24px mdi-facebook"></i>--}}
                        {{--                            </a>--}}

                        {{--                            <a href="javascript:;" class="btn btn-icon btn-lg rounded-pill btn-text-twitter">--}}
                        {{--                                <i class="tf-icons mdi mdi-24px mdi-twitter"></i>--}}
                        {{--                            </a>--}}

                        {{--                            <a href="javascript:;" class="btn btn-icon btn-lg rounded-pill btn-text-github">--}}
                        {{--                                <i class="tf-icons mdi mdi-24px mdi-github"></i>--}}
                        {{--                            </a>--}}

                        {{--                            <a href="javascript:;" class="btn btn-icon btn-lg rounded-pill btn-text-google-plus">--}}
                        {{--                                <i class="tf-icons mdi mdi-24px mdi-google"></i>--}}
                        {{--                            </a>--}}
                        {{--                        </div>--}}
                    </div>
                </div>
                <!-- Register Card -->
                <img src="{{asset("demo/assets/img/illustrations/tree-3.png")}}" alt="auth-tree"
                     class="authentication-image-object-left d-none d-lg-block">
                <img src="{{asset("/demo/assets/img/illustrations/tree.png")}}" alt="auth-tree"
                     class="authentication-image-object-right d-none d-lg-block">
            </div>
        </div>
    </div>
@endsection
