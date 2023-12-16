@php use App\Helper\Column;use App\Helper\CrudBag; @endphp
@php
    /**
     * @var array $item
    * @var Column $column
     */

    $options = $item[$column->getName()] ?? [];
    $relationId = $column->getAttributes()['relation.id'];
    $relationLabel = $column->getAttributes()['relation.label'];
    $relationEntity = $column->getAttributes()['relation.entity'];
@endphp
<td class="border">
    @foreach($options as $option)
        <div class="small p-1">
            <a href="{{url($relationEntity."/show/".$option[$relationId])}}">{{$option[$relationLabel]}}</a>
        </div>
    @endforeach
</td>
