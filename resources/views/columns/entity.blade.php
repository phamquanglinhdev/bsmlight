@php use App\Helper\Column; @endphp
@php
    /**
    * @var array $item
    * @var Column $column
    */
    $avatar = $column->getAttributes()['avatar'];
    $name = $column->getAttributes()['name'];
    $uuid = $column->getAttributes()['uuid'];
    $id = $column->getAttributes()['id'];
    $entity = $column->getAttributes()['entity'];
    $model = $column->getAttributes()['model'];

    $data = $item[$entity];

@endphp


<td class="border {{$column->getFixed() == 'first' ? 'fixed-left':''}}">
    <div class="d-flex align-items-center">
        @if($data)
            <img style="width: 2rem;height: 2rem" class="rounded-circle d-block me-2"
                 src="{{$data[$avatar]??"https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQS0Oi53Y0SYUnNZ6FDFALWjbzr2siFFZqRAI_ygcnbVunsa0Ywsn1u1xGx7FisdgzGdcQ&usqp=CAU"}}">
            <div>
                <div class="mb-1">
                    {{$data[$name]}}
                    @if(check_permission('edit '.$model))
                        <a href="{{url($model."/edit/".$data[$id])}}">
                            <span class="mdi mdi-square-edit-outline"></span>
                        </a>
                    @endif
                </div>
                <div class="small">{{$data[$uuid]}}</div>
            </div>
        @else
            ---
        @endif
    </div>

</td>
