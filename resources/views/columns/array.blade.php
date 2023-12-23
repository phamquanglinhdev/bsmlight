@php use App\Helper\Column; @endphp
@php
    /**
    * @var array $item
    * @var Column $column
    */
    $attributes = $column->getAttributes();
    $dataArrays = $item[$column->getName()];
    $randomBg = [
         'bg-secondary',
        'bg-primary',
        'bg-success',
        'bg-danger',
        'bg-warning',
        'bg-info',
];

@endphp

<td class="border text-center {{$column->getFixed() == 'first' ? 'fixed-left':''}}">
    <div class="small flex-column d-flex">
        @foreach($dataArrays as $data)
            <div class="text-start badge {{ $randomBg[$loop->iteration] }} mb-1">{{$data}}</div>
        @endforeach
   </div>
</td>
