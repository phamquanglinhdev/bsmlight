@extends('layouts.auth')

@section('content')
    <div class="position-relative">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner py-4">

                <!-- Forgot Password -->
                <div class="card p-2">
                    <!-- Logo -->
                    <div class="app-brand justify-content-center mt-5">
                    </div>
                    <!-- /Logo -->
                    <div class="card-body mt-2">
                        <h4 class="mb-2">Quên mật khẩu 🔒</h4>
                        <p class="mb-4">Nhập tên đăng nhập và email của bạn để lấy lại mật khẩu</p>
                        <form id="" class="mb-3" action="{{url('/forgot-password')}}" method="POST">
                            @csrf
                            <div class="form-floating form-floating-outline mb-3">
                                <input type="text" required class="form-control" id="uuid" name="uuid"
                                       placeholder="Nhập tên người dùng" autofocus>
                                <label>Tên người dùng</label>
                            </div>
                            <div class="form-floating form-floating-outline mb-3">
                                <input required type="email" class="form-control" id="email" name="email"
                                       placeholder="Nhập email" autofocus>
                                <label>Email</label>
                            </div>
                            <button class="btn btn-primary d-grid w-100">Gửi link lấy lại mật khẩu</button>
                        </form>
                        <div class="text-center">
                            <a href="{{url('/login')}}" class="d-flex align-items-center justify-content-center">
                                <i class="mdi mdi-chevron-left scaleX-n1-rtl mdi-24px"></i>
                                Quay về đăng nhập
                            </a>
                        </div>
                    </div>
                </div>
                <!-- /Forgot Password -->
                <img src="{{asset("demo/assets/img/illustrations/tree-3.png")}}" alt="auth-tree"
                     class="authentication-image-object-left d-none d-lg-block">
                <img src="{{asset("demo/assets/img/illustrations/tree.png")}}" alt="auth-tree"
                     class="authentication-image-object-right d-none d-lg-block">
            </div>
        </div>
    </div>
@endsection
