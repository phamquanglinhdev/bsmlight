@php use App\Helper\CrudBag; @endphp
@php

    /**
     * @var CrudBag $crudBag
     */
@endphp
@extends('layouts.auth')
@section('content')
    <div class="position-relative">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner py-4">

                <div class="card p-2">
                    <!-- Logo -->
                    <div class="app-brand justify-content-center mt-5 mb-4">

                    </div>
                    <!-- /Logo -->
                    <!-- Reset Password -->
                    <div class="card-body">
                        <h4 class="mb-3">Đặt lại mật khẩu 🔒</h4>
                        <form id="formAuthentication" class="mb-3" action="{{url("/reset_password")}}" method="post">
                            @csrf
                            <input hidden="" name="token" value="{{$crudBag->getParam('token')}}">
                            <div class="mb-3 form-password-toggle">
                                <div class="input-group input-group-merge">
                                    <div class="form-floating form-floating-outline">
                                        <input type="password" id="password" class="form-control" name="password"
                                               placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                               aria-describedby="password"/>
                                        <label for="password">Mật khẩu mới</label>
                                    </div>
                                    <span class="input-group-text cursor-pointer"><i
                                            class="mdi mdi-eye-off-outline"></i></span>
                                </div>
                            </div>
                            <div class="mb-3 form-password-toggle">
                                <div class="input-group input-group-merge">
                                    <div class="form-floating form-floating-outline">
                                        <input type="password" id="confirm-password" class="form-control"
                                               name="password_confirmation"
                                               placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                               aria-describedby="password"/>
                                        <label for="confirm-password">Xác nhận mật khẩu</label>
                                    </div>
                                    <span class="input-group-text cursor-pointer"><i
                                            class="mdi mdi-eye-off-outline"></i></span>
                                </div>
                            </div>
                            <button class="btn btn-primary d-grid w-100 mb-3">
                                Đặt mật khẩu mới
                            </button>
                            <div class="text-center">
                                <a href="{{url("/login")}}" class="d-flex align-items-center justify-content-center">
                                    <i class="mdi mdi-chevron-left scaleX-n1-rtl mdi-24px"></i>
                                    Quay về đăng nhập
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /Reset Password -->

            </div>
        </div>
    </div>
@endsection
