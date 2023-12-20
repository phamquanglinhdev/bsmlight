@php use App\Helper\Column; @endphp
@php
    /**
    * @var array $item
    * @var Column $column
    */
@endphp

<td class="border text-center {{$column->getFixed() == 'first' ? 'fixed-left':''}}">
    @if(!empty($column->getAttributes()['bg']))

        <span class="text-white p-1 px-2 rounded-pill {{$column->getAttributes()['bg'][$item[$column->getName()]]??""}}">
             {{number_format($item[$column->getName()])}}
        </span>
    @else
        {{number_format($item[$column->getName()])}}
    @endif
</td>
