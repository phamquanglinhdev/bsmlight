@php
    use Illuminate\Support\Facades\Auth;
    $user = Auth::user();
@endphp
@extends('layouts.app')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-3 col-12">
                @include('dashboard_profile',['user' => $user])
            </div>
            <div class="col-md-9 col-12">
                @include('dashboard_post')
            </div>
        </div>
    </div>

    <div class="content-backdrop fade"></div>
@endsection
