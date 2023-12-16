@php use App\Helper\Column; @endphp
@php
    /**
    * @var array $item
    * @var Column $column
    */
@endphp
<td class="border">
    {{$item[$column->getName()]}}
</td>
