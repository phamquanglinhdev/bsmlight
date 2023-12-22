@php use App\Helper\Column; @endphp
@php
    /**
    * @var array $item
    * @var Column $column
    */
    $options = $column->getAttributes()['options'];
@endphp
<td class="border text-center dark-style {{$column->getFixed() == 'first' ? 'fixed-left':''}}">
   <span class="{{$column->getAttributes()['bg'][$item[$column->getName()]]}} text-white p-1 px-3 rounded-pill">
       {{$options[$item[$column->getName()]] ?? $item[$column->getName()]}}
   </span>
</td>
