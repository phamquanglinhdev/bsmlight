@php use App\Helper\Column; @endphp
@php
    /**
    * @var array $item
    * @var Column $column
    */
    $options = $column->getAttributes()['options'];

@endphp
<td class="border">
    {{$options[$item[$column->getName()]]}}
</td>
