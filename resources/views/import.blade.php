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
        </div>
    </div>
@endsection
