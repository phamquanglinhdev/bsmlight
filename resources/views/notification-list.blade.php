@php use App\Models\Notification; @endphp
@php
    /**
    * @var Notification[] $notifications
    */
@endphp
@foreach($notifications as $notification)
    <li class="list-group-item list-group-item-action dropdown-notifications-item">
       <a href="{{$notification->url}}">
           <div class="d-flex align-items-center gap-2">

               <div class="flex-shrink-0">
                   <div class="avatar me-1">
                       <img src="{{$notification->userAvatar()}}" alt
                            class="w-px-40 h-auto rounded-circle">
                   </div>
               </div>
               <div class="d-flex flex-column flex-grow-1 overflow-hidden w-px-250">
                   <h6 class="mb-1">{{$notification->title}}</h6>
                   <small class="text-truncate text-body">{{$notification->description}}</small>
               </div>
               <div class="flex-shrink-0 dropdown-notifications-actions">
                   <small class="text-muted">{{$notification->getDistanceTimeAttribute()}}</small>
               </div>
           </div>
       </a>
    </li>
@endforeach
