@php use App\Models\User; @endphp
@php
    /**
     * @var User $user
     */
@endphp
<div class="card mb-4 position-sticky">
    <div class="card-body">
        <div class="user-avatar-section">
            <div class=" d-flex align-items-center flex-column">
                <img class="img-fluid rounded mb-3 mt-4" src="{{$user->avatar}}" height="120" width="120" alt="User avatar">
                <div class="user-info text-center">
                    <h4>{{$user->name}}</h4>
                    <span class="badge bg-label-danger rounded-pill">Author</span>
                </div>
            </div>
        </div>
        <h5 class="pb-3 border-bottom mb-3"></h5>
        <div class="info-container">
            <ul class="list-unstyled mb-4">
                <li class="mb-3">
                    <span class="fw-medium text-heading me-2">Username:</span>
                    <span>{{$user->uuid}}</span>
                </li>
                <li class="mb-3">
                    <span class="fw-medium text-heading me-2">Email:</span>
                    <span>{{$user->email}}</span>
                </li>
            </ul>
            <div class="d-flex justify-content-center">
                <a href="{{route('logout')}}" class="btn btn-primary me-3 waves-effect waves-light">Đăng xuất</a>
            </div>
        </div>
    </div>
</div>

