@php use App\Helper\Column; @endphp
@php
    /**
    * @var array $item
    * @var Column $column
    */
    $attributes = $column->getAttributes();
@endphp

<td class="border text-center {{$column->getFixed() == 'first' ? 'fixed-left':''}}">
    @if(!empty($column->getAttributes()['bg']))
        <span
            class="text-white p-1 px-2 rounded-pill {{$column->getAttributes()['bg'][$item[$column->getName()]]??""}}">
             {{\Illuminate\Support\Carbon::make($item[$column->getName()])->isoFormat('DD/MM/YYYY')}}
        </span>
    @else
        {{\Illuminate\Support\Carbon::make($item[$column->getName()])->isoFormat('DD/MM/YYYY')}}
    @endif
    @if(isset($attributes['edit']))
        <a href="{{url($attributes['entity']."/edit/".$item['id'])}}">
            <span class="mdi mdi-square-edit-outline"></span>
        </a>
    @endif
    @if(isset($attributes['show']))
        <a href="{{url($attributes['entity']."/show/".$item['id'])}}">
            <span class="mdi mdi-list-box"></span>
        </a>
    @endif
    @if(isset($attributes['transaction']))
        <a href="{{url('transaction/create/'.$attributes['entity']."?".$attributes["entity"]."_id=".$item['id'])}}">
            <span class="mdi mdi-database-plus"></span>
        </a>
    @endif
</td>
