@php
    /**
     * @var \App\Models\User $user
 * @var \App\Helper\CrudBag $crudBag
 * @var \App\Helper\ListViewModel $listViewModel
     */
    $user = \Illuminate\Support\Facades\Auth::user();
@endphp
@extends('layouts.auth')
@section('content')
    <div class="d-flex justify-content-center align-items-center" style="height: 100vh">
        <form action="{{route($crudBag->getAction(),$crudBag->getId())}}" method="POST"
              @if($crudBag->isHasFile())enctype="multipart/form-data" @endif>
            @csrf
            <div class="mb-4">
                <a class="cursor-pointer" onclick="window.history.back()">
                    <span class="mdi mdi-arrow-left-circle"></span>
                    Quay lại
                </a>
            </div>
            <div class="modal-body">
                <div class="">
                    @foreach($crudBag->getFields() as $field)
                        @include('fields.'.$field->getType(),['field' => $field])
                    @endforeach
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary w-100">{{$crudBag->getId()?"Cập nhật":'Thêm mới'}}</button>
            </div>
        </form>
    </div>
@endsection
