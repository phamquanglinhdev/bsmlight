@php use App\Helper\Column; @endphp
@php
    /**
    * @var array $item
    * @var Column $column
    */
@endphp

<td class="border text-center {{$column->getFixed() == 'first' ? 'fixed-left':''}}">
    {{$item[$column->getName()]}}
</td>
