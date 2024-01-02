@php use App\Helper\Column; @endphp
@php
    /**
    * @var array $item
    * @var Column $column
    */

    $statisticData = $item[$column->getName()];

    $attributes = $column->getAttributes();
    $statisticsFields = $column->getAttributes()['statistics_fields'];
@endphp

<td class="border text-start {{$column->getFixed() == 'first' ? 'fixed-left':''}}">
    @foreach($statisticsFields as $field)
        <div class="small">
            <span class="me-1">{{$field['label']}}:</span>
            <span class="{{$field['color']}} fw-bold">
                {{$statisticData[$field['name']]}}
            </span>
        </div>
    @endforeach
</td>
