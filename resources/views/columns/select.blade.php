@php use App\Helper\Column; @endphp
@php
    /**
    * @var array $item
    * @var Column $column
    */
    $options = $column->getAttributes()['options'];

@endphp
<td class="border text-center dark-style {{$column->getFixed() == 'first' ? 'fixed-left':''}}">
   <span class="{{$item[$column->getName()] == 1 ?"bg-success":"bg-danger"}} text-white p-1 rounded-pill">
        {{$options[$item[$column->getName()]]}}
   </span>
</td>
