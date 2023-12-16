@php use App\Helper\CrudBag; @endphp
@php
    /**
     * @var CrudBag $crudBag
     */
@endphp
@extends('layouts.app')
@section("content")
    <div class="container-xxl flex-grow-1 container-p-y">

        <h4 class="py-3 mb-4">
            <span class="text-muted fw-light">{{$crudBag->getLabel()}} /</span> Thêm mới
        </h4>
        <form action="{{route($crudBag->getAction())}}" method="POST">
            @csrf
            <div class="row">
                @foreach($crudBag->getFields() as $field)
                    <div class="{{$field->getClass() ?? "col-md-5 col-12"}}">
                        @include('fields.'.$field->getType(), ['field' => $field])
                    </div>
                @endforeach
            </div>

            <button type="submit" name="submitButton" class="btn btn-primary waves-effect waves-light">Thêm mới</button>
        </form>
    </div>
@endsection
