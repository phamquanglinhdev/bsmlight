@php
    /**
     * @var array $attributes
     */

@endphp

<div class="border p-2 rounded">
    @foreach($attributes as $key => $attribute)
        @switch($key)
            @case('card_log')
                <div class="fw-bold mb-1">Thay đổi thông tin học sinh tham gia lớp học: </div>
                @foreach($attribute as $cardKey => $card)
                    @if($card !== null)
                        <span class="bg-label-danger p-1 small rounded">Thẻ học {{\Illuminate\Support\Facades\Auth::user()->{'branch'} }}-StudyCard.{{$cardKey}}:</span>
                        @foreach($card as $item)
                            <div class="my-2">
                                <span class="bg-primary text-white p-1 small rounded">{{$item['name']}}</span>:
                                <span class="bg-secondary text-white p-1 small rounded">{{$item['old']}}</span>
                                =>
                                <span class="bg-primary text-white p-1 small rounded">{{$item['new']}}</span>
                            </div>
                        @endforeach
                    @endif
                @endforeach
            @break
            @case('working_shift')
                <div class="fw-bold mt-4 mb-1">Thay đổi thông tin ca học: </div>
                @foreach($attribute as $shiftKey => $shift)
                    @if($shift!==null)
                  <span class="bg-label-danger p-1 small rounded mb-2">Ca học {{$shiftKey}}:</span>
                        @foreach($shift as $item)
                            <div class="my-2">
                                <span class="bg-primary text-white p-1 small rounded">{{$item['name']}}</span>:
                                <span class="bg-secondary text-white p-1 small rounded">{{$item['old']}}</span>
                                =>
                                <span class="bg-primary text-white p-1 small rounded">{{$item['new']}}</span>
                            </div>
                        @endforeach
                    @endif
                @endforeach
            @break
            @default
            <div>{{$attribute['name']}}: {{$attribute['old']}} => {{$attribute['new']}}</div>
        @endswitch
    @endforeach
</div>
