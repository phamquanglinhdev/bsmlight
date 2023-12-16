@php use App\Helper\Column; @endphp
@php
    /**
    * @var array $item
    * @var Column $column
    */
@endphp
<td class="border text-center">
    <a target="_blank" href="{{$item[$column->getName()]}}">{{$item[$column->getName()]?"Mở":""}}</a>
</td>
