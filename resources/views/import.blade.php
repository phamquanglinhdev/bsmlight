@php use App\Helper\CrudBag; @endphp
@php
    /**
     * @var CrudBag $crudBag
     */
@endphp
@extends('layouts.app')
@section('content')
    <div class="container-xxl">
        <div class="h3 mt-4">
            Nhập {{$crudBag->getLabel()}} hàng loạt
        </div>
        <div class="row">
            <div class="col-md-5 col-10">
                <form method="POST" action="{{url('/import/store/'.$crudBag->getEntity())}}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-floating-outline form-floating">
                        <input name="file" class="form-control" type="file">
                        {{--                        <label>Nhập file excel</label>--}}
                    </div>

                    @foreach($errors->all() as $error)
                        <div class="text-danger small mt-3">{{ $error }}</div>
                    @endforeach
                    <button class="btn btn-primary mt-3">Bắt đầu tải lên</button>
                </form>


            </div>
            <div class="my-2 mt-4">
                <div class="fw-bold text-danger mb-2">Lưu ý khi import</div>
                <div class="text-danger mb-1">- Định dạng cột ngày tháng năm luôn là : Tháng-Ngày-Năm (VD : 01/17/2024), nhập sai định dạng có thể khiến thông tin ngày bị sai</div>
                <div class="text-danger mb-1">- Chưa hỗ trợ import danh sách trường dữ liệu tự nhập</div>
                <div class="text-danger mb-1">- Hỗ trợ import tối đa 500 hàng / lượt, quá số lượt sẽ không import được</div>
                <div class="text-danger mb-1">- Dữ liệu được ghim nếu để trống sẽ tự bỏ qua hàng ( trừ trường hợp import học sinh + thẻ học)</div>
            </div>
        </div>
    </div>
@endsection
