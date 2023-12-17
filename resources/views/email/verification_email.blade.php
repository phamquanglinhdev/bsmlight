@php use App\Models\User; @endphp
@php
    /**
* @var User $user
 */
@endphp
<p>Xin chào, {{ $user->name }}, mã xác minh BSM của bạn là {{$user->verified_code}}</p>
