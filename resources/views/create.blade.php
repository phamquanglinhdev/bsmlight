@php use App\Helper\CrudBag;use Illuminate\Support\Facades\Cache; @endphp
@php
    /**
     * @var CrudBag $crudBag
     */

@endphp
@extends('layouts.app')
@section("content")
    <div class="container-xxl flex-grow-1 container-p-y">

        <h4 class="py-3 mb-4">
            <span class="text-muted fw-light">{{$crudBag->getLabel()}} /</span>
            <span>{{$crudBag->getId()?"Chỉnh sửa":"Thêm mới"}}</span>
        </h4>
        <form action="{{route($crudBag->getAction(),$crudBag->getId())}}" method="POST"
            @if($crudBag->isHasFile())
                enctype="multipart/form-data"
            @endif
        >
            @csrf
            <div class="row">
                @foreach($crudBag->getFields() as $field)
                    <div class="{{$field->getClass() ?? "col-md-5 col-12"}}">
                        @include('fields.'.$field->getType(), ['field' => $field])
                    </div>
                @endforeach
            </div>

            <button type="submit" name="submitButton"
                    class="btn btn-primary waves-effect waves-light mt-4">{{$crudBag->getId()?"Chỉnh sửa":"Thêm mới"}}</button>
        </form>
    </div>
@endsection
@push("after_scripts")
    <link rel="stylesheet" href="{{asset('/demo/assets/vendor/libs/select2/select2.css')}}"/>
    <script src="{{asset('/demo/assets/vendor/libs/select2/select2.js')}}"></script>
    <link rel="stylesheet" href="{{asset('/demo/assets/vendor/libs/bootstrap-select/bootstrap-select.css')}}"/>
    <script src="{{asset('/demo/assets/vendor/libs/bootstrap-select/bootstrap-select.js')}}"></script>
    <script>
        $(".select2").select2();
        $(".selectpicker").selectpicker();
    </script>
    {{--    @if ($errors->any())--}}
    {{--        @foreach ($errors->all() as $error)--}}
    {{--            <script>--}}
    {{--                toastr.options = {--}}
    {{--                    closeButton: true,--}}
    {{--                    progressBar: true,--}}
    {{--                    positionClass: 'toast-top-right',--}}
    {{--                    timeOut: 2000--}}
    {{--                };--}}
    {{--                toastr.error('{{$error}}', 'Không thành công');--}}
    {{--            </script>--}}
    {{--        @endforeach--}}
    {{--    @endif--}}

@endpush
